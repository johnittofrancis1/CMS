<?php
	if(isset($_POST['add_user']))
	{
		$username = escape($_POST['username']);
		$password = escape($_POST['password']);
		$user_role = escape($_POST['user_role']);
		$first_name = escape($_POST['first_name']);
		$last_name = escape($_POST['last_name']);
		$user_email = escape($_POST['user_email']);

		$password = password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));

		if(empty($user_role))
		{
			$warn = "Required";
		}
		else
		{
			$image = escape($_FILES['user_image']['name']);
			$temp_image = $_FILES['user_image']['tmp_name'];

			move_uploaded_file($temp_image,"../images/$image");

			$insert_query = "insert into users (username,password,first_name,last_name,user_email,user_role,user_image) ";
			$insert_query .= "values ('$username','$password','$first_name','$last_name','$user_email','$user_role','$image')";
			$result = mysqli_query($connection,$insert_query);
			cnfrmQuery($result);
			header("Location: ../admin/users.php");
		}
		
	}
?>


<form action="" method="POST" enctype="multipart/form-data">

	<div class="form-group">
		<label for="username">UserName</label>
		<input class="form-control" type="text" name="username">
	</div>

	<div class="form-group">
		<label for="Password">Password</label>
		<input class="form-control" type="password" name="password">
	</div>



	<div class="form-group">
		<label for="user_role">Role	<?php if(!empty($warn))	echo "<h6 style = 'color :red'>$warn</h6>";?></label>
		<select class="form-control" name = "user_role">
			<option selected value="">Select an Option</option>
			<option value="admin">Admin</option>
			<option value="subscriber">Subscriber</option>
		</select>
	</div>
	
	<div class="form-group">
		<label for="first_name">First Name</label>
		<input class="form-control" type="text" name="first_name">
	</div>
	
	<div class="form-group">
		<label for="last_name">Last Name</label>
		<input class="form-control" type="text" name="last_name">
	</div>
	
	<div class="form-group">
		<label for="image">Upload Image</label>
		<input class="form-control" type="file" name="user_image">
	</div>
	
	<div class="form-group">
		<label for="user_email">Email</label>
		<input class="form-control" type="text" name="user_email">
	</div>
	
	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="add_user" value="submit">
	</div>
</form>