<?php include "db.php" ?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <?php

                    $pagename = basename($_SERVER['PHP_SELF']);
                    $index_class = "";
                    $category_class = "";
                    $reg_class = "";
                    $contact_class = "";

                    switch($pagename)
                    {
                        case 'category.php': $category_class = "active";break;
                        case 'registration.php': $reg_class = "active";break;
                        case 'contact.php': $contact_class = "active";break;
                    }

                ?>

                <a class="navbar-brand" href="/CMS">Blog Site</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    
                    <?php

                        $query = "select * from categories";
                        $result = mysqli_query($connection,$query);

                        while ($record = mysqli_fetch_assoc($result)) {
                            $cat_id = $record['cat_id'];
                            $cat_title = $record['cat_title'];

                            if(isset($_GET['cat_id']) && $_GET['cat_id'] == $cat_id)
                                $category_class = "active";
                            else
                                $category_class = "";

                            echo "<li class='$category_class'><a href='category.php?cat_id=$cat_id'>$cat_title</a></li>";
                        }
                    ?>

                    <li><a href="admin">Admin</a></li>

                    <?php
                        if(isset($_GET['post_id']))
                        {
                            if(isset($_SESSION['user_role']))
                            {
                                $post_id = $_GET['post_id'];
                                echo $post_id;
                                echo "<li><a href=admin/posts.php?source=edit_post&edit=$post_id>Edit Post</a></li>";
                            }
                        }
                    ?>

                    <li class="<?php echo $reg_class ?>"><a href="registration.php">Registration</a></li>

                    <li class="<?php echo $contact_class ?>"><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>