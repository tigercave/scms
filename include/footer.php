	<div id="footer">
        <ul class="footer-links">
            <?php 
            	if (isset($_SESSION['user_level'])) {
            		switch ($_SESSION['user_level']) {
            			case 0: // Registered users access.
            				echo "
            					<li><a href='".BASE_URL."edit_profile.php'>User Profile</li>
            					<li><a href='".BASE_URL."change_password.php'>Change password</li>
            					<li><a href='#'>Persional Message</li>
            					<li><a href='".BASE_URL."logout.php'>Logout</li>
            				";
            				break;
            			case 1: // Admin Access.
            				echo "
            					<li><a href='".BASE_URL."edit_profile.php'>User Profile</li>
            					<li><a href='".BASE_URL."change_password.php'>Change password</li>
            					<li><a href='#'>Persional Message</li>
            					<li><a href='".BASE_URL."admin/admin.php'>Admin</li>
            					<li><a href='".BASE_URL."logout.php'>Logout</li>
            				";
    						break;
            		}
            	} else {
            		echo "
	                    <li><a href='".BASE_URL."register.php'>Register</a></li>
	                    <li><a href='".BASE_URL."login.php'>Login</a></li>
		                ";
            	}
             ?>
        </ul>
    </div><!--end footer-->
</div> <!-- end content-container-->
</div> <!--end container-->
</body>
</html>