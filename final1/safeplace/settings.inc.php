<?php

const MODULES_DIR = '../safeplace/';
const DEBUG = true;

const errorLogPath = '../log/error.log';
const securityLogPath = '../log/security.log';
const eventLogPath = '../log/event.log';

const sessPath = '../session/';
ini_set('session.save_path', sessPath);

$dbSettings = [
    'connectionString' => 'mysql:host=localhost;dbname=db2',
    'dbUser' => 'egor',
    'dbPwd' => '1234'
];
