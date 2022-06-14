<?php

try{
    session_start();
    if ($_SERVER['REQUEST_METHOD'] != 'GET'){
        error_log('public_api: wrong request method'.PHP_EOL, 3, $destination = 'log/error.log');
        die(http_response_code(400));
    }
    if (!array_key_exists('id', $_GET) || empty($_GET['id'])) {
        error_log('public_api: no id specified'.PHP_EOL, 3, $destination = 'log/error.log');
        die(http_response_code(200));
    }

    $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET["id"];

    $query =
        'SELECT
            *
        FROM
            `films`
        WHERE
            `ID_film` = ?;';
    $sth = $dbh->prepare($query);
    $sth->execute([$id]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    echo(json_encode($result));
    die(http_response_code(200));
}
catch (PDOException $exception) {
    $_SESSION['is_auth'] = false;
    error_log('login: '.$exception->getMessage().PHP_EOL, 3, $destination = 'log/error.log');
    die(json_encode([]));
}
$dbh = null;
$sth = null;
