            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="searchresults.php" method="POST">
                        <div class="input-group">
                            <input type="text" name="searchtag" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default" name="submit" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                    
                    <!-- /.input-group -->
                </div>

                <div class="well">
                    <?php
                        if(isset($_POST['login']))
                        {
                            $username = escape($_POST['username']);
                            $password = escape($_POST['password']);

                            $username = mysqli_real_escape_string($connection,$username);
                            $password = mysqli_real_escape_string($connection,$password);

                            $query = "select * from users where username = '$username';";
                            $result = mysqli_query($connection,$query);
                            cnfrmQuery($result);

                            $no_rows = mysqli_num_rows($result);
                            if($no_rows == 0)
                                $warn = "No such Username";
                            else
                            {
                                while($record = mysqli_fetch_assoc($result))
                                {
                                    $first_name = $record['first_name'];
                                    $last_name = $record['last_name'];
                                    $user_role = $record['user_role'];
                                    $db_password = $record['password'];
                                    
                                    if($user_role == "subscriber")
                                        $warn = "You are not allowed to enter Admin Page";
                                    else if(password_verify($password,$db_password))
                                    {
                                        $_SESSION['username'] = $username;
                                        $_SESSION['first_name'] = $first_name;
                                        $_SESSION['last_name'] = $last_name;
                                        $_SESSION['user_role'] = $user_role;

                                        header("Location: admin/index.php");
                                    }
                                    else
                                    {
                                        $warn = "Incorrect Username or Password";
                                    }
                                }
                            }
                        }
                    ?>
                    <?php if(isset($_SESSION['username'])): ?>

                        <h3>Logged in as <?php echo $_SESSION['username']?></h3>
                        <a href="admin/includes/logout.php" class="btn btn-danger">Logout</a>
                    <?php else: ?>

                        <h4>Login</h4>
                        <?php if(!empty($warn)) echo "<h6 style='color:red'>$warn</h6>";?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="text" name="username" placeholder="Enter Username" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="Password" name="password" placeholder="Enter Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="login" value="Login" class="btn btn-primary">
                            </div>
                        </form>

                    <?php endif; ?>    

                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <?php

                                    $query = "select * from categories";
                                    $result = mysqli_query($connection,$query);
                                    cnfrmQuery($result);

                                    $count_rows = mysqli_num_rows($result);
                                    if($count_rows % 2 ==0)
                                        $mid = ceil($count_rows/2);
                                    else
                                        $mid = floor($count_rows/2) + 1;
                                    $offset = 0;

                                    $query = "select * from categories LIMIT $offset,$mid";
                                    $result = mysqli_query($connection,$query);
                                    cnfrmQuery($result);

                                    while (($record = mysqli_fetch_assoc($result))) {
                                        $cat_id = $record['cat_id'];
                                        $category_title = $record['cat_title'];

                                        echo "<li><a href='category.php?cat_id=$cat_id'>$category_title</a></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <?php
                                    $offset = $mid;
                                    $query = "select * from categories LIMIT $offset,$mid";
                                    $result = mysqli_query($connection,$query);

                                    if(!$result)
                                        echo "SQL Error ".mysqli_error($connection);

                                    while ($record = mysqli_fetch_assoc($result)) {
                                        $cat_id = $record['cat_id'];
                                        $category_title = $record['cat_title'];

                                        echo "<li><a href='category.php?cat_id=$cat_id'>$category_title</a></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "includes/widget.php" ?>

            </div>