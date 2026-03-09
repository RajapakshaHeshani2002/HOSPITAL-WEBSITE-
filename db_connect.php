<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unitycare"; // Replace with your actual database name

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: echo "Connected successfully"; for testing
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>  