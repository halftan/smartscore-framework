<?php
namespace SmartscoreFramework\View;

class View {

    private $__view;

    public function __construct($app, $name) {
        $viewPath = $app->getPath('view');
        $this->__view = $app->getPath('view').'/'.$name.'.php';
        if (!file_exists($this->__view)) {
            throw new \RuntimeException("No view template $name found in $viewPath.");
        }
    }

    public function render($param) {
        extract($param);
        ob_start();
        require $this->__view;
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}
