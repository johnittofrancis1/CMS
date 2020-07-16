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
                    if($_GET['cat_id'])
                    {
                        $cat_id = $_GET['cat_id'];
                        $query = "select * from posts where post_category_id = $cat_id and post_status='published'";
                        $all_posts = mysqli_query($connection,$query);
                        cnfrmQuery($all_posts);

                        $num_posts = mysqli_num_rows($all_posts);

                        if($num_posts == 0)
                        {
                            echo "<h1 class='text-center'>Sorry,No posts available</h1>";
                        }
                        else
                        {

                            while($record = mysqli_fetch_assoc($all_posts))
                            {
                                $post_id = $record['post_id'];
                                $post_title = $record['post_title'];
                                $post_author_id = $record['post_author_id'];
                                $post_date = $record['post_date'];
                                $post_image = $record['post_image'];
                                $post_content = $record['post_content'];
            
                                $author_query = "select * from users where user_id=$post_author_id";
                                $matched_usernames = mysqli_query($connection,$author_query);

                                while ($row = mysqli_fetch_assoc($matched_usernames)) {
                                    $post_author = $row['username'];
                                }
                ?>
                                <h2>
                                    <a href="post.php?post_id=<?php echo $post_id?>"> <?php echo $post_title;?> </a>
                                </h2>
                                <p class="lead">
                                    by <a href="index.php"> <?php echo $post_author;?> </a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> Posted on  <?php echo $post_date;?> </p>
                                <hr>
                                <img class="img-responsive" src="images/<?php echo $post_image?>" alt="900*300">
                                <hr>
                                <p> <?php echo $post_content;?> </p>
                                <a class="btn btn-primary" href="?post_id=<?php echo$post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

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