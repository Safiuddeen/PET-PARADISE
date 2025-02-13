<?php
include 'connection.php';
session_start();

// Get the username cookie
$username = isset($_COOKIE['user']) ? $_COOKIE['user'] : null;
// Show cookie message only if the user hasn't accepted it
if ($username && !isset($_COOKIE["cookiesAccepted_$username"])){
}else{

}


if (isset($_SESSION["customer_ID"]) && isset($_SESSION["username"])) {
    // Extract the first two characters of the username and convert them to uppercase.
    $user = strtoupper(substr($_SESSION["username"], 0, 2));
} else {
    $user = ""; // For example, "GU" for Guest User.
}

if (isset($_POST['userlogout'])) { 
    session_unset();  
    session_destroy();
    header("Location: index.php");
    exit();
}

// Get category from URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch items based on category
$sql = "SELECT * FROM item WHERE item_category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

// Fetch 12 items from the 'item' table
$sql = "SELECT * FROM item LIMIT 12";
$result = $conn->query($sql);

?>
<!-- home page -->
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
                <input type="text" placeholder="Search..." name="navsearch" class="w-2/4 px-4 py-2 border-2 border-black rounded-lg focus:outline-none focus:border-blue-500">
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

            <!-- Login Icon or User Initials -->
            <?php if (!isset($_SESSION["customer_ID"]) && !isset($_SESSION["username"])): ?>
                <!-- Not logged in: display the login icon with dropdown -->
                <li class="relative ml-8">
                    <button id="loginButton">
                        <img src="image/useradd.png" alt="User" class="w-12 h-12">
                    </button>
                    <div id="loginDropdown" class="absolute right-0 hidden w-48 bg-white border border-gray-300 rounded-lg shadow-lg">
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
                        <?php echo $user; ?>
                    </button>
                    <div id="logoutDropdown" class="absolute right-0 hidden w-48 bg-white border border-gray-300 rounded-lg shadow-lg">
                        <ul class="p-4 space-y-2">
                            <li>
                                <button onclick="window.location.href='userProfile.php'" class="w-full py-2 mt-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-700">
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


    <!-- Categories Inline -->
<div class="p-4 bg-gray-200">
<div class="container flex justify-center mx-auto space-x-6">
        <a onclick="redirectToCategory('Food')" class="flex flex-col items-center font-bold text-black cursor-pointer hover:underline">
            <img src="image/icons/food.png" alt="Food Icon" class="w-12 h-12">
            <span class="mt-2 text-lg font-bold">Food</span>
        </a>
        <a onclick="redirectToCategory('Accessories')" class="flex flex-col items-center font-bold text-black cursor-pointer hover:underline">
            <img src="image/icons/Accessories.png" alt="Accessories Icon" class="w-12 h-12">
            <span class="mt-2 text-lg font-bold">Accessories</span>
        </a>
        <a onclick="redirectToCategory('Health')" class="flex flex-col items-center font-bold text-black cursor-pointer hover:underline">
            <img src="image/icons/Health.png" alt="Health Icon" class="w-12 h-12">
            <span class="mt-2 text-lg font-bold">Health</span>
        </a>
        <a onclick="redirectToCategory('Housing')" class="flex flex-col items-center font-bold text-black cursor-pointer hover:underline">
            <img src="image/icons/Housing.png" alt="Housing Icon" class="w-12 h-12">
            <span class="mt-2 text-lg font-bold">Housing</span>
        </a>
        <a onclick="redirectToCategory('Specialty')" class="flex flex-col items-center font-bold text-black cursor-pointer hover:underline">
            <img src="image/icons/Specialty.png" alt="Specialty Icon" class="w-12 h-12">
            <span class="mt-2 text-lg font-bold">Specialty</span>
        </a>
    </div>
