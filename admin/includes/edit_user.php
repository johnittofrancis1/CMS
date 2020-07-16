<?php

	if(isset($_POST['update_user']))
	{
		$user_id = $_GET['user_id'];
		$username = escape($_POST['username']);
		$password = escape($_POST['password']);
		$user_role = escape($_POST['user_role']);
		$first_name = escape($_POST['first_name']);
		$last_name = escape($_POST['last_name']);
		$user_email = escape($_POST['user_email']);

		if(!empty($password))
		{
			$password = password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));

			$image = escape($_FILES['user_image']['name']);
			$temp_image = $_FILES['user_image']['tmp_name'];

			move_uploaded_file($temp_image,"../images/$image");

			$update_query = "UPDATE users SET username = '$username', ";
			$update_query .= "password = '$password', ";
			$update_query .= "user_role = '$user_role', ";
			if(!(empty($image) || $image == ''))
			{
				$update_query .= "user_image = '$image',";
			}
			$update_query .= "first_name = '$first_name' ,";
			$update_query .= "last_name = '$last_name',";
			$update_query .= "user_email = '$user_email' where user_id=$user_id";
			$result = mysqli_query($connection,$update_query);
			cnfrmQuery($result);
			
			header("Location: ../admin/users.php");
		}
		
	}
?>

<?php 
	// display Post's Values
	if(isset($_GET['user_id']))
	{
		$user_id = $_GET['user_id'];
		$query = "select * from users where user_id=$user_id";
		$result = mysqli_query($connection,$query);
		cnfrmQuery($query);

		while ($record = mysqli_fetch_assoc($result)) {
			$user_id = $record['user_id'];
            $username = $record['username'];
            $first_name = $record['first_name'];
            $last_name = $record['last_name'];
            $user_email = $record['user_email'];
            $user_image = $record['user_image'];
            $user_role = $record['user_role'];
?>

<form action="" method="POST" enctype="multipart/form-data">

	<div class="form-group">
		<label for="username">UserName</label>
		<input class="form-control" type="text" name="username" value="<?php echo $username ?>">
	</div>

	<div class="form-group">
		<label for="Password">Password</label>
		<input class="form-control" type="password" name="password">
	</div>



	<div class="form-group">
		<label for="user_role">Role	<?php if(!empty($warn))	echo "<h6 style = 'color :red'>$warn</h6>";?></label>
		<select class="form-control" name = "user_role">
			<option value="admin" <?php if($user_role=="admin") echo "selected"; ?> >Admin</option>
			<option value="subscriber" <?php if($user_role=="subscriber") echo "selected"; ?>>Subscriber</option>
		</select>
	</div>
	
	<div class="form-group">
		<label for="first_name">First Name</label>
		<input class="form-control" type="text" name="first_name" value="<?php echo $first_name ?>">
	</div>
	
	<div class="form-group">
		<label for="last_name">Last Name</label>
		<input class="form-control" type="text" name="last_name" value="<?php echo $last_name ?>">
	</div>

	<div class="form-group">
		<img class="img-responsive" width="150" src="../images/<?php echo $user_image ?>" />
	</div>

	<div class="form-group">
		<label for="image">Upload Image</label>
		<input class="form-control" type="file" name="user_image">
	</div>
	
	<div class="form-group">
		<label for="user_email">Email</label>
		<input class="form-control" type="text" name="user_email" value="<?php echo $user_email ?>">
	</div>
	
	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="update_user" value="Update User">
	</div>
</form>
<?php
		}
	}
?>