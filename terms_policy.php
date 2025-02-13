<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="image/PARADISE.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Terms and Conditions</title>
</head>
<body class="flex flex-col min-h-screen bg-indigo-200">

    <!-- Navbar -->
    <nav class="flex items-center justify-between w-full p-4 bg-white shadow-md">
        <ul class="flex items-center w-full">
            <li class="mr-4">
                <a href="index.php">
                    <img src="image/PARADISE2.png" alt="logo" class="h-20 w-36">
                </a>
            </li>
            <li class="items-center flex-grow text-center">
                <p class="text-lg font-semibold">Stay informed, stay connected - Check our terms or contact us anytime.</p>
            </li>
        </ul>
    </nav>

    <!-- Banner -->
    <div class="relative">
        <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[140px]" src="image/helpbanner.png" alt="Welcome Banner">
    </div>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center flex-grow px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-black">How can we Assist You?</h1>

        <div class="flex flex-col w-full max-w-4xl mt-8 overflow-hidden bg-white rounded-lg shadow-lg md:flex-row">
            <!-- Terms and Conditions Section -->
            <div class="w-full md:w-1/2 p-6 overflow-y-auto max-h-[500px] bg-gray-100">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">Terms & Conditions</h2>
                <h3 class="text-lg font-semibold text-gray-800">General Terms</h3>
                <p class="text-sm leading-relaxed text-gray-700">
                    1. By using our services, you agree to comply with our terms.<br><br>
                    2. We ensure the safety and quality of our products.<br><br>
                    3. Personal information provided will be handled with confidentiality.<br><br>
                    4. Any misuse of our services may result in account termination.<br><br>
                    5. We reserve the right to modify these terms at any time.<br><br>
                </p>
                <h3 class="mt-4 text-lg font-semibold text-gray-800">Usage Policies</h3>
                <p class="text-sm leading-relaxed text-gray-700">
                    6. Refunds are subject to our policy stated on the website.<br><br>
                    7. Unauthorized reproduction of our content is prohibited.<br><br>
                    8. Users must be 18 years or older to register.<br><br>
                    9. Our liability is limited to the maximum extent permitted by law.<br><br>
                    10. By continuing, you accept these terms fully.<br><br>
                </p>
            </div>
            
            <!-- Contact Us Form -->
            <div class="w-full p-6 md:w-1/2">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">Contact Us</h2>
                <form action="#" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Your Name</label>
                        <input type="text" name="username" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" name="email" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Comments</label>
                        <textarea name="comments" rows="4" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Send</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 text-sm text-center text-white bg-slate-700">
        <p>We're here 24/7</p>
        <a href="terms_policy.php" class="pr-2 text-white hover:underline">+94 715 223 323</a>-Or-
        <a href="terms_policy.php" class="pl-2 text-white hover:underline">Email Us</a>
    </footer>
    <footer class="py-4 text-sm text-center bg-white text-slate-900">
        <p>Pet Paradise</p>
        <p>Sri Lanka</p>
        <p>© 2024 Paradise Inc. All rights reserved.</p>
        <a href="terms_policy.php" class="text-blue-950 hover:underline">Privacy Policy</a> | 
        <a href="terms_policy.php" class="text-blue-950 hover:underline">Terms of Service</a>
    </footer>
</body>
</html>
