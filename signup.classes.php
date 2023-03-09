<?php
include 'connect.php';

class Signup extends Dbh{

    protected function setUser($first_name,$last_name,$signup_Email,$signup_Phone,$CIN,$signup_Address,
    $birth_Date,$account_Type,$signup_Password,$signup_Re_Password){
      $stm = $this->connect()->prepare('INSERT INTO `client`(
        Nickname,
        First_Name,	
        Last_Name,	
        Password,	
        Address,	
        Email,	
        Phone,	
        CIN,	
        Occupation,	
        Penalty_Count,
        Birth_Date,
        Admin
        ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);');
    $hashedPw = password_hash($signup_Password, PASSWORD_DEFAULT);
    if (!$stm->execute([$first_name."_".$last_name,$first_name,$last_name,$hashedPw,$signup_Address,$signup_Email,$signup_Phone,$CIN,
        $account_Type,0,$birth_Date,0])){     
        
    $stm = null ;
    header('location : index.php');
    exit();
    }
}

protected function checkuser($signup_Email,$first_name,$last_name){
     $stm = $this->connect()->prepare('SELECT Nickname AND Email FROM `client` WHERE Email = ? AND Nickname = ?;');
     if(!$stm->execute([$signup_Email,$first_name."_".$last_name])){
       $stm = null ;
       header('location : index.php');
       exit();
     }
     $resultCheck;
     if($stm->rowCount() > 0){
       $resultCheck = false ;
     }else{
        $resultCheck = true ;
     }
     return $resultCheck;
   }
}

?>