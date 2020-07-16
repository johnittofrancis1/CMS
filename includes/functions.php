<?php
	include "db.php";
	function cnfrmQuery($result)
	{
		global $connection;
		if(!$result)
			die("Query Failed ".mysqli_error($connection));
	}

	function escape($string)
	{
		global $connection;

		return mysqli_escape_string($connection,trim($string));
	}

	function usernameExists($username)
	{
		global $connection;

		$query = "SELECT * from users WHERE username = '$username'";
		$result = mysqli_query($connection,$query);
		cnfrmQuery($result);

		$count_rows = mysqli_num_rows($result);

		if($count_rows == 0)
			return false;
		else
			return true;
	}


	function emailExists($email)
	{
		global $connection;

		$query = "SELECT * from users WHERE user_email = '$email'";
		$result = mysqli_query($connection,$query);
		cnfrmQuery($result);

		$count_rows = mysqli_num_rows($result);

		if($count_rows == 0)
			return false;
		else
			return true;
	}

?>