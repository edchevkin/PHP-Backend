<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($_SESSION['is_auth'] == false){
        die('Already logged out'.PHP_EOL);
    }
    unset($_SESSION);
    session_destroy();
    session_start();
    setcookie("PHPSESSID", session_id(), time()+3600,
        $httponly = true, $domain = 'localhost');
    $_SESSION['is_auth'] = false;
    echo ('OK'.PHP_EOL);
    die(http_response_code(200));
}
else{
    error_log('logout: wrong request method'.PHP_EOL, 3, $destination = 'log/error.log');
    die(http_response_code(400));
}