<?php
// Include the configuration file
include_once "config.php";

// Function to safely fetch input from $_POST with error handling
function getInput($key, $conn) {
    if(isset($_POST[$key])) {
        return mysqli_real_escape_string($conn, $_POST[$key]);
    } else {
        return false; // Indicate key not found
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data from the form
    $book_name = getInput('book_name', $conn);
    $rating = getInput('rating', $conn);
    $review = getInput('review', $conn);
    $reviewer_name = getInput('reviewer_name', $conn);
    $reviewer_email = getInput('reviewer_email', $conn);
    $reviewer_number = getInput('reviewer_number', $conn);

    // Check if all required fields are filled
    if ($book_name === false || $rating === false || $review === false || $reviewer_name === false || $reviewer_email === false || $reviewer_number === false) {
        echo "Error: Please fill in all required fields";
        exit();
    }

    // Prepare SQL statement to retrieve book ID based on book name
    $sql_select_book_id = "SELECT book_id FROM books WHERE bookname = ?";
    $stmt_select_book_id = $conn->prepare($sql_select_book_id);
    if (!$stmt_select_book_id) {
        echo "Error: " . $conn->error;
        exit();
    }
    $stmt_select_book_id->bind_param("s", $book_name);
    $stmt_select_book_id->execute();
    $result_book_id = $stmt_select_book_id->get_result();

    // Check if book exists
    if ($result_book_id->num_rows > 0) {
        $row_book_id = $result_book_id->fetch_assoc();
        $book_id = $row_book_id['book_id'];

        // Prepare SQL statement to insert the review into the database
        $sql_insert_review = "INSERT INTO reviews (book_id, rating, review, reviewer_name, reviewer_email, reviewer_number) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert_review = $conn->prepare($sql_insert_review);
        if (!$stmt_insert_review) {
            echo "Error: " . $conn->error;
            exit();
        }
        $stmt_insert_review->bind_param("iissss", $book_id, $rating, $review, $reviewer_name, $reviewer_email, $reviewer_number);
        $stmt_insert_review->execute();

        // Check if insertion was successful
        if ($stmt_insert_review->affected_rows > 0) {
            echo "Review submitted successfully";
        } else {
            echo "Error: Unable to submit review";
        }

        // Close prepared statements
        $stmt_insert_review->close();
        $stmt_select_book_id->close();
    } else {
        echo "Error: Book not found";
    }

    // Close database connection
    $conn->close();
} else {
    // If the form is not submitted, do nothing (no redirection or error message)
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Submit Review</h2>
    <form action="review.php" method="post">
        <div class="form-group">
            <label for="book_name">Select Book:</label>
            <select id="book_name" name="book_name" required>
                <option value="">Select a book</option>
                <?php
                // Retrieve book names from the database and populate the dropdown menu
                $sql_select_books = "SELECT bookname FROM books";
                $result_books = $conn->query($sql_select_books);
                if ($result_books->num_rows > 0) {
                    while ($row_book = $result_books->fetch_assoc()) {
                        echo "<option value='" . $row_book['bookname'] . "'>" . $row_book['bookname'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="rating">Rating:</label>
            <input type="text" id="rating" name="rating" required>
        </div>
        <div class="form-group">
            <label for="review">Review:</label>
            <textarea id="review" name="review" required></textarea>
        </div>
        <div class="form-group">
            <label for="reviewer_name">Reviewer Name:</label>
            <input type="text" id="reviewer_name" name="reviewer_name" required>
        </div>
        <div class="form-group">
            <label for="reviewer_email">Reviewer Email:</label>
            <input type="email" id="reviewer_email" name="reviewer_email" required>
        </div>
        <div class="form-group">
            <label for="reviewer_number">Reviewer Number:</label>
            <input type="text" id="reviewer_number" name="reviewer_number" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Submit Review">
        </div>
    </form>
</div>
<a href="read_reviews.php">Review</a>
</body>
</html>
