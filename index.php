<?php require('includes/header.php'); ?>

	<main class="content">
		<?php 
		//write a query to get all published posts, newest first 
		$query = "SELECT posts.post_id, posts.title, posts.body, posts.image, 
						posts.date, users.username,users.profile_pic,  categories.name
					FROM posts, users, categories
					WHERE posts.is_published = 1
					AND posts.user_id = users.user_id
					AND posts.category_id = categories.category_id
					ORDER BY posts.date DESC
					LIMIT 20";
		//run it
		$result =  $db->query($query);
		//check to see if rows were found
		if( $result->num_rows >= 1  ):
			//loop through each row
			while( $row = $result->fetch_assoc() ):
		?>
		<article>
			<h2 class="profile-pic">
			<img  src="<?php echo $row['profile_pic']; ?>" width="80" height="80">
			<?php echo $row['username']; ?>
		</h2>
			<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
				<?php display_post_image( $row['post_id'], 'large' ); ?>
			</a>

			<div class="post-info">
				<h3><?php echo $row['title']; ?></h3>
				<h4>Category: <?php echo $row['name'] ?></h4>
				<p><?php echo $row['body']; ?></p>
				<span class="date"><?php convert_date($row['date']); ?></span>
				<span class="comment-count"><?php count_comments( $row['post_id'] ); ?></span>
			</div>
		</article>

		<?php
			endwhile;//there are posts to show
			$result->free();
		else:
			echo 'Sorry, no posts to show'; 
		endif; //there are rows 
		?>
		
	</main>
	
<?php require('includes/sidebar.php'); ?>	
<?php require('includes/footer.php'); ?>