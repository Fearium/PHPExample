<?php ob_start();

 $title = 'Change Password';
 $image = $_SESSION['location'];
 require_once('authentication.php');
 require_once('header.php');

//check for level of authentication and if any store in variable
if(isset($_GET['user_id'])){
$user_id = base64_decode($_GET['user_id']);
}
if(isset($_GET['admin_id'])){
$admin_id = base64_decode($_GET['admin_id']);
}
?>

    <form method="post" action="save-password.php" class="form form-horizontal">
    <h4>* Required Information</h4>
    <div>
        <label for="password">New Password:*</label>
        <input name="password" required type="password"/>
    </div>
    <div>
        <label for="confirm">Confirm Password:*</label>
        <input name="confirm" required type="password" />
    </div>
<?php 
//pass id of user or admin in hidden input
if(!empty($admin_id)){ ?>
<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>" />
  <?php } ?>
<?php if(!empty($user_id)){ ?>
<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
  <?php } ?>
<input type="submit" value="Save Password" />
</form>

<?php
require_once('footer.php');
ob_flush();
?>