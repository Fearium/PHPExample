<?php
ob_start();

//access current session
session_start();

//remove any vaiables from the session
session_unset();

//kill the session
session_destroy();

//redirect
header('location:login.php');

ob_flush();
?>