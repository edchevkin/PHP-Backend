<?php
declare(strict_types=1);
ini_set('error_log', __DIR__ . '/error.log');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (array_key_exists('IDA', $_POST) &&
            $_POST['IDA'] != null &&
            array_key_exists('IDF', $_POST) &&
            $_POST['IDF'] != null){
            $IDA = $_POST['IDA'];
            $IDF = $_POST['IDF'];
        }
        else {
            error_log('addlink: bad params');
            echo json_encode(['status' => 'error',
                'message' => 'Failed to add record']);
            die(http_response_code(400));
        }


        $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query =
            'INSERT INTO `films-actors`(`ID_actor`, `ID_film`)
            VALUES(:IDA, :IDF)';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':IDA', $IDA);
        $sth->bindParam(':IDF', $IDF);
        $sth->execute();

        $query = 'SELECT LAST_INSERT_ID();';
        $sth = $dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['status:' =>'success',
            'id:' => $result[0]["LAST_INSERT_ID()"]]);;
        $dbh = null;
        $sth = null;

    } else {
        error_log("addlink: wrong request method");
        die(http_response_code(400));
    }
} catch (PDOException $exception) {
    $dbh = null;
    error_log('addlink:' . $exception->getMessage());
    die(json_encode([]));
}


