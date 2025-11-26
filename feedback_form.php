<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Form</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="center-body">

<div class="form-container">
    <h2 class="form-title">Feedback Form</h2>

    <form action="save_feedback.php" method="POST">

        <h3>Customer Information</h3>

        <label>Name:</label>
        <input type="text" name="customer_name" placeholder="Enter your name" required>

        <label>Email:</label>
        <input type="email" name="customer_email" placeholder="Enter your email" required>

        <h3>Tell Us About Your Experience</h3>

        <label>Product:</label>
        <select name="product" required>
            <option value="">-- Select Product --</option>

            <?php
            $product_sql = "SELECT * FROM Product";
            $product_result = mysqli_query($conn, $product_sql);

            while ($row = mysqli_fetch_assoc($product_result)) {
                echo "<option value='" . $row['ProductID'] . "'>" . 
                    $row['ProductName'] . "</option>";
            }
            ?>
        </select>

        <label>Message:</label>
        <textarea name="comment" placeholder="Enter your message" required></textarea>

        <label>Rating:</label>

        <div class="rating-container">
            <span class="rating-dot" data-value="1"></span>
            <span class="rating-dot" data-value="2"></span>
            <span class="rating-dot" data-value="3"></span>
            <span class="rating-dot" data-value="4"></span>
            <span class="rating-dot" data-value="5"></span>
        </div>

        <input type="hidden" name="rating" id="rating-value" required>

        <button type="submit" class="submit-btn">Submit</button>

    </form>
</div>

    <script>
        // JavaScript for rating selection
    const dots = document.querySelectorAll(".rating-dot");
    const hiddenInput = document.getElementById("rating-value");

    dots.forEach(dot => {
        dot.addEventListener("click", () => {
            const value = dot.getAttribute("data-value");
            hiddenInput.value = value;

            // update visual selection
            dots.forEach(d => d.classList.remove("selected"));
            for (let i = 0; i < value; i++) {
                dots[i].classList.add("selected");
            }
        });
    });
    </script>
</body>
</html>
