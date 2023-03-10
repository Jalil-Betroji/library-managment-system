<?php
include 'connect.php';

class Login extends Dbh{

    protected function getUser($login_Email,$login_Password){

      $stm = $this->connect()->prepare('SELECT * FROM `client` WHERE Email = ? ;');

      if (!$stm->execute([$login_Email])){          
       $stm = null ;
       header('location : error.php');
       exit();
      }
      if($stm->rowCount() == 0){
        $stm = null ;
        header("Location: error.php");
        exit();
      }
      $user = $stm->fetchAll(PDO::FETCH_ASSOC);
      $checkPass = password_verify($login_Password , $user[0]["Password"]);

      if($checkPass == false){
        $stm = null ;
        header("Location: error.php");
        exit();
      }elseif ($checkPass == true) {
         $stm = $this->connect()->prepare('SELECT * FROM `client` WHERE Email = ? And Password = ?;');
        if (!$stm->execute([$login_Email,$user[0]["Password"]])){          
          $stm = null ;
          header('location : error.php');
          exit();
        }
        if($stm->rowCount() == 0){
          $stm = null ;
          header("Location: error.php");
          exit();
        }
        $user = $stm->fetchAll(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION['Nickname'] = $user[0]["Nickname"];
        $_SESSION['First_Name'] = $user[0]["First_Name"];
        $_SESSION['Last_Name'] = $user[0]["Last_Name"];
        $_SESSION['Email'] = $user[0]["Email"];
        $_SESSION['Address'] = $user[0]["Address"];
        $_SESSION['Phone'] = $user[0]["Phone"];
        $_SESSION['Occupation'] = $user[0]["Occupation"];
        $_SESSION['Birth_Date'] = $user[0]["Birth_Date"];
      }
    }
}

?>
