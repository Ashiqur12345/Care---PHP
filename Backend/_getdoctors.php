<?php
include_once('_authcheck.php');

if($_SERVER['REQUEST_METHOD']=="GET" && authCheck()){
    include_once('_dbconnect.php');

    if(isset($_GET['option'])){
        if($_GET['option'] === "option"){
            if(isset($_GET['filterby']) && isset($_GET['key'])){

                if($_GET['filterby'] === 'Name'){
                    $sql = 'SELECT `Disease Name` AS "Option" FROM `diseases` WHERE `diseases`.`Disease Name` LIKE "%'.$_GET["key"].'%"';
                }
                else{
                    $sql = 'SELECT `NAME` AS "Option" FROM `fields` WHERE `fields`.`Name` LIKE "%'.$_GET["key"].'%"';
                }
            }

            $result = $conn->query($sql);
            $conn->close();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    echo '<option value="'.$row['Option'].'">'.$row['Option'].'</option>';
                }
            }
            else{
                echo "<option value=\"None\">None</option>";
            }
        }
        else if($_GET['option'] === "doctor"){

            if(isset($_GET['filterby']) && isset($_GET['key'])){

                if($_GET['filterby'] === 'Field'){
                    $sql = 'SELECT * FROM  `doctors` JOIN `fields` on `doctors`.`Expertise` = `fields`.`Field ID` WHERE `fields`.`Name` LIKE "%'.$_GET['key'].'%"';
                }
                else{
                    $sql = 'SELECT * FROM  `doctors` JOIN `fields` on `doctors`.`Expertise` = `fields`.`Field ID` JOIN diseases on `diseases`.`Field ID` = `fields`.`Field ID` WHERE `diseases`.`Disease Name` LIKE "%'.$_GET['key'].'%"';
                }
            

                $result = $conn->query($sql);
                $conn->close();

                if ($result->num_rows > 0) {
                    echo '{';
                    echo '"success": true, "data":';

                    echo '[';

                    for ($i=0; $i < $result->num_rows - 1; $i++) { 
                        $row = $result->fetch_assoc();
                        echo '{';
                            echo '"Name":"'.$row["Doctor Name"].'",';
                            echo '"Contact":"'.$row['Contact'].'",';
                            echo '"Location":"'.$row['Chamber Location'].'",';
                            echo '"Expertise":"'.$row['Name'].'"';
                        echo '},';
                    }

                    $row = $result->fetch_assoc();
                    echo '{';
                        echo '"Name":"'.$row["Doctor Name"].'",';
                        echo '"Contact":"'.$row['Contact'].'",';
                        echo '"Location":"'.$row['Chamber Location'].'",';
                        echo '"Expertise":"'.$row['Name'].'"';
                    echo '}';

                    echo ']';
                    echo '}';
                }
                else{
                    echo '{"success": false}';
                }
            }
        }
    }  
}

?>