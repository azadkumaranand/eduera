<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <button id="rzp-button1">Pay</button>

    <script>
        // Fetch order ID from the Laravel backend
        fetch('{{ route('payment.createOrder') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(order => {
            var options = {
                "key": "{{ env('RAZORPAY_KEY') }}", // Enter the Key ID generated from the Dashboard
                "amount": 500, // Amount is in currency subunits
                "currency": order.currency,
                "name": "Acme Corp", // Your business name
                "description": "Test Transaction",
                "image": "https://example.com/your_logo",
                "order_id": order.id, // This is the order ID created in the server
                "callback_url": "{{ route('payment.success') }}",
                "prefill": { // Prefill customer information
                    "name": "{{ Auth::user()->name }}", // Your customer's name
                    "email": "{{ Auth::user()->email }}",
                    "contact": "9000090000" // Provide the customer's phone number for better conversion rates 
                },
                "notes": {
                    "address": "Razorpay Corporate Office"
                },
                "theme": {
                    "color": "#3399cc"
                },
                "config": {
                    "display": {
                        "blocks": {
                            "banks": {
                                "name": "Most Used Methods",
                                "instruments": [
                                    {
                                        "method": "wallet",
                                        "wallets": ["freecharge"]
                                    },
                                    {
                                        "method": "upi"
                                    }
                                ]
                            }
                        },
                        "sequence": ["block.banks"],
                        "preferences": {
                            "show_default_blocks": true
                        }
                    }
                }
            };
            var rzp1 = new Razorpay(options);
            document.getElementById('rzp-button1').onclick = function(e){
                rzp1.open();
                e.preventDefault();
            }
        })
        .catch(error => {
            console.error('Error fetching order ID:', error);
        });
    </script>
</body>
</html>
