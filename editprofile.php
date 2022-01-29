<?php 
    session_start();
    include('server.php'); 
    $username= $_SESSION['username1'];
    $catagory_check_query_user = "SELECT * FROM member WHERE email = '$username'";
    $query_catagory_user = mysqli_query($conn, $catagory_check_query_user);
    $row_user = mysqli_fetch_array($query_catagory_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php require 'Se_ed_header.php';?>

    <div class="headerregister">
        <h2>แก้ไขข้อมูลส่วนตัว</h2>
    </div>
    <div class="login">
    <form action="editprofile_db.php" method="post">
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
        <?php echo $username1?>
        </div>
       
            <?php 
             if(!isset($_SESSION['password_0'])):
            ?>
            <div class="input-group5">
            <label for="name">ชื่อ-สกุล:</label>
            <?php echo $row_user['Cus_Name']?>
            <?php echo $row_user['Cus_LName'];  ?> 
             </div>
             <div class="input-group8">
            <label for="phone">โทรศัพท์:</label>
            <?php echo $row_user['Cus_PhoneNum'];  ?> 
             </div>
             <div class="input-group9">
            <label for="mobile">มือถือ:</label>
            <?php echo $row_user['Cus_mobile'];  ?>
            </div>
             <div class="input-group2">
            <label for="password_0">รหัสผ่าน:</label>
            <input type="password" name="password_0"pattern="[A-Za-z\0-9]{4,20}">
             </div>
            <div class="input-groupcheck">
            <button type="submit" name="submit-pass">แก้ไขข้อมูล</button>
        </div>
            <?php endif?>
            <?php 
             if(isset($_SESSION['password_0'])):
            ?>
       
      
        <div class="input-group4">
            <label for="name">ชื่อ:</label>
            <input type="text" name="name"pattern="[A-Za-z|ก-๙]{4,20}"  value = <?php echo $row_user['Cus_Name'];  ?> >
        </div>
        <div class="input-group5">
            <label for="surname">นามสกุล:</label>
            <input type="text" name="surname" pattern="[A-Za-z|ก-๙]{4,20}"value = <?php echo $row_user['Cus_LName'];  ?> >
        </div>
        <div class="input-group6">
            <label for="sex">เพศ:</label>
            <?php 
             if($row_user['Cus_sex']=='ชาย'):
            ?>
            <input type="radio" name="sex" value="ชาย" checked>ชาย
            <input type="radio" name="sex" value="หญิง">หญิง
            <?php endif?>
            <?php 
             if($row_user['Cus_sex']=='หญิง'):
            ?>
            <input type="radio" name="sex" value="ชาย" >ชาย
            <input type="radio" name="sex" value="หญิง" checked>หญิง
            <?php endif?>
            
        </div>
        <div class="input-group7">
            <label for="date">วันเกิด:</label>
            <input type="date" name="date"value = <?php echo $row_user['Cus_BDate'];  ?>>
        </div>
        <div class="input-group6">
            <label for="address">ที่อยู่:</label>
            <center><textarea name="address"cols="20" rows="5"  ><?php echo $row_user['Cus_Address'];?></textarea></center>
        </div>
        <div class="input-group8">
            <label for="phone">โทรศัพท์:</label>
            <input type="text" name="phone"pattern="[0-9]{4,20}"value = <?php echo $row_user['Cus_PhoneNum'];  ?> >
        </div>
        <div class="input-group9">
            <label for="mobile">มือถือ:</label>
            <input type="text" name="mobile"pattern="[0-9]{4,20}"value = <?php echo $row_user['Cus_mobile'];  ?>>
        </div>
        
        <div class="input-group10">
            <button type="submit" name="edit_user" class="btn">ยืนยันการแก้ไข</button>
            <hr>
            <center><b>แก้ไขรหัสผ่าน</b></center>
            <div class="input-group2">
            <label for="password_1">รหัสผ่านใหม่:</label>
            <input type="password" name="password_1"pattern="[A-Za-z\0-9]{4,20}">
        </div>
        <div class="input-group3">
            <label for="password_2">ยืนยันรหัสผ่านใหม่:</label>
            <input type="password" name="password_2"pattern="[A-Za-z\0-9]{4,20}">
        </div>
        <button type="submit" name="edit_pass" class="btn">แก้ไขรหัส</button>
            

            
        </div>
    </form>
    <br><br>
    </div>
    <?php endif?>

</body>
</html>