<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 22:27
 */

namespace Xend;


class View {

    private $_vars = array();
    private $_scriptPath = "";
    private $_script = "";

    public $childView = array();


    public function __construct($config)
    {
        $this->_scriptPath = $config['path'];
    }

    public function setVar($name,$value)
    {
        $this->_vars[$name] = $value;
    }

    public function setVars($variables)
    {
        $this->_vars = array_merge($this->_vars,$variables);
    }

    public function addChildView($name,$view)
    {
        $this->childView[$name] = $view;
    }

    public function setScript($script)
    {
        $this->_script = $this->_scriptPath.$script;
    }


    public function render($scriptPath = null,$variables = array())
    {
        $variables = array_merge($this->_vars,$variables);

        if($scriptPath != null)
        {
            $this->_script = $this->_scriptPath . $scriptPath;
        }

        foreach($this->childView as $name => $view)
        {
            $variables[$name] = $view->render();
        }

        extract($variables);

        ob_start();

        include $this->_script;

        $content = ob_get_clean();

        return $content;
    }
} 