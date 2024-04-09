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

<div class="hero_area">
    <header class="header_section long_section px-0">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="#">
                <span>Book Review </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
                    <ul class="navbar-nav  ">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="create.php">Data Demo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="review.php">Reviews</a>
                        </li>
                    </ul>
                </div>
<!--                <div class="quote_btn-container">-->
<!--                    <a href="#">-->
<!--                        <span>Login</span>-->
<!--                        <i class="fa fa-user" aria-hidden="true"></i>-->
<!--                    </a>-->
<!--                    <form class="form-inline">-->
<!--                        <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">-->
<!--                            <i class="fa fa-search" aria-hidden="true"></i>-->
<!--                        </button>-->
<!--                    </form>-->
<!--                </div>-->
            </div>
        </nav>
    </header>
    <section class="slider_section long_section">
        <div id="customCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="detail-box">
                                    <h1>Discover Your Next Read</h1>
                                    <p>Explore insightful book reviews curated just for you. Find your next captivating
                                        read and share your thoughts on beloved classics.</p>
                                    <div class="btn-box">
                                        <a href="#" class="btn1">Explore Reviews</a>
                                        <a href="#" class="btn2">Submit a Review</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="img-box">
                                    <img src="images/slider-img.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ol class="carousel-indicators">
                <li data-target="#customCarousel" data-slide-to="0" class="active"></li>
            </ol>
        </div>
    </section>
</div>




<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>