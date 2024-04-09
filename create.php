<?php
include_once "config.php";

// Assuming you have a default author ID or you retrieve it from somewhere else
$default_author_id = 1; // Change this to the desired author ID

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $bookname = trim($_POST['bookname']);
    $date_published = $_POST['date_published'];
    $description = trim($_POST['description']);
    $isbn = trim($_POST['isbn']);
    $cover_photo = $_FILES["cover_photo"]["name"];
    $rating = intval($_POST['rating']); // Assuming rating is an integer
    $price = floatval($_POST['price']); // Assuming price is a float

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["cover_photo"]["name"]);
    $uploadOk = 1;
    // You can add checks for file size, type, etc., here
    if (move_uploaded_file($_FILES["cover_photo"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars($cover_photo). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        $uploadOk = 0;
    }

    if($uploadOk) {
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO books (bookname, date_published, description, isbn, cover_photo, rating, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissssd", $bookname, $date_published, $description, $isbn, $target_file, $rating, $price);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "New book added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close(); // Close statement
    }
}

$conn->close(); // Close connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 50px 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s ease forwards;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .btn-link {
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add New Book</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="bookname">Book Name:</label>
        <input type="text" id="bookname" name="bookname" required>

        <label for="date_published">Date Published:</label>
        <input type="date" id="date_published" name="date_published" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>

        <label for="cover_photo">Cover Photo:</label>
        <input type="file" id="cover_photo" name="cover_photo" required>

        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <input type="submit" value="Add Book">
    </form>
    <a href="read_books.php" class="btn btn-link">View Books</a>
    <a href="add_author.php" class="btn btn-link">Add Author</a><br>
    <a href="view_author.php" class="btn btn-link">View Author</a><br>
</div>


</body>
</html>
