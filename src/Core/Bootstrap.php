<?php
namespace SmartscoreFramework\Core;

use SmartscoreFramework\Core\Router\Router;
use SmartscoreFramework\Core\Application\Base;

class Bootstrap {

    public static function createApplication(
        $namespace,
        array $pathConf=array()) {

        $pathDefault = array(
            'config'     => 'Config',
            'controller' => 'Controller',
            'model'      => 'Model',
            'view'       => 'View',
            'suffix'     => array(
                'controller' => 'Controller',
                'model'      => 'Model',
                'view'       => 'View'
            )
        );
        $paths = $classSuffix = array();
        $pathConf = array_merge($pathDefault, $pathConf);
        $paths['app']       = dirname($_SERVER['DOCUMENT_ROOT']).'/app';
        $paths['public']     = $_SERVER['DOCUMENT_ROOT'];
        $paths['config']     = $paths['app']."/{$pathConf['config']}";
        $paths['controller'] = $paths['app']."/{$pathConf['controller']}";
        $paths['model']      = $paths['app']."/{$pathConf['model']}";
        $paths['view']       = $paths['app']."/{$pathConf['view']}";

        $classSuffix         = $pathConf['suffix'];

        return new Base($namespace, $paths, $classSuffix);
    }
}
