<?php 
    session_start();
    include('server.php');

    $errors = array();

    if (isset($_POST['login_user'])) {
        $username1 = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($username1)) {
            array_push($errors, "กรุณากรอกอีเมลล์!");
        }

        if (empty($password)) {
            array_push($errors, "กรุณากรอกรหัสผ่าน!");
        }

        if (count($errors) == 0) {
            $password = ($password);
            $query = "SELECT * FROM member WHERE email = '$username1' AND password = '$password' ";
            $result = mysqli_query($conn, $query);
            
            
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['username1'] = $username1;
   
                if($_SESSION['username1'] == 'admin@se-ed.com'){//ดักจับว่าเป็นแอดมินไหม
                    header("location: admin.php");  //ถ้าใช่ให้เข้าสู่หน้าแอดมิน(ต้องแก้!)
                }
                else{
                header("location: index0.php");
                }
                
            } else {
                array_push($errors, "ชื่อผู้ใช้หรือรหัสผ่านเกิดข้อผิดพลาด!");
                $_SESSION['error'] = "ชื่อผู้ใช้หรือรหัสผ่านเกิดข้อผิดพลาด!";
                header("location: login.php");
            }
        } else {
            array_push($errors, "โปรดกรอกชื่อผู้ใช้เเละรหัสผ่าน");
            $_SESSION['error'] = "โปรดกรอกชื่อผู้ใช้เเละรหัสผ่าน";
            header("location: login.php");
        }
    } unset($_SESSION['username']);

?>