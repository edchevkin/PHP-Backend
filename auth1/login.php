<?php

session_start();
setcookie('PHPSESSID', session_id(), time()+3600, '/', $domain = 'localhost', $httponly = true);

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!array_key_exists('login', $_POST)
            || empty($_POST['login'])) {
            $_SESSION['is_auth'] = false;
            error_log('login: wrong login type or login has not been specified'.PHP_EOL, 3, $destination = 'log/error.log');
            echo("Invalid credentials" . PHP_EOL);
            die(http_response_code(200));
        }
        if (!array_key_exists('password', $_POST)
            || empty($_POST['password'])) {
            $_SESSION['is_auth'] = false;
            error_log('login: wrong password type or password has not been specified'.PHP_EOL, 3, $destination = 'log/error.log');
            echo("Invalid credentials" . PHP_EOL);
            die(http_response_code(200));
        }
    } else {
        error_log('login: wrong request type'.PHP_EOL, 3, $destination = 'log/error.log');
        die(http_response_code(400));
    }

    $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $login = $_POST['login'];
    $password = $_POST['password'];

    $query =
        'SELECT
            *
        FROM
            `users`
        WHERE
            `login` = ?;';
    $sth = $dbh->prepare($query);
    $sth->execute([$login]);
    $info = $sth->fetchAll(PDO::FETCH_ASSOC);
    if ($info == []) {
        error_log('login: inexistent login has been used'.PHP_EOL, 3, $destination = 'log/security.log');
        $_SESSION['is_auth'] = false;
        echo('Invalid credentials' . PHP_EOL);
        die(http_response_code(200));
    }
    $serv_password = $info[0]['password'];
    $user_id = $info[0]['user_id'];

    if ($serv_password != null && password_verify($password, $serv_password)){
        if(array_key_exists('is_auth', $_SESSION)){
            if ($_SESSION['is_auth'] == true && $_SESSION['login'] == $login){
                die('You are already logged in'.PHP_EOL);
            }
        }
        session_regenerate_id(true);
        $_SESSION['id'] = session_id();
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['is_auth'] = true;
        setcookie('PHPSESSID', session_id(), time()+3600, '/',
            $domain = 'localhost', $httponly = true);
        echo('OK'.PHP_EOL);
        die(http_response_code(200));
        }
    else{
        error_log('login: wrong password for user _'.$login.'_ has been used'.PHP_EOL, 3, $destination = 'log/security.log');
        $_SESSION['is_auth'] = false;
        echo('Invalid credentials'.PHP_EOL);
        die(http_response_code(200));
    }
}
catch (PDOException $exception) {
    $_SESSION['is_auth'] = false;
    error_log('login: '.$exception->getMessage().PHP_EOL, 3, $destination = 'log/error.log');
    die(json_encode([]));
}
$dbh = null;
$sth = null;
