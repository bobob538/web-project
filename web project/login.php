<?php
session_start();
require_once "database.php";

$error = "";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "Email and password are required";
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['ID']; // Match your "ID" column name
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['full_name'];
echo "Session set. Redirecting...";
            header("Location: dashbourd.php");
            exit();
        } else {
            $error = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-gruop">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-gruop">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-gruop">
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </div>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="project.php">Register here</a></p>
    </div>
</body>
</html>