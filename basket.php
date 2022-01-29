<?php 

session_start();
    include('server.php'); 
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }

    $checkout = FALSE;
    $style1 = 2;

    $checkout_complete = FALSE;

    if (isset($_REQUEST['delete_order'])) {

        $delete_isbn = $_REQUEST['delete_order'];
        $count = $_REQUEST['count'];
        $order_ = $_REQUEST['order_'];

        if($count==1){
            $delete_order = "DELETE FROM book_order WHERE Order_Num = '$order_' ";  
        }
        else{
            $delete_order = "DELETE FROM book_order_detail WHERE Order_Num = '$order_' AND Book_ISBN = '$delete_isbn' ";
        }
        mysqli_query($conn,$delete_order);

        if($delete_order) echo "<script>alert('ลบข้อมูลคำสั่งซื้อเรียบร้อย')</script>";
        else echo "<script>alert('ลบข้อมูลคำสั่งซื้อไม่สำเร็จ')</script>";

    }

    if (isset($_REQUEST['clear'])) {

        $order_Num = $_REQUEST['clear'];

        $delete_order = "DELETE FROM book_order WHERE Order_Num = '$order_Num' ";
        mysqli_query($conn,$delete_order);

        if($delete_order) echo "<script>alert('ลบข้อมูลคำสั่งซื้อเรียบร้อย')</script>";
        else echo "<script>alert('ลบข้อมูลคำสั่งซื้อไม่สำเร็จ')</script>";
        echo "<script>window.location.href='/bookstore/index0.php'</script>";
    }   

    if (isset($_POST['pay'])) {
       $checkout = TRUE;
       $Style1 = 4;
    }
            
    if (isset($_POST['back'])) {
        
        echo "<script>window.location.href='/bookstore/index0.php'</script>";
    }    

    if(isset($_REQUEST['checkout'])){
        
        if(isset($_REQUEST['paymethod']) &&  isset($_REQUEST['address'])){
            $payment = $_REQUEST['paymethod'];
            $deliver = NULL;

            if($_REQUEST['address'] == 2){
                $deliver = $_REQUEST['fill_address'];

                if(!isset($deliver)){
                    echo "<script>alert('กรุณากรอกที่อยู่จัดส่ง')</script>";
                    echo "<script>window.location.href='/bookstore/editprofile.php'</script>";
                    return;
                }
            
            }
            else if($_REQUEST['address'] == 1){
                $id = $_REQUEST['id'];
                $deliver = "SELECT Cus_Address FROM member WHERE Cus_id = '$id' ";
                $deliver = mysqli_query($conn,$deliver);
                $deliver = mysqli_fetch_assoc($deliver);

                $deliver = $deliver['Cus_Address'];
                if(!isset($deliver)){
                    echo "<script>alert('กรุณากรอกที่อยู่จัดส่ง')</script>";
                    echo "<script>window.location.href='/bookstore/editprofile.php'</script>";
                    return;
                }

            }
            
            //update transaction complete
            $transaction = "UPDATE book_order 
            SET Order_Status = 1, 
                PayMethod = '$payment', 
                Order_Address = '$deliver',
                Order_Time = CURRENT_TIMESTAMP()
            WHERE Order_Num = '$_REQUEST[checkout]' AND Cus_id = '$_REQUEST[id]' ";
            mysqli_query($conn,$transaction);

            //update book instock quantity
            $find = "SELECT book_order_detail.Book_ISBN ,Book_SaleQuantity ,Quantity
            FROM book 
            INNER JOIN book_order_detail ON book_order_detail.Book_ISBN = book.Book_ISBN
            WHERE Order_Num ='$_REQUEST[checkout]' ";
            $find = mysqli_query($conn,$find);

            while($row = mysqli_fetch_array($find)){
                $update = "UPDATE book SET Book_SaleQuantity = ('$row[Book_SaleQuantity]' + '$row[Quantity]')
                        WHERE Book_ISBN = '$row[Book_ISBN]' ";
                mysqli_query($conn,$update);
            }
            
            //update customer point
            $point_update = "SELECT Cus_Point FROM member WHERE Cus_id = '$_REQUEST[id]' ";
            $point_update = mysqli_query($conn,$point_update);
            $point = mysqli_fetch_assoc($point_update);

            $update_point = "UPDATE member SET Cus_Point = '$point[Cus_Point]'  + ((8/100) * '$_REQUEST[total]')
                WHERE Cus_id = '$_REQUEST[id]' ";
            mysqli_query($conn,$update_point);

            echo "<script>alert('ชำระเงินเรียบร้อย')</script>";
            echo "<script>window.location.href='/bookstore/index0.php'</script>";

        }
        else{
            echo "<script>alert('กรุณาระบุวิธีชำระเงิน และที่อยู่ในการจัดส่งให้เรียบร้อย')</script>";
        }
    }
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SE-ED Basket</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
    <link  rel="stylesheet" href="styleadmin.css">

    

</head>
<body>

