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
            <p class="self-center text-3xl font-bold">LOGIN FORM</p><br>
            
            <label for="username" class="font-semibold text-black">UserName:</label>
            <input type="text" name="username" placeholder="UserName" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <label for="password" class="font-semibold text-black">Password:</label>
            <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 mb-6 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <button type="submit" class="px-6 py-2 text-white transition duration-200 bg-blue-500 rounded-2xl hover:bg-blue-600">
                Log in
            </button>
            <a href="create_login.php" class="self-center text-blue-950 hover:underline">Create New Account</a>

            <footer class="mt-6 text-sm text-center text-white">
                <p>© 2024 Paradise Inc. All rights reserved.</p>
                <a href="#" class=" text-blue-950 hover:underline">Privacy Policy</a> | 
                <a href="#" class="text-blue-950 hover:underline">Terms of Service</a>
            </footer>
        </form>
    </div>


<!-- Create logging form -->
    <div id="createForm" >
        <form action="#" method="" class="flex flex-col p-6 mt-20 mb-40 rounded-lg shadow-lg w-96 bg-slate-800/25">

            <a href="index.php" class="self-center">
                <img src="image/PARADISE.png"  alt="logo" class="w-24 h-auto mb-4 rounded-lg shadow-[2px_2px_20px_black]" >
            </a>
            <p class="self-center text-3xl font-bold">CREATE LOGIN</p><br>
            
            <label for="username" class="font-semibold text-black">FullName:</label>
            <input type="text" name="fullname" placeholder="FullName" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <label for="username" class="font-semibold text-black">UserName:</label>
            <input type="text" name="username" placeholder="UserName" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <label for="username" class="font-semibold text-black">Email:</label>
            <input type="text" name="email" placeholder="Email" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <label for="gender" class="mb-2 font-semibold text-black">Gender:</label>
                    <div>
                        <input id="gender-male" type="radio" name="gender" value="Male" class="text-blue-500 form-radio focus:ring focus:ring-blue-200">
                        <span class="ml-2">Male</span>

                        <input id="gender-female" type="radio" name="gender" value="Female" class="text-blue-500 ml-7 form-radio focus:ring focus:ring-blue-200">
                        <span class="ml-2">Female</span>
                    
                        <input id="gender-other" type="radio" name="gender" value="Other" class="text-blue-500 ml-7 form-radio focus:ring focus:ring-blue-200">
                        <span class="ml-2">Other</span>
                    </div>    
            
            <label for="password" class="mt-4 font-semibold text-black">Password:</label>
            <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 mb-6 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <label for="password" class="font-semibold text-black">Re Enter Password:</label>
            <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 mb-6 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">       

            <button type="submit" class="px-6 py-2 font-semibold text-white transition duration-200 bg-blue-500 rounded-2xl hover:bg-blue-600">
                    Create Account
            </button>

            <footer class="mt-6 text-sm text-center text-white">
                <p>© 2024 Paradise Inc. All rights reserved.</p>
                <a href="#" class=" text-blue-950 hover:underline">Privacy Policy</a> | 
                <a href="#" class="text-blue-950 hover:underline">Terms of Service</a>
            </footer>
        </form>
    </div>


    <script>
        //script for show the form
        function showForm() {
            const urlParams = new URLSearchParams(window.location.search);
            const formType = urlParams.get('form');
            const loginForm = document.getElementById('loginForm');
            const createForm = document.getElementById('createForm');

            if (formType === 'login') {
                loginForm.style.display = 'block';
                createForm.style.display = 'none';
            } else if (formType === 'create') {
                createForm.style.display = 'block';
                loginForm.style.display = 'none';
            } else {
                loginForm.style.display = 'none';
                createForm.style.display = 'none';
                alert('Invalid form type. Please go back and select an option.');
            }
        }

        window.onload = showForm;
    </script>
    
    
</body>
</html>