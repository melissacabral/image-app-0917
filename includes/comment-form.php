<?php 
// Hide this form if not logged in
if( $logged_in_user ): ?>

<section class="comment-form">
	<h2>Leave a comment</h2>

	<?php 
	//parser feedback
	if( isset($message) ):
		echo "<div class='feedback'>$message</div>";
	endif;
	 ?>

	<form action="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>" method="post">

		<label for="the_body">Your Comment:</label>
		<textarea name="body" id="the_body"></textarea>

		<input type="submit" value="Comment">
		<input type="hidden" name="did_comment" value="1">
	</form>
</section>
<?php 
else:
	echo '<b>You must be logged in to leave a comment</b>';
endif; 
?>