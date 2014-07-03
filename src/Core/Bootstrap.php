<?php
namespace SmartscoreFramework\Core;

use SmartscoreFramework\Core\Router\Router;
use SmartscoreFramework\Core\Application\Base;

class Bootstrap {

    public static function createApplication(array $pathConf=array()) {
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
        $paths = $classSuffix = array();
        $pathConf = array_merge($pathDefault, $pathConf);
        $paths['root']       = dirname($_SERVER['DOCUMENT_ROOT']);
        $paths['public']     = $_SERVER['DOCUMENT_ROOT'];
        $paths['config']     = $paths['root']."/{$pathConf['config']}";
        $paths['controller'] = $paths['root']."/{$pathConf['controller']}";
        $paths['model']      = $paths['root']."/{$pathConf['model']}";
        $paths['view']       = $paths['root']."/{$pathConf['view']}";

        $classSuffix         = $pathConf['suffix'];

        return new Base($paths, $classSuffix);
    }
}
