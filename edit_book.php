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
    $bookname = getInput('bookname', $conn);
    $date_published = getInput('date_published', $conn);
    $description = getInput('description', $conn);
    $isbn = getInput('isbn', $conn);

    // Check if all required fields are filled
    if ($book_id === false || $bookname === false || $date_published === false || $description === false || $isbn === false) {
        echo "Error: Please fill in all required fields";
        exit();
    }

    // Prepare SQL statement to update the book record
    $sql = "UPDATE books SET bookname=?, date_published=?, description=?, isbn=? WHERE book_id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error: " . $conn->error;
        exit();
    }
    $stmt->bind_param("ssssi", $bookname, $date_published, $description, $isbn, $book_id);
    $stmt->execute();

    // Check if update was successful
    if ($stmt->affected_rows > 0) {
        echo "Book updated successfully";
    } else {
        echo "Error: Unable to update book";
    }

    // Close prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Fetch book data based on book_id
    $book_id = $_GET['book_id'];
    $sql = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Book found, display edit form
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Book</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                body {
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                }
                .form-group {
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
        <div class="container">
            <h2 class="mt-4 mb-4">Edit Book</h2>
            <form action="edit_book.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                <div class="form-group">
                    <label for="bookname">Book Name:</label>
                    <input type="text" class="form-control" id="bookname" name="bookname" value="<?php echo $row['bookname']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="date_published">Date Published:</label>
                    <input type="date" class="form-control" id="date_published" name="date_published" value="<?php echo $row['date_published']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description" required><?php echo $row['description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN:</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo $row['isbn']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="cover_photo">Current Cover Photo:</label><br>
                    <img src="<?php echo $row['cover_photo']; ?>" alt="Cover Photo" class="img-thumbnail"><br><br>
                    <label for="cover_photo">Upload New Cover Photo:</label>
                    <input type="file" id="cover_photo" name="cover_photo">
                </div>

                <button type="submit" class="btn btn-primary">Update Book</button>
            </form>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "Book not found";
    }

    $stmt->close();
    $conn->close();
}
?>
