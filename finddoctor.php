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

    <title>Find Doctor</title>

    <?php include_once('cssreferences.php'); ?>
  </head>

  <body id="page-top" onload="showNotification();fetchDoctorsFromGetvalues();" class="sidebar-toggled">

    <?php include_once('navbar.php') ?>

    <div id="wrapper" class="sidebar-toggled">

    <?php include_once('sidebar.php') ?>

        <div id="content-wrapper">

            <div class="container-fluid">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="home.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Find Doctor</li>
                </ol>

                <!-- Page Content -->
                <h1>Find Doctor</h1>
                <hr>
                
                <div class="row">
                    <div class="col col-lg-12">
                        <div>
                            <form onsubmit="return(fetchDoctors());" action="#" method="POST" name="filterform">
                                <div class="row">
                                    
                                    <div class="col col-lg-4 col-md-8 col-sm-10">
                                        <div class="form-group">
                                            <label for="filter">Filter By:</label>
                                            <select class="form-control" id="filter" onchange="document.getElementById('label-doctor-prop').innerHTML = 'Disease '+event.target.value+':';fetchKeys();">
                                                <option value="Name" selected>Disease Name</option>
                                                <option value="Field">Disease Field</option>
                                            </select>                                           
                                        </div>

                                        <div class="form-group">
                                            <label for="doctor-prop" class="control-label" id="label-doctor-prop">Disease Name:</label>
                                        
                                            <input type="text" class="form-control" id="doctor-prop" name="doctor-prop" list="options" required onkeyup="fetchKeys();">
                                            <datalist id="options">
                                            </datalist>
                                                      
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Find Doctor">
                                    </div>
                                </div>                                    
                            </form>                            
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="doctorlist"></div>
                <script>
                    function fetchKeys(){
                        
                        let filterby = document.forms['filterform'][0].value;
                        let key = document.forms['filterform'][1].value;
                        
                        let url = 'Backend/_getdoctors.php?option=option&filterby='+filterby+"&key="+key;

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

                    function fetchDoctors(){
                        let filterby = document.forms['filterform'][0].value;
                        let key = document.forms['filterform'][1].value;
                        
                        let url = 'Backend/_getdoctors.php?option=doctor&filterby='+filterby+"&key="+key;

                        let xhttp=new XMLHttpRequest();
                                
                        xhttp.open('GET',url,true);
                        
                        xhttp.onreadystatechange=function(){
                            if(this.readyState==4 && this.status==200){
                                console.log(this.responseText);
                                let obj = JSON.parse(this.responseText);
                                if(obj.success)
                                {
                                    let elements = '<div class="col col-lg-12"><h5>Contacts any of the following doctor(s)</h5></div>';
                                    obj.data.forEach(function(element, index ) {   
                                        elements += buildDoctorUI(element);
                                    });
                                    document.getElementById('doctorlist').innerHTML = elements;             
                                }
                                else{
                                    document.getElementById('doctorlist').innerHTML = '<div class="col col-lg-12"><h5>No doctor found</h5></div>'; 
                                }
                            }
                        }
                        xhttp.send();

                        return false;
                    }


                    function buildDoctorUI(doc){
                        let str = '<div class="col col-lg-3 col-md-4 col-sm-6">'; 
                            str += '<div class="card bg-light mb-3 bg-white rounded" style="min-height:18em; max-height:18em; min-width:15em; max-width:17em; margin: 1em 1em 1em 1em">';
                           
                                str += '<div class="card-body">';
                                    str += '<h5 class="card-title">';
                                        str += '<i class="fas fa-user-md fa-fw"></i><br> '+doc.Name;
                                    str += '</h5>';
                                    str += '<h6>';
                                        str += 'Expertise: '+ doc.Expertise;
                                    str += '</h6>';
                                    str += '<p class="card-text">';
                                        str +=  '<b>Chamber: </b>'+doc.Location;
                                    str += '</p>';
                                str += '</div>';

                                str += '<div class="card-footer">';
                                    str += '<a href="tel:'+doc.Contact+'" class="btn btn-info">';
                                        str += 'Call for appointment <span class="fa fa-phone"></span>';
                                    str += '</a>';
                                str += '</div>';
                            str += '</div>';
                        str += '</div>';
                        return str;
                    }

                    
                    function fetchDoctorsFromGetvalues(){
                        let disease = findGetParameter('disease');
                        if(disease != null){
                            document.getElementById('doctor-prop').value = disease;
                            fetchDoctors();
                        }

                        //let field = findGetParameter('field');
                    }
                </script>
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