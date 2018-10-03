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

    <title>Home</title>

    <?php include_once('cssreferences.php'); ?>
  </head>

  <body id="page-top" onload="showNotification();" class="sidebar-toggled">

    <?php include_once('navbar.php') ?>

    <div id="wrapper" class="sidebar-toggled">

    <?php include_once('sidebar.php') ?>

        <div id="content-wrapper">

            <div class="container-fluid">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                </ol>

                <!-- Page Content -->
                <h1>Services</h1>
                <hr>
                
                <div class="row">
                    
                    <div class="card-holder col col-lg-4 col-md-6 col-sm-12">                   
                        
                        <div class="card bg-light mb-3 shadow p-3 mb-5 bg-white rounded" style="min-height:17em; max-height:20em; min-width:15em;">
                            <div class="card-header">
                                <a href="emergency.php"><i class="fas fa-ambulance fa-fw emergency"></i></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="emergency.php">Medical Emergency</a></h5>
                                <p class="card-text">Call for emergency services</p>
                            </div>
                            <div class="card-footer text-right">
                                <a href="">Learn More</a>
                            </div>
                        </div>
                        
                    </div>

                                        
                    <div class="card-holder col col-lg-4 col-md-6 col-sm-12">                   
                        
                        <div class="card bg-light mb-3 shadow p-3 mb-5 bg-white rounded" style="min-height:17em; max-height:17em; min-width:15em;">
                            <div class="card-header">
                                <a href="smileybot.php"><i class="fas fa-stethoscope fa-fw bot"></i></a>
                                
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="smileybot.php">Smiley Bot</a></h5>
                                <p class="card-text">Preliminary disease detection from feelings and symptoms</p>
                            </div>
                            <div class="card-footer text-right">
                                <a href="">Learn More</a>
                            </div>
                        </div>
                        
                    </div>
                                        
                    <div class="card-holder col col-lg-4 col-md-6 col-sm-12">                   
                        
                        <div class="card bg-light mb-3 shadow p-3 mb-5 bg-white rounded" style="min-height:17em; max-height:17em; min-width:15em;">
                            <div class="card-header">
                                <a href="finddoctor.php"><i class="fas fa-user-md fa-fw doctor"></i></a>
                                
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="finddoctor.php">Find Doctor</a></h5>
                                <p class="card-text">Find appropriate doctors</p>
                            </div>
                            <div class="card-footer text-right">
                                <a href="">Learn More</a>
                            </div>
                        </div>
                        
                    </div>

                    <div class="card-holder col col-lg-4 col-md-6 col-sm-12">                   
                        
                        <div class="card bg-light mb-3 shadow p-3 mb-5 bg-white rounded" style="min-height:17em; max-height:17em; min-width:15em;">
                            <div class="card-header">
                                <a href="firstaidkit.php"><i class="fas fa-first-aid fa-fw aid"></i></a>
                                
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="firstaidkit.php">First Aid Kit</a></h5>
                                <p class="card-text">Buy first aid kits to tackle emergency situations</p>                                
                            </div>
                            <div class="card-footer text-right">
                                <a href="">Learn More</a>
                            </div>
                        </div>
                        
                    </div>
                                        
                    <div class="card-holder col col-lg-4 col-md-6 col-sm-12">                   
                        
                        <div class="card bg-light mb-3 shadow p-3 mb-5 bg-white rounded" style="min-height:17em; max-height:17em; min-width:15em;">
                            <div class="card-header">
                                <a href="lifeline.php"><i class="fas fa-history fa-fw history"></i></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="lifeline.php">Lifeline</a></h5>
                                <p class="card-text">Store and manage your medical records</p>
                            </div>
                            <div class="card-footer text-right">
                                <a href="">Learn More</a>
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

  </body>

</html>