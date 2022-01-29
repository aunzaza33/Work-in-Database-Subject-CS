<?php 
    session_start();
    include('server.php'); 
    if($_GET){
        $id = $_GET['id'];
    }
    
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }
      if (!isset($_SESSION['username1'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

?>

<head>
    <meta charset="UTF-8">
    <link  rel="stylesheet" href="stylemin.css">
    <title>Welcome SE-ED Admin</title>
    <link rel="stylesheet" href="style.css">
    <link  rel="stylesheet" href="styleadmin.css">
</head>
<body>
    
    <?php require 'Se_ed_header.php';
            $goto = "books";
            require 'admin_tab.php';?>

    
    <div class="admin_container">

            <br><br>

            
            <div class="accordion_tab">
                <input type="checkbox" class="hidden" checked disabled id="chck1">
                <label class="accordion_tab-label" for="chck1">แก้ไขข้อมูลหนังสือ</label>
                <div class="accordion_tab-content">
                    <?php require('addbook.php'); ?>
                </div>
            </div>

        
    </div>


</body>
</html>
