<!DOCTYPE html>
<html>

<head>
    <title>Student Result</title>
    <style>
        /* CSS styles for better formatting */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Add more styles as needed */
    </style>
</head>

<body>
    <h1>Student Results</h1>

    <table>
        <tr>
            <th>Student Name</th>
            <td>{{ $student->name }}</td>
        </tr>
        <tr>
            <th>Roll Number</th>
            <td>{{ $student->roll_no }}</td>
        </tr>
        <tr>
            <th>Class</th>
            <td>{{ $student->class }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $student->gender }}</td>
        </tr>
        <tr>
            <th>Guardian Name</th>
            <td>{{ $student->guardian_name }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $student->city }}, {{ $student->state }}, {{ $student->pincode }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Subject</th>
            <th>Marks</th>
        </tr>
        @foreach (['maths', 'science', 'hindi', 'english', 'social_science', 'computer', 'arts'] as $subject)
            <tr>
                <td>{{ ucfirst($subject) }}</td>
                <td>{{ $student->result[$subject] }}</td>
            </tr>
        @endforeach
        <tr>
            <td><strong>Total</strong></td>
            <td><strong>{{ $student->result['total'] }}</strong></td>
        </tr>
        <tr>
            <td><strong>Percentage</strong></td>
            <td><strong>{{ $student->result['percentage'] }}%</strong></td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td><strong>{{ $student->result['status'] }}</strong></td>
        </tr>
    </table>
</body>

</html>
