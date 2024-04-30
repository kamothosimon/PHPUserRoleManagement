<?php
// Database configuration
$dbHost = 'localhost';
$dbName = 'tele';
$dbUser = 'root';
$dbPass = '';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user data
    $stmt = $pdo->prepare("INSERT INTO Users (username, password_hash, email) VALUES (:username, :password, :email)");
    // Bind parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':email', $email);

    // Execute the statement
    $stmt->execute();

    echo "User registered successfully!";
} catch (PDOException $e) {
    die("Registration failed: " . $e->getMessage());
}
?>