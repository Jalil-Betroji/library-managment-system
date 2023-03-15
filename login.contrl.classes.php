<?php
include 'login.classes.php';

class LoginContrl extends Login {
    protected $login_Email;
    private $login_Password;


    public function __construct($login_Email, $login_Password) {
       $this->login_Email = $login_Email;
       $this->login_Password = $login_Password;
    }
    
    public function emptyInputs() {
        $result;
        if (empty($this->login_Email) || empty($this->login_Password)) {
              $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
  
    private function invalidEmail() {
        $result;
        if (!filter_var($this->login_Email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    public function loginUser() {
        $login_Email = $this->login_Email;
        $login_Password = $this->login_Password;
    
        if ($this->emptyInputs() == false) {
           header('location:error.php');
           exit();
        }
        
        $this->getUser($login_Email, $login_Password);
    }
}

?>
