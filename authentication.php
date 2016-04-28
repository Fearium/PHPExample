<?php
    session_start();
//check if there is current session, if not redirect to login page
if(empty($_SESSION['user_id']) and empty($_SESSION['admin_id'])){
    header('location:login.php');
    exit();
}
?>
