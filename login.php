<?php 
ob_start();
$title = 'Log In';
session_start();
$image = $_SESSION['location'];
require_once('header.php');
?>

<div class="container">
<h1>Log In</h1>
<form method="post" action="validate.php" class="form-horizontal">
<div class="form-group">
    <label for="username" class="col-sm-2">Username:</label>
    <input name="username" />
</div>
<div class="form-group">
    <label for="password" class="col-sm-2">Password:</label>
    <input type="password" name="password" />
</div>

<div class="col-sm-offset-2">
    <input type="submit" value="Log In" class="btn btn-success" />
</div>
</form>
</div>
<?
require_once('footer.php');
ob_flush();
?>