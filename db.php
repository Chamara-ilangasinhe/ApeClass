<?php
$host = "sql311.infinityfree.com";
$user = "if0_42836832";
$pass = "H1D9q4HI5tK";
$dbname = "if0_42836832_apeclass";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// mysqli භාවිතා කරන්නේ නම්:
mysqli_set_charset($conn, "utf8mb4");

// PDO භාවිතා කරන්නේ නම් connection string එකට charset=utf8mb4 එකතු කරන්න:
// $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
?>