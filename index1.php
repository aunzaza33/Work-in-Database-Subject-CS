
<?php 
    session_start();
    include('server.php'); 
    if (!isset($_SESSION['username1'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register SE-AD member</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php require 'Se_ed_header.php';?>


</body>
</html>