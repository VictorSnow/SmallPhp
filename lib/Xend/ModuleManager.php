<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/27
 * Time: 10:37
 */

namespace Xend;

class ModuleManager
{
    private $_initModules = array();
    private $_loadModules = array();

    public function __construct($modules = array())
    {
        $this->_initModules = $modules;
    }

    public function loadModule($name)
    {
        $name = ucfirst($name);

        if(isset($this->_loadModules[$name]) || !in_array($name, $this->_initModules))
        {
            return;
        }

        $module = $name.'\Module';
        $this->_loadModules[$name] = new $module();
        $module->bootstrap();
    }
}