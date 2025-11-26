<?php
session_start();
include("db.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Basic validation
    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $check_sql = "SELECT * FROM Admin WHERE AdminEmail='$email'";
        $result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($result) > 0) {
            $error = "An admin with this email already exists.";
        } else {
            // Hash password
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insert admin
            $insert_sql = "INSERT INTO Admin (AdminName, AdminEmail, AdminPassword)
                           VALUES ('$name', '$email', '$hashed')";
            mysqli_query($conn, $insert_sql);

            $success = "Admin account created successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Admin Account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="center-body">

<div class="form-container">
    <h2 class="form-title">Admin Signup</h2>

    <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p class='success-msg'>$success</p>"; ?>

    <form method="POST">

        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" class="submit-btn">Create Account</button>

    </form>

    <div style="text-align:center; margin-top: 15px;">
        <a href="admin_login.php">Already have an account? Login</a>
    </div>
</div>

</body>
</html>
