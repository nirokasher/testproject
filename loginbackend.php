<?php
require_once('db/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the login form
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        // Prepare and execute the SQL statement to check user credentials
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            echo '<div class="alert alert-success" role="alert">';
            echo 'Login successful! Welcome, ' . $username . '!';
            echo '</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Invalid username or password. Please try again.';
            echo '</div>';
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
        echo '<div class="alert alert-danger" role="alert">';
        echo 'Login failed. Please check the log for more details.';
        echo '</div>';
    }
} else {
    // If someone tries to access this page directly without submitting the form
    echo '<div class="alert alert-warning" role="alert">';
    echo 'Invalid request!';
    echo '</div>';
}
?>
