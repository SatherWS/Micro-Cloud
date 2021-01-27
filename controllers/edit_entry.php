<?php
include_once '../config/database.php';

$database = new Database();
$curs = $database->getConnection();
header("Access-Control-Allow-Origin: *");

if ($curs->connect_error) {
    die("Connection failed: " . $curs->connect_error);
}

/* 
*   Article editing section 
*/

// update an article according to the changes made in the details form
if (isset($_POST['edit'])) 
{
    $sql = "update journal set message = ?, subject = ? where id = ?";
    mysqli_query($curs, $sql);
    $stmnt = mysqli_prepare($curs, $sql);
    $journal_edit = $_POST['edited'];
    $stmnt -> bind_param("sss", $journal_edit, $_POST['jsubs'], $_POST['edit']);
    $stmnt -> execute();
    header("Location: ../views/journal-details.php?journal=".$_POST['edit']);
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

if (isset($_POST['mod-task'])) 
{
  $id = $_POST['mod-task'];
  $sql = "update todo_list set title=?, description=?, date_created=?, deadline=?, importance=?, status=?, assignee=?, creator=? where id=?";
  mysqli_query($curs, $sql);
  $stmnt = mysqli_prepare($curs, $sql);
  $stmnt -> bind_param("sssssssss", $_POST["title"], $_POST["description"], $_POST["start-date"], $_POST["end-date"], $_POST["importance"], $_POST['change-status'], $_POST["change-assignee"], $_POST["change-creator"], $id);
  $stmnt -> execute();
  header("Location: ../views/task-details.php?task=".$id);
}

/*
*   File upload for images in articles section
*
*   TODO: move file upload code that is below this comment to a separate file
*/

// send an image to the server
if (isset($_POST["img-upload"])) 
{
    $journalnum = $_POST["article_assoc"];
    $target_dir = "../uploads/images/$journalnum/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir);
        chmod($target_dir, 0777);
    }
    $target_file = $target_dir . basename($_FILES["imageToUpload"]["name"]);
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $file_name = pathinfo($target_file,PATHINFO_FILENAME);
    $file_type = pathinfo($target_file,PATHINFO_EXTENSION);
    $file_class = "image";

    // Check if image file is a actual image or fake image
    if (isset($_POST["imageToUpload"])) {
      $check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
      if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } 
      else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["imageToUpload"]["size"] > 50000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } 
    else {
      if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["imageToUpload"]["name"])). " has been uploaded.";

        // append to the associated article
        $md_img = " <br> ![uploaded image]($target_file)";
        $sql = "update journal set message = CONCAT(message, ?) where id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $md_img, $journalnum);
        $stmnt -> execute();

        // add the image path to file storage paths
        $sql = "insert into file_storage(file_name, file_type, file_path, article_id, file_class) values(?, ?, ?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sssss", $file_name, $file_type, $target_file, $journalnum, $file_class);
        $stmnt -> execute();
        
        header("Location: ../views/journal-details.php?journal=$journalnum");
      } 
      else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
}


// Attach a file thats not an image 
if (isset($_POST["file-upload"])) 
{
  $journalnum = $_POST["article_assoc"];
  $target_dir = "../uploads/files/$journalnum/";

  if (!is_dir($target_dir)) {
    mkdir($target_dir);
    chmod($target_dir, 0777);
  }
  
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  
  $dataFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $file_name = pathinfo($target_file,PATHINFO_FILENAME);
  $file_type = pathinfo($target_file,PATHINFO_EXTENSION);
  $file_class = "file";

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if ($dataFileType != "docx" && $dataFileType != "doc" && $dataFileType != "pdf"
  && $dataFileType != "txt" && $dataFileType != "xlsx" && $dataFileType != "xlsm" && $dataFileType != "zip") {
    echo "Sorry, only DOCX, DOC, PDF & TXT files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } 
  else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      
      $sql = "insert into file_storage(file_name, file_type, file_path, article_id, file_class) values(?, ?, ?, ?, ?)";
      $stmnt = mysqli_prepare($curs, $sql);
      $stmnt -> bind_param("sssss", $file_name, $file_type, $target_file, $journalnum, $file_class);
      $stmnt -> execute();
      
      header("Location: ../views/journal-details.php?journal=$journalnum");
    } 
    else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
$curs -> close();
?>
