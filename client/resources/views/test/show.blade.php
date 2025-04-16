@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Test Results</h1>

            <!-- Personal Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium">{{ $test->first_name }} {{ $test->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">College</p>
                        <p class="font-medium">{{ $test->college }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Course</p>
                        <p class="font-medium">{{ $test->course }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Age</p>
                        <p class="font-medium">{{ $test->age }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <p class="font-medium">{{ $test->contact_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Sex</p>
                        <p class="font-medium">{{ ucfirst($test->sex) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $test->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Test Results -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Test Results</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Total Score</p>
                        <p class="font-medium">{{ $test->total_score }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Depression Level</p>
                        <p class="font-medium">{{ $test->depression_level }}</p>
                    </div>
                </div>
            </div>

            <!-- Facial Expression Analysis -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Facial Expression Analysis</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Emotion
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Confidence
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Timestamp
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($test->facialExpressions as $expression)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ ucfirst($expression->emotion) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($expression->confidence * 100, 2) }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $expression->timestamp->format('Y-m-d H:i:s') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Question Responses -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Question Responses</h2>
                <div class="space-y-4">
                    @foreach($questions as $question)
                    <div class="border rounded-lg p-4">
                        <p class="text-lg font-medium mb-2">{{ $question['text'] }}</p>
                        @php
                            $answer = $test->answers->where('question_id', $question['id'])->first();
                            $selectedOption = collect($question['options'])->firstWhere('value', $answer->answer);
                        @endphp
                        <p class="text-gray-600">Response: {{ $selectedOption['text'] }}</p>
                        <p class="text-gray-600">Score: {{ $answer->answer }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 