<?php

    include "deletemodal.php";
    
    if(isset($_POST['apply']))
    {
        $bulk_action = $_POST['bulk_action'];

        if(isset($_POST['checkboxArray']))
        {
            $checkboxArray = $_POST['checkboxArray'];

            foreach ($checkboxArray as $post_id) {

                switch($bulk_action)
                {
                    case 'publish':
                    {
                        $query = "UPDATE posts SET post_status='published' where post_id = $post_id";
                        $result  = mysqli_query($connection,$query);
                        cnfrmQuery($result);
                        break;
                    }

                    case 'draft':
                    {
                        $query = "UPDATE posts SET post_status='draft' where post_id = $post_id";
                        $result  = mysqli_query($connection,$query);
                        cnfrmQuery($result);
                        break;
                    }

                    case 'delete':
                    {
                        $query = "DELETE FROM posts where post_id = $post_id";
                        $result  = mysqli_query($connection,$query);
                        cnfrmQuery($result);

                        $delete_comments_query = "DELETE FROM comments where comment_post_id = $post_id";
                        $result = mysqli_query($connection,$delete_comments_query);
                        cnfrmQuery($result);

                        break;
                    }

                    case 'clone':
                    {
                        $query = "SELECT * from posts where post_id=$post_id";
                        $result = mysqli_query($connection,$query);
                        cnfrmQuery($result);

                        while($record = @mysqli_fetch_assoc($result))
                        {
                            $post_category_id = $record['post_category_id'];
                            $post_title = $record['post_title'];
                            $post_author_id = $record['post_author_id'];
                            $post_content = $record['post_content'];
                            $post_image = $record['post_image'];
                            $post_status = $record['post_status'];
                            $post_date = date('d-m-y');
                            $post_tags = $record['post_tags'];

                            $clone_query = "INSERT INTO posts (post_category_id,post_title,post_author_id,post_date,post_image,";
                            $clone_query .= "post_content,post_status,post_tags) ";
                            $clone_query .= "values ($post_category_id,'$post_title',$post_author_id,'$post_date','$post_image',";
                            $clone_query .= "'$post_content','$post_status','$post_tags')"; 

                            $result = mysqli_query($connection,$clone_query);
                            cnfrmQuery($result);
                        }

                        break;
                    }

                }

            }
        }
    }

