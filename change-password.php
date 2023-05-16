<?php 
	include('./classes/db.php');
	include('./classes/Login.php');
	

	if (Login::isLoggedIn())
	{
		// echo 'You are logged in as ' . DB::query('SELECT username FROM users WHERE id=:id', array(':id'=>Login::isLoggedIn()))[0]['username'];

	} else 
	{
		die('Not Logged In');
	}

	if (isset($_POST['changepassword']))
	{
		$oldpassword = $_POST['oldpassword'];
		$newpassword = $_POST['newpassword'];
		$newpasswordconfirm = $_POST['newpasswordconfirm'];
		$userid = Login::isLoggedIn();

		if ($newpassword == null || $oldpassword == null ||$newpasswordconfirm == null)
		{
			#Check if every field is filled up
			echo 'You have to fill up all necessary fields';

		} elseif (!password_verify($oldpassword, DB::query('SELECT password FROM users WHERE id=:userid', array(':userid'=>$userid))[0]['password']))
		{
			#Check if old password is equal to current password
			echo 'Wrong password';

		} elseif ($oldpassword ==$newpassword)
		{
			#Check if new password is the same as the old password
			echo 'New passwords don\'t match';

		} elseif (strlen($newpassword) < 6 && strlen($newpassword) < 60)
		{
			#Check if password is between 6 and 60 characters
			echo 'Password has to be between 6 and 60 characters';

		} elseif (!(preg_match('/[A-Z]+/', $newpassword) && preg_match('/[0-9]+/', $newpassword)))
		{
			#Check if password has a number and a letter
			echo 'Password needs atlest 1 number and 1 capital letter';

		} elseif (!($newpassword == $newpasswordconfirm))
		{
			#Check if newpassword is equal to newpasswordconfirm
			echo 'Your new password as the be the same in both fields';

		} else
		{
			DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT),':userid'=>$userid));
			echo 'Password changed successfully';
		}
		

	}
?>
<h1>Change your password</h1>
<form action="change-password.php" method="post">
	<input type="password" name="oldpassword" value="" placeholder="Current Password"><p />
	<input type="password" name="newpassword" value="" placeholder="New Password"><p />
	<input type="password" name="newpasswordconfirm" value="" placeholder="Confirm New Password"><p />
	<input type="submit" name="changepassword" value="Change Password">
</form>