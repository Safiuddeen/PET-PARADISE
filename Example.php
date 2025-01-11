<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Inline Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="p-4 bg-blue-600">
        <div class="container flex items-center justify-between mx-auto">
            <h1 class="text-xl font-bold text-white">PetParadise</h1>
            <ul class="flex space-x-6 text-white">
                <li><a href="#" class="hover:underline">Home</a></li>
                <li><a href="#" class="hover:underline">About</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Categories Inline -->
    <div class="p-4 bg-gray-200">
        <div class="container flex justify-center mx-auto space-x-6">
            <a href="#" class="text-blue-600 hover:underline">Food</a>
            <a href="#" class="text-blue-600 hover:underline">Accessories</a>
            <a href="#" class="text-blue-600 hover:underline">Health & Wellness</a>
            <a href="#" class="text-blue-600 hover:underline">Housing</a>
            <a href="#" class="text-blue-600 hover:underline">Specialty Items</a>
        </div>
    </div>

    <!-- Optional Content Below -->
    <div class="container mx-auto mt-8">
        <p class="text-center text-gray-600">Additional content can go here.</p>
    </div>
</body>
</html>
