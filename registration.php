<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    


    <?php

        if(isset($_POST['register']))
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];


            if(!empty($username) && !empty($email) && !empty($password))
            {

                $username = escape($username);
                $password = escape($password);
                $email = escape($email);

                if(!usernameExists($username) && !emailExists($email))
                {

                    $password = password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));


                    $query = "INSERT INTO users(username,password,user_email) ";
                    $query .= "values ('$username','$password','$email')";
                    $result = mysqli_query($connection,$query);
                    cnfrmQuery($result);

                    $message = "Account Created";
                }
                else
                {
                    $message = "This Username or Email-Id already exists";
                }
            }
            else
            {
                $message = "Fields cannot be Empty";
            }
        }

    ?>
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <?php if(!empty($message)) echo "<h6 class='text-center' style='color:red'>$message</h6>";?>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" name="username" id="username" class="form-control" autocomplete="on" 
                            placeholder="Enter Desired Username" value="<?php echo isset($_POST['username']) ? $_POST['username']:'' ?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" autocomplete="on"
                            placeholder="somebody@example.com" value="<?php echo isset($_POST['email']) ? $_POST['email']:''?>" >
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
