@extends('layouts.app')


<div class="max-w-2xl mx-auto p-6">
    <form action="{{ route('user.test.answers') }}" method="POST" class="space-y-6">
        @csrf
        @foreach($questions as $question)
        <div class="border p-4 rounded-md">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Question {{ $question['id'] }}</h3>
            <p class="text-gray-600 mb-4">{{ $question['text'] }}</p>
            <div class="space-y-2">
                @foreach($question['options'] as $option)
                <label class="block">
                    <input type="radio" name="answers[{{ $question['id'] }}]" value="{{ $option['value'] }}" required
                        class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="ml-2">{{ $option['text'] }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit Answers
            </button>
        </div>
    </form>
</div>
