<?php
 if (!defined('IN_IA')){
    exit('Access Denied');
}
class PluginModel{
    private $pluginname;
    public function __construct($dephp_0 = ''){
        $this -> pluginname = $dephp_0;
    }
    public function getSet(){
        global $_W, $_GPC;
        $dephp_1 = m('common') -> getSetData();
        $dephp_2 = iunserializer($dephp_1['plugins']);
        if (is_array($dephp_2) && isset($dephp_2[$this -> pluginname])){
            return $dephp_2[$this -> pluginname];
        }
        return array();
    }
    public function updateSet($dephp_3 = array()){
        global $_W;
        $dephp_4 = $_W['uniacid'];
        $dephp_1 = pdo_fetch('select * from ' . tablename('sz_yi_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $dephp_4));
        if (empty($dephp_1)){
            pdo_insert('sz_yi_sysset', array('uniacid' => $dephp_4, 'sets' => iserializer(array()), 'plugins' => iserializer(array($this -> pluginname => $dephp_3))));
        }else{
            $dephp_5 = unserialize($dephp_1['plugins']);
            $dephp_5[$this -> pluginname] = $dephp_3;
            pdo_update('sz_yi_sysset', array('plugins' => iserializer($dephp_5)), array('uniacid' => $dephp_4));
        }
        $dephp_1 = pdo_fetch('select * from ' . tablename('sz_yi_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $dephp_4));
        m('cache') -> set('sysset', $dephp_1);
    }
    function getName(){
        return pdo_fetchcolumn('select name from ' . tablename('sz_yi_plugin') . ' where identity=:identity limit 1', array(':identity' => $this -> pluginname));
    }
}
