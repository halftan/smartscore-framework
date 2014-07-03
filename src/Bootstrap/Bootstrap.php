<?php
namespace \Smartscore\Bootstrap;

class Bootstrap {

    #
    #@var array Contains path info.
    #  keys:
    #       - root
    #       - public
    #       - config
    #       - controller
    #       - view
    #       - model
    private $paths;
    private $classSuffix;

    public function __construct(array $pathConf) {
        $pathDefault = array(
            'config'     => 'config',
            'controller' => 'controller',
            'model'      => 'model',
            'view'       => 'view',
            'suffix'     => array(
                'controller' => 'Controller',
                'model'      => 'Model',
                'view'       => 'View'
            )
        );
        $pathConf = array_merge($pathDefault, $pathConf);
        $paths['root']       = dirname($_SERVER['DOCUMENT_ROOT']);
        $paths['public']     = $_SERVER['DOCUMENT_ROOT'];
        $paths['config']     = $paths['root']."/{$pathConf['config']}";
        $paths['controller'] = $paths['root']."/{$pathConf['controller']}";
        $paths['model']      = $paths['root']."/{$pathConf['model']}";
        $paths['view']       = $paths['root']."/{$pathConf['view']}";

        $classSuffix         = $pathConf['suffix'];
    }
}
