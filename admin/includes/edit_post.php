<?php

	if(isset($_POST['update_post']))
	{
		$post_id = $_GET['edit'];
		$post_title = escape($_POST['title']);
		$post_category_id = escape($_POST['category_id']);
		$post_author_id = escape($_POST['author_id']);
		$post_tags = escape($_POST['tags']);
		$post_content = escape($_POST['content']);
		$post_status = escape($_POST['post_status']);
		$post_date = date('d-m-y');

		$image = $_FILES['image']['name'];
		$temp_image = $_FILES['image']['tmp_name'];

		move_uploaded_file($temp_image,"../images/$image");

		$update_query = "UPDATE posts SET post_category_id = $post_category_id,";
		$update_query .= "post_title = '$post_title',";
		$update_query .= "post_author_id = $post_author_id,";
		$update_query .= "post_date = '$post_date',";
		if(!(empty($image) || $image == ''))
		{
			$update_query .= "post_image = '$image',";
		}
		$update_query .= "post_content = '$post_content' ,";
		$update_query .= "post_tags = '$post_tags',";
		$update_query .= "post_status = '$post_status' ";
		$update_query .= "where post_id = $post_id";
		$result = mysqli_query($connection,$update_query);
		cnfrmQuery($result);
		echo "<p class='bg-success'>Post Updated. <a href='../post.php?post_id={$post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
	}

	if(isset($_POST['reset_views_count']))
	{
		$post_id = $_GET['edit'];

		$reset_query = "UPDATE posts SET post_views_count = 0 where post_id = $post_id";
		$result = mysqli_query($connection,$reset_query);
		cnfrmQuery($result);
	}
?>

<?php 
	// display Post's Values
	if(isset($_GET['edit']))
	{
		$post_id = $_GET['edit'];
		$query = "select * from posts where post_id=$post_id";
		$result = mysqli_query($connection,$query);
		cnfrmQuery($query);

		while ($record = mysqli_fetch_assoc($result)) {
			$post_id = $record['post_id'];
            $post_category_id = $record['post_category_id'];
            $post_title = $record['post_title'];
            $post_author_id = $record['post_author_id'];
            $post_date = $record['post_date'];
            $post_image = $record['post_image'];
            $post_content = $record['post_content'];
            $post_status = $record['post_status'];
            $post_tags = $record['post_tags'];
            $post_comments = $record['post_comment_count'];
?>

<form action="" method="POST" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input class="form-control" type="text" name="title" value="<?php echo $post_title ?>">
	</div>

	<div class="form-group">
		<input class="btn btn-success" type="submit" name="reset_views_count" value="Reset View Count">
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
						if($cat_id == $post_category_id)
							echo "<option selected value = {$cat_id} >$cat_title</option>";
						else
							echo "<option value=$cat_id>$cat_title</option>";
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
						if($user_id == $post_author_id)
							echo "<option selected value = {$user_id} >$username</option>";
						else
							echo "<option value = {$user_id} >$username</option>";
					}
			?>
		</select>
	</div>
	
	<div class="form-group">
		<label for="tags">Post Tags</label>
		<input class="form-control" type="text" name="tags" value="<?php echo $post_tags ?>">
	</div>
	
	<div class="form-group">
		<img alt=" No image" width="300" class="image-responsive" src="../images/<?php echo $post_image ?>">
	</div>

	<div class="form-group">
		<label for="image">Change Image</label>
		<input class="form-control" type="file" name="image">
	</div>
	
	<div class="form-group">
		<label for="content">Post Content</label>
		<textarea class="form-control" type="text" name="content" rows=10 cols=30><?php echo $post_content ?></textarea> 
	</div>
	
	<div class="form-group">
		<label for="tags">Post Status</label>
		<select class="form-control" name = "post_status">
			<option value="draft" <?php if($post_status=="draft") echo "selected"; ?> >Draft</option>
			<option value="published" <?php if($post_status=="published") echo "selected"; ?>>Published</option>
		</select>
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
	</div>
</form>
<?php
		}
	}
?>