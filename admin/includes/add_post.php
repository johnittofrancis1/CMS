<?php
	if(isset($_POST['add_post']))
	{
		$post_title = escape($_POST['title']);
		$post_category_id = escape($_POST['category_id']);
		$post_author_id = escape($_POST['author_id']);
		$post_tags = escape($_POST['tags']);
		$post_content = escape($_POST['content']);
		$post_date = date('d-m-y');

		$image = $_FILES['image']['name'];
		$temp_image = $_FILES['image']['tmp_name'];

		move_uploaded_file($temp_image,"../images/$image");

		$insert_query = "insert into posts (post_category_id,post_title,post_author_id,post_date,post_image,post_content,post_tags) ";
		$insert_query .= "values ($post_category_id,'$post_title',$post_author_id,'$post_date','$image','$post_content','$post_tags')";
		$result = mysqli_query($connection,$insert_query);
		cnfrmQuery($result);
		header("Location: ../admin/posts.php");
	}
?>


<form action="" method="POST" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input class="form-control" type="text" name="title">
	</div>

	<div class="form-group">
		<label for="category">Post Category Title</label>
		<select class="form-control" name = "category_id">
			<?php
					$query = "select * from categories";
					$all_categories = mysqli_query($connection,$query);
					cnfrmQuery($all_categories);


					while ($record = mysqli_fetch_assoc($all_categories)) {
						$cat_id = $record['cat_id'];
						$cat_title = $record['cat_title'];
						echo "<option value = {$cat_id} >$cat_title</option>";
					}
			?>
		</select>
	</div>
	
	<div class="form-group">
		<label for="author">Post Author</label>
		<select class="form-control" name = "author_id">
			<?php
					$query = "select * from users";
					$all_users = mysqli_query($connection,$query);
					cnfrmQuery($all_users);


					while ($record = mysqli_fetch_assoc($all_users)) {
						$user_id = $record['user_id'];
						$username = $record['username'];
						echo "<option value = {$user_id} >$username</option>";
					}
			?>
		</select>
	</div>
	
	<div class="form-group">
		<label for="tags">Post Tags</label>
		<input class="form-control" type="text" name="tags">
	</div>
	
	<div class="form-group">
		<label for="image">Upload Image</label>
		<input class="form-control" type="file" name="image">
	</div>
	
	<div class="form-group">
		<label for="content">Post Content</label>
		<textarea class="form-control" type="text" name="content" rows=10 cols=30></textarea> 
	</div>
	
	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="add_post" value="Publish Post">
	</div>
</form>