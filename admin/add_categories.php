<?php include('../include/mysqli_connect.php') ?>
<?php include('../include/functions.php') ?>
<?php include('../include/header.php') ?>
<?php include('../include/sitebar-admin.php') ?>
<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $cat_name = mysqli_real_escape_string($dbc,filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS));
        $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);

        // validate cat_name
        if (empty($cat_name)) {
            $message = "<p class='warning'>Category name is required!</p>";
        } 

        // validate position
        if (!filter_var($position, FILTER_VALIDATE_INT, array('min-range' => 1))) {
           $message = "<p class='warning'>Position is required!</p>";
        }
        
        if (!isset($message) || empty($message)) { // Check is has any error message
            
            $q = "INSERT INTO categories (user_id, cat_name, position) VALUES (1, '{$cat_name}', {$position})";
            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);
            
            if (mysqli_affected_rows($dbc) == 1) {
                $message = "<p class='success'>The category was added successfully.</p>";
            } else {
                $message = "<p class='warning'>Could not added to the database due to a system error.</p>";
            }    
        }
        
    } // END main if submit condition
 ?>
<div id="content">
    <h2>Create a category</h2>
    
    <form id="add_cat" action="" method="post">
    <?php
        if (isset($message)) echo $message;
    ?>
        <fieldset>
            <legend>Add category</legend>
            <div>
                <label for="category">Category name: <span class="required">*</span></label>
                <input type="text" name="category" id="category" size="20" maxlength="80" tabindex="1" value="<?php if (isset($cat_name)) echo $cat_name; ?>"/>
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
        <p><input type="submit" name="submit" value="Add category"/></p>
    </form>

</div><!--end content-->
<?php include('../include/footer.php') ?>