<?php
session_start();
require_once "config.php";
$folder = 'assets/images/users/';
$db_image_paths = [];



// 2. Fetch all image paths stored in the database
$sql = "SELECT img FROM users"; // Replace with your actual column and table
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $db_image_paths[] = basename($row['img']); // Extract filename only
    }
}

// 3. Scan image folder
$files = scandir($folder);
$deleted = [];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $file_path = $folder . $file;
    // 4. If file is not in DB list and is a file, delete it
    if (is_file($file_path) && !in_array($file, $db_image_paths)) {
        if (unlink($file_path)) {
            $deleted[] = $file;
        }
    }
}

// 5. Output result
echo "Deleted " . count($deleted) . " garbage files:\n";
foreach ($deleted as $del) {
    echo "- $del\n";
}

$conn->close();