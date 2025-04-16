let video = null;
let canvas = null;
let ctx = null;
let isDetecting = false;
let expressions = [];

async function startDetection() {
    try {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        ctx = canvas.getContext('2d');

        // Start video stream
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        video.play();

        // Start Python detection
        const response = await fetch('http://localhost:5000/start', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Failed to start detection');
        }

        isDetecting = true;
        console.log('Detection started successfully');
    } catch (error) {
        console.error('Error starting detection:', error);
        alert('Failed to start facial detection. Please make sure the Python server is running.');
    }
}

async function stopDetection() {
    try {
        if (!isDetecting) {
            return [];
        }

        // Stop Python detection and get results
        const response = await fetch('http://localhost:5000/stop', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Failed to stop detection');
        }

        const data = await response.json();
        isDetecting = false;
        return data;
    } catch (error) {
        console.error('Error stopping detection:', error);
        return [];
    }
}

// Export functions for use in other files
window.facialDetection = {
    startDetection,
    stopDetection
}; 