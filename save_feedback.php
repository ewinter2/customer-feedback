<?php
include("db.php");

// Get form data
$name = $_POST['customer_name'];
$email = $_POST['customer_email'];
$comment = $_POST['comment'];
$rating = $_POST['rating'];
$product = $_POST['product'];

// Insert or find the customer
$check_sql = "SELECT CustomerID FROM Customer WHERE CustomerEmail='$email'";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    $row = mysqli_fetch_assoc($check_result);
    $customer_id = $row['CustomerID'];
} else {
    $insert_customer = "INSERT INTO Customer (CustomerName, CustomerEmail)
                        VALUES ('$name', '$email')";
    mysqli_query($conn, $insert_customer);
    $customer_id = mysqli_insert_id($conn);
}

// Insert feedback
$insert_feedback = "
    INSERT INTO Feedback (FeedbackComment, FeedbackRating, FeedbackDate, CustomerID, ProductID)
    VALUES ('$comment', $rating, CURDATE(), $customer_id, $product)
";

if (mysqli_query($conn, $insert_feedback)) {
    echo "<h2>Thank you for your feedback!</h2>";
    echo "<a href='feedback_form.php'>Submit Another</a><br>";
    echo "<a href='index.php'>Return Home</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
