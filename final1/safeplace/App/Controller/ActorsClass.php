<?php

namespace App\Controller;

class ActorsClass extends DBClass
{
    public function list()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $query =
                'SELECT
                    `actors`.*,
                    `actors_family`.`partner`,
                    `children`
                FROM
                    `actors`
                LEFT JOIN `actors_family` USING (`ID_actor`);';

            $queryParams = [];

            $data = $this->queryFetchAll($query, $queryParams);
            return json_encode($data);
        }
        else
        {
            $this->errorLogger->logEvent('msg: wrong request method', __FILE__, __LINE__, __FUNCTION__);
            die(http_response_code(400));
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
                $this->errorLogger->logEvent('msg: wrong id or no id given', __FILE__, __LINE__, __FUNCTION__);
                die(json_encode([]));
            }

            $query =
                'SELECT
                    `actors`.*,
                    `actors_family`.`partner`,
                    `children`
                FROM
                    `actors`
                LEFT JOIN `actors_family` USING(`ID_actor`)
                WHERE
                    `actors`.`ID_actor` = :id;';

            $data['Main_info'] = $this->queryFetchAll($query, [':id' => $id]);

            $query =
                'SELECT
                    `films`.*
                FROM
                    `actors`
                LEFT JOIN `films-actors` USING(`ID_actor`)
                LEFT JOIN `films` USING(`ID_film`)
                WHERE
                    `actors`.`ID_actor` = :id;';

            $data['Linked_records'] = $this->queryFetchAll($query, [':id' => $id]);

            return json_encode($data);
        }
        else
        {
            $this->errorLogger->logEvent('msg: wrong request message', __FILE__, __LINE__, __FUNCTION__);
            die(http_response_code(400));
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (array_key_exists('first_name', $_POST) &&
                !empty($_POST['first_name']) &&
                array_key_exists('last_name', $_POST) &&
                !empty($_POST['last_name']) &&
                array_key_exists('year_of_birth', $_POST) &&
                !empty($_POST['year_of_birth']) &&
                array_key_exists('country_of_birth', $_POST) &&
                !empty($_POST['country_of_birth']) &&
                array_key_exists('career_start_year', $_POST) &&
                !empty($_POST['career_start_year'])){
                $name = $_POST['first_name'];
                $lastname = $_POST['last_name'];
                $yob = $_POST['year_of_birth'];
                $cob = $_POST['country_of_birth'];
                $csy = $_POST['career_start_year'];
            }
            else
            {
                $this->errorLogger->logEvent('msg: a param is wrong. Check them again', __FILE__, __LINE__, __FUNCTION__);
                echo json_encode(['status' => 'error', 'message' => 'Failed to add record']);
                die(http_response_code(400));
            }

            $query =
                'INSERT INTO `actors`(
                    `first_name`,
                    `last_name`,
                    `year_of_birth`,
                    `country_of_birth`,
                    `career_start_year`
                    )
                VALUES(:name, :lastname, :yob, :cob, :csy);';

            $queryParams = [
                ':name' => $name,
                ':lastname' => $lastname,
                ':yob' => $yob,
                ':cob' => $cob,
                ':csy' => $csy
            ];

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
            $valid_params = ['id', 'first_name', 'last_name', 'year_of_birth', 'country_of_birth', 'career_start_year'];
            if (array_key_exists('id', $_POST) && $_POST['id'] != null)
            {
                $id = $_POST['id'];
            }
            else
            {
                $this->errorLogger->logEvent('msg: wrong id param name or no id given', __FILE__, __LINE__, __FUNCTION__);
                echo json_encode(['status' => 'error', 'message' => 'Failed to edit record']);
                die(http_response_code(400));
            }

            foreach ($_POST as $key => $param)
            {
                if (!in_array($key, $valid_params))
                {
                    $this->errorLogger->logEvent('msg: there is a typo in one of the optional param name', __FILE__, __LINE__, __FUNCTION__);
                    echo json_encode(['status' => 'error', 'message' => 'Failed to edit record']);
                    die(http_response_code(400));
                }
            }

            $query =
                'SELECT
                    *
                FROM
                    `actors`
                WHERE
                    `ID_actor` = :id;';

            $data = $this->queryFetchAll($query, [':id' => $id]);


            $params = [
                ':id' => $id,
                ':first_name' => null,
                ':last_name' => null,
                ':year_of_birth' => null,
                ':country_of_birth' => null,
                ':career_start_year' => null
            ];
            foreach ($params as $param => &$value)
            {
                $param = trim($param, ':');
                if ($param != 'id')
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
                    `actors`
                SET
                    `first_name` = :first_name,
                    `last_name` = :last_name,
                    `year_of_birth` = :year_of_birth,
                    `country_of_birth` = :country_of_birth,
                    `career_start_year` = :career_start_year
                WHERE
                    `actors`.`ID_actor` = :id;';

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
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $deletedata = file_get_contents('php://input');
            $exploded = explode('&', $deletedata);
            foreach ($exploded as $pair) {
                $item = explode('=', $pair);
                if (count($item) == 2) {
                    $_DELETE[urldecode($item[0])] = urldecode($item[1]);
                }
            }

            if (array_key_exists('id', $_DELETE) &&  $_DELETE['id'] != null)
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
                    `actors`
                WHERE
                    `actors`.`ID_actor` = :id;';

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