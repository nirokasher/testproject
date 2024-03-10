<?php
require_once('db/db_connection.php');

// Get the raw JSON data from the request body
$jsonData = file_get_contents('php://input');

// Decode the JSON data into a PHP associative array
$data = json_decode($jsonData, true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($data)) {
    // Retrieve user input from the decoded JSON data
    $username = $data["username"];
    $email = $data["email"];
    $password = $data["password"];

    // Hash the password for better security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare and execute the SQL statement to insert user data
        $query = "INSERT INTO users (username, emailid, password) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            $response = '<div class="alert alert-success" role="alert">';
            $response .= 'Registration successful! User data inserted into the database.';
            $response .= '</div>';
            echo $response;
        } else {
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Error: Unable to execute the query.';
            echo '</div>';
            print_r($stmt->errorInfo()); // Print PDO error information
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();

        // Log the error to a text file
        $log_file = 'log.txt';
        file_put_contents($log_file, date('Y-m-d H:i:s') . ' ' . $error_message . PHP_EOL, FILE_APPEND);
        echo '<div class="alert alert-danger" role="alert">';
        echo 'Registration failed. Please check the log for more details.';
        echo '</div>';
    }
} else {
    // If someone tries to access this page directly without submitting the form
    echo '<div class="alert alert-warning" role="alert">';
    echo 'Invalid request!';
    echo '</div>';
}
