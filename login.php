<?php 
	$title = "Login";
	include('include/mysqli_connect.php');
	include('include/functions.php');
	include('include/header.php');
	include('include/sitebar-a.php');
	include('include/sitebar-b.php');
?>
<?php 
	if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
		// Get all from param from request
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
		$has_errors = FALSE;

		if (empty($email)) { // Check email 
			$email_error = "<span class='warning'>Email is required.</span>";
			$has_errors = TRUE;
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // CHECK $email is valid?
			$email_error = "<span class='warning'>Email is invalid.</span>";
			$has_errors = TRUE;
		}

		if (empty($password)) { // CHECK password is required.
			$password_error = "<span class='warning'>Password is required.</span>";
		}

		if ($has_errors) { // If Validation result is FALSE.
			$message = "<p class='warning'>Please try again.</p>";
		} else { // Find user 
			$q = "SELECT u.user_id, u.first_name, u.user_level FROM users u WHERE u.email = '{$email}' AND u.pass = SHA1('{$password}') AND u.active IS NULL LIMIT 1";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);

			if (mysqli_num_rows($r) == 1) { // If users found.
				session_regenerate_id();
				list($uid, $first_name, $user_level) = mysqli_fetch_array($r, MYSQLI_NUM);
				$_SESSION['uid'] = $uid;
				$_SESSION['first_name'] = $first_name;
				$_SESSION['user_level'] = $user_level;

				redirect_to();
			} else {
				$message = "<p class='warning'>Your email or password do not match OR your have not activated your account.</p>";
			}
		}
	}
 ?>
<div id="content">
	<h2>Login</h2>
	<form id="loginForm" name="loginForm" method="post" action="">
		<?php echo isset($message) ? $message : ''; ?>
		<fieldset>
			<legend>Login</legend>
			<div>
				<label for="email">Email: <span class="warning">*</span><?php echo isset($email_error) ? $email_error : ''; ?></label>
				<input type="email" id="email" name="email" size="20" maxlength="40" required value="<?php echo isset($email) ? $email : ''; ?>">
			</div>
			<div>
				<label for="password">Password: <span class="warning">*</span><?php echo isset($password_error) ? $password_error : ''; ?></label>
				<input type="password" id="password" name="password" size="20" maxlength="40" required>
			</div>
		</fieldset>
		<div>
			<input id="submit" name="submit" type="submit" value="Submit">
		</div>
	</form>
</div><!--end content-->
<?php include('include/footer.php') ?>