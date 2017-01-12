<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
if (!class_exists('RankingModel')) 
{
	class RankingModel extends PluginModel 
	{
		public function getSet() 
		{
			$_obfuscate_DSUMMSsGKQsTNSsIJSM5DDQsNAsZIzI = parent::getSet();
			return $_obfuscate_DSUMMSsGKQsTNSsIJSM5DDQsNAsZIzI;
		}
		public function getMember($id) 
		{
			$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
			$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
			$_obfuscate_DQIbBSsNBDdcLTMwHCYqATQXAU7JSI = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where uniacid = \'' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '\' and id = \'' . $id . '\'');
			return $_obfuscate_DQIbBSsNBDdcLTMwHCYqATQXAU7JSI;
		}
	}
}
?>