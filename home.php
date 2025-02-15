<?php
require_once 'config/connection.php'; //Database connection file

$db = new Database(); // Create Database class
$conn = $db->getConnection();

session_start();

if (isset($_SESSION["username"])) {
    $user=($_SESSION["username"]);
} 

if (isset($_POST['userlogout'])) { 
    session_unset();  
    session_destroy();
    header("Location: index.php");
    exit();
}

// Fetch items for the Bird category
$queryBird = "SELECT * FROM item WHERE pet_category = 'Bird'";
$resultBird = $conn->query($queryBird);

// Fetch items for the Dog category
$queryDog = "SELECT * FROM item WHERE pet_category = 'Dog'";
$resultDog = $conn->query($queryDog);

// Fetch items for the Dog category
$queryCat = "SELECT * FROM item WHERE pet_category = 'Cat'";
$resultCat = $conn->query($queryCat);

// Fetch items for the Dog category
$queryFish = "SELECT * FROM item WHERE pet_category = 'Fish'";
$resultFish = $conn->query($queryFish);

// Fetch items for the Dog category
$queryRabbit = "SELECT * FROM item WHERE pet_category = 'Rabbit'";
$resultRabbit = $conn->query($queryRabbit);

// Fetch items for the Dog category
$queryHorse = "SELECT * FROM item WHERE pet_category = 'Horse'";
$resultHorse = $conn->query($queryHorse);

// Fetch items for the Dog category
$queryFA = "SELECT * FROM item WHERE pet_category = 'FarmAnimal'";
$resultFA = $conn->query($queryFA);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="image/PARADISE.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
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
            <li class="relative ">
                <button onclick="window.location.href='help.php'">
                    <img src="image/massege.png" alt="Message" class="w-12 h-12">
                </button>
            </li>

            <!-- Cart Icon with Dropdown -->
            <li class="relative z-50 ml-6">
                <button id="cartButton">
                    <img src="image/grocery-store.png" alt="Cart" class="w-12 h-12">
                </button>
                <div id="cartDropdown" class="absolute right-0 z-50 hidden bg-white border border-gray-300 rounded-lg shadow-lg w-80">
                    <ul class="p-4 space-y-2">
                        <li class="text-sm text-gray-700">
                            <div class="px-4 text-center">
                                <h1 class="mb-4 text-2xl font-semibold text-gray-900">Shopping cart</h1>
                                <p class="mb-2 text-lg text-gray-700">You don't have any items in your cart.</p>
                                <p class="text-sm text-gray-500">Have an account? | Sign in to see your items.</p>
                                <div class="flex justify-center gap-4 mt-6">
                                    <button onclick="window.location.href='login_Details.php?form=login'" class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                                        Sign in
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Login Icon or User Initials (Right Side) -->
            <?php if (!isset($_SESSION["username"])): ?>
                <!-- Not logged in: display the login icon with dropdown -->
                <li class="relative ml-8">
                    <button id="loginButton">
                        <img src="image/useradd.png" alt="User" class="w-12 h-12">
                    </button>
                    <div id="loginDropdown" class="absolute right-0 z-50 hidden w-48 bg-white border border-gray-300 rounded-lg shadow-lg">
                        <ul class="p-4 space-y-2">
                            <li>
                                <button onclick="window.location.href='login_Details.php?form=login'" class="w-full py-2 mt-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Sign in
                                </button>
                            </li>
                            <li>
                                <button onclick="window.location.href='login_Details.php?form=create'" class="w-full py-2 mt-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Create an Account
                                </button>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php else: ?>
                <!-- Logged in: display user initials -->
                <li class="relative ml-8">
                    <button id="userInitialsButton" class="flex items-center justify-center w-12 h-12 text-white bg-blue-500 rounded-full">
                        <?php echo strtoupper(substr($user, 0, 2)); ?>
                    </button>
                    <div id="logoutDropdown" class="absolute right-0 z-50 hidden w-48 bg-white border border-gray-300 rounded-lg shadow-lg">
                        <ul class="p-4 space-y-2">
                            <li>
                                <button onclick="window.location.href=''" class="w-full py-2 mt-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    User Profile
                                </button>
                            </li>
                            <li>
                                <form action="" method="post">
                                <button name="userlogout" class="w-full py-2 text-sm font-semibold text-white bg-red-500 rounded hover:bg-red-700">
                                    Logout
                                </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

