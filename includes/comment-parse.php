<?php 
//if they submitted the form, try to add the comment

if( $_POST['did_comment'] ):
	//extract and sanitize all data
	$body = clean_string($_POST['body']);
	$post_id = clean_int($_GET['post_id']);
	//who is logged in?
	$user_id = $logged_in_user['user_id'];


	//validate
	$valid = true;

	//body is blank
	if( $body == '' ):
		$valid = false;
	endif;

	//post_id not a number
	if( ! is_numeric($post_id) ):
		$valid = false;
	endif;

	//check for duplicate comment
	$query = "SELECT comment_id 
				FROM comments
				WHERE post_id = $post_id
				AND user_id = $user_id
				AND body = '$body'
				LIMIT 1";
	$result = $db->query($query);
	//if one row found, this is a duplicate comment
	if($result->num_rows == 1):
		$valid = false;
	endif;
	
	//if valid, add the comment to the DB
	//TODO: is_approved is set to 1 here for convenience. maybe change this in the future
	if( $valid ):
		$query = "INSERT INTO comments
					( body, date, user_id, post_id, is_approved )
					VALUES 
					( '$body', now(), $user_id, $post_id, 1 )";
		//run it
		$result = $db->query($query);	
		//check it
		if( !$result ):
			echo $db->error;
		endif;

		//user feedback
		if( $db->affected_rows == 1 ):
			//success
			$message = 'Thank you for your comment';
		else:
			//error
			$message = 'Sorry, your comment could not be saved.';
		endif;

	endif; //valid
		
endif; //end of parser
//no close PHP