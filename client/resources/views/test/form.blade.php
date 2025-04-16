@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="border-4 border-dashed border-gray-200 rounded-lg p-4">
            <!-- Video Feed Section -->
            <div class="mb-8">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Facial Detection</h2>
                <div class="relative">
                    <img id="videoFeed" src="http://localhost:5000/video_feed" alt="Video Feed" class="w-full h-auto rounded-lg">
                    <div id="emotion-display" class="absolute bottom-4 left-4 bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg">Waiting to start...</div>
                </div>
                <div id="detection-error" class="mt-2 text-red-600 hidden"></div>
            </div>

            <form id="testForm" method="POST" action="{{ route('test.store') }}" class="space-y-8">
                @csrf
                
                <!-- Personal Information Section -->
                <div class="space-y-6">
                    <h2 class="text-lg font-medium text-gray-900">Personal Information</h2>
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" id="first_name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-3">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" id="last_name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-3">
                            <label for="college" class="block text-sm font-medium text-gray-700">College</label>
                            <input type="text" name="college" id="college" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-3">
                            <label for="course" class="block text-sm font-medium text-gray-700">Course</label>
                            <input type="text" name="course" id="course" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                            <input type="number" name="age" id="age" required min="1" max="120"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="tel" name="contact_number" id="contact_number" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
                            <select name="sex" id="sex" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Depression Assessment Questions -->
                <div class="space-y-6">
                    <h2 class="text-lg font-medium text-gray-900">Depression Assessment</h2>
                    
                    <div class="space-y-4">
                        @foreach($questions as $question)
                        <div class="bg-white shadow rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-900 mb-2">{{ $question->question_text }}</p>
                            <div class="flex space-x-4">
                                @foreach(['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day'] as $value => $label)
                                <label class="inline-flex items-center">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $value }}" required
                                        class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Hidden input for facial expressions -->
                <input type="hidden" name="facial_expressions" id="facial_expressions">

                <div class="flex justify-end">
                    <button type="submit" id="submitButton"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Submit Test
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/facial-detection.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoFeed = document.getElementById('videoFeed');
    const errorDisplay = document.getElementById('detection-error');
    
    // Check if video feed is accessible
    videoFeed.onerror = function() {
        errorDisplay.textContent = 'Error: Could not connect to video feed. Please make sure the Python server is running.';
        errorDisplay.classList.remove('hidden');
    };
    
    // Start facial detection when page loads
    try {
        window.facialDetection.startDetection();
    } catch (error) {
        errorDisplay.textContent = 'Error starting facial detection: ' + error.message;
        errorDisplay.classList.remove('hidden');
    }

    // Handle form submission
    document.getElementById('testForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.textContent = 'Processing...';

        try {
            // Stop facial detection and get expressions
            const expressions = await window.facialDetection.stopDetection();
            
            // Set the facial expressions in the hidden input
            document.getElementById('facial_expressions').value = JSON.stringify(expressions);
            
            // Submit the form
            this.submit();
        } catch (error) {
            console.error('Error during form submission:', error);
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Test';
            alert('An error occurred while processing your test. Please try again.');
        }
    });
});
</script>
@endpush
@endsection 