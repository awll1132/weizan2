<?php
 if (!defined('IN_IA')){
    exit('Access Denied');
}
class Processor extends WeModuleProcessor{
    public function respond(){
        $dephp_0 = pdo_fetch('select * from ' . tablename('rule') . ' where id=:id limit 1', array(':id' => $this -> rule));
        if (empty($dephp_0)){
            return false;
        }
        $dephp_1 = explode(':', $dephp_0['name']);
        $dephp_2 = isset($dephp_1[1]) ? $dephp_1[1] : '';
        if (!empty($dephp_2)){
            $dephp_3 = SZ_YI_PLUGIN . $dephp_2 . '/processor.php';
            if (is_file($dephp_3)){
                require $dephp_3;
                $dephp_4 = ucfirst($dephp_2) . 'Processor';
                $dephp_5 = new $dephp_4($dephp_2);
                if (method_exists($dephp_5, 'respond')){
                    return $dephp_5 -> respond($this);
                }
            }
        }
    }
}
