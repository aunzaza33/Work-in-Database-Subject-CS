<?php 
session_start();
    include('server.php'); 

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }
      if (!isset($_SESSION['username1'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];
        $select_stmt = "SELECT * FROM book WHERE Book_ISBN = '$id'";
        $query_ITEM = mysqli_query($conn, $select_stmt);
        $row = mysqli_fetch_array($query_ITEM);
        unlink("upload/".$row['image']); // unlink functoin permanently remove your file

        // delete an original record from db
        $delete_stmt ="DELETE FROM book WHERE Book_ISBN = '$id'";
        mysqli_query($conn, $delete_stmt);
        header("Location: admin.php");
    }
    if(isset($_POST['btn_edit'])){

        $edit_id = $_REQUEST['btn_edit'];
        header("location: admin_books_edit.php?id=".$edit_id);

    
    } 
    if(isset($_POST['btn_delete'])){

        $id = $_REQUEST['btn_delete'];

        $delete_stmt ="DELETE FROM book WHERE Book_ISBN = '$id'";
        mysqli_query($conn, $delete_stmt);
        
        //check if delete success
        $select_book = "SELECT * FROM book WHERE Book_ISBN = '$id'";
        $query_book = mysqli_query($conn, $select_book);

        if(mysqli_num_rows($query_book) == 0){
            //delete complete
            echo "<script>alert('ลบข้อมูลหนังสือสำเร็จ');</script>";
        }
        else{
            //delete fail
            echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
        }
        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_books.php'</script>";

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
                <input type="checkbox" class="hidden" id="chck1">
                <label class="accordion_tab-label" for="chck1">เพิ่มข้อมูลหนังสือ</label>
                <div class="accordion_tab-content">
                    <?php require('addbook.php'); ?>
                </div>
            </div>
            
            <br><br>

            <?php

                    $select_stmt ='SELECT i.*,a.*,c.*,p.* FROM book as i INNER JOIN author as a on a.Author_ID=i.Author_ID
                    INNER JOIN catagory as c on c.Catagory_ID=i.Catagory_ID
                    INNER JOIN publisher as p on p.Publisher_ID =i.Publisher_ID 
                    ORDER BY Book_ISBN '; 

                    $query_ITEM = mysqli_query($conn, $select_stmt);
                    if(mysqli_num_rows($query_ITEM) == 0){
                        echo "<h1 style='text-align:center;font-size:35px;'>ไม่มีข้อมูล</h1>";
                    }
                    else{
            ?>

            <div class="admin_table">
                <table width="98%">
                    <tr>
                        <th style="width:118px">ISBN</th>
                        <th >ชื่อหนังสือ</th>
                        <th style="width:150px">Image</th>
                        <th >นํ้าหนัก</th>
                        <th>ราคา</th>
                        <th >จำนวน</th>
                        <th >จำนวน<br>ที่ขายได้</th>
                        <th style="width: 120px;">สำนักพิมพ์</th>
                        <th >ครั้งที่<br>ตีพิมพ์</th>
                        <th >ปีที่ตี<br>พิมพ์</th>
                        <th >หมวดหนังสือ</th>
                        <th style="width: 150px;">ผู้เเต่ง</th>
                        <th></th>
                    </tr>
                    <?php
                        while ($row = mysqli_fetch_array($query_ITEM)) {
                    ?>
                   <tr>
                <form action="" method="post">
                        <td rowspan="2">
                            <?php echo substr($row['Book_ISBN'],0,3),'-',
                                  substr($row['Book_ISBN'],3,1),'-',
                                  substr($row['Book_ISBN'],4,3),'-',
                                  substr($row['Book_ISBN'],6,5),'-',
                                  substr($row['Book_ISBN'],11,1);
                            ?>
                        </td>
                        <td rowspan="2">
                            <?php echo $row['Book_Name']; ?>
                        </td>                        
                        <td rowspan="2" style="padding:5px;"><img src="upload/<?php echo $row['image']; ?>" width="125px" height="160px" alt=""></td>
                        <td rowspan="2"><?php echo  number_format($row['Book_Weight'],2); ?> <br>กรัม</td>    
                        <td rowspan="2"><?php echo number_format( $row['Book_Price'],2); ?> <br>บาท</td>     
                        <td rowspan="2"><?php echo  number_format($row['Book_Quantity']); ?> เล่ม</td>  
                        <td rowspan="2"><?php echo  number_format($row['Book_SaleQuantity']); ?> เล่ม</td>  
                        <td rowspan="2"><?php echo $row['Publisher_Name']; ?></td>  
                        <td rowspan="2">ครั้งที่ <?php echo $row['Book_PublishNumber']; ?></td>  
                        <td rowspan="2">ปี <?php echo $row['Book_PublishYear']; ?></td>       
                        <td rowspan="2"><?php echo $row['Catagory_Name']; ?></td>    
                        <td rowspan="2"><?php echo $row['Author_Name']; ?> <?php echo $row['Author_LastName']; ?></td>                
                        <td colspan="1" style="border-bottom:hidden;padding: 10px;"><?php edit_button($row['Book_ISBN']); ?></td>
                    </tr>
                    <tr>
                        <td style="padding:10px"><?php delete_button($row['Book_ISBN']); ?>   </td>
                </form>
                    </tr>

                    <?php } ?>
                    

                </table>
            </div> <?php }?>
</div>

            <br><br>

            
    </div> 

</body>
</html>
