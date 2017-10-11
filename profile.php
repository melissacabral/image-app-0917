<?php require('includes/header.php'); 

//query string will be ?user_id=X
$user_id = $_GET['user_id'];
?>

<main class="content grid">
	<?php //get all the info about THIS user, and also get any posts if they have some
	$query = "SELECT users.username, users.bio, users.profile_pic, posts.image, 
			posts.title, posts.post_id
			FROM users
			LEFT JOIN posts
			ON (users.user_id = posts.user_id)
			WHERE users.user_id = $user_id
			ORDER BY posts.date DESC
			LIMIT 20";
	$result = $db->query($query);
	if( !$result )
		echo $db->error;

	if( $result->num_rows >= 1 ):
		//we need a counter so we can tell what iteration of the loop we are on
		$counter = 1;
		while( $row = $result->fetch_assoc() ):
			//are we showing the first row?
			if( $counter == 1 ):
	 ?>
	<div class="full-column">
		<?php display_user_image( $user_id , 100 ); ?>
		<h2><?php echo $row['username']; ?></h2>
		<p><?php echo $row['bio']; ?></p>
	</div>

	<?php 
				if( $row['post_id'] ): ?>
	<article class="full-column">
		<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
			<?php display_post_image( $row['post_id'], 'large' ); ?>
			<h3><?php echo $row['title']; ?></h3>
		</a>
	</article>
	
	<?php 
				else:
					echo '<h3>This user hasn\'t made any posts</h3>';
				endif;
			else:
				//not the first row
	?>

	<article>
		<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
			<?php display_post_image( $row['post_id'], 'thumb' ); ?>
			<h3><?php echo $row['title']; ?></h3>
		</a>
	</article>

	<?php 
			endif;

			//increase the counter
			$counter ++;
		endwhile;
	else: //no user found 
	?>
		<h1>Invalid User</h1>
	<?php 
	endif; 
	?>
	
</main>

<?php require('includes/sidebar.php'); ?>
<?php require('includes/footer.php'); ?>

