<?php 
require('includes/db-config.php');
require_once('includes/functions.php');

//if they submitted the form, try to register the user
if( $_POST['did_register'] ):
	//sanitize everything
	$username 	= clean_string($_POST['username']);
	$email 		= clean_string($_POST['email']);
	$password 	= clean_string($_POST['password']);
	$policy 	= clean_int($_POST['policy']);

	//validate
	$valid = true;
		//username cannot be blank, less than 4 chars or more than 40
	if( strlen($username) < 4 OR strlen($username) > 40 ):
		$valid = false;
		$errors['username'] = 'Your username must be between 4-40 characters long.';
	else:
		//username must not exist in DB
		$query = "SELECT username 
					FROM users
					WHERE username = '$username'
					LIMIT 1";
		$result = $db->query($query);
		if( $result->num_rows == 1 ):
			//username already taken!
			$valid = false;
			$errors['username'] = 'Sorry, that username is already taken';
		endif;
	endif;//end username check
		
	//blank or invalid email
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ):
		$valid = false;
		$errors['email'] = 'Please provide a valid email address.';
	else:
		//email must not exist in DB
		$query = "SELECT email 
					FROM users 
					WHERE email = '$email' 
					LIMIT 1";
		$result = $db->query($query);
		if($result->num_rows == 1):
			//email already taken
			$valid = false;
			$errors['email'] = 'That email is already registered. Do you want to login?';
		endif; 
	endif; //end email check
		
	//password is less than 8 chars
	if( strlen($password) < 8 ):
		$valid = false;
		$errors['password'] = 'Choose a password that is longer than 8 characters';
	endif; //end password check

	//did not agree to policy
	if( $policy != 1 ):
		$valid = false;
		$errors['policy'] = 'Please agree to our terms before signing up.';
	endif; //policy check

	//if valid, add the user to DB and log them in and redirect to the home page
	if( $valid ):
		//add new user
		$query = "INSERT INTO users
					( username, email, password, join_date, is_admin )
					VALUES 
					( '$username', '$email', sha1('$password'), now(), 0 )";
		$result = $db->query($query);
		if( !$result )
			echo $db->error;
		if( $db->affected_rows == 1 ):
			//SUCCESS! TODO: log them in and redirect to home
			$feedback = "Success. You are now a user!";
		else:
			$feedback = "Query Failed.";			
		endif; //one row affected

	else:
		//if not valid, show error message
		$feedback = "Not valid";	
	endif; //valid	
		
endif; //end of register parser
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create an Account</title>
	<link rel="stylesheet" type="text/css" href="styles/login-style.css">
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<h1>Create an Account</h1>
		<p>Sign up to start sharing photos!</p>

		<?php
		if(isset($feedback))
			echo $feedback;
		?>
		<pre><?php print_r($errors); ?></pre>

		<label for="the_username">Create Username</label>
		<input type="text" name="username" id="the_username">

		<label for="the_email">Email Address</label>
		<input type="email" name="email" id="the_email">

		<label for="the_password">Create Password</label>
		<input type="password" name="password" id="the_password">

		<label>
			<input type="checkbox" name="policy" value="1">
			I agree to the <a href="#">terms of service and privacy policy</a>
		</label>

		<input type="submit" value="Sign Up">
		<input type="hidden" name="did_register" value="1">

	</form>
</body>
</html>