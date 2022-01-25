<?php
declare(strict_types=1);
ini_set('error_log', __DIR__ . '/error.log');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (array_key_exists('name', $_POST) &&
            !empty($_POST['name']) &&
            array_key_exists('lastname', $_POST) &&
            !empty($_POST['lastname']) &&
            array_key_exists('yob', $_POST) &&
            !empty($_POST['yob']) &&
            array_key_exists('cob', $_POST) &&
            !empty($_POST['cob']) &&
            array_key_exists('csy', $_POST) &&
            !empty($_POST['csy'])){
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $yob = $_POST['yob'];
            $cob = $_POST['cob'];
            $csy = $_POST['csy'];
        }
        else {
            error_log('additem2: Failed to add item');
            echo json_encode(['status' => 'error',
                'message' => 'Failed to add record']);
            die(http_response_code(400));
        }

        $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query =
            'INSERT INTO `actors`(
                `first_name`,
                `last_name`,
                `year_of_birth`,
                `country_of_birth`,
                `career_start_year`
            )
            VALUES(:name, :lastname, :yob, :cob, :csy);';

        $sth = $dbh->prepare($query);
        $sth->bindParam(':name', $name);
        $sth->bindParam(':lastname', $lastname);
        $sth->bindParam(':yob', $yob);
        $sth->bindParam(':cob', $cob);
        $sth->bindParam(':csy', $csy);

        $sth->execute();

        $query = 'SELECT LAST_INSERT_ID();';
        $sth = $dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['status:' =>'success',
            'id:' => $result[0]["LAST_INSERT_ID()"]]);
        $dbh = null;
        $sth = null;
    }
    else{
        error_log("additem2: wrong request method");
        die(http_response_code(400));
    }
}
catch (PDOException $exception) {
    $dbh = null;
    error_log("additem2:".$exception->getMessage());
    die(json_encode([]));
}
