<?php
namespace SmartscoreFramework\Core\Application;

use SmartscoreFramework\Core\Router\Router;
use SmartscoreFramework\Core\Router\Route;

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

    # @var Router
    private $router;

    public function __construct($paths, $classSuffix) {
        $this->paths       = $paths;
        $this->classSuffix = $classSuffix;
    }

    public function getRouter() {
        if ($this->router == null) {
            $this->router = Router::getInstance();
        }
        return $this->router;
    }
}
