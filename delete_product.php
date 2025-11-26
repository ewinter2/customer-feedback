<?php
session_start();
include("db.php");

// User must be logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Product ID from URL
if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit();
}

$product_id = intval($_GET['id']);

// Ensure product belongs to THIS admin
$check_sql = "SELECT * FROM Product WHERE ProductID = $product_id AND AdminID = $admin_id";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) === 0) {
    // Not allowed
    echo "Unauthorized action.";
    exit();
}

// Delete the product
$delete_sql = "DELETE FROM Product WHERE ProductID = $product_id";
mysqli_query($conn, $delete_sql);

// Redirect back
header("Location: manage_products.php");
exit();
?>
