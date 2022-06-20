<?php

if (!defined('MODULES_DIR')) {
    throw new RuntimeException('config not set');
}

spl_autoload_register(
    function ($class_name)
    {
        if (file_exists(MODULES_DIR.$class_name.'.php'))
        {
            require MODULES_DIR.$class_name.'.php';
        }
    }
);
