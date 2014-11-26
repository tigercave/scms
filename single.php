<?php 
	$title = "Single";
	include('include/mysqli_connect.php');
	include('include/functions.php');
	include('include/header.php');
	include('include/sitebar-a.php');
	include('include/sitebar-b.php') ;
?>

<div id="content">
	<?php 
		// filter id option
		$options = array('options' => array('range'=>1));
		$pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT, $options);
		if (!empty($pid)) {
			$q = "SELECT p.page_name, p.page_id, p.content, DATE_FORMAT(p.post_on, '%b %d %y') date, ";
			$q .= "CONCAT_WS(' ', u.first_name, u.last_name) user, u.user_id ";
			$q .= "FROM pages p INNER JOIN users u USING(user_id) WHERE p.page_id = {$pid} LIMIT 1";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);

			if (mysqli_num_rows($r) == 1) { // Neu co du lieu page de hien thi

				$page = mysqli_fetch_array($r, MYSQLI_ASSOC);
	?>

					<div class="post">
						<h2><?php echo $page['page_name']?></h2>
						<p><?php echo $page['content']?></p>
						<p class="meta">
							<strong>Posted by: </strong><?php echo $page['user'] ?>
							<strong>On: </strong><?php echo $page['date'] ;?>
						</p>

					</div>
	<?php
			} else {
				redirect_to();
			}
		} else {
			redirect_to();
		} 
	 ?>

</div><!--end content-->
<?php include('include/footer.php') ?>