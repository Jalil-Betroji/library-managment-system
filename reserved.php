<?php
require_once('connect.php');

if (isset($_GET["reserved_book"])) {

    $Reservation_ID = $_GET["reserved_book"];

    // Create a new Dbh object
    $dbh = new Dbh();
    // Call the connect method to establish a connection to the database
    $conn = $dbh->connect();

    // $sql = "SELECT a.Collection_ID, a.Cover_Image, a.Author_Name, a.Title, a.Edition_Date, a.Number_Of_Pages, a.State, a.Status, b.Type_Name
    // FROM `collection` a
    // INNER JOIN types b ON a.Type_ID = b.Type_ID
    // WHERE a.Collection_ID = $Reservation_ID";

    $sql = "SELECT a.Collection_ID, a.Cover_Image, a.Author_Name, a.Title, a.Edition_Date, a.Number_Of_Pages, a.State, a.Status, b.Type_Name, c.Reservation_ID, c.Nickname, d.CIN
    FROM `collection` a
    INNER JOIN types b ON a.Type_ID = b.Type_ID
    INNER JOIN reservation c ON c.Collection_ID = a.Collection_ID
    INNER JOIN client d ON d.Nickname = c.Nickname
    WHERE c.Reservation_ID = $Reservation_ID";



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