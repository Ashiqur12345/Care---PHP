

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body onload="window.location='index.html'">
    
</body>
</html>

<?php

if (isset($_COOKIE['auth'])) {

    unset($_COOKIE['auth']);

    setcookie('auth', null, -1, '/');
    return true;
}

flush();
header("Location: index.html");
die('You are being redirected to index page.');
?>