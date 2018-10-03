<?php
include_once('_authcheck.php');

if($_SERVER['REQUEST_METHOD']=="POST" && authCheck() && getRoleID() == 2){


    if(isset($_POST['option'])) {

        if($_POST['option'] === 'field' && isset($_POST['fieldname'])){
            insertNewField($_POST['fieldname']);
        }
        else if($_POST['option'] === 'disease' && isset($_POST['diseasename']) && isset($_POST['fieldname']) ){
            
            insertNewDisease($_POST['diseasename'], $_POST['fieldname']);
            
        }
        else if($_POST['option'] === 'treatment' && isset($_POST['diseasename']) && isset($_POST['treatmentname']) ){
            
            insertNewTreatment($_POST['diseasename'], $_POST['treatmentname']);
            
        }
        else if($_POST['option'] === 'doctor' && isset($_POST['doctorname']) && isset($_POST['fieldname']) && isset($_POST['contact']) && isset($_POST['location'])){
            
            insertNewDoctor($_POST['doctorname'], $_POST['fieldname'], $_POST['contact'], $_POST['location']);
            
        }
        else{
            echo 'else php';
        }
    }
}



function insertNewField($fieldname){
    include_once('_dbconnect.php');
    $sql = 'INSERT INTO `fields` (`Name`) VALUES ("'.$fieldname.'")';

    if ($conn->query($sql) === TRUE) {
        echo '{';
        echo '"success":true,';
        echo '"msg":"New field added",';
        echo '"msgtype":"success"';
        echo '}';
    }
    else{
        
        echo '{';
        echo '"success":false,';
        echo '"msg":"Field already exists",';
        echo '"msgtype":"danger"';
        echo '}';
    }

    $conn->close();  
}

function insertNewDisease($diseasename, $fieldname){
    include_once('_dbconnect.php');
    
    $sql = 'SELECT * FROM `diseases` WHERE `Disease Name` = "'.$_POST['diseasename'].'"';
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo '{';
        echo '"success":false,';
        echo '"msg":"Disease already exists",';
        echo '"msgtype":"danger"';
        echo '}';
    }
    else{

        $sql = 'SELECT * FROM `fields` WHERE `Name` = "'.$_POST['fieldname'].'"';
        $result = $conn->query($sql);

        $dfid = -1;  
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $dfid = $row["Field ID"];
        }
        else{                

            $sql = 'INSERT INTO `fields` (`Name`) VALUES ("'.$_POST['fieldname'].'")';

            if ($conn->query($sql) === TRUE) {
                $dfid = $conn->insert_id;
            }             
        }
        
        $sql = 'INSERT INTO `diseases` (`Disease Name`, `Field ID`) VALUES ("'.$_POST['diseasename'].'", '.$dfid.')';

        if ($conn->query($sql) === TRUE) {
            echo '{';
            echo '"success":true,';
            echo '"msg":"New disease added",';
            echo '"msgtype":"success"';
            echo '}';
        }
        else{
            
            echo '{';
            echo '"success":false,';
            echo '"msg":"Disease insertion failed",';
            echo '"msgtype":"danger"';
            echo '}';
        }
    }
    

    $conn->close();  
}

function insertNewTreatment($diseasename, $treatmentname){
    include_once('_dbconnect.php');

    $treatmentID = -1;
    $diseaseID = -1;
    
    $sql = 'SELECT * FROM `treatments` WHERE `treatments`.`Treatment Name` LIKE "'.$treatmentname.'"';
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // echo '{';
        // echo '"success":false,';
        // echo '"msg":"Treatment already exists",';
        // echo '"msgtype":"danger"';
        // echo '}';

        $row = $result->fetch_assoc();
        $treatmentID = $row["Treatment ID"];
    }
    else{

        $sql = 'INSERT INTO `treatments` (`Treatment Name`) VALUES ("'.$treatmentname.'")';
        
        if ($conn->query($sql) === TRUE) {
            $treatmentID = $conn->insert_id;
        }
    }

    $sql = 'SELECT * FROM `diseases` WHERE `diseases`.`Disease Name` = "'.$diseasename.'"';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $diseaseID = $row["Disease ID"];

        $sql = 'INSERT INTO `disease treatments` (`Disease ID`, `Treatment ID`) VALUES ('.$diseaseID.', '.$treatmentID.')';
        
        if ($conn->query($sql) === TRUE) {
            $treatmentID = $conn->insert_id;

            echo '{';
            echo '"success":true,';
            echo '"msg":"Disease treatment inserted",';
            echo '"msgtype":"success"';
            echo '}';
        }
        else{
            echo '{';
            echo '"success":false,';
            echo '"msg":"Fail to insert treatment",';
            echo '"msgtype":"danger"';
            echo '}';
        }

    }
    else{
        echo '{';
        echo '"success":false,';
        echo '"msg":"Disease not found",';
        echo '"msgtype":"danger"';
        echo '}';
    }
    
    $conn->close();  
}

function insertNewDoctor($doctorname, $fieldname, $contact, $location){
    include_once('_dbconnect.php');
    $fieldID = -1;

    $sql = 'SELECT * FROM `fields` WHERE `fields`.`Name` = "'.$fieldname.'"';
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fieldID = $row["Field ID"];
    }
    else{
        $sql = 'INSERT INTO `fields` (`Name`) VALUES ("'.$fieldname.'")';

        if ($conn->query($sql) === TRUE) {
            $fieldID = $conn->insert_id;
        }
    }


    $sql = 'SELECT * FROM `doctors` WHERE `doctors`.`Doctor Name` = "'.$doctorname.'" AND `doctors`.`Contact` = "'.$contact.'" AND `doctors`.`Expertise` = '.$fieldID.' AND `doctors`.`Chamber Location` = "'.$location.'"';
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo '{';
        echo '"success":false,';
        echo '"msg":"Doctor data already exists",';
        echo '"msgtype":"danger"';
        echo '}';
    }
    else{
        $sql = 'INSERT INTO `doctors` (`Doctor Name`, `Expertise`, `Contact`, `Chamber Location`) VALUES ("'.$doctorname.'", '.$fieldID.', "'.$contact.'", "'.$location.'")';

        $result = $conn->query($sql);
        if ($conn->query($sql) === TRUE) {
            echo '{';
            echo '"success":false,';
            echo '"msg":"Doctor data inserted successfully",';
            echo '"msgtype":"success"';
            echo '}';
        }
        else{
            echo '{';
            echo '"success":false,';
            echo '"msg":"Failed to insert doctor data",';
            echo '"msgtype":"danger"';
            echo '}';
        }
    }
    
    
    $conn->close();  
}


?>