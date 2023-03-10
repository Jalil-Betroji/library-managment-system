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

// Cancel the reservzation 

if (isset($_POST['cancel'])) {
    $reservation_Id = $_POST['cancel'];
    echo $reservation_Id;
    $dbh = new Dbh();
    $conn = $dbh->connect();
    // $cancelsql = "DELETE FROM reservation WHERE Reservation_ID = :reservationId";
    // $cancelstm = $conn->prepare($cancelsql);
    // $cancelstm->bindValue(":reservationId", $reservation_Id, PDO::PARAM_INT);
    // $cancelstm->execute();

    $getcollection_ID ="SELECT Collection_ID FROM reservation WHERE Reservation_ID = :reservationId";
    $updatestatus = $conn->prepare($getcollection_ID);
    $updatestatus->bindValue(":reservationId", $reservation_Id, PDO::PARAM_INT);
    $updatestatus->execute();
    print_r($updatestatus) ;
    $updatecollection = "UPDATE collection SET Status = 'available' WHERE Collection_ID = $collection_ID";
    // header("Location:profile.php");
}

// Update the profile info 

// if(isset($_POST['profileUpdate'])){

//   $first_Name = $_POST['profile_FName'];
//   $last_Name = $_POST['profile_LName'];
//   $phone = $_POST['profile_Phone'];
//   $email = $_POST['profile_Email'];
//   $username = $_POST['username'];
//   $birthday = $_POST['profile_Birthday'];
//   $address = $_POST['profile_Address'];
//   $occupation = $_POST['profile_Occupation'];

// class Database extends Dbh{

//     public function updateClientInfo($username, $first_Name , $last_Name , $phone , $email , $birthday , $address , $occupation ) {
        
//         $existing_clients = $this->connect()->prepare("SELECT * FROM client WHERE Phone = :phone OR Email = :email");
//         $existing_clients->execute(['nickname' => $username,'phone' => $phone, 'email' => $email]);
//         $existing_client = $existing_clients->fetch(PDO::FETCH_ASSOC);
//         if ($existing_client && $existing_client['Nickname'] != $username) {
//             return "Error: phone, email, or username already exists";
//         }
//         $update_fields = [];
//         if (!is_null($username)) {
//             $update_fields[] = "Nickname = :username";
//         }
//         if (!is_null($first_Name)) {
//             $update_fields[] = "First_Name = :first_Name";
//         }
//         if (!is_null($last_Name)) {
//             $update_fields[] = "Last_Name = :last_Name";
//         }
//         if (!is_null($birthday)) {
//             $update_fields[] = "Birth_Date = :birthday";
//         }
//         if (!is_null($address)) {
//             $update_fields[] = "Address = :address";
//         }
//         if (!is_null($occupation)) {
//             $update_fields[] = "Occupation = :occupation";
//         }
//         if (!is_null($phone)) {
//             $update_fields[] = "Phone = :phone";
//         }
//         if (!is_null($email)) {
//             $update_fields[] = "Email = :email";
//         }
        
//         if (count($update_fields) > 0) {
//             $update_query = "UPDATE client SET " . implode(", ", $update_fields) . " WHERE Nickname = :username";
//             $stmt = $this->connect()->prepare($update_query);
//             $stmt->bindParam(':username', $username, PDO::PARAM_INT);
//             if (!is_null($first_Name)) {
//                 $stmt->bindParam(':first_Name', $first_Name, PDO::PARAM_STR);
//             }
//             if (!is_null($last_Name)) {
//                 $stmt->bindParam(':last_Name', $last_Name, PDO::PARAM_STR);
//             }
//             if (!is_null($phone)) {
//                 $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
//             }
//             if (!is_null($email)) {
//                 $stmt->bindParam(':email', $email, PDO::PARAM_STR);
//             }
//             if (!is_null($username)) {
//                 $stmt->bindParam(':username', $username, PDO::PARAM_STR);
//             }
//             if (!is_null($birthday)) {
//                 $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
//             }
//             if (!is_null($address)) {
//                 $stmt->bindParam(':address', $address, PDO::PARAM_STR);
//             }
//             if (!is_null($occupation)) {
//                 $stmt->bindParam(':occupation', $occupation, PDO::PARAM_STR);
//             }
//         }
//     }
//  }


// }
?>