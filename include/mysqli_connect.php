<?php 
	// Connect to database
	$dbc = mysqli_connect('localhost', 'root', '', 'scms');

	// If connect error then throw error message to browser.
	if (!$dbc) {
		trigger_error("Could not connect to DB" .  mysqli_connect_error());
	} else {
		// dat phuong thuc ke noi la utf-8
		mysqli_set_charset($dbc, 'utf-8');
	}
 ?>