<?php
session_start();
include("db.php");

// Only admins allowed
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $admin_name; ?>'s Dashboard</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        /* LEFT FILTER PANEL */
        .filter-panel {
            max-width: 900px;
            margin: 0 auto 15px auto;
            padding: 10px 0;
            text-align: left;
        }

        .filter-panel label {
            font-weight: bold;
            display: block;
            margin-top: 12px;
        }

        .filter-panel input,
        .filter-panel select {
            width: 250px;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background-color: #ffffff;
        }

        .filter-panel button {
            width: auto;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #059c8e;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .filter-panel button:hover {
            background-color: #047c72;
        }

        /* KEEP WHITE BOX ONLY FOR THE TABLE */
        .table-container {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
    </style>

</head>

<body>

<!-- Dashboard Title -->
<h2 style="text-align:center; margin-top:30px;">
    <?php echo $admin_name; ?>'s Dashboard
</h2>

<!-- Top Navigation -->
<div style="text-align:center; margin-bottom: 15px;">
    <a href="manage_products.php">Manage My Products</a> |
    <a href="admin_logout.php">Logout</a>
</div>

<!-- LEFT-ALIGNED FILTERS (no card, no white background) -->
<div class="filter-panel">

    <form method="GET">

        <label>Product:</label>
        <select name="product">
            <option value="">-- All My Products --</option>

            <?php
            $p_sql = "SELECT * FROM Product WHERE AdminID = $admin_id";
            $p_result = mysqli_query($conn, $p_sql);

            while ($p = mysqli_fetch_assoc($p_result)) {
                echo "<option value='{$p['ProductID']}'>{$p['ProductName']}</option>";
            }
            ?>
        </select>

        <label>Customer Email:</label>
        <input type="text" name="email" placeholder="Search by email">

        <label>Keyword:</label>
        <input type="text" name="keyword" placeholder="Search feedback text">

        <button type="submit">Apply Filters</button>

    </form>
</div>


<!-- FEEDBACK TABLE IN A CENTERED WHITE CARD -->
<div class="table-container">

<?php
// Base query
$query = "
    SELECT Feedback.*, Customer.CustomerName, Customer.CustomerEmail,
           Product.ProductName
    FROM Feedback
    JOIN Customer ON Feedback.CustomerID = Customer.CustomerID
    JOIN Product ON Feedback.ProductID = Product.ProductID
    WHERE Product.AdminID = $admin_id
";

// Filters
if (!empty($_GET['product'])) {
    $prod = $_GET['product'];
    $query .= " AND Product.ProductID = $prod";
}

if (!empty($_GET['email'])) {
    $email = $_GET['email'];
    $query .= " AND Customer.CustomerEmail LIKE '%$email%'";
}

if (!empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $query .= " AND Feedback.FeedbackComment LIKE '%$keyword%'";
}

$result = mysqli_query($conn, $query);

// Results
if ($result && mysqli_num_rows($result) > 0) {
    echo "<table>
            <tr>
                <th>Product</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['ProductName']}</td>
                <td>{$row['CustomerName']}</td>
                <td>{$row['CustomerEmail']}</td>
                <td>{$row['FeedbackRating']}</td>
                <td>{$row['FeedbackComment']}</td>
                <td>{$row['FeedbackDate']}</td>
              </tr>";
    }

    echo "</table>";

} else {
    echo "<p style='text-align:center;'>No feedback found for your products.</p>";
}
?>

</div>

</body>
</html>
