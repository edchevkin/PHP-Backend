<?php
declare(strict_types=1);
ini_set('error_log', __DIR__ . '/error.log');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' ||
        $_SERVER['REQUEST_METHOD'] == 'PUT') {
        if (array_key_exists('name', $_POST) &&
            array_key_exists('yor', $_POST) &&
            array_key_exists('cor', $_POST) &&
            array_key_exists('IMDb', $_POST) &&
            array_key_exists('RT', $_POST)){
            $name = $_POST['name'];
            $yor = $_POST['yor'];
            $cor = $_POST['cor'];
            $IMDb = $_POST['IMDb'];
            $RT = $_POST['RT'];
        }
        else {
            echo json_encode(['status' => 'error',
                'message' => 'Failed to add record']);
            die(http_response_code(400));
        }

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

        $query = 'SELECT LAST_INSERT_ID();';
        $sth = $dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['status:' =>'success',
            'id:' => $result[0]["LAST_INSERT_ID()"]]);
    }
    else{
        error_log("additem1: wrong request method");
        die(http_response_code(400));
    }
    $dbh = null;
    $sth = null;
}
catch (PDOException $exception) {
    $dbh = null;
    error_log("additem1:".$exception->getMessage());
    die(json_encode([]));
}

