<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Booking Confirmation</h2>
        <p>Hello, {{ $booking->user->first_name }} {{ $booking->user->last_name }}</p>

        <p>Your booking has been confirmed. Here are the details:</p>

        <ul>
            <li><img src="{{ asset('storage/uploads/'. $booking->room->images->first()->image_path) }}" alt="{{ $booking->room->type }}"></li>
            <li><strong>Room:</strong> {{ $booking->room->description }}</li>
            <li><strong>Date:</strong> {{ $booking->check_in }} - {{ $booking->check_out }} ,  {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }}  Night(s)

            </li>
            <li><strong>Rooms:</strong> {{ $booking->room_count }}</li>
            <li><strong>Persons:</strong> {{ $booking->adult_count }} Adults, {{ $booking->child_count }} Child</li>
            <li><strong>Extra Bed:</strong> {{$booking->extra_bed}}</li>
            <li><strong>Total Price:</strong> {{ $booking->net_amount }}</li>
        </ul>

        <p>Thank you for booking with us!</p>

        <p>Best regards,<br>
            Travancore Court</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Book Myticket. All rights reserved.
    </div>
</body>
</html>
