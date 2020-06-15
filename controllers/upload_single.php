<?php

if( empty($_FILES['input-file']['name'])){
	// checking if the file is selected or not
	
	$file_name = $_FILES['input-file']['name'];
	$file_tmp = $_FILES['input-file']['tmp_name'];
	$file_size = $_FILES['input-file']['size'];
	$file_error = $_FILES['input-file']['error'];
	$file_type = $_FILES['input-file']['type'];
	$file_ext = explode('.', $file_name);
	$file_act_ext = strtolower(end($file_ext));
	$allowed = ['jpg'];
	$path = 'C:/images/';

	if( !in_array($file_act_ext, $allowed) )
		return 'Only .jpg Files Are Allowed!';

	if( $file_error != 0 )
		return 'Image Size Should Be Be Than 2mb.';

	if( $file_size > 2000000 )
		return 'Image Size Should Be Be Than 2mb.';

	$new_file_name = $name . $file_act_ext;
	$file_des = $path .'/'. $new_file_name;

	$move = move_uploaded_file($file_tmp, $file_des);

	if (!$move) {
        return "Sorry Failed To Upload Image!" ; 
    }
    else { 
		$image_name = [$new_file_name];
		return $image_name; 
	}
}


	
?>