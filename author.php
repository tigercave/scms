<?php include('include/mysqli_connect.php') ?>
<?php include('include/functions.php') ?>
<?php include('include/header.php') ?>
<?php include('include/sitebar-a.php') ?>
<?php include('include/sitebar-b.php') ?>

<div id="content">
<?php 
		if ($user_id = validate_id('aid')) {
			$r = get_pages_by_user_id($user_id);
			if (mysqli_num_rows($r) > 0) { // Neu co du lieu page de hien thi
				while ($page = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	?>
		<div class="post">
			<h2><a href="single.php?pid=<?php echo $page['page_id'] ?>"><?php echo $page['page_name']?></a></h2>
			<p><?php echo the_excerpt($page['content']) . " ... <a href='single.php?pid={$page['page_id']}'>Read more</a>" ?></p>
			<p class="meta">
				<strong>Posted by: </strong><a href="author.php?aid=<?php echo $page['user_id'];?>"><?php echo $page['user'] ?></a>
				<strong>On: </strong><?php echo $page['date'] ;?>
			</p>
		</div>
	<?php
				}
			} else {
				echo "<p>The are currently no page in this category!</p>";
			}
		} else {
			redirect_to('index.php');
		}
	 ?>

</div><!--end content-->
<?php include('include/footer.php') ?>