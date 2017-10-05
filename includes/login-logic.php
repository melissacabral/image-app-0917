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
	$_SESSION['secret_key'] = 0;
	$_SESSION['user_id'] = 0;
	//unset all cookies
	setcookie('secret_key', 0, time() -99999 );
	setcookie('user_id', 0, time() -99999 );

endif; //end of logout logic

//if the user submitted the form, parse it
if( $_POST['did_login'] ):
	//extract and sanitize what the user typed in
	$username = clean_string($_POST['username']);
	$password = clean_string($_POST['password']);
	
	// validate it
	$valid = true;

	//check if UN is not between 4 - 40 chars
	if( strlen($username) < 4 OR strlen($username) > 40 ){
		$valid = false;
	}

	//check if password is too short
	if( strlen($password) < 8 ){
		$valid = false;
	}

	// if valid, check login credentials
	// if the UN & PW match the correct values, send them to the secret page

	if( $valid ):
		$query = "SELECT user_id 
					FROM users 
					WHERE username = '$username' 
					AND password = sha1('$password')
					LIMIT 1";
		$result = $db->query($query);
		if( !$result )
			echo $db->error;
		//one row found = Correct match. log them in!
		if( $result->num_rows == 1 ):
			$secret_key = sha1( microtime() . 'sgfks#^$^&hfjrsd,lkwaqe;lh51130851');
			//store the secret in the DB
			
			//WHO logged in?
			$row = $result->fetch_assoc();
			$user_id = $row['user_id'];
			$query = "UPDATE users
						SET secret_key = '$secret_key'
						WHERE user_id = $user_id";
			$result = $db->query($query);
			//check it
			if(!$result)
				echo $db->error;

			if( $db->affected_rows == 1 ):
				//store sessions and cookies
				setcookie( 'secret_key', $secret_key, time() + 60 * 60 * 24 * 7 );
				$_SESSION['secret_key'] = $secret_key;

				//which user is logged in?
				setcookie( 'user_id', $user_id, time() + 60 * 60 * 24 * 7 );
				$_SESSION['user_id'] = $user_id;

				//redirect home
				header('Location:index.php');

			else:
				//todo: remove after debugging
				$errors['update'] = 'update secret key failed';
			endif;
		else:
			$feedback = 'Sorry, that username/password combo is incorrect';
		endif;
	else:
		$feedback = 'Invalid form submission';
	endif; // valid

endif; //end of login parser
?>