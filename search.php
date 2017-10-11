<?php require('includes/header.php');

//search configuration
$per_page = 2;

//get the phrase the user typed in, and clean it
$phrase = clean_string( $_GET['phrase'] );

?>
<main class="content grid">
	<?php 
	//look it up in the DB if the phrase is not blank
	if( $phrase != '' ):
		$query = "SELECT users.username, posts.title, posts.image, posts.post_id, 
					posts.date
					FROM users, posts
					WHERE users.user_id = posts.user_id
					AND posts.is_published = 1
					AND ( posts.title LIKE '%$phrase%'
						OR
						posts.body LIKE '%$phrase%' )
					ORDER BY posts.date DESC";
		$result = $db->query($query);

		//check it
		if( !$result ):
			echo $db->error;
		endif;

		$total = $result->num_rows;

		//figure out how many total pages are needed
		$max_page = ceil( $total / $per_page );

		//what page are we trying to show?
		//Query string will be like: ?phrase=bla&page=2 
		//unless we are on the first page
		if( $_GET['page'] ):
			$current_page = $_GET['page'];
		else:
			$current_page = 1;
		endif;

		//check if the current page is out of bounds
		if( $current_page > $max_page ):
			//show the last page
			$current_page = $max_page;
		endif;
	?>

	<section class="search-header full-column">
		<h1>Search Results for <?php echo $phrase; ?></h1>
		<h2><?php echo $total; ?> posts found</h2>
		<h3>Showing page <?php echo $current_page;?> of <?php echo $max_page; ?></h3>
	</section>

	<?php 
		if( $total >= 1 ): 

			//add a LIMIT to the original query
			$offset = ($current_page - 1) * $per_page;
			$query .= " LIMIT $offset, $per_page";

			//run the query again
			$result = $db->query($query);

			while( $row = $result->fetch_assoc() ): ?>
	<article class="medium-post">
		<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
			<?php display_post_image( $row['post_id'] ); ?>
		</a>
		<h2><?php echo $row['username']; ?></h2>
		<h3><?php echo $row['title']; ?></h3>
		<span class="date"><?php convert_date( $row['date'] ); ?></span>
		<span class="comment-count"><?php count_comments( $row['post_id'] ); ?></span>
	</article>
	<?php endwhile;	?>

	<section class="pagination full-column">
		<?php 
		$prev_page = $current_page - 1;
		$next_page = $current_page + 1;
		
		if( $current_page != 1 ):
		?>
		<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php 
				echo $prev_page ?>">🡰 Previous Page</a>

		<?php 
		endif; 

		//numbered pagination
		for( $i = 1 ; $i <= $max_page; $i++ ){
		?>
<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $i; ?>">
	<?php echo $i; ?>
</a>
		<?php 
		} //end for loop

		if( $current_page < $max_page ):
		?>
		<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php 
				echo $next_page ?>">Next Page 🡲</a>
		<?php 
		endif;
		 ?>
	</section>

	<?php
		endif; //there are posts to show
	else:
		echo 'Search field cannot be blank';
	endif; ?>
</main>

<?php require('includes/sidebar.php'); ?>
<?php require('includes/footer.php'); ?>