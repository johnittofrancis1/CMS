<?php include "includes/header.php";

    setCategories_Active();
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
                    </div>
                </div>
                <!-- /.row -->
                <div class="col-xs-6">

                    <?php
                        // add Category
                        if(isset($_POST['add_category']))
                        {

                            $cat_title = escape($_POST['cat_title']);
                            if ($cat_title == "" || empty($cat_title)) {
                                echo "<h6 style='color:red'>Enter a category Name</h6>";
                            }
                            else
                            {
                                $query = "insert into categories (cat_title) values ('{$cat_title}')";
                                $result = mysqli_query($connection,$query);
                                cnfrmQuery($result);
                            }
                            

                        }

                        // edit category
                        if(isset($_POST['edit_category']))
                        {
                            if(isset($_SESSION['user_role']))
                            {
                                if($_SESSION['user_role'] == 'admin')
                                {
                                    $cat_id = $_GET['edit'];
                                    $cat_title = escape($_POST['cat_title']);
                                    $query = "UPDATE categories SET cat_title='$cat_title' where cat_id=$cat_id";
                                    $result = mysqli_query($connection,$query);
                                    cnfrmQuery($result);
                                }
                            }
                        }

                        // delete category
                        if(isset($_POST['delete']))
                        {
                            if(isset($_SESSION['user_role']))
                            {
                                if($_SESSION['user_role'] == 'admin')
                                {
                                    $cat_id = $_POST['cat_id'];
                                    $query = "DELETE FROM categories where cat_id=$cat_id";
                                    $result = mysqli_query($connection,$query);
                                    cnfrmQuery($result);

                                    header("LOCATION = categories.php");
                                }
                            }
                        } 


                    ?>


                    <form action="" method ="POST">
                        <div class="form-group">
                            <label for ="cat_title">Add Category</label>
                            <input class="form-control" type="text" name="cat_title">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="add_category">
                        </div>
                    </form>
                    <?php
                            // Category Edit Form Display
                            if(isset($_GET['edit']))
                            {
                                $cat_id = $_GET['edit'];
                                $query = "SELECT * from categories WHERE cat_id=$cat_id";
                                $matched_cat = mysqli_query($connection,$query);
                                if(!$matched_cat)
                                    die("Query Failed ".mysqli_error());
                                while($record = mysqli_fetch_assoc($matched_cat))
                                {
                                    $cat_title = $record['cat_title'];
                                }

                                echo "<form action='' method ='POST'>";
                                echo "<div class='form-group'>";
                                echo "<label for ='cat_title'>Edit Category</label>";
                                echo "<input class='form-control' type='text' value=$cat_title name='cat_title'>";
                                echo "</div>";
                                echo "<div class='form-group'>";
                                echo "<input class='btn btn-primary' type='submit' name='edit_category'>";
                                echo "</div>";
                                echo "</form>";
                            }


                    ?>
                                    
                </div>

                <div class="col-xs-6">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <td>Id</td>
                            <td>Category Title</td>
                            <td colspan="2">Operations</td>
                        </thead>

                        <?php
                                    $query = "select * from categories";
                                    $result = mysqli_query($connection,$query);

                                    if(!$result)
                                        echo "SQL Error ".mysqli_error();
                                    while (($record = mysqli_fetch_assoc($result))) {
                                        $cat_id = $record['cat_id'];
                                        $cat_title = $record['cat_title'];

                                        echo "<tr>";
                                        echo "<td>{$cat_id}</td>";
                                        echo "<td>{$cat_title}</td>";
                                        echo "<td class='text-center'><a class='btn btn-primary' href='?edit={$record['cat_id']}'>Edit
                                                </a></td>";
                         ?>
                                    <form action="" method="POST">
                                        <input type="hidden" name="cat_id" value="<?php echo $cat_id ?>"> 
                                        <td class="text-center">
                                            <input onClick=
                                            "javascript: return confirm('Are you sure you want to delete this Category');" 
                                            class="btn btn-danger" type="submit" name="delete" value="Delete">
                                        </td>
                                    </form>
                        <?php
                                        echo "</tr>";
                                    }
                        ?>


                    </table>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/footer.php" ?>
