<?php
namespace SmartscoreFramework\Controller;

class BasicController {

    # @var SmartscoreFramework\Core\Base
    private $app;

    # @var view to render
    private $view;

    # @var view parameter
    private $viewParam;

    # @var string referrs to REST action
    # example: if route registered with 'home:dashboard'
    #           then $action will be 'dashboard'
    private $action;

    public function __construct($app, $action) {
        $this->app       = $app;
        $this->action    = $action;
        $this->viewParam = array();
    }

    public function __toString() {
        return get_class($this);
    }

    public function setView($view, $partial_name = 'main') {
        $suffix = $this->app->getSuffix('controller');
        $subFolder = preg_replace("#^.+\\\(.+)$suffix$#i", '${1}', get_class($this));
        $this->view[$partial_name] = $subFolder.'/'.$view;
        return $this;
    }

    public function getView() {
        if ($this->view === null) {
            $this->setView($this->action);
        } else if (!isset($this->view['main'])) {
            $this->setView($this->action);
        }
        if (!isset($this->view[$this->action])) {
            $this->setView($this->action, $this->action);
        }
        return $this->view;
    }

    public function setViewParam($key, $value) {
        $this->viewParam[$key] = $value;
        return $this;
    }

    public function getViewParam() {
         return $this->viewParam;
    }

}
