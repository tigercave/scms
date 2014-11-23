<?php 
	// hang so cho dia chi tuyet doi
	define("BASE_URL", 'http://localhost/scms/');

	// Kiem tra xem ket qua tra ve co dung hay khong
	function confirm_query($result, $query) {
		global $dbc;
		if (!$result) {
			die("Query {$query} \n</br> MYSQL Error: ".mysqli_error($dbc));
		}
	}

	function redirect_to($page = 'index.php') {
		$url = BASE_URL . $page;
		header("Location: {$url}");
		exit();
	}
 ?>