<?php

declare(strict_types=1);
ini_set('error_log', __DIR__ . '/error.log');

try {
    $_DELETE = array();
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        $deletedata = file_get_contents('php://input');
        $exploded = explode('&', $deletedata);
        foreach ($exploded as $pair) {
            $item = explode('=', $pair);
            if(count($item) == 2) {
                $_DELETE[urldecode($item[0])] = urldecode($item[1]);
            }
        }
        if (!array_key_exists('ID', $_DELETE) || (int) $_DELETE['ID'] == null){
            error_log('deleteitem: Wrong params');
            echo json_encode(['status' => 'error',
                'message' => 'Failed to delete record']);
            die(http_response_code(400));
        }
        $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $ID = (int) $_DELETE['ID'];


        $query =
            'DELETE
            FROM
                `films`
            WHERE
                `films`.`ID_film` = ?;';
        $sth = $dbh->prepare($query);
        $sth->execute( [$ID] );

        echo json_encode(['status' => 'success',
                        'id' => $ID]);
        $sth = null;
        $dbh = null;

    }
    else{
        error_log("deleteitem: wrong request method");
        die(http_response_code(400));
    }
}
catch (PDOException $exception) {
    $dbh = null;
    error_log("deleteitem:" . $exception->getMessage());
    die(json_encode([]));
}
