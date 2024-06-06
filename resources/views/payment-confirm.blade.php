<!DOCTYPE html>
<html>
<head>
    <title>Confirm Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>Confirm Payment</h1>
    <form id="payment-form" action="{{ route('payment.success') }}" method="POST">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        <button id="rzp-button1" class="btn btn-primary">Pay with Razorpay</button>
    </form>
</div>
<script>
    var options = {
        "key": "{{ $razorpayKey }}", // Enter the Key ID generated from the Dashboard
        "amount": "50000", // Amount in paise
        "currency": "INR",
        "name": "Acme Corp", // Your business name
        "description": "Test Transaction",
        "image": "https://example.com/your_logo",
        "order_id": "{{ $orderId }}", // This is the order ID created in the controller
        "callback_url": "{{ route('payment.success') }}",
        "prefill": { // Prefill customer information
            "name": "{{ Auth::user()->name }}", // Customer's name
            "email": "{{ Auth::user()->email }}",
            "contact": "9000090000" // Customer's contact number
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        },
        "method": {
            "upi": true,  // Enable UPI
            "qr": true    // Enable QR code
        }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
</script>
</body>
</html>
