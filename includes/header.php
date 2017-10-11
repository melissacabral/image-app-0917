<?php 
//login wont work without session
session_start();
error_reporting( E_ALL & ~E_NOTICE ); 
//connect to the database
require('includes/db-config.php'); 
include_once('includes/functions.php');
//check to see if someone is logged in
$logged_in_user = check_login();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles/style.css">

	<link rel="alternate" type="application/rss+xml" href="rss.php">

	<title>Image App Home Page</title>
</head>
<body>
	<header class="header">
		<h1><a href="index.php">Image App</a></h1>
	</header>

	<nav class="main-navigation wrapper">
		<section class="search-bar">
			<form action="search.php" method="get">
				<input type="search" name="phrase" placeholder="Search">
				<input type="submit" value="Search">
			</form>
		</section>

		<ul class="menu">
			<?php 
			//menu items for users who are not logged in 
			if( ! $logged_in_user ): ?>
			<li><a href="login.php">Log In</a></li>
			<li><a href="register.php">Register</a></li>
			<?php 
			//logged in menu items
			else: ?>
			<li><a href="add-post.php">Add New Post</a></li>
			<li><a href="profile.php?user_id=<?php echo $logged_in_user['user_id']; ?>">
				<?php echo $logged_in_user['username']; ?>'s Profile</a>
			</li>
			<li><a href="login.php?action=logout">Log Out</a></li>
			<?php endif; ?>

		</ul>
	</nav>

	<div class="wrapper"> <!-- closes in the footer -->
