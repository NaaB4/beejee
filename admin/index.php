<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


include "../components/constants.php";
include "../components/autoload.php";

use app\components\Router;
use app\models\Users;

if(!Users::isAdmin()) header("Location: /user/login");

Router::init();