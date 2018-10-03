<?php
include_once('Backend/_authcheck.php');
if(!authCheck()){header("Location: signin.php?msg=Sign in first&msgtype=warning");die();}

$targetUserID = getUserID();

if(getRoleID() == 2){
    if(isset($_GET['userid'])){
        $targetUserID = $_GET['userid'];
    }
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

    <title>Lifeline</title>

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
                        <a href="home.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Lifeline</li>
                </ol>

                <!-- Page Content -->
                <h1>Lifeline</h1>
                <hr>
                <?php 
                    if(getRoleID() == 2){
                ?>
                <div class="row">
                    <div class="col col-lg-12">
                        <form action="" method="GET" name="filterform">
                            <div class="row">
                                
                                <div class="col col-lg-4 col-md-8 col-sm-10">
                                    <div class="form-group">
                                        <label for="filter">Filter By:</label>
                                        <select class="form-control" id="filter" onchange="changeFilter(event);">
                                            <option value="Email" selected>User Email</option>
                                            <option value="ID">User ID</option>
                                        </select>                                           
                                    </div>

                                    <div class="form-group">
                                        <label for="userid" class="control-label" id="label-userid">User Email:</label>
                                    
                                        <input type="text" class="form-control" id="userid" name="userid" list="options" required onkeyup="fetchKeys();">
                                        <datalist id="options">
                                        </datalist>
                                                    
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="View Lifeline">
                                </div>
                            </div>                                    
                        </form>    
                    </div>
                </div>
                    <script>
                        function changeFilter(event){

                            document.getElementById('label-userid').innerHTML = 'User '+event.target.value+':';

                            if(event.target.value == "ID"){
                                document.getElementById('userid').setAttribute('type', 'number');
                                document.getElementById('userid').setAttribute('min', '1');
                            }
                            else if(event.target.value == "Email"){
                                document.getElementById('userid').removeAttribute('min');
                                document.getElementById('userid').setAttribute('type', 'email');
                                document.getElementById('userid').setAttribute('pattern','[A-Za-z0-9_.]+@[A-Za-z0-9_.]+\.[A-Za-z0-9_.]+');                        
                            }
                            fetchKeys();
                        }

                        function fetchKeys(){
                            
                            let filterby = document.forms['filterform'][0].value;

                            if(filterby == "Email"){
                                let email = document.forms['filterform'][1].value;
                                
                                let url = 'Backend/_getuserids.php?email='+email;

                                let xhttp=new XMLHttpRequest();
                                        
                                xhttp.open('GET',url,true);
                                
                                xhttp.onreadystatechange=function(){
                                    if(this.readyState==4 && this.status==200){
                                        //console.log("fetch",this.responseText;);
                                        document.getElementById('options').innerHTML = this.responseText;             
                                    }
                                }
                                xhttp.send();
                            }
                            else{
                                document.getElementById('options').innerHTML = ""; 
                            }
                        }
                    </script>
                    <hr>
                <?php
                    }
                ?>
                
                <?php
                    include_once('Backend/_dbconnect.php');
                    
                    if($targetUserID != getUserID()){
                        $sql = 'SELECT `User Name` FROM `users` WHERE `User ID` = '.$targetUserID;
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo '<div class="row">';
                                echo '<div class="col col-lg-12">';
                                    echo 'Showing life line of <b>'.$row["User Name"].'</b>. ID: <b>'.$targetUserID.'</b>';                                
                                echo '</div>';
                            echo '</div>';
                            echo '<hr>';
                        }
                        else{
                            echo '<div class="row">';
                                echo '<div class="col col-lg-12">';
                                    echo '<p style="color:red">User with ID <b>'.$targetUserID.'</b> does not exist</p>';                                
                                echo '</div>';
                            echo '</div>';
                            echo '<hr>';
                        }
                    }
                    else{
                        echo '<div class="row">';
                            echo '<div class="col col-lg-12">';
                                echo 'Showing your lifeline';                                
                            echo '</div>';
                        echo '</div>';
                        echo '<hr>';
                    }
                ?>
                <div id="modalcontainer"></div>
                <div class="row">
                    <div class="col col-lg-8 col-md-12">
                        <ol class="timeline">
                            <?php
                                $sql = 'SELECT `Record ID`, `Symptoms`, `Not Symptoms`, `Disease Name`, `Cured`, DATE_FORMAT(Date, "%W, %M %e, %Y") AS MyDate, TIME_FORMAT(Date, "%r") AS MyTime '
                                        .'FROM `health records` JOIN diseases ON `health records`.`Predicted Disease ID` = `diseases`.`Disease ID` WHERE `User ID` = '.$targetUserID
                                        .' ORDER BY STR_TO_DATE(MyDate, "%W, %M %e, %Y") DESC, STR_TO_DATE(MyTime, "%r") DESC';
                                $result = $conn->query($sql);
                                $conn->close();
                                
                                if ($result->num_rows > 0) {
                                    
                                    while($row = $result->fetch_assoc()){
                                        

                                        $symps = explode(",",$row["Symptoms"]);

                                        echo '<li>';
                                            echo '<div class="card mb-3 shadow p-3 mb-5 bg-white rounded">';
                                                echo '<div class="card-header">';
                                                    
                                                    echo '<h4 class="timeline-title">';
                                                    echo '<span style="color: red">'.$row["Disease Name"].'</span> was found';

                                                    echo '<span class="float-right">';
                                                    echo '<div class="btn-group">';

                                                            if (! $row['Cured']) {
                                                                echo '<a class="btn btn-default" title="Set disease as cured" onclick="setDiseaseAsCured('.$row['Record ID'].', '.$targetUserID.')"><i class="fas fa-check-square fa-fw" style="color: green;"></i></a>';
                                                                echo '<a class="btn btn-default" title="Find doctor" href="finddoctor.php?disease='.$row["Disease Name"].'" target="blank"><i class="fas fa-user-md fa-fw" style="color: darkcyan;"></i></a>';
                                                                echo '<a class="btn btn-default" title="View primary treatment"  onclick="viewPrimaryTreatment(\''.$row['Disease Name'].'\')"><i class="fas fa-tint fa-fw" style="color: darkorange;"></i></a>';
                                                            }
                                                            echo '<a class="btn btn-default" title="Delete this record"  onclick="deleteRecord('.$row['Record ID'].', '.$targetUserID.')"><i class="fas fa-trash fa-fw" style="color: red;"></i></a>';                                                                                                                        
                                                        echo '</div>';
                                                    
                                                    if ($row['Cured']) {
                                                        echo '<i class="fa fa-check-square fa-fw" style="color: green; font-size: 50px" title="Disease is cured"></i>';
                                                    }
                                                    else {
                                                        echo '<i class="fa fa-exclamation-triangle fa-fw" style="color: red; font-size: 50px" title="Disease is not cured"></i>';
                                                    }
                                                    
                                                    echo '</span>';

                                                    echo '</h4>';
                                                    echo '<pre><small class="text-muted"><i class="fa fa-clock"></i> '.$row["MyDate"].' at '.$row["MyTime"].'</small></pre>';
                                                    
                                                echo '</div>';

                                                echo '<div class="card-body">';
                                                    echo '<h5 class="card-title">Patient symptoms: </h5>';
                                                    echo '<p class="card-text">';
                                                        for ($i=0; $i < count($symps) - 2; $i++) { 
                                                            echo $symps[$i].", ";
                                                        }    
                                                        echo $symps[$i];

                                                    echo '</p>';
                                                echo '</div>';

                                                // echo '<div class="card-footer text-right"></div>';
                                                
                                            echo '</div>';
                                        echo '</li>';                                       
                                    }
                                }
                                else{
                                    echo '<li class="list-group-item">'; 
                                        echo "Nothing to show ";
                                    echo '</li>'; 
                                }
                            ?>
                        </ol>
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
    <script src="Contents/Scripts/modal.js"></script>
    <script src="Contents/Scripts/lifeline.js"></script>


</body>

</html>