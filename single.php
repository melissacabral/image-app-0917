<?php 
error_reporting( E_ALL & ~E_NOTICE ); 
require('includes/header.php'); 
include('includes/comment-parse.php');

//which post are we trying to view?
//URL will be single.php?post_id=X
$post_id = $_GET['post_id'];
//Get the info about this post
$query = "SELECT posts.title, posts.date, posts.body, posts.image, users.username, 
				users.profile_pic, categories.*
			FROM posts, users, categories
			WHERE posts.user_id = users.user_id
			AND posts.category_id = categories.category_id
			AND posts.post_id = $post_id
			AND posts.is_published = 1
			LIMIT 1";
//run it
$result = $db->query($query);
//check it
if(!$result):
	echo $db->error;
endif;
?>

<main class="content">
	
	<?php 
	if( $result->num_rows == 1 ):
		//no need for "while" since there's only one post to show 
		$row = $result->fetch_assoc();
	?>
	<article>
		<img src="<?php echo $row['image']; ?>">
		<h2 class="profile-pic">
			<img  src="<?php echo $row['profile_pic']; ?>" width="80" height="80">
			<?php echo $row['username']; ?>
		</h2>
		<h3><?php echo $row['title']; ?></h3>
		<p><?php echo $row['body']; ?></p>

		<span class="date"><?php convert_date($row['date']); ?></span>
		<span class="comment-count"><?php count_comments( $post_id ); ?></span>
	</article>

	<?php //done showing the post, set the result free
	$result->free(); 

	//get all the approved comments on THIS post, Oldest comments first
	$query = "SELECT comments.body, comments.date, users.username, users.profile_pic
			FROM comments, users
			WHERE comments.user_id = users.user_id
			AND comments.is_approved = 1
			AND comments.post_id = $post_id
			ORDER BY comments.date ASC
			LIMIT 20";
	//run it
	$result = $db->query($query);
	//check it
	if( ! $result ):
		echo $db->error;
	endif;
	if( $result->num_rows >= 1 ):
	?>
	<section class="comments-list">
		<h2>Comments:</h2>
		<ul>
			<?php while( $row = $result->fetch_assoc() ): ?>
			<li>
				<h2>
					<img src="<?php echo $row['profile_pic']; ?>" width="80" height="80">
					<?php echo $row['username']; ?>
				</h2>
				<p><?php echo $row['body']; ?></p>
				<span class="date"><?php echo convert_date($row['date']); ?></span>
			</li>
			<?php endwhile; ?>
		</ul>
	</section>
	<?php 
	endif; //there are comments to show

	include('includes/comment-form.php');
	?>


	<?php 
	else:
		echo 'Invalid Post';
	endif; //one post found 
	?>


</main>

<?php require('includes/sidebar.php'); ?>

<?php require('includes/footer.php'); ?>