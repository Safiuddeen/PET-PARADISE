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
                <img src="image/grocery-store.png" alt="Cart" class="w-12 h-12 ">
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

<!-- Categories Inline -->
    <div class="p-4 bg-gray-200">
        <div class="container flex justify-center mx-auto space-x-6">
            <a href="#" class="flex flex-col items-center font-bold text-black hover:underline">
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
    <img class="object-cover w-full h-[30vh] sm:h-[35vh] md:h-[40vh] lg:h-[46vh]" src="image/animal-front.jpg" alt="Welcome Banner">
    <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full">
        <div class="text-center text-black">
            <!-- <h1 class="px-5 text-lg font-bold sm:text-xl md:text-2xl lg:text-4xl">Welcome to PET-PARADISE.</h1>
            <h5 class="mt-2 text-sm sm:text-base md:text-lg lg:text-xl">Everything they need, all in one happy place.</h5> -->
        </div>
    </div>
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

<div class="relative">
    <img class="object-cover w-full h-[30vh] sm:h-[35vh] md:h-[40vh] lg:h-[46vh]" src="image/animal-front.jpg" alt="Welcome Banner">
    <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full">
        <div class="text-center text-black">
            <!-- <h1 class="px-5 text-lg font-bold sm:text-xl md:text-2xl lg:text-4xl">Welcome to PET-PARADISE.</h1>
            <h5 class="mt-2 text-sm sm:text-base md:text-lg lg:text-xl">Everything they need, all in one happy place.</h5> -->
        </div>
    </div>
</div>

<div class="w-full h-5 bg-gray-100 border-t-4"></div>

<!-- item cards -->
<div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3 lg:grid-cols-6">
    <!-- Card 1 -->
        <div class="p-4 bg-white rounded-lg shadow-lg">
            <!-- Image Section -->
            <img src="https://www.bizadmark.com/wp-content/uploads/2021/08/pet-produtcs.jpg" alt="Product Image" class="object-cover w-full h-48 mb-4 rounded-md">
            
            <!-- Title -->
            <h3 class="mb-2 text-lg font-bold">Card 01 Item name</h3>
            
            <!-- Description -->
            <p class="text-gray-600">This is a description for card 01.</p>
            
            <!-- Additional Fields -->
            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-700">Price: <span class="text-gray-600">Rs. 1,500</span></p>
                <p class="text-sm font-semibold text-gray-700">Quantity: <span class="text-gray-600">10</span></p>
                <p class="text-sm font-semibold text-gray-700">Item Category: <span class="text-gray-600">Food</span></p>
            </div>

            <!-- Button and Icon -->
            <div class="flex items-center mt-4">
                <button class="px-4 py-1 text-white bg-blue-500 rounded-lg hover:bg-blue-600">View</button>
                <img src="image/grocery-store.png" alt="Cart Icon" class="w-6 h-6 ml-4">
            </div>
        </div>


  <!-- Card 2 -->
  <div class="p-4 bg-white rounded-lg shadow-lg">
    <h3 class="mb-2 text-lg font-bold">Card 02</h3>
    <p class="text-gray-600">This is a description for card 02.</p>
    <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
  </div>

  <!-- Card 3 -->
  <div class="p-4 bg-white rounded-lg shadow-lg">
    <h3 class="mb-2 text-lg font-bold">Card 03</h3>
    <p class="text-gray-600">This is a description for card 03.</p>
    <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
  </div>

  <!-- Card 4 -->
  <div class="p-4 bg-white rounded-lg shadow-lg">
    <h3 class="mb-2 text-lg font-bold">Card 04</h3>
    <p class="text-gray-600">This is a description for card 04.</p>
    <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
  </div>

  <!-- Card 5 -->
  <div class="p-4 bg-white rounded-lg shadow-lg">
    <h3 class="mb-2 text-lg font-bold">Card 05</h3>
    <p class="text-gray-600">This is a description for card 04.</p>
    <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
  </div>

   <!-- Card 6 -->
   <div class="p-4 bg-white rounded-lg shadow-lg">
    <h3 class="mb-2 text-lg font-bold">Card 06</h3>
    <p class="text-gray-600">This is a description for card 04.</p>
    <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
  </div>
  
    <!-- Card 5 -->
    <div class="p-4 bg-white rounded-lg shadow-lg">
      <h3 class="mb-2 text-lg font-bold">Card 07</h3>
      <p class="text-gray-600">This is a description for card 05.</p>
      <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
    </div>

    <!-- Card 6 -->
    <div class="col-start-2 p-4 bg-white rounded-lg shadow-lg">
      <h3 class="mb-2 text-lg font-bold">Card 08</h3>
      <p class="text-gray-600">This is a description for card 06.</p>
      <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
    </div>

    <!-- Card 7 -->
    <div class="p-4 bg-white rounded-lg shadow-lg">
      <h3 class="mb-2 text-lg font-bold">Card 09</h3>
      <p class="text-gray-600">This is a description for card 07.</p>
      <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
    </div>


    <!-- Card 7 -->
    <div class="p-4 bg-white rounded-lg shadow-lg">
      <h3 class="mb-2 text-lg font-bold">Card 10</h3>
      <p class="text-gray-600">This is a description for card 07.</p>
      <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
    </div>

    <!-- Card 7 -->
    <div class="p-4 bg-white rounded-lg shadow-lg">
      <h3 class="mb-2 text-lg font-bold">Card 11</h3>
      <p class="text-gray-600">This is a description for card 07.</p>
      <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
    </div>

    <!-- Card 7 -->
    <div class="p-4 bg-white rounded-lg shadow-lg">
      <h3 class="mb-2 text-lg font-bold">Card 12</h3>
      <p class="text-gray-600">This is a description for card 07.</p>
      <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Learn More</button>
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



