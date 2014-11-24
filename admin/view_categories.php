<?php include('../include/mysqli_connect.php') ?>
<?php include('../include/functions.php') ?>
<?php include('../include/header.php') ?>
<?php include('../include/sitebar-admin.php') ?>
<div id="content">
	<h2>Manage categories</h2>
	<table>
		<thead>
			<tr>
				<th><a href="view_categories.php?ob=cat_name">Category</a></th>
				<th><a href="view_categories.php?ob=position">Position</a></th>
				<th><a href="view_categories.php?ob=posted_by">Posted by</a></th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php
				// Order By
				$ob = filter_input(INPUT_GET, 'ob');

				$q = "SELECT c.cat_id,c.cat_name,c.position, CONCAT_WS(' ', u.first_name, u.last_name) as name FROM categories c, users u WHERE c.user_id = u.user_id ";

				/*calculate order of categories*/
				if (isset($ob)) { // su ly order
					switch ($ob) {
						case "cat_name":
							$q .= "ORDER BY c.cat_name ASC";
							break;

						case "posted_by":
							$q .= "ORDER BY name ASC";
							break;

						default:
							$q .= "ORDER BY c.position ASC";
							break;
					}
				} else {
					$q .= "ORDER BY c.position ASC";
				}
		
				$r = mysqli_query($dbc, $q);
				confirm_query($r, $q);

				while($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo "<tr>";
					echo "<td>".$cats['cat_name']."</td>";
					echo "<td>".$cats['position']."</td>";
					echo "<td>".$cats['name']."</td>";
					echo "<td><a href='edit_category.php?cid=".$cats['cat_id']."'>Edit</a></td>";
					echo "<td><a href='delete_category.php?cid={$cats['cat_id']}'>Delete</a></td>";
					echo "</tr>";
				} // end WHILE categories rows
			 ?>
			
		</tbody>
	</table>
</div><!-- end div#content -->
<?php include('../include/footer.php') ?>