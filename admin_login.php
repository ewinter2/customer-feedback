<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM Admin WHERE AdminEmail='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['AdminPassword'])) {
            $_SESSION['admin_id'] = $admin['AdminID'];
            $_SESSION['admin_name'] = $admin['AdminName'];

            header("Location: admin_view.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="center-body">

<div class="form-container">
    <h2 class="form-title">Admin Login</h2>

    <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>

    <form method="POST">

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit" class="submit-btn">Login</button>

    </form>

    <div style="text-align:center; margin-top: 15px;">
        <a href="admin_signup.php">Create an admin account</a>
    </div>
</div>

</body>
</html>
