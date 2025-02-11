<?php
include("connection.php");



$searchResults = "";
// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if (isset($_GET["search_name"])) {
    $search_name = test_input($_GET["search_name"]);
    $sql = "SELECT * FROM item WHERE item_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search_name . "%";
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $item_name = htmlspecialchars($row["item_name"]);
            $price = htmlspecialchars($row["price"]);
            $discount = htmlspecialchars($row["discount"]);
            $quantity = htmlspecialchars($row["quantity"]);
            $item_category = htmlspecialchars($row["item_category"]);
            $pet_category = htmlspecialchars($row["category"]);
            $description = htmlspecialchars($row["description"]);
            $image = !empty($row["item_image"]) ? "data:image/jpeg;base64," . base64_encode($row["item_image"]) : "No image";

            $searchResults .= "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";
            $searchResults .= "<p><strong>Item Name:</strong> $item_name</p>";
            $searchResults .= "<p><strong>Price:</strong> $price</p>";
            $searchResults .= "<p><strong>Discount:</strong> $discount</p>";
            $searchResults .= "<p><strong>Quantity:</strong> $quantity</p>";
            $searchResults .= "<p><strong>Item Category:</strong> $item_category</p>";
            $searchResults .= "<p><strong>Pet Category:</strong> $pet_category</p>";
            $searchResults .= "<p><strong>Description:</strong> $description</p>";
            if ($image !== "No image") {
                $searchResults .= "<img src='$image' width='150'>";
            } else {
                $searchResults .= "<p>No image available</p>";
            }
            $searchResults .= "</div>";
        }
    } else {
        $searchResults = "<p>No results found.</p>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>
    <h2>Search Results</h2>
    <?php echo $searchResults; ?>
    <br><br>
    <a href="upload.php">Back to Upload Page</a>
</body>
</html>
