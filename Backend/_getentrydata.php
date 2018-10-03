<?php
include_once('_authcheck.php');
include_once('_dbconnect.php');
if($_SERVER['REQUEST_METHOD']=="GET" && authCheck() && getRoleID() == 2){


        if(isset($_GET['fieldname'])){
            $sql = 'SELECT DISTINCT `fields`.`Name` FROM `fields` WHERE `fields`.`Name` LIKE "%'.$_GET['fieldname'].'%"';
            
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row["Name"]."'>".$row["Name"]."</option>";
                }
            }
        }
        else if(isset($_GET['diseasename'])){
            $sql = 'SELECT DISTINCT `diseases`.`Disease Name` FROM `diseases` WHERE `diseases`.`Disease Name` LIKE "%'.$_GET['diseasename'].'%"';
            
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row["Disease Name"]."'>".$row["Disease Name"]."</option>";
                }
            }
        }
        else if(isset($_GET['treatment'])){
            $sql = 'SELECT DISTINCT `treatments`.`Treatment Name` FROM `treatments` WHERE `treatments`.`Treatment Name` LIKE "%'.$_GET['treatment'].'%"';
            
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row["Treatment Name"]."'>".$row["Treatment Name"]."</option>";
                }
            }
        }
        else if(isset($_GET['location'])){
            $sql = 'SELECT DISTINCT `doctors`.`Chamber Location` FROM `doctors` WHERE `doctors`.`Chamber Location` like "%'.$_GET['location'].'%"';
            
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row["Chamber Location"]."'>".$row["Chamber Location"]."</option>";
                }
            }
        }
        else if(isset($_GET['doctornames'])){
            $sql = 'SELECT DISTINCT `doctors`.`Doctor Name` FROM `doctors` WHERE `doctors`.`Doctor Name` like "%'.$_GET['doctornames'].'%"';
            
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row["Doctor Name"]."'>".$row["Doctor Name"]."</option>";
                }
            }
        }
    
}
?>