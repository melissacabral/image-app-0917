<?php 
/**
 * Convert any DATETIME to a human readable date
 * @param   $timestamp string - any date/time stamp
 * @return  string. A nicely formatted date
 */
function convert_date( $timestamp ){
	$date = new DateTime( $timestamp );
	echo $date->format('F j, Y');
}


/**
 * Convert any DATETIME to RFC-822 for the RSS feed
 * @param   $timestamp string - any date/time stamp
 * @return  string. A nicely formatted date
 */
function convert_date_rss( $timestamp ){
	$date = new DateTime( $timestamp );
	echo $date->format('r');
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

/**
 * Form Field Sanitizing Functions
 */
function clean_string( $dirty ){
	global $db;
	//strip the tags
	$clean = filter_var($dirty, FILTER_SANITIZE_STRING);
	//prep for DB
	$clean = mysqli_real_escape_string($db, $clean);

	return $clean;
}

function clean_int( $dirty ){
	global $db;
	//strip the tags
	$clean = filter_var($dirty, FILTER_SANITIZE_NUMBER_INT);
	//prep for DB
	$clean = mysqli_real_escape_string($db, $clean);

	return $clean;
}

//no close php