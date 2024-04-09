<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'db_connection.php';

    // Define variables and initialize them with empty values
    $book_id = $rating = $review = $reviewer_name = $reviewer_email = $reviewer_number = "";

    // Validate and sanitize input data
    $book_id = trim($_POST['book_id']);
    $rating = intval($_POST['rating']);
    $review = trim($_POST['review']);
    $reviewer_name = trim($_POST['reviewer_name']);
    $reviewer_email = trim($_POST['reviewer_email']);
    $reviewer_number = trim($_POST['reviewer_number']);

    // Prepare SQL statement
    $sql = "INSERT INTO reviews (book_id, rating, review, reviewer_name, reviewer_email, reviewer_number) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the statement
        $stmt->bind_param("iissss", $book_id, $rating, $review, $reviewer_name, $reviewer_email, $reviewer_number);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Review added successfully
            echo "Review submitted successfully.";
        } else {
            // Error executing the statement
            echo "Error submitting review. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Review</title>
</head>
<body>

<h2>Submit Review</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div>
        <label for="book_id">Book ID:</label>
        <input type="text" name="book_id" id="book_id">
    </div>
    <div>
        <label for="rating">Rating (1-5):</label>
        <input type="number" name="rating" id="rating" min="1" max="5">
    </div>
    <div>
        <label for="review">Review:</label><br>
        <textarea name="review" id="review" cols="30" rows="5"></textarea>
    </div>
    <div>
        <label for="reviewer_name">Your Name:</label>
        <input type="text" name="reviewer_name" id="reviewer_name">
    </div>
    <div>
        <label for="reviewer_email">Your Email:</label>
        <input type="email" name="reviewer_email" id="reviewer_email">
    </div>
    <div>
        <label for="reviewer_number">Your Phone Number:</label>
        <input type="tel" name="reviewer_number" id="reviewer_number">
    </div>
    <div>
        <input type="submit" value="Submit Review">
    </div>
</form>

</body>
</html>
