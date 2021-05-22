<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Package Booking Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        @page {
            margin: 0;
            padding: ;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
        }
        .invoice {

        }

        .invoice-header {
            background: #08a0e9;
            color: rgb(255, 255, 255);
            height: 70px;
            padding: 10px 50px;
            text-align: center;
        }

        .invoice-header.header-success {
            background: #0ac50a;
        }

        .invoice-header.header-danger {
            background: #c5360a;
        }

        .invoice-body {
            padding: 30px;
        }

        .invoice-footer {

        }

        .mt-15 {
            margin-top: 15px;
        }

        .mt-30 {
            margin-top: 30px;
        }

        hr {
            border-bottom: 1px solid gray;
            margin-bottom: 5px;
        }

        #footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 15px 0px;
            background: rgb(199, 199, 199);
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header {{ $booking->status == 'approved' ? 'header-success' : '' }} {{ $booking->status == 'cancelled' ? 'header-danger' : '' }}">
            <h2>Booking No: {{ $booking->booking_no }}</h2>
        </div>
        <div class="invoice-body">
            <div class="booking-guest">
                <strong>Guest Information</strong><hr>
                <h3>{{ $booking->guest->name }}</h3>
                <p>{{ $booking->guest->phone }}</p>
                <p>{{ $booking->guest->address }}</p>
            </div>

            <div class="booking-package-content mt-15">
                <strong>Package Information</strong><hr>
                <p><strong>Package: </strong> {{ $booking->package()->name }}</p>
                <p><strong>From Date:</strong> {{ user_formatted_date($booking->assignPackage->check_in) }}</p>
                <p><strong>To Date:</strong> {{ user_formatted_date($booking->assignPackage->check_in) }}</p>
            </div>

            <div class="booking-content mt-15">
                <strong>Booking Information</strong><hr>
                <p><strong>Issue Date: </strong>{{ user_formatted_datetime($booking->created_at) }}</p>
                <p><strong>Members: </strong>{{ $booking->member }}</p>
                <p><strong>Price (Per Unit): </strong>{{ $booking->price }}</p>
                <p><strong>Total Price: </strong>{{ $booking->total_price }}</p>
                <p><strong>Status: </strong>{{ $booking->status }}</p>
            </div>

            <div class="booking-warning mt-30">
                <p><strong>N.B: </strong>Please visit <a href="https://vromonbilash.com/invoice/track">https://vromonbilash.com/invoice/track</a> to get update about your package</p>
            </div>
        </div>
        <div class="invoice-footer" id="footer">
            <p>Vromonbilash.com</p>
        </div>
    </div>
</body>
</html>
