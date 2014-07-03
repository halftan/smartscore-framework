<?php
namespace SmartscoreFramework\Core\Router;

class Route {

    # @var array
    private $pattern;

    # @var array
    private $paramList;

    # @var mixed
    private $target;

    public function __construct($pattern, $target) {
        if (!is_array($pattern)) {
            # Remove the leading slash ('/') of url and explode.
            $pattern = explode('/', substr($pattern, 1));
        }
        if (empty($pattern[0])) {
            $pattern = array('/');
        } else {
            array_unshift($pattern, '/');
        }

        $this->pattern = $this->paramList = array();
        $this->target  = $target;
        foreach ($pattern as $key => $value){
            if ($value[0] == ':') {
                $this->paramList[$key] = $value;
            } else {
                $this->pattern[$key] = $value;
            }
        }
    }

}
