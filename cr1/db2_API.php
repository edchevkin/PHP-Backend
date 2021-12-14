<?php
var_dump($_GET);

if ($_GET["type"] == "by_speciality") {
    $table = students_by_speciality($_GET["speciality_name"]);
    print_r($table);
}

function students_by_speciality(string $speciality_name){
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=db2', 'egor', '1234');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] != 'GET'){
            $dbh = null;
            echo die('Студенты не найдены');
        }

        $query = "SELECT st.`lastname`, st.`firstname`, g.`grnum`, sp.`speciality_name` 
                    FROM `students` st LEFT JOIN `groups` g ON st.`grid` = g.`grid`
                    LEFT JOIN `specialities` sp ON g.`speciality_id` = sp.`speciality_id`
                    WHERE sp.`speciality_name` LIKE ?";

        $sth = $dbh->prepare($query);
        $sth->execute( [$speciality_name] );

        $table = $sth->fetchAll();

        $dbh = null;
        $sth = null;

        return json_encode($table);
    }
    catch (PDOException $e) {
        print "Error!:" . $e->getMessage() . '<br/>'; # поменять сообщение об ошибке
        $dbh = null;
    }
}
