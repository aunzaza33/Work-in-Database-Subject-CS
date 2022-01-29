<?php 
    session_start();
    include('server.php');
    
    $errors = array();
    $success = array();
    if (isset($_POST['checkemail'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $username1=$username;

        if (empty($username)) {
            array_push($errors, "โปรดระบุอีเมล");
            $_SESSION['error'] = "โปรดระบุอีเมล";
            header("location: register.php");
        }
    

        $user_check_query = "SELECT * FROM member WHERE email = '$username' LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['username'] == $username) {
                array_push($errors, "อีเมลนี้ถูกใช้ไปแล้ว");
                $_SESSION['error'] = "อีเมลนี้ถูกใช้ไปแล้ว";
            }
        }

        if (count($errors) == 0) {
            $_SESSION['username'] = $username;
            array_push($success,"อีเมลนี้สามารถใช้ได้");
            $_SESSION['success'] = "อีเมลนี้สามารถใช้ได้";
            header('location: register.php');
        } else {
            $_SESSION['success'] = "อีเมลนี้สามารถใช้ได้";
            header("location: register.php");
        }
                
            
        
    }
    
    

    if (isset($_POST['reg_user'])) {
        if (!isset($_SESSION['username'])) {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $username1=$username;}
            if (isset($_SESSION['username'])) {
                $username1=$_SESSION['username'];}
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $sex = mysqli_real_escape_string($conn, $_POST['sex']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
      
        
        if (empty($password_1)) {
            array_push($errors, "โปรดระบุรหัสผ่าน");
            $_SESSION['error'] = "โปรดระบุรหัสผ่าน";
        }
        if ($password_1 != $password_2) {
            array_push($errors, "รหัสผ่านทั้งสองไม่ตรงกัน");
            $_SESSION['error'] = "รหัสผ่านทั้งสองไม่ตรงกัน";
        }
        if ($username1 != $email) {
            array_push($errors, "อีเมลทั้งสองไม่ตรงกัน");
            $_SESSION['error'] = "อีเมลทั้งสองไม่ตรงกัน";
        }
        if (empty($name)) {
            array_push($errors, "โปรดระบุชื่อ");
            $_SESSION['error'] = "โปรดระบุชื่อ";
        }
        if (empty($surname)) {
            array_push($errors, "โปรดระบุนามสกุล");
            $_SESSION['error'] = "โปรดระบุนามสกุล";
        }
        if (empty($date)) {
            array_push($errors, "โปรดระบุวันเกิด");
            $_SESSION['error'] = "โปรดระบุวันเกิด";
        }
        if (empty($phone)) {
            array_push($errors, "โปรดระบุหมายเลขโทรศัพท์");
            $_SESSION['error'] = "โปรดระบุหมายเลขโทรศัพท์";
        }
        if (empty($mobile)) {
            array_push($errors, "โปรดระบุหมายเลขโทรศัพท์มือถือ");
            $_SESSION['error'] = "โปรดระบุหมายเลขโทรศัพท์มือถือ";
        }

        $user_check_query = "SELECT * FROM member WHERE email = '$username1'  LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);
       

        if ($result) { // if user exists
            if ($result['username'] == $username1) {
                array_push($errors, "อีเมลนี้ถูกใช้ไปแล้ว");
                $_SESSION['error'] = "อีเมลนี้ถูกใช้ไปแล้ว";
            }
            
        }

        if (count($errors) == 0) {
            $password = ($password_1);
            
            
            $sql = "INSERT INTO member (email,password,Cus_Name,Cus_LName,Cus_sex,Cus_BDate,Cus_PhoneNum,Cus_mobile) 
            VALUES ('$username1','$password','$name','$surname','$sex','$date','$phone','$mobile')";
            
            mysqli_query($conn, $sql);
           
            header('location: login.php');
        } else {
            header("location: register.php");
        }
        unset($_SESSION['username']);
    } 

?>