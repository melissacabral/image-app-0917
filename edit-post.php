<?php require('includes/header.php'); ?>
<?php require('includes/edit-post-parse.php'); ?>

<main class="content">
	<h2>Image Details</h2>

	<?php display_post_image($_GET['post_id'], 'large'); ?>

	<?php form_errors( $feedback, $errors ); ?>

	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?<?php echo $_SERVER['QUERY_STRING'] ?>" method="post">
		<label>Title</label>
		<input type="text" name="title" value="<?php echo $title; ?>">

		<label>Post Body</label>
		<textarea name="body"><?php echo $body; ?></textarea>

		<?php category_dropdown( $category_id ); ?>

		<label>
			<input type="checkbox" name="allow_comments" value="1" <?php 
			checked($allow_comments, 1); ?>>
			Allow comments on this post
		</label>

		<input type="submit" value="Save Post">

		<input type="hidden" name="did_edit_post" value="1">

	</form>


</main>

<?php require('includes/sidebar.php'); ?>
<?php require('includes/footer.php'); ?>
