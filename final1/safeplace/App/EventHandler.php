<?php

namespace App;
use PDO;
use Exception;
use App\Logger\LoggerInterface;

class EventHandler
{
    private string $page;
    private PDO $dbh;
    protected array $handler;
    protected LoggerInterface $errorLogger;
    protected LoggerInterface $securityLogger;
    protected LoggerInterface $eventLogger;

    function __construct(array $dbSettings, LoggerInterface $errorLogger, LoggerInterface $securityLogger, LoggerInterface $eventLogger)
    {
        $this->errorLogger = $errorLogger;
        $this->securityLogger = $securityLogger;
        $this->eventLogger = $eventLogger;
        $page = array_key_exists('page', $_GET) ? $_GET['page'] : 'default';
        $this->initDB($dbSettings['connectionString'], $dbSettings['dbUser'], $dbSettings['dbPwd']);
        $this->setPage($page);
    }

    private function initDB(string $connectionString, string $dbUser, string $dbPwd)
    {
        $this->dbh = new PDO($connectionString, $dbUser, $dbPwd);
        $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function setPage(string $page)
    {
        if (!empty($page))
        {
            $this->page = $page;
            $query =
                'SELECT
                    *
                FROM
                    `system_pages`
                WHERE
                    `page` LIKE ?;';
            $sth = $this->dbh->prepare($query);
            $sth->execute([$this->page]);
            $data = $sth->fetchAll();
            if ((!isset($_SESSION['is_auth']) || $_SESSION['is_auth'] == false)
                && $data[0]['controller'] != 'AuthClass' && $data[0]['handler'] != 'list')
            {
                $this->securityLogger->logEvent('unauthorized attempt to access the '.$data[0]['page'].' api', __FILE__, __LINE__, __FUNCTION__);
                die(http_response_code(403));
            }
            if (!empty($data) && count($data) == 1)
            {
                $this->handler = $data[0];

            }
        }
        if (empty($this->handler))
        {
            $this->page = 'default';
            $this->handler = [
                'page' => 'default',
                'description' => 'Действие по умолчанию',
                'controller' => 'FilmsClass',
                'handler' => 'list'
            ];
        }
    }

    private function createController()
    {
        $controller = 'App\Controller\\'.$this->handler['controller'];
        $params = [
            $this->dbh,
            $this->errorLogger,
            $this->securityLogger,
            $this->eventLogger
        ];
        return new $controller(...$params);
    }

    private function getHandlerFunction()
    {
        return $this->handler['handler'];
    }

    public function run()
    {
        try
        {
            $controller = $this->createController();
            $handler = $this->getHandlerFunction();
            echo $controller->$handler();
        }
        catch (Exception $e)
        {
            $this->errorLogger->logEvent($e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
            echo json_encode([]);
        }
    }
}
