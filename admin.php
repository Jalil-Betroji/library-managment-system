<?php
require 'connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Readly - Admin</title>
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
                    <a href="admin.php" class="nav-item nav-link active">Home</a>
                    <div class="nav-item dropdown d-flex m-1">
                        <a href="#" class="nav-item"><img class="rounded-circle" style="width:4rem; height:4rem;"
                                src="img/Review1.jpg">
                            <span class="fw-bold">
                                <?php echo $_SESSION['Nickname'] ?>
                            </span>
                        </a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="#" class="dropdown-item" id="confirm_Reservations">Reservations</a>
                            <a href="#" class="dropdown-item" id="confirmed_Reservations">confirmed reservations</a>
                            <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                data-bs-target="#add_collection_modal">Add collection</a>
                            <a href="#" class="dropdown-item" id="collection_List">Collection List</a>
                            <a href="logout.php" name="logout" class="dropdown-item">Log out</a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </header>
    <!-- ============ Header Navbar End ============ -->

    <!-- Search Start -->
    <section class="container-fluid bg-color mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
        <div class="container">
            <form action="admin.php" method="POST">
                <div class="d-flex gap-2">
                    <input type="number" class="border-0 rounded select_property p-3 container"
                        name="reservation_search" placeholder="Search by reservation ID">
                    <button type="submit" class="btn btn-dark border-0" name="RS_Searchbtn">Search</button>
                </div>
            </form>
        </div>
    </section>
    <!-- Search End -->


    <!-- =========== Reservations List Start =========== -->

    <section class="container-xxl py-5 profile_hide" id="reservation_List">
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

                        class Reservations_Library
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
                        $library = new Reservations_Library($dbh);
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

                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                        data-bs-target="#confirm_reservation_modal"
                                        onclick="getMore_Details(<?php echo $values['Reservation_ID']; ?>)">
                                        Confirm
                                    </button>

                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
    </section>

    <!-- =========== reservations List End =========== -->



    <!-- =========== Return Confirm List Start =========== -->

    <section class="container-xxl py-5 profile_hide" id="confirmed_Reservations_List">
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

                        class ReturnConfirmation
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
                              AND Reservation_Status = 'borrowed'
                              INNER JOIN types ON collection.Type_ID = types.Type_ID ;";

                                $statement = $this->conn->prepare($query);
                                $statement->execute();
                                $reservationList = $statement->fetchAll(PDO::FETCH_ASSOC);
                                return $reservationList;
                            }
                        }

                        $dbh = new Dbh();
                        $library = new ReturnConfirmation($dbh);
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

                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                        data-bs-target="#confirm_return_modal"
                                        onclick="getMore_Details(<?php echo $values['Reservation_ID']; ?>)">
                                        Confirm Return
                                    </button>

                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
    </section>

    <!-- =========== Return Confirm List End =========== -->


    <!-- =========== Collection List Start =========== -->

    <section class="container-xxl py-5" id="full_Collection_List">
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
                        if (isset($_POST['RS_Searchbtn'])) {
                            include 'search.php';
                        } else {
                            class Collection_List
                            {
                                private $conn;

                                public function __construct($dbh)
                                {
                                    $this->conn = $dbh->connect();
                                }

                                public function getreservationList()
                                {
                                    $query = "SELECT collection.Collection_ID,collection.Type_ID,Title,Author_Name,
                              Cover_Image,state,Type_Name
                              FROM collection INNER JOIN types ON collection.Type_ID = types.Type_ID ;";

                                    $statement = $this->conn->prepare($query);
                                    $statement->execute();
                                    $reservationList = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    return $reservationList;
                                }
                            }

                            $dbh = new Dbh();
                            $library = new Collection_List($dbh);
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
                                        <div class="d-flex justify-content-center gap-5 mb-1">
                                            <button type="button" class="btn btn-warning " data-bs-toggle="modal"
                                                data-bs-target="#Update_modal"
                                                onclick="getMore_Details_crud(<?php echo $values['Collection_ID']; ?>)">
                                                Update
                                            </button>
                                            <button type="button" class="btn btn-danger " data-bs-toggle="modal"
                                                data-bs-target="#Delete_modal"
                                                onclick="getMore_Details_crud(<?php echo $values['Collection_ID']; ?>)">
                                                Delete
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
    </section>

    <!-- =========== Collection List End =========== -->


    <!-- Update modal start -->

    <section class="modal fade" id="Update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- ======== -->

                    <form action="code.php" method="POST" class="row justify-content-center mt-5 w-100">
                        <div class="col">
                            <img src="" alt="" id="Update_Image" style="width:100%;height:100%;">
                        </div>
                        <div class="col-md-5 profile form-input">
                            <label for="text" class="mx-1">Title</label>
                            <input type="text" name="Update_Title" id="Update_Title" value="">

                            <label for="text" class="mx-1">Author Name</label>
                            <input type="text" name="Update_Name" id="Update_Name" value="">

                            <label for="date" class="mx-1">Edition Date</label>
                            <input type="date" name="Update_Edition" id="Update_Edition" value="">

                        </div>
                        <div class="col-md-5 profile form-input">

                            <label class="mx-1">Book Helath</label>
                            <input type="text" name="Update_Health" id="Update_Health" value="">

                            <label class="mx-1">Book availability</label>
                            <input type="text" name="Update_Status" id="Update_Status" value="">

                            <label class="mx-1">Number Of Pages</label>
                            <input type="text" name="Update_Number_Of_Pages" id="Update_Number_Of_Pages" value="">

                        </div>



                        <!-- ======== -->
                </div>
                <div class="modal-footer" method="POST" action="code.php">
                    <button type="submit" class="btn btn-primary w-45" data-bs-dismiss="modal" name="crud"
                        id="update">Update Collection</button>
                </div>
                </form>
            </div>
        </div>
    </section>


    <!-- Update modal end -->



    <!-- Delete modal start -->

    <section class="modal fade" id="Delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- ======== -->
                    <p>Are you sure you want to delete this collection ?</p>
                    <!-- ======== -->
                </div>
                <form class="modal-footer" method="POST" action="code.php">
                    <button type="submit" class="btn btn-danger w-45" data-bs-dismiss="modal" name="crud"
                        id="delete">Delete</button>
                </form>
            </div>
        </div>
    </section>


    <!-- Delete modal end -->





    <!-- confirm reservation modal start -->

    <section class="modal fade" id="confirm_reservation_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- ======== -->

                    <section class="row justify-content-center mt-5 w-100">
                        <form class="col">
                            <img src="" alt="" id="book_Image" style="width:100%;height:100%;">
                        </form>
                        <div class="col-md-5 profile form-input">
                            <input type="text" id="book_Title" value="" readonly>

                            <input type="text" id="author_Name" value="" readonly>

                            <input type="text" id="book_Type" value="" tabindex="10" readonly>

                            <input type="text" id="Edition_Date" value="" readonly>

                        </div>
                        <div class="col-md-5 profile form-input">

                            <input type="text" id="book_Health" value="" readonly>

                            <input type="text" id="book_Status" value="" readonly>

                            <input type="text" id="Nickname" value="" readonly>

                            <input type="text" id="CIN" value="" readonly>

                        </div>

                    </section>

                    <!-- ======== -->
                </div>
                <form class="modal-footer" method="POST" action="code.php">
                    <button type="submit" class="btn btn-primary w-45" data-bs-dismiss="modal" name="confirm_borrow"
                        id="borrow">confirm reservation</button>
                </form>
            </div>
        </div>
    </section>


    <!-- confirm reservation modal end -->


    <!-- confirm return modal start -->

    <section class="modal fade" id="confirm_return_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- ======== -->

                    <section class="row justify-content-center mt-5 w-100">
                        <form class="col">
                            <img src="" alt="" id="Book_Image" style="width:100%;height:100%;">
                        </form>
                        <div class="col-md-5 profile form-input">
                            <input type="text" id="Book_Title" value="" readonly>

                            <input type="text" id="Author_Name" value="" readonly>

                            <input type="text" id="Book_Type" value="" tabindex="10" readonly>

                            <input type="text" id="Edition_date" value="" readonly>

                        </div>
                        <div class="col-md-5 profile form-input">

                            <input type="text" id="Book_Health" value="" readonly>

                            <input type="text" id="Book_Status" value="" readonly>

                            <input type="text" id="nickname" value="" readonly>

                            <input type="text" id="CIN_Info" value="" readonly>

                        </div>

                    </section>

                    <!-- ======== -->
                </div>
                <form class="modal-footer" method="POST" action="code.php">
                    <button type="submit" class="btn btn-primary w-45" data-bs-dismiss="modal" name="confirm_return"
                        id="return">return</button>
                </form>
            </div>
        </div>
    </section>


    <!-- confirm return modal end -->

    <!-- Add Collection modal start -->

    <section class="modal fade" id="add_collection_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- ======== -->

                    <?php
                    class Get_type extends Dbh
                    {
                        public function get_Type_Value()
                        {
                            $sql = "SELECT Type_ID , Type_Name FROM types";
                            $stmt = $this->connect()->prepare($sql);
                            $stmt->execute();
                            return $stmt->fetchAll(PDO::FETCH_ASSOC);
                        }
                    }

                    $types_Data = new Get_type();
                    $results = $types_Data->get_Type_Value();
                    ?>

                    <form action="code.php" method="POST" class="row justify-content-center mt-5 w-100"
                        enctype="multipart/form-data">
                        <div class="col">
                            <input type="file" name="image" style="width:100%;height:100%;">
                        </div>
                        <div class="col-md-5 profile form-input">
                            <label for="text" class="mx-3">Title</label>
                            <input type="text" name="book_Title" placeholder="Book Title">

                            <label for="text" class="mx-3">Author Name</label>
                            <input type="text" name="author_Name" placeholder="Author Name">

                            <label for="text" class="mx-3">Book Type</label>
                            <select type="text" name="book_Type" style="width: 27.2rem;">
                                <option value="- Select Book Type -" selected>- Select Book Type -</option>
                                <?php foreach ($results as $values) { ?>
                                    <option value="<?php echo $values['Type_ID'] ?>"><?php echo $values['Type_Name'] ?>
                                    </option>
                                <?php } ?>
                            </select>

                            <label for="text" class="mx-3">Edition Date</label>
                            <input type="date" name="Edition_Date">
                        </div>
                        <div class="col-md-5 profile form-input">
                            <label for="text" class="mx-3">Book Health</label>
                            <input type="text" name="book_Health" placeholder="Book Health">

                            <label for="text" class="mx-3">Number of pages</label>
                            <input type="text" name="number_of_pages" placeholder="Number_Of _Pages">

                            <label for="text" class="mx-3">Date of purchase</label>
                            <input type="date" name="Buy_Date">

                            <label for="text" class="mx-3">availability</label>
                            <input type="text" name="availability" placeholder="Book availability">
                        </div>

                        <!-- ======== -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-45" data-bs-dismiss="modal" name="crud">Add
                                Collection</button>
                        </div>
                    </form>

                </div>
            </div>
    </section>


    <!-- Add Collection modal end -->



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
    <script src="js/admin.js"></script>
    <script>
        const xhttp = new XMLHttpRequest();

        book_Data = [];
        function getMore_Details(Reservation_ID) {
            console.log(Reservation_ID);

            xhttp.open("GET", "reserved.php?reserved_book=" + Reservation_ID, true);
            xhttp.send();

            // Define a callback function
            xhttp.onload = function () {
                console.log(xhttp.response);
                if (this.readyState == 4 && this.status == 200) {
                    book_Data = JSON.parse(this.response);

                    document.getElementById("book_Image").src = `img/${book_Data.Cover_Image}`;
                    document.getElementById("book_Title").value = book_Data.Title;
                    document.getElementById("author_Name").value = book_Data.Author_Name;
                    document.getElementById("book_Type").value = book_Data.Type_Name;
                    document.getElementById("Edition_Date").value = book_Data.Edition_Date;
                    document.getElementById("book_Health").value = book_Data.State;
                    document.getElementById("book_Status").value = book_Data.Status;
                    document.getElementById("Nickname").value = book_Data.Nickname;
                    document.getElementById("CIN").value = book_Data.CIN;
                    document.getElementById("borrow").setAttribute('value', book_Data.Reservation_ID);
                    // document.getElementById("delete").setAttribute('value', book_Data.Collection_ID);
                    // document.getElementById("update").setAttribute('value', book_Data.Collection_ID);

                    document.getElementById("Book_Image").src = `img/${book_Data.Cover_Image}`;
                    document.getElementById("Book_Title").value = book_Data.Title;
                    document.getElementById("Author_Name").value = book_Data.Author_Name;
                    document.getElementById("Book_Type").value = book_Data.Type_Name;
                    document.getElementById("Edition_date").value = book_Data.Edition_Date;
                    document.getElementById("Book_Health").value = book_Data.State;
                    document.getElementById("Book_Status").value = book_Data.Status;
                    document.getElementById("nickname").value = book_Data.Nickname;
                    document.getElementById("CIN_Info").value = book_Data.CIN;
                    document.getElementById("return").setAttribute('value', book_Data.Reservation_ID);

                }
            };
        }

        Book_Data = [];
        function getMore_Details_crud(Collection_ID) {
            console.log(Collection_ID);

            xhttp.open("GET", "details.php?Book_Info=" + Collection_ID, true);
            xhttp.send();

            // Define a callback function
            xhttp.onload = function () {
                console.log(xhttp.response);
                if (this.readyState == 4 && this.status == 200) {
                    Book_Data = JSON.parse(this.response);

                    document.getElementById("Update_Image").src = `img/${Book_Data.Cover_Image}`;
                    document.getElementById("Update_Title").value = Book_Data.Title;
                    document.getElementById("Update_Name").value = Book_Data.Author_Name;
                    document.getElementById("Update_Edition").value = Book_Data.Edition_Date;
                    document.getElementById("Update_Number_Of_Pages").value = Book_Data.Number_Of_Pages;
                    document.getElementById("Update_Health").value = Book_Data.State;
                    document.getElementById("Update_Status").value = Book_Data.Status;
                    document.getElementById("update").setAttribute('value', Book_Data.Collection_ID);
                    document.getElementById("delete").setAttribute('value', Book_Data.Collection_ID);
                }
            };
        }
    </script>
</body>

</html>