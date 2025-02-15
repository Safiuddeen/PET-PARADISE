<?php
session_start();
require_once 'config/connection.php'; // Database connection file

$db = new Database(); // Create Database class
$conn = $db->getConnection();

if (!isset($_SESSION['customer_ID'])) {
    die("Error: User not logged in.");
}

$user_id = $_SESSION['customer_ID'];
echo $user_id;

// Initialize variables
$item_name = $price = $available_quantity =$contact_number = $address = "";
$email = $state = $city = $postal_code = $quantity = 0;
$contact_numberErr = $addressErr = $emailErr = $stateErr = $cityErr = $postalCodeErr = $quantityErr ="";

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate and sanitize item name
if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];
    
    // Fetch item details
    $query = "SELECT item_name, original_price, quantity, item_image, pet_category, item_category FROM item WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $item_id); // Changed to "s" to match string type
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $item_name = htmlspecialchars($row['item_name']);
        $price = htmlspecialchars($row['original_price']);
        $available_quantity = htmlspecialchars($row['quantity']);
        $pet_category = htmlspecialchars($row['pet_category']);
        $item_category = htmlspecialchars($row['item_category']);
        $item_image = !empty($row['item_image']) ? 'data:image/jpeg;base64,' . base64_encode($row['item_image']) : 'placeholder.jpg';
    } else {
        echo "Item not found. item_id: $item_id"; // Debugging line to check if item_id is correct
        exit;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    // Sanitize and validate each field
    if (empty($_POST["contactnumber"])) {
        $contact_numberErr = "Contact number is required";
        $valid = false;
    } else {
        $contact_number = sanitize_input($_POST["contactnumber"]);
        if (!preg_match("/^[0-9]{10}$/", $contact_number)) { // Basic contact number validation (10 digits)
            $contact_numberErr = "Invalid contact number format";
            $valid = false;
        }
    }

    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
        $valid = false;
    } else {
        $address = sanitize_input($_POST["address"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $valid = false;
    } else {
        $email = sanitize_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $valid = false;
        }
    }

    if (empty($_POST["state"])) {
        $stateErr = "State is required";
        $valid = false;
    } else {
        $state = sanitize_input($_POST["state"]);
    }

    if (empty($_POST["city"])) {
        $cityErr = "City is required";
        $valid = false;
    } else {
        $city = sanitize_input($_POST["city"]);
    }

    if (empty($_POST["postalCode"])) {
        $postalCodeErr = "Postal code is required";
        $valid = false;
    } else {
        $postal_code = sanitize_input($_POST["postalCode"]);
    }

    if (empty($_POST["quantity"])) {
        $quantityErr = "Quantity is required";
        $valid = false;
    } else {
        $quantity = intval($_POST["quantity"]);
        if ($quantity < 1 || $quantity > $available_quantity) {
            $quantityErr = "Invalid quantity selected | only select available quantity";
            $valid = false;
        }
    }

    // Insert into Order table if data is valid
    if ($valid) {
        $orderQuery = "INSERT INTO Orders (item_id, shipping_address, contact_number, email, state, city, postal_code, required_quantity, customer_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($orderQuery);
        $stmt->bind_param("sssssssis", $item_id, $address, $contact_number, $email, $state, $city, $postal_code, $quantity, $user_id);

        if ($stmt->execute()) {
            header('Location: paymentex.php');
        } else {
            echo "Error placing order: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Process</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen bg-indigo-200">
    
    <!-- Navbar -->
    <nav class="flex items-center justify-between w-full p-4 bg-white shadow-md">
        <ul class="flex items-center w-full">
            <li class="mr-4">
                <a href="index.php">
                    <img src="image/PARADISE2.png" alt="logo" class="h-20 w-36">
                </a>
            </li>
            <li class="items-center flex-grow text-center">
                <p class="text-lg font-semibold">Stay informed, stay connected.</p>
            </li>
        </ul>
    </nav>

    <!-- Profile Container -->
    <div class="flex flex-col items-center justify-center w-full max-w-4xl px-4 py-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-center text-black">Process your payment</h1>

        <!-- Form -->
        <form class="w-full p-6 bg-white rounded-lg shadow-lg md:flex" method="POST" action="">
            <!-- Left Column -->
            <div class="w-full p-3 md:w-1/2">
                <img src="<?php echo $item_image; ?>" class="w-3/4 h-56 mb-4 rounded-md " alt="Item Image">
                <p class="mb-4 "><strong>Item Name:</strong> <?php echo $item_name; ?></p>
                <p class="mb-4 "><strong>Price:</strong> Rs. <?php echo $price; ?></p>
                <p class="mb-4 "><strong>Pet Category:</strong> <?php echo $pet_category; ?></p>
                <p class="mb-4 "><strong>Item Category:</strong> <?php echo $item_category; ?></p>
                <p class="mb-4 "><strong>Available Quantity:</strong> <?php echo $available_quantity; ?></p>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Select Required Quantity</label>
                <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $available_quantity; ?>" required class="w-full p-2 mb-4 border rounded-lg">
            </div>    

            <!-- Right Column -->
            <div class="w-full p-3 md:w-1/2">
                <label for="contactnumber" class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="text" id="contactnumber" name="contactnumber" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea id="address" name="address" class="block w-full mt-1 mb-4 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></textarea>
                
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="email" name="email" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                
                <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                <input type="text" id="state" name="state" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" id="city" name="city" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                
                <label for="postalCode" class="block text-sm font-medium text-gray-700">Postal Code</label>
                <input type="text" id="postalCode" name="postalCode" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                
                <!-- Submit Button -->
                <button type="submit" name="save" class="w-full py-2 mt-5 text-white bg-blue-500 rounded-lg hover:bg-blue-800">Pay</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="py-4 mt-6 text-sm text-center text-white bg-slate-700">
        <p>We're here 24/7</p>
        <a href="terms_policy.php" class="pr-4 text-white hover:underline">1-800-672-4399</a> Or
        <a href="terms_policy.php" class="pl-4 text-white hover:underline">Email Us</a>
    </footer>

    <footer class="py-4 text-sm text-center bg-white text-slate-900">
        <p>Sri Lanka</p>
        <p>© 2024 Paradise Inc. All rights reserved.</p>
        <a href="terms_policy.php" class="text-blue-950 hover:underline">Privacy Policy</a> |
        <a href="terms_policy.php" class="text-blue-950 hover:underline">Terms of Service</a>
    </footer>
</body>
</html>
