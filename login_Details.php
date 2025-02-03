<?php
session_start();

include("connection.php");

// Initialize error variables
$fullnameErr = $usernameErr = $emailErr = $genderErr = $contactnumErr = $passwordErr = "";

// Handle Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $gender = $_POST["gender"] ?? "";
    $contactnum = trim($_POST["contactnum"]);
    $password = $_POST["password"];

    // Validate Full Name
    if (empty($fullname)) {
        $fullnameErr = "Full Name is required.";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
        $fullnameErr = "Only letters and white space allowed.";
    }

    // Validate Username
    if (empty($username)) {
        $usernameErr = "Username is required.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
        $usernameErr = "Only letters, numbers, and underscores allowed.";
    }

    // Validate Email
    if (empty($email)) {
        $emailErr = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
    }

    // Validate Gender
    if (empty($gender)) {
        $genderErr = "Gender is required.";
    }

    // Validate Contact Number
    if (empty($contactnum)) {
        $contactnumErr = "Contact Number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $contactnum)) {
        $contactnumErr = "Invalid contact number.";
    }

    // Validate Password
    if (empty($password)) {
        $passwordErr = "Password is required.";
    } elseif (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters long.";
    }

    // If no errors, insert data into the database
    if (empty($fullnameErr) && empty($usernameErr) && empty($emailErr) && empty($genderErr) && empty($contactnumErr) && empty($passwordErr)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO create_login (full_name, user_name, email, gender, contact_number, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullname, $username, $email, $gender, $contactnum, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION["username"] = $username;
            header("Location: index.php"); // Redirect to home
            exit();
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
}

// Handle Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Validate inputs
    if (empty($username)) {
        $usernameErr = "Username is required.";
    }
    if (empty($password)) {
        $passwordErr = "Password is required.";
    }

    // If no errors, check credentials
    if (empty($usernameErr) && empty($passwordErr)) {
        $stmt = $conn->prepare("SELECT password FROM create_login WHERE user_name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION["username"] = $username;
                header("Location: index.php"); // Redirect to home
                exit();
            } else {
                $passwordErr = "Invalid password.";
            }
        } else {
            // If user not found in create_login, check manager table
            $stmt->close();
            $stmt = $conn->prepare("SELECT password FROM manager WHERE user_name = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($hashed_password);
                $stmt->fetch();
                if (password_verify($password, $hashed_password)) {
                    $_SESSION["username"] = $username;
                    header("Location: admin2.php");
                    exit();
                } else {
                    $passwordErr = "Incorrect password.";
                }
            } else {
                $usernameErr = "User not found.";
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="PARADISE.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-indigo-200">

<!-- Login Form -->
<div id="loginForm">
    <form action="" method="POST" class="flex flex-col p-6 rounded-lg shadow-lg w-96 bg-slate-800/25">
        <a href="index.php" class="self-center">
            <img src="image/PARADISE.png" alt="logo" class="w-24 h-auto mb-4 rounded-lg">
        </a>
        <p class="self-center text-3xl font-bold">LOGIN FORM</p><br>

        <!-- Error Message Container -->
        <?php if (!empty($usernameErr) || !empty($passwordErr)): ?>
            <div class="p-2 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                <?php
                if (!empty($usernameErr)) {
                    echo "<p class='text-sm'>$usernameErr</p>";
                }
                if (!empty($passwordErr)) {
                    echo "<p class='text-sm'>$passwordErr</p>";
                }
                ?>
            </div>
        <?php endif; ?>

        <label for="username" class="font-semibold text-black">Username:</label>
        <input type="text" name="username" required placeholder="Username" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
        <br>

        <label for="password" class="font-semibold text-black">Password:</label>
        <input type="password" name="password" required placeholder="Password" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
        <br>

        <button type="submit" name="login" class="px-6 py-2 text-white bg-blue-500 rounded-2xl hover:bg-blue-600">
            Log in
        </button><br>

        <div class="flex justify-between mt-2 mb-4">
            <a href="forgotPassword.php" class="text-blue-950 hover:underline">Forgot Password?</a>
            <a href="?form=create" class="text-blue-950 hover:underline">Create New Account</a>
        </div>

        <footer class="mt-6 text-sm text-center text-white">
            <p>© 2024 Paradise Inc. All rights reserved.</p>
            <a href="#" class="text-blue-950 hover:underline">Privacy Policy</a> | 
            <a href="#" class="text-blue-950 hover:underline">Terms of Service</a>
        </footer>
    </form>
</div>

<!-- Registration Form -->
<div id="createForm" class="hidden">
    <form action="" method="POST" class="flex flex-col p-6 mt-20 mb-40 rounded-lg shadow-lg w-96 bg-slate-800/25">
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
            Create Account
        </button>

        <!-- Footer -->
        <footer class="mt-6 text-sm text-center text-white">
            <p>© 2024 Paradise Inc. All rights reserved.</p>
            <a href="#" class="text-blue-950 hover:underline">Privacy Policy</a> | 
            <a href="#" class="text-blue-950 hover:underline">Terms of Service</a>
        </footer>
    </form>
</div>

<script>
    // Script to show the form based on URL parameter
    function showForm() {
        const urlParams = new URLSearchParams(window.location.search);
        const formType = urlParams.get('form');
        const loginForm = document.getElementById('loginForm');
        const createForm = document.getElementById('createForm');

        if (formType === 'create') {
            loginForm.style.display = 'none';
            createForm.style.display = 'block';
        } else {
            loginForm.style.display = 'block';
            createForm.style.display = 'none';
        }
    }

    window.onload = showForm;
</script>

</body>
</html>