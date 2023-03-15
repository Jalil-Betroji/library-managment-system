<?php
require 'connect.php';
session_start();

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


?>