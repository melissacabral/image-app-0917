<?php
//Display output for the likes interface
require('../includes/db-config.php');
require_once('../includes/functions.php');


//extract the data from the ajax request
$user_id = $_GET['user_id'];
$post_id = $_GET['post_id'];

//check to see if the user already likes this post
$query = "SELECT * FROM likes
		WHERE user_id =  $user_id
		AND post_id = $post_id
		LIMIT 1";
$result = $db->query($query);

if(!$result)
	die($db->error);

if($result->num_rows == 1){
	//THE USER ALREADY LIKES THIS. UN-LIKE IT!
	$query = "DELETE FROM likes
				WHERE post_id = $post_id
				AND user_id = $user_id
				LIMIT 1";
	
}else{
	//THE USER IS TRYING TO "LIKE" THIS POST
	$query = "INSERT INTO likes
				( post_id, user_id )
				VALUES 
				( $post_id, $user_id )";
}



$result = $db->query($query);
//check if it worked. One row will be deleted or added (affected)
if( $db->affected_rows >= 1 ){
	likes_interface($post_id, $user_id);
}else{
	echo 'nope';
}

