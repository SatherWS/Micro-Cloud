<?php

$count = count($_FILES['input-file']['name']);

for($i=0; $i<$count; $i++){
	
	$file_name = $_FILES['input-file']['name'][$i];
	$file_tmp = $_FILES['input-file']['tmp_name'][$i];
	$file_size = $_FILES['input-file']['size'][$i];
	$file_error = $_FILES['input-file']['error'][$i];
	$file_type = $_FILES['input-file']['type'][$i];
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

	if(!$move){
	 	return "Sorry Failed To Upload Image!" ; 
	}
}

?>