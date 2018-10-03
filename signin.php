<?php

include_once('Backend/_authcheck.php');
if($_SERVER['REQUEST_METHOD']=="GET" && authCheck()){
    header("Location: home.php?msg=Sign out first&msgtype=warning");die();
}

if($_SERVER['REQUEST_METHOD']=="GET"){
    $msg = "";
    $msgtype = "";
    
    if(isset($_GET['msg']) && isset($_GET['msgtype'])){
        $msg = $_GET['msg'];
        $msgtype = $_GET['msgtype'];
    }

    $rdrurl = "home.php";
    if(isset($_GET['rdrurl'])){
        $rdrurl = $_GET['rdrurl'];
    }

?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sign In</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- My styles-->
    <link rel="stylesheet" href="./Contents/Styles/mystyle.css">

  </head>

  <body class="bg-dark" onload="showNotification();">

    <div class="container">

        <div class="col-md-12 text-center">
            <div class="logoh1"><h1>Care</h1></div>
            <p class="logoh1">Healthcare for Everyone</p>
        </div>
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Sign in</div>
            <div class="card-body">
                <form onsubmit="return(handleSignin(event))" action="#" method="POST" name="signinform">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required pattern="[A-Za-z0-9_.]+@[A-Za-z0-9_.]+\.[A-Za-z0-9_.]+">
                    </div>
                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control" id="pass" name="pass" required>
                    </div>
                    <!-- <div class="checkbox">
                        <label><input type="checkbox"> Remember me</label>
                    </div> -->
                    <button type="submit" class="btn btn-primary btn-block" >Sign In</button>
                </form>
                <div class="text-center">
                    <a class="d-block small mt-3" href="register.php">Register an Account</a>
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
    function handleSignin(event){
        event.target[2].innerText = "Signing in...";
        let mail = document.forms['signinform'][0].value;
        let pass = document.forms['signinform'][1].value;

        if(mail != null && pass != null) {
           
            let data = new FormData();
            data.append('email', mail);
            data.append('password', pass);

            let url = 'signin.php?_=' + new Date().getTime();

            let xhttp=new XMLHttpRequest();

            // xhttp.setRequestHeader('cache-control', 'no-cache, must-revalidate, post-check=0, pre-check=0');
            // xhttp.setRequestHeader('cache-control', 'max-age=0');
            // xhttp.setRequestHeader('expires', '0');
            // xhttp.setRequestHeader('expires', 'Tue, 01 Jan 1980 1:00:00 GMT');
            // xhttp.setRequestHeader('pragma', 'no-cache');
                
            xhttp.open('POST',url,true);
            xhttp.send(data);
            xhttp.onreadystatechange=function(){
                //hidePleaseWait();
                if(this.readyState==4 && this.status==200){
                    console.log(this.responseText);
                    let obj = JSON.parse(this.responseText);
                    if(obj.authenticate){
                        window.location = "<?php echo $rdrurl;?>";
                    }
                    else{
                        event.target[2].innerText = "Sign In";
                        $.notify({
                            message: obj.msg
                        },{
                            type: obj.msgtype,
                        });
                    }
                    
                }
            }
        }
        
        return false;
    }

</script>

<?php
    
}
else if($_SERVER['REQUEST_METHOD']=="POST"){
    echo "{";
    if(isset($_POST['email']) && isset($_POST['password'])){

        if(authenticateAndSetCookie($_POST['email'], $_POST['password'])){
            echo '"msg":"Successfully signed in",';
            echo '"msgtype":"success",';
            echo '"authenticate":true';
            
        }
        else{
            echo '"msg":"Sign in failed",';
            echo '"msgtype":"danger",';
            echo '"authenticate":false';
        }
    }
    else{
        echo '"msg":"Sign in failed",';
        echo '"msgtype":"danger",';
        echo '"authenticate":false';
    }

    echo "}";
}

// $pwd_encrypted = password_hash($pwd, PASSWORD_DEFAULT);
// $bool = password_verify($pwd, $pwd_encrypted);

function authenticateAndSetCookie($email, $pass){

    include_once('./Backend/_dbconnect.php');

    $sql = 'SELECT * FROM `users` WHERE `Email` = "'.$email.'"';

    $result = $conn->query($sql);

    $conn->close();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $bool = password_verify( $pass ,$row["Password"]);
        
        if($bool){
            include_once('Backend/_crypt.php');
            $cookieval = '{"UserID": '.$row["User ID"].', "Name": "'.$row["User Name"].'", "Email": "'.$row["Email"].'", "RoleID": "'.$row["Role ID"].'"}';
            
            $enc = myEncrypt($cookieval);
            setcookie("auth", $enc, time() + 86400, "/"); // 86400 = 1 day
            return true;
        }
    } 

    return false;
}

?>