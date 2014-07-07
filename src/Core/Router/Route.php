<?php
namespace SmartscoreFramework\Core\Router;

use SmartscoreFramework\Core\Exception\ControllerNotFoundException;
class Route {

    # @var array
    private $pattern;

    # @var array
    private $paramList;

    # @var mixed
    private $target;

    # @var int
    public $pathCount;

    # @var string
    private $method;

    public function __construct($pattern, $target, $method='get') {
        $this->pattern = $this->paramList = array();
        $this->target  = $target;
        $this->method  = strtolower($method);
        if ($pattern == '/') {
            $this->pattern = '__root';
            $this->pathCount = 0;
            return;
        }
        if (!is_array($pattern)) {
            # Remove the leading slash ('/') of url and explode.
            $pattern = explode('/', substr($pattern, 1));
        }

        foreach ($pattern as $key => $value){
            if ($value[0] == ':') {
                $this->paramList[$key] = $value;
            } else {
                $this->pattern[$key] = $value;
            }
        }
        $this->pathCount = count($pattern);
    }

    public function isHit($uri) {
        $uriInfo = parse_url($uri);
        $path    = $uriInfo['path'];

        if ($path[0] == '/') {
                $path = substr($path, 1);
        }
        if (empty($path)) {
            if ($this->pattern == "__root") {
                return true;
            } else {
                return false;
            }
        }
        $path = explode('/', $path);
        foreach ($this->pattern as $key => $value){
            if ($path[$key] !== $value) {
                return false;
            }
        }
        return true;
    }

    public function inflateParams($uri) {
        $uriInfo = parse_url($uri);
        $path    = $uriInfo['path'];
        $query   = isset($uriInfo['query']) ? $uriInfo['query'] : array();

        $params  = array();

        if ($path[0] == '/') {
                $path = substr($path, 1);
        }
        $path = explode('/', $path);

        foreach ($this->paramList as $key => $value){
            assert(isset($path[$key]), "Param '$value' must exist.");
            $params[substr($value, 1)] = $path[$key];
        }
        return $params + $query;
    }

    public function call($app, $params) {
        if (is_string($this->target)) {
            $pos = strpos($this->target, ':');
            if ($pos != false) {
                $action       = '_'.lcfirst(substr($this->target, $pos + 1));
                $this->target = substr($this->target, 0, $pos);
            } else {
                $action = "_action";
            }

            $this->target = array(
                $app->buildCallable($this->target, 'controller'),
                $this->method.$action
            );

            try {
                $controllerRef   = new \ReflectionClass($this->target[0]);
                $controller      = $controllerRef->newInstanceArgs(array($app));
                $this->target[0] = $controller;

                call_user_func($this->target, $app, $params);
                return $controller;
            } catch (\Exception $e) {
                throw new ControllerNotFoundException("User callable ".implode('\\', $this->target)." not found.");
                die($e->message);
            }
        } else if (isset($this->target) && is_callable($this->target)){
            return call_user_func($this->target, $app, $params);
        }
    }

}
