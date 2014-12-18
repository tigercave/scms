<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'/>
	<title><?php echo !empty($title) ? $title : 'Simple Content Management System'; ?></title>
	<link rel="stylesheet" href="http://localhost/scms/css/style.css"/>
	<script type="text/javascript" src="http://localhost/js/jquery.min.js"></script>
	<script type="text/javascript" src="http://localhost/scms/js/tinymce/tiny_mce.js" ></script>
    
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><a href ="">izCMS</a></h1>
			<p class="slogan">The iz Content Management System</p>
		</div>
		<div id="navigation">
		<ul>
	        <li><a href='/scms/index.php'>Home</a></li>
			<li><a href='#'>About</a></li>
			<li><a href='#'>Services</a></li
>			<li><a href='#'>Contact us</a></li>
		</ul>
        
        <p class="greeting">Xin chào <?php echo isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'bạn hiền' ?>!</p>
	</div><!-- end navigation-->
	