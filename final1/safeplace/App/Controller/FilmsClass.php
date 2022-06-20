<?php

namespace App\Controller;

class FilmsClass extends DBClass
{
    public function list()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $query =
                'SELECT
                    `films`.*,
                    `awards`.`award`,
                    `date`
                FROM
                    `films`
                LEFT JOIN `awards` USING (`ID_film`);';

            $queryParams = [];

            $data = $this->queryFetchAll($query, $queryParams);
            return json_encode($data);
        }
        else
        {
            $this->errorLogger->logEvent('msg: wrong request method', __FILE__, __LINE__, __FUNCTION__);
            return(http_response_code(400));
        }
    }

    public function get()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            if (array_key_exists('id', $_GET) && $_GET['id'] != null)
            {
                $id = $_GET['id'];
            }
            else
            {
                $this->errorLogger->logEvent('msg: there is a typo in id param name or no id given', __FILE__, __LINE__, __FUNCTION__);
                die(json_encode([]));
            }

            $query =
                'SELECT
                    `films`.*,
                    `awards`.`award`,
                    `date`
                FROM
                    `films`
                LEFT JOIN `awards` USING(`ID_film`)
                WHERE
                    `films`.`ID_film` = :id;';

            $data['Main_info'] = $this->queryFetchAll($query, [':id' => $id]);

            $query =
                'SELECT
                    `actors`.*
                FROM
                    `films`
                LEFT JOIN `films-actors` USING(`ID_film`)
                LEFT JOIN `actors` USING(`ID_actor`)
                WHERE
                    `films`.`ID_film` = :id;';

            $data['Linked_records'] = $this->queryFetchAll($query, [':id' => $id]);

            return json_encode($data);
        }
        else
        {
            $this->errorLogger->logEvent('msg: wrong request method', __FILE__, __LINE__, __FUNCTION__);
            die(http_response_code(400));
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (array_key_exists('film_name', $_POST) &&
                !empty($_POST['film_name']) &&
                array_key_exists('year_of_release', $_POST) &&
                !empty($_POST['year_of_release']) &&
                array_key_exists('country_of_release', $_POST) &&
                !empty($_POST['country_of_release']) &&
                array_key_exists('IMDb_rating', $_POST) &&
                !empty($_POST['IMDb_rating']) &&
                array_key_exists('RT_rating', $_POST) &&
                !empty($_POST['RT_rating'])){
                $queryParams = [
                    ':name' => $_POST['film_name'],
                    ':yor' => $_POST['year_of_release'],
                    ':cor' => $_POST['country_of_release'],
                    ':IMDb' => $_POST['IMDb_rating'],
                    ':RT' => $_POST['RT_rating']
                ];
            }
            else
            {
                $this->errorLogger->logEvent('msg: there is an optional param missing or there is a typo in ones name', __FILE__, __LINE__, __FUNCTION__);
                echo json_encode(['status' => 'error', 'message' => 'Failed to add record']);
                die(http_response_code(400));
            }

            $query =
                'INSERT INTO `films`(
                    `film_name`,
                    `year_of_release`,
                    `country_of_release`,
                    `IMDb_rating`,
                    `RT_rating`
                    )
                VALUES(:name, :yor, :cor, :IMDb, :RT);';


            $this->queryFetchAll($query, $queryParams);

            $query = 'SELECT LAST_INSERT_ID();';
            $data = $this->queryFetchAll($query, []);
            return json_encode(['status:' =>'success', 'id:' => $data[0]["LAST_INSERT_ID()"]]);
        }
        else
        {
            $this->errorLogger->logEvent('msg: wrong request method', __FILE__, __LINE__, __FUNCTION__);
            die(http_response_code(400));
        }
    }

    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $valid_params = ['id', 'film_name', 'year_of_release', 'country_of_release', 'IMDb_rating', 'RT_rating'];
            if (array_key_exists('id', $_POST) && $_POST['id'] != null)
            {
                $id = $_POST['id'];
            }
            else
            {
                $this->errorLogger->logEvent('msg: there is a typo in id param name or no id given', __FILE__, __LINE__, __FUNCTION__);
                echo json_encode(['status' => 'error', 'message' => 'Failed to edit record']);
                die(http_response_code(400));
            }

            foreach ($_POST as $key => $param)
            {
                if (!in_array($key, $valid_params))
                {
                    $this->errorLogger->logEvent('msg: there must be a typo in params name', __FILE__, __LINE__, __FUNCTION__);
                    echo json_encode(['status' => 'error', 'message' => 'Failed to edit record']);
                    die(http_response_code(400));
                }
            }

            $query =
                'SELECT
                    *
                FROM
                    `films`
                WHERE
                    `ID_film` = :id;';

            $data = $this->queryFetchAll($query, [':id' => $id]);

            $params = [
                ':id' => $id,
                ':film_name' => null,
                ':year_of_release' => null,
                ':country_of_release' => null,
                ':IMDb_rating' => null,
                ':RT_rating' => null
            ];
            foreach ($params as $param => &$value)
            {
                $param = trim($param, ':');
                if ($param != ':id')
                {
                    if (array_key_exists($param, $_POST))
                    {
                        $value = $_POST[$param];
                    }
                    else
                    {
                        $value = $data[0][$param];
                    }
                }
            }

            $query =
                'UPDATE
                    `films`
                SET
                    `film_name` = :film_name,
                    `year_of_release` = :year_of_release,
                    `country_of_release` = :country_of_release,
                    `IMDb_rating` = :IMDb_rating,
                    `RT_rating` = :RT_rating
                WHERE
                    `films`.`ID_film` = :id;';

            $this->queryFetchAll($query, $params);

            return json_encode(['status:' => 'success', 'id:' => $id]);

        }
        else
        {
            $this->errorLogger->logEvent('msg: wrong request method', __FILE__, __LINE__, __FUNCTION__);
            die(http_response_code(400));
        }
    }

    public function delete()
    {
        $_DELETE = array();
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
        {
            $deletedata = file_get_contents('php://input');
            $exploded = explode('&', $deletedata);
            foreach ($exploded as $pair)
            {
                $item = explode('=', $pair);
                if (count($item) == 2)
                {
                    $_DELETE[urldecode($item[0])] = urldecode($item[1]);
                }
            }

            if (array_key_exists('id', $_DELETE) && $_DELETE['id'] != null)
            {
                $id = $_DELETE['id'];
            }
            else
            {
                $this->errorLogger->logEvent('msg: there is a typo in id param name or no id given', __FILE__, __LINE__, __FUNCTION__);
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete record']);
                die(http_response_code(400));
            }

            $query =
                'DELETE
                FROM
                    `films`
                WHERE
                    `films`.`ID_film` = :id;';

            $this->queryFetchAll($query, [':id' => $id]);

            return json_encode(['status' => 'success', 'id' => $id]);


        }
        else
        {
            $this->errorLogger->logEvent('msg: wrong request method', __FILE__, __LINE__, __FUNCTION__);
            die(http_response_code(400));
        }

    }
}
