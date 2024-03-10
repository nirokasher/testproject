<?php
require_once('db_connection.php');

class RegistrationManager
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registerUser($username, $password, $email)
    {
        try {
            // Check if the username is already taken
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "username_taken";
            }

            // If username is available, proceed with registration
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertStmt = $this->conn->prepare("INSERT INTO users (username, password, emailid) VALUES (:username, :password, :emailid)");
            $insertStmt->bindParam(':username', $username);
            $insertStmt->bindParam(':password', $hashedPassword);
            $insertStmt->bindParam(':emailid', $email);
            $insertStmt->execute();

            return "success";
        } catch (PDOException $e) {
            error_log($e->getMessage()); // Log any errors to the PHP error log
            return "error";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $registrationManager = new RegistrationManager($conn);
    $registrationResult = $registrationManager->registerUser($username, $password, $email);

    echo $registrationResult;
}
