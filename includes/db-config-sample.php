<?php
$database_name = 'melissa_image_app_0917';
$username = 'mmc_image_app_09';
$password = 'X7XvTnaAsDXVL2hK';
$database_host = 'localhost';

//connect to the DB
$db = new mysqli( $database_host, $username, $password, $database_name );

//check to make sure it worked
if( $db->connect_errno > 0 ):
	die('Error connecting to Database');
endif; 
//no close php