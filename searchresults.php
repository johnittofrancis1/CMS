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

                    if(isset($_POST['submit']))
                    {
                        $searchtag = escape($_POST['searchtag']);
                        $query = "select * from posts_view where post_tags LIKE '%$searchtag%' AND post_status='published';";
                        $matched_posts = mysqli_query($connection,$query);
                        cnfrmQuery($matched_posts);

                        $count = mysqli_num_rows($matched_posts);
                        if($count == 0)
                            echo "<h1>No Results</h1>";
                        else
                        {
                            while($record = mysqli_fetch_assoc($matched_posts))
                            {
                                $post_title = $record['post_title'];
                                $post_author = $record['username'];
                                $post_date = $record['post_date'];
                                $post_image = $record['post_image'];
                                $post_content = $record['post_content'];


                ?>
                                <h2>
                                    <a href="#"> <?php echo $post_title;?> </a>
                                </h2>
                                <p class="lead">
                                    by <a href="author_posts.php?author_name=<?php echo $post_author?>"> <?php echo $post_author;?> </a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> Posted on  <?php echo $post_date;?> </p>
                                <hr>
                                <img class="img-responsive" src="images/<?php echo $post_image?>" alt="900*300">
                                <hr>
                                <p> <?php echo $post_content;?> </p>
                                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

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