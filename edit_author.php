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
    $author_id = getInput('author_id', $conn);
    $author_name = getInput('author_name', $conn);
    $biography = getInput('biography', $conn);
    $date_of_birth = getInput('date_of_birth', $conn);
    $email = getInput('email', $conn);
    $phone_number = getInput('phone_number', $conn);

    // Check if all required fields are filled
    if ($author_id === false || $author_name === false || $biography === false || $date_of_birth === false || $email === false || $phone_number === false) {
        echo "Error: Please fill in all required fields";
        exit();
    }

    // Prepare SQL statement to update the author record
    $sql = "UPDATE authors SET author_name=?, biography=?, date_of_birth=?, email=?, phone_number=? WHERE author_id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error: " . $conn->error;
        exit();
    }
    $stmt->bind_param("sssssi", $author_name, $biography, $date_of_birth, $email, $phone_number, $author_id);
    $stmt->execute();

    // Check if update was successful
    if ($stmt->affected_rows > 0) {
        echo "Author updated successfully";
    } else {
        echo "Error: Unable to update author";
    }

    // Close prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Retrieve author data by ID
    if(isset($_GET['author_id']) && !empty($_GET['author_id'])) {
        // Get author_id from URL parameter
        $author_id = $_GET['author_id'];

        // Validate author_id as an integer
        if (!filter_var($author_id, FILTER_VALIDATE_INT)) {
            // Redirect to an error page for invalid author ID
            header("Location: error.php?message=Invalid%20author%20ID");
            exit;
        }

        // Prepare SQL query to select author by ID
        $sql = "SELECT * FROM authors WHERE author_id = ?";

        // Prepare statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $author_id);

        // Execute statement
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Check if result is available
        if ($result->num_rows == 1) {
            // Fetch author data
            $author = $result->fetch_assoc();
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit Author</title>
                <!-- Bootstrap CSS -->
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <!-- Custom CSS -->
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
                <h2>Edit Author</h2>
                <form action="edit_author.php" method="post">
                    <input type="hidden" name="author_id" value="<?php echo htmlspecialchars($author['author_id']); ?>">
                    <div class="form-group">
                        <label for="author_name">Author Name:</label>
                        <input type="text" class="form-control" id="author_name" name="author_name" value="<?php echo htmlspecialchars($author['author_name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="biography">Biography:</label>
                        <textarea class="form-control" id="biography" name="biography"><?php echo htmlspecialchars($author['biography']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth:</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($author['date_of_birth']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($author['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number:</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($author['phone_number']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            </body>
            </html>

            <?php
        } else {
            // Redirect to an error page for author not found
            header("Location: error.php?message=Author%20not%20found");
            exit;
        }
    } else {
        // Redirect to an error page for author ID not specified
        header("Location: error.php?message=Author%20ID%20not%20specified");
        exit;
    }
}
?>
