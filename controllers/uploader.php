<?php
class Uploader {
  
  public function sendImg() 
  {
    $target_dir = "../uploads/images/";
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
  }


  public function sendFile()
  {
    echo "send non image file";
  }
}
?>

