<?php 
    session_start();
    include('server.php');
    include('errors.php'); 

    if($_GET){
        $from = $_GET['from'];
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }
    if (isset($_POST['btn_add'])) {

        $catagory= $_REQUEST['txt_Catagory'];

        if (empty($catagory)) {
            echo "<script>alert('กรุณาระบุหมวดหนังสือ');</script>";
            return;
        }
        
        $catagory_check = "SELECT * FROM catagory WHERE Catagory_Name = '$catagory'  LIMIT 1";
        $query_c = mysqli_query($conn, $catagory_check);
             

        if (mysqli_num_rows($query_c) > 0) {
            echo "<script>alert('มีหมวดหนังสือนี้อยู่แล้ว กรุณาลองใหม่อีกครั้ง');</script>";
        }
        else{
            $in = "INSERT INTO catagory (Catagory_Name) VALUES ('$catagory')";
            mysqli_query($conn, $in);

            if ($in) {
                echo "<script>alert('บันทึกหมวดหนังสือใหม่สำเร็จ');</script>";
            }
            else {
                echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
            }
               
            mysqli_close($conn);
            echo "<script>window.location.href='/bookstore/admin_catagory.php'</script>";
            
        }
           
    }
    if(isset($_POST['btn_edit'])){

        $edit_id = $_REQUEST['btn_edit'];
    
    } 
    if(isset($_POST['btn_delete'])){

        $id = $_REQUEST['btn_delete'];

        $delete_stmt ="DELETE FROM catagory WHERE Catagory_ID = '$id'";
        mysqli_query($conn, $delete_stmt);
        
        //check if delete success
        $select_cat = "SELECT * FROM catagory WHERE Catagory_ID = '$id'";
        $query_cat = mysqli_query($conn, $select_cat);

        if(mysqli_num_rows($query_cat) == 0){
            //delete complete
            echo "<script>alert('ลบหมวดหนังสือสำเร็จ');</script>";
        }
        else{
            //delete fail
            echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
        }
        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_catagory.php'</script>";
    }
    if(isset($_POST['btn_submit'])){
        
        $edit_id = $_REQUEST['btn_submit'];
        $catagory = $_REQUEST['new_catagoryname'];

        if (empty($catagory)) {
            echo "<script>alert('กรุณาระบุหมวดหนังสือ');</script>";
            $edit_id = $_REQUEST['btn_submit'];
        }
        else{

            $catagory_check = "SELECT * FROM catagory WHERE Catagory_Name = '$catagory'  LIMIT 1";
            $query_c = mysqli_query($conn, $catagory_check);
                

            if (mysqli_num_rows($query_c) > 0) {
                echo "<script>alert('มีหมวดหนังสือนี้อยู่แล้ว กรุณาลองใหม่อีกครั้ง');</script>";
            }
            else{
                $up = "UPDATE catagory
                        SET Catagory_Name = '$catagory'
                        WHERE Catagory_ID = '$edit_id' ";

                mysqli_query($conn, $up);

                if ($up) {
                    //echo "<script>alert('แก้ไขหมวดหนังสือสำเร็จ');</script>";
                }
                else {
                    //echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
                }
                
                mysqli_close($conn);
                echo "<script>window.location.href='/bookstore/admin_catagory.php'</script>";
                
            }
        }
        
    }
    if(isset($_POST['btn_cancel'])){
        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_catagory.php'</script>";
    }

    if(isset($_POST['btn_back'])){
        mysqli_close($conn);
        header('Location: admin_books_edit.php?id='.$from);
    }

    function edit_button($id){
        ?>
        <button name="btn_edit" class="edit" value=<?php echo $id; ?>>
            แก้ไข
        </button>
        <?php
    }

    function delete_button($id){
        ?>
        <button name="btn_delete" class="delete" value=<?php echo $id; ?>>
            ลบ
        </button>
        <?php
    }

    function submit_button($id){
        ?>
        <button name="btn_submit" class="edit" value=<?php echo $id; ?>>
            ยืนยัน
        </button>
        <?php
    }

    function cancel_button(){
        ?>
        <button name="btn_cancel" class="delete">
            ยกเลิก
        </button>
        <?php
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link  rel="stylesheet" href="stylemin.css">
    <title>Welcome SE-ED Admin</title>
    <link rel="stylesheet" href="style.css">
    <link  rel="stylesheet" href="styleadmin.css">
</head>
<body>

    <?php require 'Se_ed_header.php';
        $goto = "catagories";
        require 'admin_tab.php';?>

    <div class="admin_container">

            <br><br>
            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                <div class="form-group" style="width:80%;">
                    <table style="width: 100%;">
                        <tr>
                            <th>
                                <label for="name" class="col-sm-3-control-label">เพิ่มหมวดหนังสือใหม่</label>
                            </th>
                            <th>
                                <input type="text" 
                                       name="txt_Catagory" 
                                       class="form-control textstyle" 
                                       size="20" style="
                                                width:85%;
                                                line: height 100px;"
                                       placeholder="เพิ่มหมวดหนังสือใหม่...">
                            </th>
                            <th>
                                <input type="submit" name="btn_add" class="util_btn" value="เพิ่ม">
                            </th>
                    </table>    
                </div>
            </form>

            <?php
                if(isset($from)){
                    ?>
                        <br>
                        <table style="width:100%;margin:auto;">
                            <tr>
                                <th>
                                    <button name="btn_back" class="delete">ย้อนกลับ</button>
                                </th>
                            </tr>
                        </table>

                    <?php
                }
                else{
                    $catagory_check_query = "SELECT * FROM catagory order by Catagory_ID";
                    $query_catagory = mysqli_query($conn, $catagory_check_query);

                    if(mysqli_num_rows($query_catagory) == 0){
                        echo "<h1 style='text-align:center;font-size:35px;'>ไม่มีข้อมูล</h1>";
                    }
                    else{
            ?>

            <br><br>

            <div class="admin_table">
             
                <table style="width:60%">
                    <tr style="padding:10px;">
                        <th style="width: 25%;">Catogory_ID</th>
                        <th>ชื่อหมวดหนังสือ</th>
                        <th style="width: 25%;"></th>
                    </tr>
                                            
                    <?php
                        while ( $row = mysqli_fetch_assoc($query_catagory)){
                    ?>
                    <tr>
                <form action="" method="post" autocomplete="off">
                        <td rowspan="2" style="font-size: 21px;"> <?php echo $row['Catagory_ID']; ?> </td>
                        <td rowspan="2" style="font-size: 21px;">
                            <?php 
                                if((isset($edit_id))){

                                    if($edit_id == $row['Catagory_ID']){ ?>
                                        <input type='text' 
                                                name='new_catagoryname' 
                                                class='form-control' 
                                                placeholder='Enter new catagory...' 
                                                value= <?php echo $row['Catagory_Name']; ?> 
                                                style="line: height 21px;
                                                        padding: 5px 5px;
                                                        font-size: 21px;"
                                            >
                                    <?php }
                                    else echo $row['Catagory_Name']; 
                                    
                                }
                                else echo $row['Catagory_Name']; ?>
                                
                        </td>    
                        <td columnspan="1" style="border-bottom:hidden;padding: 10px;">
                            <?php 
                                //edit catagory and submit new catagory
                                if((isset($edit_id))){

                                    if($edit_id == $row['Catagory_ID']){ 
                                        submit_button($row['Catagory_ID']);
                                    }
                                    else edit_button($row['Catagory_ID']); 
                                    
                                }
                                else edit_button($row['Catagory_ID']); 
                            ?>   
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px">  
                            <?php 
                            //cancel edited catagory or delete catagory
                                if((isset($edit_id))){

                                    if($edit_id == $row['Catagory_ID']){ 
                                        cancel_button();
                                    }
                                    else delete_button($row['Catagory_ID']); 
                                    
                                }
                                else delete_button($row['Catagory_ID']); 
                            ?>   
                        </td>
                </form>
                    </tr>

                    <?php }  ?>
               
                </table> <?php } } ?>

    </div>

        

</body>
</html>