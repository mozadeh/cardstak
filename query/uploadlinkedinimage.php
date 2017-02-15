<?php
require_once('../config.php');
require("../common.php"); 

$thumb_square_size 		= 350; //Thumbnails will be cropped to 200x200 pixels
$max_image_size 		= 500; //Maximum image size (height and width)
$thumb_prefix			= "thumb_"; //Normal thumb Prefix
$destination_folder		= 'uploads/'; //upload directory ends with / (slash)
$jpeg_quality 			= 100; //jpeg quality


$photoname2 = $_POST['photoid1'];
$photourl2 = $_POST['photourl1'];


if (isset($_POST['photourl1'])) {
	//echo 	$photoname2." photourl= ".$photourl2;
	//move_uploaded_file($photourl2, 'uploads/'.$photoname2);
	
	
	$img = file_get_contents($photourl2);
	
	
	$image_size_info = getimagesize($photourl2); //get image size
	
	if($image_size_info){
		$image_width 		= $image_size_info[0]; //image width
		$image_height 		= $image_size_info[1]; //image height
		$image_type 		= $image_size_info['mime']; //image type
	}else{
		die("Make sure image file is valid!");
	}
	
	$image_res =  imagecreatefromstring($img);
	

	//switch statement below checks allowed image type 
	//as well as creates new image from given file 
	switch($image_type){
		case 'image/png':
			$image_t =  'png'; break;
		case 'image/gif':
			$image_t =  'gif'; break;			
		case 'image/jpeg': case 'image/pjpeg':
			$image_t =  'jpeg'; break;
		default:
			$image_res = false;
	}
	
	
	
	
	
	if($image_res){
		

		$destination_folder='../uploads/';
		//create a random name for new image (Eg: fileName_293749.jpg) ;
		$new_file_name = $photoname2. '_' .  rand(0, 9999999999) . '.' . $image_t;
		
		//folder path to save resized images and thumbnails
		$thumb_save_folder 	= $destination_folder . $new_file_name; 

		if(crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality))
		{
			echo $new_file_name;
		}
		else{
			die('Error Creating thumbnail');
		}
		
		imagedestroy($image_res); //freeup memory
	}
	
	
	

}
else {
echo "There was an error";
}





##### This function corps image to create exact square, no matter what its original size! ######
function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
	if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
	
	if( $image_width > $image_height )
	{
		$y_offset = 0;
		$x_offset = ($image_width - $image_height) / 2;
		$s_size 	= $image_width - ($x_offset * 2);
	}else{
		$x_offset = 0;
		$y_offset = ($image_height - $image_width) / 2;
		$s_size = $image_height - ($y_offset * 2);
	}
	$new_canvas	= imagecreatetruecolor( $square_size, $square_size); //Create a new true color image
	
	//Copy and resize part of an image with resampling
	if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
		save_image($new_canvas, $destination, $image_type, $quality);
	}

	return true;
}

##### Saves image resource to file ##### 
function save_image($source, $destination, $image_type, $quality){
	switch(strtolower($image_type)){//determine mime type
		case 'image/png': 
			imagepng($source, $destination); return true; //save png file
			break;
		case 'image/gif': 
			imagegif($source, $destination); return true; //save gif file
			break;          
		case 'image/jpeg': case 'image/pjpeg': 
			imagejpeg($source, $destination, $quality); return true; //save jpeg file
			break;
		default: return false;
	}
}



?>