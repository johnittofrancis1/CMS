
                            <?php
                                // Delete post
                                if(isset($_POST['delete']))
                                {
                                    if(isset($_SESSION['user_role']))
                                    {
                                        if($_SESSION['user_role'] == 'admin')
                                        {
                                            $comment_id = $_POST['comment_id'];
                                            $query = "DELETE FROM comments where comment_id=$comment_id";
                                            $result = mysqli_query($connection,$query);
                                            cnfrmQuery($result);
                                        }
                                    }
                                }

                                // Approve post
                                if(isset($_GET['approve']))
                                {
                                    if(isset($_SESSION['user_role']))
                                    {
                                        if($_SESSION['user_role'] == 'admin')
                                        {
                                            $comment_id = $_GET['approve'];
                                            $query = "UPDATE comments SET comment_status = 'approved' where comment_id=$comment_id";
                                            $result = mysqli_query($connection,$query);
                                            cnfrmQuery($result);
                                        }
                                    }
                                }

                                // Unapprove post
                                if(isset($_GET['unapprove']))
                                {
                                    if(isset($_SESSION['user_role']))
                                    {
                                        if($_SESSION['user_role'] == 'admin')
                                        {
                                            $comment_id = $_GET['unapprove'];
                                            $query = "UPDATE comments SET comment_status = 'unapproved' where comment_id=$comment_id";
                                            $result = mysqli_query($connection,$query);
                                            cnfrmQuery($result);
                                        }
                                    }
                                }

                                $query = "select * from posts";
                                $all_posts = mysqli_query($connection,$query);

                                while($row = mysqli_fetch_assoc($all_posts))
                                {
                                    $post_id = $row['post_id'];
                                    $post_title = $row['post_title'];

                                    $query = "select * from comments WHERE comment_post_id=$post_id";
                                    $all_comments_foreach_post = mysqli_query($connection,$query);

                                    if(mysqli_num_rows($all_comments_foreach_post) != 0)
                                    {
                                        echo "<h3 class='page-header'>
                                                    <small>In Response to : </small>
                                                    <a href=../post.php?post_id=$post_id target='_blank'> $post_title </a>
                                             </h3>";
                            ?>
                            
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <td>Id</td>
                                    <td>Author</td>
                                    <td>Email</td>
                                    <td>Content</td>
                                    <td>Date Created</td>
                                    <td>Status</td>
                                    <td colspan="2" style="text-align: center">Operations</td>
                                </thead>
                            <?php        
                                        while($record = mysqli_fetch_assoc($all_comments_foreach_post))
                                        {
                                            $comment_id = $record['comment_id'];
                                            $comment_author = $record['comment_author'];
                                            $comment_email = $record['comment_email'];
                                            $comment_content = $record['comment_content'];
                                            $comment_date = $record['comment_date'];
                                            $comment_status = $record['comment_status'];

                                            if($comment_status == "unapproved")
                                                $appr_op = "approve";
                                            else
                                                $appr_op = "unapprove";

                                            $comment_status = ucfirst($comment_status);
                                            echo "<tr>";
                                            echo "<td>$comment_id</td>";
                                            echo "<td>$comment_author</td>";
                                            echo "<td>$comment_email</td>";
                                            echo "<td>$comment_content</td>";
                                            echo "<td>$comment_date</td>";
                                            echo "<td>$comment_status</td>";
                                            echo "<td class='text-center'><a class='btn btn-success' href=?$appr_op=$comment_id>$appr_op</a></td>";
                            ?>
                                    <form action="" method="POST">
                                        <input type="hidden" name="comment_id" value="<?php echo $comment_id ?>"> 
                                        <td class="text-center">
                                            <input  class="btn btn-danger" type="submit" name="delete" value="Delete">
                                        </td>
                                    </form>
                            <?php
                                            echo "</tr>";
                                        }
                            ?>
                            </table>
                            <?php
                                    }
                                }
                            ?>