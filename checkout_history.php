<?php 

session_start();
    include('server.php'); 
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SE-ED Edit Book</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
    <link  rel="stylesheet" href="styleadmin.css">

    

</head>
<body>

<?php require 'Se_ed_header.php';?>

    <br><br>
        <h1 style="text-align:center">ประวัติคำสั่งซื้อ</h1>
    <br><br>

    <?php 
        $view_header = "SELECT Cus_id , Cus_Name , Cus_LName ,Cus_Point FROM member WHERE Cus_id = '$customer_id' " ;
        $view_header = mysqli_query($conn,$view_header);
        $header_result = mysqli_fetch_assoc($view_header);

        $view_order = "SELECT * FROM book_order WHERE Cus_id = '$customer_id' AND Order_Status = 1 ORDER BY Order_Num ASC";
        $view_order = mysqli_query($conn,$view_order);
        
    ?>

    <table style="margin:auto;border:solid black 2px;width:90%">
        <tr>
            <th colspan="7" style="text-align:left;"><h2>หมายเลขลูกค้า : <?php echo $header_result['Cus_id']."<br>  
                ชื่อลูกค้า : ".$header_result['Cus_Name']." ".$header_result['Cus_LName']."<br>คะแนน : ".$header_result['Cus_Point']." คะแนน"; ?></h2></th>
        </tr>
        <tr><?php while($order_result = mysqli_fetch_assoc($view_order)){ 
            $paymethod = "ไม่มี";
            if($order_result['PayMethod'] == 1){
                $paymethod = "ชำระด้วยบัตรเครดิต / เดบิต";
            }
            else{
                $paymethod = "ชำระเงินปลายทาง";
            }
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
                <td colspan="7">
                    <table style="border-collapse:collapse;width:100%">
                        <tr style="background-color:red;padding:3px;">
                            <h2>
                                <td style="text-align:left;">
                                    <h3>หมายเลขคำสั่งซื้อ : <?php echo $order_result['Order_Num']; ?>
                                    <br>วันที่ : <?php echo $day." ".$month." ".$year; ?>  เวลา : <?php echo $time; ?></h3>
                                </td>
                                <td style="text-align:right;">
                                    <h3>วิธิชำระเงิน : <?php echo $paymethod; ?> 
                                    <br> ที่อยู่ : <?php echo $order_result['Order_Address']; ?></h3>
                                </td>
                            </h2>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="background-color:pink;">
                <th>ISBN</th>
                <th>ชื่อหนังสือ</th>
                <th>หมวดหมู่</th>
                <th>ผู้แต่ง</th>
                <th>สำนักพิมพ์</th>
                <th>จำนวนเล่ม</th>
                <th>ราคารวม</th>
            </tr>
            <?php 
                $view_detail = "SELECT * FROM book_order_detail 
                    INNER JOIN book ON book_order_detail.Book_ISBN = book.Book_ISBN
                    INNER JOIN catagory ON book.Catagory_ID = catagory.Catagory_ID
                    INNER JOIN author ON book.Author_ID = author.Author_ID
                    INNER JOIN publisher ON book.Publisher_ID = publisher.Publisher_ID
                    WHERE Order_Num = '$order_result[Order_Num]' ";
                $view_detail = mysqli_query($conn,$view_detail);
                while($detail_result = mysqli_fetch_assoc($view_detail)){
            ?>
                    
        
        <tr style="font-size:18px;text-align:center;">
                    <td><?php echo $detail_result['Book_ISBN'] ?></td>
                    <td><?php echo $detail_result['Book_Name'] ?></td>
                    <td><?php echo $detail_result['Catagory_Name'] ?></td>
                    <td><?php echo $detail_result['Author_Name']." ".$detail_result['Author_LastName'] ?></td>
                    <td><?php echo $detail_result['Publisher_Name'] ?></td>
                    <td><?php echo $detail_result['Quantity'] ?></td>
                    <td><?php echo number_format($detail_result['Quantity'] * $detail_result['Book_Price'],2)." บาท" ?></td>
        </tr>
        
            <?php } ?>
        <tr style="text-align:center;background-color:red">
            <td colspan="7" style="padding: 8px;">
            <?php
                $status = "get and go";
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
            <h2><?php echo "สถานะการจัดส่ง : ".$status; ?></h2>
                    
            </td>
            
        </tr>
        <tr>
            <td><br><br><br></td>
        </tr>
            <?php }?>
    <table>


                
</body>

</html>