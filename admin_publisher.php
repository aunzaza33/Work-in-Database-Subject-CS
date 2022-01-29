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

        $publisher= $_REQUEST['publisher_name'];
        $address= $_REQUEST['publisher_address'];

        if (empty($publisher)) {
            echo "<script>alert('กรุณาระบุสำนักพิมพ์');</script>";

        }
        else{
            $publisher_check = "SELECT * FROM publisher WHERE Publisher_Name = '$publisher'  LIMIT 1";
            $query_p = mysqli_query($conn, $publisher_check);
                

            if (mysqli_num_rows($query_p) > 0) {
                echo "<script>alert('มีสำนักพิมพ์นี้อยู่แล้ว กรุณาลองใหม่อีกครั้ง');</script>";
            }
            else{

                if(empty($address)){
                    $in = "INSERT INTO publisher (Publisher_Name) VALUES ('$publisher')"; 
                }
                else{
                    $in = "INSERT INTO publisher (Publisher_Name,Publisher_Address) VALUES ('$publisher','$address')"; 
                }
                mysqli_query($conn, $in);

                if ($in) {
                    echo "<script>alert('บันทึกสำนักพิมพ์ใหม่สำเร็จ');</script>";
                }
                else {
                    echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
                }
                
            }
        }

        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_publisher.php'</script>";
        
           
    }
    if(isset($_POST['btn_edit'])){

        $edit_id = $_REQUEST['btn_edit'];
    
    } 
    if(isset($_POST['btn_delete'])){

        $id = $_REQUEST['btn_delete'];

        $delete_stmt ="DELETE FROM publisher WHERE Publisher_ID = '$id'";
        mysqli_query($conn, $delete_stmt);
        
        //check if delete success
        $select_publ = "SELECT * FROM publisher WHERE Publisher_ID = '$id'";
        $query_publ = mysqli_query($conn, $select_publ);

        if(mysqli_num_rows($query_publ) == 0){
            //delete complete
            echo "<script>alert('ลบข้อมูลสำนักพิมพ์สำเร็จ');</script>";
        }
        else{
            //delete fail
            echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
        }
        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_publisher.php'</script>";

    }
    if(isset($_POST['btn_submit'])){
 
        $id = $_REQUEST['btn_submit'];
        $newpublisher = $_REQUEST['new_publisher_name'];
        $newaddress = $_REQUEST['new_publisher_address'];

        if(empty($newpublisher)) {
            echo "<script>alert('ชื่อสำนักพิมพ์ต้องไม่ว่าง');</script>";
            $edit_id = $_REQUEST['btn_edit'];
        }
        else{
            $up = "UPDATE publisher
                    SET Publisher_Name = '$newpublisher', Publisher_Address = '$newaddress'
                    WHERE Publisher_ID = '$id' ";

            mysqli_query($conn, $up);

            if ($up) {
                echo "<script>alert('แก้ไขข้อมูลสำนักพิมพ์สำเร็จ');</script>";
            }
            else {
                echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
            }
               
            mysqli_close($conn);
            echo "<script>window.location.href='/bookstore/admin_publisher.php'</script>";
            
        }

    }
    if(isset($_POST['btn_cancel'])){
        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_publisher.php'</script>";
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
        $goto = "publishers";
        require('admin_tab.php');?>

    <div class="admin_container">

        <br><br>
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group" style="width:80%;">
                <table style="width: 100%;">
                    <tr>
                        <th style="width:15%;">
                            <label for="name" class="col-sm-3-control-label">เพิ่มข้อมูล<br>สำนักพิมพ์</label>
                        </th>
                        <th style="width:30%;">
                            <input type="text" 
                                   name="publisher_name" 
                                   class="form-control textstyle"
                                   size="20" style="width:90%;"
                                   placeholder="เพิ่มชื่อ...">
                        </th>
                        <th style="width:30%;padding: 5px;">
                            <textarea rows="4" cols="30"
                                      name="publisher_address" 
                                      class="form-control textstyle" 
                                      style="resize:none;"
                                     placeholder="เพิ่มที่ตั้ง..."></textarea>
                            </textarea>
                                
                        </th>
                        <th>
                            <input type="submit" name="btn_add" class="util_btn" value="เพิ่ม">
                        </th>
                            
                    </tr>
                </table>
            </div>
        </form>

        <script>
            function auto_grow(element) {
                element.style.height = "5px";
                element.style.height = (element.scrollHeight)+"px";
            }
        </script>

        <br><br>

        <?php 
            $publisher_check_query = "SELECT * FROM publisher order by Publisher_ID";
            $query_publisher = mysqli_query($conn, $publisher_check_query);
            if(mysqli_num_rows($query_publisher) == 0){
                echo "<h1 style='text-align:center;font-size:35px;'>ไม่มีข้อมูล</h1>";
            }
            else{
        ?>
            
        <div class="admin_table">

            <table style="width:70%">
                <tr style="padding:10px;">
                    <th style="width: 15%;">Publisher_ID</th>
                    <th style="width: 25%;">ชื่อสำนักพิมพ์</th>
                    <th style="width: 35%;">ที่อยู่สำนักพิมพ์</th>
                    <th style="width: 25%;"></th>
                </tr>
                      
                <?php
                    while ($row = mysqli_fetch_assoc($query_publisher)){
                ?>
                <tr>
                    <form action="" method="post">
                        <td rowspan="2" style="font-size: 21px;"> <?php echo $row['Publisher_ID']; ?> </td>
                        <td rowspan="2" style="font-size: 18px;">
                        
                    <?php 
                        if((isset($edit_id))){

                            if($edit_id == $row['Publisher_ID']){ ?>
                                <input type='text' 
                                       name='new_publisher_name' 
                                       class='form-control textinput' 
                                       placeholder='แก้ไขชื่อสำนักพิมพ์...' 
                                       value= <?php echo $row['Publisher_Name']; ?> 
                                >
                            <?php }
                                else echo $row['Publisher_Name']; 
                        }
                        else echo $row['Publisher_Name']; ?>
                                
                        </td>
                        <td rowspan="2" style="font-size: 18px;">
                            <?php 
                                if((isset($edit_id))){

                                    if($edit_id == $row['Publisher_ID']){ ?>
                                        <textarea 
                                                name='new_publisher_address' 
                                                class='form-control textinput' 
                                                placeholder='แก้ไขที่ตั้ง...'
                                                value= <?php 
                                                    if(isset($row['Publisher_Address'])){
                                                        echo $row['Publisher_Address']; 
                                                    }
                                                ?> 
                                                rows="5" cols="30"
                                                style="resize: none"

                                        ><?php echo trim($row['Publisher_Address']); ?></textarea>
                                    <?php }
                                    else echo trim($row['Publisher_Address']); 
                                    
                                }
                                else echo trim($row['Publisher_Address']); ?>
                                
                        </td>
                        
                        <td colspan="1" style="border-bottom:hidden;padding: 10px;">
                            <?php 
                                //edit publisher data  / submit edited data
                                if((isset($edit_id))){

                                    if($edit_id == $row['Publisher_ID']){ 
                                        submit_button($row['Publisher_ID']);
                                    }
                                    else edit_button($row['Publisher_ID']); 
                                    
                                }
                                else edit_button($row['Publisher_ID']); 
                            ?>   
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px">  
                            <?php 
                            //cancel edited data or delete data
                                if((isset($edit_id))){

                                    if($edit_id == $row['Publisher_ID']){ 
                                        cancel_button();
                                    }
                                    else delete_button($row['Publisher_ID']); 
                                    
                                }
                                else delete_button($row['Publisher_ID']); 
                            ?>   
                        </td>
                </form>
                    </tr>

                    <?php }?>
               
                </table> <?php } ?>
    </div>

</body>
</html>