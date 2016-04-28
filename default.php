<?php ob_start();

if (isset($_GET['id'])){
    $id = base64_decode($_GET['id']);
    
    require_once('db.php');
    $sql = "SELECT * FROM pages  WHERE id = :id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':id', $id, PDO::PARAM_INT);
    $cmd->execute();
    $result = $cmd->fetchAll();
    
    foreach ($result as $row) {
    	$page_title = $row['title'];
        $content = $row['content'];
    }
}
 $title = "$page_title";
 require_once('authentication.php');
 $image = $_SESSION['location'];
 require_once('header.php');

try{
   
    //select all from active page
    $sql = "SELECT * FROM pages WHERE id = :id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':id', $id, PDO::PARAM_INT);
    $cmd->execute();
    $result = $cmd->fetchAll();
   
    //store content into variable
    foreach ($result as $row) {
    	$content = $row['content'];
    }
   
    //disconnect
	$conn = null;
}
catch(exception $e){
    //email the error details
    mail('chado94@rogers.com','Default Page Error', $e);
    header('location:error.php');
}

echo '<h1>' . $page_title . '</h1>';
echo '<p class="text-center" style="padding: 0 25px">' . $content . '</p>';

require_once('footer.php');
ob_flush();
?>