<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    session_unset();  // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login_Details.php"); // Redirect to login page
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="image/PARADISE.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    

<div class="flex ">
    <!-- Sidebar -->
    <div id="sidebar" class="flex-col items-center hidden w-1/5 min-h-full p-4 space-y-6 text-black transition-all duration-300 ease-in-out bg-white lg:flex">
       
        <div class="w-full h-1 border-t-4 border-black"></div>
        <p class="text-lg font-semibold text-orange-600">Manager -: <?php if (isset($_SESSION["username"])) echo htmlspecialchars($_SESSION["username"]); ?>. </p>
        <div class="w-full h-1 border-t-4 border-black"></div>
        <!-- Categories -->
        <div class="flex flex-col items-center w-full">
            <h3 class="mb-4 text-lg font-bold">Categories</h3>
            <ul class="space-y-2 text-center">
            <li><button onclick="showContent('dog')" class="hover:underline">Dog</button></li>
                <li><button onclick="showContent('cat')" class="hover:underline">Cat</button></li>
                <li><button onclick="showContent('bird')" class="hover:underline">Bird</button></li>
                <li><button onclick="showContent('rabbit')" class="hover:underline">Rabbit</button></li>
                <li><button onclick="showContent('fish')" class="hover:underline">Fish</button></li>
                <li><button onclick="showContent('farm')" class="hover:underline">Farm Animals</button></li>
                <li><button onclick="showContent('horse')" class="hover:underline">Horses</button></li>
            </ul>
        </div>
        <div id="backButton" class="hidden mt-4">
            <button onclick="showWelcome()" class="flex items-center px-4 py-2 text-sm font-bold text-white bg-blue-500 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </button>
        </div>

        <div class="w-full h-1 border-t-4 border-black"></div>

        <!-- Item managment -->
        <div class="flex flex-col items-center w-full">
        <h3 class="mb-4 text-lg font-bold">Admin Panel</h3>
        <ul class="space-y-2 text-center">
            <li>
                <a onclick="window.location.href='admin2.php'" class="cursor-pointer ">
                <img src="image/inventory.png" alt="Inventory" class="w-16 h-16 mx-auto">
                Admin Dashboard
                </a>
            </li>
        </ul>
    </div>


        <div class="w-full h-1 border-t-4 border-black"></div>

        <!-- Logout Button -->
        <div class="mt-auto">
            <form action="" method="POST">
                <button type="submit" class="flex items-center mb-auto space-x-1 hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                    </svg>
                    Logout
                </button>
            </form>
    </div>
    </div>

    <!-- Collapsed Icon -->
    <div id="sidebarIcon" class="fixed p-2 text-white bg-blue-500 rounded-md cursor-pointer lg:hidden top-2 left-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </div>

    <!-- Main Content -->
        <div class="flex-1 p-4 bg-indigo-200">
            <!-- Default Welcome Content -->
            <div id="welcome" class="bg-white content-section">
                <!-- Navbar -->
                <nav class="bg-white">
                    <ul class="flex flex-wrap items-center justify-between w-full p-4">
                        <!-- Para -->
                        <li class="flex-grow text-center">
                            <!-- Display as smaller text on small screens -->
                            <p class="hidden text-xs font-medium text-gray-700 sm:text-lg sm:block">
                            Welcome to Inventory Managment Dashboard <br>PetParadise   </p>
                        </li>
                    </ul>
                </nav>
                <nav class=" bg-slate-600">
                    <ul class="flex flex-wrap items-center justify-between w-full p-2">
                        <li><button onclick="showContent('admin')" class="text-white hover:underline">Admin Manage</button></li>
                        <li><button onclick="showContent('customer')" class="text-white hover:underline">Customer Manage</button></li>
                        <li><button onclick="showContent('supplier')" class="text-white hover:underline">Suplier Manage</button></li>
                    </ul>
                </nav>
                            
            </div>  
        
        <!-- Category-Specific Content -->
        <!-- DOG -->
        <div id="dog" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Dog Items</h1>
            <p class="mb-6 text-center">Details about dogs and related items go here.</p>
            <br>
            <br>
                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>  
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                            </tr>
                        </thead>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- CAT -->
        <div id="cat" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Cat Items</h1>
            <p class="mb-6 text-center">Details about cat and related items go here.</p>
            <br>
            <br>
                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                            </tr>
                        </thead>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- BIRD -->
        <div id="bird" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Bird Items</h1>
            <p class="mb-6 text-center">Details about bird and related items go here.</p>
            <br>
            <br>
                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                            </tr>
                        </thead>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- RABBIT -->
        <div id="rabbit" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Rabbit Items</h1>
            <p class="mb-6 text-center">Details about rabbit and related items go here.</p>
            <br>
            <br>
                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                            </tr>
                        </thead>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- FISH -->
        <div id="fish" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Fish Items</h1>
            <p class="mb-6 text-center">Details about fish and related items go here.</p>
            <br>
            <br>
                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                            </tr>
                        </thead>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- FARM-ANIMAL -->
        <div id="farm" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Farm Animal Items</h1>
            <p class="mb-6 text-center">Details about farm animal and related items go here.</p>
            <br>
            <br>
                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                            </tr>
                        </thead>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- HORSE -->
        <div id="horse" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Horse Items</h1>
            <p class="mb-6 text-center">Details about horse and related items go here.</p>
            <br>
            <br>
                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                            </tr>
                        </thead>
                    </table>
                </div>            
            <br><br><br><br>
        </div>
        <!-- ADMIN -->
