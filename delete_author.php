<?php
// Include config file
include_once "config.php";

// Check if author_id parameter exists
if(isset($_GET['author_id']) && !empty($_GET['author_id'])) {
    // Get author_id from URL parameter
    $author_id = $_GET['author_id'];

    // Function to delete author
    function deleteAuthor($conn, $author_id) {
        // Prepare SQL statement to delete the author
        $stmt = $conn->prepare("DELETE FROM authors WHERE author_id = ?");
        $stmt->bind_param("i", $author_id);

        // Execute SQL statement
        if ($stmt->execute()) {
            return true; // Deleted successfully
        } else {
            return false; // Error deleting author
        }
    }

    // Attempt to delete the author
    if(deleteAuthor($conn, $author_id)) {
        // Author deleted successfully
        header("Location: index.php"); // Redirect back to the main page or any other page as needed
        exit();
    } else {
        // Error deleting author
        echo "Error deleting author.";
    }
} else {
    // Redirect to an error page or handle the case where author_id parameter is missing
    echo "Author ID not specified.";
}
?>
