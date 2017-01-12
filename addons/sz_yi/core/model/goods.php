<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Sz_DYi_Goods 
{
	public function getOption($goodsid = 0, $optionid = 0) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		return pdo_fetch('select * from ' . tablename('sz_yi_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid', array(':id' => $optionid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':goodsid' => $goodsid));
	}
	public function getList($args = array()) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DTYwNig7MAwuEBkDEggrQBw7LDQEAwE = ((!empty($args['page']) ? intval($args['page']) : 1));
		$_obfuscate_DS0qBzkcPQooAzgYDwg9Mh4KOz0lDjI = ((!empty($args['pagesize']) ? intval($args['pagesize']) : 10));
		$_obfuscate_DTIrAltbORIlCi4sKQYvMxYeNxwpAgE = ((!empty($args['random']) ? $args['random'] : false));
		$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = ((!empty($args['order']) ? $args['order'] : ' displayorder desc,createtime desc'));
		$_obfuscate_DT82NAMLJwYMFzwFXBspWxs3Ih8zDBE = ((!empty($args['by']) ? $args['by'] : ''));
		$_obfuscate_DRM0JwknOBoDPh4UPw0xJTI3KDMPyI = ((!empty($args['ids']) ? trim($args['ids']) : ''));
		$_obfuscate_DT43MgotCSMGLyEoHSkcCzUaLTgOChE = ((!empty($args['supplier_uid']) ? trim($args['supplier_uid']) : ''));
		$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE = ' and `uniacid` = :uniacid AND `deleted` = 0 and status=1';
		$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI = array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
		if (!empty($_obfuscate_DRM0JwknOBoDPh4UPw0xJTI3KDMPyI)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' and id in ( ' . $_obfuscate_DRM0JwknOBoDPh4UPw0xJTI3KDMPyI . ')';
		}
		if (!empty($_obfuscate_DT43MgotCSMGLyEoHSkcCzUaLTgOChE)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' and supplier_uid = :supplier_uid ';
			$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI[':supplier_uid'] = intval($_obfuscate_DT43MgotCSMGLyEoHSkcCzUaLTgOChE);
		}
		$_obfuscate_DSQELywfDwMaMRkjLQ8lLyMGLSQRIzI = ((!empty($args['isnew']) ? 1 : 0));
		if (!empty($_obfuscate_DSQELywfDwMaMRkjLQ8lLyMGLSQRIzI)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' and isnew=1';
		}
		$_obfuscate_DREzFD4uKjc9EzlbMBQTEAoOCi8XXCI = ((!empty($args['ishot']) ? 1 : 0));
		if (!empty($_obfuscate_DREzFD4uKjc9EzlbMBQTEAoOCi8XXCI)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' and ishot=1';
		}
		$_obfuscate_DQ4aBhgbXB1bHRU5CBEzOSkrBDYWPwE = ((!empty($args['isrecommand']) ? 1 : 0));
		if (!empty($_obfuscate_DQ4aBhgbXB1bHRU5CBEzOSkrBDYWPwE)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' and isrecommand=1';
		}
		$_obfuscate_DQkNFTgZCjwnPBYeCxw4FFwNBQ8ZJTI = ((!empty($args['isdiscount']) ? 1 : 0));
		if (!empty($_obfuscate_DQkNFTgZCjwnPBYeCxw4FFwNBQ8ZJTI)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' and isdiscount=1';
		}
		$_obfuscate_DQoeKzcnFCIMNhUbHxotOxIjEDEyKwE = ((!empty($args['istime']) ? 1 : 0));
		if (!empty($_obfuscate_DQoeKzcnFCIMNhUbHxotOxIjEDEyKwE)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' and istime=1 and ' . time() . '>=timestart and ' . time() . '<=timeend';
		}
		$_obfuscate_DTAoMxBAEzAvCjQSDSMwHC8pPSg4NhE = ((!empty($args['keywords']) ? $args['keywords'] : ''));
		if (!empty($_obfuscate_DTAoMxBAEzAvCjQSDSMwHC8pPSg4NhE)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' AND `title` LIKE :title';
			$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI[':title'] = '%' . trim($_obfuscate_DTAoMxBAEzAvCjQSDSMwHC8pPSg4NhE) . '%';
		}
		$_obfuscate_DSsINDsiNCIbGgIJKDA1Igw5WzwTFDI = intval($args['tcate']);
		if (!empty($_obfuscate_DSsINDsiNCIbGgIJKDA1Igw5WzwTFDI)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' AND ( `tcate` = :tcate or  FIND_IN_SET(' . $_obfuscate_DSsINDsiNCIbGgIJKDA1Igw5WzwTFDI . ',tcates)<>0 )';
			$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI[':tcate'] = intval($_obfuscate_DSsINDsiNCIbGgIJKDA1Igw5WzwTFDI);
		}
		else 
		{
			$_obfuscate_DR8mATERBRsIETAVHQcyWxsiNxQ3FhE = intval($args['ccate']);
			if (!empty($_obfuscate_DR8mATERBRsIETAVHQcyWxsiNxQ3FhE)) 
			{
				$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' AND ( `ccate` = :ccate or  FIND_IN_SET(' . $_obfuscate_DR8mATERBRsIETAVHQcyWxsiNxQ3FhE . ',ccates)<>0 )';
				$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI[':ccate'] = intval($_obfuscate_DR8mATERBRsIETAVHQcyWxsiNxQ3FhE);
			}
			else 
			{
				$_obfuscate_DRcGITUkKhsKOzALFCQSGEAkEQc5FCI = intval($args['pcate']);
				if (!empty($_obfuscate_DRcGITUkKhsKOzALFCQSGEAkEQc5FCI)) 
				{
					$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' AND ( `pcate` = :pcate or  FIND_IN_SET(' . $_obfuscate_DRcGITUkKhsKOzALFCQSGEAkEQc5FCI . ',pcates)<>0 )';
					$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI[':pcate'] = intval($_obfuscate_DRcGITUkKhsKOzALFCQSGEAkEQc5FCI);
				}
			}
		}
		$_obfuscate_DQEdHAIrNjwGQAsMCRE7PSMENh8UWzI = intval($args['tcate1']);
		if (!empty($_obfuscate_DQEdHAIrNjwGQAsMCRE7PSMENh8UWzI)) 
		{
			$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' AND ( `tcate1` = :tcate1 or  FIND_IN_SET(' . $_obfuscate_DQEdHAIrNjwGQAsMCRE7PSMENh8UWzI . ',tcates)<>0 )';
			$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI[':tcate1'] = intval($_obfuscate_DQEdHAIrNjwGQAsMCRE7PSMENh8UWzI);
		}
		else 
		{
			$_obfuscate_DRwRKR8IBwsKAyoeCg8xGRgbEjsUNiI = intval($args['ccate1']);
			if (!empty($_obfuscate_DRwRKR8IBwsKAyoeCg8xGRgbEjsUNiI)) 
			{
				$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' AND ( `ccate1` = :ccate1 or  FIND_IN_SET(' . $_obfuscate_DRwRKR8IBwsKAyoeCg8xGRgbEjsUNiI . ',ccates)<>0 )';
				$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI[':ccate1'] = intval($_obfuscate_DRwRKR8IBwsKAyoeCg8xGRgbEjsUNiI);
			}
			else 
			{
				$_obfuscate_DRQEJhoBKxcNGzMMCQw2ATwnHzEOKSI = intval($args['pcate1']);
				if (!empty($_obfuscate_DRQEJhoBKxcNGzMMCQw2ATwnHzEOKSI)) 
				{
					$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' AND ( `pcate1` = :pcate1 or  FIND_IN_SET(' . $_obfuscate_DRQEJhoBKxcNGzMMCQw2ATwnHzEOKSI . ',pcates)<>0 )';
					$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI[':pcate1'] = intval($_obfuscate_DRQEJhoBKxcNGzMMCQw2ATwnHzEOKSI);
				}
			}
		}
		$_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE = m('user')->getOpenid();
		$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = m('member')->getMember($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE);
		$_obfuscate_DTIyBFwmGREhGwQuIQYWAigVPg0lKQE = intval($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['level']);
		$_obfuscate_DSIvLzIXJwMhOSowBhQGOSgfEgIQJTI = intval($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['groupid']);
		$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' and ( ifnull(showlevels,\'\')=\'\' or FIND_IN_SET( ' . $_obfuscate_DTIyBFwmGREhGwQuIQYWAigVPg0lKQE . ',showlevels)<>0 ) ';
		$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE .= ' and ( ifnull(showgroups,\'\')=\'\' or FIND_IN_SET( ' . $_obfuscate_DSIvLzIXJwMhOSowBhQGOSgfEgIQJTI . ',showgroups)<>0 ) ';
		if (!$_obfuscate_DTIrAltbORIlCi4sKQYvMxYeNxwpAgE) 
		{
			$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'SELECT * FROM ' . tablename('sz_yi_goods') . ' where 1 ' . $_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE . ' ORDER BY ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE . ' ' . $_obfuscate_DT82NAMLJwYMFzwFXBspWxs3Ih8zDBE . ' LIMIT ' . (($_obfuscate_DTYwNig7MAwuEBkDEggrQBw7LDQEAwE - 1) * $_obfuscate_DS0qBzkcPQooAzgYDwg9Mh4KOz0lDjI) . ',' . $_obfuscate_DS0qBzkcPQooAzgYDwg9Mh4KOz0lDjI;
		}
		else 
		{
			$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'SELECT * FROM ' . tablename('sz_yi_goods') . ' where 1 ' . $_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE . ' ORDER BY rand() LIMIT ' . $_obfuscate_DS0qBzkcPQooAzgYDwg9Mh4KOz0lDjI;
		}
		$_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE = pdo_fetchall($_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI, $_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI);
		$_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE = set_medias($_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE, 'thumb');
		return $_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE;
	}
	public function getComments($goodsid = '0', $args = array()) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DTYwNig7MAwuEBkDEggrQBw7LDQEAwE = ((!empty($args['page']) ? intval($args['page']) : 1));
		$_obfuscate_DS0qBzkcPQooAzgYDwg9Mh4KOz0lDjI = ((!empty($args['pagesize']) ? intval($args['pagesize']) : 10));
		$_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE = ' and `uniacid` = :uniacid AND `goodsid` = :goodsid and deleted=0';
		$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI = array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':goodsid' => $goodsid);
		$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'SELECT id,nickname,headimgurl,content,images FROM ' . tablename('sz_yi_goods_comment') . ' where 1 ' . $_obfuscate_DRIUMi4mJCZADApcHBIfLlwTDCQHNRE . ' ORDER BY createtime desc LIMIT ' . (($_obfuscate_DTYwNig7MAwuEBkDEggrQBw7LDQEAwE - 1) * $_obfuscate_DS0qBzkcPQooAzgYDwg9Mh4KOz0lDjI) . ',' . $_obfuscate_DS0qBzkcPQooAzgYDwg9Mh4KOz0lDjI;
		$_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE = pdo_fetchall($_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI, $_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI);
		foreach ($_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE as &$_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI ) 
		{
			$_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['images'] = set_medias(unserialize($_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['images']));
		}
		unset($_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI);
		return $_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE;
	}
}
?>