<?php include('../include/mysqli_connect.php') ?>
<?php include('../include/functions.php') ?>
<?php include('../include/header.php') ?>
<?php include('../include/sitebar-admin.php') ?>

<?php 
	//get all field from request
	$page_id = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));

	


	if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
		// error array
		$errors = array();

		/* variables */
		$page_name = mysqli_real_escape_string($dbc, filter_input(INPUT_POST, 'page_name', FILTER_SANITIZE_SPECIAL_CHARS));
		$categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_SPECIAL_CHARS);
		$position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
		$page_content = filter_input(INPUT_POST, 'page_content');

		// validate page_name
		if (empty($page_name)) {
			$errors = "page_name";
		}

		// validate category 
		if (!filter_var($categoryId, FILTER_VALIDATE_INT, array('min_range' => 1))) {
			$errors = "categoryId";
		}

		// position category 
		if (!filter_var($position, FILTER_VALIDATE_INT, array('min_range' => 1))) {
			$errors = "position";
		}

		// validate page_content
		if (empty($page_content)) {
			$errors = "page_content";  
		} 

		// Add page to db
		if (!isset($errors) || empty($errors)) {

			$q = "UPDATE pages SET ";
				$q .= "page_name = '{$page_name}', ";
				$q .= "cat_id = {$cat_id}, ";
				$q .= "position = {$position}, ";
				$q .= "content = '{$page_content}' ";
			$q .= "WHERE page_id = {$page_id} LIMIT 1";

			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);

			if (mysqli_affected_rows($dbc) == 1) {
				$messages = "<p class='success'>The page was updated successfully</p>"; 
			} else {
				$messages = "<p class='warning'>The page could not be update due to a system error</p>";
			}
		} 

	} // end of if submit condition
 ?>
<div id="content">
	<h2>Update this page</h2>
	<?php if (!empty($messages)) echo $messages;?>
	<form id="addPageForm" method="post">

		<fieldset>
			<legend>Add a page</legend>

			<div>
				<label for="page_name">Page name:<span class="required">*</span>
					<?php if (isset($errors) && in_array("page_name", $errors)) echo "<p class='warning'>Please fill in page name.</p>"; ?>
				</label>
				<input id="page_name" name="page_name" type="text" value="<?php if (isset($page_name)) echo $page_name; ?>">
			</div>

			<div>
				<label for="categoryId">Category:<span class="required">*</span></label>
				<select id="categoryId" name="categoryId"/>
					<?php 
						$q = "SELECT cat_id, cat_name FROM categories";
						$r = mysqli_query($dbc, $q);
						confirm_query($r, $q);
						if (mysqli_num_rows($r) > 0) {
							while ($cats = mysqli_fetch_array($r, MYSQLI_NUM)) {
								echo "<option value='{$cats[0]}' ";
									if (isset($categoryId) && $categoryId == $cats[0]) echo "selected='selected'";
								echo ">".$cats[1]."</option>";
							}
						}
					 ?>
				</select>
			</div>

			<div>
				<label for="position">Position:<span class="required">*</span></label>
				<select id="position" name="position"/>
					<?php 
						$q = "SELECT COUNT(p.page_id) AS count FROM pages p";
						$r = mysqli_query($dbc, $q);
						confirm_query($r, $q);
						if (mysqli_num_rows($r) == 1) {
							list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
							for ($i = 1; $i <= $num + 1; $i++) {
								echo "<option value='{$i}' ";
									if (isset($position) && $position == $i) echo "selected='selected'";
								echo ">".$i."</option>";
							}
						}
					 ?>
				</select>
			</div>

			<div>
				<label for="page_content">Content: <span class="required">*</span>
					<?php if (isset($errors) && in_array('page_content', $errors)) echo "<p class='warning'>Please fill in content.</p>";?>
				</label>
				<textarea id="page_content" name="page_content" cols="50" rows="6">
					<?php if (isset($page_content)) echo htmlentities($page_content, ENT_COMPAT, 'UTF-8'); ?>
				</textarea>
			</div>

		</fieldset>
		<p><input type="submit" name="submit" value="Update Page"/></p>
	</form>
</div><!--end content-->
<?php include('../include/footer.php') ?>