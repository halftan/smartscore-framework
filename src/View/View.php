<?php
namespace SmartscoreFramework\View;

class View {

    # @var array of partial views.
    private $__partial;

    # @var string path to application_view view.
    private $__application_view;

    private $app;

    # @var string indicates currently rendering partial name.
    # prevent infinite render loop.
    private $__current_partial;

    public function __construct($app, $name) {
        if (!is_array($name)) {
            $this->__partial['main'] = $name;
        } else {
            $this->__partial = $name;
        }
        $this->app    = $app;
    }

    public function __yield($partial = 'main') {
        if ($this->__current_partial == $partial) {
            die("Infinite loop when rendering $partial");
        }
        $this->__current_partial = $partial;
        extract($this->__param);
        ob_start();
        require $this->getAbsolutePath($partial);
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    public function getAbsolutePath($partial_name = 'main') {
        return $this->app->getPath('view').'/'.$this->__partial[$partial_name].'.php';
    }

    public function render($param) {
        $this->__param = $param;
        $viewPath      = $this->app->getPath('view');

        if ($this->__application_view === null) {
            $this->__application_view = $viewPath."/application.php";
        }
        $mainView = $this->getAbsolutePath();
        if (!file_exists($mainView)) {
            throw new \RuntimeException("Template $mainView does not exist!");
        }
        extract($this->__param);
        ob_start();
        if (file_exists($this->__application_view)) {
            require $this->__application_view;
            $result = ob_get_contents();
        } else {
            require $mainView;
            $result = ob_get_contents();
        }
        ob_end_clean();
        return $result;
    }
}
