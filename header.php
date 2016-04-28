<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title><?php echo $title; ?></title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    
</head>
    
<body>
    
    <?php 
    if(empty($image)){
    $image = 'logo/ozz.png';
    }
    ?>
        
    <img src="<?php echo $image; ?>" alt="Logo" align="left" height="100" width="100" />
    
    <nav class="nav navbar-default">
        <ul class="nav navbar-nav"> 
    <?php 

    //show all links if user has admin rights
    if(!empty($_SESSION['admin_id'])) {
    ?>
        <li><a href="register-admin.php">Register Admin</a></li>
        <li><a href="register-user.php">Register User</a></li>
        <li><a href="addPage.php">Add Page</a></li>
        <li><a href="admin-list.php">List Admins</a></li>
        <li><a href="user-list.php">List Users</a></li>
        <li><a href="page-list.php">List Pages</a></li>
        <li><a href="add-logo.php">Upload Logo</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul>
        
    <?php 
    }
    //show some links if user hase user rights
    if(!empty($_SESSION['user_id'])) {
    ?>
        <li><a href="user-list.php">List Users</a></li>
        <li><a href="addPage.php">Add Page</a></li>
        
        <?php
        require_once('db.php');
        $sql = "SELECT * FROM pages;";

        //execute the query and store the results
        $cmd = $conn->prepare($sql);
        $cmd->execute();
        $result = $cmd->fetchAll();
        
        foreach($result as $row){
        echo '<li><a href="default.php?id="' . $row['id'] . '">' . $row['title'] . '</a></li>';
        }
        ?>
        
        <li><a href="logout.php">Log Out</a></li>
    </ul>
    <?php
    }
    //show limited links if user has no rights
    if(empty($_SESSION['user_id']) and empty($_SESSION['admin_id']))
    {
    ?>
        <li><a href="register-user.php">Register</a></li>
        <li><a href="login.php">Log In</a></li>
        <?php
        require_once('db.php');
        $sql = "SELECT * FROM pages;";

        //execute the query and store the results
        $cmd = $conn->prepare($sql);
        $cmd->execute();
        $result = $cmd->fetchAll();
        
        foreach($result as $row){
        echo '<li><a href="default.php?id="' . $row['id'] . '">' . $row['title'] . '</a></li>';
        }
        ?>
    <?php
     $conn = null;
    }
    ?>
    </ul>
    </nav>