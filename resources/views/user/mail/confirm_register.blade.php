<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Confirmation</title>
</head>
<body>
    <h2>Registration Confirmation</h2>
    <p>Hello, {{ $user->first_name }}{{ $user->first_name }}</p>

    <p>Your registration was successful. Welcome to our platform!</p>

    <p>You can now log in to your account and start exploring.</p>

    <p>Best regards,<br>
    Travancore Court</p>
</body>
</html>
