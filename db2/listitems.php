<?php
declare(strict_types=1);
ini_set('error_log', __DIR__ . '/error.log');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query =
            'SELECT
                `films`.*,
                `awards`.`award`,
                `date`
            FROM
                `films`
            LEFT JOIN `awards` USING(`ID_film`);';

        $sth = $dbh->prepare($query);
        $sth->execute();
        echo json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
        $dbh = null;
        $sth = null;
    }
    else{
        error_log("listitems: wrong request method");
        die(http_response_code(400));
    }
}
catch (PDOException $exception) {
    $dbh = null;
    error_log('listitems:'.$exception->getMessage());
    die(json_encode([]));
}
