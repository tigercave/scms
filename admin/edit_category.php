<?php include('../include/mysqli_connect.php') ?>
<?php include('../include/functions.php') ?>
<?php include('../include/header.php') ?>
<?php include('../include/sitebar-admin.php') ?>
<?php 
	// check categoryId
	$catId = filter_input(INPUT_GET, 'cid');
	if (isset($catId) && filter_var($catId, FILTER_VALIDATE_INT, array('min_ranger' => 1))) {
		// Get query from db
		$q = "SELECT cat_name,position, user_id FROM categories c WHERE c.cat_id = {$catId}";
		$r = mysqli_query($dbc, $q);
		confirm_query($r,$q);

		if(mysqli_num_rows($r) == 1) { // Xac dinh cho co mot ket qua tra ve
			$cat = mysqli_fetch_array($r, MYSQL_ASSOC);	
			// load information
			$cat_name = $cat['cat_name'];
			$position = $cat['position'];
			$user_id = $cat['user_id'];
		} else {
			redirect_to("admin/admin.php");
		}
		
	} else {
		redirect_to("admin/admin.php");
	}

	// processing update form.
	if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
		$errors = array();
		$catId = filter_input(INPUT_POST, 'cid');
		$cat_name = mysqli_real_escape_string($dbc, filter_input(INPUT_POST, 'cat_name', FILTER_SANITIZE_SPECIAL_CHARS));
		$position = filter_input(INPUT_POST, 'position');

		if (empty($catId) || !filter_var($catId, FILTER_VALIDATE_INT, array('min_ranger' => 1))) {
			redirect_to('admin/admin.php');
		}

		if (empty($cat_name)) {
			$errors = "cat_name";
		}

		if (empty($position) || !filter_var($position, FILTER_VALIDATE_INT, array('min_ranger' => 1))) {
			$errors = "position";	
		}

		if (!isset($errors) || empty($errors)) {
			$q = "UPDATE categories SET cat_name = '{$cat_name}', position = {$position} WHERE cat_id = {$catId} LIMIT 1";
			$r = mysqli_query($dbc, $q);
			confirm_query($r,$q);

			if (mysqli_affected_rows($dbc) == 1) {
				$message = "<p class='success'>Edit category success full</p>";
			} else {
				$message = "<p class='warning'>Could not edit category due to system error.</p>";
			}
		} else {
			$message = "<p class='warning'>Please fill in all the required fields.</p>";
		}


	}
 ?>
<div id="content">
    <h2>Edit a category</h2>
    
    <form id="add_cat" action="" method="post">
    <?php
        if (isset($message)) echo $message;
    ?>
        <fieldset>
        	<input type="hidden" name="cid" value="<?php echo $catId; ?>"/>
            <legend>Edit category</legend>
            <div>
                <label for="cat_name">Category name: <span class="required">*</span></label>
                <input name="cat_name" id="cat_name" size="20" maxlength="80" tabindex="1" value="<?php if (isset($cat_name)) echo $cat_name; ?>"/>
            </div>
            <div>
                <label for="position">Position: <span class="required">*</span></label>
                <select name="position" tabindex="2">
                    <?php 
                        $q = "SELECT count(cat_id) AS count FROM categories";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);
                        if (mysqli_num_rows($r) == 1) {
                            list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
                            for ($i = 1; $i<=$num + 1; $i++) {
                                echo "<option value='{$i}'";
                                if (isset($position) && $position == $i) {
                                     echo " selected='selected'";
                                }
                                echo ">{$i}</option>";
                            }
                        } 
                     ?>
                </select>
            </div>
        </fieldset>
        <p><input type="submit" name="submit" value="Update category"/></p>
    </form>

</div><!--end content-->
<?php include('../include/footer.php') ?>