<div class="w-full p-2 bg-gray-100 ">  </div>

<div class="flex">
    <!-- Sidebar -->
    <div id="sidebar" class="flex-col items-center hidden w-1/5 min-h-full p-4 space-y-6 text-black transition-all duration-300 ease-in-out bg-white lg:flex">
        
        <!-- Sidebar Top Border -->
        <div class="w-full h-1 border-t-4 border-black"></div>

        <!-- Categories Section -->
        <div class="flex flex-col w-full">
            <h3 class="mb-4 text-lg font-bold">Item categories</h3>
            <ul class="space-y-2 ">
                <li>
                    <input type="checkbox" id="dog" class="mr-2">
                    <label for="dog">Food</label>
                </li>
                <li>
                    <input type="checkbox" id="cat" class="mr-2">
                    <label for="cat">Accessories</label>
                </li>
                <li>
                    <input type="checkbox" id="bird" class="mr-2">
                    <label for="bird">Health & Wellness</label>
                </li>
                <li>
                    <input type="checkbox" id="rabbit" class="mr-2">
                    <label for="rabbit">Housing</label>
                </li>
                <li>
                    <input type="checkbox" id="fish" class="mr-2">
                    <label for="fish">Specialty Items</label>
                </li>
            </ul>
        </div>

        <div class="w-full h-1 border-t-4 border-black"></div>

        <!-- Price Section -->
        <div class="flex flex-col w-full mt-6">
            <h3 class="mb-4 text-lg font-bold">Price Range</h3>
            <div class="flexspace-x-2">
                <input type="checkbox" id="low-price" class="mr-2">
                <label for="low-price">Under Rs 1000</label>
            </div>
            <div class="flex space-x-2">
                <input type="checkbox" id="mid-price" class="mr-2">
                <label for="mid-price">Rs 1000 - Rs 2500</label>
            </div>
            <div class="flex space-x-2">
                <input type="checkbox" id="high-price" class="mr-2">
                <label for="high-price">Above Rs 2500</label>
            </div>
        </div>

        <div class="w-full h-1 border-t-4 border-black"></div>
        
        <!-- Customer Ratings Section -->
        <div class="flex flex-col w-full mt-6">
            <h3 class="mb-4 text-lg font-bold">Customer Ratings</h3>
            <div class="flex space-x-2">
                <input type="checkbox" id="star-5" class="mr-2">
                <label for="star-5">⭐⭐⭐⭐⭐</label>
            </div>
            <div class="flex space-x-2">
                <input type="checkbox" id="star-4" class="mr-2">
                <label for="star-4">⭐⭐⭐⭐</label>
            </div>
            <div class="flex space-x-2">
                <input type="checkbox" id="star-3" class="mr-2">
                <label for="star-3">⭐⭐⭐</label>
            </div>
            <div class="flex space-x-2">
                <input type="checkbox" id="star-2" class="mr-2">
                <label for="star-2">⭐⭐</label>
            </div>
            <div class="flex space-x-2">
                <input type="checkbox" id="star-1" class="mr-2">
                <label for="star-1">⭐</label>
            </div>
        </div>

        <div class="w-full h-1 border-t-4 border-black"></div>
        
        <!-- Back Button -->
        <div id="backButton" class="mt-4">
            <button onclick="window.location.href='index.php';" class="flex px-4 py-2 text-sm font-bold text-white bg-blue-500 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to MainPage
            </button>
        </div>

        <!-- Sidebar Bottom Border -->
        <div class="w-full h-1 border-t-4 border-black"></div>
    </div>



    <!-- Collapsed Icon -->
    <div id="sidebarIcon" class="fixed p-2 text-white bg-blue-500 rounded-md cursor-pointer lg:hidden top-2 left-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </div>

        <!-- Main Content -->
        <div class="flex-1 p-4 bg-indigo-200">
            <!-- Bird Section -->
            <section id="bird" class="hidden content-section">
                <div>
                    <h1 class="mb-4 text-3xl font-bold text-center">Bird Supplies</h1>
                </div>
                <div class="relative">
                    <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[100px]" src="image/banners/7.png" alt="Bird Banner">
                </div>
                <!-- item cards -->
                <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-4">
                    <?php if ($resultBird && $resultBird->num_rows > 0): ?>
                        <?php while ($row = $resultBird->fetch_assoc()): ?>
                            <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg"
                                onclick="openModal('<?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?>',
                                '<?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?>',
                                '<?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?>',
                                '<?php echo !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) :''; ?>',
                                '<?php echo $row['item_id']; ?>')">
                                <!-- Display image if available -->
                                <?php if (!empty($row['item_image'])): ?>
                                    <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['item_image']); ?>" alt="<?php echo htmlspecialchars($row['item_name'] ?? 'Item'); ?>" class="object-cover w-full h-48 mb-4 rounded-md">
                                <?php endif; ?>
                                <!-- Additional Fields -->
                                <div class="mt-4">
                                    <h2 class="mb-2 text-lg font-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['discount'] ?? 'No discount available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['original_price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center text-gray-500 col-span-full">No bird items found.</p>
                    <?php endif; ?>
                </div>
            </section>

            
            <!-- Dog Section -->
            <section id="dog" class="hidden content-section">
                <div>
                    <h1 class="mb-4 text-3xl font-bold text-center">Dog Supplies</h1>
                </div>
                <div class="relative">
                    <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[100px]" src="image/banners/4.png" alt="Welcome Banner">
                </div>
                <!-- item cards -->
                <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-4">
                    <?php if ($resultDog && $resultDog->num_rows > 0): ?>
                        <?php while ($row = $resultDog->fetch_assoc()): ?>
                            <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg"
                                onclick="openModal('<?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?>',
                                '<?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?>',
                                '<?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?>',
                                '<?php echo !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) :''; ?>',
                                '<?php echo $row['item_id']; ?>')">
                                <!-- Display image if available -->
                                <?php if (!empty($row['item_image'])): ?>
                                    <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['item_image']); ?>" alt="<?php echo htmlspecialchars($row['item_name'] ?? 'Item'); ?>" class="object-cover w-full h-48 mb-4 rounded-md">
                                <?php endif; ?>
                                <!-- Additional Fields -->
                                <div class="mt-4">
                                    <h2 class="mb-2 text-lg font-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['discount'] ?? 'No discount available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['original_price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center text-gray-500 col-span-full">No Dog items found.</p>
                    <?php endif; ?>
                </div>
                
            </section>

           
            <!-- Cat Section -->
            <section id="cat" class="hidden content-section">
                <div>
                    <h1 class="mb-4 text-3xl font-bold text-center">Cat Supplies</h1>
                    <div class="relative">
                        <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[100px]" src="image/banners/5.png" alt="Welcome Banner">
                    </div>
                    <!-- item cards -->
                    <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-4">
                        <?php if ($resultCat && $resultCat->num_rows > 0): ?>
                            <?php while ($row = $resultCat->fetch_assoc()): ?>
                            <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg"
                                onclick="openModal('<?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?>',
                                '<?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?>',
                                '<?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?>',
                                '<?php echo !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) :''; ?>',
                                '<?php echo $row['item_id']; ?>')">
                                <!-- Display image if available -->
                                <?php if (!empty($row['item_image'])): ?>
                                    <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['item_image']); ?>" alt="<?php echo htmlspecialchars($row['item_name'] ?? 'Item'); ?>" class="object-cover w-full h-48 mb-4 rounded-md">
                                <?php endif; ?>
                                <!-- Additional Fields -->
                                <div class="mt-4">
                                    <h2 class="mb-2 text-lg font-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['discount'] ?? 'No discount available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['original_price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?></p>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-center text-gray-500 col-span-full">No Cat items found.</p>
                        <?php endif; ?>
                    </div>    
                </div>
            </section>
            
            <!-- Fish Section -->
            <section id="fish" class="hidden content-section">
                <div>
                    <h1 class="mb-4 text-3xl font-bold text-center">Fish Supplies</h1>
                    <div class="relative">
                        <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[100px]" src="image/banners/6.png" alt="Welcome Banner">
                    </div>
                    <!-- item cards -->
                    <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-4">
                        <?php if ($resultFish && $resultFish->num_rows > 0): ?>
                            <?php while ($row = $resultFish->fetch_assoc()): ?>
                            <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg"
                                onclick="openModal('<?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?>',
                                '<?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?>',
                                '<?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?>',
                                '<?php echo !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) :''; ?>',
                                '<?php echo $row['item_id']; ?>')">
                                <!-- Display image if available -->
                                <?php if (!empty($row['item_image'])): ?>
                                    <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['item_image']); ?>" alt="<?php echo htmlspecialchars($row['item_name'] ?? 'Item'); ?>" class="object-cover w-full h-48 mb-4 rounded-md">
                                <?php endif; ?>
                                <!-- Additional Fields -->
                                <div class="mt-4">
                                    <h2 class="mb-2 text-lg font-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['discount'] ?? 'No discount available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['original_price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?></p>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-center text-gray-500 col-span-full">No Fish items found.</p>
                        <?php endif; ?>
                    </div>    
                </div>
            </section>
            
            <!-- Rabbit Section -->
            <section id="rabbit" class="hidden content-section">
                <div>
                    <h1 class="mb-4 text-3xl font-bold text-center">Rabbit Supplies</h1>
                    <div class="relative">
                        <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[100px]" src="image/banners/8.png" alt="Welcome Banner">
                    </div>
                    <!-- item cards -->
                    <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-4">
                        <?php if ($resultRabbit && $resultRabbit->num_rows > 0): ?>
                            <?php while ($row = $resultRabbit->fetch_assoc()): ?>
                            <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg"
                                onclick="openModal('<?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?>',
                                '<?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?>',
                                '<?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?>',
                                '<?php echo !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) :''; ?>',
                                '<?php echo $row['item_id']; ?>')">
                                <!-- Display image if available -->
                                <?php if (!empty($row['item_image'])): ?>
                                    <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['item_image']); ?>" alt="<?php echo htmlspecialchars($row['item_name'] ?? 'Item'); ?>" class="object-cover w-full h-48 mb-4 rounded-md">
                                <?php endif; ?>
                                <!-- Additional Fields -->
                                <div class="mt-4">
                                    <h2 class="mb-2 text-lg font-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['discount'] ?? 'No discount available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['original_price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?></p>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-center text-gray-500 col-span-full">No Rabbit items found.</p>
                        <?php endif; ?>
                    </div>    
                </div>
            </section>

            <!-- Horse Section -->
            <section id="horse" class="hidden content-section">
                <div>
                    <h1 class="mb-4 text-3xl font-bold text-center ">Horse Supplies</h1>
                    <div class="relative">
                        <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[100px]" src="image/banners/9.png" alt="Welcome Banner">
                    </div>
                    <!-- item cards -->
                    <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-4">
                        <?php if ($resultHorse && $resultHorse->num_rows > 0): ?>
                            <?php while ($row = $resultHorse->fetch_assoc()): ?>
                            <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg"
                                onclick="openModal('<?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?>',
                                '<?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?>',
                                '<?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?>',
                                '<?php echo !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) :''; ?>',
                                '<?php echo $row['item_id']; ?>')">
                                <!-- Display image if available -->
                                <?php if (!empty($row['item_image'])): ?>
                                    <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['item_image']); ?>" alt="<?php echo htmlspecialchars($row['item_name'] ?? 'Item'); ?>" class="object-cover w-full h-48 mb-4 rounded-md">
                                <?php endif; ?>
                                <!-- Additional Fields -->
                                <div class="mt-4">
                                    <h2 class="mb-2 text-lg font-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['discount'] ?? 'No discount available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['original_price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?></p>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-center text-gray-500 col-span-full">No horse items found.</p>
                        <?php endif; ?>
                    </div>    
                </div>
            </section>

            <!-- Farm Animal Section -->
            <section id="farm-animal" class="hidden content-section">
                <div>
                    <h1 class="mb-4 text-3xl font-bold text-center">Farm Animal Supplies</h1>
                    <div class="relative">
                        <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[100px]" src="image/banners/10.png" alt="Welcome Banner">
                    </div>
                    <!-- item cards -->
                    <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-4">
                        <?php if ($resultFA && $resultFA->num_rows > 0): ?>
                            <?php while ($row = $resultFA->fetch_assoc()): ?>
                            <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg"
                                onclick="openModal('<?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?>',
                                '<?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?>',
                                '<?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?>',
                                '<?php echo !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) :''; ?>',
                                '<?php echo $row['item_id']; ?>')">
                                <!-- Display image if available -->
                                <?php if (!empty($row['item_image'])): ?>
                                    <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['item_image']); ?>" alt="<?php echo htmlspecialchars($row['item_name'] ?? 'Item'); ?>" class="object-cover w-full h-48 mb-4 rounded-md">
                                <?php endif; ?>
                                <!-- Additional Fields -->
                                <div class="mt-4">
                                    <h2 class="mb-2 text-lg font-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['discount'] ?? 'No discount available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['original_price'] ?? 'No price available.'); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?></p>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-center text-gray-500 col-span-full">No FarmAnimal items found.</p>
                        <?php endif; ?>
                    </div>    
                </div>
            </section>
            <?php $conn->close(); ?>
        </div>
