<?php 
    session_start();
    include('server.php');
    include('errors.php'); 

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }
   

    if(!isset($deliver)){
        $deliver = 1;
    } 
    

    if(isset($_POST['change_deliverstatus'])){
            
            $order = $_REQUEST['order'];
            $state = $_REQUEST['change_deliverstatus'];
            
            $update_deliverstatus = "UPDATE book_order 
                SET DeliveryStatus = '$state'
                WHERE Order_Num = '$order' ";
            mysqli_query($conn,$update_deliverstatus);
            
            
            if($state == 1) echo "<script>alert('คำสั่งซื้อหมายเลข ".$order." : กำลังจัดส่งถึงลูกค้า');</script>";
            else if($state == 2) echo "<script>alert('คำสั่งซื้อหมายเลข ".$order." : จัดส่งถึงลูกค้าเรียบร้อยแล้ว');</script>";

            $deliver = $state;
            
    }

    if(isset($_POST['deliv1'])){
        $deliver = 1;
    }

    if(isset($_POST['deliv2'])){
        $deliver = 2;
    }

    if(isset($_POST['deliv3'])){
        $deliver = 3;
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
        $goto = "order";
        require('admin_tab.php');?>


    <div class="admin_container">

        <br><br>
        <?php 
        $view_header = "SELECT Cus_id , Cus_Name , Cus_LName FROM member WHERE email != 'admin@se-ed.com ' ";
        $view_header = mysqli_query($conn,$view_header);
        
    ?>

    <div class="admin_tab" style="width:90%;border:none">
        <form action="" method="post">
            <button class="tablinks" style="width:33.3%" name="deliv1"
                <?php
                    if(isset($deliver)){
                        if($deliver == 1){
                            btn_disable();
                        }
                    }
                ?>>กำลังจัดส่ง</button>
            <button class="tablinks" style="width:33.3%" name="deliv2"
                <?php
                    if(isset($deliver)){
                        if($deliver == 2){
                            btn_disable();
                        }
                    }
                ?>>จัดส่งแล้ว</button>
            <button class="tablinks" style="width:33.3%" name="deliv3"
                <?php
                    if(isset($deliver)){
                        if($deliver == 3){
                            btn_disable();
                        }
                    }
                ?>>จัดส่งเสร็จสิ้น</button>
        </form>
    </div>
    <table style="margin:auto;border:solid black 2px;width:90%;">
        <tr>
            <?php while($header_result = mysqli_fetch_assoc($view_header)){ ?>
            <th colspan="4" style="text-align:left;padding:3px;background-color:red;"><h2>หมายเลขลูกค้า : <?php echo $header_result['Cus_id']."<br>  
                        ชื่อลูกค้า : ".$header_result['Cus_Name']." ".$header_result['Cus_LName']; ?></h2></th>
        </tr>
            <?php
                    $dv = 1;
                    if(isset($deliver)){
                        $dv = $deliver; 
                    }
                    else $dv = 1;
                    $view_order = "SELECT * FROM book_order 
                    WHERE Cus_id = '$header_result[Cus_id]'
                        AND Order_Status = 1 
                        AND DeliveryStatus = ('$dv' - 1)
                        ORDER BY Order_Num ASC";
                    $view_order = mysqli_query($conn,$view_order); 

                    if(mysqli_num_rows($view_order) == 0) { ?>

                        <tr><td colspan='7' style='text-align:center'><h1>ไม่มีข้อมูล</h1></td></tr>
                    
                    <?php } 
                    else{
                        while($order_result = mysqli_fetch_assoc($view_order)){  

                        $total = 0;
                        $paymethod = "ไม่มี";
                        if($order_result['PayMethod'] == 1) $paymethod = "ชำระด้วยบัตรเครดิต / เดบิต";
                        else $paymethod = "ชำระเงินปลายทาง";
                        $splited_timestamp = explode(" ",$order_result['Order_Time']);
                        $date =  $splited_timestamp[0];
                        $time = $splited_timestamp[1];

                        $splited_date = explode("-",$date);
                        $day = $splited_date[2];
                        $month = $splited_date[1];
                        $year = $splited_date[0];
                        switch($month){
                            case 1:
                                $month = "มกราคม";
                                break;
                            case 2:
                                $month = "กุมภาพันธ์";
                                break;
                            case 3:
                                $month = "มีนาคม";
                                break;
                            case 4:
                                $month = "เมษายน";
                                break;
                            case 5:
                                $month = "พฤษภาคม";
                                break;
                            case 6:
                                $month = "มิถุนายน";
                                break;
                            case 7:
                                $month = "กรกฎาคม";
                                break;
                            case 8:
                                $month = "สิงหาคม";
                                break;
                            case 9:
                                $month = "กันยายน";
                                break;
                            case 10:
                                $month = "ตุลาคม";
                                break;
                            case 11:
                                $month = "พฤศจิกายน";
                                break;
                            case 12:
                                $month = "ธันวาคม";
                                break;
                    }
            ?>

        <tr>
            <td colspan="4">
                <table style="border-collapse:collapse;width:100%">
                    <tr style="background-color:#ff6666;padding:3px;">
                        <td style="text-align:left;">
                            <h3>หมายเลขคำสั่งซื้อ : <?php echo $order_result['Order_Num']; ?>
                            <br>วันที่ : <?php echo $day." ".$month." ".$year; ?>  เวลา : <?php echo $time; ?></h3>
                        </td>
                        <td style="text-align:right;">
                            <h3>วิธิชำระเงิน : <?php echo $paymethod; ?> 
                            <br> ที่อยู่ : <?php echo $order_result['Order_Address']; ?></h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr style="background-color:pink;">
            <th>ISBN</th>
            <th>ชื่อหนังสือ</th>
            <th>จำนวน</th>
            <th>ราคาต่อเล่ม</th>
        </tr>
        
            <?php 

                $view_detail = "SELECT * FROM book_order_detail 
                INNER JOIN book ON book_order_detail.Book_ISBN = book.Book_ISBN
                WHERE Order_Num = '$order_result[Order_Num]' ";
                $view_detail = mysqli_query($conn,$view_detail); 

                while($detail_result = mysqli_fetch_assoc($view_detail)){ ?>

                

        <tr style="font-size:18px;text-align:center;">
            <td><?php echo $detail_result['Book_ISBN'];  ?></td>
            <td><?php echo $detail_result['Book_Name']; ?></td>
            <td><?php echo " x ".$detail_result['Quantity']." เล่ม"; ?></td>
            <td><?php echo number_format($detail_result['Book_Price'],2)." บาท"; ?></td>

            <?php $total += $detail_result['Quantity'] * $detail_result['Book_Price']; } ?></td>
        </tr>
        <tr>
            <td colspan="4">    

                <table style="border-collapse:collapse;width:100%;background-color:#ff6666">
                    <tr>
                        <td style="text-align:left;width:50%;padding-bottom:0px">
                            <h2><?php echo "ราคาสุทธิ : ".number_format($total,2)." บาท"; ?></h2>
                        </td>
                        <td style="text-align:right;width:50%">
                            <?php 
                                switch($order_result['DeliveryStatus']){
                                    case 0:
                                        $status = "กำลังเตรียมจัดส่ง";
                                        break;
                                    case 1:
                                        $status = "จัดส่งแล้ว";
                                        break;
                                    case 2:
                                        $status = "การจัดส่งเสร็จสมบูรณ์";
                                        break;

                                }
                            ?>
                            <h2><?php echo "สถานะการจัดส่ง : ".$status ?></h2>
                        </td>
                    </tr> 
                    <?php if(isset($deliver)){
                        if($deliver != 3){ 

                            $change_btn = "จัดส่งสินค้าแล้ว";
                            
                            switch($deliver){
                                case 1:
                                    $change_btn = "จัดส่งสินค้าแล้ว";
                                    break;
                                case 2:
                                    $change_btn = "ลูกค้าได้รับสินค้าแล้ว";
                                    break;
                            }
                            
                    ?>
                            <tr style="text-align:center;">
                                <td colspan="2" style="padding-bottom:10px;">
                                    <form action="" method="post">
                            <input type="hidden" name="order" value=<?php echo $order_result['Order_Num']; ?>>
                                        <button name="change_deliverstatus" 
                                            class="buy" 
                                            style="border:solid black 2px" 
                                            value=<?php echo $deliver; ?>>
                                            <?php echo $change_btn; ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    <?php } } ?>
                </table>

            </td>
        </tr>
        <tr>
            <td colspan="4"> <br> </td>
        <tr>
            <?php } } }  ?>
    </table>
    </div>

</body>
</html>