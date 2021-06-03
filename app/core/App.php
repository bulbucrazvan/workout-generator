<?php
require_once(__DIR__ . "/../Utility/SessionUtils.php");
require_once(__DIR__ . "/../Utility/Redirect.php");

class App {
    protected $controller = 'welcome';
    protected $controllerObject;
    protected $method = 'index';
    protected $params = [];

    public function __construct(){
        SessionUtils::startSession();

        if (SessionUtils::isLoggedIn()) {
            $this->controller = 'home';
        }

        $url = $this->parseURL();

        if (isset($url[0])){
            if (file_exists('../app/controllers/' . $url[0] . '.php')){
                $this->controller = $url[0];
                unset($url[0]);
            }
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controllerObject = new $this->controller;

        if (isset($url[1])){
            if (method_exists($this->controllerObject, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controllerObject, $this->method], $this->params);

    }

    protected function parseURL(){
        if (isset($_GET['url'])){
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}

?>