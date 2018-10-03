<?php 

    if($_SERVER['REQUEST_METHOD']=="POST"){
        
        if(isset($_POST['option'])){
            
            if($_POST['option'] === 'signin' && isset($_POST['email']) && isset($_POST['password']) ){
                authentication($_POST['email'], $_POST['password']);
            }
            else if($_POST['option'] === 'signup' 
                    && isset($_POST['name']) 
                    && isset($_POST['email']) 
                    && isset($_POST['password']) 
                    && isset($_POST['gender']) 
                    && isset($_POST['bloodgroup']) 
                    && isset($_POST['birthdate']) ){
                
                
                $uid = register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['gender'], $_POST['bloodgroup'], $_POST['birthdate']);

                if($uid > 0){
                    echo '{';
                        echo '"authentication":true,';
                        echo '"userid": '.$uid;
                    echo '}';
                }
                else if($uid == -1){
                    echo '{';
                        echo '"authentication":false,';
                        echo '"messege":"Email is already used"';
                    echo '}';
                }
                else if($uid == -2){
                    echo '{';
                        echo '"authentication":false,';
                        echo '"messege":"Invalid blood group name"';
                    echo '}';
                }           
                else if($uid == -3){
                    echo '{';
                        echo '"authentication":false,';
                        echo '"messege":"Unknown error"';
                    echo '}';
                }      
            }
        }
        else {
            echo '{';
                echo '"messege":"Insufficient info"';
            echo '}';
        }
    }
    //End of "POST"


    function authentication($email, $pass){
        include('./Backend/_dbconnect.php');
    
        $sql = 'SELECT * FROM `users` WHERE `Email` = "'.$email.'"';
    
        $result = $conn->query($sql);

        $bool = false;
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    
            $bool = password_verify( $pass ,$row["Password"]);
            
            
        } 
    
        if($bool){
            echo '{';
                echo '"authentication":true,';
                echo '"userid": '.$row["User ID"].',';
                echo '"name": "'.$row["User Name"].'",';
                echo '"email": "'.$row["Email"].'",';
                echo '"gender": "'.$row["Gender"].'",';                    
                echo '"bloodgroup": "'.getBloodGroupFromID($row["Blood Group ID"]).'",';
                echo '"age": '.calculateAgeFromBirthDate($row["Birth Date"]);
            echo '}';
        }
        else{
            echo '{';
                echo '"authentication":false';
            echo '}';
        }
        $conn->close();
    }

    function register($name, $email, $pass, $gender, $bgroup, $bdate){
        include('./Backend/_dbconnect.php');
        
        $sql = 'SELECT * FROM `users` WHERE `Email` = "'.$email.'"';
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0){
            $conn->close();
            return -1; //-1 is email is taken
        }
        else{
            $hashedpass = password_hash($pass, PASSWORD_DEFAULT);

            $bgid = getBloodGroupIDFromName($bgroup);

            if($bgid < 0){
                $conn->close();
                return -2; //-2 means blood group error
            }
    
            $sql = 'INSERT INTO `users` (`User Name`, `Email`, `Gender`, `Password`, `Birth Date`, `Role ID`, `Blood Group ID`) '
                    .'VALUES ("'.$name.'", "'.$email.'", "'.$gender.'", "'.$hashedpass.'", "'.$bdate.'", 1, '.$bgid.')';

            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;
                return $last_id;
            }
            else{
                $conn->close();
                return -3; //-3 is insertion problem
            }
        }
        
    }

    function getBloodGroupFromID($bgid){
        include('./Backend/_dbconnect.php');
        $sql = 'SELECT * FROM `blood group` WHERE `blood group`.`Blood Group ID` = '.$bgid;
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    
            return $row["Name"];
        }
        else {
            return "N/A";
        }
        $conn->close();

    }

    function getBloodGroupIDFromName($bgname){
        include('./Backend/_dbconnect.php');
        $sql = 'SELECT * FROM `blood group` WHERE `blood group`.`Name` = "'.$bgname.'"';
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    
            return $row["Blood Group ID"];
        }
        else {
            return -1;
        }
        $conn->close();

    }

    function calculateAgeFromBirthDate($bdate){
        
        $sqlDateExplosed = explode("-", $bdate);
        //date in mm/dd/yyyy format; or it can be in other formats as well
        $birthDate = $sqlDateExplosed[1]."/".$sqlDateExplosed[2]."/".$sqlDateExplosed[0];
        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
        
        return $age;
    }

    
?>