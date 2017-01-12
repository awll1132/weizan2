<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
global $_GPC;
$tpl = trim($_GPC['tpl']);
load()->func('tpl');
$pv = p('virtual');
if ($tpl == 'option') 
{
	$tag = random(32);
	include $this->template('web/shop/tpl/option');
	return 1;
}
if ($tpl == 'spec') 
{
	$spec = array('id' => random(32), 'title' => $_GPC['title']);
	include $this->template('web/shop/tpl/spec');
	return 1;
}
if ($tpl == 'specitem') 
{
	$spec = array('id' => $_GPC['specid']);
	$specitem = array('id' => random(32), 'title' => $_GPC['title'], 'show' => 1);
	include $this->template('web/shop/tpl/spec_item');
	return 1;
}
if ($tpl == 'param') 
{
	$tag = random(32);
	include $this->template('web/shop/tpl/param');
}
?>