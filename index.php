<?php 
//connect to the database
require('includes/db-config.php'); 
include_once('includes/functions.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Image App Home Page</title>
</head>
<body>
	<header class="header">
		<h1>Image App</h1>
	</header>
	<main class="content">
		<?php 
		//write a query to get all published posts, newest first 
		$query = "SELECT title, body, image, date
					FROM posts
					WHERE is_published = 1
					ORDER BY date DESC
					LIMIT 20";
		//run it
		$result =  $db->query($query);
		//check to see if rows were found
		if( $result->num_rows >= 1  ):
			//loop through each row
			while( $row = $result->fetch_assoc() ):
		?>
		<article>
			<h2>USERNAME</h2>
			<img src="<?php echo $row['image']; ?>">

			<div class="post-info">
				<h3><?php echo $row['title']; ?></h3>
				<p><?php echo $row['body']; ?></p>
				<span class="date"><?php echo convert_date($row['date']); ?></span>
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
	<aside class="sidebar">
		<?php 
		//get all the users, most recently joined first
		$query = "SELECT profile_pic, username, user_id
					FROM users
					ORDER BY join_date DESC
					LIMIT 5";
		//run it
		$result = $db->query($query);
		//check it - did the query work?
		if(!$result):
			echo $db->error;
		endif;
		//check it - at least one row found?
		if( $result->num_rows >= 1 ):	
		 ?>
		<section>
			<h2>Newest Users</h2>

			<?php 
			//loop it
			while( $row = $result->fetch_assoc() ): 
			?>
			<a href="#" class="profile-pic small">
				<img src="<?php echo $row['profile_pic'] ?>" 
					alt="<?php echo $row['username'] ?>'s Profile" 
					width="80" height="80">
			</a>
			<?php 
			endwhile; 
			$result->free();
			?>
		</section>
		<?php 
		endif; //there are users ?>

		<?php 
		//get all the categories in alpha order
		$query = "SELECT * 
				FROM categories 
				ORDER BY name ASC";
		//run it
		$result = $db->query($query);
		//check it - did the query work?
		if(!$result):
			echo $db->error;
		endif;
		//check it - at least one row found?
		if( $result->num_rows >= 1 ):	
		?>
		<section>
			<h2>Categories</h2>

			<ul>
				<?php 
				//loop it
				while( $row = $result->fetch_assoc() ): 
				?>
				<li><a href="#"><?php echo $row['name']; ?></a></li>
				<?php 
				endwhile; 
				$result->free();
				?>
		</ul>
		</section>
		<?php 
		endif; //there are users 

		//get all the tags in alpha order
		$query = "SELECT * 
				FROM tags
				ORDER BY name ASC";
		//run it
		$result = $db->query($query);
		//check it - did the query work?
		if(!$result):
			echo $db->error;
		endif;
		//check it - at least one row found?
		if( $result->num_rows >= 1 ):	
		?>
		<section>
			<h2>Tags</h2>

			<ul>
				<?php 
				//loop it
				while( $row = $result->fetch_assoc() ): 
				?>
				<li><a href="#"><?php echo $row['name']; ?></a></li>
				<?php 
				endwhile; 
				$result->free();
				?>
		</ul>
		</section>
		<?php 
		endif; //there are users ?>
	</aside>
	<footer class="footer">
		&copy;2017 Your Name Here
	</footer>

</body>
</html>
<?php $db->close(); ?>