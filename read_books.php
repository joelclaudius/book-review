<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .book {
            border-bottom: 1px solid #ccc;
            padding: 20px 0;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .book img {
            float: left;
            margin-right: 20px;
            max-width: 200px;
            height: auto;
            border-radius: 5px;
        }

        .book-info {
            overflow: hidden;
        }

        .book-info h3 {
            margin-top: 0;
        }

        .book-info p {
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .book img {
                float: none;
                margin: 0 auto 20px;
                display: block;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Our Books</h2>
    <?php
    include_once "config.php";

    // Perform SQL query to fetch books data
    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='book'>";
            echo "<img src='" . $row["cover_photo"] . "' alt='Cover Photo'>";
            echo "<div class='book-info'>";
            echo "<h3>" . $row["bookname"] . "</h3>";
            echo "<p><strong>Book ID:</strong> " . $row["book_id"] . "</p>";
            echo "<p><strong>Author ID:</strong> " . $row["author_id"] . "</p>";
            echo "<p><strong>Date Published:</strong> " . $row["date_published"] . "</p>";
            echo "<p><strong>Description:</strong> " . $row["description"] . "</p>";
            echo "<p><strong>ISBN:</strong> " . $row["isbn"] . "</p>";
            // Delete Button
            echo "<form action='delete_book.php' method='post'>";
            echo "<input type='hidden' name='book_id' value='" . $row["book_id"] . "'>";
            echo "<button type='submit'>Delete</button>";
            echo "</form>";
            // Edit Button
            echo "<form action='edit_book.php' method='get'>";
            echo "<input type='hidden' name='book_id' value='" . $row["book_id"] . "'>";
            echo "<button type='submit'>Edit</button>";
            echo "</form>";
            echo "</div>"; // Close .book-info
            echo "</div>"; // Close .book
        }
    } else {
        echo "<p>No results found</p>";
    }

    $conn->close();
    ?>
</div>
</body>
</html>
