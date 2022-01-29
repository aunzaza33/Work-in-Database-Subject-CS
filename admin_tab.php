<style>
    /* Style the tab */
    .admin_tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #444;
        width: 95%;
        margin: auto;
    }

    /* Style the buttons inside the tab */
    .admin_tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 20px;
        width: 20%;
    }

    /* Change background color of buttons on hover */
    .admin_tab button:hover {
        background-color: pink;
        color: black;
    }

    /* Create an active/current tablink class */
    .admin_tab button.active {
        background-color: red;
        color:white;
    }
            
</style>

<br><br>

    <?php
        function btn_disable(){
            ?>
            disabled

            <?php
        }
    ?>
    <h1 style="text-align:center">ยินดีต้อนรับ Admin</h1>
    <h2 style="text-align:center">การจัดการสินค้า</h2>

<br><br>

<div class="admin_tab">
    <button class="tablinks" 
        <?php
            if(isset($goto)){
                if($goto == "books"){
                    btn_disable();
                }
            }
        ?>
        onclick ="window.location.href='/bookstore/admin_books.php'">ข้อมูลหนังสือ</button>
    <button class="tablinks" 
        <?php
            if(isset($goto)){
                if($goto == "publishers"){
                    btn_disable();
                }
            }
        ?>
        onclick ="window.location.href='/bookstore/admin_publisher.php'">สำนักพิมพ์</button>
    <button class="tablinks" 
        <?php
            if(isset($goto)){
                if($goto == "catagories"){
                    btn_disable();
                }
            }
        ?>
        onclick="window.location.href='/bookstore/admin_catagory.php'">หมวดหมู่หนังสือ</button>
    <button class="tablinks" 
        <?php
            if(isset($goto)){
                if($goto == "authors"){
                    btn_disable();
                }
            }
        ?>
        onclick ="window.location.href='/bookstore/admin_authors.php'">ผู้แต่ง</button>
    <button class="tablinks"
        <?php
            if(isset($goto)){
                if($goto == "order"){
                    btn_disable();
                }
            }
        ?>
        onclick="window.location.href='/bookstore/admin_order.php'">คำสั่งซื้อ</button>
    
</div>