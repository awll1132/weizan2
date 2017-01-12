<?php
 if (!defined('IN_IA')){
    exit('Access Denied');
}
class Plugin extends Core{
    public $pluginname;
    public $model;
    public function __construct($dephp_0 = ''){
        parent :: __construct();
        $this -> modulename = 'sz_yi';
        $this -> pluginname = $dephp_0;
        $this -> loadModel();
        if (strexists($_SERVER['REQUEST_URI'], '/web/')){
            cpa($this -> pluginname);
        }else if (strexists($_SERVER['REQUEST_URI'], '/app/')){
            $this -> setFooter();
        }
        $this -> module['title'] = pdo_fetchcolumn('select title from ' . tablename('modules') . ' where name=\'sz_yi\' limit 1');
    }
    private function loadModel(){
        $dephp_1 = IA_ROOT . '/addons/' . $this -> modulename . '/plugin/' . $this -> pluginname . '/model.php';
        if (is_file($dephp_1)){
            $dephp_2 = ucfirst($this -> pluginname) . 'Model';
            require $dephp_1;
            $this -> model = new $dephp_2($this -> pluginname);
        }
    }
    public function getSet(){
        return $this -> model -> getSet();
    }
    public function updateSet($dephp_3 = array()){
        $this -> model -> updateSet($dephp_3);
    }
    public function template($dephp_4, $dephp_5 = TEMPLATE_INCLUDEPATH){
        global $_W;
        $dephp_6 = (isMobile()) ? 'mobile' : 'pc';
        if(strstr($_SERVER['REQUEST_URI'], 'app')){
            if(!isMobile()){
                if($this -> yzShopSet['ispc'] == 0){
                    $dephp_6 = 'mobile';
                }
            }
        }
        $dephp_7 = IA_ROOT . '/addons/sz_yi/';
        if (defined('IN_SYS')){
            $dephp_8 = IA_ROOT . '/addons/sz_yi/plugin/' . $this -> pluginname . "/template/{$dephp_4}.html";
            $dephp_9 = IA_ROOT . "/data/tpl/web/{$_W['template']}/sz_yi/plugin/" . $this -> pluginname . "/{$dephp_4}.tpl.php";
            if (!is_file($dephp_8)){
                $dephp_8 = IA_ROOT . "/addons/sz_yi/template/{$dephp_4}.html";
                $dephp_9 = IA_ROOT . "/data/tpl/web/{$_W['template']}/sz_yi/{$dephp_4}.tpl.php";
            }
            if (!is_file($dephp_8)){
                $dephp_8 = IA_ROOT . "/web/themes/{$_W['template']}/{$dephp_4}.html";
                $dephp_9 = IA_ROOT . "/data/tpl/web/{$_W['template']}/{$dephp_4}.tpl.php";
            }
            if (!is_file($dephp_8)){
                $dephp_8 = IA_ROOT . "/web/themes/default/{$dephp_4}.html";
                $dephp_9 = IA_ROOT . "/data/tpl/web/default/{$dephp_4}.tpl.php";
            }
        }else{
            $dephp_10 = m('cache') -> getString('template_shop');
            if (empty($dephp_10)){
                $dephp_10 = 'default';
            }
            if (!is_dir(IA_ROOT . "/addons/sz_yi/template/{$dephp_6}/" . $dephp_10)){
                $dephp_10 = 'default';
            }
            $dephp_11 = m('cache') -> getString('template_' . $this -> pluginname);
            if (empty($dephp_11)){
                $dephp_11 = 'default';
            }
            if (!is_dir(IA_ROOT . '/addons/sz_yi/plugin/' . $this -> pluginname . "/template/{$dephp_6}/" . $dephp_11)){
                $dephp_11 = 'default';
            }
            $dephp_9 = IA_ROOT . '/data/app/sz_yi/plugin/' . $this -> pluginname . "/{$dephp_11}/{$dephp_6}/{$dephp_4}.tpl.php";
            $dephp_8 = $dephp_7 . '/plugin/' . $this -> pluginname . "/template/{$dephp_6}/{$dephp_11}/{$dephp_4}.html";
            if (!is_file($dephp_8)){
                $dephp_8 = $dephp_7 . '/plugin/' . $this -> pluginname . "/template/{$dephp_6}/default/{$dephp_4}.html";
                $dephp_9 = IA_ROOT . '/data/app/sz_yi/plugin/' . $this -> pluginname . "/default/{$dephp_6}/{$dephp_4}.tpl.php";
            }
            if (!is_file($dephp_8)){
                $dephp_8 = $dephp_7 . "/template/{$dephp_6}/{$dephp_10}/{$dephp_4}.html";
                $dephp_9 = IA_ROOT . "/data/app/sz_yi/{$dephp_10}/{$dephp_4}.tpl.php";
            }
            if (!is_file($dephp_8)){
                $dephp_8 = $dephp_7 . "/template/{$dephp_6}/default/{$dephp_4}.html";
                $dephp_9 = IA_ROOT . "/data/app/sz_yi/default/{$dephp_4}.tpl.php";
            }
            if (!is_file($dephp_8)){
                $dephp_8 = $dephp_7 . "/template/{$dephp_6}/{$dephp_4}.html";
                $dephp_9 = IA_ROOT . "/data/app/sz_yi/{$dephp_4}.tpl.php";
            }
            if (!is_file($dephp_8)){
                $dephp_12 = explode('/', $dephp_4);
                $dephp_13 = $dephp_12[0];
                $dephp_14 = m('cache') -> getString('template_' . $dephp_13);
                if (empty($dephp_14)){
                    $dephp_14 = 'default';
                }
                if (!is_dir(IA_ROOT . '/addons/sz_yi/plugin/' . $dephp_13 . "/template/{$dephp_6}/" . $dephp_14)){
                    $dephp_14 = 'default';
                }
                $dephp_15 = $dephp_12[1];
                $dephp_8 = IA_ROOT . '/addons/sz_yi/plugin/' . $dephp_13 . "/template/{$dephp_6}/" . $dephp_14 . "/{$dephp_15}.html";
            }
        }
        if (!is_file($dephp_8)){
            exit("Error: template source '{$dephp_4}' is not exist!");
        }
        if (DEVELOPMENT || !is_file($dephp_9) || filemtime($dephp_8) > filemtime($dephp_9)){
            shop_template_compile($dephp_8, $dephp_9, true);
        }
        return $dephp_9;
    }
    public function _exec_plugin($dephp_16, $dephp_17 = true){
        global $_GPC;
        if ($dephp_17){
            $dephp_18 = IA_ROOT . '/addons/sz_yi/plugin/' . $this -> pluginname . '/core/web/' . $dephp_16 . '.php';
        }else{
            $dephp_18 = IA_ROOT . '/addons/sz_yi/plugin/' . $this -> pluginname . '/core/mobile/' . $dephp_16 . '.php';
        }
        if (!is_file($dephp_18)){
            message("未找到控制器文件 : {$dephp_18}");
        }
        include $dephp_18;
        exit;
    }
}
