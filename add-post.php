<?php 
require('includes/header.php'); 
require('includes/add-post-parse.php');
?>
<main class="content">
	<?php if( $logged_in_user ): ?>
	<h2>Add New Post</h2>

	<?php form_errors($feedback, array()); ?>

	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" 
		enctype="multipart/form-data">
		<label>Image:</label>
		<input type="file" name="uploadedfile">

		<input type="submit" value="Next Step: Post Details &rarr;">

		<input type="hidden" name="did_add_post" value="1">		
	</form>

	<?php 
	else:
	echo 'You must be logged in to add posts';
	endif; ?>	

</main>
<?php require('includes/sidebar.php'); ?>

<?php require('includes/footer.php'); ?>
