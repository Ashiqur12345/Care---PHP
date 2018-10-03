<?php

if($_SERVER['REQUEST_METHOD']=="GET"){

    include_once('_dbconnect.php');
    $sql = 'SELECT * FROM `blood group` WHERE 1';
    $result = $conn->query($sql);
    $conn->close();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            echo "<option value=".$row["Blood Group ID"].">".$row["Name"]."</option>";
        }
    }
    else{
        echo "<option value=\"None\">None</option>";
    }
}

?>