<?php 
	include('include/mysqli_connect.php');
	include('include/functions.php');
	if ($page_id = validate_id('pid')) { // validate post param pid (page_id)
		if ($page = get_page_by_id($page_id)) {
			$title = $page['page_name'];
		} else { // if page not found in database, redirect to home page
			redirect_to();
		}
	} else { // if page_id not found, redirect to home page.
		redirect_to();
	}

	include('include/header.php');
	include('include/sitebar-a.php');
	include('include/sitebar-b.php') ;
?>

<div id="content">
<?php 
	if (isset($page)) {	// if has page, show the page information into single.php
?>
	<div class="post">
		<h2><?php echo $page['page_name']?></h2>
		<p><?php echo the_content($page['content']);?></p>
		<p class="meta">
			<strong>Posted by: </strong><?php echo $page['user'] ?>
			<strong>On: </strong><?php echo $page['date'] ;?>
		</p>

	</div>
<?php
	include('include/comment_form.php');
	}
 ?>

</div><!--end content-->
<?php include('include/footer.php'); ?>