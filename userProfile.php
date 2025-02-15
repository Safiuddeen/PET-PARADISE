<?php
require_once 'config/connection.php'; //Database connection file

$db = new Database(); // Create Database class
$conn = $db->getConnection();
session_start();

// Check if the user is logged in
if (!isset($_SESSION["customer_ID"])) {
    
    header("Location: login_Details.php"); // Redirect to login page if not logged in
    exit();
}else{
    
}

$customer_id = $_SESSION["customer_ID"];

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize variables
$fullName = $userName = $email = $contactNumber = $gender = $birthYear = $address = $state = $city = $postalCode = "";
$fullNameErr = $userNameErr = $emailErr = $contactNumberErr = $genderErr = $birthYearErr = $addressErr = $stateErr = $cityErr = $postalCodeErr = "";

// Fetch existing user data
$sql = "SELECT * FROM create_login WHERE customer_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullName = $row['full_name'];
    $userName = $row['user_name'];
    $email = $row['email'];
    $contactNumber = $row['contact_number'];
    $gender = $row['gender'];
    $birthYear = $row['birth_date'];
    $address = $row['address'];
    $state = $row['state'];
    $city = $row['city'];
    $postalCode = $row['postal_code'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $valid = true;

    // Validate and sanitize Full Name
    if (empty($_POST["fullName"])) {
        $fullNameErr = "Full Name is required";
        $valid = false;
    } else {
        $fullName = test_input($_POST["fullName"]);
    }

    // Validate and sanitize User Name
    if (empty($_POST["userName"])) {
        $userNameErr = "User Name is required";
        $valid = false;
    } else {
        $userName = test_input($_POST["userName"]);
    }

    // Validate and sanitize Email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $valid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $valid = false;
    } else {
        $email = test_input($_POST["email"]);
    }

    // Validate and sanitize Contact Number
    if (empty($_POST["contactNumber"])) {
        $contactNumberErr = "Contact Number is required";
        $valid = false;
    } else {
        $contactNumber = test_input($_POST["contactNumber"]);
    }

    // Validate and sanitize Gender
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
        $valid = false;
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // Validate and sanitize Birth Year
    if (empty($_POST["birthYear"])) {
        $birthYearErr = "Birth Year is required";
        $valid = false;
    } else {
        $birthYear = test_input($_POST["birthYear"]);
    }

    // Validate and sanitize Address
    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
        $valid = false;
    } else {
        $address = test_input($_POST["address"]);
    }

    // Validate and sanitize State
    if (empty($_POST["state"])) {
        $stateErr = "State is required";
        $valid = false;
    } else {
        $state = test_input($_POST["state"]);
    }

    // Validate and sanitize City
    if (empty($_POST["city"])) {
        $cityErr = "City is required";
        $valid = false;
    } else {
        $city = test_input($_POST["city"]);
    }

    // Validate and sanitize Postal Code
    if (empty($_POST["postalCode"])) {
        $postalCodeErr = "Postal Code is required";
        $valid = false;
    } else {
        $postalCode = test_input($_POST["postalCode"]);
    }

    if ($valid) {
        // Update SQL query with the correct data binding
        $sql_update = "UPDATE create_login SET full_name=?, user_name=?, email=?, contact_number=?, gender=?, birth_date=?, address=?, state=?, city=?, postal_code=? WHERE customer_ID=?";
        
        if ($stmt = $conn->prepare($sql_update)) {
            $stmt->bind_param("sssssssssss", $fullName, $userName, $email, $contactNumber, $gender, $birthYear, $address, $state, $city, $postalCode, $customer_id);
            
            if ($stmt->execute()) {
                echo "<script>alert('Profile updated successfully');</script>";
                header("Refresh:0"); // Reload page after update
            } else {
                echo "<script>alert('Error updating profile');</script>";
            }
        } else {
            echo "<script>alert('Error preparing the SQL query');</script>";
        }
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
        <h1 class="mb-6 text-3xl font-bold text-center text-black">Manage Your Profile</h1>

        <!-- Single Form Container -->
        <form class="w-full p-6 bg-white rounded-lg shadow-lg md:flex" method="POST">
            
            <!-- Left Column -->
            <div class="w-full p-3 md:w-1/2">
                <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" id="fullName" value="<?= $fullName; ?>" name="fullName" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                <label for="userName" class="block text-sm font-medium text-gray-700">User Name</label>
                <input type="text" id="userName" name="userName" value="<?= $userName; ?>" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="<?= $email; ?>" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        
                <label for="contactNumber" class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="tel" id="contactNumber" value="<?= $contactNumber; ?>" name="contactNumber" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select id="gender" name="gender" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="male" <?= ($gender == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?= ($gender == 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?= ($gender == 'other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>    

            <!-- Right Column -->
            <div class="w-full p-3 md:w-1/2">
                <label for="birthYear" class="block text-sm font-medium text-gray-700">Birth Year</label>
                <input type="date" id="birthYear" name="birthYear" value="<?= $birthYear; ?>" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea id="address" name="address" class="block w-full mt-1 mb-4 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" required><?= $address; ?></textarea>
            
                <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                <input type="text" id="state" name="state" value="<?= $state; ?>" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" id="city" name="city" value="<?= $city; ?>" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            
                <label for="postalCode" class="block text-sm font-medium text-gray-700">Postal Code</label>
                <input type="text" id="postalCode" name="postalCode" value="<?= $postalCode; ?>" class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                <!-- Submit Button -->
                <button type="submit" name="save" class="w-full py-2 mt-5 text-white bg-blue-500 rounded-lg hover:bg-blue-800">SAVE</button>
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
