
                        <table class="table table-bordered table-hover">
                            <thead>
                                <td>Id</td>
                                <td>Image</td>
                                <td>UserName</td>
                                <td>First Name</td>
                                <td>Last Name</td>
                                <td>Email</td>
                                <td>Role</td>
                                <td colspan="3" style="text-align: center;">Operations</td>
                            </thead>
                            <?php
                                // Delete post
                                if(isset($_POST['delete']))
                                {
                                    if(isset($_SESSION['user_role']))
                                    {
                                        if($_SESSION['user_role'] == 'admin')
                                        {
                                            $user_id = $_POST['user_id'];
                                            $query = "DELETE FROM users where user_id=$user_id";
                                            $result = mysqli_query($connection,$query);
                                            cnfrmQuery($result);
                                        }
                                    }
                                }

                                // make the user - admin
                                if(isset($_GET['admin']))
                                {
                                    if(isset($_SESSION['user_role']))
                                    {
                                        if($_SESSION['user_role'] == 'admin')
                                        {
                                            $user_id = $_GET['admin'];
                                            $query = "UPDATE users SET user_role='admin' where user_id=$user_id";
                                            $result = mysqli_query($connection,$query);
                                            cnfrmQuery($result);
                                        }
                                    }
                                }

                                // make the user - subscriber
                                if(isset($_GET['subscriber']))
                                {
                                    if(isset($_SESSION['user_role']))
                                    {
                                        if($_SESSION['user_role'] == 'admin')
                                        {
                                            $user_id = $_GET['subscriber'];
                                            $query = "UPDATE users SET user_role='subscriber' where user_id=$user_id";
                                            $result = mysqli_query($connection,$query);
                                            cnfrmQuery($result);
                                        }
                                    }
                                }



                                $query = "select * from users";
                                $all_users = mysqli_query($connection,$query);

                                while($record = mysqli_fetch_assoc($all_users))
                                {
                                    $user_id = $record['user_id'];
                                    $username = $record['username'];
                                    $first_name = $record['first_name'];
                                    $last_name = $record['last_name'];
                                    $email = $record['user_email'];
                                    $user_image = $record['user_image'];
                                    $user_role = $record['user_role'];

                                    if($user_role == "admin")
                                        $role_change = "subscriber";
                                    else if($user_role == "subscriber")
                                        $role_change = "admin";

                                    $user_role = ucfirst($user_role);
                                    $cap_role_change = ucfirst($role_change);

                                    echo "<tr>";
                                    echo "<td>$user_id</td>";
                                    echo "<td><img class='img-responsive' src='../images/$user_image' width='100'/></td>";
                                    echo "<td>$username</td>";
                                    echo "<td>$first_name</td>";
                                    echo "<td>$last_name</td>";
                                    echo "<td>$email</td>";
                                    echo "<td>$user_role</td>";
                                    echo "<td class='text-center'><a class='btn btn-success' onClick=
                                    \"javascript: return confirm('Are you sure you want to make this User - $cap_role_change');\"  href=?$role_change=$user_id>$cap_role_change</a></td>";
                                    echo "<td class='text-center'><a class='btn btn-primary' href=?source=edit_user&user_id=$user_id>Edit</a></td>";
                            ?>
                                    <form action="" method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>"> 
                                        <td class="text-center">
                                            <input onClick=
                                            "javascript: return confirm('Are you sure you want to delete this User');" class="btn btn-danger" type="submit" name="delete" value="Delete">
                                        </td>
                                    </form>
                            <?php
                                    echo "</tr>";
                                }
                            ?>
                        </table>