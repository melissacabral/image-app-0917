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
			<a href="profile.php?user_id=<?php echo $row['user_id']; ?>" class="profile-pic small">
				<?php display_user_image( $row['user_id'], 30 ); ?>
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
		$query = "SELECT categories.*, COUNT(*) AS total
					FROM categories, posts
					WHERE categories.category_id = posts.category_id
					GROUP BY posts.category_id
					ORDER BY categories.name ASC
					LIMIT 10";
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
				<li>
					<a href="#"><?php echo $row['name']; ?></a>
					<?php 
					echo $row['total'];

					if( $row['total'] > 1 ):
						echo ' posts';
					else:
						echo ' post';
					endif;
					?> 
				</li>
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