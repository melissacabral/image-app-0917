<?php 
/*
AJAX Demo - this is the interface that the user will see, normal HTML/CSS/PHP rules apply
*/

require('includes/header.php'); 

//get all the categories for the interface
$query = "SELECT * FROM categories";
$result = $db->query($query);

if(!$result):
	echo $db->error;
endif;	

?>
	<main class="content">
		<h2>Pick a Category</h2>
		<?php 
		while($row = $result->fetch_assoc()):
	?>		
	<button class="category-button" data-catid="<?php echo $row['category_id']; ?>"><?php echo $row['name']; ?></button>

	<?php	
	endwhile;	
	 ?>
	 <div id="display-area">
	 	Pick a category to see all of the posts in it.	
	 </div>
	</main>
	<?php require('includes/sidebar.php'); ?>	
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
//when the user clicks on a button
$('.category-button').click( function(e){
	//which category did they click?
	var catid = $(this).data('catid');
	//alert(catid);

	$.ajax({
		method : 'POST',
		url : 'ajax/ajax-category-handler.php',
		data: {'catid' : catid},
		dataType: 'html',
		success : function(response){
			$('#display-area').html(response);
		} //end succcess

	}) //end ajax 

})//end click

//what to do if slow...
//listen for the ajax request to start and stop to show "loading" feedback
$(document).on({
	ajaxStart : function(){
		$('#display-area').addClass('loading');
		console.log('ajax started');
	},
	ajaxStop : function(){
		$('#display-area').removeClass('loading');
		console.log('ajax finished');
	}

})



</script>
<?php require('includes/footer.php'); ?>