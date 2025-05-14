<?php
// dashboard.php
session_start();
require_once "database.php"; // Ensure this filename is correct

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


// Fetch user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT full_name, email, phone, city FROM users WHERE ID = ?"; // Match your table's "ID" column
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Database error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Handle missing user data
if (!$user) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <div class="text-end mt-3">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        
        <h1 class="mt-4">Welcome, <?= htmlspecialchars($user['full_name']) ?>!</h1>
        
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Your Profile</h5>
                <p class="card-text">
                    <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?>
                </p>
                <p class="card-text">
                    <strong>Phone:</strong> <?= htmlspecialchars($user['phone'] ?? 'Not provided') ?>
                </p>
                <p class="card-text">
                    <strong>City:</strong> <?= htmlspecialchars($user['city'] ?? 'Not provided') ?>
                </p>
            </div>
        </div>
    </div>
</body>
</html>