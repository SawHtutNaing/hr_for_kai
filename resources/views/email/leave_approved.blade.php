<!DOCTYPE html>
<html>
<head>
    <title>Leave Request Approved</title>
</head>
<body>
    <h1>Leave Request Approved</h1>
    <p>Dear {{ $user->name }},</p>
    <p>Your leave request has been approved with the following details:</p>
    <ul>
        <li>Start Date: {{ $start_date }}</li>
        <li>End Date: {{ $end_date }}</li>
        <li>Reason: {{ $reason }}</li>
    </ul>
    <p>Best regards,</p>
    <p>Myanmar Tech Solutions</p>
</body>
</html>
