<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 12/11/18
 * Time: 23:51
 */

namespace App\Src\Http;

use App\Src\Http\HttpRequest\Request;
use App\Src\Http\HttpRequest\RequestInterface;

class Router
{
    private $request;

    private $supportedHttpMethods = [
        "GET",
        "POST",
        "PUT",
        "DELETE"
    ];

    /**
     * Initialize Router
     */
    function __construct()
    {
        $this->request = Request::singleton();
    }

    /**
    * Call method action
    */
    function __call($name, $args)
    {
        list($route, $method) = $args;

        if(!in_array(strtoupper($name), $this->supportedHttpMethods))
        {
            $this->invalidMethodHandler();
        }
        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
    * Removes trailing forward slashes from the right of the route.
    * @param string $route
     * @return string $route_clear
    */
    private function formatRoute($route)
    {
        $route_clear = rtrim($route, '/');
        if ($route_clear === '')
        {
            return '/';
        }
        return $route_clear;
    }

    /**
    * Validate Method
    */
    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    /**
    * Route Not Found
    */
    private function defaultRequestHandler()
    {
        header("{$this->request->serverProtocol} 404 Not Found");
    }

    /**
     * Resolves a route
     */
    private function resolve($injects = [])
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);
        $method = $methodDictionary[$formatedRoute];

        if (is_null($method)) {
            $this->defaultRequestHandler();
            return;
        }

        if (is_string($method)) {
            list($controller, $method) = explode("@",$method);

            $reflection = new \ReflectionMethod($controller,$method);

            foreach ($reflection->getParameters() as $param) {
                $selfClass = $param->getClass();
                $objclass = new $selfClass->name();

                if (method_exists($objclass, 'singleton')) {
                    $objclass = ($selfClass->name)::singleton();
                }

                array_push($injects, $objclass);
            }

            $controller = new $controller();

            if (count($injects) > 0) {
                echo call_user_func_array([$controller,$method],$injects);
            } else {
                echo $controller->{$method}();
            }

        }
        else {
            echo call_user_func_array($method, array($this->request));
        }
    }

    public function __destruct()
    {
        $this->resolve();
    }
}