<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
define('TM_COMMISSION_AGENT_NEW', 'commission_agent_new');
define('TM_BONUS_ORDER_PAY', 'bonus_order_pay');
define('TM_BONUS_ORDER_FINISH', 'bonus_order_finish');
define('TM_BONUS_ORDER_AREA_PAY', 'bonus_order_area_pay');
define('TM_BONUS_ORDER_AREA_FINISH', 'bonus_order_area_finish');
define('TM_COMMISSION_APPLY', 'commission_apply');
define('TM_COMMISSION_CHECK', 'commission_check');
define('TM_BONUS_PAY', 'bonus_pay');
define('TM_BONUS_GLOBAL_PAY', 'bonus_global_pay');
define('TM_BONUS_UPGRADE', 'bonus_upgrade');
define('TM_COMMISSION_BECOME', 'commission_become');
if (!class_exists('BonusModel')) {
    class BonusModel extends PluginModel
    {
        private $agents = array();
        private $parentAgents = array();

        public function getSet()
        {
            $danxin_82 = parent::getSet();
            $danxin_82['texts'] = array('agent' => empty($danxin_82['texts']['agent']) ? '代理商' : $danxin_82['texts']['agent'], 'premiername' => empty($danxin_82['texts']['premiername']) ? '全球分红' : $danxin_82['texts']['premiername'], 'center' => empty($danxin_82['texts']['center']) ? '分红中心' : $danxin_82['texts']['center'], 'commission' => empty($danxin_82['texts']['commission']) ? '佣金' : $danxin_82['texts']['commission'], 'commission1' => empty($danxin_82['texts']['commission1']) ? '分红佣金' : $danxin_82['texts']['commission1'], 'commission_total' => empty($danxin_82['texts']['commission_total']) ? '累计分红佣金' : $danxin_82['texts']['commission_total'], 'commission_ok' => empty($danxin_82['texts']['commission_ok']) ? '待分红佣金' : $danxin_82['texts']['commission_ok'], 'commission_apply' => empty($danxin_82['texts']['commission_apply']) ? '已申请佣金' : $danxin_82['texts']['commission_apply'], 'commission_check' => empty($danxin_82['texts']['commission_check']) ? '待打款佣金' : $danxin_82['texts']['commission_check'], 'commission_lock' => empty($danxin_82['texts']['commission_lock']) ? '未结算佣金' : $danxin_82['texts']['commission_lock'], 'commission_detail' => empty($danxin_82['texts']['commission_detail']) ? '分红明细' : $danxin_82['texts']['commission_detail'], 'commission_pay' => empty($danxin_82['texts']['commission_pay']) ? '已分红佣金' : $danxin_82['texts']['commission_pay'], 'order' => empty($danxin_82['texts']['order']) ? '分红订单' : $danxin_82['texts']['order'], 'order_area' => empty($danxin_82['texts']['order_area']) ? '区域订单' : $danxin_82['texts']['order_area'], 'mycustomer' => empty($danxin_82['texts']['mycustomer']) ? '我的下线' : $danxin_82['texts']['mycustomer'], 'agent_province' => empty($danxin_82['texts']['agent_province']) ? '省级代理' : $danxin_82['texts']['agent_province'], 'agent_city' => empty($danxin_82['texts']['agent_city']) ? '市级代理' : $danxin_82['texts']['agent_city'], 'agent_district' => empty($danxin_82['texts']['agent_district']) ? '区级代理' : $danxin_82['texts']['agent_district']);
            return $danxin_82;
        }

        public function getParentAgents($danxin_80, $danxin_79, $danxin_77 = -1)
        {
            global $_W;
            $danxin_78 = 'select id, agentid, bonuslevel, bonus_status from ' . tablename('sz_yi_member') . " where id={$danxin_80} and uniacid=" . $_W['uniacid'];
            $danxin_83 = pdo_fetch($danxin_78);
            if (empty($danxin_83)) {
                return $this->parentAgents;
            } else {
                if (!empty($danxin_83['bonuslevel'])) {
                    if ($danxin_79 == 0) {
                        $danxin_84 = pdo_fetchcolumn('select level from ' . tablename('sz_yi_bonus_level') . ' where id=' . $danxin_83['bonuslevel']);
                        if (empty($this->parentAgents[$danxin_83['bonuslevel']]) && $danxin_77 < $danxin_84) {
                            $this->parentAgents[$danxin_83['bonuslevel']] = $danxin_83['id'];
                        }
                    } else {
                        if (empty($this->parentAgents[$danxin_83['bonuslevel']])) {
                            $this->parentAgents[$danxin_83['bonuslevel']] = $danxin_83['id'];
                        }
                    }
                }
                if ($danxin_83['agentid'] != 0) {
                    return $this->getParentAgents($danxin_83['agentid'], $danxin_79, $danxin_84);
                } else {
                    return $this->parentAgents;
                }
            }
        }

        public function calculate($danxin_89 = 0, $danxin_88 = true)
        {
            global $_W;
            $danxin_82 = $this->getSet();
            $danxin_87 = $this->getLevels();
            $danxin_85 = time();
            $danxin_86 = pdo_fetch('select openid, address from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $danxin_89));
            $danxin_76 = $danxin_86['openid'];
            $danxin_75 = unserialize($danxin_86['address']);
            $danxin_66 = pdo_fetchall('select og.id,og.realprice,og.price,og.goodsid,og.total,og.optionname,g.hascommission,g.nocommission,g.nobonus,g.bonusmoney,g.productprice,g.marketprice,g.costprice from ' . tablename('sz_yi_order_goods') . '  og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id = og.goodsid' . ' where og.orderid=:orderid and og.uniacid=:uniacid', array(':orderid' => $danxin_89, ':uniacid' => $_W['uniacid']));
            $danxin_67 = m('member')->getInfo($danxin_76);
            $danxin_87 = pdo_fetchall('SELECT * FROM ' . tablename('sz_yi_bonus_level') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY level asc");
            $danxin_79 = empty($danxin_82['isdistinction']) ? 0 : 1;
            foreach ($danxin_66 as $danxin_65) {
                $danxin_64 = $this->calculate_method($danxin_65);
                if (empty($danxin_65['nobonus']) && $danxin_64 > 0) {
                    if (empty($danxin_82['selfbuy'])) {
                        $danxin_62 = $danxin_67['agentid'];
                    } else {
                        $danxin_62 = $danxin_67['id'];
                    }
                    if (!empty($danxin_62)) {
                        $danxin_63 = $this->getParentAgents($danxin_62, $danxin_79);
                        $danxin_68 = 0;
                        foreach ($danxin_87 as $danxin_69 => $danxin_77) {
                            $danxin_74 = $danxin_77['id'];
                            if (array_key_exists($danxin_74, $danxin_63)) {
                                if ($danxin_77['agent_money'] > 0) {
                                    $danxin_73 = $danxin_77['agent_money'] / 100;
                                } else {
                                    continue;
                                }
                                $danxin_72 = round($danxin_64 * $danxin_73, 2);
                                if ($danxin_79 == 0) {
                                    $danxin_70 = $danxin_72 - $danxin_68;
                                    $danxin_68 = $danxin_72;
                                } else {
                                    $danxin_70 = $danxin_72;
                                }
                                if ($danxin_70 <= 0) {
                                    continue;
                                }
                                $danxin_71 = array('uniacid' => $_W['uniacid'], 'ordergoodid' => $danxin_65['goodsid'], 'orderid' => $danxin_89, 'total' => $danxin_65['total'], 'optionname' => $danxin_65['optionname'], 'mid' => $danxin_63[$danxin_74], 'levelid' => $danxin_74, 'money' => $danxin_70, 'createtime' => $danxin_85);
                                pdo_insert('sz_yi_bonus_goods', $danxin_71);
                            }
                        }
                    }
                    $danxin_90 = 0;
                    if (!empty($danxin_82['area_start'])) {
                        $danxin_91 = floatval($danxin_82['bonus_commission3']);
                        if (!empty($danxin_91)) {
                            $danxin_111 = pdo_fetchall('select id, bonus_area_commission from ' . tablename('sz_yi_member') . ' where bonus_province=\'' . $danxin_75['province'] . '\' and bonus_city=\'' . $danxin_75['city'] . '\' and bonus_district=\'' . $danxin_75['area'] . '\' and bonus_area=3 and uniacid=' . $_W['uniacid']);
                            if (!empty($danxin_111)) {
                                foreach ($danxin_111 as $danxin_69 => $danxin_112) {
                                    if ($danxin_112['bonus_area_commission'] > 0) {
                                        $danxin_110 = round($danxin_64 * $danxin_112['bonus_area_commission'] / 100, 2);
                                    } else {
                                        $danxin_110 = round($danxin_64 * $danxin_82['bonus_commission3'] / 100, 2);
                                    }
                                    if (empty($danxin_82['isdistinction_area'])) {
                                        $danxin_109 = $danxin_110 - $danxin_90;
                                        $danxin_90 = $danxin_110;
                                    } else {
                                        $danxin_109 = $danxin_110;
                                    }
                                    if ($danxin_109 > 0) {
                                        $danxin_71 = array('uniacid' => $_W['uniacid'], 'ordergoodid' => $danxin_65['goodsid'], 'orderid' => $danxin_89, 'total' => $danxin_65['total'], 'optionname' => $danxin_65['optionname'], 'mid' => $danxin_112['id'], 'bonus_area' => 3, 'money' => $danxin_109, 'createtime' => $danxin_85);
                                    }
                                    pdo_insert('sz_yi_bonus_goods', $danxin_71);
                                    if (empty($danxin_82['isdistinction_area']) || empty($danxin_82['isdistinction_area_all'])) {
                                        break;
                                    }
                                }
                            }
                        }
                        $danxin_107 = floatval($danxin_82['bonus_commission2']);
                        if (!empty($danxin_107)) {
                            $danxin_108 = pdo_fetchall('select id, bonus_area_commission from ' . tablename('sz_yi_member') . ' where bonus_province=\'' . $danxin_75['province'] . '\' and bonus_city=\'' . $danxin_75['city'] . '\' and bonus_area=2 and uniacid=' . $_W['uniacid']);
                            if (!empty($danxin_108)) {
                                foreach ($danxin_108 as $danxin_69 => $danxin_114) {
                                    if ($danxin_114['bonus_area_commission'] > 0) {
                                        $danxin_110 = round($danxin_64 * $danxin_114['bonus_area_commission'] / 100, 2);
                                    } else {
                                        $danxin_110 = round($danxin_64 * $danxin_82['bonus_commission2'] / 100, 2);
                                    }
                                    if (empty($danxin_82['isdistinction_area'])) {
                                        $danxin_109 = $danxin_110 - $danxin_90;
                                        $danxin_90 = $danxin_110;
                                    } else {
                                        $danxin_109 = $danxin_110;
                                    }
                                    if ($danxin_109 > 0) {
                                        $danxin_71 = array('uniacid' => $_W['uniacid'], 'ordergoodid' => $danxin_65['goodsid'], 'orderid' => $danxin_89, 'total' => $danxin_65['total'], 'optionname' => $danxin_65['optionname'], 'mid' => $danxin_114['id'], 'bonus_area' => 2, 'money' => $danxin_109, 'createtime' => $danxin_85);
                                        pdo_insert('sz_yi_bonus_goods', $danxin_71);
                                    }
                                    if (empty($danxin_82['isdistinction_area']) || empty($danxin_82['isdistinction_area_all'])) {
                                        break;
                                    }
                                }
                            }
                        }
                        $danxin_117 = floatval($danxin_82['bonus_commission1']);
                        if (!empty($danxin_117)) {
                            $danxin_120 = pdo_fetchall('select id, bonus_area_commission from ' . tablename('sz_yi_member') . ' where bonus_province=\'' . $danxin_75['province'] . '\' and bonus_area=1 and uniacid=' . $_W['uniacid']);
                            if (!empty($danxin_120)) {
                                foreach ($danxin_120 as $danxin_69 => $danxin_119) {
                                    if ($danxin_119['bonus_area_commission'] > 0) {
                                        $danxin_110 = round($danxin_64 * $danxin_119['bonus_area_commission'] / 100, 2);
                                    } else {
                                        $danxin_110 = round($danxin_64 * $danxin_82['bonus_commission1'] / 100, 2);
                                    }
                                    if (empty($danxin_82['isdistinction_area'])) {
                                        $danxin_109 = $danxin_110 - $danxin_90;
                                        $danxin_90 = $danxin_110;
                                    } else {
                                        $danxin_109 = $danxin_110;
                                    }
                                    if ($danxin_109 > 0) {
                                        $danxin_71 = array('uniacid' => $_W['uniacid'], 'ordergoodid' => $danxin_65['goodsid'], 'orderid' => $danxin_89, 'total' => $danxin_65['total'], 'optionname' => $danxin_65['optionname'], 'mid' => $danxin_119['id'], 'bonus_area' => 1, 'money' => $danxin_109, 'createtime' => $danxin_85);
                                        pdo_insert('sz_yi_bonus_goods', $danxin_71);
                                    }
                                    if (empty($danxin_82['isdistinction_area']) || empty($danxin_82['isdistinction_area_all'])) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        public function calculate_method($danxin_118)
        {
            global $_W;
            $danxin_82 = $this->getSet();
            $danxin_115 = $danxin_118['realprice'];
            if (empty($danxin_82['culate_method'])) {
                return $danxin_118['bonusmoney'] > 0 && !empty($danxin_118['bonusmoney']) ? $danxin_118['bonusmoney'] * $danxin_118['total'] : $danxin_118['price'];
            } else {
                if ($danxin_118['optionid'] != 0) {
                    $danxin_116 = pdo_fetch('select productprice,marketprice,costprice from ' . tablename('sz_yi_goods_option') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $danxin_118['optionid'], ':uniacid' => $_W['uniacid']));
                    $danxin_106 = $danxin_116['productprice'] * $danxin_118['total'];
                    $danxin_105 = $danxin_116['marketprice'] * $danxin_118['total'];
                    $danxin_96 = $danxin_116['costprice'] * $danxin_118['total'];
                } else {
                    $danxin_106 = $danxin_118['productprice'] * $danxin_118['total'];
                    $danxin_105 = $danxin_118['marketprice'] * $danxin_118['total'];
                    $danxin_96 = $danxin_118['costprice'] * $danxin_118['total'];
                }
                if ($danxin_82['culate_method'] == 1) {
                    return $danxin_115;
                } else if ($danxin_82['culate_method'] == 2) {
                    return $danxin_106;
                } else if ($danxin_82['culate_method'] == 3) {
                    return $danxin_105;
                } else if ($danxin_82['culate_method'] == 4) {
                    return $danxin_96;
                } else if ($danxin_82['culate_method'] == 5) {
                    $danxin_97 = $danxin_115 - $danxin_96;
                    return $danxin_97 > 0 ? $danxin_97 : 0;
                }
            }
        }

        public function getChildAgents($danxin_80)
        {
            global $_W;
            $danxin_78 = 'select id from ' . tablename('sz_yi_member') . " where agentid={$danxin_80} and id!={$danxin_80} and status=1 and isagent = 1 and uniacid=" . $_W['uniacid'];
            $danxin_95 = pdo_fetchall($danxin_78);
            foreach ($danxin_95 as $danxin_94) {
                $this->agents[] = $danxin_94['id'];
                $this->getChildAgents($danxin_94['id']);
            }
            return $this->agents;
        }

        public function getLevels($danxin_92 = true)
        {
            global $_W;
            if ($danxin_92) {
                return pdo_fetchall('select * from ' . tablename('sz_yi_bonus_level') . ' where uniacid=:uniacid order by level asc', array(':uniacid' => $_W['uniacid']));
            } else {
                return pdo_fetchall('select * from ' . tablename('sz_yi_bonus_level') . ' where uniacid=:uniacid and (ordermoney>0 or commissionmoney>0) order by level asc', array(':uniacid' => $_W['uniacid']));
            }
        }

        public function premierInfo($danxin_76, $danxin_93 = null)
        {
            if (empty($danxin_93) || !is_array($danxin_93)) {
                $danxin_93 = array();
            }
            global $_W;
            $danxin_82 = $this->getSet();
            $danxin_67 = m('member')->getInfo($danxin_76);
            $danxin_98 = 0;
            $danxin_99 = 0;
            $danxin_104 = 0;
            $danxin_103 = 0;
            $danxin_102 = 0;
            $danxin_85 = time();
            $danxin_100 = intval($danxin_82['settledays']) * 3600 * 24;
            if (in_array('ok', $danxin_93)) {
                $danxin_78 = 'select sum(o.price) as money from ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid={$_W['uniacid']} and ({$danxin_85} - o.finishtime > {$danxin_100}) ORDER BY o.createtime DESC,o.status DESC";
                $danxin_99 = pdo_fetchcolumn($danxin_78, array(':uniacid' => $_W['uniacid']));
            }
            if (in_array('total', $danxin_93)) {
                $danxin_78 = 'select sum(o.price) as money from ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_order_refund') . ' r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where o.status>=1 and o.uniacid=:uniacid  ORDER BY o.createtime DESC,o.status DESC';
                $danxin_98 = pdo_fetchcolumn($danxin_78, array(':uniacid' => $_W['uniacid']));
            }
            if (in_array('pay', $danxin_93)) {
                $danxin_78 = 'select sum(money) from ' . tablename('sz_yi_bonus_log') . ' where openid=:openid and isglobal=1 and uniacid=:uniacid';
                $danxin_104 = pdo_fetchcolumn($danxin_78, array(':uniacid' => $_W['uniacid'], 'openid' => $danxin_67['openid']));
            }
            if (in_array('myorder', $danxin_101)) {
                $danxin_61 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.openid=:openid and o.status>=3 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $danxin_67['openid']));
                $danxin_103 = $danxin_61['ordermoney'];
                $danxin_102 = $danxin_61['ordercount'];
            }
            $danxin_67['commission_ok'] = round($danxin_99, 2);
            $danxin_67['commission_total'] = round($danxin_98, 2);
            $danxin_67['commission_pay'] = $danxin_104;
            $danxin_67['myordermoney'] = $danxin_103;
            $danxin_67['myordercount'] = $danxin_102;
            return $danxin_67;
        }

        public function getInfo($danxin_76, $danxin_93 = null)
        {
            if (empty($danxin_93) || !is_array($danxin_93)) {
                $danxin_93 = array();
            }
            global $_W;
            $danxin_82 = $this->getSet();
            $danxin_67 = m('member')->getInfo($danxin_76);
            if (empty($danxin_67['id'])) {
                return false;
            }
            $danxin_98 = 0;
            $danxin_99 = 0;
            $danxin_60 = 0;
            $danxin_21 = 0;
            $danxin_22 = 0;
            $danxin_104 = 0;
            $danxin_20 = 0;
            $danxin_19 = 0;
            $danxin_17 = 0;
            $danxin_103 = 0;
            $danxin_102 = 0;
            $danxin_18 = $danxin_67['id'];
            $danxin_85 = time();
            $danxin_100 = intval($danxin_82['settledays']) * 3600 * 24;
            $this->agents = array();
            if (in_array('totaly', $danxin_93)) {
                $danxin_78 = 'select sum(money) as money from ' . tablename('sz_yi_order') . ' o left join  ' . tablename('sz_yi_bonus_goods') . '  cg on o.id=cg.orderid and cg.status=0 left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=0 and o.uniacid={$_W['uniacid']} and cg.mid = {$danxin_18} and cg.bonus_area = 0";
                $danxin_20 = pdo_fetchcolumn($danxin_78, array(':uniacid' => $_W['uniacid']));
            }
            if (in_array('totaly_area', $danxin_93)) {
                $danxin_78 = 'select sum(money) as money from ' . tablename('sz_yi_order') . ' o left join  ' . tablename('sz_yi_bonus_goods') . '  cg on o.id=cg.orderid and cg.status=0 left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=0 and o.uniacid={$_W['uniacid']} and cg.mid = {$danxin_18} and cg.bonus_area!=0";
                $danxin_19 = pdo_fetchcolumn($danxin_78, array(':uniacid' => $_W['uniacid']));
            }
            if (in_array('ok', $danxin_93)) {
                $danxin_78 = 'select sum(money) as money from ' . tablename('sz_yi_order') . ' o left join  ' . tablename('sz_yi_bonus_goods') . '  cg on o.id=cg.orderid and cg.status=0 left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid={$_W['uniacid']} and cg.mid = {$danxin_18} and ({$danxin_85} - o.finishtime > {$danxin_100}) ORDER BY o.createtime DESC,o.status DESC";
                $danxin_99 = pdo_fetchcolumn($danxin_78, array(':uniacid' => $_W['uniacid']));
            }
            if (in_array('total', $danxin_93)) {
                $danxin_78 = 'select sum(money) as money from ' . tablename('sz_yi_order') . ' o left join  ' . tablename('sz_yi_bonus_goods') . '  cg on o.id=cg.orderid left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where o.status>=1 and o.uniacid=:uniacid and cg.mid = {$danxin_18} ORDER BY o.createtime DESC,o.status DESC";
                $danxin_98 = pdo_fetchcolumn($danxin_78, array(':uniacid' => $_W['uniacid']));
            }
            if (in_array('ordercount', $danxin_93)) {
                $danxin_23 = pdo_fetchcolumn('select count(distinct o.id) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_bonus_goods') . ' cg on cg.orderid=o.id  where o.status>=0 and cg.status>=0 and o.uniacid=' . $_W['uniacid'] . ' and cg.mid =' . $danxin_18 . ' and cg.bonus_area=0 limit 1');
            }
            if (in_array('ordercount_area', $danxin_93)) {
                $danxin_17 = pdo_fetchcolumn('select count(distinct o.id) as ordercount_area from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_bonus_goods') . ' cg on cg.orderid=o.id  where o.status>=0 and cg.status>=0 and o.uniacid=' . $_W['uniacid'] . ' and cg.mid =' . $danxin_18 . ' and cg.bonus_area!=0 limit 1');
            }
            if (in_array('apply', $danxin_93)) {
                $danxin_78 = 'select sum(money) as money from ' . tablename('sz_yi_order') . ' o left join  ' . tablename('sz_yi_bonus_goods') . '  cg on o.id=cg.orderid and cg.status=1 left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid={$_W['uniacid']} and cg.mid = {$danxin_18} and ({$danxin_85} - o.finishtime <= {$danxin_100}) ORDER BY o.createtime DESC,o.status DESC";
                $danxin_60 = pdo_fetchcolumn($danxin_78);
            }
            if (in_array('check', $danxin_93)) {
                $danxin_78 = 'select sum(money) as money from ' . tablename('sz_yi_order') . ' o left join  ' . tablename('sz_yi_bonus_goods') . '  cg on o.id=cg.orderid and cg.status=2 left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid={$_W['uniacid']} and cg.mid = {$danxin_18} and ({$danxin_85} - o.finishtime <= {$danxin_100}) ORDER BY o.createtime DESC,o.status DESC";
                $danxin_21 = pdo_fetchcolumn($danxin_78);
            }
            if (in_array('pay', $danxin_93)) {
                $danxin_78 = 'select sum(money) as money from ' . tablename('sz_yi_order') . ' o left join  ' . tablename('sz_yi_bonus_goods') . '  cg on o.id=cg.orderid and cg.status=3 left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid={$_W['uniacid']} and cg.mid = {$danxin_18} ORDER BY o.createtime DESC,o.status DESC";
                $danxin_104 = pdo_fetchcolumn($danxin_78);
            }
            if (in_array('lock', $danxin_93)) {
                $danxin_78 = 'select sum(money) as money from ' . tablename('sz_yi_order') . ' o left join  ' . tablename('sz_yi_bonus_goods') . '  cg on o.id=cg.orderid and cg.status=1 left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid={$_W['uniacid']} and cg.mid = {$danxin_18} and ({$danxin_85} - o.finishtime <= {$danxin_100}) ORDER BY o.createtime DESC,o.status DESC";
                $danxin_22 = pdo_fetchcolumn($danxin_78);
            }
            if (in_array('myorder', $danxin_93)) {
                $danxin_61 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.openid=:openid and o.status>=3 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $danxin_67['openid']));
                $danxin_103 = $danxin_61['ordermoney'];
                $danxin_102 = $danxin_61['ordercount'];
            }
            $danxin_24 = $this->getChildAgents($danxin_67['id']);
            $danxin_29 = count($danxin_24);
            $danxin_67['commission_ok'] = isset($danxin_99) ? $danxin_99 : 0;
            $danxin_67['commission_total'] = isset($danxin_98) ? $danxin_98 : 0;
            $danxin_67['commission_pay'] = isset($danxin_104) ? $danxin_104 : 0;
            $danxin_67['commission_apply'] = isset($danxin_60) ? $danxin_60 : 0;
            $danxin_67['commission_check'] = isset($danxin_21) ? $danxin_21 : 0;
            $danxin_67['commission_lock'] = isset($danxin_22) ? $danxin_22 : 0;
            $danxin_67['commission_totaly'] = isset($danxin_20) ? $danxin_20 : 0;
            $danxin_67['commission_totaly_area'] = isset($danxin_19) ? $danxin_19 : 0;
            $danxin_67['ordercount'] = $danxin_23;
            $danxin_67['ordercount_area'] = $danxin_17;
            $danxin_67['agentcount'] = $danxin_29;
            $danxin_67['agentids'] = $danxin_24;
            $danxin_67['myordermoney'] = $danxin_103;
            $danxin_67['myordercount'] = $danxin_102;
            return $danxin_67;
        }

        public function checkOrderConfirm($danxin_89 = '0')
        {
            global $_W, $_GPC;
            $danxin_82 = $this->getSet();
            if (empty($danxin_82['start'])) {
                return;
            }
            $this->calculate($danxin_89);
        }

        public function checkOrderPay($danxin_89 = '0')
        {
            global $_W, $_GPC;
            $danxin_82 = $this->getSet();
            if (empty($danxin_82['start'])) {
                return;
            }
            $danxin_86 = pdo_fetch('select id,openid,ordersn,goodsprice,agentid,paytime from ' . tablename('sz_yi_order') . ' where id=:id and status>=1 and uniacid=:uniacid limit 1', array(':id' => $danxin_89, ':uniacid' => $_W['uniacid']));
            if (empty($danxin_86)) {
                return;
            }
            $danxin_76 = $danxin_86['openid'];
            $danxin_67 = m('member')->getMember($danxin_76);
            if (empty($danxin_67)) {
                return;
            }
            $danxin_28 = pdo_fetchall('select g.id,g.title,og.total,og.price,og.realprice, og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1 from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $danxin_86['id']));
            $danxin_66 = '';
            $danxin_115 = 0;
            foreach ($danxin_28 as $danxin_27) {
                $danxin_66 .= "" . $danxin_27['title'] . '( ';
                if (!empty($danxin_27['optiontitle'])) {
                    $danxin_66 .= ' 规格: ' . $danxin_27['optiontitle'];
                }
                $danxin_66 .= ' 单价: ' . ($danxin_27['realprice'] / $danxin_27['total']) . ' 数量: ' . $danxin_27['total'] . ' 总价: ' . $danxin_27['realprice'] . '); ';
                $danxin_115 += $danxin_27['realprice'];
            }
            $danxin_25 = pdo_fetchall('select distinct mid from ' . tablename('sz_yi_bonus_goods') . ' where uniacid=:uniacid and orderid=:orderid', array(':orderid' => $danxin_86['id'], ':uniacid' => $_W['uniacid']));
            foreach ($danxin_25 as $danxin_69 => $danxin_26) {
                $danxin_76 = pdo_fetchcolumn('select openid from ' . tablename('sz_yi_member') . ' where id=' . $danxin_26['mid'] . ' and uniacid=' . $_W['uniacid']);
                $danxin_16 = pdo_fetchcolumn('select sum(money) from ' . tablename('sz_yi_bonus_goods') . ' where mid=' . $danxin_26['mid'] . ' and orderid=' . $danxin_86['id'] . ' and bonus_area=0 and uniacid=' . $_W['uniacid']);
                if ($danxin_16 > 0) {
                    $this->sendMessage($danxin_76, array('nickname' => $danxin_67['nickname'], 'ordersn' => $danxin_86['ordersn'], 'price' => $danxin_115, 'goods' => $danxin_66, 'commission' => $danxin_16, 'paytime' => $danxin_86['paytime']), TM_BONUS_ORDER_PAY);
                }
                $danxin_15 = pdo_fetchcolumn('select sum(money) from ' . tablename('sz_yi_bonus_goods') . ' where mid=' . $danxin_26['mid'] . ' and orderid=' . $danxin_86['id'] . ' and bonus_area > 0 and uniacid=' . $_W['uniacid']);
                if ($danxin_15 > 0) {
                    $this->sendMessage($danxin_76, array('nickname' => $danxin_67['nickname'], 'ordersn' => $danxin_86['ordersn'], 'price' => $danxin_115, 'goods' => $danxin_66, 'commission' => $danxin_15, 'paytime' => $danxin_86['paytime']), TM_BONUS_ORDER_AREA_PAY);
                }
                $this->upgradeLevelByAgent($danxin_76);
            }
        }

        public function checkOrderFinish($danxin_89 = '')
        {
            global $_W, $_GPC;
            if (empty($danxin_89)) {
                return;
            }
            $danxin_82 = $this->getSet();
            if (empty($danxin_82['start'])) {
                return;
            }
            $danxin_86 = pdo_fetch('select id,openid,ordersn,goodsprice,agentid,paytime,finishtime from ' . tablename('sz_yi_order') . ' where id=:id and status>=1 and uniacid=:uniacid limit 1', array(':id' => $danxin_89, ':uniacid' => $_W['uniacid']));
            if (empty($danxin_86)) {
                return;
            }
            $danxin_76 = $danxin_86['openid'];
            $danxin_67 = m('member')->getMember($danxin_76);
            if (empty($danxin_67)) {
                return;
            }
            $danxin_28 = pdo_fetchall('select g.id,g.title,og.total,og.price,og.realprice, og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1 from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $danxin_86['id']));
            $danxin_66 = '';
            $danxin_115 = 0;
            foreach ($danxin_28 as $danxin_27) {
                $danxin_66 .= "" . $danxin_27['title'] . '( ';
                if (!empty($danxin_27['optiontitle'])) {
                    $danxin_66 .= ' 规格: ' . $danxin_27['optiontitle'];
                }
                $danxin_66 .= ' 单价: ' . ($danxin_27['realprice'] / $danxin_27['total']) . ' 数量: ' . $danxin_27['total'] . ' 总价: ' . $danxin_27['realprice'] . '); ';
                $danxin_115 += $danxin_27['realprice'];
            }
            $danxin_25 = pdo_fetchall('select distinct mid from ' . tablename('sz_yi_bonus_goods') . ' where uniacid=:uniacid and orderid=:orderid', array(':orderid' => $danxin_89, ':uniacid' => $_W['uniacid']));
            foreach ($danxin_25 as $danxin_69 => $danxin_26) {
                $danxin_76 = pdo_fetchcolumn('select openid from ' . tablename('sz_yi_member') . ' where id=' . $danxin_26['mid'] . ' and uniacid=' . $_W['uniacid']);
                $danxin_16 = pdo_fetchcolumn('select sum(money) from ' . tablename('sz_yi_bonus_goods') . ' where mid=' . $danxin_26['mid'] . ' and orderid=' . $danxin_86['id'] . ' and bonus_area=0 and uniacid=' . $_W['uniacid']);
                if ($danxin_16 > 0) {
                    $this->sendMessage($danxin_76, array('nickname' => $danxin_67['nickname'], 'ordersn' => $danxin_86['ordersn'], 'price' => $danxin_115, 'goods' => $danxin_66, 'commission' => $danxin_16, 'finishtime' => $danxin_86['finishtime']), TM_BONUS_ORDER_FINISH);
                }
                $danxin_15 = pdo_fetchcolumn('select sum(money) from ' . tablename('sz_yi_bonus_goods') . ' where mid=' . $danxin_26['mid'] . ' and orderid=' . $danxin_86['id'] . ' and bonus_area > 0 and uniacid=' . $_W['uniacid']);
                if ($danxin_15 > 0) {
                    $this->sendMessage($danxin_76, array('nickname' => $danxin_67['nickname'], 'ordersn' => $danxin_86['ordersn'], 'price' => $danxin_115, 'goods' => $danxin_66, 'commission' => $danxin_15, 'finishtime' => $danxin_86['finishtime']), TM_BONUS_ORDER_AREA_FINISH);
                }
                $this->upgradeLevelByAgent($danxin_76);
            }
        }

        public function getLevel($danxin_76)
        {
            global $_W;
            if (empty($danxin_76)) {
                return false;
            }
            $danxin_67 = m('member')->getMember($danxin_76);
            if (empty($danxin_67['bonuslevel'])) {
                return false;
            }
            $danxin_77 = pdo_fetch('select * from ' . tablename('sz_yi_bonus_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $danxin_67['bonuslevel']));
            return $danxin_77;
        }

        public function isLevel($danxin_76)
        {
            global $_W;
            if (empty($danxin_76)) {
                return false;
            }
            $danxin_67 = m('member')->getMember($danxin_76);
            if (empty($danxin_67['bonuslevel'])) {
                $danxin_74 = 0;
            } else {
                $danxin_74 = pdo_fetchcolumn('select id from ' . tablename('sz_yi_bonus_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $danxin_67['bonuslevel']));
            }
            if (!empty($danxin_74) || !empty($danxin_67['bonus_area'])) {
                return true;
            } else {
                return false;
            }
        }

        public function upgradeLevelByAgent($danxin_5)
        {
            global $_W;
            if (empty($danxin_5)) {
                return false;
            }
            $danxin_82 = $this->getSet();
            $danxin_67 = p('commission')->getInfo($danxin_5, array('ordercount0'));
            if (empty($danxin_67)) {
                return;
            }
            if (empty($danxin_67['bonuslevel'])) {
                $danxin_6 = false;
                $danxin_4 = pdo_fetch('select * from ' . tablename('sz_yi_bonus_level') . ' where uniacid=' . $_W['uniacid'] . ' order by level asc');
            } else {
                $danxin_6 = $this->getLevel($danxin_67['openid']);
                $danxin_3 = pdo_fetchcolumn('select level from ' . tablename('sz_yi_bonus_level') . ' where  uniacid=:uniacid and id=:bonuslevel order by level asc', array(':uniacid' => $_W['uniacid'], ':bonuslevel' => $danxin_67['bonuslevel']));
                $danxin_4 = pdo_fetch('select * from ' . tablename('sz_yi_bonus_level') . ' where  uniacid=:uniacid and level>:levelby order by level asc', array(':uniacid' => $_W['uniacid'], ':levelby' => $danxin_3));
            }
            if (empty($danxin_4) || $danxin_4['status'] == 1) {
                return false;
            }
            $danxin_1 = $danxin_82['leveltype'];
            $danxin_2 = true;
            if (in_array('4', $danxin_1)) {
                $danxin_7 = pdo_fetchcolumn('select sum(price) from ' . tablename('sz_yi_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $danxin_67['openid']));
                if ($danxin_4['ordermoney'] > 0) {
                    if ($danxin_7 < $danxin_4['ordermoney']) {
                        $danxin_2 = false;
                    }
                }
            }
            if (in_array('8', $danxin_1)) {
                if (!empty($danxin_4['downcount'])) {
                    if ($danxin_67['agentcount'] < $danxin_4['downcount']) {
                        $danxin_2 = false;
                    }
                }
            }
            if (in_array('9', $danxin_1)) {
                if (!empty($danxin_4['downcountlevel1'])) {
                    if ($danxin_67['level1'] < $danxin_4['downcountlevel1']) {
                        $danxin_2 = false;
                    }
                }
            }
            if (in_array('11', $danxin_1)) {
                if ($danxin_4['commissionmoney'] > 0) {
                    if ($danxin_67['ordermoney0'] < $danxin_4['commissionmoney']) {
                        $danxin_2 = false;
                    }
                }
            }
            if ($danxin_2 == true) {
                pdo_update('sz_yi_member', array('bonuslevel' => $danxin_4['id'], 'bonus_status' =>１), array('id' => $danxin_67['id'])); $danxin_8 = $this->upgradeLevelByAgent($danxin_67['id']); if ($danxin_8 == false) {
                    $this->sendMessage($danxin_67['openid'], array('nickname' => $danxin_67['nickname'], 'oldlevel' => $danxin_6, 'newlevel' => $danxin_4,), TM_BONUS_UPGRADE);
                } return true; }
            return false;
        }

        function sendMessage($danxin_76 = '', $danxin_71 = array(), $danxin_13 = '')
        {
            global $_W, $_GPC;
            $danxin_82 = $this->getSet();
            $danxin_14 = $danxin_82['tm'];
            $danxin_12 = $danxin_14['templateid'];
            $danxin_67 = m('member')->getMember($danxin_76);
            $danxin_11 = unserialize($danxin_67['noticeset']);
            if (!is_array($danxin_11)) {
                $danxin_11 = array();
            }
            if ($danxin_13 == TM_COMMISSION_AGENT_NEW && !empty($danxin_14['commission_agent_new']) && empty($danxin_11['commission_agent_new'])) {
                $danxin_9 = $danxin_14['commission_agent_new'];
                $danxin_9 = str_replace('[昵称]', $danxin_71['nickname'], $danxin_9);
                $danxin_9 = str_replace('[时间]', date('Y-m-d H:i:s', $danxin_71['childtime']), $danxin_9);
                $danxin_10 = array('keyword1' => array('value' => !empty($danxin_14['commission_agent_newtitle']) ? $danxin_14['commission_agent_newtitle'] : '新增下线通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $danxin_9, 'color' => '#73a68d'));
                if (!empty($danxin_12)) {
                    m('message')->sendTplNotice($danxin_76, $danxin_12, $danxin_10);
                } else {
                    m('message')->sendCustomNotice($danxin_76, $danxin_10);
                }
            } else if ($danxin_13 == TM_BONUS_ORDER_PAY && !empty($danxin_14['bonus_order_pay']) && empty($danxin_11['bonus_order_pay'])) {
                $danxin_9 = $danxin_14['bonus_order_pay'];
                $danxin_9 = str_replace('[昵称]', $danxin_71['nickname'], $danxin_9);
                $danxin_9 = str_replace('[时间]', date('Y-m-d H:i:s', $danxin_71['paytime']), $danxin_9);
                $danxin_9 = str_replace('[订单编号]', $danxin_71['ordersn'], $danxin_9);
                $danxin_9 = str_replace('[订单金额]', $danxin_71['price'], $danxin_9);
                $danxin_9 = str_replace('[分红金额]', $danxin_71['commission'], $danxin_9);
                $danxin_9 = str_replace('[商品详情]', $danxin_71['goods'], $danxin_9);
                $danxin_10 = array('keyword1' => array('value' => !empty($danxin_14['bonus_order_paytitle']) ? $danxin_14['bonus_order_paytitle'] : '股权代理下级付款通知"'), 'keyword2' => array('value' => $danxin_9));
                if (!empty($danxin_12)) {
                    m('message')->sendTplNotice($danxin_76, $danxin_12, $danxin_10);
                } else {
                    m('message')->sendCustomNotice($danxin_76, $danxin_10);
                }
            } else if ($danxin_13 == TM_BONUS_ORDER_FINISH && !empty($danxin_14['bonus_order_finish']) && empty($danxin_11['bonus_order_finish'])) {
                $danxin_9 = $danxin_14['bonus_order_finish'];
                $danxin_9 = str_replace('[昵称]', $danxin_71['nickname'], $danxin_9);
                $danxin_9 = str_replace('[时间]', date('Y-m-d H:i:s', $danxin_71['finishtime']), $danxin_9);
                $danxin_9 = str_replace('[订单编号]', $danxin_71['ordersn'], $danxin_9);
                $danxin_9 = str_replace('[订单金额]', $danxin_71['price'], $danxin_9);
                $danxin_9 = str_replace('[分红金额]', $danxin_71['commission'], $danxin_9);
                $danxin_9 = str_replace('[商品详情]', $danxin_71['goods'], $danxin_9);
                $danxin_10 = array('keyword1' => array('value' => !empty($danxin_14['bonus_order_finishtitle']) ? $danxin_14['bonus_order_finishtitle'] : '股权代理下级确认收货通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $danxin_9, 'color' => '#73a68d'));
                if (!empty($danxin_12)) {
                    m('message')->sendTplNotice($danxin_76, $danxin_12, $danxin_10);
                } else {
                    m('message')->sendCustomNotice($danxin_76, $danxin_10);
                }
            } else if ($danxin_13 == TM_BONUS_ORDER_AREA_PAY && !empty($danxin_14['bonus_order_area_pay']) && empty($danxin_11['bonus_order_area_pay'])) {
                $danxin_9 = $danxin_14['bonus_order_area_pay'];
                $danxin_9 = str_replace('[昵称]', $danxin_71['nickname'], $danxin_9);
                $danxin_9 = str_replace('[时间]', date('Y-m-d H:i:s', $danxin_71['paytime']), $danxin_9);
                $danxin_9 = str_replace('[订单编号]', $danxin_71['ordersn'], $danxin_9);
                $danxin_9 = str_replace('[订单金额]', $danxin_71['price'], $danxin_9);
                $danxin_9 = str_replace('[分红金额]', $danxin_71['commission'], $danxin_9);
                $danxin_9 = str_replace('[商品详情]', $danxin_71['goods'], $danxin_9);
                $danxin_10 = array('keyword1' => array('value' => !empty($danxin_14['bonus_order_area_paytitle']) ? $danxin_14['bonus_order_area_paytitle'] : '区域代理下级付款通知"'), 'keyword2' => array('value' => $danxin_9));
                if (!empty($danxin_12)) {
                    m('message')->sendTplNotice($danxin_76, $danxin_12, $danxin_10);
                } else {
                    m('message')->sendCustomNotice($danxin_76, $danxin_10);
                }
            } else if ($danxin_13 == TM_BONUS_ORDER_AREA_FINISH && !empty($danxin_14['bonus_order_area_finish']) && empty($danxin_11['bonus_order_area_finish'])) {
                $danxin_9 = $danxin_14['bonus_order_area_finish'];
                $danxin_9 = str_replace('[昵称]', $danxin_71['nickname'], $danxin_9);
                $danxin_9 = str_replace('[时间]', date('Y-m-d H:i:s', $danxin_71['finishtime']), $danxin_9);
                $danxin_9 = str_replace('[订单编号]', $danxin_71['ordersn'], $danxin_9);
                $danxin_9 = str_replace('[订单金额]', $danxin_71['price'], $danxin_9);
                $danxin_9 = str_replace('[分红金额]', $danxin_71['commission'], $danxin_9);
                $danxin_9 = str_replace('[商品详情]', $danxin_71['goods'], $danxin_9);
                $danxin_10 = array('keyword1' => array('value' => !empty($danxin_14['bonus_order_area_finishtitle']) ? $danxin_14['bonus_order_area_finishtitle'] : '区域代理下级确认收货通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $danxin_9, 'color' => '#73a68d'));
                if (!empty($danxin_12)) {
                    m('message')->sendTplNotice($danxin_76, $danxin_12, $danxin_10);
                } else {
                    m('message')->sendCustomNotice($danxin_76, $danxin_10);
                }
            } else if ($danxin_13 == TM_BONUS_PAY && !empty($danxin_14['bonus_pay']) && empty($danxin_11['bonus_pay'])) {
                $danxin_9 = $danxin_14['bonus_pay'];
                $danxin_9 = str_replace('[昵称]', $danxin_67['nickname'], $danxin_9);
                $danxin_9 = str_replace('[时间]', date('Y-m-d H:i:s', time()), $danxin_9);
                $danxin_9 = str_replace('[金额]', $danxin_71['commission'], $danxin_9);
                $danxin_9 = str_replace('[打款方式]', $danxin_71['type'], $danxin_9);
                $danxin_9 = str_replace('[代理等级]', $danxin_71['levelname'], $danxin_9);
                $danxin_10 = array('keyword1' => array('value' => !empty($danxin_14['bonus_paytitle']) ? $danxin_14['bonus_paytitle'] : '代理分红打款通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $danxin_9, 'color' => '#73a68d'));
                if (!empty($danxin_12)) {
                    m('message')->sendTplNotice($danxin_76, $danxin_12, $danxin_10);
                } else {
                    m('message')->sendCustomNotice($danxin_76, $danxin_10);
                }
            } else if ($danxin_13 == TM_BONUS_GLOBAL_PAY && !empty($danxin_14['bonus_global_pay']) && empty($danxin_11['bonus_global_pay'])) {
                $danxin_9 = $danxin_14['bonus_global_pay'];
                $danxin_9 = str_replace('[昵称]', $danxin_67['nickname'], $danxin_9);
                $danxin_9 = str_replace('[时间]', date('Y-m-d H:i:s', time()), $danxin_9);
                $danxin_9 = str_replace('[金额]', $danxin_71['commission'], $danxin_9);
                $danxin_9 = str_replace('[打款方式]', $danxin_71['type'], $danxin_9);
                $danxin_9 = str_replace('[代理等级]', $danxin_71['levelname'], $danxin_9);
                $danxin_10 = array('keyword1' => array('value' => !empty($danxin_14['bonus_global_paytitle']) ? $danxin_14['bonus_global_paytitle'] : '全球分红打款通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $danxin_9, 'color' => '#73a68d'));
                if (!empty($danxin_12)) {
                    m('message')->sendTplNotice($danxin_76, $danxin_12, $danxin_10);
                } else {
                    m('message')->sendCustomNotice($danxin_76, $danxin_10);
                }
            } else if ($danxin_13 == TM_BONUS_UPGRADE && !empty($danxin_14['bonus_upgrade']) && empty($danxin_11['bonus_upgrade'])) {
                $danxin_9 = $danxin_14['bonus_upgrade'];
                if (!empty($danxin_71['newlevel']['msgcontent'])) {
                    $danxin_9 = $danxin_71['newlevel']['msgcontent'];
                }
                $danxin_9 = str_replace('[昵称]', $danxin_67['nickname'], $danxin_9);
                $danxin_9 = str_replace('[时间]', date('Y-m-d H:i:s', time()), $danxin_9);
                $danxin_9 = str_replace('[旧等级]', $danxin_71['oldlevel']['levelname'], $danxin_9);
                $danxin_9 = str_replace('[旧分红比例]', $danxin_71['oldlevel']['agent_money'] . '%', $danxin_9);
                $danxin_9 = str_replace('[新等级]', $danxin_71['newlevel']['levelname'], $danxin_9);
                $danxin_9 = str_replace('[新分红比例]', $danxin_71['newlevel']['agent_money'] . '%', $danxin_9);
                $danxin_14['bonus_upgradetitle'] = !empty($danxin_14['bonus_upgradetitle']) ? $danxin_14['bonus_upgradetitle'] : '代理商等级升级通知';
                $danxin_10 = array('keyword1' => array('value' => !empty($danxin_71['newlevel']['msgtitle']) ? $danxin_71['newlevel']['msgtitle'] : $danxin_14['bonus_upgradetitle'], 'color' => '#73a68d'), 'keyword2' => array('value' => $danxin_9, 'color' => '#73a68d'));
                if (!empty($danxin_12)) {
                    m('message')->sendTplNotice($danxin_76, $danxin_12, $danxin_10);
                } else {
                    m('message')->sendCustomNotice($danxin_76, $danxin_10);
                }
            } else if ($danxin_13 == TM_COMMISSION_BECOME && !empty($danxin_14['commission_become']) && empty($danxin_11['commission_become'])) {
                $danxin_9 = $danxin_14['commission_become'];
                $danxin_9 = str_replace('[昵称]', $danxin_71['nickname'], $danxin_9);
                $danxin_9 = str_replace('[时间]', date('Y-m-d H:i:s', $danxin_71['agenttime']), $danxin_9);
                $danxin_10 = array('keyword1' => array('value' => !empty($danxin_14['commission_becometitle']) ? $danxin_14['commission_becometitle'] : '成为分销商通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $danxin_9, 'color' => '#73a68d'));
                if (!empty($danxin_12)) {
                    m('message')->sendTplNotice($danxin_76, $danxin_12, $danxin_10);
                } else {
                    m('message')->sendCustomNotice($danxin_76, $danxin_10);
                }
            }
        }

        function perms()
        {
            return array('bonus' => array('text' => $this->getName(), 'isplugin' => true, 'child' => array('cover' => array('text' => '入口设置'), 'agent' => array('text' => '代理商管理', 'view' => '浏览', 'edit' => '修改-log', 'user' => '查看下线', 'order' => '查看推广订单(还需有订单权限)', 'changeagent' => '设置代理商'), 'level' => array('text' => '代理商等级', 'view' => '浏览', 'add' => '添加-log', 'edit' => '修改-log', 'delete' => '删除-log'), 'send' => array('text' => '代理分红', 'view' => '浏览', 'bont' => '分红按钮'), 'sendall' => array('text' => '全球分红', 'view' => '浏览', 'bont' => '分红按钮'), 'detail' => array('text' => '分红明细', 'view' => '浏览', 'afresh' => '重发分红'), 'notice' => array('text' => '通知设置-log'), 'set' => array('text' => '基础设置-log'))));
        }

        public function autosend()
        {
            global $_W, $_GPC;
            $danxin_85 = time();
            $danxin_30 = 0;
            $danxin_70 = 0;
            $danxin_31 = false;
            $danxin_82 = $this->getSet();
            $danxin_51 = m('common')->getSysset('shop');
            $danxin_100 = intval($danxin_82['settledays']) * 3600 * 24;
            $danxin_52 = strtotime(date('Y-m-d 00:00:00'));
            if (empty($danxin_82['sendmonth'])) {
                $danxin_50 = $danxin_52 - $danxin_100;
                $danxin_49 = strtotime(date('Y-m-d ' . $danxin_82['senddaytime'] . ':00:00'));
            } else if ($danxin_82['sendmonth'] == 1) {
                $danxin_47 = date('Y-m-d', mktime(0, 0, 0, date('m') - 1, 1, date('Y')));
                $danxin_50 = $danxin_47 - $danxin_100;
                $danxin_48 = empty($danxin_82['interval_day']) ? 1 : 1 + $danxin_82['interval_day'];
                $danxin_49 = strtotime(date('Y-' . date('m') . '-' . $danxin_48 . ' ' . $danxin_82['senddaytime'] . ':00:00'));
            }
            if ($danxin_49 < $danxin_85) {
                return false;
            }
            $danxin_100 = intval($danxin_82['settledays']) * 3600 * 24;
            $danxin_78 = 'select distinct cg.mid from ' . tablename('sz_yi_bonus_goods') . ' cg left join  ' . tablename('sz_yi_order') . '  o on o.id=cg.orderid and cg.status=0 left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid={$_W['uniacid']} and o.finishtime < {$danxin_50}";
            $danxin_53 = pdo_fetchall($danxin_78);
            $danxin_54 = 0;
            if (empty($danxin_53)) {
                return false;
            }
            $danxin_59 = 0;
            foreach ($danxin_53 as $danxin_69 => $danxin_58) {
                $danxin_67 = $this->getInfo($danxin_58['mid'], array('ok'));
                $danxin_57 = $danxin_67['commission_ok'];
                if ($danxin_57 <= 0) {
                    continue;
                }
                $danxin_31 = true;
                $danxin_55 = 1;
                $danxin_77 = $this->getlevel($danxin_67['openid']);
                $danxin_56 = empty($danxin_77['levelname']) ? '代理' : $danxin_77['levelname'];
                if (empty($danxin_82['paymethod'])) {
                    m('member')->setCredit($danxin_67['openid'], 'credit2', $danxin_57);
                } else {
                    $danxin_46 = m('common')->createNO('bonus_log', 'logno', 'RB');
                    $danxin_45 = m('finance')->pay($danxin_67['openid'], 1, $danxin_57 * 100, $danxin_46, '【' . $danxin_51['name'] . '】' . $danxin_56 . '分红');
                    if (is_error($danxin_45)) {
                        $danxin_55 = 0;
                        $danxin_30 = 1;
                    }
                }
                pdo_insert('sz_yi_bonus_log', array('openid' => $danxin_67['openid'], 'uid' => $danxin_67['uid'], 'money' => $danxin_57, 'uniacid' => $_W['uniacid'], 'paymethod' => $danxin_82['paymethod'], 'sendpay' => $danxin_55, 'status' => 1, 'ctime' => time(), 'send_bonus_sn' => $danxin_85));
                if ($danxin_55 == 1) {
                    $this->sendMessage($danxin_67['openid'], array('nickname' => $danxin_67['nickname'], 'levelname' => $danxin_77['levelname'], 'commission' => $danxin_57, 'type' => empty($danxin_82['paymethod']) ? '余额' : '微信钱包'), TM_BONUS_PAY);
                }
                $danxin_25 = array('status' => 3, 'applytime' => $danxin_85, 'checktime' => $danxin_85, 'paytime' => $danxin_85, 'invalidtime' => $danxin_85);
                pdo_update('sz_yi_bonus_goods', $danxin_25, array('mid' => $danxin_67['id'], 'uniacid' => $_W['uniacid']));
                $danxin_54 += $danxin_67['commission_ok'];
            }
            $danxin_59 += 1;
            if ($danxin_31) {
                $danxin_36 = array('uniacid' => $_W['uniacid'], 'money' => $danxin_54, 'status' => 1, 'ctime' => time(), 'type' => 1, 'paymethod' => $danxin_82['paymethod'], 'sendpay_error' => $danxin_30, 'utime' => $danxin_52, 'send_bonus_sn' => $danxin_85, 'total' => $danxin_59);
                pdo_insert('sz_yi_bonus', $danxin_36);
                return true;
            }
        }

        public function autosendall()
        {
            global $_W, $_GPC;
            $danxin_85 = time();
            $danxin_30 = 0;
            $danxin_70 = 0;
            $danxin_54 = 0;
            $danxin_31 = false;
            $danxin_82 = $this->getSet();
            $danxin_51 = m('common')->getSysset('shop');
            $danxin_100 = intval($danxin_82['settledays']) * 3600 * 24;
            $danxin_52 = strtotime(date('Y-m-d 00:00:00'));
            if (empty($danxin_82['sendmonth'])) {
                $danxin_37 = $danxin_52 - $danxin_100 - 86400;
                $danxin_50 = $danxin_52 - $danxin_100;
                $danxin_49 = strtotime(date('Y-m-d ' . $danxin_82['senddaytime'] . ':00:00'));
            } else if ($danxin_82['sendmonth'] == 1) {
                $danxin_35 = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
                $danxin_37 = $danxin_35 - $danxin_100;
                $danxin_47 = mktime(0, 0, 0, date('m'), 1, date('Y'));
                $danxin_50 = $danxin_47 - $danxin_100;
                $danxin_34 = empty($danxin_82['interval_day']) ? 1 : 1 + $danxin_82['interval_day'];
                $danxin_49 = strtotime(date('Y-' . date('m') . '-' . $danxin_48 . ' ' . $danxin_82['senddaytime'] . ':00:00'));
            }
            if ($danxin_49 < $danxin_85) {
                return false;
            }
            $danxin_32 = pdo_fetchcolumn('select sum(o.price) from ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_order_refund') . " r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid={$_W['uniacid']} and  o.finishtime >={$danxin_37} and o.finishtime < {$danxin_50}");
            $danxin_33 = pdo_fetchall('select * from ' . tablename('sz_yi_bonus_level') . " where uniacid={$_W['uniacid']} and premier=1");
            $danxin_38 = array();
            $danxin_54 = 0;
            foreach ($danxin_33 as $danxin_69 => $danxin_58) {
                $danxin_39 = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_member') . " where uniacid={$_W['uniacid']} and bonuslevel=" . $danxin_58['id']);
                if ($danxin_39 > 0) {
                    $danxin_44 = round($danxin_43 * $danxin_58['pcommission'] / 100, 2);
                    if ($danxin_44 > 0) {
                        $danxin_42 = round($danxin_44 / $danxin_39, 2);
                        if ($danxin_42 > 0) {
                            $danxin_38[$danxin_58['id']] = $danxin_42;
                            $danxin_54 += $danxin_44;
                        }
                    }
                }
            }
            $danxin_40 = pdo_fetchall('select m.*,l.levelname from ' . tablename('sz_yi_member') . ' m left join ' . tablename('sz_yi_bonus_level') . " l on m.bonuslevel=l.id where 1 and l.premier=1 and m.uniacid={$_W['uniacid']}");
            $danxin_59 = 0;
            if (!empty($danxin_82['consume_withdraw'])) {
                foreach ($danxin_40 as $danxin_69 => $danxin_41) {
                    $danxin_61 = pdo_fetchcolumn('select sum(og.realprice) as ordermoney as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.openid=:openid and o.status>=3 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $danxin_41['openid']));
                    if ($danxin_61 < floatval($danxin_82['consume_withdraw'])) {
                        unset($danxin_40[$danxin_69]);
                        continue;
                    }
                }
            }
            if (!empty($_POST)) {
                if ($danxin_54 <= 0) {
                    return false;
                }
                foreach ($danxin_40 as $danxin_69 => $danxin_58) {
                    $danxin_57 = $danxin_38[$danxin_58['bonuslevel']];
                    $danxin_55 = 1;
                    if (empty($danxin_82['paymethod'])) {
                        m('member')->setCredit($danxin_58['openid'], 'credit2', $danxin_57);
                    } else {
                        $danxin_46 = m('common')->createNO('bonus_log', 'logno', 'RB');
                        $danxin_45 = m('finance')->pay($danxin_58['openid'], 1, $danxin_57 * 100, $danxin_46, '【' . $danxin_51['name'] . '】' . $danxin_58['levelname'] . '分红');
                        if (is_error($danxin_45)) {
                            $danxin_55 = 0;
                            $danxin_30 = 1;
                        }
                    }
                    pdo_insert('sz_yi_bonus_log', array('openid' => $danxin_58['openid'], 'uid' => $danxin_58['uid'], 'money' => $danxin_57, 'uniacid' => $_W['uniacid'], 'paymethod' => $danxin_82['paymethod'], 'sendpay' => $danxin_55, 'isglobal' => 1, 'status' => 1, 'ctime' => time(), 'send_bonus_sn' => $danxin_85));
                    if ($danxin_55 == 1) {
                        $this->model->sendMessage($danxin_58['openid'], array('nickname' => $danxin_58['nickname'], 'levelname' => $danxin_58['levelname'], 'commission' => $danxin_57, 'type' => empty($danxin_82['paymethod']) ? '余额' : '微信钱包'), TM_BONUS_GLOBAL_PAY);
                    }
                }
                $danxin_36 = array('uniacid' => $_W['uniacid'], 'money' => $danxin_54, 'status' => 1, 'ctime' => time(), 'sendmonth' => $danxin_82['sendmonth'], 'paymethod' => $danxin_82['paymethod'], 'type' => 1, 'sendpay_error' => $danxin_30, 'isglobal' => 1, 'utime' => $danxin_52, 'send_bonus_sn' => $danxin_85, 'total' => $danxin_59);
                pdo_insert('sz_yi_bonus', $danxin_36);
            }
        }
    }
} ?>