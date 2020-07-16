<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    


    <?php

        if(isset($_POST['submit']))
        {
            $mail = escape($_POST['mail']);
            $subject = $_POST['subject'];
            $body = $_POST['message'];

            mail("johnittofrancis46@gmail.com",$subject,$body." from ".$mail);

            $message = "Your mail has been sent";
        }

    ?>
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <?php if(!empty($message)) echo "<h6 style='color:red'>$message</h6>";?>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">Email</label>
                            <input type="email" name="mail" id="username" class="form-control" placeholder="Enter Your Mail">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="email" class="form-control" placeholder="Enter your subject">
                        </div>
                         <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                            <textarea class="form-control" name="message">
                            </textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
