<?php
// db.php - PDO connection to MySQL database

$host = 'localhost';            // Usually localhost
$db   = 'hostelmanagementsystem';  // Your database name — change if needed
$user = 'root';                 // Your MySQL username (default for XAMPP is 'root')
$pass = '';                    // Your MySQL password (default for XAMPP is empty '')
$charset = 'utf8mb4';           // Character set

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Enable exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch results as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Use native prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If connection fails, stop script and display error message
    die("Database connection failed: " . $e->getMessage());
}
