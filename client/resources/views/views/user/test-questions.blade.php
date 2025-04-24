<!DOCTYPE html>
<html lang="en">

<head>
    // ... existing code ...
    
    <style>
        // ... existing code ...
        
        .video-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 320px;
            height: 240px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        
        .video-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body id="page-top">
    // ... existing code ...
    
    <!-- Add video container for facial detection -->
    <div class="video-container">
        <img id="video-feed" src="http://localhost:5000/video_feed" alt="Facial Expression Detection">
    </div>
    
    // ... existing code ...
    
    <script>
        $(document).ready(function() {
            // ... existing code ...
            
            // Function to stop the video feed
            function stopVideoFeed() {
                const videoFeed = document.getElementById('video-feed');
                if (videoFeed) {
                    // Remove the src to stop the video feed
                    videoFeed.src = '';
                    // Hide the container
                    videoFeed.parentElement.style.display = 'none';
                }
            }
            
            // Function to check if the Flask server is running
            function checkFlaskServer() {
                fetch('http://localhost:5000/video_feed')
                    .then(response => {
                        if (!response.ok) {
                            console.error('Flask server is not running');
                            Swal.fire({
                                title: 'Warning',
                                text: 'Facial expression detection is not available. Please make sure the detection server is running.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error connecting to Flask server:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Could not connect to facial expression detection server. Please make sure it is running.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            }
            
            // Check Flask server when page loads
            checkFlaskServer();
            
            // Modify the form submission to stop the video feed
            $('#test-form').on('submit', function(e) {
                e.preventDefault();
                
                // Check if all questions are answered
                const unansweredQuestions = [];
                $('.question-card').each(function() {
                    const questionNum = $(this).data('question');
                    const isAnswered = $(this).find('input[type="radio"]:checked').length > 0;
                    if (!isAnswered) {
                        unansweredQuestions.push(questionNum);
                    }
                });

                if (unansweredQuestions.length > 0) {
                    Swal.fire({
                        title: 'Incomplete Answers',
                        text: 'Please answer all questions before submitting.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Show confirmation dialog
                Swal.fire({
                    title: 'Submit Test',
                    text: 'Are you sure you want to submit your answers?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit',
                    cancelButtonText: 'No, review answers'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Stop the video feed before submitting
                        stopVideoFeed();
                        
                        // Submit the form
                        $.ajax({
                            url: $(this).attr('action'),
                            method: 'POST',
                            data: $(this).serialize(),
                            success: function(response) {
                                Swal.fire({
                                    title: 'Test Submitted!',
                                    text: 'Thank you for completing the test. Your results will be analyzed.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "{{ route('user.dashboard') }}";
                                    }
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'There was an error submitting your test. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
            
            // ... rest of your existing code ...
        });
    </script>
</body>
</html> 