?>
















                    <form action="" method="POST">
                        <div id="bulkOptionContainer" style="padding: 0px" class="col-xs-4">
                                <select class="form-control" name="bulk_action">
                                    <option selected>Select an Option</option>
                                    <option value="publish">Publish</option>
                                    <option value="draft">Draft</option>
                                    <option value="delete">Delete</option>
                                    <option value="clone">Clone</option>
                                </select>
                        </div>

                        <div class="col-xs-4">
                                <input class="btn btn-success" type="submit" name="apply" value="Apply">
                            
                                <a class="btn btn-primary" href="?source=add_post">Add a Post</a>
                        </div>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <td><input type="checkbox" id="selectall">
                                <td>Id</td>
                                <td>Category</td>
                                <td>Title</td>
                                <td>Author</td>
                                <td>Content</td>
                                <td>Date Created</td>
                                <td>Image</td>
                                <td>Tags</td>
                                <td>Comments</td>
                                <td>Status</td>
                                <td colspan="3" style="text-align: center;">Operations</td>
                                <td>Views</td>
                            </thead>
                            <?php
                                // Delete post
                                if(isset($_POST['delete']))
                                {
                                    if(isset($_SESSION['user_role']))
                                    {
                                        if($_SESSION['user_role'] == 'admin')
                                        {
                                            $post_id = $_POST['post_id'];
                                            $query = "DELETE FROM posts where post_id=$post_id";
                                            $result = mysqli_query($connection,$query);
                                            cnfrmQuery($result);

                                            $delete_comments_query = "DELETE FROM comments where comment_post_id = $post_id";
                                            $result = mysqli_query($connection,$delete_comments_query);
                                            cnfrmQuery($result);
                                        }
                                    }
                                }

                                if(isset($_GET['draft']))
                                {
                                    if(isset($_SESSION['user_role']))
                                    {
                                        if($_SESSION['user_role'] == 'admin')
                                        {
                                            $post_id = $_GET['draft'];
                                            $query = "UPDATE posts SET post_status='draft' where post_id=$post_id";
                                            $result = mysqli_query($connection,$query);
                                            cnfrmQuery($result);
                                        }
                                    }
                                }

                                if(isset($_GET['publish']))
                                {
                                    if(isset($_SESSION['user_role']))
                                    {
                                        if($_SESSION['user_role'] == 'admin')
                                        {
                                            $post_id = $_GET['publish'];
                                            $query = "UPDATE posts SET post_status='published' where post_id=$post_id";
                                            $result = mysqli_query($connection,$query);
                                            cnfrmQuery($result);
                                        }
                                    }
                                }


                                    $query = "SELECT * FROM posts_view ORDER BY post_id DESC";
                                    $all_posts = mysqli_query($connection,$query);
                                    cnfrmQuery($all_posts);

                                    while($record = mysqli_fetch_assoc($all_posts))
                                    {
                                        $post_id = $record['post_id'];
                                        $cat_title = $record['cat_title'];
                                        $post_title = $record['post_title'];
                                        $post_author = $record['username'];
                                        $post_date = $record['post_date'];
                                        $post_image = $record['post_image'];
                                        $post_content = substr($record['post_content'],0,50);
                                        $post_status = $record['post_status'];
                                        $post_tags = $record['post_tags'];
                                        $post_comments = $record['post_comment_count'];
                                        $post_views_count = $record['post_views_count'];

                                        if($post_status == 'draft')
                                            $change_status = 'publish';
                                        else if($post_status == 'published')
                                            $change_status = 'draft';

                                        $cap_change_status = ucfirst($change_status);

                                        
                                        echo "<tr>";
                            ?>
                                        <td><input class="checkBoxes" type="checkbox" name="checkboxArray[]" value="<?php echo $post_id ?>"></td>
                            <?php
                                        echo "<td>$post_id</td>";
                                        echo "<td>$cat_title</td>";
                                        echo "<td><a href=../post.php?post_id=$post_id target=_blank>$post_title</a></td>";
                                        echo "<td>$post_author</td>";
                                        echo "<td>$post_content</td>";
                                        echo "<td>$post_date</td>";
                                        echo "<td><img class='img-responsive' src='../images/$post_image'/></td>";
                                        echo "<td>$post_tags</td>";
                                        echo "<td>$post_comments</td>";
                                        echo "<td>$post_status</td>";
                                        echo "<td class='text-center'><a class='btn btn-success' onClick=
                                        \"javascript: return confirm('Are you sure you want to $cap_change_status this Post');\" 
                                         href=?$change_status=$post_id>$cap_change_status</a></td>";
                                        echo "<td><a class='btn btn-primary' href=?source=edit_post&edit=$post_id>Edit</a></td>";
                                        // echo "<td><a onClick=
                                        // \"javascript: return confirm('Are you sure you want to delete this Post');\"  href=?delete=$post_id>Delete</a></td>";
                                        //echo "<td><a class='delete_link' rel='$post_id'>Delete</a></td>";
                            ?>
                                    <form action="" method="POST">
                                       <input type="hidden" name="post_id" value="<?php echo $post_id ?>"> 
                                        <td class="text-center">
                                            <input onClick=
                                            "javascript: return confirm('Are you sure you want to delete this Post');"" class="btn btn-danger" type="submit" name="delete" value="Delete">
                                        </td>
                                    </form>
                            <?php
                                        echo "<td>$post_views_count</td>";
                                        echo "</tr>";
                                    }
                            ?>
                        </table>
                    </form>

<!-- <script type="text/javascript">
    
    $(".delete_link").on("click",function()
    {
        var id = $(this).attr("rel");

        var delete_url = "posts.php?delete="+id+"";

        $(".modal_delete_link").attr("href",delete_url);

        $("#myModal").modal('show');
    });

</script> -->