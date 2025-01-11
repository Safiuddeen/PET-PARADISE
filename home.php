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

<!-- navbar -->
<nav class="flex items-center justify-between w-full p-4 bg-white">
    <ul class="flex items-center w-full">
        <!-- Logo -->
        <li class="mr-4"><img src="image/PARADISE2.png" alt="logo" class="h-20 w-36"></li>

        <!-- Search Bar -->
        <li class="flex-grow pl-6"><input type="text" placeholder="Search..." class="w-2/4 px-4 py-2 border-2 border-black rounded-lg focus:outline-none focus:border-blue-500"></li>

        <!-- Login Icon -->
        <li class="relative ml-4">
            <button id="loginButton">
                <img src="image/useradd.png" alt="User" class="w-12 h-12">
            </button>
            <div id="loginDropdown" class="absolute right-0 hidden w-48 bg-white border border-gray-300 rounded-lg shadow-lg">
                <ul class="p-4 space-y-2">
                    <li><button onclick="window.location.href='login_Details.php?form=login'" class="w-full py-2 mt-2 text-sm font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                            Sign in
                        </button>                           
                    </li>
                    
                    <li><button onclick="window.location.href='login_Details.php?form=create'" class="w-full py-2 mt-2 text-sm font-semibold text-white rounded-lg bg-slate-400 hover:bg-slate-200">
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

<section>
    <div class="relative">
        <!-- Slider -->
        <ul id="slider" class="overflow-hidden">
            <li class="relative">
                <img class="object-cover w-full h-auto max-h-[40vh]" src="image/heading.jpg" alt="Responsive Image">
            </li>
            <li class="relative hidden">
                <img class="object-cover w-full h-[40vh]" src="image/Headline.png" alt="">
                <div class="absolute top-0 left-0 flex w-full h-full">
                    <h1 class="w-full px-5 my-auto text-xl font-bold text-center text-white lg:text-4xl">Welcome to PET-PARADISE.</h1>
                </div>
            </li>
            <li class="relative hidden">
                <img class="object-cover w-full h-[40vh]" src="image/Headline.png" alt="">
                <div class="absolute top-0 left-0 flex w-full h-full">
                    <h1 class="w-full px-5 my-auto text-xl font-bold text-center text-white lg:text-4xl">Welcome to PET-PARADISE.</h1>
                </div>
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
        </div>
    </div>
</section>

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
                    <h1 class="text-3xl font-bold text-center">Bird Supplies</h1>
                    <p class="mt-6 text-lg text-center">Manage your categories and items seamlessly using the sidebar.</p>
                </div>
            </section>

            <!-- Dog Section -->
            <section id="dog" class="hidden content-section">
                <div>
                    <h1 class="text-3xl font-bold text-center">Dog Supplies</h1>
                    <p class="mt-6 text-lg text-center">Manage your categories and items seamlessly using the sidebar.</p>
                </div>
            </section>

            <!-- Cat Section -->
            <section id="cat" class="hidden content-section">
                <div>
                    <h1 class="text-3xl font-bold text-center">Cat Supplies</h1>
                    <p class="mt-6 text-lg text-center">Manage your categories and items seamlessly using the sidebar.</p>
                </div>
            </section>

            <!-- Fish Section -->
            <section id="fish" class="hidden content-section">
                <div>
                    <h1 class="text-3xl font-bold text-center">Fish Supplies</h1>
                    <p class="mt-6 text-lg text-center">Manage your categories and items seamlessly using the sidebar.</p>
                </div>
            </section>

            <!-- Rabbit Section -->
            <section id="rabbit" class="hidden content-section">
                <div>
                    <h1 class="text-3xl font-bold text-center">Rabbit Supplies</h1>
                    <p class="mt-6 text-lg text-center">Manage your categories and items seamlessly using the sidebar.</p>
                </div>
            </section>

            <!-- Horse Section -->
            <section id="horse" class="hidden content-section">
                <div>
                    <h1 class="text-3xl font-bold text-center">Horse Supplies</h1>
                    <p class="mt-6 text-lg text-center">Manage your categories and items seamlessly using the sidebar.</p>
                </div>
            </section>

            <!-- Farm Animal Section -->
            <section id="farm-animal" class="hidden content-section">
                <div>
                    <h1 class="text-3xl font-bold text-center">Farm Animal Supplies</h1>
                    <p class="mt-6 text-lg text-center">Manage your categories and items seamlessly using the sidebar.</p>
                </div>
            </section>
        </div>
</div>       

<!-- main page footer -->
<footer class="py-4 mt-0 text-sm text-center text-white bg-slate-700">
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

<script>

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
</script>


 


    
</body>
</html>