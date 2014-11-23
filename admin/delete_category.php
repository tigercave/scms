<?php include('../include/mysqli_connect.php') ?>
<?php include('../include/functions.php') ?>
<?php include('../include/header.php') ?>
<?php include('../include/sitebar-admin.php') ?>
<?php include('../include/sitebar-b.php') ?>
<?php 
	
	$catId = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT, array('min_ranger'=>1));

	if (empty($catId)) {
		$error_messages = "<p class='warning'>Your request is not valid.</p>";
	} else {
		$q = "SELECT cat_name FROM categories WHERE cat_id = {$catId}";
		$r = mysqli_query($dbc, $q);
		confirm_query($r, $q);

		if (mysqli_num_rows($r) == 1) {
			$cat = mysqli_fetch_array($r);
		} else {
			$error_messages = "<p class='warning'>Category not found to delete.</p>";
		}
	}

	if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') ==  'POST') {

		$catId = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT, array('min_ranger'=>1));
		$delete = filter_input(INPUT_POST, 'delete');
		if ($delete == 'yes') {
			$q = "DELETE FROM categories WHERE cat_id = {$catId}";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);

			if (mysqli_affected_rows($dbc) == 1) {
				redirect_to('admin/view_categories.php');
			} else {
				$messages = "<p class='warning'>Could not delete the category due to the system error.</p>";
			}
		}
	}

 ?>
<div id="content">
	<?php 
		if (isset($error_messages)) 
			echo $error_messages; 
		else 
			if (isset($messages)) 
				echo $messages; 
	?>
	<?php if (empty($error_messages))  { ?>
		<h2>Delete Category: <?php if (isset($cat)) echo htmlentities($cat[0], ENT_COMPAT, 'UTF-8'); ?></h2>	
		<form name="del_cat_form" method="post">
			<input type="hidden" name="cid" value="<?php if (isset($catId)) echo $catId; ?>">
			<fieldset>
				<legend>Are you sure?</legend>
				<div>
					<input type="radio" name="delete" value="no" checked="checked"> No
					<input type="radio" name="delete" value="yes"> Yes
				</div>
			</fieldset>
			<div>
				<input type="submit" name="submit" value="Delete"/>
			</div>
		</form> 
	<?php } ?>
</div><!-- end div#content -->
<?php include('../include/footer.php') ?>