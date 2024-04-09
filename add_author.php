<?php
include_once "config.php";


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $author_name = trim($_POST['author_name']);
    $biography = trim($_POST['biography']);
    $date_of_birth = $_POST['date_of_birth'];
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);

    // Check if the author name and email are not empty
    if (empty($author_name) || empty($email)) {
        echo "Author name and email cannot be empty.";
        exit; // Stop execution if author name or email is empty
    }

    // Insert new author into the database
    $stmt = $conn->prepare("INSERT INTO authors (author_name, biography, date_of_birth, email, phone_number) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $author_name, $biography, $date_of_birth, $email, $phone_number);

    if ($stmt->execute()) {
        echo "New author added successfully.";
    } else {
        echo "Error adding new author: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close(); // Close connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Author</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-style: italic;
        }

        .success {
            color: green;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add New Author</h2>
    <?php
    include_once "config.php";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Your PHP code here
        // ...
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="author_name">Author Name:</label>
            <input type="text" id="author_name" name="author_name" required>
        </div>
        <div class="form-group">
            <label for="biography">Biography:</label>
            <textarea id="biography" name="biography" required></textarea>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number">
        </div>
        <div class="form-group">
            <input type="submit" value="Add Author">
        </div>
    </form>
</div>
</body>
</html>
