<?php ob_start(); 
    require_once('authentication.php');
?>
<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Deleting Page...</title>
</head>

<body>
<?php
try{
//store id in a variable
$page_id = base64_decode($_GET['id']);

//connect
require_once('db.php');

//set up the SQL DELETE command
$sql = "DELETE FROM pages WHERE id = :id";

//execute the deletion
$cmd = $conn->prepare($sql);
$cmd->bindParam(':id', $page_id, PDO::PARAM_INT);
$cmd->execute();

//disconnect
$conn = null;

//redirect to updated list of pages
header('location:page-list.php');
}
catch(exception $e) {
 mail('chado94@rogers.com', 'Delete Page Error', $e);
 header('location:error.php');
}
?>
</body>

</html>
<?php ob_flush(); ?>
