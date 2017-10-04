<?php
error_reporting( E_ALL & ~E_NOTICE ); 
//open a new session or resume the current one
session_start(); 

//If the user is trying to log out ( ?action=logout )
if( $_GET['action'] == 'logout' ):
	//snippet from php.net to delete session cookies
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}
	//remove the session id
	session_destroy();
	//erase all session vars
	$_SESSION['loggedin'] = 0;
	//unset all cookies
	setcookie('loggedin', 0, time() -99999 );
endif; //end of logout logic

//if the user submitted the form, parse it
if( $_POST['did_login'] ):
	//extract and sanitize what the user typed in
	$username = trim(strip_tags($_POST['username']));
	$password = trim(strip_tags($_POST['password']));
	
	// validate it
	$valid = true;

	//check if UN is not between 5 - 30 chars
	if( strlen($username) < 5 OR strlen($username) > 30 ){
		$valid = false;
	}

	//check if password is too short
	if( strlen($password) < 8 ){
		$valid = false;
	}

	// if valid, check login credentials
	// if the UN & PW match the correct values, send them to the secret page
	// TODO: Make this work with a Database
	if( $valid ):
		$correct_username = 'melissa';
		$correct_password = 'phprules';
		if( $username === $correct_username AND $password === $correct_password ):
			//remember me for 24 hours
			setcookie( 'loggedin', 1, time() + 60 * 60 * 24 );
			$_SESSION['loggedin'] = 1;
			//redirect
			header('Location:secret.php');
		else:
			$feedback = 'Sorry, that username/password combo is incorrect';
		endif;
	else:
		$feedback = 'Invalid form submission';
	endif; // valid

endif; //end of login parser
?>