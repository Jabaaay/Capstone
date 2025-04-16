@extends('layouts.app')

<div class="max-w-2xl mx-auto p-6">
    <form action="{{ route('user.test.submit') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" id="first_name" name="first_name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" id="last_name" name="last_name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>

        <div>
            <label for="college" class="block text-sm font-medium text-gray-700">College</label>
            <select id="college" name="college" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Select College</option>
                <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                <option value="College of Business Administration">College of Business Administration</option>
                <option value="College of Education">College of Education</option>
                <option value="College of Engineering">College of Engineering</option>
                <option value="College of Nursing">College of Nursing</option>
            </select>
        </div>

        <div>
            <label for="course" class="block text-sm font-medium text-gray-700">Course</label>
            <select id="course" name="course" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Select Course</option>
                <option value="Bachelor of Science in Computer Science">Bachelor of Science in Computer Science</option>
                <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                <option value="Bachelor of Science in Psychology">Bachelor of Science in Psychology</option>
                <option value="Bachelor of Science in Nursing">Bachelor of Science in Nursing</option>
                <option value="Bachelor of Science in Business Administration">Bachelor of Science in Business Administration</option>
            </select>
        </div>

        <div>
            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
            <input type="number" id="age" name="age" required min="18" max="100"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input type="tel" id="contact_number" name="contact_number" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Sex</label>
            <div class="mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="sex" value="male" required
                        class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="ml-2">Male</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="sex" value="female" required
                        class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="ml-2">Female</span>
                </label>
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="border p-4 rounded-md">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Terms and Conditions</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p><strong>1. Data Collection:</strong> Your face and voice will be recorded for analysis.</p>
                <p><strong>2. Privacy:</strong> Your data will be kept confidential and used only for research purposes.</p>
                <p><strong>3. Voluntary Participation:</strong> You can withdraw anytime before the analysis starts.</p>
                <p><strong>4. Security:</strong> All stored data is encrypted and protected.</p>
                <p>By proceeding, you agree to these terms.</p>
            </div>
            <div class="mt-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="terms_accepted" required
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="ml-2">I agree to the terms and conditions</span>
                </label>
            </div>
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Proceed to Test
            </button>
        </div>
    </form>
</div>
