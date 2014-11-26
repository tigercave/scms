<?php include('include/mysqli_connect.php') ?>
<?php include('include/functions.php') ?>
<?php include('include/header.php') ?>
<?php include('include/sitebar-a.php') ?>
<?php include('include/sitebar-b.php') ?>

<div id="content">
	<?php 
		// filter id option
		$options = array('options' => array('range'=>1));
		$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT, $options);
		if (!empty($cid)) {
			$q = "SELECT p.page_name, p.page_id, LEFT(p.content, 400) content, DATE_FORMAT(p.post_on, '%b %d %y') date, ";
			$q .= "CONCAT_WS(' ', u.first_name, u.last_name) user, u.user_id ";
			$q .= "FROM pages p INNER JOIN users u USING(user_id) WHERE p.cat_id = {$cid} ORDER BY date ASC LIMIT 0,10";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);

			if (mysqli_num_rows($r) > 0) { // Neu co du lieu page de hien thi

				while ($page = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	?>
					<div class="post">
						<h2><a href="single.php?pid=<?php echo $page['page_id'] ?>"><?php echo $page['page_name']?></a></h2>
						<p><?php echo the_excerpt($page['content']) . " ... <a href='single.php?pid={$page['page_id']}'>Read more</a>" ?></p>
						<p class="meta">
							<strong>Posted by: </strong><?php echo $page['user'] ?>
							<strong>On: </strong><?php echo $page['date'] ;?>
						</p>

					</div>
	<?php
				}
			} else {
				echo "<p>The are currently no page in this category!</p>";
			}
		}
	 ?>

	<h2>Welcome To izCMS</h2>
	<div>
		<p>
			Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus
		</p>
		
		<p>
			Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus
		</p>
		
		<p>
			Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus
		</p>
	</div>

</div><!--end content-->
<?php include('include/footer.php') ?>