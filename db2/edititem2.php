<?php
declare(strict_types=1);
ini_set('error_log', __DIR__ . '/error.log');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!array_key_exists('ID', $_POST) || $_POST['ID'] == null) {
            error_log('edititem: Wrong params');
            echo json_encode(['status' => 'error',
                'message' => 'Failed to edit record']);
            die(http_response_code(400));
        }

        $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $ID = $_POST['ID'];
        $query =
            'SELECT
                *
            FROM
                `actors`
            WHERE
                `ID_actor` = ?;';
        $sth = $dbh->prepare($query);
        $sth->execute([$ID]);
        $info = $sth->fetchAll(PDO::FETCH_ASSOC);

        $name = null;
        $lastname = null;
        $yob = null;
        $cob = null;
        $csy = null;

        if (array_key_exists('name', $_POST)){
            $name = $_POST['name'];
        }
        else{
            $name = $info[0]['first_name'];
        }
        if (array_key_exists('lastname', $_POST)){
            $lastname = $_POST['lastname'];
        }
        else{
            $lastname = $info[0]['last_name'];
        }
        if (array_key_exists('yob', $_POST)){
            $yob = $_POST['yob'];
        }
        else{
            $yob = $info[0]['year_of_birth'];
        }
        if (array_key_exists('cob', $_POST)){
            $cob = $_POST['cob'];
        }
        else{
            $cob = $info[0]['country_of_birth'];
        }
        if (array_key_exists('csy', $_POST)){
            $csy = $_POST['csy'];
        }
        else{
            $csy = $info[0]['career_start_year'];
        }

        //QUERY FOR UPDATING
        $query =
            'UPDATE
                `actors`
            SET
                `first_name` = :name,
                `last_name` = :lastname,
                `year_of_birth` = :yob,
                `country_of_birth` = :cob,
                `career_start_year` = :csy
            WHERE
                `actors`.`ID_actor` = :id;';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':name', $name);
        $sth->bindParam(':lastname', $lastname);
        $sth->bindParam(':yob', $yob);
        $sth->bindParam(':cob', $cob);
        $sth->bindParam(':csy', $csy);
        $sth->bindParam(':id', $ID);
        $sth->execute();

        echo json_encode(['status:' => 'success',
            'id:' => $ID]);
        $dbh = null;
        $sth = null;
    }
    else{
        error_log("edititem: wrong request method");
        die(http_response_code(400));
    }
}
catch (PDOException $exception) {
    $dbh = null;
    error_log("edititem:".$exception->getMessage());
    die(json_encode([]));
}
