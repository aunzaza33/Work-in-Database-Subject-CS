
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
    <title>SE-ED</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'Se_ed_header.php';?>

<br><br>
    
    <h1 style="text-align:center">หนังสือเเนะนำ</h1>
    
    <br></br>

    <table style="width:100%">
        <tr>
            <td style="width:15%;">
                <?php require 'a-side.php'; ?>
            </td>

            <td>
    <?php 
        

        $count_column = 0;
        echo '<table style="border-style:hidden;width: 70%;margin:auto;">';
        
        if($count_column == 0){ echo '<tr style="border-style:hidden">';}
        
        $select_stmt ='SELECT i.*,a.*,c.*,p.* FROM book as i INNER JOIN author as a on a.Author_ID=i.Author_ID
        INNER JOIN catagory as c on c.Catagory_ID=i.Catagory_ID
        INNER JOIN publisher as p on p.Publisher_ID =i.Publisher_ID 
        ORDER BY Book_ISBN '; 
        $query_ITEM = mysqli_query($conn, $select_stmt);
        while ($row = mysqli_fetch_array($query_ITEM)) {
                
            echo '<td style="
                border-style:hidden;
                width:33.33%;
                font-size: 16px;
                padding: 40px;
                 ">';
            echo '<b>'.$row['Book_Name']. '</b><br>'; ?>

            <a href="buy_book.php?update_id=<?php echo $row['Book_ISBN']; ?>"><img src="upload/<?php echo $row['image']; ?>" width="200px" height="280px" alt=""></a><br> 

            <?php

            echo '<label>ราคา ' .number_format($row['Book_Price'],2). ' บาท</label> <br>';
            echo '<label>มีอยู่ '.number_format($row['Book_Quantity']).' เล่ม</label>  <br>';
            echo '<label>ขายแล้ว '.number_format($row['Book_SaleQuantity']).' เล่ม</label> <br>';
            echo '</td>';

            $count_column++;
            if($count_column == 3){
                echo '</tr>';    
                $count_column = 0;
            }
        }
        echo '</table>';
    ?>
            </td>
        <tr>
    </table>
    

</body>
</html>