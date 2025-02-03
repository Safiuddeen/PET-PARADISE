<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connecton</title>
</head>
<body>
<?php
        $servername = "localhost"; // Server address
        $username = "root";        // MySQL username
        $password = "";            // MySQL password
        $db = "petparadisedb";            // Database name
        $port = 3307;              // Custom port

        // Create the connection
        $conn = new mysqli($servername, $username, $password, $db, $port);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    ?>
</body>
</html>