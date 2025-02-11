<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateitem"])) {
    $item_id = $_POST["item_id"];
    $item_name = $_POST["itemname"];
    $price = $_POST["price"];
    $discount = $_POST["discount"];
    $original_price = $price - $discount;
    $quantity = $_POST["quantity"];
    $item_category = $_POST["item_category"];
    $pet_category = $_POST["pet_category"]; // Renamed to match DB structure
    $description = $_POST["description"];

    // Check if a new image is uploaded
    if (!empty($_FILES["itemimage"]["tmp_name"])) {
        $image_tmp = $_FILES["itemimage"]["tmp_name"];
        $item_image = file_get_contents($image_tmp);

        $sql = "UPDATE item SET 
                    item_name=?, price=?, discount=?, original_price=?, 
                    quantity=?, item_image=?,  category=?, description=?,item_category=?, 
                    
                WHERE item_id=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdddibssbi", $item_name, $price, $discount, $original_price, 
                          $quantity, $item_image, $item_category, $pet_category, $description, $item_id);
        $stmt->send_long_data(8, $item_image);
    } else {
        // Update all fields except image
        $sql = "UPDATE item SET 
                    item_name=?, price=?, discount=?, original_price=?, 
                    quantity=?, item_category=?, category=?, description=? 
                WHERE item_id=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdddibssi", $item_name, $price, $discount, $original_price, 
                          $quantity, $item_category, $category, $description, $item_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Item updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Update failed: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uploaditem"])) {
    $item_name = $_POST["itemname"];
    $price = $_POST["price"];
    $discount = $_POST["discount"];
    $original_price = $price - $discount;
    $quantity = $_POST["quantity"];
    $item_category = $_POST["item_category"];
    $pet_category = $_POST["pet_category"];
    $description = $_POST["description"];

    // Process Image Upload
    if (isset($_FILES["itemimage"]) && $_FILES["itemimage"]["size"] > 0) {
        $image_tmp = $_FILES["itemimage"]["tmp_name"];
        $item_image = file_get_contents($image_tmp); // Read image as binary

        $sql = "INSERT INTO item (item_name, price, discount, original_price, quantity, item_image, category, item_category, description)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdddibsss", $item_name, $price, $discount, $original_price, $quantity, $null, $pet_category, $item_category, $description);
        $stmt->send_long_data(5, $item_image);

        if ($stmt->execute()) {
            echo "<script>alert('Item uploaded successfully!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Upload failed: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please upload an image.');</script>";
    }
}



$conn->close();
?>
