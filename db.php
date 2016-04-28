<?php
    //connect to db
    $conn = new PDO('mysql:host=sql.computerstudi.es;dbname=gc200301048','gc200301048','H6c3Z3th');
    //enable pdo debugging
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
