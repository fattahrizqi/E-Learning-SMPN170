<?php

require_once 'controllers/Controller.php';
require_once 'config/config.php';
require_once 'database/database.php';
// middleware
require_once 'middlewares/AuthMiddleware.php';

// helpers
spl_autoload_register(function( $class ){
    $class = explode('\\', $class);
    $class = end($class);
    require_once __DIR__ . '/helpers/' . $class . '.php';
});

class App {

    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() 
    {
        $url = $this->parseURL();
        
        /* Controller Init */
        if (!empty($url)) {
            if (file_exists('app/controllers/' . $url[0] . 'controller.php')) {
                $this->controller = $url[0] . 'controller';
                unset($url[0]);
            }
        }
        
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        /* Method Init */
        if ( isset($url[1]) ) {
            if ( method_exists($this->controller, $url[1]) ) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        /* Parameter */
        if ( !empty($url) ) {
            $this->params = array_values($url);
        }

        /* Start Controller & Method and Send Params */
        call_user_func_array([$this->controller, $this->method], $this->params);

    }

    public function parseURL() 
    {
        if ( isset($_GET['url'] )) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

}