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

                    if(isset($_GET['author_id']))
                    {
                        $author_id = $_GET['author_id'];
                        $query = "select * from posts where post_status='published' and post_author_id='$author_id'";
                        $all_posts_byauthor = mysqli_query($connection,$query);
                        cnfrmQuery($all_posts_byauthor);

                        $num_posts = mysqli_num_rows($all_posts_byauthor);

                        if($num_posts == 0)
                        {
                            echo "<h1 class='text-center'>Sorry,No posts available</h1>";
                        }
                        else
                        {

                            while($record = mysqli_fetch_assoc($all_posts_byauthor))
                            {
                                $post_id = $record['post_id'];
                                $post_title = $record['post_title'];
                                $post_date = $record['post_date'];
                                $post_image = $record['post_image'];
                                $post_content = $record['post_content'];

                ?>
                            <h2>
                                <a href="post.php?post_id=<?php echo $post_id?>"> <?php echo $post_title;?> </a>
                            </h2>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on  <?php echo $post_date;?> </p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_image?>" alt="900*300">
                            <hr>
                            <p> <?php echo substr($post_content,0,100);?> </p>
                            <a class="btn btn-primary" href="post.php?post_id=<?php echo$post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

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