<?php
require_once('connect.php');

if (isset($_GET["Book_Info"])) {

    $Collection_ID = $_GET["Book_Info"];

    // Create a new Dbh object
    $dbh = new Dbh();
    // Call the connect method to establish a connection to the database
    $conn = $dbh->connect();

    $sql = "SELECT * FROM `collection` WHERE Collection_ID = $Collection_ID ";

    // execute a query
    $statement = $conn->query($sql);

    // fetch all rows
    $annonce = $statement->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    echo json_encode($annonce);

}
?>