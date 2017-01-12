<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class ReturnWeb extends Plugin 
{
	protected $set;
	public function __construct() 
	{
		parent::__construct('return');
		$this->set = $this->getSet();
	}
	public function index() 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		header('location: ' . $this->createPluginWebUrl('return/set'));
	}
	public function upgrade() 
	{
		$this->_exec_plugin('upgrade');
	}
	public function set() 
	{
		$this->_exec_plugin('set');
	}
	public function return_tj() 
	{
		$this->_exec_plugin('return_tj');
	}
	public function queue() 
	{
		$this->_exec_plugin('queue');
	}
}
?>