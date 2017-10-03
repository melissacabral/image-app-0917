<?php 
/*
Display output
This file stays on the server and has no doctype/page structure
it runs the query to get all the posts in a category
and gives back the HTML content for the posts 
*/
require('../includes/db-config.php');
include_once('../includes/functions.php');

//get rid of this when done....
//adding this to simulate a slow connection
sleep(5); //puts server to sleep for 5 seconds!!!!

//the category ID that the user clicked from the interface file
$category_id = $_REQUEST['catid'];

//query to get all the published posts in a given category:

$query = "SELECT posts.*, categories.name
FROM posts, categories
WHERE posts.category_id = categories.category_id
AND posts.category_id = $category_id
AND posts.is_published = 1
ORDER BY date DESC
LIMIT 10";

$result = $db->query($query);

if(! $result ):
	die($db->error);
endif;	

if($result->num_rows >= 1):
	while($row= $result->fetch_assoc()):
?>		
<article>
	<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
		<img src="<?php echo $row['image'] ?>" alt="<?php echo $row['title']; ?>">
	</a>
	<h2><?php echo $row['title']; ?></h2>
	<h3><?php echo $row['name']; ?></h3>
	<p><?php echo $row['body']; ?></p>
	<div class="post-info">
		<span class="date">
			<?php convert_date($row['date']); ?>
		</span>
		<span class="comment-count">
			<?php count_comments($row['post_id']); ?>			
		</span>
	</div>

</article>
<?php
	endwhile;
	$result->free();
else:
	echo 'No posts in this category';
endif;
 ?>