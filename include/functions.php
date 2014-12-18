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

	// Redirect to other page
	function redirect_to($page = 'index.php') {
		$url = BASE_URL . $page;
		header("Location: {$url}");
		exit();
	}

	// remove last word from string
	function the_excerpt($value, $length = 400) {
		if (strlen($value) > $length) {
			$value = substr($value, 0, $length);
		}
		$value = substr($value, 0, strrpos($value, ' '));
		$sanitized = htmlentities($value, ENT_COMPAT, 'UTF-8');
		return $sanitized;
	}

	// create paragrap from db text
	function the_content($text) {
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
		$sanitized = str_replace(array("\r\n", "\n"), array("<p>", "</p>"), $sanitized);
		return $sanitized;
	}

	// Check if current user is admin
	function is_admin() {
		return isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1;
	}

	// validate id to load entity from database from from get request
	function validate_id($id_name) {
		return $id = filter_input(INPUT_GET, $id_name, FILTER_VALIDATE_INT, array('options' => array('range' => 1)));
	}

	// get page by page_id.
	function get_page_by_id($page_id) {
		global $dbc;
		// query select page with page_id
		$q = "SELECT ";
			$q .= "p.page_name, ";
			$q .= "p.page_id, ";
			$q .= "p.content, ";
			$q .= "DATE_FORMAT(p.post_on, '%b %d %y') date, ";
			$q .= "CONCAT_WS(' ', u.first_name, u.last_name) user, ";
			$q .= "u.user_id ";
		$q .= "FROM ";
			$q .= "pages p INNER JOIN users u USING(user_id) ";
		$q .= "WHERE ";
			$q .= "p.page_id = {$page_id} ";
		$q .= "LIMIT 1";
		// resultset 
		$results = mysqli_query($dbc, $q);
		// check query error
		confirm_query($results, $q);
		if (mysqli_num_rows($results) == 1) { // check if has only 1 row
			return mysqli_fetch_array($results, MYSQLI_ASSOC); // return associate array
		} else {
			return NULL; 
		}
	}

	// get pages from cat_id
	function get_pages_by_cat_id($cat_id) {
		global $dbc;
		// query select page with cat_id
		$q = "SELECT ";
			$q .= "p.page_name, ";
			$q .= "p.page_id, ";
			$q .= "p.content, ";
			$q .= "DATE_FORMAT(p.post_on, '%b %d %y') date, ";
			$q .= "CONCAT_WS(' ', u.first_name, u.last_name) user, ";
			$q .= "u.user_id ";
		$q .= "FROM ";
			$q .= "pages p INNER JOIN users u USING(user_id) ";
		$q .= "WHERE ";
			$q .= "p.cat_id = {$cat_id} ";
		$q .= "ORDER BY date ASC ";
		$q .= "LIMIT 0, 10";
		// resultset 
		$results = mysqli_query($dbc, $q);
		// check query error
		confirm_query($results, $q);

		return $results;
	}

	// get pages from user_id
	function get_pages_by_user_id($user_id, $start = 0, $range = 10) {
		global $dbc;
		// query select page with cat_id
		$q = "SELECT ";
			$q .= "p.page_name, ";
			$q .= "p.page_id, ";
			$q .= "p.content, ";
			$q .= "DATE_FORMAT(p.post_on, '%b %d %y') date, ";
			$q .= "CONCAT_WS(' ', u.first_name, u.last_name) user, ";
			$q .= "u.user_id ";
		$q .= "FROM ";
			$q .= "pages p INNER JOIN users u USING(user_id) ";
		$q .= "WHERE ";
			$q .= "p.user_id = {$user_id} ";
		$q .= "ORDER BY date ASC ";
		$q .= "LIMIT {$start}, {$range}";
		// resultset 
		$results = mysqli_query($dbc, $q);
		// check query error
		confirm_query($results, $q);

		return $results;
	}

	function captcha() {
		$qna = array(
			1 => array('question' => 'Mot cong mot', 'answer' => 2),
			2 => array('question' => 'ba tru hai', 'answer' => 1),
			3 => array('question' => 'ba nhan nam', 'answer' => 15),
			4 => array('question' => 'sau chia hai', 'answer' => 3),
			5 => array('question' => 'nang bach tuyet va ... chu lun', 'answer' => 7),
			6 => array('question' => 'Alibaba va ... ten cuop', 'answer' => 40),
			7 => array('question' => 'an mot qua khe, tra ... cuc vang', 'answer' => 1),
			8 => array('question' => '... nam ha dong, ba muoi nam ha tay mac khi thieu nien cung.', 'answer' => 30)
			);
		$rand_key = array_rand($qna);
		$_SESSION['q'] = $qna[$rand_key];
		return $question = $qna[$rand_key]['question'];
	}

 ?>