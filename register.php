<?php
include_once('Backend/_authcheck.php');
if($_SERVER['REQUEST_METHOD']=="GET" && authCheck()){
    header("Location: home.php?msg=Sign out first&msgtype=warning");die();
}


if($_SERVER['REQUEST_METHOD']=="GET"){
?>

<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- My styles-->
    <link rel="stylesheet" href="./Contents/Styles/mystyle.css">
    
  </head>

  <body class="bg-dark" onload="showNotification(); fetchBGroups(); ">

    <div class="container">

      <div class="col-md-12 text-center">
        <div class="logoh1"><h1>Care</h1></div>
        <p class="logoh1">Healthcare for Everyone</p>
      </div>
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Register</div>
        <div class="card-body">
            <form onsubmit="return(handleRegister(event))" name="registerform">
                
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required minlength="3" required>
                        <label for="name">Name</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label-group">
                    <input type="email" class="form-control" id="email" name="email"  placeholder="Email" required pattern="[A-Za-z0-9_.]+@[A-Za-z0-9_.]+\.[A-Za-z0-9_.]+">
                        <label for="email">Email</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" required>
                                <label for="pass">Password</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Confirm Password" required>
                                <label for="pass2">Confirm password</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="gender">Gender</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group">
                            <select class="form-control" id="gender" name="gender" placeholder="Gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="bgroup">Blood Group</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <select class="form-control" id="bgroup" name="bgroup"  placeholder="Blood Group">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="bdate">Birth Date</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <input type="date" class="form-control" id="bdate" name="bdate"  placeholder="Birth Date" required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Register</button>

            </form>
            <div class="text-center">
                <a class="d-block small mt-3" href="signin.php">Sign in</a>
                <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
            </div>
        </div>
      </div>
    </div>

    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="Contents/Scripts/_bootstrap-notify.min.js"></script>

    <!-- Opening Notification -->
    <script src="Contents/Scripts/openingnotification.js"></script>

</body>

</html>
<script>

    function fetchBGroups(){
        let xhttp=new XMLHttpRequest();
                
        xhttp.open('GET','Backend/_getbgroups.php',true);
        
        xhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                //console.log("fetch",this.responseText;);
                document.getElementById('bgroup').innerHTML = this.responseText;             
            }
        }
        xhttp.send();
    }

    function handleRegister(event){
        
        
        let name = document.forms['registerform'][0].value;
        let mail = document.forms['registerform'][1].value;
        let pass = document.forms['registerform'][2].value;
        let pass2 = document.forms['registerform'][3].value;
        let gender = document.forms['registerform'][4].value;
        let bgroup = document.forms['registerform'][5].value;
        let bdate = document.forms['registerform'][6].value;
                
        event.target[7].innerText = "Please Wait...";

        if(pass === pass2) {
        
            let data = new FormData();

            data.append('name', name);
            data.append('email', mail);
            data.append('password', pass);
            data.append('password2', pass2);
            data.append('gender', gender);
            data.append('bgroup', bgroup);
            data.append('bdate', bdate);

            let url = 'register.php?_=' + new Date().getTime();
                                        
            let xhttp=new XMLHttpRequest();

            
            // xhttp.setRequestHeader('cache-control', 'no-cache, must-revalidate, post-check=0, pre-check=0');
            // xhttp.setRequestHeader('cache-control', 'max-age=0');
            // xhttp.setRequestHeader('expires', '0');
            // xhttp.setRequestHeader('expires', 'Tue, 01 Jan 1980 1:00:00 GMT');
            // xhttp.setRequestHeader('pragma', 'no-cache');
                    
            xhttp.open('POST',url,true);
            xhttp.send(data);
            xhttp.onreadystatechange=function(){
                if(this.readyState==4 && this.status==200){
                    console.log(this.responseText);
                    let obj = JSON.parse(this.responseText);
                    if(obj.authenticate){
                        window.location = "home.php?msg=<b>Hello "+name+"</b>! Registration is successful&msgtype=success";
                    }
                    else{
                        event.target[7].innerText = "Register";
                        $.notify({
                            message: obj.msg
                        },{
                            type: obj.msgtype
                        });
                    }                      
                }
            }
        }
        else{
            event.target[7].innerText = "Register";
            $.notify({
                message: "Passwords mismatched"
            },{
                type: 'danger'
            });
        }            
        return false;
    }

