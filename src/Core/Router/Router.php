<?php
namespace SmartscoreFramework\Core\Router;

class Router {

    private static $routerCache = array();

    public static function getInstance() {
        if (!empty(self::$routerCache)) {
            return self::$routerCache;
        } else {
            self::$routerCache = new static;
            return self::$routerCache;
        }
    }

    #
    # Dynamic properties [array]:
    #   - getAction
    #   - postAction
    #   - putAction
    #   - deleteAction
    #   - ...Action
    #

    private function __construct($config = null) {
        if ($config !== null) {
            # TODO: Read config file.
        } else {
            $this->routeHash = array();
        }
    }

    #
    # @param string The request url pattern to register.
    #   Example: "/user/:name"
    #            "/user/:name/profile/:category"
    # @param mixed The target class or function to be bind to.
    #   Can be either string or an object.
    #
    public function register($pattern, $target, $method='get') {
        $method = strtolower($method);
        $prop   = $method.'Action';
        if (!isset($this->$prop)) {
            $this->$prop = array();
        }
        # TODO: Log $pattern.
        array_push($this->$prop, new Route($pattern, $target));
    }

    public function findRoute($method, $uri) {
        $method = strtolower($method);
        $prop   = $method.'Action';
        $routes = array_filter($this->$prop, function($var) use ($uri) {
             return $var->isHit($uri);
        });
        $route = array_reduce($routes, function($carry, $var) {
            if ($carry == null || $carry->pathCount < $var->pathCount) {
                return $var;
            } else {
                return $carry;
            }
        });
        return $route;
    }

}
