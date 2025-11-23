<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Feedback View</title>
</head>
<body>

<h2>Admin Feedback Reports</h2>

<form method="GET">
    <label>Search by Customer Email:</label><br>
    <input type="text" name="email"><br><br>

    <label>Search by Keyword:</label><br>
    <input type="text" name="keyword"><br><br>

    <label>Search by Category:</label><br>
    <select name="category">
        <option value="">-- All Categories --</option>

        <?php
        $cat_sql = "SELECT * FROM Category";
        $cat_result = mysqli_query($conn, $cat_sql);

        while ($row = mysqli_fetch_assoc($cat_result)) {
            echo "<option value='" . $row['CategoryID'] . "'>" . 
                  $row['CategoryName'] . "</option>";
        }
        ?>
    </select>
    <br><br>

    <button type="submit">Search</button>
</form>

<hr>

<?php
// Build dynamic query
$query = "
SELECT Feedback.FeedbackComment, Feedback.FeedbackRating, Feedback.FeedbackDate,
       Customer.CustomerName, Customer.CustomerEmail,
       Category.CategoryName
FROM Feedback
JOIN Customer ON Feedback.CustomerID = Customer.CustomerID
JOIN Category ON Feedback.CategoryID = Category.CategoryID
WHERE 1=1
";

if (!empty($_GET['email'])) {
    $email = $_GET['email'];
    $query .= " AND CustomerEmail LIKE '%$email%'";
}

if (!empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $query .= " AND FeedbackComment LIKE '%$keyword%'";
}

if (!empty($_GET['category'])) {
    $cat = $_GET['category'];
    $query .= " AND Feedback.CategoryID = $cat";
}

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Results:</h3>";
    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>Customer</th>
                <th>Email</th>
                <th>Category</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['CustomerName']}</td>
                <td>{$row['CustomerEmail']}</td>
                <td>{$row['CategoryName']}</td>
                <td>{$row['FeedbackRating']}</td>
                <td>{$row['FeedbackComment']}</td>
                <td>{$row['FeedbackDate']}</td>
            </tr>";
    }

    echo "</table>";

} else {
    echo "<p>No results found.</p>";
}
?>

</body>
</html>