</script>

<?php
        
    }
    else if($_SERVER['REQUEST_METHOD']=="POST"){{
        
        if(isset($_POST['name']) 
            && isset($_POST['email']) 
            && isset($_POST['password']) 
            && isset($_POST['password2']) 
            && isset($_POST['gender'])  
            && isset($_POST['bgroup'])
            && isset($_POST['bdate'])){

            
            
            if($_POST['name'] === null){
                echo "{";
                echo '"msg":"Name is required",';
                echo '"msgtype":"danger",';
                echo '"authenticate":false';
                echo "}";
            }
            else if($_POST['password'] != $_POST['password2']){
                echo "{";
                echo '"msg":"Passwords mismatched",';
                echo '"msgtype":"danger",';
                echo '"authenticate":false';
                echo "}";
            }
            else if(strlen($_POST['password']) < 4){
                echo "{";
                echo '"msg":"Password is too short",';
                echo '"msgtype":"danger",';
                echo '"authenticate":false';
                echo "}";
            }
            else if($_POST['email'] === null){
                echo "{";
                echo '"msg":"Email is required",';
                echo '"msgtype":"danger",';
                echo '"authenticate":false';
                echo "}";
            }
            else if($_POST['gender'] === null){
                echo "{";
                echo '"msg":"Gender is required",';
                echo '"msgtype":"danger",';
                echo '"authenticate":false';
                echo "}";
            }
            else if($_POST['bgroup'] === null){
                echo "{";
                echo '"msg":"Blood Group is required",';
                echo '"msgtype":"danger",';
                echo '"authenticate":false';
                echo "}";
            }
            else if($_POST['bdate'] === null){
                echo "{";
                echo '"msg":"Birth date is required",';
                echo '"msgtype":"danger",';
                echo '"authenticate":false';
                echo "}";
            }
            else{
                dataEntryAndAuthenticate($_POST['name'], $_POST['email'], $_POST['password'], $_POST['gender'], $_POST['bgroup'], $_POST['bdate']);
            }

        }
        else{
            echo "{";
            echo '"msg":"Fill out all the forms correctly",';
            echo '"msgtype":"danger",';
            echo '"authenticate":false';
            echo "}";
        }

        
    }
}

function dataEntryAndAuthenticate($name, $email, $pass, $gender, $bgroup, $bdate){
    
    include_once('Backend/_dbconnect.php');

    $sql = 'SELECT * FROM `users` WHERE `Email` = ".$mail."';
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0){
        echo "{";
        echo '"msg":"Email is alreadty used",';
        echo '"msgtype":"danger",';
        echo '"authenticate":false';
        echo "}";
    }
    else{
        $hashedpass = password_hash($pass, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO `users` (`User ID`, `User Name`, `Email`, `Gender`, `Password`, `Birth Date`, `Role ID`, `Blood Group ID`) VALUES (NULL, "'.$name.'", "'.$email.'", "'.$gender.'", "'.$hashedpass.'", "'.$bdate.'", 1, '.$bgroup.')';
        
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            //echo "New record created successfully. Last inserted ID is: " . $last_id;

            include('Backend/_crypt.php');

            $cookieval = '{"UserID": '.$last_id.', "Name": "'.$name.'", "Email": "'.$email.', "RoleID": 1"}';
            
            $enc = myEncrypt($cookieval);
            setcookie("auth", $enc, time() + 86400, "/"); // 86400 = 1 day

            echo "{";
            echo '"msg":"Registration successful",';
            echo '"msgtype":"success",';
            echo '"authenticate":true';
            echo "}";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            echo "{";
            echo '"msg":"Something went wrong",';
            echo '"msgtype":"danger",';
            echo '"authenticate":false';
            echo "}";
        }
    }
    $conn->close();
}

?>
