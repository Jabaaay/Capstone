window.facialDetection = {
    isDetecting: false,
    expressions: [],
    videoElement: null,
    emotionDisplay: null,
    detectionInterval: null,

    startDetection: function() {
        try {
            this.videoElement = document.getElementById('videoFeed');
            this.emotionDisplay = document.getElementById('emotion-display');
            
            if (!this.videoElement) {
                throw new Error('Video element not found');
            }
            
            this.isDetecting = true;
            this.expressions = [];
            this.updateEmotionDisplay('Starting detection...');
            
            // Start collecting expressions
            this.startExpressionCollection();
            
            console.log('Facial detection started successfully');
        } catch (error) {
            console.error('Error starting facial detection:', error);
            this.updateEmotionDisplay('Error starting detection');
        }
    },

    stopDetection: function() {
        try {
            this.isDetecting = false;
            if (this.detectionInterval) {
                clearInterval(this.detectionInterval);
                this.detectionInterval = null;
            }
            this.updateEmotionDisplay('Detection stopped');
            return Promise.resolve(this.expressions);
        } catch (error) {
            console.error('Error stopping detection:', error);
            return Promise.reject(error);
        }
    },

    updateEmotionDisplay: function(emotion) {
        if (this.emotionDisplay) {
            this.emotionDisplay.textContent = emotion;
        }
    },

    startExpressionCollection: function() {
        // Clear any existing interval
        if (this.detectionInterval) {
            clearInterval(this.detectionInterval);
        }

        // Function to collect expressions periodically
        this.detectionInterval = setInterval(() => {
            if (!this.isDetecting) return;

            // Get current timestamp
            const timestamp = new Date().toISOString();
            
            // Get current emotion from the video feed
            // This is a placeholder - in a real implementation, you would get this from your Python backend
            const currentEmotion = 'neutral'; // Replace with actual emotion from backend
            
            // Add to expressions array
            this.expressions.push({
                timestamp,
                emotion: currentEmotion
            });

            // Update display
            this.updateEmotionDisplay(`Current emotion: ${currentEmotion}`);
        }, 1000); // Collect every second
    }
}; 