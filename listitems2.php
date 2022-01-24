<?php
declare(strict_types=1);
ini_set('error_log', __DIR__ . '/error.log');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query =
            'SELECT
                `actors`.*,
                `actors_family`.partner,
                `children`
            FROM
                `actors`
            LEFT JOIN `actors_family` USING(`ID_actor`);';

        $sth = $dbh->prepare($query);
        $sth->execute();
        echo json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
    }
    else{
        error_log("listitems2: wrong request method");
        die(http_response_code(400));
    }
    $dbh = null;
    $sth = null;
}
catch (PDOException $exception) {
    $dbh = null;
    error_log('listitems2:'.$exception->getMessage());
    die(json_encode([]));
}

