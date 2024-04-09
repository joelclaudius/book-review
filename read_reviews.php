<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for card animation */
        .card {
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s, transform 0.5s;
        }

        .card.animated {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <?php
        // Include the configuration file
        include_once "config.php";

        // Query to retrieve reviews with associated book names
        $sql = "SELECT r.*, b.bookname 
                FROM reviews r
                INNER JOIN books b ON r.book_id = b.book_id";

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are any reviews
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card animated">
                        <div class="card-body">
                            <h5 class="card-title">Book Name: <?php echo $row["bookname"]; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Rating: <?php echo $row["rating"]; ?></h6>
                            <p class="card-text">Review: <?php echo $row["review"]; ?></p>
                            <p class="card-text">Reviewer Name: <?php echo $row["reviewer_name"]; ?></p>
                            <p class="card-text">Reviewer Email: <?php echo $row["reviewer_email"]; ?></p>
                            <p class="card-text">Reviewer Number: <?php echo $row["reviewer_number"]; ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='col'>No reviews found</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</div>

<!-- Bootstrap JS (optional, for dropdowns, modals, etc.) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript to add animation to the cards
    document.addEventListener('DOMContentLoaded', function () {
        var cards = document.querySelectorAll('.card');
        cards.forEach(function (card, index) {
            setTimeout(function () {
                card.classList.add('animated');
            }, index * 150);
        });
    });
</script>
</body>
</html>
