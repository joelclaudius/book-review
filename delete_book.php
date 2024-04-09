<?php
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
    $book_id = getInput('book_id', $conn);

    // Check if book_id is provided
    if ($book_id === false) {
        echo "Error: Book ID not found in the request";
        exit();
    }

    // Prepare SQL statement to delete the book record
    $sql = "DELETE FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error: " . $conn->error;
        exit();
    }
    $stmt->bind_param("i", $book_id);
    $stmt->execute();

    // Check if deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Book deleted successfully";
    } else {
        echo "Error: Unable to delete book";
    }

    // Close prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error: Invalid request method";
}
?>
