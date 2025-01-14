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
        <li class="relative z-50 ml-8"> 
            <button id="cartButton">
                <img src="image/grocery-store.png" alt="Cart" class="w-12 h-12">
            </button>
            <!-- Dropdown Menu -->
            <div id="cartDropdown" class="absolute right-0 z-50 hidden bg-white border border-gray-300 rounded-lg shadow-lg w-80"> <!-- Add z-50 here as well -->
                <ul class="p-4 space-y-2">
                    <li class="text-sm text-gray-700">
                        <div class="px-4 text-center">
                            <h1 class="mb-4 text-2xl font-semibold text-gray-900">Shopping cart</h1>
                            <p class="mb-2 text-lg text-gray-700">You don't have any items in your cart.</p>
                            <p class="text-sm text-gray-500">Have an account? | Sign in to see your items.</p>
                            <div class="flex justify-center gap-4 mt-6">
                                <button onclick="window.location.href='login_Details.php?form=login'" class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">Sign in</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>


<!-- Categories Inline -->
    <div class="p-4 bg-gray-200">
        <div class="container flex justify-center mx-auto space-x-6">
            <a href="#" class="flex flex-col items-center font-bold text-black hover:underline ">
                <img src="image/icons/food.png" alt="Food Icon" class="w-12 h-12">
                <span class="mt-2 text-lg font-bold">Food</span>
            </a>
            <a href="#" class="flex flex-col items-center font-bold text-black hover:underline">
                <img src="image/icons/Accessories.png" alt="Food Icon" class="w-12 h-12">
                <span class="mt-2 text-lg font-bold">Accessories</span>
            </a>
            <a href="#" class="flex flex-col items-center font-bold text-black hover:underline">
                <img src="image/icons/Health.png" alt="Food Icon" class="w-12 h-12">
                <span class="mt-2 text-lg font-bold">Health</span>
            </a>
            <a href="#" class="flex flex-col items-center font-bold text-black hover:underline">
                <img src="image/icons/Housing.png" alt="Food Icon" class="w-12 h-12">
                <span class="mt-2 text-lg font-bold">Housing</span>
            </a>
            <a href="#" class="flex flex-col items-center font-bold text-black hover:underline">
                <img src="image/icons/Specialty.png" alt="Food Icon" class="w-12 h-12">
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
        <!-- Card 1 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="https://www.bizadmark.com/wp-content/uploads/2021/08/pet-produtcs.jpg" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
                
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 01 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>


        <!-- Card 2 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 02 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 03 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 04 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 05 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 06 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>
  
        <!-- Card 7 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 07 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>

        <!-- Card 8 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 8 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>

        <!-- Card 9 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 9 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>


        <!-- Card 10 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 10 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>

        <!-- Card 11 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 11 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>

        <!-- Card 12 -->
        <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg" onclick="openModal('Product name','Description','Price')">
            <!-- Image Section -->
            <img src="" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 12 Item name</h3>
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>
        </div>
  </div>
</div>

<!-- larger item display  -->
<div id="itemModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-50">
        <div class="relative w-full max-w-lg mx-auto mt-20 bg-white rounded-lg shadow-lg">
            <button class="absolute text-gray-600 top-2 right-2 hover:text-red-900" onclick="closeModal()">✖</button>
            <img id="modalImage" src="https://via.placeholder.com/150" alt="Modal Image" class="w-full h-48 rounded-t-lg">
            <div class="p-6">
                <h3 id="modalTitle" class="text-2xl font-bold"></h3>
                <p id="modalDescription" class="mt-2 text-gray-600"></p>
                <p id="modalPrice" class="mt-4 text-xl font-semibold text-gray-800"></p>
                <div class="flex justify-around mt-6">
                    <a href="cart.php">
                        <button class="px-3 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Add to Cart</button>
                    </a>
                    <a href="paymentex.php">
                        <button class="px-3 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Buy It Now</button>
                    </a>
                    
                </div>
            </div>
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
    // Dropdown of Cart
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


    // Function to open the item in larger display
    function openModal(title, description, price) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalDescription').textContent = description;
            document.getElementById('modalPrice').textContent = `$${price}`;
            document.getElementById('itemModal').classList.remove('hidden');
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('itemModal').classList.add('hidden');
        }
</script>
</html>



