@vite('resources/scss/app.scss')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Thank you for your order!</h1>
        @if($order)
            <p>Order Number: {{ $order->id }}</p>
            <p>Status: {{ $order->status }}</p>
            <p>Total Price: ${{ $order->total_price }}</p>
            <p>We’ll send you a confirmation email shortly.</p>
        @else
            <p>We couldn't find your order details. Please contact support.</p>
        @endif
        <a href="{{ url('/') }}">Go back to Home</a>
    </div>
</body>
</html>
