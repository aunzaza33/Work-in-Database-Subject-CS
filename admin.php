
<?php 
    session_start();
    include('server.php'); 


    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username1']);
        header('location: index0.php');
    }
      if (!isset($_SESSION['username1'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];
        $select_stmt = "SELECT * FROM book WHERE Book_ISBN = '$id'";
        $query_ITEM = mysqli_query($conn, $select_stmt);
        $row = mysqli_fetch_array($query_ITEM);
        unlink("upload/".$row['image']); // unlin functoin permanently remove your file

        // delete an original record from db
        $delete_stmt ="DELETE FROM book WHERE Book_ISBN = '$id'";
        mysqli_query($conn, $delete_stmt);
        header("Location: admin.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome SE-ED Admin</title>
    <link  rel="stylesheet" href="stylemin.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php 
        require 'Se_ed_header.php';
        require 'admin_tab.php';
    ?>

    </body>
</html>