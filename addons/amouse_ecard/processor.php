<?php

defined('IN_IA') or exit('Access Denied');
class Amouse_ecardModuleProcessor extends WeModuleProcessor {
    public $name = 'Amouse_ecardModuleProcessor';
    public function respond() {
        global $_W;
        $rid = $this->rule;
        $weid = $_W['uniacid'];
        $from_user = $this->message['from'];
    }

}