<div id="admin" class="flex flex-col items-center hidden min-h-screen content-section">
    <h1 class="w-full mb-4 text-2xl font-bold text-center">Admin Managing</h1>

    <div class="w-full px-4">
        <h3 class="text-xl font-bold text-center">Add Admin</h3>

        <div class="flex justify-center">
            <form action="" method="POST" class="flex flex-col p-6 mt-10 rounded-lg shadow-lg w-96 bg-slate-800/25">
                <p class="self-center text-3xl font-bold">Add admin</p><br>
                <p class="text-sm text-red-700 error">* Required field</p>

                <!-- Full Name -->
                <label class="font-semibold text-black">Full Name:</label>
                <input type="text" name="fullname" required placeholder="Full Name" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                <span class="text-sm text-red-500 error"><?php echo $fullnameErr; ?></span><br>

                <!-- Username -->
                <label class="font-semibold text-black">Username:</label>
                <input type="text" name="username" required placeholder="Username" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                <span class="text-sm text-red-500 error"><?php echo $usernameErr; ?></span><br>

                <!-- Email -->
                <label class="font-semibold text-black">Email:</label>
                <input type="email" name="email" required placeholder="Email" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                <span class="text-sm text-red-500 error"><?php echo $emailErr; ?></span><br>

                <!-- Gender -->
                <label class="font-semibold text-black">Gender:</label>
                <div>
                    <input type="radio" name="gender" value="Male" required> Male
                    <input type="radio" name="gender" value="Female" required class="ml-4"> Female
                    <input type="radio" name="gender" value="Other" required class="ml-4"> Other
                </div>
                <span class="text-sm text-red-500 error"><?php echo $genderErr; ?></span><br>

                <!-- Contact Number -->
                <label class="mt-2 font-semibold text-black">Contact Number:</label>
                <input type="text" name="contactnum" required placeholder="Contact Number" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                <span class="text-sm text-red-500 error"><?php echo $contactnumErr; ?></span><br>

                <!-- Password -->
                <label class="font-semibold text-black">Password:</label>
                <input type="password" name="password" required placeholder="Password" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                <span class="text-sm text-red-500 error"><?php echo $passwordErr; ?></span><br>

                <!-- Submit Button -->
                <button type="submit" name="register" class="px-6 py-2 text-white bg-blue-500 rounded-2xl hover:bg-blue-600">
                    Create New Admin
                </button>
            </form>
        </div>
    </div>

    <!-- Admin list Table -->
    <div class="w-full px-4 mt-8">
        <h3 class="text-xl font-semibold text-center">Pre-Orders</h3>
        <table class="w-full mt-4 border border-collapse border-gray-300 table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border border-gray-300">Admin ID</th>
                    <th class="px-4 py-2 border border-gray-300">Admin FullName</th>
                    <th class="px-4 py-2 border border-gray-300">Email</th>
                    <th class="px-4 py-2 border border-gray-300">Gender</th>
                    <th class="px-4 py-2 border border-gray-300">Contact-Number</th>
                    <th class="px-4 py-2 border border-gray-300">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

            
        
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarIcon = document.getElementById('sidebarIcon');
    const backButton = document.getElementById('backButton');

    // Toggle sidebar visibility on click
    sidebarIcon.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
    });
    //when click visibality
    window.addEventListener('click', (e) => {
        if (! sidebarIcon.contains(e.target) && !sidebar.contains(e.target)) {
          sidebar.classList.add('hidden');
        }
    });
    // this funtion to show the purticuler categorie
     function showContent(category) {
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => section.classList.add('hidden'));
        document.getElementById(category).classList.remove('hidden');
        backButton.classList.remove('hidden');
    }

    function showWelcome() {
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => section.classList.add('hidden'));
        document.getElementById('welcome').classList.remove('hidden');
        backButton.classList.add('hidden');
    }


   // Function to preview the selected image
function previewImage(event) {
    const preview = document.getElementById('preview'); // Image preview element
    const removeButton = document.getElementById('remove-button'); // Remove button
    const fileLabel = document.getElementById('file-label'); // Label for the file name
    const fileInput = event.target; // File input element
    const file = fileInput.files[0]; // Get the selected file

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result; // Display the image in the preview
            preview.classList.remove('hidden'); // Show the preview image
            removeButton.classList.remove('hidden'); // Show the remove button
            fileLabel.textContent = file.name; // Display the file name
        };

        reader.readAsDataURL(file); // Read the file as a Data URL
    }
}

// Function to remove the image preview and reset input
function removeImage() {
    const preview = document.getElementById('preview'); // Image preview element
    const fileInput = document.querySelector('input[name="itemimage"]'); // File input element
    const removeButton = document.getElementById('remove-button'); // Remove button
    const fileLabel = document.getElementById('file-label'); // Label for the file name

    preview.src = ''; // Clear the image source
    preview.classList.add('hidden'); // Hide the preview image
    fileInput.value = ''; // Reset the file input field
    removeButton.classList.add('hidden'); // Hide the remove button
    fileLabel.textContent = 'No file chosen'; // Reset the file label
}

</script>

</body>
</html>
