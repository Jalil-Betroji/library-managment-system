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


    // Going to back to index
    header("Location: index.php");
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

// confirm reservation by admin

class Reservation extends Dbh
{

    public function getReservationData($Reservation_ID)
    {
        $sql = "SELECT Nickname, Reservation_ID , Collection_ID FROM reservation WHERE Reservation_ID = :Reservation_ID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(":Reservation_ID", $Reservation_ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function confirmBorrow()
    {
        if (isset($_POST['confirm_borrow'])) {
            $Reservation_ID = $_POST['confirm_borrow'];

            $reservationData = $this->getReservationData($Reservation_ID);
            $Reservation_ID = $reservationData[0]['Reservation_ID'];
            $Nickname = $reservationData[0]['Nickname'];
            $collection_ID = $reservationData[0]['Collection_ID'];
            $insertBorrowing = $this->connect()->prepare("INSERT INTO borrowings (
                Borrowing_Date,
                Borrowing_Expire_Date,
                Reservation_ID,
                Nickname,
                Status
                )
            VALUES (:Borrowing_Date, :Borrowing_Expire_Date ,:Reservation_ID, :Nickname,'borrowed')");

            $currentDate = date('Y-m-d H:i:s');
            $expireDate = date('Y-m-d H:i:s', strtotime('+15 days'));
            $insertBorrowing->bindParam(':Borrowing_Date', $currentDate);
            $insertBorrowing->bindParam(':Borrowing_Expire_Date', $expireDate);
            $insertBorrowing->bindParam(':Reservation_ID', $Reservation_ID);
            $insertBorrowing->bindParam(':Nickname', $Nickname);
            $insertBorrowing->execute();

            $update_Collection_Status = $this->connect()->prepare("UPDATE collection SET Status = 'borrowed' WHERE Collection_ID = :collectionId");
            $update_Collection_Status->bindParam(':collectionId', $collection_ID);
            $update_Collection_Status->execute();

            $update_Reservation_Status = $this->connect()->prepare("UPDATE reservation SET Reservation_Status = 'borrowed' WHERE Reservation_ID = :Reservation_ID");
            $update_Reservation_Status->bindParam(':Reservation_ID', $Reservation_ID);
            $update_Reservation_Status->execute();

            header("Location:admin.php");
        }
    }
}

$reservation = new Reservation();
$reservation->confirmBorrow();

//confirm returned collection 

class Returned_Collection extends Dbh
{
    public function getReservationData($Reservation_ID)
    {
        $sql = "SELECT Collection_ID, Nickname FROM reservation WHERE Reservation_ID = :Reservation_ID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(":Reservation_ID", $Reservation_ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function returnCollection()
    {
        if (isset($_POST['confirm_return'])) {
            $Reservation_ID = $_POST['confirm_return'];

            $get_Reserved_Data = $this->getReservationData($Reservation_ID);
            echo $Reservation_ID;
            $Nickname = $get_Reserved_Data[0]['Nickname'];
            $Collection_ID = $get_Reserved_Data[0]['Collection_ID'];

            $get_Borrowing_Date = $this->connect()->prepare("SELECT Borrowing_Expire_Date FROM borrowings WHERE Reservation_ID =:Reservation_ID");
            $get_Borrowing_Date->bindParam(":Reservation_ID", $Reservation_ID);
            $get_Borrowing_Date->execute();
            print_r($get_Borrowing_Date);
            $Borrowing_Expire_Date = $get_Reserved_Data[0]['Borrowing_Expire_Date'];

            $return_Date = date('Y-m-d H:i:s');

            // $borrowing_Period = ;
            // $borrowing_Period = floor($borrowing_Period / (60 * 60 * 24)); // convert to days

            // check if the borrowing period is more than 15 days
            if (strtotime($return_Date) > strtotime($Borrowing_Expire_Date)) {
                $penalty_count_stmt = $this->connect()->prepare("SELECT Penalty_Count FROM client WHERE Nickname = :Nickname");
                $penalty_count_stmt->bindParam(':Nickname', $Nickname);
                $penalty_count_stmt->execute();
                $penalty_count = $penalty_count_stmt->fetchColumn();


                // increase the penalty count and check if it exceeds 3
                if ($penalty_count = 2) {
                    $this->connect()->prepare("UPDATE client SET Penalty_Count = Penalty_Count + 1, Account_Status = 'locked' WHERE Nickname = :Nickname")->execute(array(':Nickname' => $Nickname));
                    $_SESSION['logged_in'] = false;
                } elseif ($penalty_count < 2) {
                    $this->connect()->prepare("UPDATE client SET Penalty_Count = Penalty_Count + 1 WHERE Nickname = :Nickname")->execute(array(':Nickname' => $Nickname));
                }
            }

            // update the borrowing status and return date
            $update_borrowing = $this->connect()->prepare("UPDATE borrowings SET Status = 'returned' , Borrowing_Return_Date = :Borrowing_Return_Date WHERE Reservation_ID = :Reservation_ID");
            $update_borrowing->bindParam(':Reservation_ID', $Reservation_ID);
            $update_borrowing->bindParam(':Borrowing_Return_Date', $return_Date);
            $update_borrowing->execute();

            // update the collection status
            $update_Collection_Status = $this->connect()->prepare("UPDATE collection SET Status = 'available' WHERE Collection_ID = :collectionId");
            $update_Collection_Status->bindParam(':collectionId', $Collection_ID);
            $update_Collection_Status->execute();

            // update the reservation status
            $update_Reservation_Status = $this->connect()->prepare("UPDATE reservation SET Reservation_Status = 'returned' WHERE Reservation_ID = :Reservation_ID");
            $update_Reservation_Status->bindParam(':Reservation_ID', $Reservation_ID);
            $update_Reservation_Status->execute();

            header("Location:admin.php?message=Book has been successfully returned");
            exit;
        }
    }
}

$reservation = new Returned_Collection();
$reservation->returnCollection();

// Cancel the reservzation 

if (isset($_POST['cancel'])) {
    $reservation_Id = $_POST['cancel'];
    echo $reservation_Id;

    $dbh = new Dbh();
    $conn = $dbh->connect();

    $getcollection_ID = "SELECT Collection_ID FROM reservation WHERE Reservation_ID = :reservationId";
    $updatestatus = $conn->prepare($getcollection_ID);
    $updatestatus->bindValue(":reservationId", $reservation_Id, PDO::PARAM_INT);
    $updatestatus->execute();
    $collection_ID = $updatestatus->fetchColumn();
    echo $collection_ID;
    $updatecollection = "UPDATE collection SET Status = 'available' WHERE Collection_ID = :collectionId";
    $updatestmt = $conn->prepare($updatecollection);
    $updatestmt->bindValue(":collectionId", $collection_ID, PDO::PARAM_INT);
    $updatestmt->execute();

    $cancelsql = "DELETE FROM reservation WHERE Reservation_ID = :reservationId";
    $cancelstm = $conn->prepare($cancelsql);
    $cancelstm->bindValue(":reservationId", $reservation_Id, PDO::PARAM_INT);
    $cancelstm->execute();


    header("Location:profile.php");
    exit();
}


// Update the profile info 

if (isset($_POST['profileUpdate'])) {

    $first_Name = $_POST['profile_FName'];
    $last_Name = $_POST['profile_LName'];
    $phone = $_POST['profile_Phone'];
    $email = $_POST['profile_Email'];
    $username = $_POST['username'];
    $birthday = $_POST['profile_Birthday'];
    $address = $_POST['profile_Address'];
    $occupation = $_POST['profile_Occupation'];

    class UpdateProfile extends Dbh
    {

        public function updateClientInfo($username, $first_Name, $last_Name, $phone, $email, $birthday, $address, $occupation)
        {
            $existing_clients = $this->connect()->prepare("SELECT * FROM client WHERE Phone = :phone OR Email = :email");
            $existing_clients->execute([':phone' => $phone, ':email' => $email]);
            $existing_client = $existing_clients->fetch(PDO::FETCH_ASSOC);
            if ($existing_client && $existing_client['Nickname'] != $username) {
                header("Location: code.php?error= phone, email, or username already exists");
            }

            $update_query = "UPDATE client SET first_Name = :first_Name ,last_Name = :last_Name,
                Phone = :phone, Email = :email, Birth_Date = :birthday,
                Address = :address, Occupation = :occupation WHERE Nickname = :username";
            $stmt = $this->connect()->prepare($update_query);
            $stmt->bindParam(':first_Name', $first_Name);
            $stmt->bindParam(':last_Name', $last_Name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':birthday', $birthday);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':occupation', $occupation);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            header("Location:profile.php");

        }
    }
    // create an object of UpdateProfile class
    $updateProfile = new UpdateProfile();

