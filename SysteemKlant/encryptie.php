<!DOCTYPE html>
<!--
Daan hagemans
Met deze code kan je md5 encryptie vergelijken met SHA512($6$)
-->
<html>
    <head>
        <title>Password Encryption</title>
    </head>
    <body>
        <form method="POST">
        	<p>Password: <input type="password" name="password"></p>
        	<input type="submit" name="show" value="Show Hash"><br>
        	<?php
        	if (isset($_POST["show"])) {
            	
              // begin SHA512 functie
            	function myhash($password, $unique_salt) {
                	return crypt($password, '$6$20$' . $unique_salt);
            	}
            	
            	function unique_salt() {
                	return substr(sha1(mt_rand()), 0, 22);
            	}
            	// einde SHA512 functie
              
            	$password = $_POST["password"];
            	
            	echo '<br>SafeHash:<br><br>' . myhash($password, unique_salt()) . '<br><br>';
            	
            	echo 'MD5Hash:<br><br>' . md5($password) . '<br><br>';
        	}
        	?>
        </form>
    </body>
</html>
