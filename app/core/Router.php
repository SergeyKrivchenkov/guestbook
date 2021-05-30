<?php

namespace app\core;

class Router
{
    private $routes = [];
    private $params = [];
    public function __construct()
    {
        // echo __CLASS__;
        $routes_arr = require_once 'app/config/routes.php';
        // debug($routes_arr);
        foreach ($routes_arr as $route => $params) {
            $this->add($route, $params);
        }
    }
    private function add($route, $params)
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    private function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $url = $this->removeQueryString($url); //очистка url от get запроса
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                // debug($params);
                return true;
            }
        }
        return false;
    }

    private function removeQueryString($url) // это как бы фильтр перед тем как проводить последующие операции
    {
        //'catalogue?page=3'
        $params = explode('?', $url); // разбираем строку (1 параметр делимитер = ? т.е разделитель, 2 это с чем работаем с какой строкой)
        return $params[0];
        //debug($params); // результат [0] => catalogue [1] => page=4 т.о разделили строку на 2 стоставляющее.
    }

    public function run()
    {
        if ($this->match()) {
            $controller_name = '\app\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($controller_name)) {
                $controller = new $controller_name($this->params);
                $action_name = $this->params['action'] . 'Action';
                if (method_exists($controller, $action_name)) {
                    $controller->$action_name();
                } else {
                    echo 'Method' . $action_name . 'does not exist';
                }
            } else {
                echo 'Controller' . $controller_name . 'does not exist';
            }
        } else {
            echo 'Rout' . $_SERVER['REQUEST_URI'] . 'does not exist';
        }
    }
}
