	</div> <!-- close .wrapper -->
	
	<footer class="footer">
		&copy;2017 Your Name Here
	</footer>

<?php if($logged_in_user): ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
	// LIKES
	$(".likes").on( "click", ".heart-button", function(){
		//which post did they click?  grab the data-postid="X" attribute value
		var post_id = $(this).data("postid");
		//Which user is logged in?
		var user_id = <?php echo $logged_in_user['user_id']; ?>

		console.log(post_id, user_id);

		var display = $(this).parents(".likes");
		
		$.ajax({
			type: "GET",
			url: "ajax/ajax-likes-handler.php",
			dataType: "html",
			data: {
				"user_id" : user_id,
				"post_id" : post_id
			},
			success: function(response){
				//update the display if it worked
				display.html(response);
				console.log('success');
			}
		});
	} );
</script>
<?php endif; ?>

</body>
</html>
<?php $db->close(); ?>