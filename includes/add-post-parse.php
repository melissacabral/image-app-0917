<?php 
if($_POST['did_add_post']):
	
	//file uploading stuff begins
	
	$target_path = "uploads/";
	
	//list of image sizes to generate. make sure a column name in your DB matches up with a key for each size
	$sizes = array(
		'thumb' => 100,
		'medium' => 200,
		'large' => 400,
	);	
		
	// get the name of the file that was uploaded
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];

	// Capture the original size of the uploaded image
	list($width,$height) = getimagesize($uploadedfile);
	
	//make sure the width and height exist, otherwise, this is not a valid image
	if($width > 0 AND $height > 0){
	
	//what kind of image is it
	$filetype = $_FILES['uploadedfile']['type'];
	
	switch($filetype){
		case 'image/gif':
			// Create an Image from it so we can do the resize
			$src = imagecreatefromgif($uploadedfile);
		break;
		
		case 'image/pjpeg':
		case 'image/jpg':
		case 'image/jpeg': 
			// Create an Image from it so we can do the resize
			$src = imagecreatefromjpeg($uploadedfile);
		break;
	
		case 'image/png':
			// // Create an Image from it so we can do the resize
			// TODO: debug this
			// $required_memory = round($width * $height * $size['bits']);
			// $new_limit=memory_get_usage() + $required_memory;
			// ini_set("memory_limit", $new_limit);
			// $src = imagecreatefrompng($uploadedfile);
			// ini_restore ("memory_limit");
		break;
		
			
	}
	//for filename
	$randomsha = sha1(microtime());
	
	//do it!  resize images
	foreach($sizes as $size_name => $size){
		
		/*SQUARE CROP CALCULATIONS*/
		if ($width > $height) {
			$crop_y = 0;
			$crop_x = ($width - $height) / 2;
			$smallestSide = $height;
		} else {
			$crop_x = 0;
			$crop_y = ($height - $width) / 2;
			$smallestSide = $width;
		}
		//resize the image - make a new blank canvas of the desired size
		$tmp_canvas = imagecreatetruecolor($size, $size);
		//copy the original image onto this canvas and resize
		imagecopyresampled($tmp_canvas, $src, 0, 0, $crop_x, $crop_y, $size, $size, $smallestSide, $smallestSide);

		$filename = $target_path.$randomsha.'_'.$size_name.'.jpg';

		$didcreate = imagejpeg($tmp_canvas,$filename,70);
		imagedestroy($tmp_canvas);
				
	}
	
	imagedestroy($src);
	
		
	}else{//width and height not greater than 0
		$didcreate = false;
	}
	
	

	if($didcreate) {
		//it worked - the file was saved
		$feedback .=  "The file ".  basename( $_FILES['uploadedfile']['name']). 
		" has been uploaded <br />";

		//store this image as a post draft
		$user_id = $logged_in_user['user_id'];
		$query = "INSERT INTO posts
				( image, date, user_id, is_published )
				VALUES
				( '$randomsha', now(), $user_id, 0 )";
		$result = $db->query($query);
		if( !$result )
			$feedback .= 'Bad insert query';

		if( $db->affected_rows == 1 ){
			//successfully added to DB - go to step 2
			$post_id = $db->insert_id;
			header("Location:edit-post.php?post_id=$post_id");
		}else{
			//nothing added to DB
			$feedback .= 'DB FAILED.';
		}		

	} else{
		//it didn't save the file
		$feedback .= "There was an error uploading the file, please try again!<br />";
	}		



endif;