</div>
  

    <div class="w-full h-3 bg-gray-100 "></div>

    <div class="relative">
        <img class="object-cover w-full h-auto max-h-[55vh] sm:max-h-[60vh] md:max-h-[70vh] lg:max-h-[80vh] min-h-[140px]" src="image/banners/maroon and white modern pet shop banner landscape (15 x 4 in) (2).png" alt="Welcome Banner">
    </div>



    <!-- Categories -->
    <div class="overflow-x-auto">

        <table class="min-w-full border border-gray-200">
            <thead>
                <tr>
                    <th colspan="7" class="p-3 text-lg font-bold text-center text-gray-700 bg-gray-100">CATEGORIES</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="p-4">
                        <!-- Image Grid -->
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7">
                            <!-- Bird -->
                            <div class="flex flex-col items-center">
                                <img src="image/cat_Image/bird.jpeg" onclick="window.location.href='home.php?id=bird'" alt="Bird" class="w-24 h-24 rounded-full cursor-pointer sm:w-32 sm:h-32">
                                <span class="mt-2 text-lg font-bold">Bird</span>
                            </div>
                            <!-- Dog -->
                            <div class="flex flex-col items-center">
                                <img src="image/cat_Image/dog1.jpg" onclick="window.location.href='home.php?id=dog'" alt="Dog" class="w-24 h-24 rounded-full cursor-pointer sm:w-32 sm:h-32">
                                <span class="mt-2 text-lg font-bold">Dog</span>
                            </div>
                            <!-- Cat -->
                            <div class="flex flex-col items-center">
                                <img src="image/cat_Image/cat.jpeg" onclick="window.location.href='home.php?id=cat'" alt="Cat" class="w-24 h-24 rounded-full cursor-pointer sm:w-32 sm:h-32">
                                <span class="mt-2 text-lg font-bold">Cat</span>
                            </div>
                            <!-- Fish -->
                            <div class="flex flex-col items-center">
                                <img src="image/cat_Image/Fish1.jpg" onclick="window.location.href='home.php?id=fish'" alt="Fish" class="w-24 h-24 rounded-full cursor-pointer sm:w-32 sm:h-32">
                                <span class="mt-2 text-lg font-bold">Fish</span>
                            </div>
                            <!-- Rabbit -->
                            <div class="flex flex-col items-center">
                                <img src="image/cat_Image/rabit.jpeg" onclick="window.location.href='home.php?id=rabbit'" alt="Rabbit" class="w-24 h-24 rounded-full cursor-pointer sm:w-32 sm:h-32">
                                <span class="mt-2 text-lg font-bold">Rabbit</span>
                            </div>
                            <!-- Horse -->
                            <div class="flex flex-col items-center">
                                <img src="image/cat_Image/horse.jpg" onclick="window.location.href='home.php?id=horse'" alt="Horse" class="w-24 h-24 rounded-full cursor-pointer sm:w-32 sm:h-32">
                                <span class="mt-2 text-lg font-bold">Horse</span>
                            </div>
                            
                            <!-- Farm Animals -->
                            <div class="flex flex-col items-center">
                                <img src="image/cat_Image/Farm.jpeg" onclick="window.location.href='home.php?id=farm-animal'" alt="Farm Animals" class="w-24 h-24 rounded-full cursor-pointer sm:w-32 sm:h-32">
                                <span class="mt-2 text-lg font-bold">Farm Animals</span>
                            </div>
                        
                        </div>
                    </td>
                </tr>
                <tr>
                    <th colspan="7" class="p-2 bg-gray-100"></th>
                </tr>
            </tbody>
        </table>
    </div>
    <section>
        <div class="relative">
            <!-- Slider -->
            <ul id="slider" class="overflow-hidden">
                <li class="relative">
                    <img class="object-cover w-full h-auto max-h-[48vh]" src="image/banners/7.png" alt="1">
                </li>
                <li class="relative hidden">
                    <img class="object-cover w-full h-auto max-h-[48vh]" src="image/banners/4.png" alt="2">
                    
                </li>
                <li class="relative hidden">
                    <img class="object-cover w-full h-auto max-h-[48vh]" src="image/banners/5.png" alt="3">
                </li>
                <li class="relative hidden">
                    <img class="object-cover w-full h-auto max-h-[48vh]" src="image/banners/6.png" alt="4">
                </li>
                <li class="relative hidden">
                    <img class="object-cover w-full h-auto max-h-[48vh]" src="image/banners/8.png" alt="5">
                </li>
                <li class="relative hidden">
                    <img class="object-cover w-full h-auto max-h-[48vh]" src="image/banners/9.png" alt="6">
                </li>
                <li class="relative hidden">
                    <img class="object-cover w-full h-auto max-h-[48vh]" src="image/banners/10.png" alt="7">
                </li>
            </ul>

            <!-- Navigation Buttons -->
            <div class="absolute top-0 left-0 flex w-full h-full px-5">
                <div class="flex justify-between w-full my-auto">
                    <button id="prev" class="p-2 bg-white rounded-full shadow-lg bg-opacity-30">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </button>
                    <button id="next" class="p-2 bg-white rounded-full shadow-lg bg-opacity-30">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Dots -->
            <div id="dots" class="absolute flex space-x-2 transform -translate-x-1/2 bottom-5 left-1/2">
                <span class="w-3 h-3 bg-gray-400 rounded-full dot"></span>
                <span class="w-3 h-3 bg-gray-400 rounded-full dot"></span>
                <span class="w-3 h-3 bg-gray-400 rounded-full dot"></span>
                <span class="w-3 h-3 bg-gray-400 rounded-full dot"></span>
                <span class="w-3 h-3 bg-gray-400 rounded-full dot"></span>
                <span class="w-3 h-3 bg-gray-400 rounded-full dot"></span>
                <span class="w-3 h-3 bg-gray-400 rounded-full dot"></span>

            </div>
        </div>
    </section>

    <div class="w-full h-5 bg-gray-100 border-t-4"></div>

    <!-- item cards -->
    <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-6">
        <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg"
            onclick="openModal('<?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?>',
            '<?php echo htmlspecialchars($row['pet_category'] ?? 'No description available.'); ?>',
            '<?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?>',
            '<?php echo !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) :''; ?>',
            '<?php echo $row['item_id']; ?>')">
            
            <!-- Display image if available -->
            <?php if (!empty($row['item_image'])): ?>
            <!-- Image Section -->
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
            <p class="text-center text-gray-500 col-span-full">No items found.</p>
            <?php endif; ?>
            <?php $conn->close(); ?>
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
                    <a id="buyNowLink" href="#">
                        <button class="px-1 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Place order</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- cookie notification -->
    <div id="cookieMessage" class="fixed p-4 text-white bg-gray-800 rounded-lg shadow-lg bottom-4 left-4">
    <p>We use cookies to enhance your experience. By continuing, you accept our cookies.</p>
    <button onclick="acceptCookies('<?php echo $username; ?>')" class="px-4 py-2 mt-2 text-white bg-blue-500 rounded">Accept Cookies</button>
