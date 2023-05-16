<?php 
	include('./classes/db.php');

	if (isset($_POST['login']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username)))
		{
			echo 'User is not registered';
		} elseif (!password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password']))
		{
			echo 'Incorrect password';
		} else
		{
			echo 'Logged in!';

			$cstrong = True;
			$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
			$user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
			DB::query('INSERT INTO login_tokens VALUES (\'\',:token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

			setcookie('LANID', $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
			setcookie('LANID_','1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
		}
	
	}
?>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1>Login</h1>
	<form action="login.php" method="post">
		<input type="text" name="username" placeholder="Username"><p />
		<input type="password" name="password" placeholder="Password"><p />
		<input type="submit" name="login" value="Login">
	</form>
</body>
</html>