<?php require 'Se_ed_header.php';?>

    <br><br>

        <h1 style="text-align:center">ตะกร้าสินค้า</h1>
    <br><br>
    <?php

                if($checkout==TRUE){
                    $style1 = 4;
                }

                $select_basket = "SELECT book_order.Order_Num,book.image,book.Book_Name,book.Book_ISBN, book_order_detail.Quantity ,book.Book_Price
                FROM book_order
                INNER JOIN book_order_detail ON book_order.Order_Num = book_order_detail.Order_Num
                INNER JOIN book ON book_order_detail.Book_ISBN = book.Book_ISBN
                WHERE book_order.Cus_id = '$customer_id' 
                    AND book_order.Order_Status = 0";
                $query_ITEM = mysqli_query($conn, $select_basket);

                $total_amount = 0;
                if(mysqli_num_rows($query_ITEM) == 0){
                    ?>
                        <h1 style="text-align:center">ขณะนี้ยังไม่มีการสั่งซื้อหนังสือใดๆ</h1>
                    <?php
                }
                else{ ?>
    <div class="admin_table">
        <table style="width:85%">
            <tr >
                <th colspan="2" style="font-size:20px;width:50%;">หนังสือ</th>
                <th style="font-size:20px;width:25%;">จำนวน</th>
                <th style="font-size:20px;width:25%;">ราคา</th>
                <th></th>
            </tr>
            <form action="" method="post">
                <input type="hidden" name="count" value=<?php echo mysqli_num_rows($query_ITEM); ?>>
                <input type="hidden" name="id" value=<?php echo $customer_id; ?>>
            <?php
            
                    $point = 0;
                    while($row = mysqli_fetch_array($query_ITEM)){
                        $order_N = $row['Order_Num'];
            ?><tr>
                    <td style="padding:5px;">
                        <img src= <?php echo "upload/".$row['image'];?> width="150px" height="200px">
                    </td>
                    <td>
                        <h3 style="font-size:18px;"><?php echo $row['Book_Name']; ?></h3>
                    </td>
                    <td>
                        <?php echo $row['Quantity']." เล่ม"; ?>
                    </td>
                    <td>
                        <?php echo number_format($row['Quantity'] * $row['Book_Price'],2)." บาท"; 
                            $total_amount += $row['Quantity'] * $row['Book_Price'];

                        ?>
                       
                    </td>
                    <td>
                        
                        <?php if($checkout == FALSE) {?>
                            <button class="delete" name="delete_order" value=<?php echo $row['Book_ISBN']; ?> >ลบ</button>
                        <?php }?>

                        <input type="hidden" name="order_" value=<?php echo  $row['Order_Num']; ?>>
                    </td>
                </tr>
                    
                <?php } ?>
            <tr style="border-top:solid black;
                        border-bottom: double black;">

                <input type="hidden" name="total" value=<?php echo $total_amount; ?> >

                <td colspan= <?php echo $style1; ?> >
                    <h2><?php echo "ราคาสุทธิ : ".number_format($total_amount,2)." บาท"; ?></h2>
                </td>
                    <?php if($checkout == FALSE){ ?>
                <td>
                    <button class="edit" name="pay">ชำระเงิน</button>
                </td>

                <td>
                    <button class="delete" name="clear" style="width: 150px;" 
                        value=<?php echo $order_N; ?> >ลบคำสั่งซื้อ</button>
                </td>

                <td>
                    <button class="delete" name="back" >ย้อนกลับ</button>
                </td>
            
            </tr>
            <?php }
            else{ ?>
            <tr style="padding: 10px;">
                <td colspan="2"> 
                    <h3>เลือกวิธีชำระเงิน</h3>
                </td>

                <td colspan="2">
                    <h3>เลือกที่อยู่จัดส่ง</h3>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:30px;border-bottom:none;">

                          <input type="radio" id="credit_card" name="paymethod" value="1">
                          <label for="credit_card"><strong>บัตรเครดิต/เดบิต</strong></label><br><br>
                          <input type="radio" id="dest_transact" name="paymethod" value="2">
                          <label for="dest_transact"><strong>ชำระเงินปลายทาง</strong></label><br>
                        <br>  

                </td>
                <td colspan="2" style="padding:30px;border-bottom:none;">

                          <input type="radio" id="from_account" name="address" value="1">
                            <label for="credit_card"><strong>ใช้ที่อยู่ที่ตั้งค่าจากบัญชี</strong></label><br><br>

                          <input type="radio" id="new address_" name="address" value="2">
                            <label for="dest_transact"><strong>กำหนดที่อยู่จัดส่งใหม่</strong></label><br><br>  

                          <textarea name="fill_address" rows="4" cols="27" 
                                      style="font-size:17px;height:150px;resize:none;padding:5px" wrap="hard"
                          placeholder="กรอกที่อยู่ใหม่..."></textarea>

                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:30px;">
                    <button class="edit" name="checkout" value=<?php echo $order_N;?>>สั่งซื้อ</button>
                </td>
                <td colspan="2" style="padding:30px;">
                    <button class="delete" name="back" >ย้อนกลับ</button>
                </td>
            </tr>

            <?php } }?>
        </form>
        </table>
    </div>

</body>

</html>