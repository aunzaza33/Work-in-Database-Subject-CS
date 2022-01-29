<?php
    session_start();
    include('server.php'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
    
    
</head>
<body>

    <?php require 'Se_ed_header.php';?>
    
    <table style="margin:auto;width:100%;">
        <tr>
            <td>
        <div class="headerlogin">
        <h2>สมัครสมาชิก</h2>
</div>
<div class="login">
   <form>
        <div class="input-group">
        <br><br>
            <label for="text">กรุณาคลิกปุ่มสมัครสมาชิกด้านล่างเพื่อเข้าสู่ขั้นตอนสมัครสมาชิก</label>
        </div>
        <div class="input-group10">
        <br><br> 
        <a href="register.php">
            <p>สมัครสมาชิก</p></a>
            <br><br><br><br>
        </div>
        </form> 
        </aside>

</div>

            </td>

            <td>

    <div class="headerlogin">
        <h2>เข้าสู่ระบบ / Login</h2>
    </div>
<div class="login">
    <form action="login_db.php" method="post" autocomplete="off">
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <h3>
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="input-group">
            <label for="username">อีเมลในการเข้าสู่ระบบ</label>
            <input type="text" name="email">
        </div>
        <div class="input-group2">
            <label for="password">รหัสผ่าน</label>
            <input type="password" name="password">
        </div>
        <div class="input-groupcheck">
            <input type="checkbox" name="status">
            <label for="check">อยู่ในสถานะลงชื่อเข้าใช้</label>
        </div>
        <div class="input-group">
            <button type="submit" name="login_user" class="btnlogin">เข้าสู่ระบบ</button>
        </div>
        <div class="input-group11">
            <label for="or">หรือ</label>
            <br>
            <a href="https://www.facebook.com/";>
            <img src="login_with_facebook.png" alt="Jane" style="width:50%;height:40px;"></a>
        </div>
       
        
    </form>
</div>
            </td>
        <tr>
    <table>

        
</body>
</html>