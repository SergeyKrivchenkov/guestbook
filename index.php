<?php
require_once 'app/lib/debug.php';
//debug($_SERVER['REMOTE_ADDR'] . '<br>' . $_SERVER['HTTP_USER_AGENT']); // ip adress & HTTP
use app\core\Router;

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once "{$class}.php";
});
$router = new Router();
$router->run();
