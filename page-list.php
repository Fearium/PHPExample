<?php ob_start(); 
//insert header and make sure user has authorization for the page
require_once('authentication.php');
$title = 'Page Information';
$image = $_SESSION['location'];
require_once('header.php');

//start of try catch block
try{
    //connect to db
    require_once('db.php');

    //set up an SQL query
    $sql = "SELECT * FROM pages;";

    //execute the query and store the results
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $result = $cmd->fetchAll();

    //start table and add headings
    echo '<table class="table table-striped"><thead><th>Title</th><th>Description</th><th>View</th><th>Edit</th><th>Delete</th></thead><tbody>';

    //loop through the query result 
    foreach($result as $row) {
        //display - title, content, view, edit, delete
        echo '<tr><td>' . $row['title'] . '</td>
            <td>' . $row['content'] . '</td>
            <td><a href="default.php?id=' . base64_encode($row['id']) . '">View</a></td>
            <td><a href="addPage.php?id=' . base64_encode($row['id']) . '">Edit</a></td>
            <td><a href="delete-page.php?id=' . base64_encode($row['id']) . '" 
            onclick="return confirm(\'Are you sure you want to delete this Page?\');">Delete</a></td></tr>';
    }

    //close table 
    echo '</tbody></table>';

    //disconnect
    $conn = null;
}
catch(exception $e){
    //email the error details to myself
    mail('chado94@rogers.com','Page List Error', $e);
    header('location:error.php');
}
?>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<?
//display footer
require_once('footer.php');
ob_flush();
?>