<?php 
/**
 * Convert any DATETIME to a human readable date
 * @param   $timestamp string - any date/time stamp
 * @return  string. A nicely formatted date
 */
function convert_date( $timestamp ){
	$date = new DateTime( $timestamp );
	return $date->format('F j, Y');
}

/**
 * Count the number of comments on any particular post
 * @param $post_id int any valid post_id
 * @return string Displays the number of comments with good grammar
 */
function count_comments( $post_id ){
	//access the database connection we made outside this function
	global $db;
	$query = "SELECT COUNT(*) AS total
				FROM comments
				WHERE post_id = $post_id";
	//run it
	$result = $db->query($query);
	//check it
	if( !$result ):
		echo $db->error;
	endif;
	if( $result->num_rows >= 1 ):
		//loop it
		while( $row = $result->fetch_assoc() ):
			echo $row['total'];

			if( $row['total'] == 1 ):
				echo ' Comment';
			else:
				echo ' Comments';
			endif;
		endwhile;
	endif;
}

//no close php