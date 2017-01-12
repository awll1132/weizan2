<?php
 if (!defined('IN_IA')){
    exit('Access Denied');
}
require IA_ROOT . '/addons/sz_yi/defines.php';
class PluginProcessor extends WeModuleProcessor{
    public $model;
    public $modulename;
    public $message;
    public function __construct($dephp_0 = ''){
        $this -> modulename = 'sz_yi';
        $this -> pluginname = $dephp_0;
        $this -> loadModel();
    }
    private function loadModel(){
        $dephp_1 = IA_ROOT . '/addons/' . $this -> modulename . '/plugin/' . $this -> pluginname . '/model.php';
        if (is_file($dephp_1)){
            $dephp_2 = ucfirst($this -> pluginname) . 'Model';
            require $dephp_1;
            $this -> model = new $dephp_2($this -> pluginname);
        }
    }
    public function respond(){
        $this -> message = $this -> message;
    }
}
