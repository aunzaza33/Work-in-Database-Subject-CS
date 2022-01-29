<?php 

    if(isset($id)){
        $book_record = "SELECT * FROM book WHERE Book_ISBN = '$id' ";
        $book_record = mysqli_query($conn, $book_record);
        $row = mysqli_fetch_array($book_record);
        extract($row);
    }

    include('server.php'); 
    if (isset($_POST['btn_insert'])){

            $ISBN = $_REQUEST['txt_isbn'];
            $name = $_REQUEST['txt_name'];
            $Weight =  (double)$_REQUEST['txt_Weight'];
            $Price=  (double)$_REQUEST['txt_Price'];
            $Quantity =   (int)$_REQUEST['num_Quantity'];
            $Publish_ID = $_REQUEST['ID_Publish'];
            $PublishNumber = $_REQUEST['num_PublishNumber'];
            $PublishYear =  (int)$_REQUEST['txt_PublishYear'];
            $Catagory_ID = $_REQUEST['ID_Catagory'];
            $Author_ID = $_REQUEST['ID_Author'];
            $image_file = $_FILES['txt_file']['name'];
            $type = $_FILES['txt_file']['type'];
            $size = $_FILES['txt_file']['size'];
            $temp = $_FILES['txt_file']['tmp_name'];

            $path = "upload/" . $image_file; // set upload folder path

            $errorMsg = array();
            if (empty($ISBN)) array_push($errorMsg,"Please Enter ISBN (ONLY number)");
            else{
                $isbn_check = "SELECT Book_ISBN FROM book WHERE Book_ISBN = '$ISBN'";
                if(mysqli_num_rows(mysqli_query($conn, $isbn_check)) > 0){
                    array_push($errorMsg,"ISBN cannot duplicated");
                }
            }

            if (empty($name)) array_push($errorMsg,"Please Enter name");
                
            if (empty($Weight)) array_push($errorMsg,"Please Enter Weight (ONLY number)");
                
            if (empty($Price)) array_push($errorMsg,"Please Enter Price (ONLY number)");
                
            if (empty($Quantity)) array_push($errorMsg,"Please Enter Quantity");
                
            if (empty($Publish_ID) || ($Publish_ID=="-")) array_push($errorMsg,"Please Enter Publisher");
                
            if (empty($PublishNumber)) array_push($errorMsg,"Please Enter PublishNumber (ONLY number)");
                
            if (empty($PublishYear)) array_push($errorMsg,"Please Enter PublishYear");
                
            if (empty($Catagory_ID) || ($Catagory_ID=="-")) array_push($errorMsg,"Please Enter Catagory");
            
            if (empty($Author_ID) || ($Author_ID=="-")) array_push($errorMsg,"Please Enter Author");

            if (empty($image_file)) {
                array_push($errorMsg,"Please Select Image");
            }else if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
                if (!file_exists($path)) { // check file not exist in your upload folder path
                    if ($size > 5000000) { // check file size 5MB
                        array_push($errorMsg,"Your file too large please upload 5MB size"); // error message file size larger than 5mb
                    }
                } else array_push($errorMsg,"File already exists... Check upload folder"); // error message file not exists your upload folder path
                
            } else array_push($errorMsg,"Upload JPG, JPEG, PNG & GIF file formate...");

        if (count($errorMsg) == 0) {
            $insert_stmt = "INSERT INTO book(Book_ISBN ,Book_Name ,image,Book_Weight,Book_Price,Book_Quantity,Book_PublishNumber
            ,Book_PublishYear,Publisher_ID,Catagory_ID,Author_ID) 
            VALUES ('$ISBN',
                    '$name',
                    '$image_file',
                    '$Weight',
                    '$Price',
                    '$Quantity',
                    '$PublishNumber',
                    '$PublishYear',
                    '$Publish_ID',
                    '$Catagory_ID',
                    '$Author_ID')";
            mysqli_query($conn, $insert_stmt);
                if ($insert_stmt) {
                    echo "<script>alert('เพิ่มข้อมูลหนังสือสำเร็จ');</script>";
                    move_uploaded_file($temp, 'upload/'.$image_file); // move upload file temperory directory to your upload folder
                } else {
                    echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
                }
        }

    }

    if(isset($_POST['btn_submit'])){
    
        $ISBN = $_REQUEST['txt_isbn'];
        $name = $_REQUEST['txt_name'];
        $Weight =  (double)$_REQUEST['txt_Weight'];
        $Price=  (double)$_REQUEST['txt_Price'];
        $Quantity =   (int)$_REQUEST['num_Quantity'];
        $Publish_ID = $_REQUEST['ID_Publish'];
        $PublishNumber = $_REQUEST['num_PublishNumber'];
        $PublishYear =  (int)$_REQUEST['txt_PublishYear'];
        $Catagory_ID = $_REQUEST['ID_Catagory'];
        $Author_ID = $_REQUEST['ID_Author'];
        $image_file = $_FILES['txt_file']['name'];
        $type = $_FILES['txt_file']['type'];
        $size = $_FILES['txt_file']['size'];
        $temp = $_FILES['txt_file']['tmp_name'];

        $path = "upload/".$image_file;
        $directory = "upload/"; // set upload folder path for upadte time previous file remove and new file upload for next use

        $errorMsg = array();

        if (empty($ISBN)) array_push($errorMsg,"Please Enter ISBN");

        if (empty($name)) array_push($errorMsg,"Please Enter name");
                
        if (empty($Weight)) array_push($errorMsg,"Please Enter Weight (ONLY number)");
            
        if (empty($Price)) array_push($errorMsg,"Please Enter Price (ONLY number)");
            
        if (empty($Quantity)) array_push($errorMsg,"Please Enter Quantity");
            
        if (empty($Publish_ID) || ($Publish_ID=="-")) array_push($errorMsg,"Please Enter Publisher");
            
        if (empty($PublishNumber)) array_push($errorMsg,"Please Enter PublishNumber (ONLY number)");
            
        if (empty($PublishYear)) array_push($errorMsg,"Please Enter PublishYear");
            
        if (empty($Catagory_ID) || ($Catagory_ID=="-")) array_push($errorMsg,"Please Enter Catagory");
        
        if (empty($Author_ID) || ($Author_ID=="-")) array_push($errorMsg,"Please Enter Author");

        if ($image_file) {
            if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
                if (!file_exists($path)) { // check file not exist in your upload folder path
                    if ($size < 5000000) { // check file size 5MB
                        unlink($directory.$row['image']); // unlink function remove previous file
                        move_uploaded_file($temp, 'upload/'.$image_file); // move upload file temperory directory to your upload folder
                    } else array_push($errorMsg,"Your file too large please upload 5MB size"); // error message file size larger than 5mb
                } else array_push($errorMsg,"File already exists... Check upload folder"); // error message file not exists your upload folder path
            } else array_push($errorMsg,"Upload JPG, JPEG, PNG & GIF file formate...");
        } else $image_file = $row['image']; // if you not select new image than previos image same it is it.
        
        if (count($errorMsg) == 0) {
            $update_stmt = "UPDATE book SET
                Book_Name = '$name',
                image = '$image_file',
                Book_Weight = '$Weight',
                Book_Price = '$Price',
                Book_Quantity = '$Quantity',
                Book_PublishNumber = '$PublishNumber',
                Book_PublishYear = '$PublishYear',
                Publisher_ID = '$Publish_ID',
                Catagory_ID = '$Catagory_ID',
                Author_ID = '$Author_ID'
                WHERE Book_ISBN = '$id'";

            mysqli_query($conn, $update_stmt);
                if ($update_stmt) {
                    echo "<script>alert('แก้ไขข้อมูลหนังสือสำเร็จ');</script>";
                    move_uploaded_file($temp, 'upload/'.$image_file); // move upload file temperory directory to your upload folder
                    echo "<script>window.location.href='/bookstore/admin_books.php'</script>";

                } else {
                    echo "<script>alert('มีข้อผิดพลาด  กรุณาลองใหม่อีกครั้ง');</script>";
                }
        }

    }
    if(isset($_POST['btn_cancel'])){
        mysqli_close($conn);
        echo "<script>window.location.href='/bookstore/admin_books.php'</script>";
    }    

    function submit_button($id){
        ?>
        <button name="btn_submit" class="edit" value=<?php echo $id; ?>>
            ยืนยัน
        </button>
        <?php
    }

    function cancel_button(){
        ?>
        <button name="btn_cancel" class="delete">
            ยกเลิก
        </button>
        <?php
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>        
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SE-ED Add Book</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
    <link  rel="stylesheet" href="styleadmin.css">
</head>
<body>

<div class="container-text-center">
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group" style="
                margin:auto;
                border-radius: 0px;
                border:solid black 2px;
                width: 775px;
                border-top:none;">
                <?php 
                    if(isset($errorMsg)){ 
                        if(count($errorMsg) > 0) {
                ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errorMsg as $err){ ?>
                        <strong><?php echo $err; ?></strong>
                        <br>
                        <?php }?>
                    </div>
                <?php } }?>

                <?php 
                    if(isset($insertMsg)) {
                ?>
                    <div class="alert alert-success">
                        <strong><?php echo $insertMsg; ?></strong>
                    </div>
                <?php } 
                ?>
                <div class="input-group">
                    <div class="row">
                        <div class="col-sm-9">
                            <label for="isbn" class="col-sm-3-control-label">เลข ISBN</label>
                            <input type="text" name="txt_isbn" class="form-control textstyle" autocomplete="off" placeholder="ระบุเลข ISBN..."
                            <?php if(isset($id)){ ?> disabled <?php echo "value =  ".$row['Book_ISBN']; } ?> >
                        </div>
                    <div class="col-sm-9">
                        <label for="name" class="col-sm-3-control-label">ชื่อหนังสือ</label>
                        <input type="text" name="txt_name" class="form-control textstyle" autocomplete="off" placeholder="ระบุชื่อหนังสือ..."
                        <?php if(isset($id)){?> value = <?php echo $row['Book_Name'];  }?>>
                    </div>
                    <div class="col-sm-9">
                        <label for="Weight" class="col-sm-3-control-label">นํ้าหนักหนังสือ</label>
                        <input type="text" name="txt_Weight" class="form-control textstyle" autocomplete="off" placeholder="ระบุน้ำหนักหนังสือ..."
                        <?php if(isset($id)){?> value = <?php echo $row['Book_Weight'];  }?> >
                    </div>
                    <div class="col-sm-9">
                        <label for="Price" class="col-sm-3-control-label">ราคาหนังสือ</label>
                        <input type="text" name="txt_Price" class="form-control textstyle" autocomplete="off" placeholder="ระบุราคาหนังสือ..."
                        <?php if(isset($id)){?> value = <?php echo $row['Book_Price'];  }?> >
                    </div>
                    <div class="col-sm-9">
                        <label for="Quantity" class="col-sm-3-control-label">จำนวนหนังสือ</label>
                        <input type="number" name="num_Quantity" class="form-control textstyle" min="1"
                        <?php if(isset($id)){?> value = <?php echo $row['Book_Quantity'];  }?> >
                    </div>
                    <div class="col-sm-9">

                        <label for="Publish" class="col-sm-3-control-label">สำนักพิมพ์</label>
                        <select name="ID_Publish" class="form-control textstyle">
                            <option
                                <?php if(isset($id)){
                                    if(!isset($row['Publisher_ID'])){
                                ?>selected="selected"
                                <?php } } ?>
                            >-</option>
                        <?php 
                            $publisher_check_query = "SELECT Publisher_ID,Publisher_Name FROM publisher order by Publisher_ID";
                            $query_publisher = mysqli_query($conn, $publisher_check_query);
                            while($result_publisher = mysqli_fetch_assoc($query_publisher)){
                        ?>
                            <option value="<?php echo $result_publisher['Publisher_ID']; ?>"
                                <?php if(isset($id)){
                                    if($result_publisher['Publisher_ID'] == $row['Publisher_ID']){
                                ?> selected="selected"
                                <?php } } ?>
                            > <?php echo $result_publisher['Publisher_Name']; ?></option>
                            <?php } ?>
                            <!--<option value="publisher_add">เพิ่มสำนักพิมพ์...</option>-->
                            </select>

                    </div>
                    <div class="col-sm-9">

                        <label for="PublishNumber" class="col-sm-3-control-label">จำนวนครั้งที่ตีพิมพ์หนังสือ</label>
                        <input type="number" name="num_PublishNumber" class="form-control textstyle" min="1"
                        <?php if(isset($id)){?> value = <?php echo $row['Book_PublishNumber'];  }?> >

                    </div>
                    <div class="col-sm-9">

                        <label for="PublishYear" class="col-sm-3-control-label">ปีที่ตีพิมพ์หนังสือ</label>
                        <input type="text" name="txt_PublishYear" class="form-control textstyle" autocomplete="off" placeholder="ระบุปีที่ตีพิมพ์..."
                        <?php if(isset($id)){?> value = <?php echo $row['Book_PublishYear'];  }?> >

                    </div>

                    <div class="col-sm-9">
                        <label for="Catagory" class="col-sm-3-control-label">หมวดหนังสือ</label>
                        <select name="ID_Catagory" class="form-control textstyle">
                            <option 
                                <?php if(isset($id)){
                                    if(!isset($row['Catagory_ID'])){
                                ?>selected="selected"
                                <?php } } ?>
                            >-</option>
                            <?php 
                            $catagory_check_query = "SELECT * FROM catagory order by Catagory_ID";
                            $query_catagory = mysqli_query($conn, $catagory_check_query);                     
                            while ($result_catagory = mysqli_fetch_assoc($query_catagory)) {
                        ?>
                            <option value="<?php echo $result_catagory['Catagory_ID']; ?>"
                                <?php if(isset($id)){
                                    if($result_catagory['Catagory_ID'] == $row['Catagory_ID']){
                                ?> selected="selected"
                                <?php } } ?>
                            > <?php echo $result_catagory['Catagory_Name']; ?></option>
                            <?php } ?>
                            <!--<option value="catagory_add">เพิ่มหมวดหมู่...</option>-->
                            </select>

                    </div>
                    <div class="col-sm-9">

                        <label for="Author" class="col-sm-3-control-label">ผู้เเต่ง</label>
                        <select name="ID_Author"class="form-control textstyle">
                            <option
                                <?php if(isset($id)){
                                    if(!isset($row['Author_ID'])){
                                ?>selected="selected"
                                <?php } } ?>
                            
                            >-</option>
                        <?php
                            $author_check_query = "SELECT * FROM author order by Author_ID";
                            $query_author = mysqli_query($conn, $author_check_query);
                            while($result_author = mysqli_fetch_assoc($query_author)){
                        ?>
                            <option value="<?php echo $result_author['Author_ID']; ?>"
                                <?php if(isset($id)){
                                    if($result_author['Author_ID'] == $row['Author_ID']){
                                ?> selected="selected"
                                <?php } } ?>
                            > <?php echo $result_author['Author_Name']." ".$result_author['Author_LastName']; ?></option>
                            <?php } ?>
                            <!--<option value="author_add">เพิ่มผู้แต่ง...</option>-->
                            </select>
                    </div>
                </div>
            </div>
            
            <div class="button-group">
                <div class="col-sm-9">
                    <label for="name" class="col-sm-3 control-label" style="font-size:18px;">รูปตัวอย่างหนังสือ</label>
                    <input type="file" name="txt_file" class="form-control textstyle" onchange="loadFile(event)"
                    <?php if(isset($id)){?> value = <?php echo $row['image'];  }?> >
                </div>
            </div>        
                <img <?php if(isset($id)){?> src = <?php echo "upload/".$row['image'];  }?> id="output" width="250" height="300" style="display: block;margin: 0 auto;"/>
            <div class="button-group">
                    <br>
                <?php
                if(isset($id)){ ?>
                    <table style="margin:auto;width:100%">
                        <tr>
                            <th style="width:50%">
                                <?php submit_button($id); ?>
                            </th>
                            <th style="width:50%">
                                <?php cancel_button(); ?>
                            </th>
                        </tr>
                    </table>

                    <?php
                } else {?><input type="submit" name="btn_insert" class="edit" style="margin:auto;" value="เพิ่มข้อมูล"> <?php }?>
            </div>
        </form>


    </div>


</div>

<script>
    var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
        }
    };

</script>

</body>
</html>