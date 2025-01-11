<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="max-w-5xl mx-auto mt-10">
        <div class="flex flex-col my-10 shadow-md md:flex-row">
            <!-- Left Section (Shopping Cart Items) -->
            <div class="w-full p-6 bg-white md:w-3/4">
                <h1 class="mb-4 text-2xl font-bold">Shopping Cart</h1>
                <!-- Cart Item -->
                <div class="flex items-center pb-4 mb-4 border-b">
                    <img src="https://via.placeholder.com/100" alt="Product Image" class="w-24 h-24 rounded-lg">
                    <div class="flex-1 ml-4">
                        <p class="text-lg font-semibold">Frisco Heart Print Dog & Cat Bandana, X-Large/XX-Large</p>
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
                <button class="w-full px-4 py-2 mt-6 text-white bg-blue-500 rounded-lg hover:bg-blue-700">
                    Proceed to Checkout
                </button>
            </div>
        </div>


    </div>
</body>
</html>
