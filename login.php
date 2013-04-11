<?php

require_once('utility_functions.inc.php');
session_start();

/* userLoggedIn determines if the username session is set.
 * if it is, then redirect the user to the home page
 */
function userLoggedIn(){
	if(isset($_SESSION["username"])){
		header("Location: http://localhost");
		exit();
	}
}

function print_login($error){
	$error_message = "";
	if ($error) {
		$error_message = "<font color='red'>Your submitted the wrong username or password. Please try again or contact the webmaster.  If you forgot your password, go here: <a href='login_forgotpw.php'> Forgot Password</a></font><br/>";
	}
echo <<<END
	<table>
	<h1>Member Login</h1>
	<p>$error_message Please log in if you belong to Epsilon and have an account.  If you do not have an account, please contact the webmaster for the registration password and <a color="#FFFF00" href='register.php'>sign up</a>.  If you forgot your password, go here: <a href='login_forgotpw.php'> Forgot Password</a>	
	</p>
			<form name="loginform" method="post" action="$_SERVER[PHP_SELF]">
			<tr>
			<td width="40%">Username:</td><td width="60%"><input type="text" name="username"/></td>
			</tr>
			<tr>
			<td width="40%">Password:</td><td width="60%"><input type="password" name="password"/></td>
			</tr>
			<tr>
			<td float="right"><input type="submit" value="Login"/></td>
			</tr>
			<input type="hidden" name="logstate" value="login"/>
	</form>
	</table>
END;
print_r($_SESSION);
}

/* process_login() is used to process the login
 * and assign session variables
 */
function process_login(){

	$username = $_POST["username"];
	$password = md5($_POST["password"]);

	$sql = "SELECT id,username,firstname,lastname,position,active_sem,Status_Id FROM Member
			WHERE username=:username AND password=:password";


	$db = newPDO();

	$stmt = $db->prepare($sql);

	$stmt->execute(array(':username'=>$username,':password'=>$password));
	$row = $stmt->fetch();
	print_r($row);

	$_SESSION['username'] = $row['username'];
	$_SESSION['firstname'] = $row['firstname'];
	$_SESSION['lastname'] = $row['lastname'];
	$_SESSION['position'] = $row['position'];
	$_SESSION['id'] = $row['id'];
	$_SESSION['active_sem'] = $row['active_sem'];
	$_SESSION['Status_Id'] = $row['Status_Id'];

	print_r($_SESSION);
}

userLoggedIn();

if(isset($_POST['logstate']) && ('login' == $_POST['logstate'])){
	process_login();
}else{
	print_login();
}


























