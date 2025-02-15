<?php
session_start();

require_once 'config/connection.php'; //Database connection file

$db = new Database(); // Create Database class
$conn = $db->getConnection();


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


// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize variables
$item_name = $price = $discount = $quantity = $item_category = $pet_category = $description = "";
$item_nameErr = $priceErr = $discountErr = $quantityErr = $item_categoryErr = $pet_categoryErr = $uploadErr = "";
$uploadSuccess = "";
$valid = true;
$item_id = "";
$item_image = "";

// Handle search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchitem"])) {

     // Validate and sanitize item name
     if (empty($_POST["search_name"])) {
        $item_nameErr = "Search Name is required";
        $valid = false;
    } else {
        $search_name = test_input($_POST["search_name"]);
    }
    if($valid){
    $sql = "SELECT * FROM item WHERE (item_name LIKE ? OR item_id LIKE ?)";  
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search_name . "%";  // Assuming $search_name contains input
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        // Populate the form with the item details
        $item_id = $item['item_id'];
        $item_name = $item['item_name'];
        $price = $item['price'];
        $discount = $item['discount'];
        $quantity = $item['quantity'];
        $item_image = $item['item_image'];
        $pet_category = $item['pet_category'];
        $item_category = $item['item_category'];
        $description = $item['description'];
        
    } else {
        $uploadErr = "No item found with that name.";
    }
    $stmt->close();
}
}

