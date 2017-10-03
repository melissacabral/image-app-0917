<?php 
error_reporting( E_ALL & ~E_NOTICE ); 
//connect to the database
require('includes/db-config.php'); 
include_once('includes/functions.php');
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
	</nav>

	<div class="wrapper"> <!-- closes in the footer -->