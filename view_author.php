<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #28a745;
            color: #fff;
            margin-right: 5px;
        }
        .delete-btn {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>
<h2>Authors List</h2>
<table>
    <thead>
    <tr>
        <th>Author ID</th>
        <th>Author Name</th>
        <th>Biography</th>
        <th>Date of Birth</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Include config file
    include_once "config.php";

    // Function to fetch authors from the database
    function getAuthors() {
        global $conn;

        // Initialize an empty array to store authors
        $authors = array();

        // Prepare SQL query to select all authors
        $sql = "SELECT * FROM authors";

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Loop through each row and fetch the data
            while ($row = $result->fetch_assoc()) {
                // Add the fetched author data to the $authors array
                $authors[] = $row;
            }
        }

        // Return the array of authors
        return $authors;
    }

    // Function to delete an author
    function deleteAuthor($author_id) {
        global $conn;

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

    // Example usage of the function
    $authors = getAuthors();

    // Output the authors
    if (!empty($authors)) {
        foreach ($authors as $author) {
            echo "<tr>";
            echo "<td>{$author['author_id']}</td>";
            echo "<td>{$author['author_name']}</td>";
            echo "<td>{$author['biography']}</td>";
            echo "<td>{$author['date_of_birth']}</td>";
            echo "<td>{$author['email']}</td>";
            echo "<td>{$author['phone_number']}</td>";
            echo "<td>";
            echo "<a href='edit_author.php?author_id={$author['author_id']}' class='edit-btn'>Edit</a>";
            echo "<button class='delete-btn' onclick='deleteAuthor({$author['author_id']})'>Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No authors found.</td></tr>";
    }
    ?>
    </tbody>
</table>

<script>
    // JavaScript function to confirm and delete an author
    function deleteAuthor(author_id) {
        if (confirm("Are you sure you want to delete this author?")) {
            window.location.href = "delete_author.php?author_id=" + author_id;
        }
    }
</script>
</body>
</html>
