<?php
	include('./classes/db.php');

	if (isset($_POST['create-account']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];

		$n_class = $_POST['n_class'];
		$l_class = $_POST['l_class'];
		$class = $n_class . $l_class;
		echo $class;
		$class_n = $_POST['class_n'];
		$student_n = $_POST['student_n'];

		if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username)))
		{
			#Checks if user already exists
			echo 'User already exists';

		}  elseif ($username == null || $password == null || $email == null) 
		{
			#Checks if all fields are filled
			echo 'Please fill all fields required';

		} elseif (!(preg_match('/[a-zA-Z0-9_]+/', $username)))
		{
			#Checks if username has valid characters
			echo 'Invalid username';

		} elseif (strlen($password) < 6 && strlen($password) > 60)
		{
			#Checks if password has between 6 and 60 characters
			echo 'Password has to have between 6 and 60 characters';

		} elseif (!(preg_match('/[A-Z]+/', $password) && preg_match('/[0-9]+/', $password)))
		{
			#Check if password has a number and a letter
			echo 'Password needs atlest 1 number and 1 capital letter';

		} elseif (strlen($username) < 6 && strlen($username) > 32)
		{
			#Checks if username has between 8 and 32 characters
			echo 'Username has to have between 6 and 32 characters';

		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			#Checks if email is valid
			echo 'Email not valid';

		} elseif (DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email)))
		{
			#Checks if email is valid
			echo 'Email already taken';
		} else 
		{
			#Creates account on the database
			DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email, :class, :class_n, :student_n)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email, ':class'=>$class, ':class_n'=>$class_n, ':student_n'=>$student_n));
			echo 'Account Created';
		}
	}
?>

<html>
<head>
	<title>Create Account</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/styles_global.css">
	<link rel="stylesheet" type="text/css" href="css/create-account.css">

</head>
<body>
	<form method="post" action="create-account.php" class="create-account">
		<h2>Registar</h2>
	
		<input type="text" name="username" value="" placeholder="Nome de utilizador"><p />
		<input type="password" name="password" value="" placeholder="Palavra Pass"><p />
		<input type="text" name="email" value="" placeholder="Email"><p />
		<input type="text" name="student_n" value="" placeholder="Número de estudante"><p />

		<div class="school_class">
			<div class="choices_container">
				<select id="n_year" name="n_class">
					<option value="">Ano</option>
					<option value="8">8º Ano</option>
					<option value="9">9º Ano</option>
					<option value="10">10º Ano</option>
					<option value="11">11º Ano</option>
					<option value="12">12º Ano</option>
				</select>
				<select id="l_year" name="l_class">
					<option>Turma</option>
					<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="E">E</option>
					<option value="F">F</option>
					<option value="H">H</option>
					<option value="I">I</option>
					<option value="J">J</option>
				</select>
			</div>
		</div>
		<input type="text" name="class_n" value="" placeholder="Número de turma">
		<input type="submit" name="create-account" value="Registar">
	</form>
</body>
</html>
