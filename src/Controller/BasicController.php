<?php
namespace SmartscoreFramework\Controller;

class BasicController {

    # @var SmartscoreFramework\Core\Base
    private $app;

    # @var view to render
    private $view;

    # @var view parameter
    private $viewParam;

    public function __construct($app) {
        $this->application = $app;
    }

    public function __toString() {
        return get_class($this);
    }

    public function setView($view) {
        $this->view = $view;
        return $this;
    }

    public function getView() {
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
