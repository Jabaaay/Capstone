# yolo_stream.py (Python - Flask + YOLO)
from flask import Flask, Response, request
from ultralytics import YOLO
import cv2
import requests
import json

app = Flask(__name__)
model = YOLO("best.pt")
cap = cv2.VideoCapture(0)

# Store the current test ID
current_test_id = None

@app.route('/set_test_id', methods=['POST'])
def set_test_id():
    global current_test_id
    data = request.get_json()
    current_test_id = data.get('test_id')
    return {'status': 'success'}

def send_expression_to_laravel(expression, confidence):
    if current_test_id:
        try:
            # Send the expression data to Laravel using web route
            response = requests.post(
                'http://localhost:8000/store-expression',
                json={
                    'test_id': current_test_id,
                    'expression': expression,
                    'confidence': confidence
                },
                headers={
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'  # You'll need to pass this from Laravel
                }
            )
            return response.json()
        except Exception as e:
            print(f"Error sending expression data: {e}")
    return None

def gen_frames():
    while True:
        success, frame = cap.read()
        if not success:
            break
        else:
            results = model(frame)
            annotated_frame = results[0].plot()
            
            # Get the detected expression and confidence
            if len(results) > 0 and len(results[0].boxes) > 0:
                expression = results[0].names[int(results[0].boxes[0].cls[0])]
                confidence = float(results[0].boxes[0].conf[0])
                
                # Send the expression data to Laravel
                send_expression_to_laravel(expression, confidence)
            
            ret, buffer = cv2.imencode('.jpg', annotated_frame)
            frame = buffer.tobytes()
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

@app.route('/video_feed')
def video_feed():
    return Response(gen_frames(),
                    mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == '__main__':
    app.run(debug=True)
    
