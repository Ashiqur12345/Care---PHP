<?php

function authCheck(){
    if(isset($_COOKIE["auth"])) {
        
        $auth = $_COOKIE["auth"];

        include_once('_crypt.php');

        $json = myDecrypt($auth);
        $result = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json));


        if(json_last_error() > 0){
            return false;
        }


        return true;
    }
    else{
        return false;
    }
}

function getUserEmail(){
    if(isset($_COOKIE["auth"])) {
        
        $auth = $_COOKIE["auth"];

        include_once('_crypt.php');

        $json = myDecrypt($auth);
        $result = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json));


        if(json_last_error() > 0){}


        return $result->Email;
    }
}

function getUserName(){
    if(isset($_COOKIE["auth"])) {
        
        $auth = $_COOKIE["auth"];

        include_once('_crypt.php');

        $json = myDecrypt($auth);
        $result = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json));


        if(json_last_error() > 0){}


        return $result->Name;
    }
}

function getUserID(){
    if(isset($_COOKIE["auth"])) {
        
        $auth = $_COOKIE["auth"];

        include_once('_crypt.php');

        $json = myDecrypt($auth);
        $result = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json));


        if(json_last_error() > 0){}


        return $result->UserID;
    }
}

function getRoleID(){
    if(isset($_COOKIE["auth"])) {
        
        $auth = $_COOKIE["auth"];

        include_once('_crypt.php');

        $json = myDecrypt($auth);
        $result = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json));


        if(json_last_error() > 0){}


        return $result->RoleID;
    }
}
?>