//handle the insert data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["additem"])) {
    
    // Validate and sanitize item name
    if (empty($_POST["itemname"])) {
        $item_nameErr = "Name is required";
        $valid = false;
    } else {
        $item_name = test_input($_POST["itemname"]);
    }
    
    // Validate price
    if (empty($_POST["price"])) {
        $priceErr = "Price is required";
        $valid = false;
    } else {
        $price = test_input($_POST["price"]);
        if (!is_numeric($price)) {
            $priceErr = "Price must be a number";
            $valid = false;
        }
    }
    
    // Validate discount (optional; default to 0)
    if (empty($_POST["discount"])) {
        $discount = 0;
    } else {
        $discount = test_input($_POST["discount"]);
        if (!is_numeric($discount)) {
            $discountErr = "Discount must be a number";
            $valid = false;
        }
    }
    
    // Validate quantity
    if (empty($_POST["quantity"])) {
        $quantityErr = "Quantity is required";
        $valid = false;
    } else {
        $quantity = test_input($_POST["quantity"]);
        if (!is_numeric($quantity)) {
            $quantityErr = "Quantity must be a number";
            $valid = false;
        }
    }
    
    // Validate item category
    if (empty($_POST["item_category"])) {
        $item_categoryErr = "Item Category is required";
        $valid = false;
    } else {
        $item_category = test_input($_POST["item_category"]);
    }
    
    // Validate pet category
    if (empty($_POST["pet_category"])) {
        $pet_categoryErr = "Pet Category is required";
        $valid = false;
    } else {
        $pet_category = test_input($_POST["pet_category"]);
    }
    
    // Description (optional)
    if (empty($_POST["description"])) {
        $description = "";
    } else {
        $description = test_input($_POST["description"]);
    }
    
    // Process image file upload
    if (isset($_FILES["itemimage"]) && $_FILES["itemimage"]["size"] > 0) {
        $image_tmp = $_FILES["itemimage"]["tmp_name"];
        $item_image = file_get_contents($image_tmp); // Read binary data
    } else {
        $uploadErr = "Please upload an image.";
        $valid = false;
    }
    
    // If all validations pass, insert the data into the database
    if ($valid) {
        $original_price = $price - $discount; // Calculate original price
        
        $sql = "INSERT INTO item (item_name, price, discount, original_price, quantity, item_image, pet_category, item_category, description)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        // Use $null as placeholder for blob data in bind_param; send_long_data will fill it in.
        $null = NULL;
        $stmt->bind_param("sdddibsss", $item_name, $price, $discount, $original_price, $quantity, $null, $pet_category, $item_category, $description);
        $stmt->send_long_data(5, $item_image);
        
        if ($stmt->execute()) {
            $uploadSuccess = "Item uploaded successfully!";
            $item_name = $price = $discount = $quantity = $item_category = $pet_category = $description = "";
            $item_image = "";
        } else {
            $uploadErr = "Upload failed: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle item update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateitem"])) {
    // Validate inputs (same as for additem)
    if (empty($_POST["itemname"])) {
        $item_nameErr = "Name is required";
        $valid = false;
    } else {
        $item_name = test_input($_POST["itemname"]);
    }

    if (empty($_POST["price"])) {
        $priceErr = "Price is required";
        $valid = false;
    } else {
        $price = test_input($_POST["price"]);
        if (!is_numeric($price)) {
            $priceErr = "Price must be a number";
            $valid = false;
        }
    }

    $discount = empty($_POST["discount"]) ? 0 : test_input($_POST["discount"]);
    if (!is_numeric($discount)) {
        $discountErr = "Discount must be a number";
        $valid = false;
    }

    if (empty($_POST["quantity"])) {
        $quantityErr = "Quantity is required";
        $valid = false;
    } else {
        $quantity = test_input($_POST["quantity"]);
        if (!is_numeric($quantity)) {
            $quantityErr = "Quantity must be a number";
            $valid = false;
        }
    }

    if (empty($_POST["item_category"])) {
        $item_categoryErr = "Item Category is required";
        $valid = false;
    } else {
        $item_category = test_input($_POST["item_category"]);
    }

    if (empty($_POST["pet_category"])) {
        $pet_categoryErr = "Pet Category is required";
        $valid = false;
    } else {
        $pet_category = test_input($_POST["pet_category"]);
    }

    $description = empty($_POST["description"]) ? "" : test_input($_POST["description"]);

    // Check if a new image was uploaded
    if (isset($_FILES["itemimage"]) && $_FILES["itemimage"]["size"] > 0) {
        $image_tmp = $_FILES["itemimage"]["tmp_name"];
        $item_image = file_get_contents($image_tmp);
    }

    if ($valid) {
        $original_price = $price - $discount;

        if (!empty($item_image)) {
            // If new image is uploaded, update with image
            $sql = "UPDATE item SET item_name=?, price=?, discount=?, original_price=?, quantity=?, item_image=?, category=?, item_category=?, description=? WHERE item_name=?";
            $stmt = $conn->prepare($sql);
            $null = NULL;
            $stmt->bind_param("sdddibssss", $item_name, $price, $discount, $original_price, $quantity, $null, $pet_category, $item_category, $description, $item_name);
            $stmt->send_long_data(5, $item_image);
        } else {
            // If no new image is uploaded, keep the existing image
            $sql = "UPDATE item SET item_name=?, price=?, discount=?, original_price=?, quantity=?, pet_category=?, item_category=?, description=? WHERE item_name=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdddissss", $item_name, $price, $discount, $original_price, $quantity, $pet_category, $item_category, $description, $item_name);
        }

        if ($stmt->execute()) {
            $uploadSuccess = "Item updated successfully!";
            
            $item_name = $price = $discount = $quantity = $item_category = $pet_category = $description = "";
            $item_image = "";
            
        } else {
            $uploadErr = "Update failed: " . $stmt->error;
        }

        $stmt->close();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteitem"])) {
    if (!empty($_POST["itemid"])) {  
        $item_id = $_POST["itemid"];  // Get item_id from form
        $sql = "DELETE FROM item WHERE item_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $item_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Item deleted successfully!'); window.location.href='admin2.php#Data';</script>";
            $item_id = $item_name = $price = $discount = $quantity = $item_category = $pet_category = $description = "";
            $item_image = "";
        } else {
            echo "<script>alert('Error deleting item!');</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('No item selected for deletion!');</script>";
    }
}


// Fetch all items from the database to display in table
$sql = "SELECT * FROM item ";
$result = $conn->query($sql);

// Fetch all items from the database to display in table
$sqlDog = "SELECT * FROM item WHERE pet_category='Dogs'";
$resultDog = $conn->query($sqlDog);

$sqlBird = "SELECT * FROM item WHERE pet_category='Bird'";
$resultBird = $conn->query($sqlBird);

$sqlCat = "SELECT * FROM item WHERE pet_category='Cat'";
$resultCat = $conn->query($sqlCat);

$sqlRabbit = "SELECT * FROM item WHERE pet_category='Rabbit'";
$resultRabbit = $conn->query($sqlRabbit);

$sqlFA = "SELECT * FROM item WHERE pet_category='FarmAnimal'";
$resultFA = $conn->query($sqlFA);

$sqlFish = "SELECT * FROM item WHERE pet_category='Fish'";
$resultFish = $conn->query($sqlFish);

