<?php
session_start();
require_once "config.php";


// 1. Fetch all image paths stored in the database
$sql = "UPDATE kundenbestand 
JOIN location ON kundenbestand.idkundenbestand = location.ext_id 
SET kundenbestand.gps = location.gps"; // Replace with your actual column and table

if ($conn->query($sql) === TRUE) {
    echo "Updated rows: " . $conn->affected_rows;
} else {
    echo "Error: " . $conn->error;
}
$conn->close();