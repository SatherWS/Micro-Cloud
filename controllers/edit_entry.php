<?php
include_once '../config/database.php';
include '../controllers/uploader.php';
$database = new Database();
$curs = $database->getConnection();

if ($curs->connect_error) {
    die("Connection failed: " . $curs->connect_error);
}

/* 
*   Article editing section 
*/

// update an article according to the changes made in the details form
if (isset($_POST['edit'])) {
    $sql = "update journal set message = ?, subject = ? where id = ?";
    mysqli_query($curs, $sql);
    $stmnt = mysqli_prepare($curs, $sql);
    $journal_edit = $_POST['edited'];
    $stmnt -> bind_param("sss", $journal_edit, $_POST['jsubs'], $_POST['edit']);
    $stmnt -> execute();
    header("Location: ../views/journal-details.php?journal=".$_POST['edit']);
}

// send image to server
if (isset($_POST["img-upload"])) {
    $target_dir = "/uploads/images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if (isset($_POST["img-upload"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } 
      else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }
    header("Location: ../$uploadOk+$target_dir+$target_file");
}

if (isset($_POST["file-upload"])) {
    $msg = "File upload was clicked";
    header("Location: ./test.php?msg=$msg");
}

if (isset($_POST['delete'])) {
    $sql = "delete from todo_list where id = ?";
    mysqli_query($curs, $sql);
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_POST['delete']);
    $stmnt -> execute();
    header("Location: ../views/show-tasks.php");
}

/* 
*   Main Tasks & Sub Task Editing Section 
*/

if (isset($_POST['mod-task'])) {
    $id = $_POST['mod-task'];
    $sql = "update todo_list set title=?, description=?, date_created=?, deadline=?, importance=?, status=?, assignee=?, creator=? where id=?";
    mysqli_query($curs, $sql);
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("sssssssss", $_POST["title"], $_POST["description"], $_POST["start-date"], $_POST["end-date"], $_POST["importance"], $_POST['change-status'], $_POST["change-assignee"], $_POST["change-creator"], $id);
    $stmnt -> execute();
    header("Location: ../views/task-details.php?task=".$id);
}
$curs -> close();
?>
