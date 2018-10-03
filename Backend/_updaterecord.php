<?php
    include_once('_authcheck.php');
    
    if(authCheck())
    {
       
        if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['option'])){
            
            if ($_POST['option'] === 'update') {

                if(isset($_POST['recordID']) && isset($_POST['setCured'])){
                
                    if( getRoleID() == 2 || ( isset($_POST['userid']) && $_POST['userid'] == getUserID())){
                        updateRecord($_POST['recordID'], $_POST['setCured']);
                    }    
                    else{
                        echo '{';
                        echo '"success":false,';
                        echo '"msg":"<b>Failed! </b>Access denied.",';
                        echo '"msgtype":"danger"';
                        echo '}';
                    }            
                }
                else{
                    echo '{';
                    echo '"success":false,';
                    echo '"msg":"<b>Failed!</b>. Insufficient information",';
                    echo '"msgtype":"danger"';
                    echo '}';
                }
            } 
            else if ($_POST['option'] === 'delete') {
                if(isset($_POST['recordID'])){
                
                    if( getRoleID() == 2 || ( isset($_POST['userid']) && $_POST['userid'] == getUserID())){
                        deleteRecord($_POST['recordID']);
                    }    
                    else{
                        echo '{';
                        echo '"success":false,';
                        echo '"msg":"<b>Failed! </b>Access denied.",';
                        echo '"msgtype":"danger"';
                        echo '}';
                    }            
                }
                else{
                    echo '{';
                    echo '"success":false,';
                    echo '"msg":"<b>Failed!</b>. Insufficient information",';
                    echo '"msgtype":"danger"';
                    echo '}';
                }
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

    function updateRecord($recordID, $cure){

        include_once('_dbconnect.php');

        $sql = 'SELECT * FROM `health records` WHERE `Record ID` = '.$recordID;
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            $sql = 'UPDATE `health records` SET `Cured` = '.$cure.' WHERE `health records`.`Record ID` = '.$recordID;
            
            if ($conn->query($sql) === TRUE) {
                echo '{';
                echo '"success":true,';
                echo '"msg":"<b>Success!</b>. Record updated",';
                echo '"msgtype":"success"';
                echo '}';
            } else {
                echo '{';
                echo '"success":false,';
                echo '"msg":"<b>Failed!</b>. Failed to update",';
                echo '"msgtype":"danger"';
                echo '}';
            }
        }
        else{
            echo '{';
            echo '"success":false,';
            echo '"msg":"<b>Failed!</b>. Record does not exist",';
            echo '"msgtype":"danger"';
            echo '}';
        }
        $conn->close();
    }

    
    function deleteRecord($recordID){

        include_once('_dbconnect.php');

        $sql = 'DELETE FROM `health records` WHERE `health records`.`Record ID` = '.$recordID;
        $result = $conn->query($sql);

        if ($conn->query($sql) === TRUE) {
            echo '{';
            echo '"success":true,';
            echo '"msg":"<b>Success!</b>. Record deleted",';
            echo '"msgtype":"info"';
            echo '}';
        } 
        else {
            echo '{';
            echo '"success":false,';
            echo '"msg":"<b>Failed!</b>. Failed to delete",';
            echo '"msgtype":"danger"';
            echo '}';
        }

        $conn->close();
    }

?>