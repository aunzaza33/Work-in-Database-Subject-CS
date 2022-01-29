<?php 
    session_start();
    include('server.php'); 
    $errors = array();

    if (isset($_POST['submit-pass'])) {
        $username= $_SESSION['username1'];
        $password_0 = mysqli_real_escape_string($conn, $_POST['password_0']);

        if (empty($password_0)) {
            array_push($errors, "โปรดระบุรหัสผ่าน");
            $_SESSION['error'] = "โปรดระบุรหัสผ่าน";
            header("location: editprofile.php.php");
        }

        if (count($errors) == 0) {
            $query = "SELECT * FROM member WHERE email = '$username' AND password = '$password_0' ";
            $result = mysqli_query($conn, $query);
            
            
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['password_0'] = $password_0;
                header("location: editprofile.php");
                
                
            } else {
                array_push($errors, "รหัสผ่านเกิดข้อผิดพลาด!");
                $_SESSION['error'] = "รหัสผ่านเกิดข้อผิดพลาด!";
                header("location: editprofile.php");
            }
        } else {
            array_push($errors, "โปรดกรอกรหัสผ่าน");
            $_SESSION['error'] = "โปรดกรอกรหัสผ่าน";
            header("location: editprofile.php");
        }
                
    }
    
    if (isset($_POST['edit_user'])) {
        $username= $_SESSION['username1'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $sex = mysqli_real_escape_string($conn, $_POST['sex']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
        $user_sql= "UPDATE member SET Cus_Name = '$name' ,Cus_LName='$surname',Cus_sex='$sex',Cus_BDate='$date',Cus_Address='$address'
        ,Cus_PhoneNum='$phone'
        ,Cus_mobile='$mobile' WHERE email ='$username'";
        $query_user = mysqli_query($conn, $user_sql);
        if ($user_sql) {
            echo "<script>alert('แก้ไขข้อมูลสำเร็จ!');</script>";
            echo "<script>window.location.href='index0.php'</script>";
        } else {
            echo "<script>alert('มีบางอย่างผิดพลาด กรุณาลองใหม่อีกครั้ง');</script>";
            echo "<script>window.location.href='editprofile.php'</script>";
        }unset( $_SESSION['password_0']);
                
            
        
    }

    if (isset($_POST['edit_pass'])) {
        $username= $_SESSION['username1'];
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
        if (empty($password_1)) {
            array_push($errors, "โปรดระบุรหัสผ่าน");
            $_SESSION['error'] = "โปรดระบุรหัสผ่าน";
            header("location: editprofile.php");
        }
        if ($password_1 != $password_2) {
            array_push($errors, "รหัสผ่านทั้งสองไม่ตรงกัน");
            $_SESSION['error'] = "รหัสผ่านทั้งสองไม่ตรงกัน";
            header("location: editprofile.php");
        }
        if (count($errors) == 0) {
        $pass_sql= "UPDATE member SET password ='$password_1' WHERE email ='$username'";
        $query_pass = mysqli_query($conn, $pass_sql);
        if ($pass_sql) {
            echo "<script>alert('แก้ไขข้อมูลสำเร็จ!');</script>";
            echo "<script>window.location.href='index0.php'</script>";
        } else {
            echo "<script>alert('มีบางอย่างผิดพลาด กรุณาลองใหม่อีกครั้ง');</script>";
            echo "<script>window.location.href='editprofile.php'</script>";
        }unset( $_SESSION['password_0']);
    }
    }

?>