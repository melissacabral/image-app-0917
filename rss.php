<?php 
//connect DB
require('includes/db-config.php');
require_once('includes/functions.php');

//for compatibility because of <? characters
echo '<?xml version="1.0"?>'; ?>
<rss version="2.0">
	<channel>
		<title>Image App Public Posts</title>
		<link>http://localhost/melissa-php-0917/image-app-0917/</link>
		<description>Most recent images from the community</description>
		<?php 
		//get 10 most recent published posts
		$query = "SELECT posts.*, categories.*, users.username, users.email
					FROM posts, categories, users
					WHERE posts.category_id = categories.category_id
					AND posts.user_id = users.user_id
					AND posts.is_published = 1
					ORDER BY date DESC
					LIMIT 10";
		//run it
		$result = $db->query($query);
		//check it
		if( !$result ):
			echo $db->error;
		endif;

		if( $result->num_rows >= 1 ):
			//loop it
			while( $row = $result->fetch_assoc() ):
		 ?>
		<item>
			<title><?php echo $row['title']; ?></title>
			<link>http://localhost/melissa-php-0917/image-app-0917/single.php?post_id=<?php echo $row['post_id']; ?></link>
			<guid>http://localhost/melissa-php-0917/image-app-0917/single.php?post_id=<?php echo $row['post_id']; ?></guid>
			<author><?php echo $row['email'] ?> 
				(<?php echo $row['username'] ?>)</author>
			<pubDate><?php echo convert_date_rss($row['date']); ?></pubDate>
			<description><![CDATA[ 
				<?php display_post_image( $row['post_id'] ); ?>
				<h3>Category: <?php echo $row['name']; ?></h3>
				<p><?php echo $row['body']; ?></p>
			 ]]></description>
		</item>
		<?php 
			endwhile;
		endif; //there are posts ?>
	</channel>
</rss>