<?php ob_start();

 $title = 'Registration';
 $image = $_SESSION['location'];
 require_once('header.php');

try{
//check if the user is logged in
if (isset($_GET['user_id'])) {

	//store bot ids in variables
	$user_id = base64_decode($_GET['user_id']);
    $admin_id = base64_decode($_GET['admin_id']);

    //connect
   	require_once('db.php');
   
    //select all from active user
    $sql = "SELECT * FROM users WHERE user_id = :user_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $cmd->execute();
    $result = $cmd->fetchAll();
   
    //store each value from the database into a variable
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
    mail('chado94@rogers.com','User Registration Error', $e);
    header('location:error.php');
}
?>

<?php
//if user is logged in show link to reset password and smaller form else show full form
   if(!empty($user_id) and empty($admin_id)) { 
  echo  'Click <a href="new-password.php?user_id=' . base64_encode($row['user_id']) . '"> Here </a> To Reset Password.' 
?>
    <form method="post" action="save-user.php" class="form form-horizontal">
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
<form method="post" action="save-user.php" class="form form-horizontal">
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
    <input name="password" required type="password" />
</div>
<div>
    <label for="confirm">Confirm Password:*</label>
    <input name="confirm" required type="password"/>
</div>
<?php } ?>
<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
<input type="submit" value="Save User" />
</form>

<?
require_once('footer.php');
ob_flush();
?>