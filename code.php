<?php
require_once 'connect.php';
session_start();
if (isset($_POST['signup'])) {

    //get the data from input 
    $first_name = $_POST['signup_FN'];
    $last_name = $_POST['signup_LN'];
    $signup_Email = $_POST['signup_Email'];
    $signup_Phone = $_POST['signup_Phone'];
    $CIN = $_POST['CIN'];
    $signup_Address = $_POST['signup_Address'];
    $birth_Date = $_POST['birth_Date'];
    $account_Type = $_POST['account_Type'];
    $signup_Password = $_POST['signup_Password'];
    $signup_Re_Password = $_POST['signup_Re_Password'];

    //initiate signupcontr class
    // include 'connect.php';

    include 'signup.contrl.classes.php';
    $signup = new SignupContrl(
        $first_name,
        $last_name,
        $signup_Email,
        $signup_Phone,
        $CIN,
        $signup_Address,
        $birth_Date,
        $account_Type,
        $signup_Password,
        $signup_Re_Password
    );
    $result = $signup->signupUser(
        $first_name,
        $last_name,
        $signup_Email,
        $signup_Phone,
        $CIN,
        $signup_Address,
        $birth_Date,
        $account_Type,
        $signup_Password,
        $signup_Re_Password
    );


    // Going to back to homepage
    // header("Location: hoomepage.php");
}

if (isset($_POST['borrow'])) {
    // retrieve the collection ID from the form data
    $collection_ID = $_POST['borrow'];

    // retrieve the nickname of the current user from the session
    $nickname = $_SESSION['Nickname'];

    // create a new database connection
    $dbh = new Dbh();
    $conn = $dbh->connect();

    // check if the user has already borrowed or reserved three books
    $stmt = $conn->prepare("SELECT COUNT(*) FROM reservation WHERE Nickname = :nickname 
    AND (Reservation_Status = 'borrowed' OR Reservation_Status = 'reserved')");
    $stmt->bindParam(':nickname', $nickname);
    $stmt->execute();
    $reserved_count = $stmt->fetchColumn();
    if ($reserved_count >= 3) {
        // the user has already reserved three books
        echo "You have already reserved three books.";
        exit();
    }

    // check if the item is not torn
    $stmt = $conn->prepare("SELECT COUNT(*) FROM collection WHERE Collection_ID = :collection_id AND Status = 'available'");
    $stmt->bindParam(':collection_id', $collection_ID);
    $stmt->execute();
    $available_count = $stmt->fetchColumn();
    if ($available_count == 0) {
        // the item is torn and cannot be borrowed or reserved
        echo "This item is torn and cannot be borrowed or reserved.";
        exit();
    }

    // check if the item has not already been reserved
    $stmt = $conn->prepare("SELECT COUNT(*) FROM reservation WHERE Collection_ID = :collection_id AND Reservation_Status = 'reserved'");
    $stmt->bindParam(':collection_id', $collection_ID);
    $stmt->execute();
    $reserved_count = $stmt->fetchColumn();
    if ($reserved_count > 0) {
        // the item has already been reserved
        echo "This item has already been reserved.";
        exit();
    }

    // reserve the item for the current user
    try {
        // begin a transaction
        $conn->beginTransaction();

        // insert the new reservation record
        $stmt = $conn->prepare("INSERT INTO reservation (Reservation_Date, Reservation_Expiration_Date, Collection_ID, Nickname, Reservation_Status)
                                VALUES (:reservation_date, :reservation_expiration_date, :collection_id, :nickname, 'reserved')");
        $stmt->bindParam(':reservation_date', date('Y-m-d H:i:s'));
        $stmt->bindParam(':reservation_expiration_date', date('Y-m-d H:i:s', strtotime('+24 hours')));
        $stmt->bindParam(':collection_id', $collection_ID);
        $stmt->bindParam(':nickname', $nickname);
        $stmt->execute();

        // update the collection record to indicate that it has been reserved
        $stmt = $conn->prepare("UPDATE collection SET Status = 'reserved' WHERE Collection_ID = :collection_id");
        $stmt->bindParam(':collection_id', $collection_ID);
        $stmt->execute();

        // commit the transaction
        $conn->commit();

        // redirect to the profile page
        header('Location: profile.php');
        exit();
    } catch (PDOException $e) {
        // rollback the transaction on error
        $conn->rollBack();
        echo "Error reserving the item: " . $e->getMessage();
        exit();
    }
}
// Delete expired reservations
$dbh = new Dbh();
$conn = $dbh->connect();
$deleteSql = "DELETE FROM reservation WHERE Reservation_Date < DATE_SUB(NOW(), INTERVAL 24 HOUR) AND Collection_ID NOT IN (SELECT Collection_ID FROM borrowings)";
$deleteStmt = $conn->prepare($deleteSql);
$deleteStmt->execute();
?>