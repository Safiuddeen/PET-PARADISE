<?php
require 'connection.php';
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate email and passwords
    if (empty($email)) {
        $error = "Email is required.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email exists in the manager, admin, or customer tables
        $stmt = $conn->prepare("SELECT * FROM manager WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Reset password for manager
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE manager SET password = ? WHERE email = ?");
            $update_stmt->bind_param("ss", $hashed_password, $email);
            if ($update_stmt->execute()) {
                $success = "Password successfully reset for Manager!";
            } else {
                $error = "Something went wrong.";
            }
        } else {
            // Check for admin
            $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Reset password for admin
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE admin SET password = ? WHERE email = ?");
                $update_stmt->bind_param("ss", $hashed_password, $email);
                if ($update_stmt->execute()) {
                    $success = "Password successfully reset for Admin!";
                } else {
                    $error = "Something went wrong.";
                }
            } else {
                // Check for customer
                $stmt = $conn->prepare("SELECT * FROM create_login WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Reset password for customer
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_stmt = $conn->prepare("UPDATE create_login SET password = ? WHERE email = ?");
                    $update_stmt->bind_param("ss", $hashed_password, $email);
                    if ($update_stmt->execute()) {
                        $success = "Password successfully reset for Customer!";
                    } else {
                        $error = "Something went wrong.";
                    }
                } else {
                    $error = "Email not found in any role!";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-indigo-200">
    <div id="resetForm">
        <form action="#" method="post" class="flex flex-col p-6 rounded-lg shadow-lg w-96 bg-slate-800/25">
            <a href="index.php" class="self-center">
                <img src="image/PARADISE.png" alt="logo" class="w-24 h-auto mb-4 rounded-lg">
            </a>
            <p class="self-center text-3xl font-bold">Reset Password</p>

            <!-- Success and Error Messages -->
            <?php 
                if ($success) {
                    echo "<script>
                            alert('<?php echo $success; ?>');
                            window.location.href = 'login_Details.php';
                        </script>";
                }
            ?>
                
            <?php if ($error): ?>
                <div class="p-2 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                    <p class="text-sm"><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <!-- Email Field -->
            <label for="email" class="font-semibold text-black">Email:</label>
            <div class="flex items-center">
                <input type="email" name="email" required placeholder="Email" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">
                <span class="ml-2 text-sm text-red-500">*</span>
            </div>

            <!-- New Password Field -->
            <label for="new_password" class="font-semibold text-black">New Password:</label>
            <input type="password" name="new_password" required placeholder="New Password" class="w-full px-4 py-2 mb-2 border rounded focus:ring-2 focus:ring-black">

            <!-- Confirm Password Field -->
            <label for="confirm_password" class="font-semibold text-black">Confirm Password:</label>
            <input type="password" name="confirm_password" required placeholder="Confirm Password" class="w-full px-4 py-2 mb-4 border rounded focus:ring-2 focus:ring-black">

            <!-- Submit Button -->
            <button type="submit" class="px-6 py-2 text-white bg-blue-500 rounded-2xl hover:bg-blue-600">
                Reset Password
            </button>

            <!-- Footer -->
            <footer class="mt-6 text-sm text-center text-white">
                <p>© 2024 Paradise Inc. All rights reserved.</p>
                <a href="terms_policy.php" class="text-blue-950 hover:underline">Privacy Policy</a> | 
                <a href="terms_policy.php" class="text-blue-950 hover:underline">Terms of Service</a>
            </footer>
        </form>
    </div>
</body>
</html>