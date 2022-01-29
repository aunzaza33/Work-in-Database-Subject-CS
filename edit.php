<?php 

session_start();
    include('server.php'); 
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }

    if (isset($_REQUEST['update_id'])) {
            $id = $_REQUEST['update_id'];
            $select_stmt ="SELECT i.*,a.*,c.*,p.* FROM book as i INNER JOIN author as a on a.Author_ID=i.Author_ID
            INNER JOIN catagory as c on c.Catagory_ID=i.Catagory_ID
            INNER JOIN publisher as p on p.Publisher_ID =i.Publisher_ID 
            WHERE Book_ISBN = '$id'"; 
            $query_ITEM = mysqli_query($conn, $select_stmt);
            $row = mysqli_fetch_array($query_ITEM);
            extract($row);
            $catagory_check_query = "SELECT * FROM catagory order by Catagory_ID";
            $query_catagory = mysqli_query($conn, $catagory_check_query);
           
        
    }   

    if (isset($_REQUEST['btn_update'])) {
       

            $name = $_REQUEST['txt_name'];
            $Weight = $_REQUEST['txt_Weight'];
            $Price= $_REQUEST['txt_Price'];
            $Quantity = $_REQUEST['txt_Quantity'];
            $Publish = $_REQUEST['txt_Publish'];
            $PublishNumber = $_REQUEST['txt_PublishNumber'];
            $PublishYear = $_REQUEST['txt_PublishYear'];
            $Catagory = $_REQUEST['txt_Catagory'];
            $Author= $_REQUEST['txt_Author'];
            $LastAuthor= $_REQUEST['txt_AuthorLast'];
            $image_file = $_FILES['txt_file']['name'];
            $type = $_FILES['txt_file']['type'];
            $size = $_FILES['txt_file']['size'];
            $temp = $_FILES['txt_file']['tmp_name'];

            $path = "upload/".$image_file;
            $directory = "upload/"; // set uplaod folder path for upadte time previos file remove and new file upload for next use

            if ($image_file) {
                if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
                    if (!file_exists($path)) { // check file not exist in your upload folder path
                        if ($size < 5000000) { // check file size 5MB
                            unlink($directory.$row['image']); // unlink functoin remove previos file
                            move_uploaded_file($temp, 'upload/'.$image_file); // move upload file temperory directory to your upload folder
                        } else {
                            $errorMsg = "Your file to large please upload 5MB size";
                        }
                    } else {
                        $errorMsg = "File already exists... Check upload folder";
                    }
                } else {
                    $errorMsg = "Upload JPG, JPEG, PNG & GIF formats...";
                }
            } else {
                $image_file = $row['image']; // if you not select new image than previos image same it is it.
            }
    
            
            if (!isset($errorMsg)) {
                $catagory_check_query = "SELECT * FROM catagory WHERE Catagory_Name = '$Catagory'   LIMIT 1";
                $query_catagory = mysqli_query($conn, $catagory_check_query);
                $result_catagory = mysqli_fetch_array($query_catagory);
            if ($result_catagory) { // if user exists
                if ($result_catagory['Catagory_Name'] == $Catagory) {
                    $Catagory_ID=$result_catagory['Catagory_ID'];
                }
                else{
                    $insert_catagory = "INSERT INTO catagory(Catagory_Name) VALUES ('$Catagory')";
                    mysqli_query($conn, $insert_catagory);
                
                if ($insert_catagory['Catagory_Name'] == $Catagory) {
                    $Catagory_ID=$insert_catagory['Catagory_ID'];
                }
            }
            }
            $Author_check_query = "SELECT * FROM author WHERE Author_Name = '$Author'AND Author_LastName='$LastAuthor'   LIMIT 1";
            $query_Author = mysqli_query($conn, $Author_check_query);
            $result_Author = mysqli_fetch_assoc($query_Author);
            if ($result_Author) { // if user exists
               
                    $Author_ID=$result_Author['Author_ID'];
                }
            else{ 
                $insert_author = "INSERT INTO author(Author_Name,Author_LastName) VALUES ('$Author','$LastAuthor')";
                mysqli_query($conn, $insert_author);
                $Author_check_query2 = "SELECT * FROM author WHERE Author_Name = '$Author'AND Author_LastName='$LastAuthor'   LIMIT 1";
                $query_Author2 = mysqli_query($conn, $Author_check_query2);
                $result_Author2 = mysqli_fetch_assoc($query_Author2);
                if ($result_Author2) { // if user exists
               
                    $Author_ID=$result_Author2['Author_ID'];
                }

            }
        
    
                    $publisher_check_query = "SELECT * FROM publisher WHERE Publisher_Name = '$Publish'  LIMIT 1";
                    $query_publisher = mysqli_query($conn, $publisher_check_query);
                    $result_publisher = mysqli_fetch_assoc($query_publisher);
                    if ($result_publisher) { // if user exists
                        if ($result_publisher['Publisher_Name'] == $Publish) {
                            $Publish_ID=$result_publisher['Publisher_ID'];
                        }
                        else{
                            $insert_publisher = "INSERT INTO publisher(Publisher_Name) VALUES ('$Publish')";
                            mysqli_query($conn, $insert_publisher);
                        
                        if ($insert_publisher['Publisher_Name'] == $Publish) {
                            $Publish_ID=$insert_publisher['Publisher_ID'];
                        }
                    }
                }
                    }
    
                $select_stmt ="SELECT * FROM book WHERE Book_ISBN = '$id'"; 
                $query_ITEM = mysqli_query($conn, $select_stmt);
                $row = mysqli_fetch_array($query_ITEM);
                $update_stmt = "UPDATE book SET Book_Name = '$name', image = '$image_file',Book_Weight=$Weight,Book_Price=$Price
                ,Book_Quantity=$Quantity,Book_PublishNumber=$PublishNumber,Book_PublishYear=$PublishYear,Publisher_ID=$Publish_ID
                ,Catagory_ID=$Catagory_ID,Author_ID=$Author_ID
                 WHERE Book_ISBN = '$id'";
                $query_ITEM = mysqli_query($conn, $update_stmt);
                
                if ($update_stmt) {
                    echo "<script>alert('Record Inserted Successfully!');</script>";
                    echo "<script>window.location.href='admin.php'</script>";
                } else {
                    echo "<script>alert('Something went wrong! Please try again!');</script>";
                    echo "<script>window.location.href='admin.php'</script>";
                }
            
                
            }
            
        
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SE-AD Edit Book</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
    <link  rel="stylesheet" href="styleadmin.css">

    

