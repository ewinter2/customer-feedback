<?php
// simple login page to select role and redirect accordingly
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"];

    if ($role == "customer") {
        header("Location: feedback_form.php");
        exit();
    } else if ($role == "admin") {
        header("Location: admin_view.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Customer Feedback System</title>
</head>
<body>
    <h1>Customer Feedback System</h1>

    <form method="POST">
        <label>Select Role:</label><br><br>

        <select name="role" required>
            <option value="">-- choose --</option>
            <option value="customer">Customer</option>
            <option value="admin">Admin</option>
        </select>

        <br><br>
        <button type="submit">Enter</button>
    </form>
</body>
</html>
