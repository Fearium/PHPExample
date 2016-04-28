<?php ob_start();
 require_once('authentication.php');
 $title = 'Add Page';
 $image = $_SESSION['location'];
 require_once('header.php');

try{
//check for the page id
if (isset($_GET['id'])) {

	//store id in variable
	$id = base64_decode($_GET['id']);

    //connect
   	require_once('db.php');
   
    //select all from pages
    $sql = "SELECT * FROM pages WHERE id = :id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':id', $id, PDO::PARAM_INT);
    $cmd->execute();
    $result = $cmd->fetchAll();
   
    //store each value from the database into a variable
    foreach ($result as $row) {
    	$title_current = $row['title'];
    	$content = $row['content'];
        $id = $row['id'];
    }
   
    //disconnect
	$conn = null;
}
}
    
catch(exception $e){
    //email the error details
    mail('chado94@rogers.com','Page Registration Error', $e);
    header('location:error.php');
}
?>
    <!-- Form to pass information to save page  -->
    <form method="post" action="savePage.php" class="form form-horizontal">
    <h4>* Required Information</h4>
    <div>
        <label for="title">Title:*</label>
        <input name="title" required value="<?php echo $title_current; ?>" />
    </div>
    <div>
        <label for="content">Description:*</label>
        <textarea name="content" rows="25" cols="70"> <?php echo $content; ?> </textarea>
    </div>
<input type="hidden" name="page_id" value="<?php echo $id; ?>" />
<input type="submit" value="Save Page" />
</form>

<?
require_once('footer.php');
ob_flush();
?>