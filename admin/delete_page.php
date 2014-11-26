<?php include('../include/mysqli_connect.php') ?>
<?php include('../include/functions.php') ?>
<?php include('../include/header.php') ?>
<?php include('../include/sitebar-admin.php') ?>
<?php 
	$options = array('options' => array('min_range' => 1));
	$page_id = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT, $options);

	if (empty($page_id)) {
		$errors = "<p class='warning'>Your request is not valid.</p>";
	} else {
		$q = "SELECT page_name FROM pages WHERE page_id = {$page_id}";
		$r = mysqli_query($dbc, $q);
		confirm_query($r, $q);

		if (mysqli_num_rows($r) == 1) {
			$page = mysqli_fetch_array($r);
		} else {
			$errors = "<p class='warning'>Page not found to delete.</p>";
		}
	}

	if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') ==  'POST') {

		$page_id = filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT, $options);
		$delete = filter_input(INPUT_POST, 'delete');
		if ($delete == 'yes') {
			$q = "DELETE FROM pages WHERE page_id = {$page_id}";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);

			if (mysqli_affected_rows($dbc) == 1) {
				redirect_to('admin/view_pages.php');
			} else {
				$messages = "<p class='warning'>Could not delete the page due to the system error.</p>";
			}
		}
	}

 ?>
<div id="content">
	<?php 
		if (isset($errors)) {
			echo $errors; 
		} elseif (isset($messages)) {
			echo $messages; 
		}
	?>
	<?php if (empty($errors))  { ?>
		<h2>Delete Page: <?php if (isset($page)) echo htmlentities($page[0], ENT_COMPAT, 'UTF-8'); ?></h2>	
		<form name="del_page_form" method="post">
			<input type="hidden" name="pid" value="<?php if (isset($page_id)) echo $page_id; ?>">
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