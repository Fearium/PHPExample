<?php ob_start(); ?>
<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Saving File...</title>    
</head>
    
<body>
<?php
//get the file name
$name = $_FILES['logo']['name'];

//get the extension
$type = $_FILES['logo']['type'];

//get the temporary location
$tmp_name = $_FILES['logo']['tmp_name'];

//set file name depending on file type
if($type == "image/jpeg")
$name = "logo.jpeg";

if($type == "image/png")
$name = "logo.png";
    
//move to the 'logo' directory
move_uploaded_file($tmp_name, "logo/$name");
session_start();
//store in session object to be used globally
$_SESSION['location'] = "logo/$name";

//if the file is an image, display the image
if(($type == "image/jpeg") || ($type == "image/png")){
    
    echo 'Logo Uploaded Sucessfully Click <a href="add-logo.php"> here </a> to go back';
}
else{
    echo 'Logo Could Not Be Uploaded Click <a href="add-logo.php"> here </a> to go back';
}

?>
</body>
    
</html>
<?php ob_flush(); ?>