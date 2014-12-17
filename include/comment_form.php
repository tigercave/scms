<?php 
	if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
		$name = mysqli_real_escape_string($dbc,filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
		$email = mysqli_real_escape_string($dbc,filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS));
		$comment = trim(mysqli_real_escape_string($dbc,filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS)));
		$captcha = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_SPECIAL_CHARS);
		$question = isset($_SESSION['q']) ? $_SESSION['q'] : NULL;
		$website = filter_input(INPUT_POST, 'website');

		if (empty($name)) {
			$name_err = "<span class='warning'>Name is requried.</span>";
			$has_errors = true;
		} 

		if (empty($email)) {
			$email_err = "<span class='warning'>Email is requried.</span>";	
			$has_errors = true;
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email_err = "<span class='warning'>Email is not valid.</span>";
			$has_errors = true;
		}

		if (empty($comment)) {
			$comment_err = "<span class='warning'>Comment is requried.</span>";
			$has_errors = true;
		}

		if (empty($captcha)) {
			$captcha_err = "<span class='warning'>Captcha is requried.</span>";
			$has_errors = true;
		} elseif ($captcha != $question['answer']) {
			$captcha_err = "<span class='warning'>The answer is not valid.</span>";
			$has_errors = true;
		}

		if (!empty($website)) {
			redirect_to('thankyou.html');
		}

		if (!isset($has_errors)) {
			$q = "INSERT INTO comments (page_id, author, email, comment, comment_date) VALUES ({$pid}, '{$name}', '{$email}', '{$comment}', NOW())";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
			if(mysqli_affected_rows($dbc) == 1) {
				$messages = "<p class='success'>Thank you for comment.</p>";
			} else {
				$messages = "<p class='success'>Your comment could not be posted due to a system error.</p>";
			}
		}
	}

	// Display comment from database
	$q = "SELECT author, comment, DATE_FORMAT(comment_date, '%b %d %y') date FROM comments WHERE page_id = {$pid}";
	$r = mysqli_query($dbc, $q);
	confirm_query($r, $q);
	if (mysqli_num_rows($r) > 0) {
		echo "<ol id='disscuss'>";
		while(list($author, $comment1, $date) = mysqli_fetch_array($r, MYSQLI_NUM)) {
			echo "<li>
				<p class='author'>{$author}</p>
				<p class='comment_sec'>{$comment1}</p>
				<p class='date'>{$date}</p></li>";
		}
		echo "</ol>";
	} else {
		echo "<h2>Be the first to leave a comment.</h2>";	
	}


 ?>
<form id="comment_form" action="" method="post">
	<fieldset>
		<legend>Leave a comment</legend>
		<?php echo isset($messages) ? $messages : ''; ?>
		<div>
			<label for="name">Name: <?php echo isset($name_err) ? $name_err : ''; ?> <span class="required">*</span></label>
			<input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" size="20" maxlength="80" tabindex="1"/>
		</div>
		<div>
			<label for="email">Email: <?php echo isset($email_err) ? $email_err :''; ?> <span class="required">*</span></label>
			<input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" size="20" maxlength="80" tabindex="2"/>
		</div>
		<div>
			<label for="comment">Your comment: <?php echo isset($comment_err) ? $comment_err :''; ?><span class="required">*</span></label>
			<div id="comment">
				<textarea id="comment" name="comment" rows="10" cols="50" tabindex="3"><?php echo isset($comment) ? $comment :''; ?></textarea>
			</div>
		</div>
		<div>
			<label for="captcha">Answer question: <?php echo captcha(); ?>  <?php echo isset($captcha_err) ? $captcha_err :''; ?> <span class="required">*</span></label>
			<input type="text" id="captcha" name="captcha" value="<?php echo isset($captcha) ? $captcha :''; ?>" size="20" maxlength="80" tabindex="4"/>
		</div>
		<div class="website">
			<label for="website">If you see this fied, don't fill it.</label>
			<input type="text" name="website" id="website" size="20" maxlength="80" />
		</div>
	</fieldset>
	<div>
		<input type="submit" name="submit" value="Post comment"/>
	</div>
</form>