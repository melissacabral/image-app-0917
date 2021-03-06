<?php 
//get the login parser and logout logic
require('includes/db-config.php');
require_once('includes/functions.php');
require('includes/login-logic.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Log in to your account</title>
	<link rel="stylesheet" type="text/css" href="styles/login-style.css">
</head>
<body>
	<?php //if not logged in, show the form
	if( !$_SESSION['loggedin'] ): ?>
	<h1>Log in to your account</h1>

	<?php 
	form_errors($feedback, $errors);
	?>

	<form action="login.php" method="post">
		<label for="the_username">Username</label>
		<input type="text" name="username" id="the_username" required>

		<label for="the_password">Password</label>
		<input type="password" name="password" id="the_password" required>

		<input type="submit" value="Log In">
		<input type="hidden" name="did_login" value="true">
	</form>
	<?php 
	else:
		echo 'You\'re already logged in. No form for you.';
		echo ' <a href="secret.php">Go to secret page</a>';
	endif; ?>

	<footer>
		This site uses cookies to improve your experience.
		<br>
		<a href="index.php">Return Home</a> | <a href="register.php">New user? Sign Up</a>
	</footer>
</body>
</html>