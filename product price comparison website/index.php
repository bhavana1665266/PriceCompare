<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Price Comparison Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    
    <!-- Topbar End -->


    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0">
                <h1 class="text-primary m-0"><i class="fa fa-shopping-cart me-3"></i>Price Compare</h1>
                 <!--<img src="img/logo.png" alt="Logo"> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.html" class="nav-item nav-link active">Home</a>
                    <a href="#abcd" class="nav-item nav-link">About</a>
                    </div>
                    <a href="#wxyz" class="nav-item nav-link">Contact</a>
                </div>
                
            </div>
        </nav>

        <div class="container-fluid bg-primary py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row justify-content-center py-5">
                    <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                        <h1 class="display-3 text-white mb-3 animated slideInDown">Compare before you buy</h1>
                        <p class="fs-4 text-white mb-4 animated slideInDown">start searching here with us..!</p>
                        <div class="position-relative w-75 mx-auto animated slideInDown">
                        <form action="#qwerty" method="post">
                            <input class="form-control border-0 rounded-pill w-100 py-3 ps-4 pe-5" type="text" name="search" placeholder="Eg: iphone">
                          <button type="submit" class="btn btn-primary rounded-pill py-2 px-4 position-absolute top-0 end-0 me-2" style="margin-top: 7px;">Search</button>
                            </form>
                        </di>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->
    <div id="qwerty">
    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_comparison";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term = $_POST['search'];

    // Split the search term into individual words
    $search_terms = explode(' ', $search_term);

    // Construct the LIKE conditions for each word
    $like_conditions = array();
    foreach ($search_terms as $term) {
        $like_conditions[] = "title LIKE '%" . $conn->real_escape_string($term) . "%'";
    }
    $like_query_part = implode(' AND ', $like_conditions);

    // Query to search for products with the constructed LIKE conditions
    $sql1 = "SELECT title, price, rating, single_href, image_src FROM flipkart WHERE $like_query_part ORDER BY rating DESC LIMIT 8";
    $sql2 = "SELECT title, price, rating, single_href, image_src FROM amazon WHERE $like_query_part ORDER BY rating DESC LIMIT 8";
    $sql3 = "SELECT title, price, rating, single_href, image_src FROM croma WHERE $like_query_part ORDER BY rating DESC LIMIT 8";

    // Execute the queries
    $result1 = $conn->query($sql1);
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);

    // Initialize variables to store the best result
    $best_company = '';
    $best_price = PHP_INT_MAX; // Start with a high value
    $best_rating = 0; // Start with a low rating

    // Function to compare and update best result
    function updateBest($row, $company) {
        global $best_company, $best_price, $best_rating;

        if ($row['price'] < $best_price || ($row['price'] == $best_price && $row['rating'] > $best_rating)) {
            $best_company = $company;
            $best_price = $row['price'];
            $best_rating = $row['rating'];
        }
    }

    echo "<div class='results-container'>";

    // Process results for Flipkart
    if ($result1->num_rows > 0) {
        $company = 'Flipkart';
        echo "<div class='results' id='flipkart-results'>";
        echo "<h2>$company";
        if ($company === $best_company) {
            echo " <span class='best-tag'>Best</span>";
        }
        echo "</h2>";
        while ($row = $result1->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<img src='" . $row["image_src"] . "' alt='Product Image'>";
            echo "<div class='product-info'>";
            echo "<p><strong></strong> " . $row["title"] . "</p>";
            echo "<p><strong>Price:</strong> " . $row["price"] . "</p>";
            echo "<p><strong>Rating:</strong> " . $row["rating"] . "</p>";
            echo "<button onclick=\"window.open('" . $row["single_href"] . "', '_blank');\">View Product</button>";
            echo "</div>"; // Close product-info
            echo "</div>"; // Close product
        }
        echo "</div>"; // Close results
    } else {
        echo "<div class='results'>";
        echo "<h2>Flipkart</h2>";
        echo "<p>No products found.</p>";
        echo "</div>";
    }

    // Process results for Amazon
    if ($result2->num_rows > 0) {
        $company = 'Amazon';
        echo "<div class='results' id='amazon-results'>";
        echo "<h2>$company";
        if ($company === $best_company) {
            echo " <span class='best-tag'>Best</span>";
        }
        echo "</h2>";
        while ($row = $result2->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<img src='" . $row["image_src"] . "' alt='Product Image'>";
            echo "<div class='product-info'>";
            echo "<p><strong></strong> " . $row["title"] . "</p>";
            echo "<p><strong>Price:</strong> " . $row["price"] . "</p>";
            echo "<p><strong>Rating:</strong> " . $row["rating"] . "</p>";
            echo "<button onclick=\"window.open('" . $row["single_href"] . "', '_blank');\">View Product</button>";
            echo "</div>"; // Close product-info
            echo "</div>"; // Close product
        }
        echo "</div>"; // Close results
    } else {
        echo "<div class='results'>";
        echo "<h2>Amazon</h2>";
        echo "<p>No products found.</p>";
        echo "</div>";
    }

    // Process results for Croma
    if ($result3->num_rows > 0) {
        $company = 'Croma';
        echo "<div class='results' id='croma-results'>";
        echo "<h2>$company";
        if ($company === $best_company) {
            echo " <span class='best-tag'>Best</span>";
        }
        echo "</h2>";
        while ($row = $result3->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<img src='" . $row["image_src"] . "' alt='Product Image'>";
            echo "<div class='product-info'>";
            echo "<p><strong></strong> " . $row["title"] . "</p>";
            echo "<p><strong>Price:</strong> " . $row["price"] . "</p>";
            echo "<p><strong>Rating:</strong> " . $row["rating"] . "</p>";
            echo "<button onclick=\"window.open('" . $row["single_href"] . "', '_blank');\">View Product</button>";
            echo "</div>"; // Close product-info
            echo "</div>"; // Close product
        }
        echo "</div>"; // Close results
    } else {
        echo "<div class='results'>";
        echo "<h2>Croma</h2>";
        echo "<p>No products found.</p>";
        echo "</div>";
    }

    echo "</div>"; // Close results-container
}

$conn->close();
?>




    <!-- About Start -->
    <div class="container-xxl py-5" id="abcd">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="img/about.jpg" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                    <h1 class="mb-4">compare from multiple <span class="text-primary">sites</span></h1>
                    <p class="mb-4">This is a platform where you con compare prices and ratings of products from multiple E-commerce websites such as Amazon, FlipKart and Croma</p>
                    <p class="mb-4">We make your way easier to compare the prices, ratings and choose the right platform to engage with and buy products with the links provided which redirects you to the product location</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Search For Products</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>check the details</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>click on view product</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>check out product</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>buy easily after comparing</p>
                        </div>
                        
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="">compare with us !</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
      <!-- Contact Start -->
    <div class="container-xxl py-5" id="wxyz">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Contact Us</h6>
                <h1 class="mb-5">Contact For Any Query</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h5>Get In Touch</h5>
                    <p class="mb-4">For any queries contact us with the details provided below</p>
                    <div class="d-flex align-items-center mb-4">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                            <i class="fa fa-map-marker-alt text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-primary">Location</h5>
                            <p class="mb-0">Vardhaman College of Engineering ,Shamshabad</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                            <i class="fa fa-phone-alt text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-primary">Mobile</h5>
                            <p class="mb-0">+012 345 67890</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                            <i class="fa fa-envelope-open text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-primary">Email</h5>
                            <p class="mb-0">pricecompare@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div style="width: 100%"><iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=vardhaman%20college+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.gps.ie/">gps tracker sport</a></iframe></div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Contact End -->
    

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>