</div>




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

    //image slidings script
    const slides = document.querySelectorAll('#slider li');
    const dots = document.querySelectorAll('#dots .dot');
    let currentIndex = 0;
    let slideInterval;

    const showSlide = (index) => {
        slides.forEach((slide, i) => {
            slide.classList.toggle('hidden', i !== index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-gray-400', i !== index);
            dot.classList.toggle('bg-gray-700', i === index);
        });
    };

    const nextSlide = () => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    };

    const prevSlide = () => {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(currentIndex);
    };

    const startAutoSlide = () => {
        slideInterval = setInterval(nextSlide, 3000);
    };

    const stopAutoSlide = () => {
        clearInterval(slideInterval);
    };

    document.getElementById('next').addEventListener('click', () => {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    document.getElementById('prev').addEventListener('click', () => {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            stopAutoSlide();
            currentIndex = index;
            showSlide(currentIndex);
            startAutoSlide();
        });
    });

    showSlide(currentIndex);
    startAutoSlide();


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


    function redirectToCategory(category) {
    window.location.href = "shop.php?category=" + category;
    }

    //script for the acsept cookies
    function acceptCookies(username) {
        document.cookie = "cookiesAccepted_" + username + "=true; path=/; max-age=" + (30 * 24 * 60 * 60); 
        document.getElementById("cookieMessage").style.display = "none"; 
    }

</script>
</html>



