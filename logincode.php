<?php
if(isset($_POST['login'])){
    
    //get the data from input 
    $login_Email = $_POST['signin_Email'];
    $login_Password = $_POST['signin_Password'];
    
    //initiate logincontr class
    
    include 'login.contrl.classes.php';
    $login = new LoginContrl($login_Email,$login_Password);
    $login->loginUser();

    // Going to back to homepage
    header("Location: homepage.php");
}
?>
