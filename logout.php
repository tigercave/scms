<?php 
	$title = "Logout";
	include('include/mysqli_connect.php');
	include('include/functions.php');
	include('include/header.php');
	include('include/sitebar-a.php');
	include('include/sitebar-b.php');
?>
 
<div id="content">
	<?php 
		if (!isset($_SESSION['first_name'])) {
			// If user have not logged.
			redirect_to();
		} else {
			// if user have logged.
			$_SESSION = array(); // Clean session datas.
			session_destroy(); // Destroy old session
			setcookie(session_name(), '', time() - 36000); // Delete cookie of browsers.
		}

		echo "<h2>Your are now logged out.</h2>";
	 ?>
</div><!--end content-->
<?php include('include/footer.php'); ?>