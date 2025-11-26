<?php
session_start();
include("db.php");

// Protect page — only logged-in admins allowed
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle product submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['product_name']);
    $desc = trim($_POST['product_description']);

    if (!empty($name)) {
        $admin_id = $_SESSION['admin_id'];  // ← new line

        $sql = "INSERT INTO Product (ProductName, ProductDescription, AdminID)
                VALUES ('$name', '$desc', '$admin_id')";
        mysqli_query($conn, $sql);
        $success = "Product added successfully!";
    } else {
        $error = "Product name cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="center-body">

<div class="form-container">
    <h2 class="form-title">Manage Products</h2>

    <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p class='success-msg'>$success</p>"; ?>

    <form method="POST">
        <label>Product Name:</label>
        <input type="text" name="product_name" required>

        <label>Description:</label>
        <textarea name="product_description"></textarea>

        <button type="submit" class="submit-btn">Add Product</button>
    </form>

    <h3 style="text-align:center; margin-top:30px;">Existing Products</h3>

    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
        </tr>

        <?php
        $prod_sql = "SELECT * FROM Product";
        $result = mysqli_query($conn, $prod_sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['ProductName']}</td>
                    <td>{$row['ProductDescription']}</td>
                  </tr>";
        }
        ?>
    </table>

    <div style="text-align:center; margin-top:15px;">
        <a href='admin_view.php'>Back to Admin Dashboard</a>
    </div>
</div>

</body>
</html>
