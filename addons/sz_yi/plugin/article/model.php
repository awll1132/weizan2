<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
if (!class_exists('ArticleModel')) 
{
	class ArticleModel extends PluginModel 
	{
		public function getSys() 
		{
			$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
			$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
			$_obfuscate_DQUiQBgrWxhcHiQ4EBojNT4nHDMOPCI = pdo_fetch('select * from' . tablename('sz_yi_article_sys') . 'where uniacid=:uniacid', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
			return $_obfuscate_DQUiQBgrWxhcHiQ4EBojNT4nHDMOPCI;
		}
		public function doShare($article, $shareid, $myid) 
		{
			$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
			$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
			$_obfuscate_DQklMTYkHAE9EhMyByUBBCcnPD4RAwE = m('member')->getMember($shareid);
			$_obfuscate_DRMEMwEyCS0bOwwhLBYdKB0fED8zAgE = m('member')->getMember($myid);
			$_obfuscate_DTEEMhIOC1sXHhMyFTAFNhgyPgI7HgE = m('common')->getSysset('shop');
			if (!empty($myid) && ($shareid != $myid) && !empty($_obfuscate_DQklMTYkHAE9EhMyByUBBCcnPD4RAwE['openid'])) 
			{
				$_obfuscate_DRYMPAMmKBYwAwkeMAI2HSI7FCQHDwE = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_article_share') . ' WHERE aid=:aid and click_user=:click_user and uniacid=:uniacid ', array(':aid' => $article['id'], ':click_user' => $myid, ':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
				if (empty($_obfuscate_DRYMPAMmKBYwAwkeMAI2HSI7FCQHDwE)) 
				{
					$_obfuscate_DTgKNTEuEg45IRcdDD4FLytbGSoyPzI = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_article_share') . ' WHERE aid=:aid and click_user=:share_user and share_user=:click_user and uniacid=:uniacid ', array(':aid' => $article['id'], ':share_user' => $shareid, ':click_user' => $myid, ':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
					if (empty($_obfuscate_DTgKNTEuEg45IRcdDD4FLytbGSoyPzI)) 
					{
						$_obfuscate_DVs4JxQsDiUVKCITH1sZPwMwFR0NFjI = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_article_share') . ' WHERE aid=:aid and share_user=:share_user and uniacid=:uniacid ', array(':aid' => $article['id'], ':share_user' => $shareid, ':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
						if ($_obfuscate_DVs4JxQsDiUVKCITH1sZPwMwFR0NFjI < $article['article_rule_allnum']) 
						{
							$_obfuscate_DTtcJS4TFyw0XAYYGBEORtAFQkkKgE = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
							$_obfuscate_DSUNIj0XHwlbLjA4FzZAPAsCCzIPITI = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
							$_obfuscate_DQ4sH1xcGVsVEDRcNC4GLicjCycaMSI = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_article_share') . ' WHERE aid=:aid and share_user=:share_user and click_date>:day_start and click_date<:day_end and uniacid=:uniacid ', array(':aid' => $article['id'], ':share_user' => $shareid, ':day_start' => $_obfuscate_DTtcJS4TFyw0XAYYGBEORtAFQkkKgE, ':day_end' => $_obfuscate_DSUNIj0XHwlbLjA4FzZAPAsCCzIPITI, ':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
							if ($_obfuscate_DQ4sH1xcGVsVEDRcNC4GLicjCycaMSI < $article['article_rule_daynum']) 
							{
								$_obfuscate_DS0oGCUjJlwBOxkiHAU_GisKCDY2OSI = (($article['article_rule_userd_money'] ? $article['article_rule_userd_money'] : 0));
								if (0 < $article['article_rule_money_total']) 
								{
									$_obfuscate_DTEEPhwKJSMlG1sTQDI2EQ8rG1wWJhE = 'select sum(add_money) from ' . tablename('sz_yi_article_share') . ' where uniacid = \'' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '\' and aid=\'' . $article['id'] . '\' ';
									$_obfuscate_DS0oGCUjJlwBOxkiHAU_GisKCDY2OSI += pdo_fetchcolumn($_obfuscate_DTEEPhwKJSMlG1sTQDI2EQ8rG1wWJhE);
									if ($article['article_rule_money_total'] <= $_obfuscate_DS0oGCUjJlwBOxkiHAU_GisKCDY2OSI) 
									{
										$article['article_rule_money'] = 0;
									}
								}
								$_obfuscate_DRwsGhQJXB0uEx0SWwkSBzQoGxAhFgE = array('aid' => $article['id'], 'share_user' => $shareid, 'click_user' => $myid, 'click_date' => time(), 'add_credit' => $article['article_rule_credit'], 'add_money' => $article['article_rule_money'], 'uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']);
								pdo_insert('sz_yi_article_share', $_obfuscate_DRwsGhQJXB0uEx0SWwkSBzQoGxAhFgE);
								if (0 < $article['article_rule_credit']) 
								{
									m('member')->setCredit($_obfuscate_DQklMTYkHAE9EhMyByUBBCcnPD4RAwE['openid'], 'credit1', $article['article_rule_credit'], array(0, $_obfuscate_DTEEMhIOC1sXHhMyFTAFNhgyPgI7HgE['name'] . ' 文章营销奖励积分'));
								}
								if (0 < $article['article_rule_money']) 
								{
									m('member')->setCredit($_obfuscate_DQklMTYkHAE9EhMyByUBBCcnPD4RAwE['openid'], 'credit2', $article['article_rule_money'], array(0, $_obfuscate_DTEEMhIOC1sXHhMyFTAFNhgyPgI7HgE['name'] . ' 文章营销奖励余额'));
								}
								$_obfuscate_DQUiQBgrWxhcHiQ4EBojNT4nHDMOPCI = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_article_sys') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
								$_obfuscate_DQs2AzECi8UIhAlOVwHGxssIQMBIzI = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteroot'] . 'app/index.php?i=' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '&c=entry&m=sz_yi&do=member';
								$_obfuscate_DSE2MSQ0WzkMGzUKGwc_GiwnFjM3CzI = '';
								if (!empty($article['article_rule_credit'])) 
								{
									$_obfuscate_DSE2MSQ0WzkMGzUKGwc_GiwnFjM3CzI .= $article['article_rule_credit'] . '个积分、';
								}
								if (!empty($article['article_rule_money'])) 
								{
									$_obfuscate_DSE2MSQ0WzkMGzUKGwc_GiwnFjM3CzI .= $article['article_rule_money'] . '元余额';
								}
								$_obfuscate_DQIwPSw1KQwlJDgYEwUIDz0hPyE4AiI = array( 'first' => array('value' => '您的奖励已到帐！', 'color' => '#4a5077'), 'keyword1' => array('title' => '任务名称', 'value' => '分享得奖励', 'color' => '#4a5077'), 'keyword2' => array('title' => '通知类型', 'value' => '用户通过您的分享进入文章《' . $article['article_title'] . '》，系统奖励您' . $_obfuscate_DSE2MSQ0WzkMGzUKGwc_GiwnFjM3CzI . '。', 'color' => '#4a5077'), 'remark' => array('value' => '奖励已发放成功，请到会员中心查看。', 'color' => '#4a5077') );
								if (!empty($_obfuscate_DQUiQBgrWxhcHiQ4EBojNT4nHDMOPCI['article_message'])) 
								{
									m('message')->sendTplNotice($_obfuscate_DQklMTYkHAE9EhMyByUBBCcnPD4RAwE['openid'], $_obfuscate_DQUiQBgrWxhcHiQ4EBojNT4nHDMOPCI['article_message'], $_obfuscate_DQIwPSw1KQwlJDgYEwUIDz0hPyE4AiI, $_obfuscate_DQs2AzECi8UIhAlOVwHGxssIQMBIzI);
									return NULL;
								}
								m('message')->sendCustomNotice($_obfuscate_DQklMTYkHAE9EhMyByUBBCcnPD4RAwE['openid'], $_obfuscate_DQIwPSw1KQwlJDgYEwUIDz0hPyE4AiI, $_obfuscate_DQs2AzECi8UIhAlOVwHGxssIQMBIzI);
							}
						}
					}
				}
			}
		}
		public function mid_replace($content) 
		{
			$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
			preg_match_all('/href\\=["|\'](.*?)["|\']/is', $content, $_obfuscate_DQsVIiEsBCsDGhw4Mw0kEDEcCRMCPxE);
			foreach ($_obfuscate_DQsVIiEsBCsDGhw4Mw0kEDEcCRMCPxE[1] as $_obfuscate_DQMWMSQWEiMMQMCLiMOJCQLMykjLTI => $_obfuscate_DTRbXC8XWx0SNAYqGyssCQw9OCIrEzI ) 
			{
				$_obfuscate_DQ00XBwlIyYGLRUrIgEbLhYBNTQDGSI = $this->href_replace($_obfuscate_DTRbXC8XWx0SNAYqGyssCQw9OCIrEzI);
				$content = str_replace($_obfuscate_DQsVIiEsBCsDGhw4Mw0kEDEcCRMCPxE[0][$_obfuscate_DQMWMSQWEiMMQMCLiMOJCQLMykjLTI], 'href="' . $_obfuscate_DQ00XBwlIyYGLRUrIgEbLhYBNTQDGSI . '"', $content);
			}
			return $content;
		}
		public function href_replace($lnk) 
		{
			$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
			$_obfuscate_DQ00XBwlIyYGLRUrIgEbLhYBNTQDGSI = $lnk;
			if (strexists($lnk, 'sz_yi') && !strexists($lnk, '&mid')) 
			{
				if (strexists($lnk, '?')) 
				{
					$_obfuscate_DQ00XBwlIyYGLRUrIgEbLhYBNTQDGSI = $lnk . '&mid=' . intval($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['mid']);
				}
				else 
				{
					$_obfuscate_DQ00XBwlIyYGLRUrIgEbLhYBNTQDGSI = $lnk . '?mid=' . intval($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['mid']);
				}
			}
			return $_obfuscate_DQ00XBwlIyYGLRUrIgEbLhYBNTQDGSI;
		}
		public function perms() 
		{
			return array( 'article' => array( 'text' => $this->getName(), 'isplugin' => true, 'child' => array( 'cate' => array('text' => '分类设置', 'addcate' => '添加分类-log', 'editcate' => '编辑分类-log', 'delcate' => '删除分类-log'), 'page' => array('text' => '文章设置', 'add' => '添加文章-log', 'edit' => '修改文章-log', 'delete' => '删除文章-log', 'showdata' => '查看数据统计', 'otherset' => '其他设置', 'report' => '举报记录') ) ) );
		}
	}
}
?>