@extends('layouts.app')

<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Test Results</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total Score</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $totalScore }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Depression Level</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $depressionLevel }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="mt-6">
        <h4 class="text-lg font-medium text-gray-900 mb-4">Interpretation Guide</h4>
        <div class="space-y-2 text-sm text-gray-600">
            <p><strong>1-10:</strong> These ups and downs are considered normal</p>
            <p><strong>11-16:</strong> Mild mood disturbance</p>
            <p><strong>17-20:</strong> Borderline clinical depression</p>
            <p><strong>21-30:</strong> Moderate depression</p>
            <p><strong>31-40:</strong> Severe depression</p>
            <p><strong>Over 40:</strong> Extreme depression</p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('user.dashboard') }}"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Return to Dashboard
        </a>
    </div>
</div>
