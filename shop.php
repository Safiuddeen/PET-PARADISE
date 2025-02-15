<?php
require_once 'config/connection.php'; // Include the Database connection file

$db = new Database(); // Create an instance of the Database class
$conn = $db->getConnection();
session_start();

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

$category = isset($_GET['category']) ? $_GET['category'] : ''; // Get category from URL

$sql = "SELECT * FROM item WHERE item_category='$category'"; // Fetch items based on category
$result = $conn->query($sql);
?>
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

   <!-- item cards -->
   <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-6">
        <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg"
            onclick="openModal('<?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?>',
                '<?php echo htmlspecialchars($row['pet_category'] ?? 'category not available.'); ?>',
                '<?php echo htmlspecialchars($row['item_category'] ?? 'category not available.'); ?>',
                '<?php echo htmlspecialchars($row['original_price'] ?? 'No price available.'); ?>',
                '<?php echo htmlspecialchars($row['discount'] ?? 'No discount available.'); ?>',
                '<?php echo htmlspecialchars($row['description'] ?? 'No description available.'); ?>',
                '<?php echo !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) : ''; ?>',
                '<?php echo $row['item_id']; ?>')">
            
            <!-- Display image if available -->
            <?php if (!empty($row['item_image'])): ?>
                <!-- Image Section -->
                <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['item_image']); ?>" alt="<?php echo htmlspecialchars($row['item_name'] ?? 'Item'); ?>" class="object-cover w-full h-48 mb-4 rounded-md">
            <?php endif; ?>    
            <!-- Additional Fields -->
            <div class="mt-4">
                <h2 class="mb-2 text-lg font-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'No name'); ?></h2>
                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['original_price'] ?? 'No price available.'); ?></p>
                <p class="text-sm text-gray-600 uppercase"><?php echo htmlspecialchars($row['price'] ?? 'No price available.'); ?></p>
                <p class="text-sm text-red-600"><?php echo htmlspecialchars($row['discount'] ?? 'No discount available.'); ?></p>
                
                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['pet_category'] ?? 'petCategory not available.'); ?> | <?php echo htmlspecialchars($row['item_category'] ?? 'item category not available.'); ?></p>
            </div>
        </div>      
            <?php endwhile; ?>
            <?php else: ?>
            <p class="text-center text-gray-500 col-span-full">No items found.</p>
            <?php endif; ?>
            <?php $conn->close(); ?>
    </div>

    <!-- Larger Item Display Modal -->
    <div id="itemModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-50 ">
        <div class="relative w-full max-w-lg mx-auto mt-20 mb-20 bg-white rounded-lg shadow-lg">
            <button class="absolute text-gray-600 top-2 right-2 hover:text-red-900" onclick="closeModal()">✖</button>
            <img id="modalImage" src="" alt="Modal Image" class="block w-3/6 mx-auto rounded-t-lg h-52">
            <div class="p-6">
                <!-- Dynamically Updated Values -->
                <h3 id="modalName" class="text-2xl font-bold"></h3>
                <p id="modalOriginalPrice" class="mt-4 text-xl font-semibold text-gray-800"></p>
                <p id="modalDiscount" class="mt-4 text-xl text-red-800"></p>
                <p id="modalPetcategory" class="mt-2 text-gray-800"></p>
                <p id="modalItemcategory" class="mt-2 text-gray-800"></p>
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


    function openModal(name, petCategory, itemCategory, originalPrice, discount, description, imageSrc, itemId) {
        document.getElementById('modalName').textContent = name;
        document.getElementById('modalPetcategory').textContent = "Pet Category: " + petCategory;
        document.getElementById('modalItemcategory').textContent = "Item Category: " + itemCategory;
        document.getElementById('modalOriginalPrice').textContent = `Price: Rs.${originalPrice}`;
        document.getElementById('modalDiscount').textContent = `Discount: Rs.${discount}`;
        document.getElementById('modalDescription').textContent = "Description: " + description;

        // Set the image if available, else use a placeholder
        document.getElementById('modalImage').src = imageSrc || 'placeholder.jpg';

        // Update cart & buy now links dynamically
        document.getElementById('cartLink').href = `cart.php?item_id=${itemId}`;
        document.getElementById('buyNowLink').href = `place_order.php?item_id=${itemId}`;

        // Show the modal
        document.getElementById('itemModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('itemModal').classList.add('hidden');
    }

</script>
</html>