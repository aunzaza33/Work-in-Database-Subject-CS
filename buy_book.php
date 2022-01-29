
<?php 
    session_start();
    include('server.php'); 

    if(isset($_REQUEST['update_id'])){
        $id = $_REQUEST['update_id'];
    }

    if(isset($id)){
        $select_stmt = "SELECT i.*,a.*,c.*,p.* FROM book as i INNER JOIN author as a on a.Author_ID=i.Author_ID
                    INNER JOIN catagory as c on c.Catagory_ID=i.Catagory_ID
                    INNER JOIN publisher as p on p.Publisher_ID =i.Publisher_ID 
                    WHERE Book_ISBN = '$id' "; 

        $query_ITEM = mysqli_query($conn, $select_stmt);
        $book_info = mysqli_fetch_array($query_ITEM);
        extract($book_info);

    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }
    if (!isset($_SESSION['username1'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_REQUEST['btn_placeorder'])) {

        $cus_id = (int)$_POST['btn_placeorder']; 
        $book_id = $_REQUEST['update_id'];
        $quantity = (int)$_REQUEST['QTR'];
        $book_price = (double)$book_info['Book_Price'];
        $max = (int)$_REQUEST['MaxQTY'];
        $total = $book_price * $quantity;

        $active_basket_checking = "SELECT * FROM book_order WHERE Cus_id = '$cus_id' AND Order_Status = 0";
        $active_basket_checking = mysqli_query($conn,$active_basket_checking);
        

        if(mysqli_num_rows($active_basket_checking) == 0){

            //does not have any basket; create new one
            $order_placement = "INSERT INTO book_order (Cus_id)
            VALUES ('$cus_id') ";
            mysqli_query($conn,$order_placement);
            
            $active_basket = "SELECT * FROM book_order WHERE Cus_id = '$cus_id' AND Order_Status = 0";
            $active_basket = mysqli_query($conn,$active_basket);
            $active_basket_result = mysqli_fetch_array($active_basket,MYSQLI_ASSOC);

            $order_update = "INSERT INTO book_order_detail(Order_Num,Book_ISBN,Quantity)
            VALUES('$active_basket_result[Order_Num]','$book_id','$quantity')";
            mysqli_query($conn,$order_update);
            
            echo "<script>alert('เพิ่มสินค้าสำเร็จ')</script>";

            header( "location: index0.php" );
        }
        else{

            echo "<script>alert('add book complete')</script>";
            $active_basket_checking = mysqli_fetch_array($active_basket_checking,MYSQLI_ASSOC);

            $current_num = $active_basket_checking['Order_Num'];

            
            //have basket, check if that book already in basket

            $book_check = "SELECT * FROM book_order_detail 
                WHERE Order_NUM = $current_num AND Book_ISBN = '$book_id' ";
            $book_check = mysqli_query($conn,$book_check);
            $book_ch = mysqli_fetch_array($book_check);
            

            if(mysqli_num_rows($book_check) == 0){

                //this book does not in basket; add it
                
                $order_update = "INSERT INTO book_order_detail(Order_Num,Book_ISBN,Quantity)
                VALUES('$current_num','$book_id','$quantity')";
                mysqli_query($conn,$order_update);

                echo "<script>alert('เพิ่มสินค้าสำเร็จ')</script>";

                header( "location: index0.php" );

            }
            else{

                //already have book; update quantity
                if(($book_ch['Quantity'] + $quantity)  > $max){
                    echo "<script>alert('กรุณาระบุจำนวนสินค้าใหม่')</script>";
                }
                else{
                    $order_update = "UPDATE book_order_detail
                        SET Quantity = ('$book_ch[Quantity]' + '$quantity')
                        WHERE Order_NUM = '$current_num' AND Book_ISBN = '$book_id' ";
                    mysqli_query($conn,$order_update);

                    echo "<script>alert('เพิ่มสินค้าสำเร็จ')</script>";
                    header( "location: index0.php" );
                    
                }
                
            }
   
        }    
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy_a_Book</title>
    <link rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <header>
    <?php require 'Se_ed_header.php';?>
    </header>

    <br><br>

    <?php
    if(isset($id)){ ?>
    
    <div class="book_table">
        <table>
            <tr>
                <th rowspan='9' style="width:45%;">
                    <img src= <?php echo "upload/".$book_info['image']; ?> width="250px" height="350px">
                </th>
            </tr>

            <tr>

                <td colspan="3" style="
                    width:55%;
                    font-size: 30px;
                    border-bottom:solid grey 2px;
                    padding: 0px">
                    <strong><?php echo $book_info['Book_Name']; ?></strong>
                </td>
            </tr>

            <tr style="font-size: 18px;">
                <td colspan="3" ><?php echo "หมวดหมู่ : ".$book_info['Catagory_Name']; ?></td>
            </tr>

            <tr style="font-size: 18px;">
                <td colspan="3" ><?php echo "ผู้แต่ง : ".$book_info['Author_Name']." ".$book_info['Author_LastName']; ?></td>
            </tr>

            <tr style="font-size: 18px;">
                <td colspan="3" ><?php echo "สำนักพิมพ์ : ".$book_info['Publisher_Name']; ?></td>
            </tr>

            <tr style="font-size: 25px;">
                <td colspan="3" ><strong><?php echo "ราคา ".number_format($book_info['Book_Price'],2)." บาท"; ?></strong></td>
            </tr>

            <tr style="font-size: 22px;">
                <td colspan="3" style="width:33%;"><?php echo "จำนวนคงเหลือ ".$book_info['Book_Quantity']." เล่ม"; ?></td>
            </tr>
        <form action="" method="post">
                <tr style="font-size: 20px;padding:0px">
                    <td style="width:25%;">
                        ต้องการสั่งซื้อจำนวน :
                    </td>

                    <td style="width:20%;margin:auto;">
                        <input name="QTR" type="number" min="1" max=<?php echo $book_info['Book_Quantity'] - $book_info['Book_SaleQuantity']; ?>
                        style="padding:5px;" value="1">
                    </td>
                        <input type="hidden" name="MaxQTY" value=<?php echo  $book_info['Book_Quantity']; ?>>
                    <td style="width:33%;text-align:left;margin:auto;">
                        เล่ม
                    </td>
                </tr>

                <tr style="margin:auto;">
                    <td colspan="1.5" ><button name="btn_placeorder" class="buy" value="<?php echo $customer_id ?>">ซื้อ</button></td>
                    <td colspan="1.5" ><a href="index0.php" class="not">ย้อนกลับ</a></td>
                </tr>
        </form>
        </table>
    </div>
    <?php } ?>


    
</body>
</html>