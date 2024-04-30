<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Get the username and role ID of the logged-in user
$username = $_SESSION['username'];
$role_id = $_SESSION['role_id'];

// Customize the dashboard content based on the user's role
$dashboard_content = '';

if ($role_id == 1) { // Normal User
    $dashboard_content = 'Welcome, ' . $username . '! You are a Normal User. This is the basic dashboard content.';
} elseif ($role_id == 2) { // Super Admin
    $dashboard_content = 'Welcome, ' . $username . '! You are a Super Admin. You have access to administrative features.';
} elseif ($role_id == 3) { // Client Service Personnel
    $dashboard_content = 'Welcome, ' . $username . '! You are a Client Service Personnel. Here are tools and information related to client service tasks.';
} else {
    // Unknown role
    $dashboard_content = 'Welcome, ' . $username . '! Your role is not recognized.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h2>Dashboard</h2>
    <p><?php echo $dashboard_content; ?></p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>

</html>