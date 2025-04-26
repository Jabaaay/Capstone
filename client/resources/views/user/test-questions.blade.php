<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Psychological Test - Questions</title>

    <!-- Custom fonts for this template-->
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">


<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
    .test-container {
        display: flex;
        gap: 20px;
        padding: 20px;
    }
    .progress-sidebar {
        width: 25%;
        flex-shrink: 0;
    }
    .questions-content {
        width: 85%;
        flex-grow: 1;
    }
    .progress-numbers {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }
    .question-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
        background-color: #f8f9fc;
        transition: all 0.3s ease;
    }
    .question-link:hover {
        background-color: #e3e6f0;
    }
    .question-options {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
    }
    .option-label {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 4px;
        background-color: #f8f9fc;
        transition: all 0.3s ease;
    }
    .option-label:hover {
        background-color: #e3e6f0;
    }
    .option-label input[type="radio"] {
        margin-right: 15px;
        width: 18px;
        height: 18px;
    }
    .option-label span {
        font-size: 18px;
    }
    .video-container {
       
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

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->

                
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="test-container">
                        <!-- Progress Sidebar -->
                        <div class="progress-sidebar">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Progress</h6>
                                </div>
                                <div class="card-body">
                                    <div class="progress-numbers">
                                        @for($i = 1; $i <= count($questions); $i++)
                                            <a href="#" class="question-link" data-question="{{ $i }}">
                                                {{ $i }}
                                            </a>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Question Content -->
                        <div class="questions-content">
                            <!-- Instructions Card -->
                            <div class="card mb-4 py-3 border-left-primary">
                                <div class="card-body" style="font-size: 20px;">
                                    <b>Instructions:</b> This questionnaire consists of 21 groups of statements. 
                                    Please read each group carefully. Then, select the one statement from each group that best describes how you have
                                    been feeling over the past two weeks, including today.
                                </div>
                            </div>

                            <form action="{{ route('user.test.answers') }}" method="POST" id="test-form">
                                @csrf
                                @foreach($questions as $index => $question)
                                <div class="question-card card shadow mb-4" data-question="{{ $index + 1 }}" 
                                     style="display: {{ $index === 0 ? 'block' : 'none' }}">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary" style="font-size: 24px;">
                                            Question {{ $index + 1 }}
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-gray-600 mb-4" style="font-size: 20px;">{{ $question['text'] }}</p>
                                        <div class="question-options">
                                            @foreach($question['options'] as $option)
                                            <label class="option-label">
                                                <input type="radio" name="answers[{{ $question['id'] }}]" 
                                                       value="{{ $option['value'] }}" required>
                                                <span>{{ $option['text'] }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="d-flex justify-content-between mb-4">
                                    <button type="button" class="btn btn-secondary" id="prev-btn" style="display: none;">
                                        Previous
                                    </button>
                                    <button type="button" class="btn btn-primary" id="next-btn">
                                        Next
                                    </button>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success" id="submit-btn" style="display: none;">
                                        Submit Answers
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   <!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        let currentQuestion = 1;
        const totalQuestions = {{ count($questions) }};
        const answeredQuestions = new Set();

        // Function to update progress indicators
        function updateProgress() {
            $('.question-link').each(function() {
                const questionNum = $(this).data('question');
                if (answeredQuestions.has(questionNum)) {
                    $(this).css('background-color', '#1cc88a');
                    $(this).css('color', 'white');
                } else {
                    $(this).css('background-color', '#f8f9fc');
                    $(this).css('color', '#333');
                }
            });
        }

        // Function to show a specific question
        function showQuestion(questionNum) {
            $('.question-card').hide();
            $(`.question-card[data-question="${questionNum}"]`).show();
            
            // Update navigation buttons
            $('#prev-btn').toggle(questionNum > 1);
            $('#next-btn').toggle(questionNum < totalQuestions);
            $('#submit-btn').toggle(questionNum === totalQuestions);
            
            currentQuestion = questionNum;
        }

        // Handle radio button changes
        $('input[type="radio"]').change(function() {
            const questionCard = $(this).closest('.question-card');
            const questionNum = questionCard.data('question');
            answeredQuestions.add(questionNum);
            updateProgress();
        });

        // Handle question link clicks
        $('.question-link').click(function(e) {
            e.preventDefault();
            const questionNum = $(this).data('question');
            showQuestion(questionNum);
        });

        // Handle navigation buttons
        $('#prev-btn').click(function() {
            showQuestion(currentQuestion - 1);
        });

        $('#next-btn').click(function() {
            showQuestion(currentQuestion + 1);
        });

        // Handle form submission
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

        // Initialize
        showQuestion(1);
        updateProgress();
    });
</script>

<!-- Add video container for facial detection -->
<div class="video-container" style="display: none;">

    <img id="video-feed" src="http://localhost:5000/video_feed" alt="Facial Expression Detection">
</div>

</body>

</html>
