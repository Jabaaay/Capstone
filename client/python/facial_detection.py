from flask import Flask, Response, request, jsonify
from flask_cors import CORS
from ultralytics import YOLO
import cv2
import json
import time

app = Flask(__name__)
CORS(app)

# Load the model
model = YOLO("best.pt")
cap = None
is_detecting = False
expressions = []

def gen_frames():
    global cap, is_detecting, expressions
    while is_detecting:
        success, frame = cap.read()
        if not success:
            break
        else:
            # Run YOLO detection on the frame
            results = model(frame, verbose=False)
            
            # Process results and store expressions
            for result in results[0].boxes:
                cls = int(result.cls[0])
                conf = float(result.conf[0])
                emotion = model.names[cls]
                
                expressions.append({
                    'emotion': emotion,
                    'confidence': conf,
                    'timestamp': time.strftime('%Y-%m-%d %H:%M:%S')
                })

            # Annotate the frame with detection results
            annotated_frame = results[0].plot()

            # Encode as JPEG
            ret, buffer = cv2.imencode('.jpg', annotated_frame)
            if not ret:
                continue
            frame = buffer.tobytes()

            # Yield the frame in byte format for streaming
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

@app.route('/video_feed')
def video_feed():
    return Response(gen_frames(),
                    mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/start', methods=['POST'])
def start():
    global cap, is_detecting
    cap = cv2.VideoCapture(0)
    is_detecting = True
    return jsonify({"status": "success", "message": "Detection started"})

@app.route('/stop', methods=['POST'])
def stop():
    global cap, is_detecting, expressions
    is_detecting = False
    if cap is not None:
        cap.release()
    result = expressions.copy()
    expressions = []
    return jsonify(result)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True) 