    // call the updateClientInfo method
    $updateProfile->updateClientInfo($username, $first_Name, $last_Name, $phone, $email, $birthday, $address, $occupation);

}


// CRUD 

if (isset($_POST['crud'])) {
    $collection_ID = $_POST['crud'];
    $Update_Title = $_POST['Update_Title'];
    $Update_Name = $_POST['Update_Name'];
    $Update_Edition = $_POST['Update_Edition'];
    $Update_Number_Of_Pages = $_POST['Update_Number_Of_Pages'];
    $Update_Health = $_POST['Update_Health'];
    $Update_Status = $_POST['Update_Status'];

    // Sanitize user input
    $type_id = filter_input(INPUT_POST, 'book_Type', FILTER_SANITIZE_NUMBER_INT);
    $title = filter_input(INPUT_POST, 'book_Title', FILTER_SANITIZE_STRING);
    $author_name = filter_input(INPUT_POST, 'author_Name', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'book_Health', FILTER_SANITIZE_STRING);
    $edition_date = filter_input(INPUT_POST, 'Edition_Date', FILTER_SANITIZE_STRING);
    $num_pages = filter_input(INPUT_POST, 'number_of_pages', FILTER_SANITIZE_NUMBER_INT);
    $buy_date = filter_input(INPUT_POST, 'Buy_Date', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'availability', FILTER_SANITIZE_STRING);
    echo $type_id;

    // Validate user input
    if ($type_id === '' || $title === '' || $author_name === '' || $state === '' || $edition_date === '' || $num_pages === '' || $buy_date === '' || $status === '') {
        // If any required field is missing or empty, redirect to the add collection page with an error message
        header("Location: admin.php?error=required_fields_missing");
        exit();
    }


    // Validate cover image
    $cover_image = $_FILES['image'];
    if (!$cover_image['tmp_name']) {
        // If no cover image is uploaded, use a default image
        header("Location: admin.php.php?error=image file can't be empty");
    } else {
        // Check if the uploaded file is an image
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_info = new finfo(FILEINFO_MIME_TYPE);
        $file_extension = array_search($file_info->file($_FILES['image']['tmp_name']), array(
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif'
        ), true);
        if (!$file_extension) {
            // If the uploaded file is not an image, redirect to the add collection page with an error message
            header("Location: admin.php.php?error=invalid_file_type");
            exit();
        }
        // Generate a unique filename for the uploaded image
        $new_filename = uniqid() . '.' . $file_extension;
        // Set the target directory and path where the uploaded image will be saved
        $target_dir = 'img/';
        $target_path = $target_dir . $new_filename;
        // Move the uploaded image to the target directory
        move_uploaded_file($cover_image['tmp_name'], $target_path);
        $cover_image = $new_filename;
        echo "<br>";
        echo $cover_image;
    }

    class Crud extends Dbh
    {
        public function crud_Update($Update_Title, $Update_Name, $Update_Edition, $Update_Number_Of_Pages, $Update_Health, $Update_Status, $collection_ID)
        {
            $sql = $this->connect()->prepare("UPDATE collection 
            SET 	
                Title = :Update_Title, 
                Author_Name = :Update_Name, 
                State = :Update_Health, 
                Edition_Date = :Update_Edition, 
                Number_Of_Pages = :Update_Number_Of_Pages, 
                Status = :Update_Status
            WHERE 
                Collection_ID = :Collection_ID");
            $sql->bindParam(':Update_Title', $Update_Title);
            $sql->bindParam(':Update_Name', $Update_Name);
            $sql->bindParam(':Update_Health', $Update_Health);
            $sql->bindParam(':Update_Edition', $Update_Edition);
            $sql->bindParam(':Update_Number_Of_Pages', $Update_Number_Of_Pages);
            $sql->bindParam(':Update_Status', $Update_Status);
            $sql->bindParam(':Collection_ID', $collection_ID);
            $sql->execute();
            header("Location:admin.php");
        }
        public function crud_Delete($collection_ID)
        {
            $sql = $this->connect()->prepare("DELETE FROM collection WHERE Collection_ID = :Collection_ID");

            $sql->bindParam(':Collection_ID', $collection_ID);
            $sql->execute();
        }
        public function addbook(
            $type_id,
            $title,
            $author_name,
            $state,
            $edition_date,
            $cover_image,
            $num_pages,
            $buy_date,
            $status
        )
        {
            $sql = "INSERT INTO collection (
            Type_ID,
            Title,
            Author_Name,
            Cover_Image,
            State,
            Edition_Date,
            Number_Of_Pages,
            Buy_Date,
            Status
        ) VALUES (:Type_ID, :Title, :Author_Name, :Cover_Image, :State, :Edition_Date, :Number_Of_Pages, :Buy_Date, :Status)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':Type_ID', $type_id);
            $stmt->bindParam(':Title', $title);
            $stmt->bindParam(':Author_Name', $author_name);
            $stmt->bindParam(':Cover_Image', $cover_image);
            $stmt->bindParam(':State', $state);
            $stmt->bindParam(':Edition_Date', $edition_date);
            $stmt->bindParam(':Number_Of_Pages', $num_pages);
            $stmt->bindParam(':Buy_Date', $buy_date);
            $stmt->bindParam(':Status', $status);
            echo print_r($stmt);
            $stmt->execute();
        }
    }
    $curd_Apply = new Crud();
    $curd_Apply->crud_Update(
        $Update_Title,
        $Update_Name,
        $Update_Edition,
        $Update_Number_Of_Pages,
        $Update_Health,
        $Update_Status,
        $collection_ID
    );
    $curd_Apply->crud_Delete($collection_ID);
    $curd_Apply->addbook(
        $type_id,
        $title,
        $author_name,
        $state,
        $edition_date,
        $cover_image,
        $num_pages,
        $buy_date,
        $status
    );

}

?>