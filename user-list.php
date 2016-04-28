<?php ob_start(); 
require_once('authentication.php');
$image = $_SESSION['location'];
$title = 'User Information';

require_once('header.php');

try{
    //connect to db
    require_once('db.php');

    //set up an SQL query
    $sql = "SELECT * FROM users;";

    //execute the query and store the results
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $result = $cmd->fetchAll();

    //start the table and add headings
    echo '<table class="table table-striped"><thead><th>Username</th><th>Email</th><th>Edit</th><th>Delete</th></thead><tbody>';

    //loop through the query 
    foreach($result as $row) {
        //display - username, email, edit and delete
        echo '<tr><td>' . $row['username'] . '</td>
            <td>' . $row['email'] . '</td>
            <td><a href="register-user.php?user_id=' . base64_encode($row['user_id']) . '">Edit</a></td>
            <td><a href="delete-user.php?user_id=' . base64_encode($row['user_id']) . '" 
            onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a></td></tr>';
    }

    //close table 
    echo '</tbody></table>';

    //disconnect
    $conn = null;
}
catch(exception $e){
    //email the error details
    mail('chado94@rogers.com','User Error', $e);
    header('location:error.php');
}
?>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<?
require_once('footer.php');
ob_flush();
?>