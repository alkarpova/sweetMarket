<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
<h1>Your Order Has Been Created</h1>
<p>Order Number: {{ $order->number }}</p>
<p>Total: {{ $order->total }}</p>
<p>Thank you for shopping with us!</p>
</body>
</html>
