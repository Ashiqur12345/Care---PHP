<?php
    include_once('_authcheck.php');
    
    if(authCheck())
    {
       
        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            $inserted = false;
            if(isset($_POST['userid']) && isset($_POST['diseasename']) && isset($_POST['symps']) && isset($_POST['notsymps']) && isset($_POST['diseasefield'])){
                
                if( getRoleID() == 2 || $_POST['userid'] == getUserID()){
                    $inserted = saveRecord($_POST['userid'], $_POST['diseasename'], $_POST['symps'], $_POST['notsymps'], $_POST['diseasefield']);
                }                
            }
            
            if($inserted){
                echo '{';
                echo '"success":true,';
                echo '"msg":"<b>Success! </b>Saved.",';
                echo '"msgtype":"success"';
                echo '}';
            }
            else{
                echo '{';
                echo '"success":false,';
                echo '"msg":"<b>Failed!</b>. Something went wrong",';
                echo '"msgtype":"danger"';
                echo '}';
            }
        }
    }
    else{
        echo '{';
        echo '"success":false,';
        echo '"msg":"Authentication failed. Sign in again.",';
        echo '"msgtype":"danger"';
        echo '}';
    }

    function saveRecord($uid, $dname, $symps, $nSymps, $dField){


        include_once('_dbconnect.php');

        $sql = 'SELECT * FROM `diseases` WHERE `Disease Name` = "'.$dname.'"';
        $result = $conn->query($sql);

        $did = -1;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $did = $row["Disease ID"];       
            
        }
        else{
            //Get the field ID
            $sql = 'SELECT * FROM `fields` WHERE `Name` = "'.$dField.'"';
            $result = $conn->query($sql);

            $dfid = -1;  
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $dfid = $row["Field ID"];
            }
            else{                

                $sql = 'INSERT INTO `fields` (`Name`) VALUES ("'.$dField.'")';

                if ($conn->query($sql) === TRUE) {
                    $dfid = $conn->insert_id;
                }
                else{
                    $conn->close();
                    return false;
                }                
            }
            
            $sql = 'INSERT INTO `diseases` (`Disease Name`, `Field ID`) VALUES ("'.$dname.'", '.$dfid.')';

            if ($conn->query($sql) === TRUE) {
                $did = $conn->insert_id;
            }
            else{                
                $conn->close();
                return false;
            }
        }
        if($did > 0){
            $sql = 'INSERT INTO `health records` (`User ID`, `Symptoms`, `Not Symptoms`, `Predicted Disease ID`) VALUES ( '.$uid.', "'.$symps.'", "'.$nSymps.'", '.$did.');';
            if ($conn->query($sql) === TRUE) {
                // $did = $conn->insert_id;
                $conn->close();
                return true;
            }
            else{
                $conn->close();
                return false;
            }
        }        
        else{
            $conn->close();
            return false;
        }
    }

?>