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

    <title>Smiley Bot</title>

    <?php include_once('cssreferences.php'); ?>

    <style>
        * {
        box-sizing: border-box;
        }

        #manualSymptomAdd > ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        }

        #manualSymptomAdd > ul li {
        border: 1px solid #ddd;
        margin-top: -1px; /* Prevent double borders */
        background-color: #f6f6f6;
        padding: 12px;
        text-decoration: none;
        font-size: 18px;
        color: black;
        display: block;
        position: relative;
        }

        #manualSymptomAdd > ul li:hover {
        background-color: #eee;
        }

        .removeOption {
        cursor: pointer;
        position: absolute;
        top: 50%;
        right: 0%;
        padding: 12px 16px;
        transform: translate(0%, -50%);
        }

        .removeOption:hover {background: #bbb;}
    </style>
  </head>

  <body id="page-top" onload="showNotification();fetchAllSymptoms();">

    <?php include_once('navbar.php') ?>

    <div id="wrapper" class="sidebar-toggled">

    <?php include_once('sidebar.php') ?>

        <div id="content-wrapper">

            <div class="container-fluid">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="home.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">SmileyBot</li>
                </ol>

                <!-- Page Content -->
                <h1>Smiley Bot</h1>
                <p>Smiley bot can predict diseases by talking with you. <input type="button" class="btn btn-primary btn-sm" value="Start Conversation" onclick="startConversation(event);">
                . Or you can add symptoms manually. <input type="button" class="btn btn-info btn-sm" value="Add Symptoms Manually" onclick="showManualSymptomAdd(event);"></p>
                <hr>
                

                <div id="modalcontainer"></div>
                <div class="row">
                    <div class="col col-lg-6 col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col col-lg-12" id="botSymptomAdd">
                                <div class="chat-window" id="chat-window"  style="display: none">
                                    <!-- All conversations are here-->
                                </div>
                                <div id="bottom-div" class="text-center" style="bottom: 5%">
                                    <button id="predict" class="btn btn-sm btn-info" onclick="predictDisease();">Predict</button>
                                </div>
                            </div>
                            <div class="col col-lg-12" id="manualSymptomAdd" style="display: none">

                                <form onsubmit="return(addSymptomToList());" name="manualSymptomAddForm">    
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Symptom </span>
                                        </div>
                                        <input type="text" class="form-control" list="allSymptoms" required>
                                        
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="Add Symptom">
                                                                     
                                </form>
                                <br>
                                <datalist id="allSymptoms"></datalist> 
                                <ul id="symptomList">
                                    <!-- <li>Agnes<span class="removeOption">&times;</span></li> -->
                                </ul>
                                <br>
                                <button class="btn btn-info" onclick="predictDisease();">Predict</button>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6 col-md-6 col-sm-12">
                    <br>
                        <div id="report-window-btns" style="display: none">
                            <button class="btn btn-md btn-info btn-sm" title="Print report" onclick="PrintElem('report-window')"><i class="fas fa-print fa-fw"></i></button>
                            <button class="btn btn-md btn-primary btn-sm" title="Save report to lifeline" onclick="saveReport()"><i class="fas fa-save fa-fw"></i></button>
                            <button class="btn btn-md btn-primary btn-sm" title="Find doctor" onclick="findDoctor()"><i class="fas fa-user-md fa-fw"></i></button>
                            <button class="btn btn-md btn-primary btn-sm" title="Primary treatment" onclick="getPrimaryTreatment()"><i class="fas fa-tint fa-fw"></i></button>
                        </div>
                        <div id="report-window">
                        </div>
                    </div>
                </div> 
                
                <script>
                    function startConversation(event){
                        document.getElementById('botSymptomAdd').style.display = 'block';
                        document.getElementById('manualSymptomAdd').style.display = 'none';

                        document.getElementById('chat-window').style.display = 'block';
                        document.getElementById('report-window-btns').style.display = 'none';
                        document.getElementById('report-window').innerHTML = '<h4>Report</h4><p>Nothing to show</p>';
                        event.target.value = "Restart Conversation";
                        init();
                    }

                    function findDoctor(){
                        if(patient.Disease != null){
                            let url = 'finddoctor.php?disease='+patient.Disease.Disease.Name+'&field='+patient.Disease.Disease.Field;
                            let win = window.open(url, '_blank');
                            win.focus();
                        }
                        else{
                            let str = "No disease found to search doctor. You can chat with smiley bot to detect a disease by clicking <b>'Start Conversation'</b>";
                            str += " or you can go <a href='finddoctor.php'><b>here</b></a> if you know the name of the disease.";
                            modal('No disease found',str,'');
                            showModal();
                        }
                    }

                    function saveReport(){
                                            
                        let data = new FormData();
                        data.append('userid', patient.Id);
                        data.append('diseasename', patient.Disease.Disease.Name);
                        data.append('diseasefield', patient.Disease.Disease.Field);
                        let symps = "";
                        if(patient.Symptoms.length > 0){
                            patient.Symptoms.forEach(function(element, index ) {                              
                                symps += element+",";
                            });
                        }
                        data.append('symps', symps);

                        let notsymps = "";
                        if(patient.NotSymptoms.length > 0){
                            patient.NotSymptoms.forEach(function(element, index ) {                              
                            notsymps += element+",";
                        });
                        }
                        data.append('notsymps', notsymps);

                        let xhttp=new XMLHttpRequest();
                                
                        xhttp.open('POST','Backend/_postrecord.php',true);
                        xhttp.send(data);
                        xhttp.onreadystatechange=function(){
                            //hidePleaseWait();
                            if(this.readyState==4 && this.status==200){
                                console.log(this.responseText);
                                let obj = JSON.parse(this.responseText);
                                if(obj.success){
                                    $.notify({
                                        message: obj.msg
                                    },{
                                        type: obj.msgtype,
                                    });
                                }
                                else{
                                    $.notify({
                                        message: obj.msg
                                    },{
                                        type: obj.msgtype,
                                    });
                                }
                                
                            }
                        }
                    }

                    function getPrimaryTreatment(){

                        let xhttp=new XMLHttpRequest();
                                
                        xhttp.open('GET','Backend/_getprimarytreatment.php?diseasename='+patient.Disease.Disease.Name,true);
                        xhttp.send();
                        xhttp.onreadystatechange=function(){
                            //hidePleaseWait();
                            if(this.readyState==4 && this.status==200){
                                console.log(this.responseText);
                                let obj = JSON.parse(this.responseText);
                                if(obj.success){
                                    console.log(document.getElementById('report-window').firstChild);
                                    let str = "Primary Treatment(s): <br>";
                                    obj.treatments.forEach(function(element, index) {
                                        str += "<span class='treatmentItem' style='background-color: rgba(213, 219, 124, 0.637);'>&Tab;&Tab;<b>"+element+"</b></span><br>";
                                    });
                                    
                                    document.getElementById('report-window').childNodes[1].innerHTML = str;

                                    $.notify({
                                        message: "<b>Success</b>, treatments are added in the report"
                                    },{
                                        type: "success",
                                    });

                                    $('html, body').animate({
                                        scrollTop: $("#report-window").offset().top
                                    }, 2000);
                                }
                                else{
                                    $.notify({
                                        message: "<b>Sorry</b>, no treatment was found"
                                    },{
                                        type: "danger",
                                    });
                                }
                                
                            }
                        }

                        // let items = document.getElementsByClassName('treatmentItem');

                        // setTimeout((element) => {
                        //     console.log('Here');
                        //     for (let index = 0; index < items; index++) {
                        //         const element = array[index];

                        //         console.log(element);
                        //         element.style.backgroundColor = "white"; 
                        //     }
                        // }, 3000);
                    }

                    function showManualSymptomAdd(event) {
                        document.getElementById('botSymptomAdd').style.display = 'none';
                        document.getElementById('manualSymptomAdd').style.display = 'block';
                        init();
                        document.getElementById('report-window-btns').style.display = 'none';
                        document.getElementById('report-window').innerHTML = '<h4>Report</h4><p>Nothing to show</p>';
                    }
                    
                    let allSymptoms = [];
                    function fetchAllSymptoms() {
                        
                        let xhttp=new XMLHttpRequest();
                                
                        xhttp.open('GET','http://www.ashman.somee.com/api/symptoms',true);
                        xhttp.send();
                        xhttp.onreadystatechange=function(){
                            //hidePleaseWait();
                            if(this.readyState==4 && this.status==200){
                                //console.log(this.responseText);
                                allSymptoms = JSON.parse(this.responseText);
                                document.getElementById('allSymptoms').innerHTML = "";
                                allSymptoms.forEach(element => {
                                    document.getElementById('allSymptoms').innerHTML += '<option>'+element+'</option>';
                                });
                                
                            }
                        }
                    }

                    function addSymptomToList() {
                        console.log(allSymptoms);
                        let sympName = document.forms['manualSymptomAddForm'][0].value;
                        
                        let invalidSymptom = true;
                        allSymptoms.forEach(function(element, index) {
                            if(sympName.includes(element)){
                                invalidSymptom = false;
                            }
                        });

                        if(! invalidSymptom){
                            
                            let alreadyAdded = false;
                            patient.Symptoms.forEach(function(element, index) {
                                if(sympName.includes(element)){
                                    alreadyAdded = true;
                                }
                            });

                            if(! alreadyAdded){
                                patient.Symptoms.push(sympName);
                                let option = '<li>'+sympName+'<span class="removeOption" onclick="removeSymptomFromList(\''+sympName+'\')">&times;</span></li>';
                                document.getElementById('symptomList').innerHTML += option;
                                document.forms['manualSymptomAddForm'][0].value = "";
                                return false;
                            }
                            else{
                                $.notify({
                                    message: "<b>Symptom already added</b>"
                                },{
                                    type: "info",
                                });
                            }
                        }
                        else{
                            $.notify({
                                message: "<b>Invalid Symptom</b>"
                            },{
                                type: "danger",
                            });
                        }
                        
                        return false;
                    }

                    function removeSymptomFromList(sympName) {
                        patient.Symptoms.pop(sympName);

                        document.getElementById('symptomList').innerHTML = "";
                        patient.Symptoms.forEach( function(element, index) {
                            let option = '<li>'+sympName+'<span class="removeOption" onclick="removeSymptomFromList(\''+sympName+'\')">&times;</span></li>';
                            document.getElementById('symptomList').innerHTML += option;
                        });
                    }

                </script>

                <!-- Action Div-->
                
                <!-- End Action Div-->
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

    <?php include_once('jsreferencesbot.php'); ?>


  </body>

</html>