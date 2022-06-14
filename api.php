<?php
session_start();
try{
    if ($_SERVER['REQUEST_METHOD'] != 'POST'){
        error_log('api: wrong request method', 3, $destination = 'log/error.log');
        die(http_response_code(400));
    }
    if (!array_key_exists('name', $_POST) || empty($_POST['name']) ||
        !array_key_exists('yor', $_POST) || empty($_POST['yor']) ||
        !array_key_exists('cor', $_POST) || empty($_POST['cor']) ||
        !array_key_exists('IMDb', $_POST) || empty($_POST['IMDb']) ||
        !array_key_exists('RT', $_POST) || empty($_POST['RT'])) {
            error_log('api: bad request params'.PHP_EOL, 3, $destination = 'log/error.log');
            die(http_response_code(200));
    }

    $name = $_POST['name'];
    $yor = $_POST['yor'];
    $cor = $_POST['cor'];
    $IMDb = $_POST['IMDb'];
    $RT = $_POST['RT'];

    if ($_SESSION['is_auth'] == true &&
        session_id() == $_COOKIE['PHPSESSID']){
        $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query =
            'INSERT INTO `films`(
            `film_name`,
            `year_of_release`,
            `country_of_release`,
            `IMDb_rating`,
            `RT_rating`
        )
        VALUES(:name, :yor, :cor, :IMDb, :RT);';

        $sth = $dbh->prepare($query);
        $sth->bindParam(':name', $name);
        $sth->bindParam(':yor', $yor);
        $sth->bindParam(':cor', $cor);
        $sth->bindParam(':IMDb', $IMDb);
        $sth->bindParam(':RT', $RT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        $query = 'SELECT LAST_INSERT_ID();';
        $sth = $dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['status:' =>'success',
            'id:' => $result[0]["LAST_INSERT_ID()"]]);
        die(http_response_code(200));
    }
    else{
        error_log('api: unauthorized attempt to access the table', 3, $destination = 'log/security.log');
        die(http_response_code(403));
    }
}
catch (PDOException $exception) {
    $_SESSION['is_auth'] = false;
    error_log('login: '.$exception->getMessage().PHP_EOL, 3, $destination = 'log/error.log');
    die(json_encode([]));
}
$dbh = null;
$sth = null;