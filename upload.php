<?php
session_start();
include("connection.php");

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize variables and error messages
$item_name = $price = $discount = $quantity = $item_category = $pet_category = $description = "";
$item_nameErr = $priceErr = $discountErr = $quantityErr = $item_categoryErr = $pet_categoryErr = $uploadErr = "";
$uploadSuccess = "";
$valid = true;  // Initialize valid flag

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
        } else {
            $uploadErr = "Upload failed: " . $stmt->error;
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Result</title>
</head>
<body>
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
  <a href="admin2.php">Back to Upload Form</a>
</body>
</html>
