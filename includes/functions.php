<?php 
function convert_date( $timestamp ){
	$date = new DateTime( $timestamp );
	return $date->format('F j, Y');
}

//no close php