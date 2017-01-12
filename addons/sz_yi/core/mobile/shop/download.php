<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
$this->setHeader();
include $this->template('shop/download');
?>