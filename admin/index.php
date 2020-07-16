<?php include "includes/header.php";
    setDashboard_Active();
    
    $username = $_SESSION['username'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $user_role = $_SESSION['user_role'];
?>


    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome To Admin Page
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                </div>
                       
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                  <div class='huge'>
                                    
                                    <?php
                                        echo $no_posts = recordCount('posts');
                                    ?>

                                  </div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                     <div class='huge'>

                                    <?php
                                        echo $no_comments = recordCount('comments');
                                    ?>

                                     </div>
                                      <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'>

                                    <?php
                                        echo $no_users = recordCount('users');
                                    ?>

                                    </div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'>

                                    <?php
                                        echo $no_categories = recordCount('categories');
                                    ?>   

                                        </div>
                                         <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <?php
                    $no_draft_posts = recordCountforCriteria('posts','post_status','draft');

                    $no_pending_comments = recordCountforCriteria('comments','comment_status','unapproved');

                    $no_subscribers = recordCountforCriteria('users','user_role','subscriber');
                ?>


                <div class="row">

                    <script type="text/javascript">
                          google.charts.load('current', {'packages':['bar']});
                          google.charts.setOnLoadCallback(drawChart);

                          function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                              ['Data', 'Count'],

                              <?php
                                    $element_text = ['Active_Posts','Draft Posts','Comments','Pending Comments','Users','Subscribers','Categories'];
                                    $element_count = [$no_posts-$no_draft_posts,$no_draft_posts,$no_comments,
                                        $no_pending_comments,
                                        $no_users,$no_subscribers,$no_categories];

                                    for($i=0;$i<7;$i++)
                                    {
                                        echo "['$element_text[$i]',$element_count[$i]]";
                                        if($i!=6)
                                            echo ",";
                                    }   

                              ?>
                            ]);

                            var options = {
                              chart: {
                                title: '',
                                subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                              }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                          }
                </script>

                        <div id="columnchart_material" style="width: auto; height: 500px;"></div>
                </div>

            </div>  
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/footer.php" ?>
