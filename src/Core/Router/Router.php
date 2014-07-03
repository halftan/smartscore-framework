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

    private $routeHash;

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
    public function register($pattern, $target) {
        # TODO: Log $pattern.
        $this->routeHash[] = new Route($pattern, $target);
    }

}
