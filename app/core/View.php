<?php

namespace app\core;

class View
{
    protected $route;
    protected $path;
    protected $layout = 'default';
    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }
    public function render($data)
    {
        $layout = "app/views/layouts/{$this->layout}.php";
        $view = "app/views/{$this->path}.php";

        if (file_exists($view)) {
            ob_start();
            require_once $view;
            $content = ob_get_clean();
        } else {
            $content = 'error';
        }
        if (file_exists($layout)) {
            require_once $layout;
        } else {
            echo 'ERROR ';
        }
    }
}
