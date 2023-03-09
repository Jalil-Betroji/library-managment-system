<?php
require_once 'connect.php';
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>HomeLand - Real Estate</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontsAwesome -->

    <script src="https://kit.fontawesome.com/ad59909c53.js" crossorigin="anonymous"></script>

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <main class="container-xxl bg-white p-0">


        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="index.html" class="navbar-brand d-flex align-items-center text-center">
                    <div class="icon me-2">
                        <img class="img-fluid" src="img/logo2.png" alt="Icon" style="width: 4rem; height: 4rem;">
                    </div>
                    <h1 class="m-0 text-color">Readly</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="index.html" class="nav-item nav-link active">Home</a>
                        <a href="#footer" class="nav-item nav-link">About</a>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                        <div class="nav-item dropdown d-flex m-1">

                            <a href="#" class="nav-item"><img class="rounded-circle" style="width:4rem; height:4rem;"
                                    src="img/Review1.jpg">
                                <span class="fw-bold">
                                    <?php echo $_SESSION['Nickname']; ?>
                                </span>
                            </a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="profile.php" class="dropdown-item" id="my_announces">Profile</a>
                                <a href="logout.php" name="logout" class="dropdown-item">Log out</a>
                            </div>

                        </div>
                    </div>
            </nav>
        </div>
        <!-- Navbar End -->


        <!-- Header Start -->
        <header class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 animated fadeIn mb-4">Find Your <span class="text-color">inspiration
                            books</span>
                        in our platform </h1>
                    <p class="animated fadeIn mb-4 pb-2">in our platform we provide the best books .</p>
                </div>
                <div class="col-md-6 animated fadeIn">
                    <div class="owl-carousel header-carousel">
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="img/breadcrumbs.jpg" alt="">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="img/ChildOfTheKindred.jpg" alt="">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="img/graveSecret.jpg" alt="">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="img/HarryPotter.jpg" alt="">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="img/bond king.webp" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->


        <!-- Search Start -->
        <section class="container-fluid bg-color mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
            <div class="container">
                <form action="librarypage.php" method="POST">
                    <div class="d-flex gap-2 justify-content-centerflex-wrap">
                        <input type="text" class="border-0 rounded select_property p-3 container" name="book_Search"
                            placeholder="Search about your book">
                        <button class="btn btn-dark border-0" name="searchbtn">Search</button>
                    </div>
                </form>
            </div>
        </section>
        <!-- Search End -->

        <!-- =========== Announces List Start =========== -->

        <section class="container-xxl py-5">
            <div class="container">
                <div class="row g-0 gx-5 align-items-end">
                    <div class="col-lg-6">
                        <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                            <h1 class="mb-3">library List</h1>
                            <p>in our platform we provide you the best books .</p>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <?php
                            if (isset($_POST['searchbtn'])) {
                                include 'search.php';
                            } else {
                                class Library
                                {
                                    private $conn;

                                    public function __construct($dbh)
                                    {
                                        $this->conn = $dbh->connect();
                                    }

                                    public function getLibraryList()
                                    {
                                        $query = "SELECT collection.Collection_ID,collection.Type_ID,Title,Author_Name,
                              Cover_Image,state,types.Type_Name
                              FROM collection INNER JOIN types ON collection.Type_ID = types.Type_ID;";

                                        $statement = $this->conn->prepare($query);
                                        $statement->execute();
                                        $libraryList = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        return $libraryList;
                                    }
                                }

                                $dbh = new Dbh();
                                $library = new Library($dbh);
                                $libraryList = $library->getLibraryList();

                                foreach ($libraryList as $values) {
                                    ?>
                                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                        <div class="property-item rounded overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <a href=""><img class="size img-fluid"
                                                        src="img/<?php echo $values['Cover_Image'] ?>" alt=""></a>
                                                <div
                                                    class="bg-color rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                                    <?php echo $values['Type_Name'] ?>
                                                </div>
                                                <div
                                                    class="bg-white rounded-top text-color position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                                                    <?php echo $values['state'] ?>
                                                </div>
                                            </div>
                                            <div class="p-4 pb-0">
                                                <a class="d-block h5 mb-2" href="">
                                                    <?php echo $values['Title'] ?>
                                                </a>
                                                <p><i class="fa-solid fa-pen-nib text-color me-2"></i>
                                                    <?php echo $values['Author_Name'] ?>
                                                </p>
                                            </div>

                                            <button class="btn btn-primary w-100" data-bs-toggle="modal"
                                                data-bs-target="#more_details_modal"
                                                onclick="getMore_Details(<?php echo $values['Collection_ID']; ?>)">More
                                                Details</button>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <!-- =========== Announces List End =========== -->



                    <!-- More Details modal start -->

                    <section class="modal fade" id="more_details_modal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog-centered modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- ======== -->

                                    <h4 class="title text-center mt-4" id="book_Title"></h4>

                                    <div class="row gap-3">
                                        <form class="col">
                                            <img src="" alt="" id="book_Image" style="width:100%;height:100%;">
                                        </form>
                                        <form class="col-lg-5 px-3">

                                            <div>
                                                <h4 class="text-primary mb-4"> Author Name : <span class="text-dark"
                                                        id="author_Name"></span>
                                                </h4>

                                                <h4 class="text-primary mb-4"> Book Type : <span class="text-dark"
                                                        id="book_Type"></span></h4>

                                                <h4 class="text-primary mb-4"> Edition date : <span class="text-dark"
                                                        id="book_Edition">
                                                        m2</span>
                                                </h4>

                                                <h4 class="text-primary mb-4"> Health:
                                                    <span class="text-dark" id="book_Health"></span>
                                                </h4>

                                                <h4 class="text-primary mb-4"> Status: <span class="text-dark"
                                                        id="book_Status">
                                                    </span></h4>

                                            </div>

                                        </form>
                                    </div>

                                    <!-- ======== -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary w-45"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <a href="messenger.html"><button type="button" class="btn btn-primary w-45">
                                            Reserve</button></a>
                                </div>
                            </div>
                        </div>
                    </section>


                    <!-- More detaials modal end -->

    </main>

    <!-- Footer Start -->
    <footer id="footer" class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Get In Touch</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Morocco,Tanger-Ahlan</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+212 567182560</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>support@Readly.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-4">Quick Links</h5>
                    <a class="btn btn-link text-white-50" href="">About Us</a>
                    <a class="btn btn-link text-white-50" href="">Contact Us</a>
                    <a class="btn btn-link text-white-50" href="">Our Services</a>
                    <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                    <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white mb-4">Newsletter</h5>
                    <p>Subscribe to our Newsletter to get in touch with every new Book.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5 email_Validation" type="text"
                            placeholder="Your email">
                        <button type="button"
                            class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Subscribe</button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <img src="img/logo1.png" alt="" style="width: 15rem;height: 15rem;">
                </div>


            </div>
        </div>
        <div class="copyright d-flex justify-content-center">
            <p>&copy; <a class="border-bottom" href="#">Readly.com</a>,
                All Right
                Reserved.2023-2024
            </p>
        </div>
    </footer>

    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        const xhttp = new XMLHttpRequest();

        book_Data = [];
        function getMore_Details(Collection_ID) {
            console.log(Collection_ID);

            xhttp.open("GET", "details.php?Book_Info=" + Collection_ID, true);
            xhttp.send();

            // Define a callback function
            xhttp.onload = function () {
                console.log(xhttp.response);
                if (this.readyState == 4 && this.status == 200) {
                    book_Data = JSON.parse(this.response);

                    document.getElementById("book_Image").src = `img/${book_Data.Cover_Image}`;
                    document.getElementById("book_Title").innerHTML = book_Data.Title;
                    document.getElementById("author_Name").innerHTML = book_Data.Author_Name;
                    document.getElementById("book_Type").innerHTML = book_Data.Type_Name;
                    document.getElementById("book_Edition").innerHTML = book_Data.Edition_Date;
                    document.getElementById("book_Health").innerHTML = book_Data.State;
                    document.getElementById("book_Status").innerHTML = book_Data.Status;
                }
            };
        }
    </script>
</body>

</html>