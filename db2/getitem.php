<?php
declare(strict_types=1);
ini_set('error_log', __DIR__ . '/error.log');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!array_key_exists('ID', $_GET) || $_GET['ID'] == null) {
            error_log('getitem: wrong request params');
            die(json_encode([]));
        }

        $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query =
            'SELECT
                `actors`.*,
                `actors_family`.`partner`,
                `children`
            FROM
                `actors`
            LEFT JOIN `actors_family` USING(`ID_actor`)
            WHERE
                `actors`.`ID_actor` = ?';
        $sth = $dbh->prepare($query);
        $ID = $_GET["ID"];
        $sth->execute( [$ID] );
        $result['Main_info'] = $sth->fetchAll(PDO::FETCH_ASSOC);

        $query =
            'SELECT
                `films`.*
            FROM
                `actors`
            LEFT JOIN `films-actors` USING(`ID_actor`)
            LEFT JOIN `films` USING(`ID_film`)
            WHERE
                `actors`.`ID_actor` = ?;';
        $sth = $dbh->prepare($query);
        $sth->execute( [$ID] );
        $result['Linked_Records'] = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
        $dbh = null;
        $sth = null;
    }
    else{
        error_log("getitem: wrong request method");
        echo http_response_code(400);
    }
}
catch (PDOException $exception) {
    $dbh = null;
    error_log('getitem:' . $exception->getMessage());
    die(json_encode([]));
}
