<?php

namespace Core\Routing;

use \Core\ORM\Database;

class Router {

    public $routes;
    protected $requestUri;
    const GET_PARAMS_DELIMITER = '?';

    public function __construct($requestUri) {
        $this->routes = [];
        $this->setRequestUri($requestUri);
    }

    public function setRequestUri($requestUri) {
        if (strpos($requestUri, self::GET_PARAMS_DELIMITER))
        {
            $requestUri = strstr($requestUri, self::GET_PARAMS_DELIMITER, true);
        }
        $this->requestUri = $requestUri;
    }

    public function getRequestUri() {
        return $this->requestUri;
    }

    public function add($uri, $closure) {
        $route = new \Core\Routing\Route($uri, '\\App\\Controllers\\'.$closure);
        array_push($this->routes, $route);
    }

    public function run() {
        $response = false;
        $n = "";
        $requestUri = $this->getRequestUri();

        $regRoutes = Database::query("SELECT * FROM Routes WHERE method = '" . $_SERVER['REQUEST_METHOD'] . "';");

        foreach ($regRoutes as $reg) {
            if ($GLOBALS['config']["path"]["root"] != "") {
                $this->add("/".$GLOBALS['config']["path"]["root"].$reg['request_uri'], $reg['action']);
            }else{
                $this->add($reg['request_uri'], $reg['action']);
            }
        }
        
        foreach ($this->routes as $route)
        {
            if ($route->checkIfMatch($requestUri))
            {
                $n = true;
                $response = $route->execute();
                break;
            }
        }
        if ($n && $response == null) {
            $response = "";
        }
        $this->sendResponse($response);
    }

    public function sendResponse($response)
    {
        if ( is_string($response) ) {
            echo $response;
        }
        else if ( is_array($response) || is_object($response) ) {
            header('Content-Type: application/json');
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        else {
            header("HTTP/1.0 404 Not Found");
            exit('404');
        }
    }
}