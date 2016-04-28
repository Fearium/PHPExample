<?php ob_start();

 require_once('authentication.php');
 $title = 'Upload Logo';
 $image = $_SESSION['location'];
 require_once('header.php');
?>

<!-- Form to get file and pass values to save logo -->
<div class="container">
    <form method="post" action="save-logo.php" class="form form-horizontal" enctype="multipart/form-data">
        <h4>Upload a Logo</h4>
            <label for="logo" class="col-sm-2">Logo: </label>
            <input type="file" name="logo" />
        <input type="submit" value="Save Logo" class="col-sm-offset-3"/>
    </form>
</div>
<?
require_once('footer.php');
ob_flush();
?>