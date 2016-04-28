<?php ob_start(); 
    require_once('authentication.php');
?>
<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Saving Password...</title>    
</head>
    
<body>
<?php
//store form inputs in variables
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$user_id = $_POST['user_id'];
$admin_id = $_POST['admin_id'];
$ok = true;

try{
//input validation
if (empty($password)) {
    echo 'Password is required<br />';
    $ok = false;
}
if ($password != $confirm) {
    echo 'Passwords must match<br />';
    $ok = false;
}

//if passwords validate update database
if ($ok){

    //hash the password
    $password = hash('sha512', $password);

    //connect to db
    require_once('db.php');

    //update correct database depending on authority
    if (!empty($user_id)) {
	$sql = "UPDATE users SET password = :password WHERE user_id = :user_id";
    }
    if (!empty($admin_id)) {
	$sql = "UPDATE Admin_Users SET password = :password WHERE admin_id = :admin_id";
    }
    
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
    //bind only neccessary parameters
    if (!empty($user_id)) {
	$cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
}
    if (!empty($admin_id)) {
	$cmd->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
}
    $cmd->execute();
    
    //disconnect from db
    $conn = null;

    //gives link to relog after password has been changed
    echo 'Password Saved. Click <a href="logout.php">here</a> to log in.';
}
}
catch(exception $e){
    //email the error details
    mail('chado94@rogers.com','User Error', $e);
    header('location:error.php');
}

?>
</body>
    
</html>