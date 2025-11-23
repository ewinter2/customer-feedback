<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback</title>
</head>
<body>

<h2>Submit Feedback</h2>

<form action="save_feedback.php" method="POST">

    <label>Your Name:</label><br>
    <input type="text" name="customer_name" required><br><br>

    <label>Your Email:</label><br>
    <input type="email" name="customer_email" required><br><br>

    <label>Feedback Comment:</label><br>
    <textarea name="comment" required></textarea><br><br>

    <label>Rating (1-5):</label><br>
    <input type="number" name="rating" min="1" max="5" required><br><br>

    <label>Category:</label><br>
    <select name="category" required>
        <option value="">-- Select Category --</option>

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
    <button type="submit">Submit Feedback</button>

</form>

</body>
</html>
