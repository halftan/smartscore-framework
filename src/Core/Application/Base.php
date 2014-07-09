<?php
namespace SmartscoreFramework\Core\Application;

use SmartscoreFramework\Core\Router\Router;
use SmartscoreFramework\Core\Router\Route;
use SmartscoreFramework\Core\Exception\RouteNotFoundException;
use SmartscoreFramework\Controller\BasicController;
use SmartscoreFramework\View\View;

class Base {

    #
    # @var array Contains path info.
    #   keys:
    #       - root
    #       - public
    #       - config
    #       - controller
    #       - view
    #       - model
    private $paths;

    # @var array
    #   keys:
    #       - controller
    #       - model
    #       - view
    private $classSuffix;

    # @var string
    # namespace of user application
    private $namespace;

    # @var Router
    private $router;

    public function __construct($namespace, $paths, $classSuffix) {
        $this->paths       = $paths;
        $this->classSuffix = $classSuffix;
        $this->namespace   = $namespace;
    }

    public function getRouter() {
        if ($this->router == null) {
            $this->router = Router::getInstance();
        }
        return $this->router;
    }

    public function run() {
        # Find route
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $uri    = $_SERVER['REQUEST_URI'];
            $route  = $this->router->findRoute($method, $uri);
            if (empty($route)) {
                throw new RouteNotFoundException("No route found for uri {$uri}.");
            }

            # Inflate uri params
            $params = $route->inflateParams($uri);

            # Get the controller or view name
            $viewOrController = $route->call($this, $params);
            if ($viewOrController instanceof BasicController) {
                $viewName  = $viewOrController->getView();
                $viewParam = $viewOrController->getViewParam();
            } else {
                $viewName = $viewOrController;
            }

            # Render the view
            if (!empty($viewName)) {
                $view = new View($this, $viewName);
                echo $view->render($viewParam);
            }
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    public function buildCallable($classname, $type) {
        switch ($type) {
            case 'controller':
                return "$this->namespace"."\\".ucfirst($this->classSuffix['controller'])
                    ."\\".ucfirst($classname).ucfirst($this->classSuffix['controller']);
                break;
            case 'model':
                return "$this->namespace"."\\".ucfirst($this->classSuffix['model'])
                    ."\\".ucfirst($classname);
                break;
            case 'view':
                return "$this->namespace"."\\".ucfirst($this->classSuffix['view'])
                    ."\\".ucfirst($classname);
                break;
            default:
                throw new \Exception("Unknown callable type ".
                    "(must in [controller, model, view]).");
                break;
        }
    }

    public function getPath($path) {
         return $this->paths[$path];
    }

    public function getSuffix($type) {
         return $this->classSuffix[$type];
    }

}
