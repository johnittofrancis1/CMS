<?php    include "includes/header.php"; 
         include "includes/db.php"; ?>

    <!-- Navigation -->
    <?php    include "includes/navigation.php" ?>



    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <?php

                    if($_GET['post_id'])
                    {
                        $post_id = $_GET['post_id'];

                        if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')
                        {
                            $query = "select * from posts_view where post_id = $post_id";
                            $the_post = mysqli_query($connection,$query);
                            cnfrmQuery($the_post);
                        }
                        else
                        {
                            $query = "select * from posts_view where post_id = $post_id AND post_status='published'";
                            $the_post = mysqli_query($connection,$query);
                            cnfrmQuery($the_post);

                            $view_count_query = "UPDATE posts_view SET post_views_count = post_views_count + 1 where post_id=$post_id";
                            $result = mysqli_query($connection,$view_count_query);
                            cnfrmQuery($result);
                        }

                        $count = mysqli_num_rows($the_post);

                        if($count == 0)
                        {
                            echo "<h1 class='text-center'>Sorry,This post is not available</h1>";
                        }
                        else
                        {
                            while($record = mysqli_fetch_assoc($the_post))
                            {
                                $post_title = $record['post_title'];
                                $post_author = $record['username'];
                                $post_date = $record['post_date'];
                                $post_image = $record['post_image'];
                                $post_content = $record['post_content'];

                            }
                ?>
                                <h2>
                                    <a href="#"> <?php echo $post_title;?> </a>
                                </h2>
                                <p class="lead">
                                    by <a href="author_posts.php?author_id=<?php echo $post_author_id?>"> <?php echo $post_author;?> </a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> Posted on  <?php echo $post_date;?> </p>
                                <hr>
                                <img class="img-responsive" src="images/<?php echo $post_image?>" alt="900*300">
                                <hr>
                                <p> <?php echo $post_content;?> </p>

                                <hr>

                                <!-- Pager -->
                                <ul class="pager">
                                    <li class="previous">
                                        <a href="#">&larr; Older</a>
                                    </li>
                                    <li class="next">
                                        <a href="#">Newer &rarr;</a>
                                    </li>
                                </ul>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                            <div class="well">
                    <?php
                        // Uploading the Comment
                            if (isset($_POST['add_comment'])) {

                                $post_id = $_GET['post_id'];
                                $comment_author = escape($_POST['comment_author']);
                                $comment_email = escape($_POST['comment_email']);
                                $comment_content = escape($_POST['comment_content']);
                                $comment_date = date('d-m-y');

                                if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content))
                                {

                                    $insert_query = "insert into comments (comment_post_id,comment_author,comment_email,comment_content,comment_date) ";
                                    $insert_query .= " values ( $post_id,'$comment_author','$comment_email','$comment_content',";
                                    $insert_query .= "'$comment_date' )";
                                    $result = mysqli_query($connection,$insert_query);
                                    cnfrmQuery($result);
                                    $increase_comment_count = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                                    $increase_comment_count .= "where post_id = $post_id";
                                    $result = mysqli_query($connection,$increase_comment_count);
                                    cnfrmQuery($result);
                                    
                                }
                                else
                                {

                                    ?>
                                        <script type="text/javascript">
                                            alert('Comment cannot be empty');
                                        </script>
                                    <?php

                                }
                                
                            }

                    ?>
                    <h4>Leave a Comment:</h4>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="comment_author">Your Name</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="comment_email">Your Email</label>
                            <input type="text" name="comment_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="comment_content">Your Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="add_comment" value="Submit">
                        </div>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
                    // display all comments for this post
                    $post_id = $_GET['post_id'];
                    $query = "select * from comments where comment_post_id = $post_id ";
                    $query .= "and comment_status ='approved' ";
                    $query .= "ORDER BY comment_date DESC ;";
                    $all_comments_forthis_post = mysqli_query($connection,$query);
                    cnfrmQuery($all_comments_forthis_post);

                    while($record = mysqli_fetch_assoc($all_comments_forthis_post))
                    {
                        $comment_author = $record['comment_author'];
                        $comment_email = $record['comment_email'];
                        $comment_content = $record['comment_content'];
                        $comment_date = $record['comment_date'];
                        $comment_status = $record['comment_status'];

                ?>
                            <!-- Comment -->
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object" src="http://placehold.it/64x64" alt="author-pic">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $comment_author ?>
                                        <small><?php echo $comment_date ?></small>
                                    </h4>
                                    <?php echo $comment_content ?>
                                </div>
                            </div>
            <?php
                            }
                        } 
                    }    
            ?>
            </div>

        <!-- Blog Sidebar Widgets Column -->
            <?php    include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->

<?php    include "includes/footer.php" ?>