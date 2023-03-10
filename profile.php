<?php
require 'connect.php';
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>HomeLand - Profile</title>
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

    <!-- ============ Header Navbar Start ============ -->

    <header class="container-fluid nav-bar bg-transparent">
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
                    <a href="homepage.php" class="nav-item nav-link active">Home</a>
                    <a href="#footer" class="nav-item nav-link">About Us</a>


                    <div class="nav-item dropdown d-flex m-1">
                        <a href="#" class="nav-item"><img class="rounded-circle" style="width:4rem; height:4rem;"
                                src="img/Review1.jpg">
                            <span class="fw-bold">
                                <?php echo $_SESSION['Nickname'] ?>
                            </span>
                        </a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="#" class="dropdown-item" id="my_Reservation">My reservations</a>
                            <a href="#" class="dropdown-item" id="setting">Setting</a>
                            <a href="logout.php" name="logout" class="dropdown-item">Log out</a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </header>
    <!-- ============ Header Navbar End ============ -->

    <!-- =========== Announces List Start =========== -->

    <section class="container-xxl py-5" id="reservation_List">
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

                        class Library
                        {
                            private $conn;

                            public function __construct($dbh)
                            {
                                $this->conn = $dbh->connect();
                            }

                            public function getreservationList()
                            {
                                $query = "SELECT collection.Collection_ID,collection.Type_ID,Title,Author_Name,
                              Cover_Image,state,Type_Name,Reservation_ID,Reservation_Date,Reservation_Expiration_Date
                              FROM collection INNER JOIN reservation ON collection.Collection_ID = reservation.Collection_ID 
                              AND Reservation_Status = 'reserved'
                              INNER JOIN types ON collection.Type_ID = types.Type_ID ;";

                                $statement = $this->conn->prepare($query);
                                $statement->execute();
                                $reservationList = $statement->fetchAll(PDO::FETCH_ASSOC);
                                return $reservationList;
                            }
                        }

                        $dbh = new Dbh();
                        $library = new Library($dbh);
                        $reservationList = $library->getreservationList();

                        foreach ($reservationList as $values) {
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
                                    <form class="d-flex justify-content-center gap-5 mb-2">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#more_details_modal"
                                            onclick="getMore_Details(<?php echo $values['Collection_ID']; ?>)">
                                            Details
                                        </button>
                                        <button type="button" class="cancel_Reservation btn btn-warning"
                                            data-bs-toggle="modal" data-bs-target="#cancel_modal" id=""
                                            onclick="cancel_reservation(<?php echo $values['Reservation_ID']; ?>)">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
    </section>

    <!-- =========== Announces List End =========== -->


    <!-- ============ Profile Setting Start ============ -->
  <section>
    <from action="code.php" method="POST" class="row justify-content-center mt-5 w-100 profile_hide" id="Profile">

        <div class="col-md-5 profile form-input">
            <input type="text" name="profile_FName" value="<?php echo $_SESSION['First_Name']; ?>" tabindex="10" readonly>

            <input type="text" name="profile_LName" value="<?php echo $_SESSION['Last_Name']; ?>" readonly>

            <input type="email" name="profile_Email" value="<?php echo $_SESSION['Email']; ?>" tabindex="10" readonly>

            <input type="text" name="profile_Phone" value="<?php echo $_SESSION['Phone']; ?>" required>

        </div>
        <div class="col-md-5 profile form-input">

            <input type="text" name="username" value="<?php echo $_SESSION['Nickname']; ?>" tabindex="10" readonly>

            <input type="text" name="profile_Occupation" value="<?php echo $_SESSION['Occupation']; ?>" required>

            <input type="date" name="profile_Birthday" value="<?php echo $_SESSION['Birth_Date']; ?>" tabindex="10" readonly>

            <input type="text" name="profile_Address" value="<?php echo $_SESSION['Address']; ?>" tabindex="10" required>

        </div>
            <input type="submit" name="profileUpdate" class="btn btn-warning col-md-6 container" value="Update">
    </form>
</section>

    <!-- ========== Profile Setting End ======== -->


    <!-- More Details modal start -->

    <section class="modal fade" id="more_details_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

                                <h4 class="text-primary mb-4"> Edition date : <span class="text-dark" id="Edition_Date">
                                    </span>
                                </h4>

                                <h4 class="text-primary mb-4"> Health:
                                    <span class="text-dark" id="book_Health"></span>
                                </h4>

                                <h4 class="text-primary mb-4"> Status: <span class="text-dark" id="book_Status">
                                    </span></h4>

                            </div>

                        </form>
                    </div>

                    <!-- ======== -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-45" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </section>


    <!-- More Details modal end -->

    <!-- Cancel Reservation modal start -->

    <section class="modal fade" id="cancel_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- ======== -->

                    <h4 class="title text-center mt-4" id="book_Title"></h4>

                    <div class="row gap-3">
                        <div>
                            <h4 class="text-primary mb-4"> Attention <span class="text-dark">Are you sure you want to
                                    cancel this reservation ?
                                </span>
                            </h4>
                        </div>
                    </div>

                    <!-- ======== -->
                </div>
                <form class="modal-footer" method="POST" action="code.php">
                    <button type="button" class="btn btn-primary w-45" data-bs-dismiss="modal">No</button>
                    <button type="submit" name="cancel" id="cancel" class=" btn btn-danger w-45" value="">
                        Yes</button>
                </form>
            </div>
        </div>
    </section>


    <!-- Cancel Reservation modal end -->

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

    <!-- Template Javascript -->
    <script src="js/profile.js"></script>
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
                    document.getElementById("Edition_Date").innerHTML = book_Data.Edition_Date;
                    document.getElementById("book_Health").innerHTML = book_Data.State;
                    document.getElementById("book_Status").innerHTML = book_Data.Status;
                }
            };
        }
        function cancel_reservation(Reservation_ID) {
            console.log(Reservation_ID);

            xhttp.open("GET", "details.php?cancel=" + Reservation_ID, true);
            xhttp.send();

            // Define a callback function
            xhttp.onload = function () {
                console.log(xhttp.response);
                if (this.readyState == 4 && this.status == 200) {
                    reserve_id = JSON.parse(this.response);

                    document.getElementById("cancel").setAttribute('value', reserve_id.Reservation_ID);
                }
            };
        }
    </script>
</body>

</html>