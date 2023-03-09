<?php
include 'signup.classes.php';

class SignupContrl extends Signup{
    private $first_name;
    private $last_name;
    protected $signup_Email;
    private $signup_Phone;
    private $CIN;
    private $signup_Address;
    private $birth_Date;
    private $account_Type;
    private $signup_Password;
    private $signup_Re_Password;

    public function __construct($first_name,$last_name,$signup_Email,$signup_Phone,$CIN,$signup_Address,
    $birth_Date,$account_Type,$signup_Password,$signup_Re_Password){
       $this->first_name = $first_name;
       $this->last_name = $last_name;
       $this->signup_Email = $signup_Email;
       $this->signup_Phone = $signup_Phone;
       $this->CIN = $CIN;
       $this->signup_Address = $signup_Address;
       $this->birth_Date = $birth_Date;
       $this->account_Type = $account_Type;
       $this->signup_Password = $signup_Password;
       $this->signup_Re_Password = $signup_Re_Password;
    }
    public function emptyInputs(){
        $result;
        if(empty($this->first_name) || empty($this->last_name) || empty($this->signup_Email) || empty($this->signup_Phone) 
        || empty($this->CIN) || empty($this->signup_Address) || empty($this->birth_Date) || empty($this->account_Type)
        || empty($this->signup_Password) || empty($this->signup_Re_Password)){
              $result = false;
        }else{
            $result = true;
        }
        return $result;
    }
    private function invalidFName(){
        $result;
        if(!preg_match("/^[a-zA-Z0-9]*$/",$this->first_name)){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }
    private function invalidLName(){
        $result;
        if(!preg_match("/^[a-zA-Z0-9]*$/",$this->last_name)){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }
    private function invalidEmail(){
        $result;
        if(!filter_var($this->signup_Email,FILTER_VALIDATE_EMAIL)){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }
    private function passwordMatch(){
        $result;
        if($this->signup_Password !== $this->signup_Re_Password){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }
    private function userMatch(){
        $result;
       if(!$this->checkuser($this->signup_Email, $this->first_name, $this->last_name) === $this->signup_Password){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }
    public function signupUser(){
        $first_name = $this->first_name;
        $last_name = $this->last_name;
        $signup_Email = $this->signup_Email;
        $signup_Phone = $this->signup_Phone;
        $CIN = $this->CIN;
        $signup_Address = $this->signup_Address;
        $birth_Date = $this->birth_Date;
        $account_Type = $this->account_Type;
        $signup_Password = $this->signup_Password;
        $signup_Re_Password = $this->signup_Re_Password;
    
        if($this->emptyInputs() == false){
           header('location:error.php');
           exit();
        }
        if($this->invalidFName() == false){
            header('location:error.php');
            exit();
        }
        if($this->invalidLName() == false){
            header('location:error.php');
            exit();
        }
        if($this->invalidEmail() == false){
            header('location:error.php');
            exit();
        }
        if($this->passwordMatch() == false){
            header('location:error.php');
            exit();
        }
        if($this->userMatch() == false){
            header('location:error.php');
            exit();
        }
        $this->setUser($first_name,$last_name,$signup_Email,$signup_Phone,$CIN,$signup_Address,
        $birth_Date,$account_Type,$signup_Password,$signup_Re_Password);
    }
    
}

?>