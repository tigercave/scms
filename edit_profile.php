<?php 
	$title = "Login";
	include('include/mysqli_connect.php');
	include('include/functions.php');
	include('include/header.php');
	include('include/sitebar-a.php');
	include('include/sitebar-b.php');
?>
<div id="content">
	<?php 
	?>
	<form id="profileForm" method="post" action="processor/avatar.php" enctype="multipart/form-data">
		<fieldset>
			<legend>Avatar</legend>
			<div>
				<img class="avatar" src="image/upload/no-avatar.png" alt="avatar"/>

			</div>
		</fieldset>
	</form>

</div><!--end content-->
<?php include('include/footer.php') ?>