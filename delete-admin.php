<?php ob_start(); 
    require_once('authentication.php');
?>
<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Deleting Admin...</title>
</head>

<body>
<?php
try{
//store id in a variable
$admin_id = base64_decode($_GET['admin_id']);

//connect
require_once('db.php');

//set up the SQL DELETE command
$sql = "DELETE FROM Admin_Users WHERE admin_id = :admin_id";

//execute the deletion
$cmd = $conn->prepare($sql);
$cmd->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
$cmd->execute();

//disconnect
$conn = null;

//redirect to updated list of admins
header('location:admin-list.php');
}
catch(exception $e) {
 mail('chado94@rogers.com', 'Delete Admin Error', $e);
 header('location:error.php');
}
?>
</body>

</html>
<?php ob_flush(); ?>
