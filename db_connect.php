<?php
include "credentials.php"; // Ensure this path is correct

// Database connection
$conn = new mysqli('localhost', $user, $pw, 'a30003409_database');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>