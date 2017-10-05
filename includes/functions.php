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

/**
 * Display Feedback generated by a form parser
 * @param  string $message  The success or error message
 * @param  array $problems list of errors
 * @return string           HTML for the feedback
 */
function form_errors( $message, $problems ){
	if( $message != '' ):
	?>
	<div class="feedback">
		<p><?php echo $message ?></p>

		<?php if( !empty($problems) ): ?>
		<ul>
			<?php foreach( $problems as $problem ): ?>

				<li><?php echo $problem; ?></li>

			<?php endforeach; ?>
		</ul>
		<?php endif; //there are problems ?>

	</div>
	<?php
	endif;
}

/**
 * Check to see if a user is logged in and get all the info about them
 * 
 */
function check_login(){
	global $db;
	//check for the expected session data
	if( isset($_SESSION['secret_key']) AND isset($_SESSION['user_id']) ):
		//check for a match in the DB
		$sess_user_id = $_SESSION['user_id'];
		$sess_secret_key = $_SESSION['secret_key'];

		$query = "SELECT * 
				FROM users
				WHERE user_id = $sess_user_id
				AND secret_key = '$sess_secret_key'
				LIMIT 1";
		$result = $db->query($query);
		if( !$result )
			return false;
		if( $result->num_rows == 1 ):
			//SUCCESS. user is logged in. return the array of all the user's data
			return $result->fetch_assoc();
		else:
			return false;
		endif;
	else:
		//no session data. not logged in
		return false;
	endif;
}
//no close php