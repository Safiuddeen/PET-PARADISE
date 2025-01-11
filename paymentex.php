<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-6 text-2xl font-bold text-center">Payment Gateway</h2>
        
        <form action="#" method="POST" class="space-y-4">
            <!-- Cardholder Name -->
            <div>
                <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Cardholder Name</label>
                <input type="text" id="name" name="name" placeholder="John Doe" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Card Number -->
            <div>
                <label for="cardNumber" class="block mb-1 text-sm font-medium text-gray-700">Card Number</label>
                <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" 
                    maxlength="19" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Expiry Date -->
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="expiryDate" class="block mb-1 text-sm font-medium text-gray-700">Expiry Date</label>
                    <input type="month" id="expiryDate" name="expiryDate" placeholder="MM/YY" 
                        maxlength="5" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- CVV -->
                <div class="w-1/2">
                    <label for="cvv" class="block mb-1 text-sm font-medium text-gray-700">CVV</label>
                    <input type="password" id="cvv" name="cvv" placeholder="123" 
                        maxlength="3" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="block mb-1 text-sm font-medium text-gray-700">Amount</label>
                <input type="text" id="amount" name="amount" placeholder="Enter Amount (e.g., 1000)" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full px-6 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Pay Now
            </button>
        </form>
    </div>

</body>
</html>
