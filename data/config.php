<?php
defined('IN_IA') or exit('Access Denied');

$config = array();

$config['db']['host'] = '127.0.0.1';
$config['db']['username'] = 'root';
$config['db']['password'] = '303809388mysql';
$config['db']['port'] = '4306';
$config['db']['database'] = 'weizan';
$config['db']['charset'] = 'utf8';
$config['db']['pconnect'] = 0;
$config['db']['tablepre'] = 'ims_';

// --------------------------  CONFIG COOKIE  --------------------------- //
$config['cookie']['pre'] = 'fd06_';
$config['cookie']['domain'] = '';
$config['cookie']['path'] = '/';

// --------------------------  CONFIG SETTING  --------------------------- //
$config['setting']['charset'] = 'utf-8';
$config['setting']['cache'] = 'mysql';
$config['setting']['timezone'] = 'Asia/Shanghai';
$config['setting']['memory_limit'] = '256M';
$config['setting']['filemode'] = 0644;
$config['setting']['authkey'] = 'f2324449';
$config['setting']['founder'] = '1';
$config['setting']['development'] = 0;
$config['setting']['referrer'] = 0;

// --------------------------  CONFIG UPLOAD  --------------------------- //
$config['upload']['image']['extentions'] = array('gif', 'jpg', 'jpeg', 'png');
$config['upload']['image']['limit'] = 5000;
$config['upload']['attachdir'] = 'attachment';
$config['upload']['audio']['extentions'] = array('mp3');
$config['upload']['audio']['limit'] = 5000;
//++--------------- 域名绑定配置  ---------------//
$config['setting']['domain']['host']='weixin.zjgo2o.com';
$config['setting']['domain']['protect_app']='0';
$config['setting']['domain']['protect_web']='0';
if(file_exists(IA_ROOT . "/web/source/fournet/domain.php")){
   include IA_ROOT . "/web/source/fournet/domain.php";}
//----------------- 域名绑定配置  -------------++//
// --------------------------  HTTPS UP  --------------------------- //
$config['setting']['https'] = 0;