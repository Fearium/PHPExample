<?php ob_start();

 $title = 'Admin Registration';
 require_once('authentication.php');
 $image = $_SESSION['location'];
 require_once('header.php');

try{
    //check if user is an admin
    if (isset($_GET['admin_id'])) {

	//store ids in a variable
	$admin_id = base64_decode($_GET['admin_id']);
    $user_id = base64_decode($_GET['user_id']);

    //connect
   	require_once('db.php');
   
    //select all from active admin
    $sql = "SELECT * FROM Admin_Users WHERE admin_id = :admin_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
    $cmd->execute();
    $result = $cmd->fetchAll();
   
    //store some values from the database into variables
    foreach ($result as $row) {
    	$username = $row['username'];
    	$email = $row['email'];
    }
   
    //disconnect
	$conn = null;
}
}
catch(exception $e){
    //email the error details
    mail('chado94@rogers.com','Admin Registration Error', $e);
    header('location:error.php');
}
?>

<?php
//if admin is logged in show link to reset password and smaller form else show full form
    if(!empty($admin_id) and empty($user_id)) { 
    echo  'Click <a href="new-password.php?admin_id=' . base64_encode($row['admin_id']) . '"> Here </a> To Reset Password.'
?>
    <form method="post" action="save-admin.php" class="form form-horizontal">
    <h4>* Required Information</h4>
    <div>
        <label for="username">Username:*</label>
        <input name="username" required value="<?php echo $username; ?>" />
    </div>
    <div>
        <label for="email">Email:*</label>
        <input name="email" required type="email" value="<?php echo $email; ?>" />
    </div>
<?php } 
   else{
?>
<form method="post" action="save-admin.php" class="form form-horizontal">
<h4>* Required Information</h4>
<div>
    <label for="username">Username:*</label>
    <input name="username" required />
</div>
<div>
    <label for="email">Email:*</label>
    <input name="email" required type="email" />
</div>
<div>
    <label for="password">Password:*</label>
    <input name="password" required type="password"/>
</div>
<div>
    <label for="confirm">Confirm Password:*</label>
    <input name="confirm" required type="password"/>
</div>
<?php } ?>
<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>" />
<input type="submit" value="Save Admin" />
</form>

<?
require_once('footer.php');
ob_flush();
?>