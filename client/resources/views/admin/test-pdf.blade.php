<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Results - Admin Report</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
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
            color: #2c3e50;
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
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 3px;
        }
        .status-normal {
            color: #27ae60;
        }
        .status-mild {
            color: #f39c12;
        }
        .status-moderate {
            color: #e67e22;
        }
        .status-severe {
            color: #c0392b;
        }
        .status-extreme {
            color: #7b241c;
        }
    </style>
</head>
<body>
    <div class="header">

    

        <h1>Psychological Test Results - Admin Report</h1>
        <p>Generated on: {{ $test->created_at->timezone('Asia/Manila')->format('F j, Y g:i A') }}</p>
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
            <div class="info-item">
                <span class="label">Test Date:</span>
                <span class="value">{{ $test->created_at->timezone('Asia/Manila')->format('F j, Y g:i A') }}</span>
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
                <span class="value status status-{{ strtolower(str_replace(' ', '-', $test->depression_level)) }}">
                    {{ $test->depression_level }}
                </span>
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