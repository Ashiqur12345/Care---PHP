<?php
include_once('_authcheck.php');

if($_SERVER['REQUEST_METHOD']=="GET" && authCheck() && getRoleID() == 2){
    include_once('_dbconnect.php');

    if(isset($_GET['email'])){

        $sql = 'SELECT DISTINCT `users`.`User ID`, `users`.`Email` FROM `users` WHERE `users`.`Email` LIKE "%'.$_GET["email"].'%"';
            
        $result = $conn->query($sql);
        $conn->close();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                echo '<option value="'.$row['User ID'].'">'.$row['Email'].'</option>';
            }
        }
        else{
            echo "<option value=\"None\">None</option>";
        }
    }
}

?>