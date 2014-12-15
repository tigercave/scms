<?php include('../include/mysqli_connect.php') ?>
<?php include('../include/functions.php') ?>
<?php include('../include/header.php') ?>
<?php include('../include/sitebar-admin.php') ?>

<div id="content">
	<h2>Manage pages</h2>
	<table style="width: 780px; margin: 10px 0;">
		<thead>
			<tr>
				<th><a href="view_pages.php?ob=page_name">Page</a></th>
				<th><a href="view_pages.php?ob=cat">Category</a></th>
				<th><a href="view_pages.php?ob=position">Position</a></th>
				<th><a href="view_pages.php?ob=post_on">Post on</a></th>
				<th><a href="view_pages.php?ob=posted_by">Posted by</a></th>
				<th>Content</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php
				// Order By
				$ob = filter_input(INPUT_GET, 'ob');

				$q = "SELECT ";
					$q .= "p.page_id, ";
					$q .= "p.page_name, ";
					$q .= "c.cat_name, ";
					$q .= "p.position, ";
					$q .= "p.content, ";
					$q .= "DATE_FORMAT(p.post_on, '%b %d %Y') post_on,";
					$q .= "CONCAT_WS(' ', u.first_name, u.last_name) as post_by ";
				$q .= "FROM ";
					$q .= "pages p, categories c, users u ";
				$q .= "WHERE ";
					$q .= "p.user_id = u.user_id AND ";
					$q .="p.cat_id = c.cat_id ";

				/*calculate order of categories*/
				if (isset($ob)) { // su ly order
					switch ($ob) {
						case "page_name":
							$q .= "ORDER BY p.page_name ASC";
							break;

						case "cat":
							$q .= "ORDER BY c.cat_name ASC";
							break;

						case "Posted by":
							$q .= "ORDER BY post_by ASC";
							break;

						case "post_on":
							$q .= "ORDER BY p.post_on ASC";
							break;

						default:
							$q .= "ORDER BY p.position ASC";
							break;
					}
				} else {
					$q .= "ORDER BY p.position ASC";
				}
		
				$r = mysqli_query($dbc, $q);
				confirm_query($r, $q);

				while($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo "<tr>";
					echo "<td>".$pages['page_name']."</td>";
					echo "<td>".$pages['cat_name']."</td>";
					echo "<td>".$pages['position']."</td>";
					echo "<td>".$pages['post_on']."</td>";
					echo "<td>".$pages['post_by']."</td>";
					echo "<td>".the_excerpt($pages['content'],200)."</td>";
					echo "<td><a href='edit_page.php?pid=".$pages['page_id']."'>Edit</a></td>";
					echo "<td><a href='delete_page.php?pid={$pages['page_id']}'>Delete</a></td>";
					echo "</tr>";
				} // end WHILE categories rows
			 ?>
			
		</tbody>
	</table>
</div><!-- end div#content -->
<?php include('../include/footer.php') ?>