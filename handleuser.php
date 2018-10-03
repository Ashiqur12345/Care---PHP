<?php
include_once('Backend/_authcheck.php');
if(!authCheck()){header("Location: signin.php?msg=Sign in first&msgtype=warning");die();}
else if(getRoleID() != 2){
    header("Location: home.php?msg=Access denied&msgtype=danger");die();
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Handle Users</title>

    <?php include_once('cssreferences.php'); ?>
  </head>

  <body id="page-top" onload="showNotification();" class="sidebar-toggled">

    <?php include_once('navbar.php') ?>

    <div id="wrapper" class="sidebar-toggled">

    <?php include_once('sidebar.php') ?>

        <div id="content-wrapper">

            <div class="container-fluid">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Handle Users</li>
                </ol>

                <!-- Page Content -->
                <h1>Handle Users</h1>
                <hr>
                
                <div class="row">
                    <div class="col col-lg-8">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header">
                                    <a class="card-link" data-toggle="collapse" href="#collapseOne">Insert new Field</a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                    <div class="card-body">
                                        <form onsubmit="return(insertNewFieldSubmit());" name="insertfieldform">
                                        
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Field Name</span>
                                                </div>
                                                <input type="text" class="form-control" list="fieldnames" required onkeyup="fetchFieldNames(event);">
                                                
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Insert Field">                                  
                                        </form> 
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <datalist id="fieldnames"></datalist>
                <datalist id="diseasenames"></datalist>
                <datalist id="treatments"></datalist>
                <datalist id="doctornames"></datalist>
                <datalist id="locations"></datalist>
            </div>

            <!-- /.container-fluid -->
            <?php include_once('footer.php') ?>

        </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <?php include_once('jsreferences.php'); ?>

  </body>

</html>