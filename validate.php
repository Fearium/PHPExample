<?php ob_start(); ?>

<html>

<body>

<?php
//store user inputs and hash passowrd
$username = $_POST['username'];
$password = hash('sha512', $_POST['password']);
$ok = false;

//connect to db
require_once('db.php');

//setup sql
$sql = "SELECT admin_id FROM Admin_Users WHERE username = :username AND password = :password";

//bind param and execute sql
$cmd = $conn->prepare($sql);
$cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
$cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
$cmd->execute();
$adminResult = $cmd->fetchAll();

if (count($adminResult) >= 1) {
	echo 'Logged in Successfully.';
    //store identity before they leave the page
    foreach  ($adminResult as $row) {
        //access the existing session
        session_start();
        //store the admin id in the session object
        $_SESSION['admin_id'] = $row['admin_id'];
        //redirect to list of admins
        header('location:admin-list.php');
    }
}

//store user inputs and hash passowrd
$username = $_POST['username'];
$password = hash('sha512', $_POST['password']);
    
$sql = "SELECT user_id FROM users WHERE username = :username AND password = :password";

//bind param and execute sql
$cmd = $conn->prepare($sql);
$cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
$cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
$cmd->execute();
$userResult = $cmd->fetchAll();

//check how many users matched the username hashed passowrd
if (count($userResult) >= 1) {
	echo 'Logged in Successfully.';
    //store identity before they leave the page
    foreach  ($userResult as $row) {
        //access the existing session
        session_start();
        //store the user id in the session object
        $_SESSION['user_id'] = $row['user_id'];
        //redirect to athletes.php
        header('location:user-list.php');
    }
}

	echo 'Invalid Login Click <a href="login.php">here</a> to retry.';

//disconnect from db
$conn = null;

?>

</body>
</html>
<?php ob_flush(); ?>
