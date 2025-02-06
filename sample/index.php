<?php
include("connection.php");

$item_name = $price = $discount = $original_price = $quantity = $item_category = $pet_category = $description = "";
$item_id = "";
$image = "";

if (isset($_GET["search_name"])) {
    $search_name = $_GET["search_name"];
    $sql = "SELECT * FROM item WHERE item_name LIKE ? LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search_name . "%";
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $item_id = $row["item_id"];
        $item_name = $row["item_name"];
        $price = $row["price"];
        $discount = $row["discount"];
        $original_price = $row["original_price"];
        $quantity = $row["quantity"];
        $item_category = $row["item_category"];
        $pet_category = $row["category"];
        $description = $row["description"];
        $image = base64_encode($row["item_image"]);
    } else {
        echo "<script>alert('Item not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload & Update Item</title>
</head>
<body>
    <h2>Search Item</h2>
    <form action="index.php" method="GET">
        <label>Search by Name:</label>
        <input type="text" name="search_name" required>
        <button type="submit">Search</button>
    </form>

    <hr>

    <h2>Item Details</h2>
    <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="item_id" value="<?= $item_id ?>">

        <label>Item Name:</label>
        <input type="text" name="itemname" value="<?= $item_name ?>" required><br><br>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" value="<?= $price ?>" required><br><br>

        <label>Discount:</label>
        <input type="number" name="discount" step="0.01" value="<?= $discount ?>"><br><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= $quantity ?>" required><br><br>

        <label>Item Category:</label>
        <input type="text" name="item_category" value="<?= $item_category ?>" required><br><br>

        <label>Pet Category:</label>
        <input type="text" name="pet_category" value="<?= $pet_category ?>" required><br><br>

        <label>Description:</label>
        <textarea name="description"><?= $description ?></textarea><br><br>

        <label>Upload New Image (Optional):</label>
        <input type="file" name="itemimage" accept="image/*"><br><br>

        <?php if (!empty($image)) { ?>
            <label>Current Image:</label><br>
            <img src="data:image/jpeg;base64,<?= $image ?>" width="150"><br><br>
        <?php } ?>
        
        <button type="submit" name="uploaditem">Upload</button>
        <button type="submit" name="updateitem">Update</button>
    </form>
</body>
</html>
