<?php 
	$title = "Active Account";
	include('include/mysqli_connect.php');
	include('include/functions.php');
	include('include/header.php');
	include('include/sitebar-a.php');
	include('include/sitebar-b.php');
?>

<?php  
	if (filter_input(INPUT_SERVER, 'REQUEST_METHOD')  == 'POST') {
		$firstName = mysqli_real_escape_string($dbc,filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS));
		$lastName = mysqli_real_escape_string($dbc,filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS));
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		$password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_SPECIAL_CHARS);
		$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_SPECIAL_CHARS);
		$website = filter_input(INPUT_POST, 'website');
		$has_errors = false;

		// ******************
		// validate fields
		// ******************
		
		if (empty($firstName)) {
			$firstName_err = "<span class='warning'>First name is requrired.</span>";
			$has_errors = TRUE;
		}

		if (empty($lastName)) {
			$lastName_err = "<span class='warning'>Last name is requrired.</span>";
			$has_errors = TRUE;
		}

		if (empty($email)) {
			$email_err = "<span class='warning'>Email is requrired.</span>";
			$has_errors = TRUE;	
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email_err = "<span class='warning'>Email is not valid.</span>";
			$has_errors = TRUE;
		}

		if (empty($password1)) {
			$password1_err = "<span class='warning'>Password is requrired.</span>";
			$has_errors = TRUE;	
		}

		if (empty($password2)) {
			$password2_err = "<span class='warning'>Confirm password is requrired.</span>";
			$has_errors = TRUE;	
		}

		if ($password1 != $password2) {
			$password2_err = "<span class='warning'>Confirm password isn't matched with password.</span>";
			$has_errors = TRUE;	
		}

		// Check email in db
		$q = "SELECT * FROM users u WHERE u.email = '{$email}'";
		$r = mysqli_query($dbc, $q);
		confirm_query($r, $q);

		if (mysqli_num_rows($r) >= 1) {
			$email_err = "<span class='warning'>Email has existed.</span>";
			$has_errors = TRUE;
		}

		if ($has_errors) {
			$message = "<p class='warning'>Please try again.</p>";
		} else {
			$activate = md5(uniqid(rand(), true));// Generate activation key.
			$q = "INSERT INTO users(first_name, last_name, email, pass, active, registration_date) ";
			$q .= "VALUES ('{$firstName}', '{$lastName}', '{$email}', SHA1('{$password1}'), '{$activate}', NOW())";

			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);

			if (mysqli_affected_rows($dbc) == 1) {
				$message = "<p class=''>Successfully, we has been sent a activation email to you, Please check your email to activate your account.</p>";
				$body = "Thank you for registering on out website. Please click link bellow to activate your account. \n\n";
				$body .= BASE_URL."processor/activate.php?x=".urlencode($email)."&y={$activate}";
				if (mail($email, 'Activate Account on SCMS', $body, 'FROM: localhost')) {
					$message = "<p class=''>Successfully, we has been sent a activation email to you, Please check your email to activate your account.</p>";
				} else {
					$message = "<p class='warning'>Email can't be sent due to a system error. Sorry!</p>";
				}
			} else {
				$message = "<p class='warning'>Register fail due to a system error.</p>";
			}
		}

	}
?>

<div id="content">

	<form id="registerFrm" action="" method="POST">
		<?php echo isset($message) ? $message : ""; ?>
		<fieldset>
			<legend>Register</legend>
			<div>
				<label for="firstName">First name: <span class="required">*</span><?php echo isset($firstName_err) ? $firstName_err : ''; ?></label>
				<input type="text" size="20" maxlength="80" id="firstName" name="firstName" required value="<?php echo isset($firstName) ? $firstName : ''; ?>" />
			</div>
			<div>
				<label for="lastName">Last name: <span class="required">*</span><?php echo isset($lastName_err) ? $lastName_err : ''; ?></label>
				<input type="text" size="20" maxlength="80" id="lastName" name="lastName" required value="<?php echo isset($lastName) ? $lastName : ''; ?>" />
			</div>
			<div>
				<label for="email">Email: <span class="required">*</span><?php echo isset($email_err) ? $email_err : ''; ?></label>
				<input type="email" size="20" maxlength="80" id="email" required name="email" value="<?php echo isset($email) ? $email : '';  ?>" />
			</div>
			<div>
				<label for="password1">Password: <span class="required">*</span><?php echo isset($password1_err) ? $password1_err : ''; ?></label>
				<input type="password" size="20" maxlength="80" id="password1" required name="password1" value="<?php echo isset($password1) ? $password1 : ''; ?>" />
			</div>
			<div>
				<label for="password2">Confirm password: <span class="required">*</span><?php echo isset($password2_err) ? $password2_err : ''; ?></label>
				<input type="password" size="20" maxlength="80" id="password2" required name="password2" value="<?php echo isset($password2) ? $password2 : ''; ?>" />
			</div>
		</fieldset>
		<div><input type="submit" value="Register" name="submit"/></div>
	</form>
</div><!--end content-->
<?php include('include/footer.php') ?>