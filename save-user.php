<?php ob_start(); ?>
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
$user_id = $_POST['user_id'];
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

if(empty($user_id)){
    
    if (empty($password)) {
        echo 'Password is required<br />';
        $ok = false;
    }
    if ($password != $confirm) {
        echo 'Passwords must match<br />';
        $ok = false;
    }
}

//check if email has not already been registered
if(!empty($email)){
  require_once('db.php');
    
  $sql = "SELECT email FROM users WHERE email = :email";
    
  $cmd = $conn->prepare($sql);
  $cmd->bindParam(':email', $email, PDO::PARAM_STR, 50);
  $cmd->execute();
  $users = $cmd->fetchAll();
    
 $sql = "SELECT email FROM users WHERE user_id = :user_id";
    
  $cmd = $conn->prepare($sql);
  $cmd->bindParam(':user_id', $user_id, PDO::PARAM_STR, 50);
  $cmd->execute();
  $id = $cmd->fetchAll();
    
    if(count($users) >= 1){
        if($users != $id){
        echo  'Email is already registered click <a href="register-user.php"> Here </a> To go back.'; 
        $ok = false;
        }
    }
}

//if email unique update/add to database
if ($ok){

    //hash the password
    $password = hash('sha512', $password);

    //connect to db
    require_once('db.php');

    //insert
    if (!empty($user_id)) {
	$sql = "UPDATE users SET username = :username, password = :password, email = :email WHERE user_id = :user_id";
    }
    else {
	$sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
    }
    
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
    $cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
    $cmd->bindParam(':email', $email, PDO::PARAM_STR, 50);
    if (!empty($user_id)) {
	$cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
}
    $cmd->execute();
    
    if(empty($user_id)){
    //shows message along with link to relog or previous page
    echo 'User Successfully Registered. Click <a href="logout.php">here</a> to log in.';
    }
    else{
    echo 'User Successfully Saved. Click <a href="user-list.php">here</a> to return to list of users.';    
    }
    //disconnect from db
    $conn = null;
}
}
catch(exception $e){
    //email ourselves the error details
    mail('chado94@rogers.com','User Error', $e);
    header('location:error.php');
}


?>
</body>
    
</html>

<?php ob_flush(); ?>