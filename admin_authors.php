<?php 
    session_start();
    include('server.php');
    include('errors.php'); 
    
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }

    if (isset($_POST['btn_add'])) {

        $name= $_REQUEST['author_name'];
        $lastname= $_REQUEST['author_lastname'];

        if (empty($name)) {
            echo "<script>alert('กรุณาระบุชื่อผู้แต่ง');</script>";

        }
        else{
            $author_check = "SELECT * FROM author WHERE Author_Name = '$name'  LIMIT 1";
            $query_a = mysqli_query($conn, $author_check);
                

            if (mysqli_num_rows($query_a) > 0) {
                echo "<script>alert('มีชื่อนี้อยู่แล้ว กรุณาลองใหม่อีกครั้ง');</script>";
            }
            else{

                if(empty($lastname)){
                    $in = "INSERT INTO author (Author_Name) VALUES ('$name')"; 
                }
                else{
                    $in = "INSERT INTO author (Author_Name,Author_LastName) VALUES ('$name','$lastname')"; 
                }
                mysqli_query($conn, $in);

                if ($in) {
                    echo "<script>alert('บันทึกข้อมูลผู้แต่งใหม่สำเร็จ');</script>";
                }
                else {
                    echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
                }
                
            }
        }

        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_authors.php'</script>";
        
           
    }
    if(isset($_POST['btn_edit'])){

        $edit_id = $_REQUEST['btn_edit'];
    
    } 
    if(isset($_POST['btn_delete'])){

        $id = $_REQUEST['btn_delete'];

        $delete_stmt ="DELETE FROM author WHERE Author_ID = '$id'";
        mysqli_query($conn, $delete_stmt);
        
        //check if delete success
        $select_author = "SELECT * FROM author WHERE Author_ID = '$id'";
        $query_author = mysqli_query($conn, $select_author);

        if(mysqli_num_rows($query_author) == 0){
            //delete complete
            echo "<script>alert('ลบข้อมูลผู้แต่งสำเร็จ');</script>";
        }
        else{
            //delete fail
            echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
        }
        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_authors.php'</script>";

    }
    if(isset($_POST['btn_submit'])){
 
        $id = $_REQUEST['btn_submit'];
        $name= $_REQUEST['new_author_name'];
        $lastname= $_REQUEST['new_author_lastname'];

        if(empty($name)) {
            echo "<script>alert('ชื่อผู้แต่งต้องไม่ว่าง');</script>";
            $edit_id = $_REQUEST['btn_edit'];
        }
        else{
            $up = "UPDATE author
                    SET Author_Name = '$name', Author_LastName = '$lastname'
                    WHERE Author_ID = '$id' ";

            mysqli_query($conn, $up);

            if ($up) {
                echo "<script>alert('แก้ไขข้อมูลผู้แต่งสำเร็จ');</script>";
            }
            else {
                echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
            }
               
            mysqli_close($conn);
            echo "<script>window.location.href='/bookstore/admin_authors.php'</script>";
            
        }

    }
    if(isset($_POST['btn_cancel'])){
        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_authors.php'</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome SE-ED Admin</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
    <link  rel="stylesheet" href="styleadmin.css">
</head>
<body>

    <?php require 'Se_ed_header.php';
        $goto = "authors";
        require 'admin_tab.php';?>

    <div class="admin_container">

        <br><br>

        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group" style="width:80%;">
                <table style="width: 100%;">
                    <tr>
                        <th style="width:20%;">
                            <label for="name" class="col-sm-3-control-label">เพิ่มข้อมูลผู้แต่ง</label>
                        </th>
                        <th style="width:30%;">
                            <input type="text" 
                                   name="author_name" 
                                   class="form-control textstyle"
                                   size="20" style="width:85%;"
                                   placeholder="เพิ่มชื่อ...">
                        </th>
                        <th style="width:30%;">
                            <input type="text" 
                                   name="author_lastname" 
                                   class="form-control textstyle"
                                   size="20" style="width:85%;"
                                   placeholder="เพิ่มนามสกุล...">
                        </th>
                        <th>
                            <input type="submit" name="btn_add" class="util_btn" value="เพิ่ม">
                        </th>
                            
                    </tr>
                </table>
            </div>
        </form>

        <br><br>

        <?php 
            $author_check_query = "SELECT * FROM author order by Author_ID";
            $query_author = mysqli_query($conn, $author_check_query);

            if(mysqli_num_rows($query_author) == 0){
                echo "<h1 style='text-align:center;font-size:35px;'>ไม่มีข้อมูล</h1>";
            }
            else{

        ?>
        
        <div class="admin_table">

            <table style="width:80%">
                <tr style="padding:10px;">
                    <th style="width:20%;">Author_ID</th>
                    <th colspan="2" style="width:65%;">ชื่อผู้แต่ง</th>
                    <th></th>
                    
                </tr>
                      
                <?php
                    while ($row = mysqli_fetch_assoc($query_author)){
                ?>
                <tr>
                    <form action="" method="post">

                        <td rowspan="2" style="font-size: 21px;"> <?php echo $row['Author_ID']; ?> </td>
                        <?php

                        if((isset($edit_id))){

                            if($edit_id == $row['Author_ID']){ ?>

                                <td rowspan="2" style="width:30%">
                                    <input type='text' 
                                        name='new_author_name' 
                                        class='form-control' 
                                        placeholder='แก้ไขชื่อ...' 
                                        value= <?php echo $row['Author_Name']; ?> 
                                        style="line: height 21px;
                                                padding: 5px 5px;
                                                font-size: 21px;"
                                    >

                                </td>

                                <td rowspan="2" style="width:30%">
                                    <input type='text' 
                                        name='new_author_lastname' 
                                        class='form-control' 
                                        placeholder='แก้ไขนามสกุล...' 
                                        style="line: height 21px;
                                                padding: 5px 5px;
                                                font-size: 21px;"
                                        value= <?php 
                                                    if(isset($row['Author_LastName'])){
                                                        echo $row['Author_LastName']; 
                                                    }
                                                ?> 
                                        
                                    >

                                </td>
                            <?php 
                            } 
                            else echo '<td rowspan="2" colspan="2"> '. $row["Author_Name"]." ".$row['Author_LastName'].' </td>';
                        }
                        else echo '<td rowspan="2" colspan="2"> '. $row["Author_Name"]." ".$row['Author_LastName'].' </td>'; 

                        ?>

                        <td columnspan="2" style="border-bottom:hidden;padding: 10px;">
                            <?php 
                                //edit publisher data  / submit edited data
                                if((isset($edit_id))){

                                    if($edit_id == $row['Author_ID']){ 
                                        submit_button($row['Author_ID']);
                                    }
                                    else edit_button($row['Author_ID']); 
                                    
                                }
                                else edit_button($row['Author_ID']); 
                            ?>   
                        </td>

                    </tr>

                    <tr>
                        <td style="padding:10px">  
                            <?php 
                            //cancel edited data or delete data
                                if((isset($edit_id))){

                                    if($edit_id == $row['Author_ID']){ 
                                        cancel_button();
                                    }
                                    else delete_button($row['Author_ID']); 
                                    
                                }
                                else delete_button($row['Author_ID']); 
                            ?>   
                        </td>
                    </form>
                    </tr>

                    <?php }?>
               
            </table> <?php } ?>

    </div>

</body>
</html>