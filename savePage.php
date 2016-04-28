<?php ob_start(); ?>
<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Saving Page...</title>    
</head>
    
<body>
<?php
//store form inputs in variables
$title = $_POST['title'];
$content = $_POST['content'];
$page_id = $_POST['page_id'];
$ok = true;

try{
//input validation
if (empty($title)) {
    echo 'Title is required<br />';
    $ok = false;
}

if (empty($content)) {
    echo 'Content is required<br />';
    $ok = false;
}

//if no empty fields
if ($ok){
    
    //connect to db
    require_once('db.php');

    //insert
    if (!empty($page_id)) {
	$sql = "UPDATE pages SET title = :title, content = :content WHERE id = :id";
    }
    else {
	$sql = "INSERT INTO pages (title, content) VALUES (:title, :content)";
    }
    
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':title', $title, PDO::PARAM_STR, 50);
    $cmd->bindParam(':content', $content, PDO::PARAM_STR, 128);
    if (!empty($page_id)) {
	$cmd->bindParam(':id', $page_id, PDO::PARAM_INT);
}
    $cmd->execute();
    
    if(empty($page_id)){
    //shows message along with link to new page
    echo 'Page Successfully Created. Click <a href="default.php?id=' . base64_encode($row['id']) . '">here</a> to view page.';
    }
    else{
    echo 'Page Successfully Updated. Click <a href="default.php?id=' . base64_encode($row['id']) . '">here</a> to view page.';    
    }
    //disconnect from db
    $conn = null;
}
}
catch(exception $e){
    //email ourselves the error details
    mail('chado94@rogers.com','Save Page Error', $e);
    header('location:error.php');
}


?>
</body>
    
</html>

<?php ob_flush(); ?>