</div>
        <!-- Larger Item Display Modal -->
    <div id="itemModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-50">
        <div class="relative w-full max-w-lg mx-auto mt-20 bg-white rounded-lg shadow-lg">
            <button class="absolute text-gray-600 top-2 right-2 hover:text-red-900" onclick="closeModal()">✖</button>
            <img id="modalImage" src="" alt="Modal Image" class="w-3/6 rounded-t-lg h-52">
            <div class="p-6">
                <!-- Dynamically Updated Values -->
                <h3 id="modalTitle" class="text-2xl font-bold"></h3>
                <p id="modalPrice" class="mt-4 text-xl font-semibold text-gray-800"></p>
                <p id="modalDescription" class="mt-2 text-gray-600"></p>

                <div class="flex justify-around mt-6">
                    <a id="cartLink" href="#">
                        <button class="px-1 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Add to Cart</button>
                    </a>
                    <a id="buyNowLink" href="place_order.php">
                        <button class="px-1 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Place order</button>
                    </a>
                </div>
            </div>
        </div>
    </div>    

<!-- main page footer -->
<footer class="py-4 mt-0 text-sm text-center text-white bg-slate-700">
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

<script>
     const cartButton = document.getElementById('cartButton');
        const cartDropdown = document.getElementById('cartDropdown');
        cartButton.addEventListener('click', () => {
            cartDropdown.classList.toggle('hidden');
        });
        window.addEventListener('click', (e) => {
            if (!cartButton.contains(e.target) && !cartDropdown.contains(e.target)) {
                cartDropdown.classList.add('hidden');
            }
        });

        // Toggle Login Dropdown (for non-logged-in users)
        const loginButton = document.getElementById('loginButton');
        const loginDropdown = document.getElementById('loginDropdown');
        if(loginButton) {
            loginButton.addEventListener('click', () => {
                loginDropdown.classList.toggle('hidden');
            });
            window.addEventListener('click', (e) => {
                if (!loginButton.contains(e.target) && !loginDropdown.contains(e.target)) {
                    loginDropdown.classList.add('hidden');
                }
            });
        }

        // Toggle Logout Dropdown (for logged-in users)
        const userInitialsButton = document.getElementById('userInitialsButton');
        const logoutDropdown = document.getElementById('logoutDropdown');
        if(userInitialsButton) {
            userInitialsButton.addEventListener('click', () => {
                logoutDropdown.classList.toggle('hidden');
            });
            window.addEventListener('click', (e) => {
                if (!userInitialsButton.contains(e.target) && !logoutDropdown.contains(e.target)) {
                    logoutDropdown.classList.add('hidden');
                }
            });
        }
        // Get URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const sectionId = urlParams.get('id');

        // Show the corresponding section and hide others
        if (sectionId) {
            document.querySelectorAll('.content-section').forEach(section => {
                if (section.id === sectionId) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });
        }
   


    const sidebar = document.getElementById('sidebar');
    const sidebarIcon = document.getElementById('sidebarIcon');
    

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
   

    

    function openModal(title, description, price, imageSrc, itemId) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = "Description: " + description;
    document.getElementById('modalPrice').textContent = `Price: Rs.${price}`;
    document.getElementById('modalImage').src = imageSrc;
    
    // Update links dynamically
    document.getElementById('cartLink').href = `cart.php?item_id=${itemId}`;
    document.getElementById('buyNowLink').href = `place_order.php?item_id=${itemId}`;

    document.getElementById('itemModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('itemModal').classList.add('hidden');
    }
</script>


 


    
</body>
</html>