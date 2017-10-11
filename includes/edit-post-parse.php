<?php 
/**
 * This is a dual-function parser!
 * Step 2 of adding a post OR edit any post
 */
//which post are we editing?
$post_id = $_GET['post_id'];
//check for blank or invalid post id
if( ! is_numeric($post_id) ):
	die('Invalid Post');
else:
	//check that the post exists and the user can edit it AND get all the data 
	$user_id = $logged_in_user['user_id'];
	$query = "SELECT * FROM posts
				WHERE post_id = $post_id
				AND user_id = $user_id";
	$result = $db->query($query);
	if( !$result )
		die( $db->error );

	if( $result->num_rows >= 1 ):
		//YES. valid post
		$row = $result->fetch_assoc();

		//get the current values so we can show them in the form
		$title = $row['title'];
		$body = $row['body'];
		$category_id = $row['category_id'];
		$allow_comments = $row['allow_comments'];
	else:
		die('Not your post');
	endif;
endif;



if( $_POST['did_edit_post'] ):
	//clean all fields
	$post_id 		= clean_int($_GET['post_id']);
	$title 			= clean_string($_POST['title']);
	$body 			= clean_string($_POST['body']);
	$category_id 	= clean_int($_POST['category_id']);
	$allow_comments = clean_bool($_POST['allow_comments']);

	//validate
	$valid = true;
	
	//post ID must be a number
	if( ! is_numeric($post_id) ):
		$valid = false;
		$errors['post_id'] = 'Invalid post, go back to step 1.';
	endif;

	//title can't be blank
	if( $title == '' ):
		$valid = false;
		$errors['title'] = 'Please fill in the title of your post.';
	endif;

	//body cant be blank
	if( $body == '' ):
		$valid = false;
		$errors['body'] = 'Please give your post a body';
	endif;

	//category must be a number
	if( ! is_numeric($category_id) ):
		$valid = false;
		$errors['category_id'] = 'Invalid Category';
	endif;
	
	//if valid, update the post
	if( $valid ):
		$user_id = $logged_in_user['user_id'];
		$query = "UPDATE posts
					SET
					title = '$title',
					body = '$body',
					category_id = $category_id,
					is_published = 1,
					allow_comments = $allow_comments

					WHERE post_id = $post_id
					AND user_id = $user_id
					LIMIT 1	";
		$result = $db->query($query);
		if( !$result )
			echo $db->error;

		if( $db->affected_rows == 1 ):
			$feedback = 'Post successfuly saved!';
		else:
			$feedback = 'No changes were made to your post';
		endif;
	else:
		$feedback = "Your post could not be saved. Fix the following problems:";
	endif; //valid

endif;
