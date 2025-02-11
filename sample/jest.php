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

// Initialize variables
$item_name = $price = $discount = $quantity = $item_category = $pet_category = $description = "";
$item_nameErr = $priceErr = $discountErr = $quantityErr = $item_categoryErr = $pet_categoryErr = $uploadErr = "";
$uploadSuccess = "";
$valid = true;
$item_id = "";
$item_image = "";

// Handle search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchitem"])) {
    $search_name = test_input($_POST["search_name"]);
    $sql = "SELECT * FROM item WHERE item_name LIKE ? AND category='dog'";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search_name . "%";
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        // Populate the form with the item details
        $item_name = $item['item_name'];
        $price = $item['price'];
        $discount = $item['discount'];
        $quantity = $item['quantity'];
        $item_category = $item['item_category'];
        $pet_category = $item['category'];
        $description = $item['description'];
        $item_image = $item['item_image'];
    } else {
        $uploadErr = "No item found with that name.";
    }
    $stmt->close();
}

// Handle item upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["additem"])) {
    // Validate inputs
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
    
    if (isset($_FILES["itemimage"]) && $_FILES["itemimage"]["size"] > 0) {
        $image_tmp = $_FILES["itemimage"]["tmp_name"];
        $item_image = file_get_contents($image_tmp);
    } else {
        $uploadErr = "Please upload an image.";
        $valid = false;
    }
    
    if ($valid) {
        $original_price = $price - $discount;
        $sql = "INSERT INTO item (item_name, price, discount, original_price, quantity, item_image, category, item_category, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $null = NULL;
        $stmt->bind_param("sdddibsss", $item_name, $price, $discount, $original_price, $quantity, $null, $pet_category, $item_category, $description);
        $stmt->send_long_data(5, $item_image);
        
        if ($stmt->execute()) {
            $uploadSuccess = "Item uploaded successfully!";
            // Clear the form fields after successful upload
            $item_name = $price = $discount = $quantity = $item_category = $pet_category = $description = "";
            $item_image = "";  // Reset image field
        } else {
            $uploadErr = "Upload failed: " . $stmt->error;
        }
        $stmt->close();
    }
}
// Handle item update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
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
            $sql = "UPDATE item SET item_name=?, price=?, discount=?, original_price=?, quantity=?, category=?, item_category=?, description=? WHERE item_name=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdddissss", $item_name, $price, $discount, $original_price, $quantity, $pet_category, $item_category, $description, $item_name);
        }

        if ($stmt->execute()) {
            $uploadSuccess = "Item updated successfully!";

            // Clear form fields after successful update
        $item_name = $price = $discount = $quantity = $item_category = $pet_category = $description = "";
        $item_image = "";  // Reset image field
        } else {
            $uploadErr = "Update failed: " . $stmt->error;
        }

        $stmt->close();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    if (!empty($_POST["item_id"])) { // Ensure item_id is present
        $item_id = test_input($_POST["item_id"]);
        
        if (!is_numeric($item_id)) { // Validate that item_id is numeric
            $uploadErr = "Invalid item ID.";
        } else {
            $sql = "DELETE FROM item WHERE item_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $item_id);

            if ($stmt->execute()) {
                $uploadSuccess = "Item deleted successfully!";
            } else {
                $uploadErr = "Delete failed: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $uploadErr = "No item selected to delete.";
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Item</title>
</head>
<body>
    <h2>Upload / Update Item</h2>

    <!-- Search Form -->
    <form action="" method="POST">
        
        <div class="flex items-center justify-between mb-6">
                <input type="text" name="search_name" id="search_name" placeholder="Search for items..." class="w-3/4 px-3 py-2 border rounded">
                <button type="submit" name="searchitem" class="px-4 py-2 ml-4 font-bold text-white bg-blue-500 rounded">Search</button>
                </div>  
    </form>

    <?php if (!empty($uploadSuccess)): ?>
        <p style="color: green;"><?php echo $uploadSuccess; ?></p>
    <?php elseif (!empty($uploadErr)): ?>
        <p style="color: red;"><?php echo $uploadErr; ?></p>
    <?php endif; ?>

    <form id="itemForm" action="" method="POST" enctype="multipart/form-data">
        <br>
        <label>Item Name:</label>
        <input type="text" name="itemname" value="<?php echo $item_name; ?>" required><br>
        <label>Price:</label>
        <input type="number" name="price" value="<?php echo $price; ?>" step="0.01" required><br>
        <label>Discount:</label>
        <input type="number" name="discount" value="<?php echo $discount; ?>" step="0.01"><br>
        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $quantity; ?>" required><br>
        <label>Pet Category:</label>
        <input type="text" name="pet_category" value="<?php echo $pet_category; ?>" required><br>
        <label>Item Category:</label>
        <input type="text" name="item_category" value="<?php echo $item_category; ?>" required><br>
        <label>Description:</label>
        <input type="text" name="description" value="<?php echo $description; ?>" required><br>
        <label>Item Image:</label>
        <input type="file" name="itemimage" <?php echo empty($item_image) ? 'required' : ''; ?>><br>
        
        <?php if (!empty($item_image)): ?>
            <h3>Item Image</h3>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($item_image); ?>" width="200"/>
        <?php endif; ?>
        
        <button type="submit" name="additem">Upload</button>
        <button type="submit" name="update">Update</button>    
        <button type="submit" name="delete" class="px-4 py-2 text-white bg-red-500 rounded">Delete</button>
        <button type="button" onclick="clearFields()" class="refresh-btn">Refresh</button>
    </form>
</body>
<script>
function clearFields() {
    document.getElementById("itemForm").reset(); // Reset form fields
}
</script>
</html>
