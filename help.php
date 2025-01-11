<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="image/PARADISE.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Pet-Paradise</title>
</head>
<body class="bg-indigo-200 ">

<!-- Navbar -->
<nav class="flex items-center justify-between w-full p-4 bg-white">
    <ul class="flex items-center w-full">
        <!-- Logo -->
        <li class="mr-4">
            <a href="index.php">
                <img src="image/PARADISE2.png" alt="logo" class="h-20 w-36">
            </a>
        </li>

        <!-- Search Bar -->
        <li class="flex-grow pl-6">
            <input type="text" placeholder="Search..." class="w-2/4 px-4 py-2 border-2 border-black rounded-lg focus:outline-none focus:border-blue-500">
        </li>

        <!-- Message Icon -->
        <li class="relative mr-4">
            <button onclick="window.location.href='help.php'">
                <img src="image/massege.png" alt="Message" class="w-12 h-12">
            </button>
        </li>

        <!-- Login Icon -->
        <li class="relative ml-4">
            <button id="loginButton">
                <img src="image/useradd.png" alt="User" class="w-12 h-12">
            </button>
            <div id="loginDropdown" class="absolute right-0 hidden w-48 bg-white border border-gray-300 rounded-lg shadow-lg">
                <ul class="p-4 space-y-2">
                    <li>
                        <button onclick="window.location.href='login_Details.php?form=login'" class="w-full py-2 mt-2 text-sm font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-700">
                            Sign in
                        </button>
                    </li>
                    <li>
                        <button onclick="window.location.href='login_Details.php?form=create'" class="w-full py-2 mt-2 text-sm font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-700">
                            Create an Account
                        </button>
                    </li>
                </ul>
            </div>
        </li>

        

        <!-- Cart Icon with Dropdown -->
        <li class="relative ml-8">
            <button id="cartButton">
                <img src="image/grocery-store.png" alt="Cart" class="w-12 h-12">
            </button>
            <!-- Dropdown Menu -->
            <div id="cartDropdown" class="absolute right-0 hidden bg-white border border-gray-300 rounded-lg shadow-lg w-80">
                <ul class="p-4 space-y-2">
                    <li class="text-sm text-gray-700">Cart is empty</li>
                    <li>
                        <button class="w-full py-2 mt-2 text-sm font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                            Process Order
                        </button>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>


<div class="relative">
    <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[140px]" src="image/helpbanner.png" alt="Welcome Banner">
</div>


<div class="flex items-center justify-center h-scree">
    <div class="max-w-lg text-center">
        <h1 class="mt-5 mb-8 text-6xl font-bold text-black">How can we help?</h1>
        <p class="text-lg text-black ">
            <strong>A message about delivery times:</strong> With inclement weather conditions throughout the country, delivery times may run longer than usual in some regions. We are committed to delivering your orders as quickly as possible. Contact us any time. We are here for you.
        </p>
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
<script>
    // dropdown of Cart
    const cartButton = document.getElementById('cartButton');
    const cartDropdown = document.getElementById('cartDropdown');

    cartButton.addEventListener('click', () => {
        cartDropdown.classList.toggle('hidden');
    });

    // Close the dropdown if clicked outside
    window.addEventListener('click', (e) => {
        if (!cartButton.contains(e.target) && !cartDropdown.contains(e.target)) {
            cartDropdown.classList.add('hidden');
        }
    });




    // dropdown the login
    const loginButton = document.getElementById('loginButton');
    const loginDropdown = document.getElementById('loginDropdown');

    loginButton.addEventListener('click', () => {
        loginDropdown.classList.toggle('hidden');
    });

    window.addEventListener('click', (e) => {
        if (!loginButton.contains(e.target) && !loginDropdown.contains(e.target)) {
            loginDropdown.classList.add('hidden');
        }
    });
</script>
</html>