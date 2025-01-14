<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-200 ">
    <!-- Navbar -->
    <nav class="bg-white">
    <ul class="flex flex-wrap items-center justify-between w-full p-4">
        <!-- Logo -->
        <li class="flex-shrink-0 mr-4">
            <a href="index.php">
                <img src="image/PARADISE2.png" alt="logo" class="h-16 w-28 sm:h-20 sm:w-36">
            </a>
        </li>

        <!-- Para -->
        <li class="flex-grow text-center">
            <!-- Display as smaller text on small screens -->
            <p class="hidden text-xs font-medium text-gray-700 sm:text-lg sm:block">
            Your journey isn't complete yet! Secure your order now and let us take care of the rest. See you soon!
            </p>

            <!-- Display as two lines for smaller screens -->
            <p class="text-xs font-medium text-gray-700 sm:hidden">
            Your journey isn't complete yet!
            </p>
            <p class="text-xs font-medium text-gray-700 sm:hidden">
            Secure your order now — See you soon!!
            </p>
        </li>

        <!-- Help Icon -->
        <li class="mr-4">
            <button onclick="window.location.href='help.php'" class="focus:outline-none">
                <img src="image/massege.png" alt="help" class="w-10 h-10 sm:w-12 sm:h-12">
            </button>
        </li>
    </ul>
</nav>
       
        <div class="flex items-center justify-center min-h-screen">
            <div class="w-full max-w-md p-6 mt-5 mb-5 bg-white rounded-lg shadow-md">
                <h2 class="mb-6 text-2xl font-bold text-center">Payment Gateway</h2>
                
                <form action="#" method="POST" class="space-y-4">
                    <!-- Cardholder Name -->
                    <div>
                        <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Cardholder Name</label>
                        <input type="text" id="name" name="name" placeholder="holder name" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Card Number -->
                    <div class="relative">
                    <label for="cardNumber" class="block mb-1 text-sm font-medium text-gray-700">Card Number</label>
                    <div class="relative">
                        <!-- Input field -->
                        <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456"  maxlength="19" class="w-full px-4 py-2 pr-20 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <img src="image/icons/visacard.png"  alt="Visa Card" class="absolute w-8 h-8 transform -translate-y-1/2 top-1/2 right-12 mr-0.5">
                        <img src="image/icons/mastercard.png" alt="MasterCard" class="absolute w-8 h-8 transform -translate-y-1/2 top-1/2 right-4">
                    </div>
                </div>

                    <!-- Expiry Date and CVV -->
                    <div class="flex space-x-4">
                        <div class="w-1/2">
                            <label for="expiryDate" class="block mb-1 text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="month" id="expiryDate" name="expiryDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="w-1/2">
                            <label for="cvv" class="block mb-1 text-sm font-medium text-gray-700">CVV</label>
                            <input type="password" id="cvv" name="cvv" placeholder="123" maxlength="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block mb-1 text-sm font-medium text-gray-700">Amount</label>
                        <input type="text" id="amount" name="amount" placeholder="00000.00/=" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full px-6 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Pay Now
                    </button>
                </form>
            </div>
        </div>
        <!-- main page footer -->
        <footer class="py-4 mt-6 text-sm text-center text-white bg-slate-700">
                    <p>We're here 24/7</p>
                    <a href="#" class="pr-4 text-white hover:underline">1-800-672-4399 </a> Or 
                    <a href="#" class="pl-4 text-white hover:underline">Email Us</a>
            </footer>
            <footer class="py-4 text-sm text-center bg-white text-slate-900">
                    <p>Sri Lanka</p>
                    <p>© 2024 Paradise Inc. All rights reserved.</p>
                    <a href="#" class=" text-blue-950 hover:underline">Privacy Policy</a> | 
                    <a href="#" class="text-blue-950 hover:underline">Terms of Service</a>
            </footer>

</body>
</html>
