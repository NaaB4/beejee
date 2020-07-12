<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

include __DIR__."/components/constants.php";
include __DIR__."/components/autoload.php";

use app\components\Router;


Router::init();