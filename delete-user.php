<?php ob_start(); 
    require_once('authentication.php');
?>
<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Deleting User...</title>
</head>

<body>
<?php
try{
//store id in a variable
$user_id = base64_decode($_GET['user_id']);

//connect
require_once('db.php');

//set up the SQL DELETE command
$sql = "DELETE FROM users WHERE user_id = :user_id";

//execute the deletion
$cmd = $conn->prepare($sql);
$cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$cmd->execute();

//disconnect
$conn = null;

//redirect to updated list of admins
header('location:user-list.php');
}
catch(exception $e) {
 mail('chado94@rogers.com', 'Delete User Error', $e);
 header('location:error.php');
}
?>
</body>

</html>
<?php ob_flush(); ?>
