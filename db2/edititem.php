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
                `films`
            WHERE
                `ID_film` = ?;';
        $sth = $dbh->prepare($query);
        $sth->execute([$ID]);
        $info = $sth->fetchAll(PDO::FETCH_ASSOC);

        $name = null;
        $yor = null;
        $cor = null;
        $IMDb = null;
        $RT = null;

        if (array_key_exists('name', $_POST)){
            $name = $_POST['name'];
        }
        else{
            $name = $info[0]['film_name'];
        }
        if (array_key_exists('yor', $_POST)){
            $yor = $_POST['yor'];
        }
        else{
            $yor = $info[0]['year_of_release'];
        }
        if (array_key_exists('cor', $_POST)){
            $cor = $_POST['cor'];
        }
        else{
            $cor = $info[0]['country_of_release'];
        }
        if (array_key_exists('IMDb', $_POST)){
            $IMDb = $_POST['IMDb'];
        }
        else{
            $IMDb = $info[0]['IMDb_rating'];
        }
        if (array_key_exists('RT', $_POST)){
            $RT = $_POST['RT'];
        }
        else{
            $RT = $info[0]['RT_rating'];
        }

        //QUERY FOR UPDATING
        $query =
            'UPDATE
                `films`
            SET
                `film_name` = :name,
                `year_of_release` = :yor,
                `country_of_release` = :cor,
                `IMDb_rating` = :IMDb,
                `RT_rating` = :RT
            WHERE
                `films`.`ID_film` = :id;';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':name', $name);
        $sth->bindParam(':yor', $yor);
        $sth->bindParam(':cor', $cor);
        $sth->bindParam(':IMDb', $IMDb);
        $sth->bindParam(':RT', $RT);
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
