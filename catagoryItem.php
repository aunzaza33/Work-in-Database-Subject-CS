
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
    <title><?php
      if(isset($_POST['searchBT'])) {
        $search = mysqli_real_escape_string($conn, $_POST['search']);
    echo $search;
    }
    if (isset($_REQUEST['update_id'])) {
        $id = $_REQUEST['update_id'];
        $catagory_select="SELECT * FROM catagory WHERE Catagory_ID = '$id'";
        $catagory_query = mysqli_query($conn, $catagory_select);
        $catagory_name= mysqli_fetch_array($catagory_query);
       echo  $catagory_name['Catagory_Name']; }
        
    ?></title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'Se_ed_header.php';?>

<br><br>

           
    
    <?php 
        $count_column = 0;
        echo '<table style="border-style:hidden;width: 70%">';
        
        if($count_column == 0){ echo '<tr style="border-style:hidden">';}
        
        if (isset($_REQUEST['update_id'])) {
          ?>
            <h1 style="text-align:center"><?php echo  $catagory_name['Catagory_Name']; ?></h1>
            <br></br>  <?php
            $select_stmt ="SELECT i.*,a.*,c.*,p.* FROM book as i INNER JOIN author as a on a.Author_ID=i.Author_ID
            INNER JOIN catagory as c on c.Catagory_ID=i.Catagory_ID
            INNER JOIN publisher as p on p.Publisher_ID =i.Publisher_ID 
            WHERE c.Catagory_ID = '$id'"; 
            $query_ITEM = mysqli_query($conn, $select_stmt); 
        } 
        if(isset($_POST['searchBT'])) {
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            ?>
            <h1 style="text-align:center">ผลการค้นหา:<?php echo  $search; ?></h1>
            <br></br>  <?php
            $select_stmt ="SELECT i.*,a.*,c.*,p.* FROM book as i INNER JOIN author as a on a.Author_ID=i.Author_ID
            INNER JOIN catagory as c on c.Catagory_ID=i.Catagory_ID
            INNER JOIN publisher as p on p.Publisher_ID =i.Publisher_ID 
            WHERE i.Book_Name LIKE '$search%'   ORDER BY Book_ISBN "; 
            $query_ITEM = mysqli_query($conn, $select_stmt); 
        } 
       
        while ($row = mysqli_fetch_array($query_ITEM)) {
            echo '<td style="
                border-style:hidden;
                width:33.33%;
                font-size: 16px;
                padding: 20px; ">';
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
    

</body>
</html>