$sqlHorse = "SELECT * FROM item WHERE pet_category='Horse'";
$resultHorse = $conn->query($sqlHorse);

$sqlorders = "SELECT * FROM orders";
$resultorders = $conn->query($sqlorders);

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
    <!-- Include jsPDF Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
            <h3 class="mb-4 text-lg font-bold">Data managing</h3>
            <ul class="space-y-2 text-center">
                <li>
                    <a onclick="showContent('Data-section')" class="cursor-pointer ">
                    <img src="image/data.png" alt="" class="w-16 h-16 mx-auto">
                    Control Data
                    </a>
                </li>
            </ul>
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
                <li><button onclick="showContent('farm_animal')" class="hover:underline">Farm Animals</button></li>
                <li><button onclick="showContent('horse')" class="hover:underline">Horse</button></li>
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
                <div class="flex justify-end">
                    <button class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700" id="downloadBtn">
                        Download pre-order Report
                    </button>
                </div>
                <!-- Pre-Orders Table -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-center">Pre-Orders</h3>
                    <table class="w-full mt-4 border border-collapse border-gray-300 table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border border-gray-300">Order ID</th>
                                <th class="px-4 py-2 border border-gray-300">Customer ID</th>
                                <th class="px-4 py-2 border border-gray-300">Item ID</th>
                                <th class="px-4 py-2 border border-gray-300">Required Quntity</th>
                                <th class="px-4 py-2 border border-gray-300">Conatact</th>
                                <th class="px-4 py-2 border border-gray-300">Shipping Address</th>
                                <th class="px-4 py-2 border border-gray-300">State</th>
                                <th class="px-4 py-2 border border-gray-300">City</th>
                                <th class="px-4 py-2 border border-gray-300">Postal Code</th>
                                <th class="px-4 py-2 border border-gray-300">Order date</th>
                                <th class="px-4 py-2 border border-gray-300">Payment Status</th>
                                <th class="px-4 py-2 border border-gray-300">Actions</th>
                            </tr>
                            </thead>
                        <tbody>
                            <?php
                                if ($resultorders->num_rows > 0) {
                                    while($orders = $resultorders->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $orders['order_id']; ?></td>
                                            <td class="border border-black"><?php echo $orders['customer_ID']; ?></td>
                                            <td class="border border-black"><?php echo $orders['item_id']; ?></td>
                                            <td class="border border-black"><?php echo $orders['required_quantity']; ?></td>
                                            <td class="border border-black"><?php echo $orders['contact_number']; ?></td>
                                            <td class="border border-black"><?php echo $orders['shipping_address']; ?></td>
                                            <td class="border border-black"><?php echo $orders['state']; ?></td>
                                            <td class="border border-black"><?php echo $orders['city']; ?></td>
                                            <td class="border border-black"><?php echo $orders['postal_code']; ?></td>
                                            <td class="border border-black"><?php echo $orders['order_date']; ?></td>
                                            <td class="border border-black"><?php echo $orders['payment_status']; ?></td>
                                            
                                            
                                            <td class="border border-black">
                                                <!-- Deliver Order Button -->
                                                <button class="px-3 py-1 mb-2 mr-2 text-white bg-green-500 rounded hover:bg-green-700" onclick="deliverOrder(<?php echo $orders['order_id']; ?>)">
                                                    Deliver Order
                                                </button>

                                                <!-- Cancel Order Button -->
                                                <button class="px-3 py-1 text-white bg-red-500 rounded hover:bg-red-700" onclick="cancelOrder(<?php echo $orders['order_id']; ?>)">
                                                    Cancel Order
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            <br><br><br><br>
        

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
                            
                        </tbody>
                    </table>
                </div>
            </div>  
        

        <!-- Category-Specific Content -->
        <!-- DOG -->
        <div id="Data-section" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Data Control</h1>
            <p class="mb-6 text-center">Details about animal data managing please go a head.</p>
            
            <form action="" method="POST">
                <div class="flex items-center justify-between mb-3">
                <input type="text" name="search_name" id="search_name" placeholder="Search only dog items..." class="w-2/3 px-3 py-2 border rounded ml-28 ">
                <button type="submit" name="searchitem" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-800 mr-28">Search</button>
                </div>  
            </form>   

            <form action=" " method="POST" enctype="multipart/form-data" class="max-w-3xl px-8 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md">
                
                <p class="mb-4 text-lg font-bold text-center">Search / Add / Update / Delete all animal Items</p>
                <?php
                    
                    if (!empty($uploadSuccess)) {
                    echo "<p style='color:green;'>$uploadSuccess</p>";
                    }
                    if (!empty($item_nameErr) || !empty($priceErr) || !empty($quantityErr) || !empty($item_categoryErr) || !empty($pet_categoryErr) || !empty($uploadErr)) {
                    echo "<p style='color:red;'>";
                    echo $item_nameErr . " " . $priceErr . " " . $quantityErr . " " . $item_categoryErr . " " . $pet_categoryErr . " " . $uploadErr;
                    echo "</p>";
                    }
                ?>
                <!-- Item ID Field (Read-Only, if auto-generated by trigger) -->
                <div class="mb-4">
                <label for="itemid" class="block mb-2 text-sm font-bold">Item ID:</label>
                <input type="text" name="itemid" value="<?php echo $item_id; ?>" placeholder="Item ID" readonly class="w-full px-3 py-2 border rounded">
                </div>
                
                <!-- Item Name Field -->
                <div class="mb-4">
                <label for="itemname" class="block mb-2 text-sm font-bold">Item Name:</label>
                <input type="text" name="itemname" value="<?php echo $item_name; ?>" placeholder="Item Name" required class="w-full px-3 py-2 border rounded">
                </div>
                
                <!-- Price Field -->
                <div class="mb-4">
                <label for="price" class="block mb-2 text-sm font-bold">Price:</label>
                <input type="number" name="price" value="<?php echo $price; ?>" step="0.01" placeholder="0000.00" required class="w-full px-3 py-2 border rounded">
                </div>
                
                <!-- Discount Field -->
                <div class="mb-4">
                <label for="discount" class="block mb-2 text-sm font-bold">Discount:</label>
                <input type="number" name="discount" value="<?php echo $discount; ?>" step="0.01" placeholder="0000.00" class="w-full px-3 py-2 border rounded">
                </div>
                
                <!-- Quantity Field -->
                <div class="mb-4">
                <label for="quantity" class="block mb-2 text-sm font-bold">Quantity:</label>
                <input type="number" name="quantity" value="<?php echo $quantity; ?>" placeholder="Quantity" required class="w-full px-3 py-2 border rounded">
                </div>
                
                <!-- Item Image Field -->
                <div class="mb-4">
                <label for="itemimage" class="block mb-2 text-sm font-bold">Item Image:</label>
                <input type="file" name="itemimage" <?php echo empty($item_image) ? 'required' : ''; ?> class="w-full px-3 py-2 border rounded">
                <?php if (!empty($item_image)): ?>
                    <h3>Item Image</h3>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item_image); ?>" width="200"/>
                <?php endif; ?>
                </div>

                <!-- Pet-Category Field -->
                <div class="mb-4">
                    <label for="pet_category" class="block mb-2 text-sm font-bold">Pet Category:</label>
                    <select name="pet_category" required class="w-full px-3 py-2 border rounded">
                        <option value="" >Select Pet Category</option>
                        <option value="Dog" <?php if( $pet_category == "Dog") echo "selected"; ?>>Dog</option>
                        <option value="Cat" <?php if( $pet_category == "Cat") echo "selected"; ?>>Cat</option>
                        <option value="Bird" <?php if( $pet_category == "Bird") echo "selected"; ?>>Bird</option>
                        <option value="Rabbit" <?php if( $pet_category == "Rabbit") echo "selected"; ?>>Rabbit</option>
                        <option value="Fish" <?php if( $pet_category == "Fish") echo "selected"; ?>>Fish</option>
                        <option value="Horse" <?php if( $pet_category == "Horse") echo "selected"; ?>>Horse</option>
                        <option value="FarmAnimal" <?php if( $pet_category == "FarmAnimal") echo "selected"; ?>>FarmAnimal</option>
                    </select>
                </div>

                <!-- Item-Category Field -->
                <div class="mb-4">
                    <label for="item_category" class="block mb-2 text-sm font-bold">Item Category:</label>
                    <select name="item_category" required class="w-full px-3 py-2 border rounded">
                        <option value="" >Select Item Category</option>
                        <option value="Food" <?php if($item_category == "Food") echo "selected"; ?>>Food</option>
                        <option value="Accessories" <?php if($item_category == "Accessories") echo "selected"; ?>>Accessories</option>
                        <option value="Health and Wellness" <?php if($item_category == "Health and Wellness") echo "selected"; ?>>Health & Wellness</option>
                        <option value="Housing" <?php if($item_category == "Housing") echo "selected"; ?>>Housing</option>
                        <option value="Specialty Items" <?php if($item_category == "Specialty Items") echo "selected"; ?>>Specialty Items</option>
                    </select>
                </div>

                
                <!-- Description Field -->
                <div class="mb-4">
                    <label for="description" class="block mb-2 text-sm font-bold">Description:</label>
                    <textarea name="description" rows="5" placeholder="Enter item description here" class="w-full px-3 py-2 border rounded"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                <button type="submit" name="additem" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-800">Add Item</button>
                <button type="submit" name="updateitem" class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-800" onclick="return confirmupdate()">Update Item</button>
                <button type="submit" name="deleteitem" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-800" onclick="return confirmDelete()">Delete Item</button>
                </div>
            </form>
  
            <hr>
            <br>
            <br>
                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                                <th class="border border-black">Pet Category</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($result->num_rows > 0) {
                                    while($item = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $item['item_id']; ?></td>
                                            <td class="border border-black"><?php echo $item['item_name']; ?></td>
                                            <td class="border border-black"><?php echo $item['price']; ?></td>
                                            <td class="border border-black"><?php echo $item['discount']; ?></td>
                                            <td class="border border-black"><?php echo $item['quantity']; ?></td>
                                            <td class="border border-black">
                                                <?php if (!empty($item['item_image'])): ?>  
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['item_image']); ?>" width="100" />
                                                <?php else: ?>
                                                    No Image
                                                <?php endif; ?>
                                            </td>
                                            <td class="border border-black"><?php echo $item['item_category']; ?></td>
                                            <td class="border border-black"><?php echo $item['pet_category']; ?></td>
                                            
                                            
                                            <td class="border border-black"><Button class="px-1 py-2 text-white rounded bg-cyan-500 hover:bg-cyan-800"  onclick="openModal('<?php echo addslashes($item['item_name']); ?>', '<?php echo addslashes($item['item_category']); ?>', '<?php echo $item['price']; ?>', '<?php echo base64_encode($item['item_image']); ?>')">View</Button></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- DOG -->
        <div id="dog" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Dog Items</h1>
            <p class="mb-6 text-center">Details about dogs and related items go here.</p>
            
           
                <div class="mt-1">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                                <th class="border border-black">Pet Category</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($resultDog->num_rows > 0) {
                                    while($item = $resultDog->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $item['item_id']; ?></td>
                                            <td class="border border-black"><?php echo $item['item_name']; ?></td>
                                            <td class="border border-black"><?php echo $item['price']; ?></td>
                                            <td class="border border-black"><?php echo $item['discount']; ?></td>
                                            <td class="border border-black"><?php echo $item['quantity']; ?></td>
                                            <td class="border border-black">
                                                <?php if (!empty($item['item_image'])): ?>  
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['item_image']); ?>" width="100" />
                                                <?php else: ?>
                                                    No Image
                                                <?php endif; ?>
                                            </td>
                                            <td class="border border-black"><?php echo $item['item_category']; ?></td>
                                            <td class="border border-black"><?php echo $item['pet_category']; ?></td>
                                            
                                            <td class="border border-black"><a class="cursor-pointer" onclick="openModal('<?php echo addslashes($item['item_name']); ?>', '<?php echo addslashes($item['item_category']); ?>', '<?php echo $item['price']; ?>', '<?php echo base64_encode($item['item_image']); ?>')">View</a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- CAT -->
        <div id="cat" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">CAT Items</h1>
            <p class="mb-6 text-center">Details about CAT and related items go here.</p>
            
                <div class="mt-1">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                                <th class="border border-black">Pet Category</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($resultCat->num_rows > 0) {
                                    while($item = $resultCat->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $item['item_id']; ?></td>
                                            <td class="border border-black"><?php echo $item['item_name']; ?></td>
                                            <td class="border border-black"><?php echo $item['price']; ?></td>
                                            <td class="border border-black"><?php echo $item['discount']; ?></td>
                                            <td class="border border-black"><?php echo $item['quantity']; ?></td>
                                            <td>
                                                <?php if (!empty($item['item_image'])): ?>  
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['item_image']); ?>" width="100" />
                                                <?php else: ?>
                                                    No Image
                                                <?php endif; ?>
                                            </td>
                                            <td class="border border-black"><?php echo $item['item_category']; ?></td>
                                            <td class="border border-black"><?php echo $item['pet_category']; ?></td>
                                            
                                            <td class="border border-black"><a class="cursor-pointer" onclick="openModal('<?php echo addslashes($item['item_name']); ?>', '<?php echo addslashes($item['item_category']); ?>', '<?php echo $item['price']; ?>', '<?php echo base64_encode($item['item_image']); ?>')">View</a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- BIRD -->
        <div id="bird" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Bird Items</h1>
            <p class="mb-6 text-center">Details about bird and related items go here.</p>
                <div class="mt-1">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                                <th class="border border-black">Pet Category</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($resultBird->num_rows > 0) {
                                    while($item = $resultBird->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $item['item_id']; ?></td>
                                            <td class="border border-black"><?php echo $item['item_name']; ?></td>
                                            <td class="border border-black"><?php echo $item['price']; ?></td>
                                            <td class="border border-black"><?php echo $item['discount']; ?></td>
                                            <td class="border border-black"><?php echo $item['quantity']; ?></td>
                                            <td class="border border-black">
                                                <?php if (!empty($item['item_image'])): ?>  
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['item_image']); ?>" width="100" />
                                                <?php else: ?>
                                                    No Image
                                                <?php endif; ?>
                                            </td>
                                            <td class="border border-black"><?php echo $item['item_category']; ?></td>
                                            <td class="border border-black"><?php echo $item['pet_category']; ?></td>
                                            
                                            <td class="border border-black"><a class="cursor-pointer" onclick="openModal('<?php echo addslashes($item['item_name']); ?>', '<?php echo addslashes($item['item_category']); ?>', '<?php echo $item['price']; ?>', '<?php echo base64_encode($item['item_image']); ?>')">View</a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- RABBIT -->
        <div id="rabbit" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Rabbit Items</h1>
            <p class="mb-6 text-center">Details about Rabbit and related items go here.</p>

            <div class="mt-1">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                                <th class="border border-black">Pet Category</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($resultRabbit->num_rows > 0) {
                                    while($item = $resultRabbit->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $item['item_id']; ?></td>
                                            <td class="border border-black"><?php echo $item['item_name']; ?></td>
                                            <td class="border border-black"><?php echo $item['price']; ?></td>
                                            <td class="border border-black"><?php echo $item['discount']; ?></td>
                                            <td class="border border-black"><?php echo $item['quantity']; ?></td>
                                            <td class="border border-black">
                                                <?php if (!empty($item['item_image'])): ?>  
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['item_image']); ?>" width="100" />
                                                <?php else: ?>
                                                    No Image
                                                <?php endif; ?>
                                            </td>
                                            <td class="border border-black"><?php echo $item['item_category']; ?></td>
                                            <td class="border border-black"><?php echo $item['pet_category']; ?></td>
                                            
                                            <td class="border border-black"><a class="cursor-pointer" onclick="openModal('<?php echo addslashes($item['item_name']); ?>', '<?php echo addslashes($item['item_category']); ?>', '<?php echo $item['price']; ?>', '<?php echo base64_encode($item['item_image']); ?>')">View</a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- FISH -->
        <div id="fish" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Fish Items</h1>
            <p class="mb-6 text-center">Details about Fish and related items go here.</p>

            <div class="mt-1">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                                <th class="border border-black">Pet Category</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($resultFish->num_rows > 0) {
                                    while($item = $resultFish->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $item['item_id']; ?></td>
                                            <td><?php echo $item['item_name']; ?></td>
                                            <td><?php echo $item['price']; ?></td>
                                            <td><?php echo $item['discount']; ?></td>
                                            <td><?php echo $item['quantity']; ?></td>
                                            <td>
                                                <?php if (!empty($item['item_image'])): ?>  
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['item_image']); ?>" width="100" />
                                                <?php else: ?>
                                                    No Image
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $item['item_category']; ?></td>
                                            <td><?php echo $item['pet_category']; ?></td>
                                            
                                            <td><a class="cursor-pointer" onclick="openModal('<?php echo addslashes($item['item_name']); ?>', '<?php echo addslashes($item['item_category']); ?>', '<?php echo $item['price']; ?>', '<?php echo base64_encode($item['item_image']); ?>')">View</a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- Farm_animal -->
        <div id="farm_animal" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Farm Animal Items</h1>
            <p class="mb-6 text-center">Details about Farm Animal and related items go here.</p>

            <div class="mt-1">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                                <th class="border border-black">Pet Category</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($resultFA->num_rows > 0) {
                                    while($item = $resultFA->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $item['item_id']; ?></td>
                                            <td class="border border-black"><?php echo $item['item_name']; ?></td>
                                            <td class="border border-black"><?php echo $item['price']; ?></td>
                                            <td class="border border-black"><?php echo $item['discount']; ?></td>
                                            <td class="border border-black"><?php echo $item['quantity']; ?></td>
                                            <td class="border border-black">
                                                <?php if (!empty($item['item_image'])): ?>  
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['item_image']); ?>" width="100" />
                                                <?php else: ?>
                                                    No Image
                                                <?php endif; ?>
                                            </td>
                                            <td class="border border-black"><?php echo $item['item_category']; ?></td>
                                            <td class="border border-black"><?php echo $item['pet_category']; ?></td>
                                            
                                            <td class="border border-black"><a class="cursor-pointer" onclick="openModal('<?php echo addslashes($item['item_name']); ?>', '<?php echo addslashes($item['item_category']); ?>', '<?php echo $item['price']; ?>', '<?php echo base64_encode($item['item_image']); ?>')">View</a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            <br><br><br><br>
        </div>

        <!-- HORSE -->
        <div id="horse" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Horse Items</h1>
            <p class="mb-6 text-center">Details about Horse and related items go here.</p>

            <div class="mt-1">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Item ID</th>
                                <th class="border border-black">Item Name</th>
                                <th class="border border-black">Price</th>
                                <th class="border border-black">Discount</th>
                                <th class="border border-black">Quantity</th>
                                <th class="border border-black">Item Image</th>
                                <th class="border border-black">Item Category</th>
                                <th class="border border-black">Pet Category</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($resultHorse->num_rows > 0) {
                                    while($item = $resultHorse->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $item['item_id']; ?></td>
                                            <td class="border border-black"><?php echo $item['item_name']; ?></td>
                                            <td class="border border-black"><?php echo $item['price']; ?></td>
                                            <td class="border border-black"><?php echo $item['discount']; ?></td>
                                            <td class="border border-black"><?php echo $item['quantity']; ?></td>
                                            <td class="border border-black">
                                                <?php if (!empty($item['item_image'])): ?>  
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['item_image']); ?>" width="100" />
                                                <?php else: ?>
                                                    No Image
                                                <?php endif; ?>
                                            </td>
                                            <td class="border border-black"><?php echo $item['item_category']; ?></td>
                                            <td class="border border-black"><?php echo $item['pet_category']; ?></td>
                                            
                                            <td class="border border-black"><a class="cursor-pointer" onclick="openModal('<?php echo addslashes($item['item_name']); ?>', '<?php echo addslashes($item['item_category']); ?>', '<?php echo $item['price']; ?>', '<?php echo base64_encode($item['item_image']); ?>')">View</a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>            
            <br><br><br><br>
        </div>
        
    </div>
</div>


        <!-- Larger Item Modal -->
    <div id="itemModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-50">
        <div class="relative w-full max-w-lg mx-auto mt-20 bg-white rounded-lg shadow-lg">
            <button class="absolute text-gray-600 top-2 right-2 hover:text-red-900" onclick="closeModal()">✖</button>
            <img id="item_image" src="" alt="Modal Image" class="w-full h-48 rounded-t-lg"> 
            <div class="p-6">
                <h3 id="modalTitle" class="text-2xl font-bold"></h3>
                <p id="modalCategory" class="mt-2 text-gray-600"></p>
                <p id="modalPrice" class="mt-4 text-xl font-semibold text-gray-800"></p>
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

        // Function to open the item in larger display
        function openModal(title, category, price, image) {
            // Update modal with item details
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalCategory').textContent = `Category: ${category}`;
            document.getElementById('modalPrice').textContent = `Price: $${price}`;
            document.getElementById('item_image').src = 'data:image/jpeg;base64,' + image;  // Set the image in the modal
            document.getElementById('itemModal').classList.remove('hidden'); // Show the modal
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('itemModal').classList.add('hidden'); // Hide the modal
        }

        function cofirmupdate(){
            return confirm("Are you sure you want to update this item?");    
        }
        function confirmDelete() {
            return confirm("Are you sure you want to delete this item?");
        }

        
</script>

</body>
</html>
