<?php
// Database connection
include 'connection.php';

// Initialize variables
$itemid = $itemname = $price = $discount = $quantity = $description = "";
$item_category = $pet_category = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchitem'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM items WHERE item_name LIKE '%$search%' AND pet_category='Cats'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $itemid = $row['itemid'];
        $itemname = $row['itemname'];
        $price = $row['price'];
        $discount = $row['discount'];
        $quantity = $row['quantity'];
        $description = $row['description'];
        $item_category = $row['item_category'];
        $pet_category = $row['pet_category'];
    } else {
        echo "<p style='color:red;'>Item not found.</p>";
    }
}
?>

<!-- DOG -->
<div id="dog" class="hidden content-section">
    <h1 class="mb-4 text-2xl font-bold text-center">Dog Items</h1>
    <p class="mb-6 text-center">Details about dogs and related items go here.</p>

    <form action="" method="POST" enctype="multipart/form-data" class="max-w-3xl px-8 pt-6 pb-8 mx-auto mb-4 bg-white rounded shadow-md">
        <!-- Search Bar -->
        <div class="flex items-center justify-between mb-6">
            <input type="text" name="search" placeholder="Search for items..." class="w-3/4 px-3 py-2 border rounded">
            <button type="submit" name="searchitem" class="px-4 py-2 ml-4 font-bold text-white bg-blue-500 rounded">Search</button>
        </div>

        <p class="mb-4 text-lg font-bold text-center">Add Dog Items</p>

        <!-- Item ID Field -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold">Item ID:</label>
            <input type="text" name="itemid" value="<?php echo $itemid; ?>" readonly class="w-full px-3 py-2 border rounded">
        </div>
        
        <!-- Item Name Field -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold">Item Name:</label>
            <input type="text" name="itemname" value="<?php echo $itemname; ?>" required class="w-full px-3 py-2 border rounded">
        </div>

        <!-- Price Field -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold">Price:</label>
            <input type="number" name="price" step="0.01" value="<?php echo $price; ?>" required class="w-full px-3 py-2 border rounded">
        </div>

        <!-- Discount Field -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold">Discount:</label>
            <input type="number" name="discount" step="0.01" value="<?php echo $discount; ?>" class="w-full px-3 py-2 border rounded">
        </div>

        <!-- Quantity Field -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold">Quantity:</label>
            <input type="number" name="quantity" value="<?php echo $quantity; ?>" required class="w-full px-3 py-2 border rounded">
        </div>

        <!-- Item Image Field -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold">Item Image:</label>
            <input type="file" name="itemimage" accept="image/*" class="w-full px-3 py-2 border rounded">
        </div>

        <!-- Pet Category Field -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold">Pet Category:</label>
            <select name="pet_category" required class="w-full px-3 py-2 border rounded">
                <option value="Dogs" <?php echo ($pet_category == 'Dogs') ? 'selected' : ''; ?>>Dogs</option>
            </select>
        </div>

        <!-- Item Category Field -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold">Item Category:</label>
            <select name="item_category" required class="w-full px-3 py-2 border rounded">
                <option value="Food" <?php echo ($item_category == 'Food') ? 'selected' : ''; ?>>Food</option>
                <option value="Accessories" <?php echo ($item_category == 'Accessories') ? 'selected' : ''; ?>>Accessories</option>
                <option value="Health & Wellness" <?php echo ($item_category == 'Health & Wellness') ? 'selected' : ''; ?>>Health & Wellness</option>
                <option value="Housing" <?php echo ($item_category == 'Housing') ? 'selected' : ''; ?>>Housing</option>
                <option value="Specialty Items" <?php echo ($item_category == 'Specialty Items') ? 'selected' : ''; ?>>Specialty Items</option>
            </select>
        </div>

        <!-- Description Field -->
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold">Description:</label>
            <textarea name="description" rows="5" class="w-full px-3 py-2 border rounded"><?php echo $description; ?></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between">
            <button type="submit" name="additem" class="px-4 py-2 font-bold text-white bg-green-500 rounded">Add Item</button>
            <button type="submit" name="updateitem" class="px-4 py-2 font-bold text-white bg-yellow-500 rounded">Update Item</button>
            <button type="submit" name="deleteitem" class="px-4 py-2 font-bold text-white bg-red-500 rounded">Delete Item</button>
        </div>
    </form>
</div>
