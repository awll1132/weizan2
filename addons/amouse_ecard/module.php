<?php
defined('IN_IA') or exit('Access Denied');
class amouse_ecardModule extends WeModule
{
    public function fieldsFormDisplay($rid = 0)
    {
        global $_W;
    }
    public function fieldsFormValidate($rid = 0)
    {
        return '';
    }
    public function fieldsFormSubmit($rid)
    {
        global $_W, $_GPC;
        return true;
    }
    function write_cache($filename, $data)
    {
        global $_W;
        $path     = "/addons/amouse_ecard";
        $filename = IA_ROOT . $path . "/data/" . $filename . ".txt";
        load()->func('file');
        mkdirs(dirname($filename));
        file_put_contents($filename, base64_encode(json_encode($data)));
        @chmod($filename, $_W['config']['setting']['filemode']);
        return is_file($filename);
    }
    public function ruleDeleted($rid = 0)
    {
        pdo_delete('amouse_ecard_reply', array(
            'rid' => $rid
        ));
    }
}