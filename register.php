<?php 
    session_start();
    include('server.php'); 
    if (isset($_REQUEST['reset'])) {
        unset($_SESSION['username']);
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

    <div class="headerregister">
        <h2>อีเมลที่ใช้ติดต่อระบบ</h2>
    </div>
    <div class="login">
    <form action="register_db.php" method="post" autocomplete="off">
        <?php include('errors.php'); ?>
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
        <label for="username">อีเมลในการเข้าสู่ระบบ:</label>
        <?php if (!isset($_SESSION['username'])) : ?>
            <input type="email" name="username" pattern="[A-Za-z\0-9]{4,60}@[A-Za-z]{4,60}.[A-Za-z]{2,6}" >
            <?php endif ?>
        <?php if (isset($_SESSION['username'])) : ?>
            <?php 
                        echo $_SESSION['username'];
                        
                        
                    ?>
        <?php endif ?>
           
        </div>
        <div class="input-groupcheck">
        <?php if (!isset($_SESSION['username'])) : ?>
            <button type="submit" name="checkemail"></button>
            <label for="check">กรุณาเลือก เพื่อตรวจสอบอีเมล ป้องกันการใช้ซ้ำในระบบ</label>
            <?php endif ?>
        <?php if (isset($_SESSION['username'])) : ?>
            <label for="check">อีเมลนี้สามารถใช้งานได้</label>
        <?php endif ?>
        </div>
        <div class="input-group1">
            <label for="email">ยืนยันอีเมล:</label>
            <input type="email" name="email"pattern="[A-Za-z\0-9]{4,60}@[A-Za-z]{4,60}.[A-Za-z]{2,6}">
        </div>
        <div class="input-group2">
            <label for="password_1">รหัสผ่าน:</label>
            <input type="password" name="password_1"pattern="[A-Za-z\0-9]{4,20}">
        </div>
        <div class="input-group3">
            <label for="password_2">ยืนยันรหัสผ่าน:</label>
            <input type="password" name="password_2"pattern="[A-Za-z\0-9]{4,20}">
        </div>
        <div class="input-group4">
            <label for="name">ชื่อ:</label>
            <input type="text" name="name"pattern="[A-Za-z|ก-๙]{4,20}">
        </div>
        <div class="input-group5">
            <label for="surname">นามสกุล:</label>
            <input type="text" name="surname" pattern="[A-Za-z|ก-๙]{4,20}" >
        </div>
        <div class="input-group6">
            <label for="sex">เพศ:</label>
            <input type="radio" name="sex" value="ชาย" checked>ชาย
            <input type="radio" name="sex" value="หญิง">หญิง
        </div>
        <div class="input-group7">
            <label for="date">วันเกิด:</label>
            <input type="date" name="date">
        </div>
        <div class="input-group8">
            <label for="phone">โทรศัพท์:</label>
            <input type="text" name="phone"pattern="[0-9]{4,20}">
        </div>
        <div class="input-group9">
            <label for="mobile">มือถือ:</label>
            <input type="text" name="mobile"pattern="[0-9]{4,20}">
        </div>
        
        <div class="input-group10">
            
            <a href="?reset" class="reset">ล้างข้อมูล</a>
            <button type="submit" name="reg_user" class="btn">ยืนยันการสมัคร</button>
            
            

            
        </div>
        <p>กลับสู่หน้า Login <a href="login.php">Sign in</a></p>
        <p> <a href="index0.php">กลับสู่หน้าหลัก</a></p>
    </form>
    <br><br>
    </div>

</body>
</html>