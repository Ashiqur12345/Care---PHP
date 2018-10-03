<?php
include_once('Backend/_authcheck.php');
if(!authCheck()){header("Location: signin.php?msg=Sign in first&msgtype=warning");die();}

?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <?php include_once('cssreferences.php'); ?>
  </head>

  <body id="page-top" onload="showNotification();" class="sidebar-toggled">

    <?php include_once('navbar.php') ?>

    <div id="wrapper" class="sidebar-toggled">

    <?php include_once('sidebar.php') ?>

        <div id="content-wrapper">

            <div class="container-fluid">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>

                <!-- Page Content -->
                <h1>Admin Dashboard</h1>
                <hr>
                
                <div class="row">
                    
                    <div class="card-holder col col-lg-3 col-md-4 col-sm-6">                   
                        
                        <div class="card bg-light mb-3 shadow p-3 mb-5 bg-white rounded" style="min-height:10em; max-height:10em; min-width:14em;">
                            <div class="card-header">
                                <a href="dataentry.php"><i class="fas fa-list fa-fw"></i></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="dataentry.php">Data Entry</a></h5>
                            </div>
                        </div>
                        
                    </div>

                    <div class="card-holder col col-lg-3 col-md-4 col-sm-6">                   
                        
                        <div class="card bg-light mb-3 shadow p-3 mb-5 bg-white rounded" style="min-height:10em; max-height:10em; min-width:14em;">
                            <div class="card-header">
                                <a href="userhandle.php"><i class="fas fa-user fa-fw"></i></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="dataentry.php">User Handle</a></h5>
                            </div>
                        </div>
                        
                    </div>

                    <div class="card-holder col col-lg-3 col-md-4 col-sm-6">                   
                        
                        <div class="card bg-light mb-3 shadow p-3 mb-5 bg-white rounded" style="min-height:10em; max-height:10em; min-width:14em;">
                            <div class="card-header">
                                <a href="charts.php"><i class="fas fa-chart-area fa-fw"></i></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="dataentry.php">Charts</a></h5>
                            </div>
                        </div>
                        
                    </div>

                    <div class="card-holder col col-lg-3 col-md-4 col-sm-6">                   
                        
                        <div class="card bg-light mb-3 shadow p-3 mb-5 bg-white rounded" style="min-height:10em; max-height:10em; min-width:14em;">
                            <div class="card-header">
                                <a href="tables.php"><i class="fas fa-table fa-fw"></i></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="dataentry.php">Tables</a></h5>
                            </div>
                        </div>
                        
                    </div>

                </div>
                <!-- /.row -->
        
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

    <!-- Opening notification -->
    <script>

        function showNotification(){
            let msg = findGetParameter('msg');
            let msgtype = findGetParameter('msgtype');
            

            if(msg != null){
                 $.notify({
                    title: "",
                    message: msg
                },{
                    type: msgtype != null ? msgtype : 'info'
                });
            }                         
        }


        function findGetParameter(parameterName) {
            var result = null,
                tmp = [];
            location.search
                .substr(1)
                .split("&")
                .forEach(function (item) {
                tmp = item.split("=");
                if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                });
            return result;
        }
    </script>

  </body>

</html>