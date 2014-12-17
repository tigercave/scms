<?php 
	$title = "Activate Account";
	include('../include/mysqli_connect.php');
	include('../include/functions.php');
	include('../include/header.php');
	include('../include/sitebar-a.php');
	include('../include/sitebar-b.php');
?>

<div id="content">
<?php  
	$email = filter_input(INPUT_GET, 'x', FILTER_VALIDATE_EMAIL);
	$activate = filter_input(INPUT_GET, 'y', FILTER_SANITIZE_STRING);

	$email = mysqli_real_escape_string($dbc, $email);
	$activate = mysqli_real_escape_string($dbc, $activate);

	if (empty($email) || empty($activate)) {
		$message = "<p class='warning'>Your accoutn cound not be activate. Please try again later.</p>";
	} else {
		$q = "UPDATE users SET active = NULL WHERE email = '{$email}' AND active = '{$activate}' LIMIT 1";
		$r = mysqli_query($dbc, $q);
		confirm_query($r, $q);

		if (mysqli_affected_rows($dbc) == 1) {
			$message = "<p class='success'>Your account has been activated successfully. You may <a href='".BASE_URL."'>Login</a> now.";
		} else {
			$message = "<p class='warning'>Your accoutn cound not be activate due to a system error.</p>";
		}
	}

	echo isset($message) ? $message : NULL;
?>	
</div><!--end content-->
<?php include('../include/footer.php'); ?>