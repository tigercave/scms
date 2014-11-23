<?php include('../include/mysqli_connect.php') ?>
<?php include('../include/functions.php') ?>
<?php include('../include/header.php') ?>
<?php include('../include/sitebar-admin.php') ?>
<?php include('../include/sitebar-b.php') ?>

<?php 
    //get all field from request
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
            $errors = "<p class='warning'>Page name is required!</p>";
        }

        // validate category 
        if (!filter_var($categoryId, FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $errors = "<p class='warning'>Category is required!</p>";
        }

        // position category 
        if (!filter_var($position, FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $errors = "<p class='warning'>Position is required!</p>";
        }

        // validate page_content
        if (empty($page_content)) {
            //$errors = "<p class='warning'>Page content is required!</p>";  
        } 

        // Add page to db
        if (!isset($errors) || empty($errors)) {
            $q = "INSERT INTO pages (user_id, page_name, cat_id, position, content, post_on) VALUES (1, '{$page_name}', {$categoryId}, {$position}, '{$page_content}', NOW())";
            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);

            if (mysqli_affected_rows($dbc) == 1) {
                $messages = "<p class='success'>The page was added successfully</p>"; 
            } else {
                $messages = "<p class='warning'>The page could not be added due to a system error</p>";
            }
        } else {
            $messages = "<p class='warning'>Please fill in all the required fields.</p>";
        }

    } // end of if submit condition
 ?>
<div id="content">
    <h2>Create a page</h2>
    <?php 
        if (isset($errors) && !empty($errors)) {
            echo $errors;
        }
    ?>
    <?php if (!empty($messages)) echo $messages;?>
    <form id="addPageForm" method="post">

        <fieldset>
            <legend>Add a page</legend>

            <div>
                <label for="page_name">Page name:<span class="required">*</span></label>
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
                <label for="page_content">Content: <span class="required">*</span></label>
                <textarea id="page_content" name="page_content" cols="50" rows="6"></textarea>
            </div>

        </fieldset>
        <p><input type="submit" name="submit" value="Add Page"/></p>
    </form>
</div><!--end content-->
<?php include('../include/footer.php') ?>