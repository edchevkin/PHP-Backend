<?php

namespace App\Controller;
use PDO;
use App\Logger\LoggerInterface;

abstract class DBClass
{
    protected PDO $dbh;
    protected LoggerInterface $errorLogger;
    protected LoggerInterface $securityLogger;
    protected LoggerInterface $eventLogger;

    public function __construct(PDO $dbh, LoggerInterface $errorLogger,  LoggerInterface $securityLogger, LoggerInterface $eventLogger)
    {
        $this->dbh = $dbh;
        $this->errorLogger = $errorLogger;
        $this->securityLogger = $securityLogger;
        $this->eventLogger = $eventLogger;
    }

    protected function queryFetchAll($query, $queryParams)
    {
        $this->eventLogger->logEvent('query: '.$query, __FILE__, __LINE__, __FUNCTION__);
        $this->eventLogger->logEvent('params: '.var_export($queryParams, true), __FILE__, __LINE__, __FUNCTION__);
        $sth = $this->dbh->prepare($query);
        $sth->execute($queryParams);
        return $sth->fetchAll();
    }
}
