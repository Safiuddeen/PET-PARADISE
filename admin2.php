<?php
session_start();
include("connection.php");

// Check if the user is logged in
if (isset($_SESSION["username"])) {
    $user=($_SESSION["username"]);
} 
// Logout functionality
if (isset($_POST['logout'])) { 
    session_unset();  
    session_destroy();
    header("Location: login_Details.php");
    exit();
}

// Function to calculate the original price
function calculateOriginalPrice($price, $discount) {
    return round($price - $discount, 2);
}

// Initialize variables
$item_id = $item_name = $price = $discount = $original_price = $quantity = "";
$item_category = $pet_category = $description = "";
$item_image = NULL;
$search = "";
$result = null;

// **Insert Item**
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // **Add Item**
    if (isset($_POST["additem"])) {
        $item_name = $_POST["itemname"] ?? "";
        $price = $_POST["price"] ?? 0;
        $discount = $_POST["discount"] ?? 0;
        $original_price = calculateOriginalPrice($price, $discount);
        $quantity = $_POST["quantity"] ?? 0;
        $item_category = $_POST["item_category"] ?? "";
        $pet_category = $_POST["pet_category"] ?? "";
        $description = $_POST["description"] ?? "";

        // Handling image upload
        if (isset($_FILES["itemimage"]) && $_FILES["itemimage"]["size"] > 0) {
            $image_tmp = $_FILES["itemimage"]["tmp_name"];
            $item_image = file_get_contents($image_tmp); // Read binary data
        }

        // SQL Query to insert data
        $sql = "INSERT INTO item (item_name, price, discount, original_price, quantity, item_image, category, item_category, description)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdddibsss", $item_name, $price, $discount, $original_price, $quantity, $item_image, $pet_category, $item_category, $description);
        $stmt->send_long_data(5, $item_image);

        if ($stmt->execute()) {
            echo "<script>alert('Item added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding item: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }

    // **Update Item**
    if (isset($_POST["updateitem"])) {
        $item_id = $_POST["itemid"] ?? "";
        $item_name = $_POST["itemname"] ?? "";
        $price = $_POST["price"] ?? 0;
        $discount = $_POST["discount"] ?? 0;
        $original_price = calculateOriginalPrice($price, $discount);
        $quantity = $_POST["quantity"] ?? 0;
        $item_category = $_POST["item_category"] ?? "";
        $pet_category = $_POST["pet_category"] ?? "";
        $description = $_POST["description"] ?? "";

        $sql = "UPDATE item SET item_name=?, original_price=?, price=?, discount=?, quantity=?, category=?, item_category=?, description=? WHERE item_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddisssss", $item_name, $original_price, $price, $discount, $quantity, $pet_category, $item_category, $description, $item_id);

        if ($stmt->execute()) {
            echo "<script>alert('Item updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating item: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }

    // **Delete Item**
    if (isset($_POST["deleteitem"])) {
        $item_id = $_POST["itemid"] ?? "";

        $sql = "DELETE FROM item WHERE item_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $item_id);

        if ($stmt->execute()) {
            echo "<script>alert('Item deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error deleting item: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }

    // **Search Item**
    if (isset($_POST["searchitem"])) {
        $search = $_POST["search"] ?? "";
        $sql = "SELECT * FROM item WHERE item_id LIKE ? OR item_name LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = "%$search%";
        $stmt->bind_param("ss", $search_param, $search_param);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}

$conn->close();
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
        <!-- User Info -->
        <div class="w-full h-1 border-t-4 border-black"></div>
        
        <div class="flex flex-col items-center mt-6 space-y-4">
            <p class="text-lg font-semibold"><?php echo $user; ?> </p>
        </div>
        
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
        <h3 class="mb-4 text-lg font-bold">Inventory</h3>
        <ul class="space-y-2 text-center">
            <li>
                <a onclick="window.location.href='managerlogin.php'" class="cursor-pointer ">
                <img src="image/inventory.png" alt="Inventory" class="w-16 h-16 mx-auto">
                Inventory
                </a>
            </li>
        </ul>
    </div>


        <div class="w-full h-1 border-t-4 border-black"></div>

        <!-- Logout Button -->
        <div class="mt-auto">
            <form action="" method="POST">
                <button type="submit"  name="logout" class="flex items-center mb-auto space-x-1 hover:text-gray-200">
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
            <div id="welcome" class="content-section">
                <h1 class="text-3xl font-bold text-center">Welcome to Admin Dashboard</h1>
                <h2 class="mt-4 text-2xl text-center">PetParadise</h2>
                <p class="mt-6 text-lg text-center">
                    
                </p>
                <!-- Pre-Orders Table -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-center">Pre-Orders</h3>
                    <table class="w-full mt-4 border border-collapse border-gray-300 table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border border-gray-300">Order ID</th>
                                <th class="px-4 py-2 border border-gray-300">Order Image</th>
                                <th class="px-4 py-2 border border-gray-300">Order Item</th>
                                <th class="px-4 py-2 border border-gray-300">Required Quantity</th>
                                <th class="px-4 py-2 border border-gray-300">Available Quantity</th>
                                <th class="px-4 py-2 border border-gray-300">Customer Address</th>
                                <th class="px-4 py-2 border border-gray-300">Price</th>
                                <th class="px-4 py-2 border border-gray-300">Payment Status</th>
                                <th class="px-4 py-2 border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td class="px-4 py-2 border border-gray-300">#1001</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <img src="https://via.placeholder.com/50" alt="Order Image" class="w-12 h-12 mx-auto">
                                </td>
                                <td class="px-4 py-2 border border-gray-300">Dog Food</td>
                                <td class="px-4 py-2 border border-gray-300">10</td>
                                <td class="px-4 py-2 border border-gray-300">8</td>
                                <td class="px-4 py-2 border border-gray-300">123 Pet Street, Colombo</td>
                                <td class="px-4 py-2 border border-gray-300">Rs. 4500</td>
                                <td class="px-4 py-2 border border-gray-300">Paid</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <button class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600">Deliver</button>
                                    <button class="px-3 py-1 mt-2 text-white bg-red-500 rounded hover:bg-red-600">Cancel</button>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td class="px-4 py-2 border border-gray-300">#1001</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <img src="https://via.placeholder.com/50" alt="Order Image" class="w-12 h-12 mx-auto">
                                </td>
                                <td class="px-4 py-2 border border-gray-300">Cat Toy</td>
                                <td class="px-4 py-2 border border-gray-300">5</td>
                                <td class="px-4 py-2 border border-gray-300">5</td>
                                <td class="px-4 py-2 border border-gray-300">456 Kitty Lane, Kandy</td>
                                <td class="px-4 py-2 border border-gray-300">Rs. 1500</td>
                                <td class="px-4 py-2 border border-gray-300">Pending</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <button class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600">Deliver</button>
                                    <button class="px-3 py-1 mt-2 text-white bg-red-500 rounded hover:bg-red-600">Cancel</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Order History Table -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-center">Order History</h3>
                    <table class="w-full mt-4 border border-collapse border-gray-300 table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border border-gray-300">Order ID</th>
                                <th class="px-4 py-2 border border-gray-300">Order Item</th>
                                <th class="px-4 py-2 border border-gray-300">Quantity</th>
                                <th class="px-4 py-2 border border-gray-300">Price</th>
                                <th class="px-4 py-2 border border-gray-300">Order Date</th>
                                <th class="px-4 py-2 border border-gray-300">Delivery Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td class="px-4 py-2 border border-gray-300">#1001</td>
                                <td class="px-4 py-2 border border-gray-300">Dog Leash</td>
                                <td class="px-4 py-2 border border-gray-300">1</td>
                                <td class="px-4 py-2 border border-gray-300">Rs. 1000</td>
                                <td class="px-4 py-2 border border-gray-300">2025-01-01</td>
                                <td class="px-4 py-2 border border-gray-300">Delivered</td>
                            </tr>
                            <tr class="text-center">
                                <td class="px-4 py-2 border border-gray-300">#1002</td>
                                <td class="px-4 py-2 border border-gray-300">Bird Cage</td>
                                <td class="px-4 py-2 border border-gray-300">2</td>
                                <td class="px-4 py-2 border border-gray-300">Rs. 4500</td>
                                <td class="px-4 py-2 border border-gray-300">2025-01-05</td>
                                <td class="px-4 py-2 border border-gray-300">Cancelled</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>  
        

        <!-- Category-Specific Content -->
        <!-- DOG -->
        <div id="dog" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Dog Items</h1>
            <p class="mb-6 text-center">Details about dogs and related items go here.</p>

            <form class="max-w-3xl px-8 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md" action="" method="POST">
                <!-- Search Bar -->
                <div class="flex items-center justify-between mb-6">
                    <input class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" placeholder="Search for items..."name="search"/>
                    <button class="px-4 py-2 ml-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit"name="searchitem">
                        Search
                    </button>
                </div>

                <p class="mb-4 text-lg font-bold text-center">Add Dog Items</p>

                <!-- Item ID Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemid">Item ID:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemid" placeholder="Item ID" readonly/>
                </div>

                <!-- Item Name Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemname">Item Name:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemname" placeholder="Item Name"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="price">Price:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="price" placeholder="0000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="discount">Discount:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"  type="text"  name="discount" placeholder="00000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="quantity">Quantity:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="quantity" placeholder="Quantity"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemimage">Item Image:</label>
                    <input class="w-full px-3 py-2 text-gray-700" type="file" name="itemimage" accept="image/*" onchange="previewImage(event)" required/>
                    <img id="preview" src="#" alt="Image preview" class="hidden max-w-xs mx-auto mt-4"/>
                </div>


                <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-gray-700" for="pet_category">Pet Category:</label>
                    <select class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="pet_category">
                    <option value="">Select Pet Category</option>
                    <option value="Dogs">Dogs</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="item_category">Item Category:</label>
                    <select class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="item_category">
                        <option value="" disabled selected>Select Item Category</option>
                        <option value="Food">Food</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Health & Wellness">Health & Wellness</option>
                        <option value="Housing">Housing</option>
                        <option value="Specialty Items">Specialty Items</option>
                    </select>
                </div>


                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description:</label>
                    <textarea class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="description" id="description" rows="5" placeholder="Enter item description here"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between">
        <button class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline" type="submit" name="additem">
            Add Item
        </button>
        <button class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700 focus:outline-none focus:shadow-outline" type="submit" name="updateitem">
            Update Item
        </button>
        <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline" type="submit" name="deleteitem">
            Delete Item
        </button>
    </div>
            </form>
            <br>
            <br>
            <div class="mt-8">
    <h3 class="text-xl font-bold">View all items</h3>
    <table class="w-full mt-4 border border-collapse border-black table-auto">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 border border-black">Item ID</th>
                <th class="px-4 py-2 border border-black">Item Name</th>  
                <th class="px-4 py-2 border border-black">Price</th>
                <th class="px-4 py-2 border border-black">Discount</th>
                <th class="px-4 py-2 border border-black">Actual Price</th>
                <th class="px-4 py-2 border border-black">Quantity</th>
                <th class="px-4 py-2 border border-black">Item Image</th>
                <th class="px-4 py-2 border border-black">Item Category</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include "connection.php"; // Include database connection file

                // Fetch all items from the database
                $sql = "SELECT * FROM item WHERE category = 'Dogs'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='px-4 py-2 border border-black'>" . htmlspecialchars($row["item_id"]) . "</td>";
                        echo "<td class='px-4 py-2 border border-black'>" . htmlspecialchars($row["item_name"]) . "</td>";
                        echo "<td class='px-4 py-2 border border-black'>" . htmlspecialchars($row["price"]) . "</td>";
                        echo "<td class='px-4 py-2 border border-black'>" . htmlspecialchars($row["discount"]) . "</td>";
                        echo "<td class='px-4 py-2 border border-black'>" . htmlspecialchars($row["original_price"]) . "</td>";
                        echo "<td class='px-4 py-2 border border-black'>" . htmlspecialchars($row["quantity"]) . "</td>";

                        // Convert image to base64 for display
                        if (!empty($row["item_image"])) {
                            $imageData = base64_encode($row["item_image"]);
                            echo "<td class='px-4 py-2 border border-black'><img src='data:image/jpeg;base64, $imageData' class='object-cover w-16 h-16'/></td>";
                        } else {
                            echo "<td class='px-4 py-2 text-center border border-black'>No Image</td>";
                        }
                        echo "<td class='px-4 py-2 border border-black'>" . htmlspecialchars($row["category"]) . "</td>";
                        echo "</tr>";
                        }
                        } else {
                            echo "<tr><td colspan='7' class='px-4 py-2 text-center border border-black'>No items found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        
            <br><br><br><br>
        </div>

        <!-- CAT -->
        <div id="cat" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Cat Items</h1>
            <p class="mb-6 text-center">Details about cat and related items go here.</p>

            <form class="max-w-3xl px-8 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md" action="" method="post" enctype="multipart/form-data">
                <!-- Search Bar -->
                <div class="flex items-center justify-between mb-6">
                    <input class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" placeholder="Search for items..."name="search"/>
                    <button class="px-4 py-2 ml-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit"name="searchitem">
                        Search
                    </button>
                </div>

                <p class="mb-4 text-lg font-bold text-center">Add Cat Items</p>

                <!-- Item ID Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemid">Item ID:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemid" placeholder="Item ID" readonly/>
                </div>

                <!-- Item Name Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemname">Item Name:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemname" placeholder="Item Name"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="price">Price:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="price" placeholder="0000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="discount">Discount:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"  type="text"  name="discount" placeholder="00000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="quantity">Quantity:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="quantity" placeholder="Quantity"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemimage">Item Image:</label>
                    <input class="w-full px-3 py-2 text-gray-700" type="file" name="itemimage" accept="image/*" onchange="previewImage(event)"/>
                    <img id="preview" src="#" alt="Image preview" class="hidden max-w-xs mx-auto mt-4"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="pet_category">Pet Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="pet_category" placeholder="Pet Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="item_category">Item Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="item_category" placeholder="Item Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description:</label>
                    <textarea class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="description" id="description" rows="5" placeholder="Enter item description here"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <button class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline" type="submit" name="additem">
                        Add Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700 focus:outline-none focus:shadow-outline" type="submit" name="updateitem">
                        Update Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline" type="submit" name="deleteitem">
                        Delete Item
                    </button>
                </div>
            </form>
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

            <form class="max-w-3xl px-8 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md" action="" method="post" enctype="multipart/form-data">
                <!-- Search Bar -->
                <div class="flex items-center justify-between mb-6">
                    <input class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" placeholder="Search for items..."name="search"/>
                    <button class="px-4 py-2 ml-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit"name="searchitem">
                        Search
                    </button>
                </div>

                <p class="mb-4 text-lg font-bold text-center">Add Bird Items</p>

                <!-- Item ID Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemid">Item ID:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemid" placeholder="Item ID" readonly/>
                </div>

                <!-- Item Name Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemname">Item Name:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemname" placeholder="Item Name"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="price">Price:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="price" placeholder="0000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="discount">Discount:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"  type="text"  name="discount" placeholder="00000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="quantity">Quantity:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="quantity" placeholder="Quantity"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemimage">Item Image:</label>
                    <input class="w-full px-3 py-2 text-gray-700" type="file" name="itemimage" accept="image/*" onchange="previewImage(event)"/>
                    <img id="preview" src="#" alt="Image preview" class="hidden max-w-xs mx-auto mt-4"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="pet_category">Pet Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="pet_category" placeholder="Pet Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="item_category">Item Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="item_category" placeholder="Item Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description:</label>
                    <textarea class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="description" id="description" rows="5" placeholder="Enter item description here"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <button class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline" type="submit" name="additem">
                        Add Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700 focus:outline-none focus:shadow-outline" type="submit" name="updateitem">
                        Update Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline" type="submit" name="deleteitem">
                        Delete Item
                    </button>
                </div>
            </form>
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

            <form class="max-w-3xl px-8 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md" action="" method="post" enctype="multipart/form-data">
                <!-- Search Bar -->
                <div class="flex items-center justify-between mb-6">
                    <input class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" placeholder="Search for items..."name="search"/>
                    <button class="px-4 py-2 ml-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit"name="searchitem">
                        Search
                    </button>
                </div>

                <p class="mb-4 text-lg font-bold text-center">Add Rabbit Items</p>

                <!-- Item ID Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemid">Item ID:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemid" placeholder="Item ID" readonly/>
                </div>

                <!-- Item Name Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemname">Item Name:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemname" placeholder="Item Name"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="price">Price:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="price" placeholder="0000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="discount">Discount:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"  type="text"  name="discount" placeholder="00000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="quantity">Quantity:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="quantity" placeholder="Quantity"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemimage">Item Image:</label>
                    <input class="w-full px-3 py-2 text-gray-700" type="file" name="itemimage" accept="image/*" onchange="previewImage(event)"/>
                    <img id="preview" src="#" alt="Image preview" class="hidden max-w-xs mx-auto mt-4"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="pet_category">Pet Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="pet_category" placeholder="Pet Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="item_category">Item Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="item_category" placeholder="Item Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description:</label>
                    <textarea class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="description" id="description" rows="5" placeholder="Enter item description here"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <button class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline" type="submit" name="additem">
                        Add Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700 focus:outline-none focus:shadow-outline" type="submit" name="updateitem">
                        Update Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline" type="submit" name="deleteitem">
                        Delete Item
                    </button>
                </div>
            </form>
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

            <form class="max-w-3xl px-8 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md" action="" method="post" enctype="multipart/form-data">
                <!-- Search Bar -->
                <div class="flex items-center justify-between mb-6">
                    <input class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" placeholder="Search for items..."name="search"/>
                    <button class="px-4 py-2 ml-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit"name="searchitem">
                        Search
                    </button>
                </div>

                <p class="mb-4 text-lg font-bold text-center">Add Fish Items</p>

                <!-- Item ID Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemid">Item ID:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemid" placeholder="Item ID" readonly/>
                </div>

                <!-- Item Name Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemname">Item Name:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemname" placeholder="Item Name"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="price">Price:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="price" placeholder="0000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="discount">Discount:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"  type="text"  name="discount" placeholder="00000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="quantity">Quantity:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="quantity" placeholder="Quantity"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemimage">Item Image:</label>
                    <input class="w-full px-3 py-2 text-gray-700" type="file" name="itemimage" accept="image/*" onchange="previewImage(event)"/>
                    <img id="preview" src="#" alt="Image preview" class="hidden max-w-xs mx-auto mt-4"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="pet_category">Pet Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="pet_category" placeholder="Pet Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="item_category">Item Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="item_category" placeholder="Item Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description:</label>
                    <textarea class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="description" id="description" rows="5" placeholder="Enter item description here"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <button class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline" type="submit" name="additem">
                        Add Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700 focus:outline-none focus:shadow-outline" type="submit" name="updateitem">
                        Update Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline" type="submit" name="deleteitem">
                        Delete Item
                    </button>
                </div>
            </form>
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

            <form class="max-w-3xl px-8 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md" action="" method="post" enctype="multipart/form-data">
                <!-- Search Bar -->
                <div class="flex items-center justify-between mb-6">
                    <input class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" placeholder="Search for items..."name="search"/>
                    <button class="px-4 py-2 ml-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit"name="searchitem">
                        Search
                    </button>
                </div>

                <p class="mb-4 text-lg font-bold text-center">Add Farm-Animal Items</p>

                <!-- Item ID Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemid">Item ID:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemid" placeholder="Item ID" readonly/>
                </div>

                <!-- Item Name Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemname">Item Name:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemname" placeholder="Item Name"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="price">Price:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="price" placeholder="0000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="discount">Discount:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"  type="text"  name="discount" placeholder="00000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="quantity">Quantity:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="quantity" placeholder="Quantity"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemimage">Item Image:</label>
                    <input class="w-full px-3 py-2 text-gray-700" type="file" name="itemimage" accept="image/*" onchange="previewImage(event)"/>
                    <img id="preview" src="#" alt="Image preview" class="hidden max-w-xs mx-auto mt-4"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="pet_category">Pet Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="pet_category" placeholder="Pet Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="item_category">Item Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="item_category" placeholder="Item Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description:</label>
                    <textarea class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="description" id="description" rows="5" placeholder="Enter item description here"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <button class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline" type="submit" name="additem">
                        Add Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700 focus:outline-none focus:shadow-outline" type="submit" name="updateitem">
                        Update Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline" type="submit" name="deleteitem">
                        Delete Item
                    </button>
                </div>
            </form>
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
            
            <form class="max-w-3xl px-8 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md" action="" method="post" enctype="multipart/form-data">
                <!-- Search Bar -->
                <div class="flex items-center justify-between mb-6">
                    <input class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" placeholder="Search for items..."name="search"/>
                    <button class="px-4 py-2 ml-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit"name="searchitem">
                        Search
                    </button>
                </div>

                <p class="mb-4 text-lg font-bold text-center">Add Hourse Items</p>

                <!-- Item ID Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemid">Item ID:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemid" placeholder="Item ID" readonly/>
                </div>

                <!-- Item Name Field -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemname">Item Name:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="itemname" placeholder="Item Name"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="price">Price:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="price" placeholder="0000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="discount">Discount:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"  type="text"  name="discount" placeholder="00000.00/="/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="quantity">Quantity:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="quantity" placeholder="Quantity"/>
                </div>

                <div class="mb-4">
    <label class="block mb-2 text-sm font-bold text-gray-700" for="itemimage">Item Image:</label>
    <input
        class="w-full px-3 py-2 text-gray-700"
        type="file"
        name="itemimage"
        accept="image/*"
        onchange="previewImage(event)"
    />
    <span id="file-label" class="text-sm text-gray-500">No file chosen</span>
    <!-- Image preview -->
    <img
        id="preview"
        src="#"
        alt="Image preview"
        class="hidden max-w-xs mx-auto mt-4 border border-gray-300 rounded shadow"
    />
    <!-- Remove Button -->
    <button
        id="remove-button"
        onclick="removeImage()"
        type="button"
        class="hidden px-4 py-2 mt-2 text-sm text-white bg-red-500 rounded shadow hover:bg-red-600"
    >
        Remove Image
    </button>
</div>


               
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="pet_category">Pet Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="pet_category" placeholder="Pet Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="item_category">Item Category:</label>
                    <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="item_category" placeholder="Item Category"/>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description:</label>
                    <textarea class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="description" id="description" rows="5" placeholder="Enter item description here"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <button class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline" type="submit" name="additem">
                        Add Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700 focus:outline-none focus:shadow-outline" type="submit" name="updateitem">
                        Update Item
                    </button>
                    <button class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline" type="submit" name="deleteitem">
                        Delete Item
                    </button>
                </div>
            </form>
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

function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var img = document.getElementById("preview");
        img.src = reader.result;
        img.classList.remove("hidden"); // Make image visible
    };
    reader.readAsDataURL(event.target.files[0]);
}





    
</script>

</body>
</html>
