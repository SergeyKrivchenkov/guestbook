<?php

namespace app\core;

session_start();

abstract class Controller
{
    protected $route;
    protected $view;
    protected $model;
    public function __construct($route)
    {

        $this->route = $route;
        $this->view = new View($route);
        $model_name = '\app\models\\' . ucfirst($route['controller']);
        $this->model = new $model_name;
        // debug($_SERVER);
    }
}
