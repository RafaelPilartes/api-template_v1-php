<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use app\core\Router;

require_once '../vendor/autoload.php';

session_start();

Router::run();
