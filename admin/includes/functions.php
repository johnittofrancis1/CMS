<?php
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

	
	function users_online() 
	{
		if(isset($_GET['onlineusers']))
		{
			global $connection;

			if(!$connection)
			{
				session_start();
			
				include "../../includes/db.php";
			}
			$session = session_id();
			$time = time();
			$time_out_seconds = 30;
			$time_out = $time - $time_out_seconds;

			$query = "SELECT * from users_online where session='$session'";
			$result = mysqli_query($connection,$query);
			cnfrmQuery($result);
			$count = mysqli_num_rows($result);

			if($count == 0)
			{
				$insert_query = "INSERT INTO users_online (session,time) values ('$session','$time')";
				$result = mysqli_query($connection,$insert_query);
				cnfrmQuery($result);
			}
			else
			{
				$update_time_query = "UPDATE users_online SET time='$time' WHERE session='$session'";
				$result = mysqli_query($connection,$update_time_query);
				cnfrmQuery($result);
			}

			$query = "SELECT * from users_online where time > '$time_out'";
			$result = mysqli_query($connection,$query);
			cnfrmQuery($result);
			$count = mysqli_num_rows($result);

			echo $count;
		}
	}

	users_online();

	function recordCount($table)
	{
		global $connection;

		$query = "SELECT * from ".$table;
        $result = mysqli_query($connection,$query);
        cnfrmQuery($result);

        return mysqli_num_rows($result);
	}

	function recordCountforCriteria($table,$column,$value)
	{
		global $connection;
		
		$query = "SELECT * from ".$table." WHERE ".$column." = '".$value."'";
        $result = mysqli_query($connection,$query);
        cnfrmQuery($result);

        return mysqli_num_rows($result);
	}


	function isAdmin($username = '')
	{
		global $connection;
		
		$query = "SELECT user_role from users WHERE username = '$username'";
        $result = mysqli_query($connection,$query);
        cnfrmQuery($result);

        $row = mysqli_fetch_array($result);
        $user_role = $row['user_role'];

        if($user_role == 'admin')
        	return true;
        else
        	return false;
	}
?>