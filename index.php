<?php
include_once 'layout.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review Repository</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">


    <link rel="stylesheet" href="css/style.css">
    <!-- Custom CSS -->
    <style>
        .card-img-top {
            max-height: 200px; /* Adjust this value as needed */
            width: auto;
            display: block;
            margin: 0 auto; /* Centers the image horizontally */
            object-fit: cover; /* Ensures the image covers the area, may crop */
        }
        .card-body {
            padding: 10px; /* Reduces padding inside the card body */
        }
    </style>
</head>

<body>


        <div class="row" id="bookList">

            <?php
            include_once "config.php";

            // Fetch books from the database
            $sql = "SELECT * FROM books";
            $result = $conn->query($sql);
            ?>

            <!-- furniture section -->
            <section class="furniture_section layout_padding">
                <div class="container">
                    <div class="heading_container text-center mb-5">
                        <h2>Our Books</h2>
                        <p>
                            Discover the secrets of mastering productivity and achieving success with practical tips and insightful strategies in our transformative book.
                        </p>
                    </div>
                    <div class="row">
                        <?php
                        // Check if there are books in the database
                        if ($result->num_rows > 0) {
                            // Loop through each book and display its information
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <!-- Example item -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card">
                                        <img src="<?php echo $row['cover_photo']; ?>" class="card-img-top" alt="<?php echo $row['bookname']; ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $row['bookname']; ?></h5>
                                            <p class="card-text">
                                            <div class="rating">
                                                <?php
                                                // Generate rating stars based on the rating value
                                                $rating = $row['rating'];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $rating) {
                                                        echo '<i class="fas fa-star"></i>';
                                                    } else {
                                                        echo '<i class="far fa-star"></i>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            </p>
                                            <div class="price_box d-flex justify-content-between align-items-center">
                                                <h6 class="price_heading"><span>$</span><?php echo $row['price']; ?></h6>
                                                <a href="review.php?book_id=<?php echo $row['book_id']; ?>" class="btn btn-primary">Review</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No books found</p>";
                        }

                        // Close database connection
                        $conn->close();
                        ?>
                    </div>
                </div>
            </section>

               <!-- about section -->

            <section class="about_section layout_padding long_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="img-box">
                                <img src="images/6597309.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-box">
                                <div class="heading_container">
                                    <h2>
                                        Project Overview
                                    </h2>
                                </div>
                                <p>Welcome to our Book Review Web Application! This project aims to provide a platform for users to explore, review, and share their thoughts on various books across different genres.

                                    With a user-friendly interface designed with HTML, CSS, and JavaScript, we aim to create an engaging experience for book enthusiasts. Our focus on user-centric design ensures that navigating through the vast collection of book reviews is intuitive and enjoyable.

                                    Our project not only emphasizes functionality but also aesthetics. We have carefully selected color schemes, typography, and visual elements to create a visually appealing and cohesive design across all devices.

                                    We believe that a good book can change lives, and our platform seeks to facilitate the discovery of such transformative reads. Join us in building a digital haven for book lovers!
                                </p>
                                    <a href="">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- end about section -->

<?php
include_once "footer.php";
?>



            <script>

                $(document).ready(function() {
                    // Fade in each card one by one
                    $("#bookList .card").each(function(index) {
                        $(this).delay(150 * index).fadeIn(500);
                    });
                });

            </script>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>