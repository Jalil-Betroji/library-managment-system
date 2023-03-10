<?php
require_once('connect.php');

if (isset($_GET["Book_Info"])) {

    $Collection_ID = $_GET["Book_Info"];

    // Create a new Dbh object
    $dbh = new Dbh();
    // Call the connect method to establish a connection to the database
    $conn = $dbh->connect();

    $sql = "SELECT Collection_ID,Cover_Image,Author_Name,Title,Edition_Date,State,Status,Type_Name
     FROM `collection` INNER JOIN types ON  collection.Collection_ID = $Collection_ID ";

    // execute a query
    $statement = $conn->query($sql);

    // fetch all rows
    $annonce = $statement->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    echo json_encode($annonce);

}
if (isset($_GET["cancel"])) {

    $Reservation_ID = $_GET["cancel"];

    // Create a new Dbh object
    $dbh = new Dbh();
    // Call the connect method to establish a connection to the database
    $conn = $dbh->connect();

    $sql = "SELECT Reservation_ID
     FROM `reservation` WHERE  Reservation_ID = $Reservation_ID AND Reservation_Status = 'reserved' ";

    // execute a query
    $statement = $conn->query($sql);

    // fetch all rows
    $reserve_id = $statement->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    echo json_encode($reserve_id);
}

?>