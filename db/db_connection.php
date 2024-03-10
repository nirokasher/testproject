<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "tourist";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error_message = "Connection failed: " . $e->getMessage();

    // Log the error to a text file
    $log_file = 'log.txt';
    file_put_contents($log_file, date('Y-m-d H:i:s') . ' ' . $error_message . PHP_EOL, FILE_APPEND);
    die($error_message);
}