</head>
<body>

<?php require 'Se_ed_header.php';?>


<div class="container-text-center">
        <h1>เเก้ไขข้อมูลหนังสือ</h1>
        
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
        <div class="form-group">
            <div class="input-group">
                <div class="row">
                <div class="col-sm-9">
                    <label for="name" class="col-sm-3-control-label" >ชื่อหนังสือ</label>
                    <input type="text" name="txt_name" class="form-control" placeholder="Enter name"value="<?php echo $row['Book_Name']; ?>" required>
                </div>
                <div class="col-sm-9">
                    <label for="Weight" class="col-sm-3-control-label" >นํ้าหนักหนังสือ</label>
                    <input type="text" name="txt_Weight" class="form-control" placeholder="Enter Weight"value="<?php echo $row['Book_Weight']; ?>" required>
                </div>
                <div class="col-sm-9">
                    <label for="Price" class="col-sm-3-control-label" >ราคาหนังสือ</label>
                    <input type="text" name="txt_Price" class="form-control" placeholder="Enter Price"value="<?php echo $row['Book_Price']; ?>" required>
                </div>
                <div class="col-sm-9">
                    <label for="Quantity" class="col-sm-3-control-label" >จำนวนหนังสือ</label>
                    <input type="text" name="txt_Quantity" class="form-control" placeholder="Enter Quantity"value="<?php echo $row['Book_Quantity']; ?>" required>
                </div>
                <div class="col-sm-9">
                    <label for="Publish" class="col-sm-3-control-label" >สำนักพิมพ์</label>
                    <input type="text" name="txt_Publish" class="form-control" placeholder="Enter Publish"value="<?php echo $row['Publisher_Name']; ?>" required>
                </div>
                <div class="col-sm-9">
                    <label for="PublishNumber" class="col-sm-3-control-label" >จำนวนครั้งที่ตีพิมพ์หนังสือ</label>
                    <input type="text" name="txt_PublishNumber" class="form-control" placeholder="Enter PublishNumber"value="<?php echo $row['Book_PublishNumber']; ?>" required>
                </div>
                <div class="col-sm-9">
                    <label for="PublishYear" class="col-sm-3-control-label">ปีที่ตีพิมพ์หนังสือ</label>
                    <input type="text" name="txt_PublishYear" class="form-control" placeholder="Enter PublishYear"value="<?php echo $row['Book_PublishYear']; ?>" required>
                </div>
                <div class="col-sm-9">
                    <label for="Catagory" class="col-sm-3-control-label">หมวดหนังสือ</label>
                    <select name="txt_Catagory" class="form-control">
                    <?php 
                    
                    while ($result_catagory = mysqli_fetch_assoc($query_catagory)) {
                ?>
                    <option value="<?php echo $result_catagory['Catagory_Name']; ?>"><?php echo $result_catagory['Catagory_Name']; ?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="col-sm-9">
                    <label for="Author" class="col-sm-3-control-label" >ผู้เเต่ง</label>
                    <input type="text" name="txt_Author" class="form-control" placeholder="Enter Author"value="<?php echo $row['Author_Name']; ?>" required>
                    <input type="text" name="txt_AuthorLast" class="form-control" placeholder="Enter LastName"value="<?php echo $row['Author_LastName']; ?>">
                </div>
            </div>
        </div>

        <div class="button-group">
            <br>
            <div class="row">
                <label for="name" class="col-sm-3-control-label" style="font-size:15px">รูปตัวอย่างหนังสือ</label>
                <div class="col-sm-9">
                    <input type="file" name="txt_file" class="form-control" value="<?php echo $image; ?>">
                    <p>
                        <img src="upload/<?php echo $image; ?>" height="100" width="100" alt="">
                    </p>
                </div>
            </div>
        </div>
        
            
        <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
        <a href="admin.php" class="btn btn-danger">Cancel</a>
            
        
    </form>
    </div>

    
</body>
</html>