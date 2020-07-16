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

                    $per_page = 5;

                    $query = "SELECT * from posts where post_status='published'";
                    $all_posts = mysqli_query($connection,$query);
                    cnfrmQuery($all_posts);
                    $num_posts = mysqli_num_rows($all_posts);

                    if($num_posts == 0)
                    {
                        echo "<h1 class='text-center'>Sorry,No posts available</h1>";
                    }
                    else
                    {
                        $no_pages = ceil($num_posts / $per_page);

                        if(isset($_GET['page']))
                        {
                            $page = $_GET['page'];
                        }
                        else
                            $page = 1;

                        $post_offset = ($page - 1) * $per_page;
                        $query = "select * from posts_view where post_status='published' LIMIT $post_offset,$per_page";
                        $all_posts = mysqli_query($connection,$query);

                        while($record = mysqli_fetch_assoc($all_posts))
                        {
                            $post_id = $record['post_id'];
                            $post_title = $record['post_title'];
                            $post_author = $record['username'];
                            $post_date = $record['post_date'];
                            $post_image = $record['post_image'];
                            $post_content = $record['post_content'];
                ?>
                <h2>
                    <a href="post.php?post_id=<?php echo $post_id?>"> <?php echo $post_title;?> </a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author_id=<?php echo $post_author_id?>"> <?php echo $post_author;?> </a>
                </p>
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

                <?php } ?>

            <!-- Page Links -->
            <ul class="pager">    
                <?php
                    for($i=1;$i<=$no_pages;$i++)
                    {
                        if($i == $page)
                        {
                ?>
                            <li>
                                <a class="active_page" href=?page=<?php echo $i ?> ><?php echo $i ?></a>
                            </li>
                <?php
                        }
                        else
                        {
                ?>
                            <li>
                                <a href=?page=<?php echo $i ?> ><?php echo $i ?></a>
                            </li>
            <?php        
                        }   
                    }
                }
            ?>
            </ul>

            </div>

            

            <!-- Blog Sidebar Widgets Column -->
            <?php    include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->

<?php    include "includes/footer.php" ?>