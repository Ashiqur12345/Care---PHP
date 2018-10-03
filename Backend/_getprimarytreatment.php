<?php
include_once('_authcheck.php');

if($_SERVER['REQUEST_METHOD']=="GET" && authCheck() ){
    include_once('_dbconnect.php');

    if(isset($_GET['diseasename'])){

        $diseasename = $_GET['diseasename'];
        $sql = 'SELECT DISTINCT `Treatment Name` from `treatments` INNER JOIN `disease treatments` ON `treatments`.`Treatment ID` = `disease treatments`.`Treatment ID` INNER JOIN `diseases` ON `diseases`.`Disease ID` = `disease treatments`.`Disease ID`  WHERE `diseases`.`Disease Name` = "'.$diseasename.'"';
            
        $result = $conn->query($sql);
        $conn->close();

        echo "{";
        if ($result->num_rows > 0) {

            echo '"success": true,';
            echo '"disease": "'.$diseasename.'",';
            echo '"treatments": [';

            for ($i=0; $i < $result->num_rows - 1; $i++) { 
                $row = $result->fetch_assoc();

                echo '"';
                echo $row["Treatment Name"];
                echo '",';
            }
            $row = $result->fetch_assoc();
            echo "\"";
            echo $row["Treatment Name"];
            echo "\"";
            echo "]";
        }
        else{
            echo '"success": false';
        }

        echo "}";
    }
}

?>