<?php
session_start();

// Database configuration
$dbHost = 'localhost';
$dbName = 'tele';
$dbUser = 'root';
$dbPass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare SQL statement to retrieve user data
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username");
        // Bind parameters
        $stmt->bindParam(':username', $username);
        // Execute the statement
        $stmt->execute();

        // Fetch user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user['password_hash'])) {
            // Password is correct, create session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id']; // Store role_id in session
            // Redirect to dashboard or designated page
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid username or password, redirect back to login page with error message
            header("Location: login.php?error=invalid");
            exit();
        }
    } catch (PDOException $e) {
        die("Login failed: " . $e->getMessage());
    }
}
?>