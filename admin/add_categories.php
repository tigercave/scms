<?php include('../include/header.php') ?>
<?php include('../include/sitebar-admin.php') ?>
<?php include('../include/sitebar-b.php') ?>
<?php include('../include/mysqli_connect.php') ?>
<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Neu gia tri ton tai, su ly form
        $error = array();
        // validate cat_name
        if (empty($_POST['category'])) {
            $error[] = "category";
        } else {
            $cat_name = $_POST['category'];
        }
        // validate position
        if (isset($_POST['position'])  && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
            $position = $_POST['position'];
        } else {
            $error[] = "position";
        }
        
        if (empty($error)) {
            $q = "INSERT INTO categories (user_id, cat_name, position) VALUES (1, '{$cat_name}', {$position})";
            $r = mysqli_query($dbc, $q) or die("Query {$q} \n<br/> MySQL error: " . mysqli_error($dbc));
            if (mysqli_affected_rows($dbc) == 1) {
                echo "<p>The category was added successfully.</p>";
            } else {
                echo "<p>Could not added to the database due to a system error.</p>";
            }    
        } else {
            echo "Please fill all the required fields.";
        }
        
    } // END main if submit condition
 ?>
<div id="content">
    <h2>Create a category</h2>
    
    <form id="add_cat" action="" method="post">
        <fieldset>
            <legend>Add category</legend>
            <div>
                <label for="category">Category name: <span class="required">*</span></label>
                <?php 
                    if (isset($error) && in_array('category', $error)) {
                        echo "<p class='warning'>Please fill in Category name</p>";  
                    }
                 ?>
                <input type="text" name="category" id="category" value="" size="20" maxlength="80" tabindex="1"/>
            </div>
            <div>
                <label for="position">Position: <span class="required">*</span></label>
                <?php 
                    if (isset($error) && in_array('position', $error)) {
                        echo "<p class='warning'>Please pick a position</p>";
                    }
                 ?>
                <select name="position" tabindex="2">
                    <option value="1">1</option>
                </select>
            </div>
        </fieldset>
        <p><input type="submit" name="submit" value="Add category"/></p>
    </form>

</div><!--end content-->
<?php include('../include/footer.php') ?>