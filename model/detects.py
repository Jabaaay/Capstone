# yolo_stream.py (Python - Flask + YOLO)
from flask import Flask, Response, request
from ultralytics import YOLO
import cv2
import requests
import json
import time
from datetime import datetime

app = Flask(__name__)
model = YOLO("best.pt")
cap = cv2.VideoCapture(0)

# Store expressions buffer
expressions_buffer = []
last_detection_time = 0  # Track the last detection time
last_detection_results = None  # Store the last detection results
current_test_id = None  # Store the current test ID
current_user_id = None  # Store the current user ID

def send_expression_to_laravel(expression, confidence):
    if not current_test_id or not current_user_id:
        print("❌ No test ID or user ID available. Please start a test first.")
        return False, "No test ID or user ID available"

    timestamp = datetime.now().isoformat()
    expression_data = {
        'expression': expression,
        'confidence': confidence,
        'test_id': current_test_id,
        'user_id': current_user_id
    }
    try:
        print("\n=== Sending Data to Laravel ===")
        print(f"Data being sent: {json.dumps(expression_data, indent=2)}")
        
        # Send the expression data to Laravel backend
        response = requests.post('http://localhost:8000/api/facial-expressions', json=expression_data)
        response_data = response.json()
        
        print(f"Response status code: {response.status_code}")
        print(f"Response data: {json.dumps(response_data, indent=2)}")
        print("=============================\n")
        
        if response.status_code == 200:
            return True, response_data.get('message', 'Expression stored successfully')
        else:
            error_message = response_data.get('message', 'Failed to store expression')
            return False, error_message
    except Exception as e:
        error_message = f"Error sending expression to Laravel: {str(e)}"
        print(error_message)
        return False, error_message

@app.route('/get_expressions', methods=['GET'])
def get_expressions():
    return json.dumps(expressions_buffer)

@app.route('/set_test_info', methods=['POST'])
def set_test_info():
    global current_test_id, current_user_id
    data = request.get_json()
    if 'test_id' in data and 'user_id' in data:
        current_test_id = data['test_id']
        current_user_id = data['user_id']
        print(f"✅ Test ID set to: {current_test_id}")
        print(f"✅ User ID set to: {current_user_id}")
        return {'status': 'success', 'message': f'Test ID and User ID set successfully'}
    return {'status': 'error', 'message': 'No test ID or user ID provided'}, 400

def gen_frames():
    global last_detection_time
    while True:
        success, frame = cap.read()
        if not success:
            break
        else:
            current_time = time.time()
            # Only perform detection if 2 seconds have passed since last detection
            if current_time - last_detection_time >= 4:
                results = model(frame)
                annotated_frame = results[0].plot()
                
                # Get the detected expression and confidence
                if len(results) > 0 and len(results[0].boxes) > 0:
                    expression = results[0].names[int(results[0].boxes[0].cls[0])]
                    confidence = float(results[0].boxes[0].conf[0])
                    
                    # Print detection details
                    print("\n=== Detection Details ===")
                    print(f"Expression: {expression}")
                    print(f"Confidence: {confidence:.2f}")
                    print("=====================\n")
                    
                    # Store the expression data
                    success, message = send_expression_to_laravel(expression, confidence)
                    if success:
                        print(f"✅ {message}")
                    else:
                        print(f"❌ {message}")
                
                last_detection_time = current_time
            else:
                # If not time for detection, just show the frame without detection
                annotated_frame = frame
            
            ret, buffer = cv2.imencode('.jpg', annotated_frame)
            frame = buffer.tobytes()
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

# start video
@app.route('/start_video', methods=['POST'])
def start_video():
    global cap
    cap = cv2.VideoCapture(0)
    return {'status': 'success'}

@app.route('/video_feed')
def video_feed():
    return Response(gen_frames(),
                    mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == '__main__':
    app.run(debug=True, port=5000)
    
