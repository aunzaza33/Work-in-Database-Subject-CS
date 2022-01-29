<style>
    .a-side {
    
    text-align: left;
    padding: 0px;
    margin-top:0px;

    display:inline-block;
  }
  .a-side ul{
    list-style: none;
    
  }

  .a-side li{
    background-color: rgb(58, 53, 53);
    border: solid 1px rgb(0, 0, 0);
    padding:5px;
    padding-right:15px;
    padding-left:15px;
    font-size: 15px;
    color:white;
  }
  .a-side a {
    display:block;
    color: rgb(255, 255, 255);
    padding-left: 15px;
    text-decoration: none;
    border-bottom: 1px solid #888;
    transition: .3s;
    
  }
  .a-side a:hover {
    background-color: pink;
    color:rgb(0, 0, 0);
  }

</style>
<div class="a-side">
    
    <ul>
        <li>หมวดหมู่หนังสือ</li>
            <?php
                $catagory_check_query_i = "SELECT * FROM catagory order by Catagory_ID";
                $query_catagory_i = mysqli_query($conn, $catagory_check_query_i);
                while ( $rowi = mysqli_fetch_assoc($query_catagory_i)) {
            ?>
                    
                <li ><a href="catagoryItem.php?update_id=<?php echo $rowi['Catagory_ID']; ?>"> <?php echo $rowi['Catagory_Name']; ?></a></li>
                <?php } ?>
                    
    </ul> 

</div>