<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Psychological Test System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        {{-- Optional: Add custom styles if needed --}}
        <style>
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            }
            /* Basic styling for the SVG columns to somewhat mimic the original */
            .content-column {
                 background-color: var(--bs-body-bg);
                 color: var(--bs-body-color);
                 border: 1px solid var(--bs-border-color);
            }
             .visual-column {
                 background-color: #fff2f2; /* Light pinkish background */
                 border: 1px solid var(--bs-border-color);
                 display: flex;
                 align-items: center;
                 justify-content: center;
                 overflow: hidden; /* Prevent SVG overflow */
                 min-height: 300px; /* Ensure some height */
             }
             [data-bs-theme="dark"] .visual-column {
                background-color: #1D0002; /* Dark reddish background */
             }
             .laravel-logo-svg path {
                 fill: #F53003; /* Original red color */
             }
              [data-bs-theme="dark"] .laravel-logo-svg path {
                 fill: #F61500; /* Dark mode red color */
             }
             /* Ensure SVG scales reasonably */
             .visual-column svg {
                 max-width: 80%;
                 height: auto;
             }
             /* Adjust link colors */
              a.link-danger {
                 color: #f53003 !important;
                 text-decoration: underline !important;
             }
             [data-bs-theme="dark"] a.link-danger {
                 color: #FF4433 !important;
             }

             /* Mimic original spacing slightly */
             .main-content-row {
                min-height: 70vh; /* Ensure it takes significant height */
             }

        </style>
    </head>
    <body class="d-flex flex-column p-3 min-vh-100 ">

    <header>
        <nav>
            <div class="container-fluid">
                <img src="{{ asset('images/buksu-black.png') }}" alt="Buksu Logo" style="width: 50px; height: 50px;">
                <a class="navbar-brand" href="">Buksu Guidance</a>
            </div>
        </nav>
    </header>

        

        <div class="container-fluid container-lg d-flex flex-grow-1 align-items-center justify-content-center">
            <main class="row w-100 main-content-row">
                {{-- Content Column --}}
                <div class="col-lg-7 p-4 p-lg-5 d-flex flex-column justify-content-center rounded-start-lg rounded-bottom">
                    <h1 class="mb-2 fw-medium display-5">Buksu Guidance Psychological Test System</h1>
                    <p class="mb-3 text-secondary">
                    A Depression Detection System is a diagnostic tool that analyzes facial expressions, and behavioral cues to detect signs of depression. Using YOLOv8 for facial recognition, it provides real-time assessments, helping professionals identify at-risk individuals for early intervention and mental health support.
                    </p>
                    <p class="mb-4">Key Features:</p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2">
                             <span class="badge bg-primary rounded-pill me-2">&check;</span>
                             Confidential and Secure Testing
                        </li>
                         <li class="d-flex align-items-center mb-2">
                             <span class="badge bg-primary rounded-pill me-2">&check;</span>
                             Variety of Psychological Assessments
                        </li>
                        <li class="d-flex align-items-center mb-2">
                             <span class="badge bg-primary rounded-pill me-2">&check;</span>
                             User-friendly Interface
                        </li>
                    </ul>

                     {{-- Action Buttons --}}
                    <div>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary">Register Now</a>
                            <a href="{{ route('login') }}" class="btn btn-secondary ms-2">Log In</a>
                        @endauth
                    </div>
                </div>

                {{-- Visual Column --}}
                <div class="col-lg-5 p-3  rounded-end-lg rounded-top order-first order-lg-last">
                    {{-- Keep Laravel Logo or replace with your own SVG/Image --}}
                    <img src="{{ asset('images/guidance.jpg') }}" alt="Psychological Test System Logo" class="w-100 h-100">
                </div>
            </main>
        </div>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
