<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-200">
    <!-- Navbar -->
    <nav class="bg-white">
    <ul class="flex flex-wrap items-center justify-between w-full p-4">
        <!-- Logo -->
        <li class="flex-shrink-0 mr-4">
            <a href="index.php">
                <img src="image/PARADISE2.png" alt="logo" class="h-16 w-28 sm:h-20 sm:w-36">
            </a>
        </li>

        <!-- Quote Bar -->
        <li class="flex-grow text-center">
            <!-- Display as smaller text on small screens -->
            <p class="hidden text-xs font-medium text-gray-700 sm:text-lg sm:block">
                Your cart is ready to roll! Don't wait too long—your favorites are just a click away from being yours!
            </p>

            <!-- Display as two lines for smaller screens -->
            <p class="text-xs font-medium text-gray-700 sm:hidden">
                Your cart is ready to roll!
            </p>
            <p class="text-xs font-medium text-gray-700 sm:hidden">
                Don't wait too long—click away!
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


    <div class="max-w-5xl mx-auto mt-10">
        <div class="flex flex-col my-10 shadow-md md:flex-row">
            <!-- Left Section (Shopping Cart Items) -->
            <div class="w-full p-6 bg-white md:w-3/4">
                <h1 class="mb-4 text-2xl font-bold">Shopping Cart</h1>
                <!-- Cart Item -->
                <div class="flex items-center pb-4 mb-4 border-b">
                    <img src="https://via.placeholder.com/100" alt="Product Image" class="w-24 h-24 rounded-lg">
                    <div class="flex-1 ml-4">
                        <p class="text-lg font-semibold">item name</p>
                        <p class="font-bold text-red-500">$6.99</p>
                    </div>
                    <div class="flex flex-col items-center space-y-2">
                        <!-- Quantity Dropdown -->
                        <label for="qty" class="text-sm font-medium">Qty:</label>
                        <select id="qty" name="qty" class="px-3 py-1 border rounded-lg">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        <!-- Remove Button -->
                        <button class="flex items-center text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="ml-1">Remove</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Section (Summary) -->
            <div class="w-full p-6 md:w-1/4 bg-gray-50">
                <h2 class="text-lg font-semibold">Item Subtotal:</h2>
                <div class="text-2xl font-bold text-gray-900">$6.99</div>
                <button onclick="window.location.href='paymentex.php'"  class="w-full px-4 py-2 mt-6 text-white bg-blue-500 rounded-lg hover:bg-blue-700">
                    Proceed to Checkout
                </button>
            </div>
        </div>


    </div>
    <br><br><br>

    <!-- main page footer -->
    <footer class="py-4 mt-6 text-sm text-center text-white bg-slate-700">
                    <p>We're here 24/7</p>
                    <a href="terms_policy.php" class="pr-4 text-white hover:underline">1-800-672-4399 </a> Or 
                    <a href="terms_policy.php" class="pl-4 text-white hover:underline">Email Us</a>
            </footer>
            <footer class="py-4 text-sm text-center bg-white text-slate-900">
                    <p>Sri Lanka</p>
                    <p>© 2024 Paradise Inc. All rights reserved.</p>
                    <a href="terms_policy.php" class=" text-blue-950 hover:underline">Privacy Policy</a> | 
                    <a href="terms_policy.php" class="text-blue-950 hover:underline">Terms of Service</a>
            </footer>
</body>
</html>
