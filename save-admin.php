<?php ob_start(); 
    require_once('authentication.php');
?>
<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Saving Registration...</title>    
</head>
    
<body>
<?php
//store form inputs in variables
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$admin_id = $_POST['admin_id'];
$ok = true;


try{
//input validation
if (empty($email)) {
    echo 'Email is required<br />';
    $ok = false;
}

if (empty($username)) {
    echo 'Username is required<br />';
    $ok = false;
}

if(empty($admin_id)){
    
if (empty($password)) {
    echo 'Password is required<br />';
    $ok = false;
}
if ($password != $confirm) {
    echo 'Passwords must match<br />';
    $ok = false;
}
}

//check if email has already been used
if(!empty($email)){
  require_once('db.php');
    
  $sql = "SELECT email FROM Admin_Users WHERE email = :email";
    
  $cmd = $conn->prepare($sql);
  $cmd->bindParam(':email', $email, PDO::PARAM_STR, 50);
  $cmd->execute();
  $admins = $cmd->fetchAll();
    
  $sql = "SELECT email FROM Admin_Users WHERE admin_id = :admin_id";
    
  $cmd = $conn->prepare($sql);
  $cmd->bindParam(':admin_id', $admin_id, PDO::PARAM_STR, 50);
  $cmd->execute();
  $ids = $cmd->fetchAll();
    
    if(count($admins) >= 1){
        if($admins != $ids){
        echo 'Email address already registered click <a href="register-admin.php"> here </a> to go back.';
        $ok = false;
        }
    }
}

//if email is unique add/update the database
if ($ok){

    //hash the password
    $password = hash('sha512', $password);

    //insert
    if (!empty($admin_id)) {
	$sql = "UPDATE Admin_Users SET username = :username, password = :password, email = :email WHERE admin_id = :admin_id";
    }
    else {
	$sql = "INSERT INTO Admin_Users (username, password, email) VALUES (:username, :password, :email)";
    }
    
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
    $cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
    $cmd->bindParam(':email', $email, PDO::PARAM_STR, 50);
    if (!empty($admin_id)) {
	$cmd->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
}
    $cmd->execute();
    
    //disconnect from db
    $conn = null;

    if(empty($admin_id)){
    //shows message with link to return to previous page
    echo 'Admin Successfully Registered. Click <a href="admin-list.php">here</a> to return to list of admins.';
    }
    else{
    echo 'Admin Successfully Saved. Click <a href="admin-list.php">here</a> to return to list of admins.';   
    }
}
}

catch(exception $e) {
 mail('chado94@rogers.com', 'Delete Admin Error', $e);
 header('location:error.php');
}

?>
</body>
    
</html>
<?php ob_flush(); ?>