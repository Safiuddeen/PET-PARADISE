<?php
include 'connection.php';

// Fetch 12 items from the 'item' table
$sql = "SELECT * FROM item LIMIT 12";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Item Cards</title>
  <!-- Tailwind CSS via CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <div class="container p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Items</h1>
    <!-- Grid: Adjusts responsively; 6 columns on large screens -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="overflow-hidden bg-white rounded shadow">
            <!-- Display image if available -->
            <?php if (!empty($row['item_image'])): ?>
              <!-- Image container with fixed height -->
            <div class="relative w-full h-32">
                <img 
                        class="absolute top-0 left-0 object-cover w-full h-full" 
                        src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['item_image']); ?>" 
                        alt="<?php echo htmlspecialchars($row['item_name'] ?? 'Item'); ?>">
             </div>
                    <?php endif; ?>
                <div class="p-4">
                    <h2 class="mb-2 text-lg font-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'No Title'); ?></h2>
                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['description'] ?? 'No description available.'); ?></p>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <p class="text-center text-gray-500 col-span-full">No items found.</p>
            <?php endif; ?>
            <?php $conn->close(); ?>
        </div>
    </div>
</body>
</html>
