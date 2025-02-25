<?php include "includes/header.php";
    setUsers_Active();

    if(!isAdmin($_SESSION['username']))
    {
        header("Location : index.php");
    }
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
                            <small>Johnitto Francis</small>
                        </h1>

                        <?php
                            if(isset($_GET['source']))
                            {
                                $source = $_GET['source'];
                            }
                            else
                                $source = '';

                            switch ($source) {
                                case 'all_users':
                                    include "includes/view_all_users.php";
                                    break;
                                case 'add_user':
                                    include "includes/add_user.php";
                                    break;
                                case 'edit_user':
                                    include "includes/edit_user.php";
                                    break;
                                default:
                                    include "includes/view_all_users.php";
                            }
                        ?>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/footer.php" ?>
