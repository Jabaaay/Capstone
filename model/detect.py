from flask import Flask, Response
from ultralytics import YOLO
import cv2

app = Flask(__name__)
model = YOLO("best.pt")  # Make sure your best.pt is trained or fine-tuned for your use case

# Use 0 for webcam, or change to IP camera/video file if needed
cap = cv2.VideoCapture(0)

def gen_frames():
    while True:
        success, frame = cap.read()
        if not success:
            break
        else:
            # Run YOLO detection on the frame
            results = model(frame, verbose=False)
            
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

@app.route('/')
def index():
    # Simple HTML page to show the video stream
    return '''
    <html>
        <head>
            <title>YOLOv8 Real-time Detection</title>
        </head>
        <body>
            <h1>Live YOLOv8 Stream</h1>
            <img src="/video_feed" width="800">
        </body>
    </html>
    '''

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
