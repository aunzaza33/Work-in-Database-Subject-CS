<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
        <div class="head">
        
        <ul>  
         <?php   
        if (isset($_SESSION['username1'])) {
                 $username1=$_SESSION['username1'] ;
                if  ($username1=="admin@se-ed.com"){
                    ?><li><a href="admin.php"><img src="se-ed.png" alt="Jane" style="width:50%;height:60px;"></a></li>
               <?php }
            elseif($username1!=="adamin@se-ed.com"){?>
                <li><a href="index0.php"><img src="se-ed.png" alt="Jane" style="width:50%;height:60px;"></a></li>
           <?php }}?>
           <?php
           if (!isset($_SESSION['username1'])){?>
                <li><a href="index0.php"><img src="se-ed.png" alt="Jane" style="width:50%;height:60px;"></a></li>
           <?php }
            $catagory_check_query_c = "SELECT * FROM catagory order by Catagory_ID";
            $query_catagory_c = mysqli_query($conn, $catagory_check_query_c);
           ?>
                
                <li class="item"><a href="#">ซีเอ็ดบุ๊คเซ็นเตอร์</a>
                <ul>
                   
                </ul> 
            </li>
            <li class="item"><a href="#">เกี่ยวกับเรา</a>
                <ul>
                   

                </ul> 
            </li>
        </div>					
					
                <div class="nav">
                       
            <ul>  
                <li class="item"><a href="#">สินค้าเเละบริการ</a>
                <ul>
                <?php if (!isset($_SESSION['username1'])){                
                    while ( $rowq = mysqli_fetch_assoc($query_catagory_c)) {
                ?>
                    <li ><a href="catagoryItem.php?update_id=<?php echo $rowq['Catagory_ID']; ?>"> <?php echo $rowq['Catagory_Name']; ?></a></li>
                    <?php } 
                     }
                          if (isset($_SESSION['username1']))  
                         if ($_SESSION['username1']=="admin@se-ed.com") {
                            while ( $rowq = mysqli_fetch_assoc($query_catagory_c)) {
                                ?>
                                    <li ><a href="admin_catagory_books.php?update_id=<?php echo $rowq['Catagory_ID']; ?>"> <?php echo $rowq['Catagory_Name']; ?></a></li>
                                    <?php } }
                                    ?>
                   <?php
                    while ( $rowq = mysqli_fetch_assoc($query_catagory_c)) {
                        ?>
                            <li ><a href="catagoryItem.php?update_id=<?php echo $rowq['Catagory_ID']; ?>"> <?php echo $rowq['Catagory_Name']; ?></a></li>
                            <?php } ?>
                                 

                  
                  
                </ul> 
            </li>
                <li><a href="#"><form action="catagoryItem.php" method="post">
            <label ;>ค้นหา  &#8739;</label>
            <input type ="text" name ="search";>&#8739;
            <button type="submit" name="searchBT" class="btnlogin.">ค้นหา</button>
            </a></form>
                </li>
                
                <?php if (!isset($_SESSION['username1'])) : ?>
                    <li class="item"><a href="#">เข้าสู่ระบบ</a>
                        <ul>
                            <li> <a href="login.php">เข้าสู่ระบบ</a></li>
                            <li> <a href="register.php">สมัครสมาชิก</a></li>
                        </ul>
                        </li>
            <?php endif ?>
            
        <?php if (isset($_SESSION['username1'])) : ?>
            <?php if ($_SESSION['username1']=="admin@se-ed.com") : ?>
                <li class="item"><a href="#";>ยินดีต้อนรับ <?php echo $_SESSION['username1'];?></a>
                        <ul>
                        <a href="index0.php?logout='1'";>ออกจากระบบ</a>

                        </ul>
                        </li>
            <?php endif ?>
            
                <?php if ($_SESSION['username1']!=='admin@se-ed.com') : ?>
                    <li class="item"><a href="#";>ยินดีต้อนรับ <?php echo $_SESSION['username1'];?></a>
                <ul>
                    <a href="editprofile.php">แก้ไขโปรไฟล์</a>
                    <a href="basket.php">ตะกร้าสินค้า</a>   
                    <a href="checkout_history.php">ประวัติคำสั่งซื้อ</a>
                    <a href="index0.php?logout='1'";>ออกจากระบบ</a>
                    <?php
                        $query = "SELECT Cus_id FROM member WHERE email = '$username1' ";
                        $result = mysqli_query($conn, $query);
                        $result = mysqli_fetch_array($result);
                        extract($result);

                        $customer_id = $result['Cus_id'];?>
                         <?php endif ?>
                    
                </ul>
                </li>  
        <?php endif ?>
            </ul>
    </div>

</div>
</div>
        </body>