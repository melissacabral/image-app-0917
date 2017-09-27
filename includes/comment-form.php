<?php //TODO: Hide this form if not logged in ?>

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