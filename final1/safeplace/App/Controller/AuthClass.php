<?php

namespace App\Controller;

class AuthClass extends DBClass
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!array_key_exists('login', $_POST) || empty($_POST['login']))
            {
                $this->securityLogger->logEvent('no login specified in login request', __FILE__, __LINE__, __FUNCTION__);
                $_SESSION['is_auth'] = false;
                echo("Invalid credentials" . PHP_EOL);
                die(http_response_code(200));
            }
            if (!array_key_exists('password', $_POST) || empty($_POST['password']))
            {
                $this->securityLogger->logEvent('no password specified in login request', __FILE__, __LINE__, __FUNCTION__);
                $_SESSION['is_auth'] = false;
                echo("Invalid credentials" . PHP_EOL);
                die(http_response_code(200));
            }

            $login = $_POST['login'];
            $password = $_POST['password'];

            $query =
                'SELECT
                    *
                FROM
                    `users`
                WHERE
                    `login` = :login;';

            $data = $this->queryFetchAll($query, [':login' => $login]);
            if ($data == [])
            {
                $this->securityLogger->logEvent('nonexistent login has been used attempting to login', __FILE__, __LINE__, __FUNCTION__);
                echo 'Invalid credentials'.PHP_EOL;
                die(http_response_code(200));
            }

            $serv_password = $data[0]['password'];
            if ($serv_password != null && password_verify($password, $serv_password))
            {
                if (isset($_SESSION['is_auth']) && $_SESSION['is_auth'])
                {
                    $this->errorLogger->logEvent('already logged in', __FILE__, __LINE__, __FUNCTION__);
                    die('You are already logged in');
                }

                session_regenerate_id(true);
                $_SESSION['is_auth'] = true;
                $this->securityLogger->logEvent($login.' has logged in', __FILE__, __LINE__, __FUNCTION__);
                echo 'OK'.PHP_EOL;
                die(http_response_code(200));
            }
            else
            {
                $this->securityLogger->logEvent('wrong password has been used for user '.$login, __FILE__, __LINE__, __FUNCTION__);
                $_SESSION['is_auth'] = false;
                echo('Invalid credentials'.PHP_EOL);
                die(http_response_code(200));
            }
        }
        else
        {
            $this->errorLogger->logEvent('wrong request method', __FILE__, __LINE__, __FUNCTION__);
            die(http_response_code(400));
        }
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!isset($_SESSION['is_auth']) || !$_SESSION['is_auth'])
            {
                $this->errorLogger->logEvent('already logged out', __FILE__, __LINE__, __FUNCTION__);
                die('Already logged out'.PHP_EOL);
            }
            unset($_SESSION);
            session_destroy();
            session_start();
            echo ('OK'.PHP_EOL);
            die(http_response_code(200));
        }
        else{
            $this->errorLogger->logEvent('no password specified in login request', __FILE__, __LINE__, __FUNCTION__);
            die(http_response_code(400));
        }

    }
}
