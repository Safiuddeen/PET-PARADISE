<?php
session_start();
require_once 'config/connection.php'; //Database connection file

$db = new Database(); // Create Database class
$conn = $db->getConnection();



if (isset($_POST['logout'])) { 
    session_unset();  
    session_destroy();
    header("Location: login_Details.php");
    exit();
}



// Initialize error variables
 $fullname = $username =  $email = $gender = $contactnum = $password = "";
$fullnameErr = $usernameErr = $emailErr = $genderErr = $contactnumErr = $passwordErr = "";
$successMsg = $errorMsg = "";

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    // Validate Full Name
    if (empty($_POST["fullname"])) {
        $fullnameErr = "Name is required";
    } else {
        $fullname = test_input($_POST["fullname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
            $fullnameErr = "Only letters and white space allowed";
        }
    }

    // Validate Username
    if (empty($_POST["username"])) {
        $usernameErr = "Name is required";
    } else {
        $username = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
            $usernameErr = "Only letters and white space allowed";
        }
    }

    // Validate Email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format!";
        }
    }

    // Validate Gender
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // Validate Contact Number
    if (empty($_POST["contactnum"])) {
        $contactnumErr = "Contact Number is required.";
    } else {
        $contactnum = test_input($_POST["contactnum"]);
        if (!preg_match("/^[0-9]{10}$/", $contactnum)) {
            $contactnumErr = "Invalid contact number.";
        }
    }

    // Validate Password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters long";
        } elseif (!preg_match("/[A-Z]/", $password)) {
            $passwordErr = "Password must include at least one uppercase letter";
        }
    }

    if (empty($fullnameErr) && empty($usernameErr) && empty($emailErr) && empty($genderErr) && empty($contactnumErr) && empty($passwordErr)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
        $stmt = $conn->prepare("INSERT INTO admin (full_name, username, email, gender, contact_number, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullname, $username, $email, $gender, $contactnum, $hashed_password);
        
        if ($stmt->execute()) {
            echo "<script>alert('Account created successfully'); window.location='stockManagment.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fix the errors in the form');</script>";
    }   
    }


    // Fetch all items from the database to display in table
    $sql = "SELECT * FROM admin ";
    $result = $conn->query($sql);

    // Check if admin_id is set
    if (isset($_GET['admin_id'])) {
        $admin_id = $_GET['admin_id'];
        $query = "DELETE FROM admin WHERE admin_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter
        $stmt->bind_param("s", $admin_id);
        if ($stmt->execute()) {
            // Redirect to the page with success message
            echo "<script>alert('customer deleted successfully!'); window.location='stockManagment.php';</script>";
        } else {
            // Display error if delete fails
            echo "<script>alert('Error: Unable to delete admin.'); window.location='stockManagment.php.php';</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
    }
}

// Fetch all items from the database to display in table
$sql1 = "SELECT * FROM create_login ";
$resultcustomer = $conn->query($sql1);

// Check if admin_id is set
if (isset($_GET['customer_ID'])) {
    $customer_id = $_GET['customer_ID'];
    $query = "DELETE FROM create_login WHERE customer_ID = ?";

if ($stmt = $conn->prepare($query)) {
    // Bind the parameter
    $stmt->bind_param("s", $customer_id);
    if ($stmt->execute()) {
        // Redirect to the page with success message
        echo "<script>alert('Admin deleted successfully!'); window.location='stockManagment.php';</script>";
    } else {
        // Display error if delete fails
        echo "<script>alert('Error: Unable to delete admin.'); window.location='stockManagment.php.php';</script>";
    }

    // Close the statement
    $stmt->close();
} else {
}
}

// Close the database connection
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
       
        <div class="w-full h-1 border-t-4 border-black"></div>
        <p class="text-lg font-semibold text-orange-600">Manager -: <?php if (isset($_SESSION["username"])) echo htmlspecialchars($_SESSION["username"]); ?>. </p>
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
        <h3 class="mb-4 text-lg font-bold">Admin Panel</h3>
        <ul class="space-y-2 text-center">
            <li>
                <a onclick="window.location.href='admin2.php'" class="cursor-pointer ">
                <img src="image/inventory.png" alt="Inventory" class="w-16 h-16 mx-auto">
                Admin Dashboard
                </a>
            </li>
        </ul>
    </div>


        <div class="w-full h-1 border-t-4 border-black"></div>

        <!-- Logout Button -->
        <div class="mt-auto">
            <form action="" method="POST">
                <button type="submit" name="logout" class="flex items-center mb-auto space-x-1 hover:text-gray-200">
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
            <div id="welcome" class="bg-white content-section">
                <!-- Navbar -->
                <nav class="bg-white">
                    <ul class="flex flex-wrap items-center justify-between w-full p-4">
                        <!-- Para -->
                        <li class="flex-grow text-center">
                            <!-- Display as smaller text on small screens -->
                            <p class="hidden text-xs font-medium text-gray-700 sm:text-lg sm:block">
                            Welcome to Inventory Managment Dashboard <br>PetParadise   </p>
                        </li>
                    </ul>
                </nav>
                <nav class=" bg-slate-600">
                    <ul class="flex flex-wrap items-center justify-between w-full p-2">
                        <li><button onclick="showContent('admin')" class="text-white hover:underline">Admin Manage</button></li>
                        <li><button onclick="showContent('customer')" class="text-white hover:underline">Customer Manage</button></li>
                        <li><button onclick="showContent('supplier')" class="text-white hover:underline">Suplier Manage</button></li>
                    </ul>
                </nav>
                            
            </div>  
        
        <!-- Category-Specific Content -->
        <!-- DOG -->
        <div id="dog" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Dog Items</h1>
            <p class="mb-6 text-center">Details about dogs and related items go here.</p>
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

        <!-- CAT -->
        <div id="cat" class="hidden content-section">
            <h1 class="mb-4 text-2xl font-bold text-center">Cat Items</h1>
            <p class="mb-6 text-center">Details about cat and related items go here.</p>
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
        <!-- ADMIN -->
        <div id="admin" class="flex-col items-center hidden min-h-screen content-section">
            <h1 class="w-full mb-1 text-2xl font-bold text-center">Admin Managing</h1>

            <div class="w-full px-4">
                
                <div class="flex justify-center">
                    <form action="" method="POST" class="flex flex-col p-6 mt-10 mb-40 rounded-lg shadow-lg w-96 bg-slate-800/25">
                        <a href="index.php" class="self-center">
                            <img src="image/PARADISE.png" alt="logo" class="w-24 h-auto mb-4 rounded-lg">
                        </a>
                        <p class="self-center text-3xl font-bold">CREATE LOGIN</p><br>
                        <p class="text-sm text-red-700 error">* Required field</p>

                        <!-- Full Name -->
                        <label class="font-semibold text-black">Full Name:</label>
                        <div class="flex items-center">
                            <input type="text" name="fullname" required placeholder="Full Name" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                            <span class="ml-2 text-sm text-red-500 error">*</span>
                        </div>
                        <span class="text-sm text-red-500 error"><?php echo $fullnameErr; ?></span><br>

                        <!-- Username -->
                        <label class="font-semibold text-black">Username:</label>
                        <div class="flex items-center">
                            <input type="text" name="username" required placeholder="Username" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                            <span class="ml-2 text-sm text-red-500 error">*</span>
                        </div>
                        <span class="text-sm text-red-500 error"><?php echo $usernameErr; ?></span><br>

                        <!-- Email -->
                        <label class="font-semibold text-black">Email:</label>
                        <div class="flex items-center">
                            <input type="email" name="email" required placeholder="Email" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                            <span class="ml-2 text-sm text-red-500 error">*</span>
                        </div>
                        <span class="text-sm text-red-500 error"><?php echo $emailErr; ?></span><br>

                        <!-- Gender -->
                        <label class="font-semibold text-black">Gender:</label>
                        <div>
                            <input type="radio" name="gender" value="Male" required> Male
                            <input type="radio" name="gender" value="Female" required class="ml-4"> Female
                            <input type="radio" name="gender" value="Other" required class="ml-4"> Other
                        </div>
                        <span class="text-sm text-red-500 error"><?php echo $genderErr; ?></span><br>

                        <!-- Contact Number -->
                        <label class="mt-2 font-semibold text-black">Contact Number:</label>
                        <div class="flex items-center">
                            <input type="text" name="contactnum" required placeholder="Contact Number" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                            <span class="ml-2 text-sm text-red-500 error">*</span>
                        </div>
                        <span class="text-sm text-red-500 error"><?php echo $contactnumErr; ?></span><br>

                        <!-- Password -->
                        <label class="font-semibold text-black">Password:</label>
                        <div class="flex items-center">
                            <input type="password" name="password" required placeholder="Password" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                            <span class="ml-2 text-sm text-red-500 error">*</span>
                        </div>
                        <span class="text-sm text-red-500 error"><?php echo $passwordErr; ?></span><br>

                        <!-- Submit Button -->
                        <button type="submit" name="register" class="px-6 py-2 text-white bg-blue-500 rounded-2xl hover:bg-blue-600">
                            Create Admin Account
                        </button>

                        <!-- Success/Error Message -->
                        <span class="text-sm text-green-500"><?php echo $successMsg; ?></span>
                        <span class="text-sm text-red-500"><?php echo $errorMsg; ?></span>

                        <!-- Footer -->
                        <footer class="mt-6 text-sm text-center text-white">
                            <p>© 2024 Paradise Inc. All rights reserved.</p>
                            <a href="#" class="text-blue-950 hover:underline">Privacy Policy</a> | 
                            <a href="#" class="text-blue-950 hover:underline">Terms of Service</a>
                        </footer>
                    </form>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">Admin ID</th>
                                <th class="border border-black">Admin Name</th>
                                <th class="border border-black">Admin username</th>
                                <th class="border border-black">Email</th>
                                <th class="border border-black">Gender</th>
                                <th class="border border-black">Contact Number</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($result->num_rows > 0) {
                                    while($admin = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $admin['admin_id']; ?></td>
                                            <td class="border border-black"><?php echo $admin['full_name']; ?></td>
                                            <td class="border border-black"><?php echo $admin['username']; ?></td>
                                            <td class="border border-black"><?php echo $admin['email']; ?></td>
                                            <td class="border border-black"><?php echo $admin['gender']; ?></td>
                                            <td class="border border-black"><?php echo $admin['contact_number']; ?></td>
                                            <td class="border border-black">
                                                <form action="" method="GET" onsubmit="return confirmDelete()">
                                                    <input type="hidden" name="admin_id" value="<?php echo $item['admin_id']; ?>">
                                                    <button type="submit" class="px-1 py-2 text-white bg-red-500 rounded hover:bg-red-800">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                        </tbody>

                    </table>
                </div>
                <br><br><br>     
            </div>
        </div>
        <div id="customer" class="flex-col items-center hidden min-h-screen content-section">
            <h1 class="w-full mb-1 text-2xl font-bold text-center">customer Managing</h1>
            
                <div class="mt-8">
                    <h3 class="text-xl font-bold ">View all items</h3>
                    <table class="w-full mt-4 border border-collapse border-black table-auto ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-black">customer ID</th>
                                <th class="border border-black">customer Name</th>
                                <th class="border border-black">customer username</th>
                                <th class="border border-black">Email</th>
                                <th class="border border-black">Gender</th>
                                <th class="border border-black">Contact Number</th>
                                <th class="border border-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($resultcustomer->num_rows > 0) {
                                    while($customer = $resultcustomer->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="border border-black"><?php echo $customer['customer_ID']; ?></td>
                                            <td class="border border-black"><?php echo $customer['full_name']; ?></td>
                                            <td class="border border-black"><?php echo $customer['user_name']; ?></td>
                                            <td class="border border-black"><?php echo $customer['email']; ?></td>
                                            <td class="border border-black"><?php echo $customer['gender']; ?></td>
                                            <td class="border border-black"><?php echo $customer['contact_number']; ?></td>
                                            <td class="border border-black">
                                                <form action="" method="GET" onsubmit="return confirmDeleteCoust()">
                                                    <input type="hidden" name="customer_ID" value="<?php echo $customer['customer_ID']; ?>">
                                                    <button type="submit" class="px-1 py-2 text-white bg-red-500 rounded hover:bg-red-800">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                        </tbody>

                    </table>
                </div>
                <br><br><br>     
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

// Function to remove the image preview and reset input
function removeImage() {
    const preview = document.getElementById('preview'); // Image preview element
    const fileInput = document.querySelector('input[name="itemimage"]'); // File input element
    const removeButton = document.getElementById('remove-button'); // Remove button
    const fileLabel = document.getElementById('file-label'); // Label for the file name

    preview.src = ''; // Clear the image source
    preview.classList.add('hidden'); // Hide the preview image
    fileInput.value = ''; // Reset the file input field
    removeButton.classList.add('hidden'); // Hide the remove button
    fileLabel.textContent = 'No file chosen'; // Reset the file label
}

    function confirmDelete() {
        return confirm("Are you sure you want to delete this admin?");
    }
    function confirmDeleteCoust() {
        return confirm("Are you sure you want to delete this customer?");
    }


</script>

</body>
</html>