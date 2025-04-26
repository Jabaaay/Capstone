<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .value {
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f5f5f5;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Psychological Test Results</h1>
        <p>Generated on: {{ now()->format('F j, Y g:i A') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Personal Information</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Name:</span>
                <span class="value">{{ $test->first_name }} {{ $test->last_name }}</span>
            </div>
            <div class="info-item">
                <span class="label">College:</span>
                <span class="value">{{ $test->college }}</span>
            </div>
            <div class="info-item">
                <span class="label">Course:</span>
                <span class="value">{{ $test->course }}</span>
            </div>
            <div class="info-item">
                <span class="label">Age:</span>
                <span class="value">{{ $test->age }}</span>
            </div>
            <div class="info-item">
                <span class="label">Contact Number:</span>
                <span class="value">{{ $test->contact_number }}</span>
            </div>
            <div class="info-item">
                <span class="label">Sex:</span>
                <span class="value">{{ ucfirst($test->sex) }}</span>
            </div>
            <div class="info-item">
                <span class="label">Email:</span>
                <span class="value">{{ $test->email }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Test Results</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Total Score:</span>
                <span class="value">{{ $test->total_score }}</span>
            </div>
            <div class="info-item">
                <span class="label">Depression Level:</span>
                <span class="value">{{ $test->depression_level }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Question Responses</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Response</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                    @php
                        $answer = $test->answers->where('question_id', $question['id'])->first();
                        $selectedOption = collect($question['options'])->firstWhere('value', $answer->answer);
                    @endphp
                    <tr>
                        <td>{{ $question['text'] }}</td>
                        <td>{{ $selectedOption['text'] }}</td>
                        <td>{{ $answer->answer }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Interpretation Guide</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">1-10:</span>
                <span class="value">These ups and downs are considered normal</span>
            </div>
            <div class="info-item">
                <span class="label">11-16:</span>
                <span class="value">Mild mood disturbance</span>
            </div>
            <div class="info-item">
                <span class="label">17-20:</span>
                <span class="value">Borderline clinical depression</span>
            </div>
            <div class="info-item">
                <span class="label">21-30:</span>
                <span class="value">Moderate depression</span>
            </div>
            <div class="info-item">
                <span class="label">31-40:</span>
                <span class="value">Severe depression</span>
            </div>
            <div class="info-item">
                <span class="label">Over 40:</span>
                <span class="value">Extreme depression</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This is an official document generated by the Psychological Test System</p>
        <p>© {{ date('Y') }} All rights reserved</p>
    </div>
</body>
</html> 