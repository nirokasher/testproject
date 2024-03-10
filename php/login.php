<?php
require_once('db/db_connection.php');

class LoginManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function loginUser($username, $password) {
        $sql = "SELECT * FROM users WHERE username=:username AND password=:password";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        try {
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true; // Login successful
            } else {
                return false; // Invalid username or password
            }
        } catch (PDOException $e) {
            $this->logError($e->getMessage());
            return false; // Error occurred during login
        }
    }

    private function logError($errorMessage) {
        $error_message = "Error: " . $errorMessage;

        // Log the error to a text file
        $log_file = 'log.txt';
        file_put_contents($log_file, date('Y-m-d H:i:s') . ' ' . $error_message . PHP_EOL, FILE_APPEND);
    }
}
?>
