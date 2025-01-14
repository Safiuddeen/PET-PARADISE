<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="PARADISE.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-indigo-200">

<!-- logging form     -->
    <div id="loginForm" >
        <form action="#" method="" class="flex flex-col p-6 rounded-lg shadow-lg w-96 bg-slate-800/25">

            <a href="index.php" class="self-center">
                <img src="image/PARADISE.png"  alt="logo" class="w-24 h-auto mb-4 rounded-lg " >
            </a>
            <p class="self-center text-3xl font-bold">INVENTORY</p>
            <p class="self-center text-3xl font-bold">MANAGMENT LOGIN </p>
            <p class="self-center text-xs font-bold text-red-700">MANAGER ONLY CAN ACCESS </p><br>
            
            <label for="username" class="font-semibold text-black">Manager Name:</label>
            <input type="text" name="username" placeholder="ManagerName" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <label for="password" class="font-semibold text-black">Password:</label>
            <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 mb-6 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <button type="submit" class="px-6 py-2 text-white transition duration-200 bg-blue-500 rounded-2xl hover:bg-blue-600">
                Log in
            </button><br>
            <a href="stockManagment.php" class="self-center text-blue-950 hover:underline">temporary wat to view Inventory dashboard</a><br>

            <footer class="mt-6 text-sm text-center text-white">
                <p>© 2024 Paradise Inc. All rights reserved.</p>
                <a href="#" class=" text-blue-950 hover:underline">Privacy Policy</a> | 
                <a href="#" class="text-blue-950 hover:underline">Terms of Service</a>
            </footer>
        </form>
    </div>

</body>
</html>    