<?php

session_start();

use rave\core\Config;

$webRoot = dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME'));

/**
* Some useful constants
*/
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__));
define('SRC', ROOT . DS . 'src');
define('APP', SRC . DS . 'app');
define('WEB_ROOT', $webRoot === '/' ? '' : $webRoot);

/**
* Include the autoloader
*/
require_once ROOT . '/vendor/autoload.php';

Config::addArray(require 'app.php');