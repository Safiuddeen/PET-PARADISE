<?php
session_start(); // Start the session at the very beginning
include 'connection.php';

// Initialize error messages
$usernameErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["managerlogin"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Validate inputs
    if (empty($username)) {
        $usernameErr = "Username is required.";
    }
    if (empty($password)) {
        $passwordErr = "Password is required.";
    }

    if (empty($usernameErr) && empty($passwordErr)) {
        $stmt = $conn->prepare("SELECT password FROM manager WHERE user_name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION["username"] = $username;

                // Redirect to store management page
                header("Location: stockManagment.php");
                exit(); // Ensure no further execution
            } else {
                $passwordErr = "Invalid password.";
            }
        } else {
            $usernameErr = "User not found.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="PARADISE.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-indigo-200">

    <div id="loginForm">
        <form action="" method="POST" class="flex flex-col p-6 rounded-lg shadow-lg w-96 bg-slate-800/25">
            <a href="index.php" class="self-center">
                <img src="image/PARADISE.png" alt="logo" class="w-24 h-auto mb-4 rounded-lg">
            </a>
            <p class="self-center text-3xl font-bold">INVENTORY</p>
            <p class="self-center text-3xl font-bold">MANAGEMENT LOGIN</p>
            <p class="self-center text-xs font-bold text-red-700">MANAGER ONLY CAN ACCESS</p><br><br>

            <!-- Error Messages -->
            <?php if (!empty($usernameErr) || !empty($passwordErr)): ?>
                <div class="p-2 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                    <?php
                    if (!empty($usernameErr)) 
                        echo "<p class='text-sm'>" . htmlspecialchars($usernameErr) . "</p>";
                    if (!empty($passwordErr))
                         echo "<p class='text-sm'>" . htmlspecialchars($passwordErr) . "</p>";
                    ?>
                </div>
            <?php endif; ?>

            <label for="username" class="font-semibold text-black">Manager Name:</label>
            <input type="text" name="username" placeholder="ManagerName" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <label for="password" class="font-semibold text-black">Password:</label>
            <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 mb-6 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">

            <button type="submit" name="managerlogin" class="px-6 py-2 text-white transition duration-200 bg-blue-500 rounded-2xl hover:bg-blue-600">
                Log in
            </button><br>

            <footer class="mt-6 text-sm text-center text-white">
                <p>© 2024 Paradise Inc. All rights reserved.</p>
                <a href="#" class="text-blue-950 hover:underline">Privacy Policy</a> | 
                <a href="#" class="text-blue-950 hover:underline">Terms of Service</a>
            </footer>
        </form>
    </div>

</body>
</html>