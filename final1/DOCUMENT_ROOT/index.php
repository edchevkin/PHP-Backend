<?php
require_once '../safeplace/settings.inc.php';
require_once MODULES_DIR.'autoloader.php';

use App\EventHandler;
use App\Logger\FileLoggerBuf;

$errorLogger = new FileLoggerBuf(errorLogPath, 1);
$securityLogger = new FileLoggerBuf(securityLogPath, 1);
$eventLogger = new FileLoggerBuf(eventLogPath, 1);

try{
    session_start();
    $app = new EventHandler($dbSettings, $errorLogger, $securityLogger, $eventLogger);
    $app->run();
}
catch (Exception $e)
{
    $errorLogger->logEvent($e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
    echo json_encode([]);
}

