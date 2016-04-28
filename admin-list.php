<?php ob_start(); 
//insert header and make sure user has authorization for the page
require_once('authentication.php');
$title = 'Admin Information';
 $image = $_SESSION['location'];
require_once('header.php');

//start of try catch block
try{
    //connect to db
    require_once('db.php');

    //set up an SQL query
    $sql = "SELECT * FROM Admin_Users;";

    //execute the query and store the results
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $result = $cmd->fetchAll();

    //start table and add headings
    echo '<table class="table table-striped"><thead><th>Username</th><th>Email</th><th>Edit</th><th>Delete</th></thead><tbody>';

    //loop through the query result 
    foreach($result as $row) {
        //display - username, email, edit and delete
        echo '<tr><td>' . $row['username'] . '</td>
            <td>' . $row['email'] . '</td>
            <td><a href="register-admin.php?admin_id=' . base64_encode($row['admin_id']) . '">Edit</a></td>
            <td><a href="delete-admin.php?admin_id=' . base64_encode($row['admin_id']) . '" 
            onclick="return confirm(\'Are you sure you want to delete this Administrator?\');">Delete</a></td></tr>';
    }

    //close table 
    echo '</tbody></table>';

    //disconnect
    $conn = null;
}
catch(exception $e){
    //email the error details to myself
    mail('chado94@rogers.com','Admin Error', $e);
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