<?php
 if (!defined('IN_IA')){
    exit('Access Denied');
}
class Sz_DYi_Finance{
    public function pay($dephp_0 = '', $dephp_1 = 0, $dephp_2 = 0, $dephp_3 = '', $dephp_4 = ''){
        global $_W, $_GPC;
        if (empty($dephp_0)){
            return error(-1, 'openid不能为空');
        }
        $dephp_5 = m('member') -> getInfo($dephp_0);
        if (empty($dephp_5)){
            return error(-1, '未找到用户');
        }
        if (empty($dephp_1)){
            m('member') -> setCredit($dephp_0, 'credit2', $dephp_2, array(0, $dephp_4));
            return true;
        }else{
            $dephp_6 = uni_setting($_W['uniacid'], array('payment'));
            if (!is_array($dephp_6['payment'])){
                return error(1, '没有设定支付参数');
            }
            $dephp_7 = m('common') -> getSysset('pay');
            $dephp_8 = $dephp_6['payment']['wechat'];
            $dephp_9 = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
            $dephp_10 = pdo_fetch($dephp_9, array(':uniacid' => $_W['uniacid']));
            $dephp_11 = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
            $dephp_12 = array();
            $dephp_12['mch_appid'] = $dephp_10['key'];
            $dephp_12['mchid'] = $dephp_8['mchid'];
            $dephp_12['nonce_str'] = random(32);
            $dephp_12['partner_trade_no'] = empty($dephp_3) ? time() . random(4, true) : $dephp_3;
            $dephp_12['openid'] = $dephp_0;
            $dephp_12['check_name'] = 'NO_CHECK';
            $dephp_12['amount'] = $dephp_2;
            $dephp_12['desc'] = empty($dephp_4) ? '佣金提现' : $dephp_4;
            $dephp_12['spbill_create_ip'] = gethostbyname($_SERVER['HTTP_HOST']);
            ksort($dephp_12, SORT_STRING);
            $dephp_13 = '';
            foreach ($dephp_12 as $dephp_14 => $dephp_15){
                $dephp_13 .= "{$dephp_14}={$dephp_15}&";
            }
            $dephp_13 .= 'key=' . $dephp_8['apikey'];
            $dephp_12['sign'] = strtoupper(md5($dephp_13));
            $dephp_16 = array2xml($dephp_12);
            $dephp_17 = array();
            $dephp_18 = m('common') -> getSec();
            $dephp_19 = iunserializer($dephp_18['sec']);
            if (is_array($dephp_19)){
                if (empty($dephp_19['cert']) || empty($dephp_19['key']) || empty($dephp_19['root'])){
                    message('未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!', '', 'error');
                }
                $dephp_20 = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
                file_put_contents($dephp_20, $dephp_19['cert']);
                $dephp_21 = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
                file_put_contents($dephp_21, $dephp_19['key']);
                $dephp_22 = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
                file_put_contents($dephp_22, $dephp_19['root']);
                $dephp_17['CURLOPT_SSLCERT'] = $dephp_20;
                $dephp_17['CURLOPT_SSLKEY'] = $dephp_21;
                $dephp_17['CURLOPT_CAINFO'] = $dephp_22;
            }else{
                message('未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!', '', 'error');
            }
            load() -> func('communication');
            $dephp_23 = ihttp_request($dephp_11, $dephp_16, $dephp_17);
            @unlink($dephp_20);
            @unlink($dephp_21);
            @unlink($dephp_22);
            if (is_error($dephp_23)){
                return error(-2, $dephp_23['message']);
            }
            if (empty($dephp_23['content'])){
                return error(-2, '网络错误');
            }else{
                $dephp_24 = json_decode(json_encode((array)simplexml_load_string($dephp_23['content'])) , true);
                $dephp_16 = '<?xml version="1.0" encoding="utf-8"?>' . $dephp_23['content'];
                $dephp_25 = new DOMDocument();
                if ($dephp_25 -> loadXML($dephp_16)){
                    $dephp_26 = new DOMXPath($dephp_25);
                    $dephp_27 = $dephp_26 -> evaluate('string(//xml/return_code)');
                    $dephp_28 = $dephp_26 -> evaluate('string(//xml/result_code)');
                    if (strtolower($dephp_27) == 'success' && strtolower($dephp_28) == 'success'){
                        return true;
                    }else{
                        if ($dephp_26 -> evaluate('string(//xml/return_msg)') == $dephp_26 -> evaluate('string(//xml/err_code_des)')){
                            $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)');
                        }else{
                            $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)') . '<br/>' . $dephp_26 -> evaluate('string(//xml/err_code_des)');
                        }
                        return error(-2, $dephp_29);
                    }
                }else{
                    return error(-1, '未知错误');
                }
            }
        }
    }
    public function sendredpack($dephp_0, $dephp_2, $dephp_4 = '', $dephp_30 = '', $dephp_31 = ''){
        global $_W;
        $_W['account']['name'] = pdo_fetchcolumn('SELECT name FROM ' . tablename('uni_account') . 'WHERE uniacid = \'' . $_W['uniacid'] . '\'');
        if (empty($dephp_0)){
            return error(-1, 'openid不能为空');
        }
        $dephp_5 = m('member') -> getInfo($dephp_0);
        if (empty($dephp_5)){
            return error(-1, '未找到用户');
        }
        $dephp_6 = uni_setting($_W['uniacid'], array('payment'));
        if (!is_array($dephp_6['payment'])){
            return error(1, '没有设定支付参数');
        }
        $dephp_7 = m('common') -> getSysset('pay');
        $dephp_8 = $dephp_6['payment']['wechat'];
        $dephp_9 = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
        $dephp_10 = pdo_fetch($dephp_9, array(':uniacid' => $_W['uniacid']));
        $dephp_11 = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        $dephp_32 = array('wxappid' => $dephp_10['key'], 'mch_id' => $dephp_8['mchid'], 'mch_billno' => $dephp_8['mchid'] . date('YmdHis') . rand(1000, 9999), 'client_ip' => gethostbyname($_SERVER['HTTP_HOST']), 're_openid' => $dephp_0, 'total_amount' => $dephp_2, 'total_num' => 1, 'send_name' => $_W['account']['name'], 'wishing' => empty($dephp_4) ? '佣金提现红包' : $dephp_4, 'act_name' => empty($dephp_30) ? '佣金提现红包' : $dephp_30, 'remark' => empty($dephp_31) ? '佣金提现红包' : $dephp_31, 'nonce_str' => $this -> createNonceStr());
        $dephp_33 = $this -> formatQuery($dephp_32, false);
        $dephp_34 = $dephp_33 . '&key=' . $dephp_8['apikey'];
        $dephp_32['sign'] = strtoupper(md5($dephp_34));
        $dephp_35 = array2xml($dephp_32, 1);
        $dephp_18 = m('common') -> getSec();
        $dephp_19 = iunserializer($dephp_18['sec']);
        if (is_array($dephp_19)){
            if (empty($dephp_19['cert']) || empty($dephp_19['key']) || empty($dephp_19['root'])){
                message('未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!', '', 'error');
            }
            $dephp_20 = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
            file_put_contents($dephp_20, $dephp_19['cert']);
            $dephp_21 = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
            file_put_contents($dephp_21, $dephp_19['key']);
            $dephp_22 = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
            file_put_contents($dephp_22, $dephp_19['root']);
            $dephp_17 = array('CURLOPT_SSLCERT' => $dephp_20, 'CURLOPT_SSLKEY' => $dephp_21, 'CURLOPT_CAINFO' => $dephp_22);
        }else{
            message('未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!', '', 'error');
        }
        load() -> func('communication');
        $dephp_23 = ihttp_request($dephp_11, $dephp_35, $dephp_17);
        @unlink($dephp_20);
        @unlink($dephp_21);
        @unlink($dephp_22);
        if (is_error($dephp_23)){
            return error(-2, $dephp_23['message']);
        }
        if (empty($dephp_23['content'])){
            return error(-2, '网络错误');
        }else{
            $dephp_24 = json_decode(json_encode((array)simplexml_load_string($dephp_23['content'])) , true);
            $dephp_16 = '<?xml version="1.0" encoding="utf-8"?>' . $dephp_23['content'];
            $dephp_25 = new DOMDocument();
            if ($dephp_25 -> loadXML($dephp_16)){
                $dephp_26 = new DOMXPath($dephp_25);
                $dephp_27 = $dephp_26 -> evaluate('string(//xml/return_code)');
                $dephp_28 = $dephp_26 -> evaluate('string(//xml/result_code)');
                if (strtolower($dephp_27) == 'success' && strtolower($dephp_28) == 'success'){
                    return true;
                }else{
                    if ($dephp_26 -> evaluate('string(//xml/return_msg)') == $dephp_26 -> evaluate('string(//xml/err_code_des)')){
                        $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)');
                    }else{
                        $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)') . '<br/>' . $dephp_26 -> evaluate('string(//xml/err_code_des)');
                    }
                    return error(-2, $dephp_29);
                }
            }else{
                return error(-1, '未知错误');
            }
        }
    }
    public function refund($dephp_0, $dephp_36, $dephp_37, $dephp_38, $dephp_39 = 0){
        global $_W, $_GPC;
        if (empty($dephp_0)){
            return error(-1, 'openid不能为空');
        }
        $dephp_5 = m('member') -> getInfo($dephp_0);
        if (empty($dephp_5)){
            return error(-1, '未找到用户');
        }
        $dephp_6 = uni_setting($_W['uniacid'], array('payment'));
        if (!is_array($dephp_6['payment'])){
            return error(1, '没有设定支付参数');
        }
        $dephp_7 = m('common') -> getSysset('pay');
        $dephp_8 = $dephp_6['payment']['wechat'];
        $dephp_9 = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
        $dephp_10 = pdo_fetch($dephp_9, array(':uniacid' => $_W['uniacid']));
        $dephp_11 = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $dephp_12 = array();
        $dephp_12['appid'] = $dephp_10['key'];
        $dephp_12['mch_id'] = $dephp_8['mchid'];
        $dephp_12['nonce_str'] = random(8);
        $dephp_12['out_trade_no'] = $dephp_36;
        $dephp_12['out_refund_no'] = $dephp_37;
        $dephp_12['total_fee'] = $dephp_38;
        $dephp_12['refund_fee'] = $dephp_39;
        $dephp_12['op_user_id'] = $dephp_8['mchid'];
        ksort($dephp_12, SORT_STRING);
        $dephp_13 = '';
        foreach ($dephp_12 as $dephp_14 => $dephp_15){
            $dephp_13 .= "{$dephp_14}={$dephp_15}&";
        }
        $dephp_13 .= 'key=' . $dephp_8['apikey'];
        $dephp_12['sign'] = strtoupper(md5($dephp_13));
        $dephp_16 = array2xml($dephp_12);
        $dephp_17 = array();
        $dephp_18 = m('common') -> getSec();
        $dephp_19 = iunserializer($dephp_18['sec']);
        if (is_array($dephp_19)){
            if (empty($dephp_19['cert']) || empty($dephp_19['key']) || empty($dephp_19['root'])){
                message('未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!', '', 'error');
            }
            $dephp_20 = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
            file_put_contents($dephp_20, $dephp_19['cert']);
            $dephp_21 = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
            file_put_contents($dephp_21, $dephp_19['key']);
            $dephp_22 = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
            file_put_contents($dephp_22, $dephp_19['root']);
            $dephp_17['CURLOPT_SSLCERT'] = $dephp_20;
            $dephp_17['CURLOPT_SSLKEY'] = $dephp_21;
            $dephp_17['CURLOPT_CAINFO'] = $dephp_22;
        }else{
            message('未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!', '', 'error');
        }
        load() -> func('communication');
        $dephp_23 = ihttp_request($dephp_11, $dephp_16, $dephp_17);
        @unlink($dephp_20);
        @unlink($dephp_21);
        @unlink($dephp_22);
        if (is_error($dephp_23)){
            return error(-2, $dephp_23['message']);
        }
        if (empty($dephp_23['content'])){
            return error(-2, '网络错误');
        }else{
            $dephp_24 = json_decode(json_encode((array)simplexml_load_string($dephp_23['content'])) , true);
            $dephp_16 = '<?xml version="1.0" encoding="utf-8"?>' . $dephp_23['content'];
            $dephp_25 = new DOMDocument();
            if ($dephp_25 -> loadXML($dephp_16)){
                $dephp_26 = new DOMXPath($dephp_25);
                $dephp_27 = $dephp_26 -> evaluate('string(//xml/return_code)');
                $dephp_28 = $dephp_26 -> evaluate('string(//xml/result_code)');
                if (strtolower($dephp_27) == 'success' && strtolower($dephp_28) == 'success'){
                    return true;
                }else{
                    if ($dephp_26 -> evaluate('string(//xml/return_msg)') == $dephp_26 -> evaluate('string(//xml/err_code_des)')){
                        $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)');
                    }else{
                        $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)') . '<br/>' . $dephp_26 -> evaluate('string(//xml/err_code_des)');
                    }
                    return error(-2, $dephp_29);
                }
            }else{
                return error(-1, '未知错误');
            }
        }
    }
    public function downloadbill($dephp_40, $dephp_41, $dephp_42 = 'ALL'){
        global $_W, $_GPC;
        $dephp_43 = array();
        $dephp_44 = date('Ymd', $dephp_40);
        $dephp_45 = date('Ymd', $dephp_41);
        if ($dephp_44 == $dephp_45){
            $dephp_43 = array($dephp_44);
        }else{
            $dephp_46 = (float)($dephp_41 - $dephp_40) / 86400;
            for ($dephp_47 = 0; $dephp_47 < $dephp_46; $dephp_47++){
                $dephp_43[] = date('Ymd', strtotime($dephp_44 . "+{$dephp_47} day"));
            }
        }
        if (empty($dephp_43)){
            message('对账单日期选择错误!', '', 'error');
        }
        $dephp_6 = uni_setting($_W['uniacid'], array('payment'));
        if (!is_array($dephp_6['payment'])){
            return error(1, '没有设定支付参数');
        }
        $dephp_8 = $dephp_6['payment']['wechat'];
        $dephp_9 = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
        $dephp_10 = pdo_fetch($dephp_9, array(':uniacid' => $_W['uniacid']));
        $dephp_48 = "";
        foreach ($dephp_43 as $dephp_49){
            $dephp_50 = $this -> downloadday($dephp_49, $dephp_10, $dephp_8, $dephp_42);
            if (is_error($dephp_50) || strexists($dephp_50, 'CDATA[FAIL]')){
                continue;
            }
            $dephp_48 .= $dephp_49 . ' 账单

';
            $dephp_48 .= $dephp_50 . '

';
        }
        $dephp_51 = time() . '.csv';
        header('Content-type: application/octet-stream ');
        header('Accept-Ranges: bytes ');
        header("Content-Disposition: attachment; filename={$dephp_51}");
        header('Expires: 0 ');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0 ');
        header('Pragma: public ');
        die($dephp_48);
    }
    private function downloadday($dephp_49, $dephp_10, $dephp_8, $dephp_42){
        $dephp_11 = 'https://api.mch.weixin.qq.com/pay/downloadbill';
        $dephp_12 = array();
        $dephp_12['appid'] = $dephp_10['key'];
        $dephp_12['mch_id'] = $dephp_8['mchid'];
        $dephp_12['nonce_str'] = random(8);
        $dephp_12['device_info'] = 'sz_yi';
        $dephp_12['bill_date'] = $dephp_49;
        $dephp_12['bill_type'] = $dephp_42;
        ksort($dephp_12, SORT_STRING);
        $dephp_13 = '';
        foreach ($dephp_12 as $dephp_14 => $dephp_15){
            $dephp_13 .= "{$dephp_14}={$dephp_15}&";
        }
        $dephp_13 .= 'key=' . $dephp_8['apikey'];
        $dephp_12['sign'] = strtoupper(md5($dephp_13));
        $dephp_16 = array2xml($dephp_12);
        $dephp_17 = array();
        load() -> func('communication');
        $dephp_23 = ihttp_request($dephp_11, $dephp_16, $dephp_17);
        if (strexists($dephp_23['content'], 'No Bill Exist')){
            return error(-2, '未搜索到任何账单');
        }
        if (is_error($dephp_23)){
            return error(-2, $dephp_23['message']);
        }
        if (empty($dephp_23['content'])){
            return error(-2, '网络错误');
        }else{
            return $dephp_23['content'];
        }
    }
    public function closeOrder($dephp_36 = ''){
        global $_W, $_GPC;
        $dephp_6 = uni_setting($_W['uniacid'], array('payment'));
        if (!is_array($dephp_6['payment'])){
            return error(1, '没有设定支付参数');
        }
        $dephp_8 = $dephp_6['payment']['wechat'];
        $dephp_9 = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
        $dephp_10 = pdo_fetch($dephp_9, array(':uniacid' => $_W['uniacid']));
        $dephp_11 = 'https://api.mch.weixin.qq.com/pay/closeorder';
        $dephp_12 = array();
        $dephp_12['appid'] = $dephp_10['key'];
        $dephp_12['mch_id'] = $dephp_8['mchid'];
        $dephp_12['nonce_str'] = random(8);
        $dephp_12['out_trade_no'] = $dephp_36;
        ksort($dephp_12, SORT_STRING);
        $dephp_13 = '';
        foreach ($dephp_12 as $dephp_14 => $dephp_15){
            $dephp_13 .= "{$dephp_14}={$dephp_15}&";
        }
        $dephp_13 .= 'key=' . $dephp_8['apikey'];
        $dephp_12['sign'] = strtoupper(md5($dephp_13));
        $dephp_16 = array2xml($dephp_12);
        load() -> func('communication');
        $dephp_23 = ihttp_post($dephp_11, $dephp_16);
        if (is_error($dephp_23)){
            return error(-2, $dephp_23['message']);
        }
        if (empty($dephp_23['content'])){
            return error(-2, '网络错误');
        }else{
            $dephp_24 = json_decode(json_encode((array)simplexml_load_string($dephp_23['content'])) , true);
            $dephp_16 = '<?xml version="1.0" encoding="utf-8"?>' . $dephp_23['content'];
            $dephp_25 = new DOMDocument();
            if ($dephp_25 -> loadXML($dephp_16)){
                $dephp_26 = new DOMXPath($dephp_25);
                $dephp_27 = $dephp_26 -> evaluate('string(//xml/return_code)');
                $dephp_28 = $dephp_26 -> evaluate('string(//xml/result_code)');
                $dephp_52 = $dephp_26 -> evaluate('string(//xml/trade_state)');
                if (strtolower($dephp_27) == 'success' && strtolower($dephp_28) == 'success' && strtolower($dephp_52) == 'success'){
                    return true;
                }else{
                    if ($dephp_26 -> evaluate('string(//xml/return_msg)') == $dephp_26 -> evaluate('string(//xml/err_code_des)')){
                        $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)');
                    }else{
                        $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)') . '<br/>' . $dephp_26 -> evaluate('string(//xml/err_code_des)');
                    }
                    return error(-2, $dephp_29);
                }
            }else{
                return error(-1, '未知错误');
            }
        }
    }
    public function isWeixinPay($dephp_36){
        global $_W, $_GPC;
        $dephp_6 = uni_setting($_W['uniacid'], array('payment'));
        if (!is_array($dephp_6['payment'])){
            return error(1, '没有设定支付参数');
        }
        $dephp_8 = $dephp_6['payment']['wechat'];
        $dephp_9 = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
        $dephp_10 = pdo_fetch($dephp_9, array(':uniacid' => $_W['uniacid']));
        $dephp_11 = 'https://api.mch.weixin.qq.com/pay/orderquery';
        $dephp_12 = array();
        $dephp_12['appid'] = $dephp_10['key'];
        $dephp_12['mch_id'] = $dephp_8['mchid'];
        $dephp_12['nonce_str'] = random(8);
        $dephp_12['out_trade_no'] = $dephp_36;
        ksort($dephp_12, SORT_STRING);
        $dephp_13 = '';
        foreach ($dephp_12 as $dephp_14 => $dephp_15){
            $dephp_13 .= "{$dephp_14}={$dephp_15}&";
        }
        $dephp_13 .= 'key=' . $dephp_8['apikey'];
        $dephp_12['sign'] = strtoupper(md5($dephp_13));
        $dephp_16 = array2xml($dephp_12);
        load() -> func('communication');
        $dephp_23 = ihttp_post($dephp_11, $dephp_16);
        if (is_error($dephp_23)){
            return error(-2, $dephp_23['message']);
        }
        if (empty($dephp_23['content'])){
            return error(-2, '网络错误');
        }else{
            $dephp_24 = json_decode(json_encode((array)simplexml_load_string($dephp_23['content'])) , true);
            $dephp_16 = '<?xml version="1.0" encoding="utf-8"?>' . $dephp_23['content'];
            $dephp_25 = new DOMDocument();
            if ($dephp_25 -> loadXML($dephp_16)){
                $dephp_26 = new DOMXPath($dephp_25);
                $dephp_27 = $dephp_26 -> evaluate('string(//xml/return_code)');
                $dephp_28 = $dephp_26 -> evaluate('string(//xml/result_code)');
                $dephp_52 = $dephp_26 -> evaluate('string(//xml/trade_state)');
                if (strtolower($dephp_27) == 'success' && strtolower($dephp_28) == 'success' && strtolower($dephp_52) == 'success'){
                    return true;
                }else{
                    if ($dephp_26 -> evaluate('string(//xml/return_msg)') == $dephp_26 -> evaluate('string(//xml/err_code_des)')){
                        $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)');
                    }else{
                        $dephp_29 = $dephp_26 -> evaluate('string(//xml/return_msg)') . '<br/>' . $dephp_26 -> evaluate('string(//xml/err_code_des)');
                    }
                    return error(-2, $dephp_29);
                }
            }else{
                return error(-1, '未知错误');
            }
        }
    }
    function isAlipayNotify($dephp_53){
        global $_W;
        $dephp_54 = trim($dephp_53['notify_id']);
        $dephp_55 = trim($dephp_53['sign']);
        if (empty($dephp_54) || empty($dephp_55)){
            return false;
        }
        $dephp_6 = uni_setting($_W['uniacid'], array('payment'));
        if (!is_array($dephp_6['payment'])){
            return false;
        }
        $dephp_56 = $dephp_6['payment']['alipay'];
        $dephp_57 = array();
        foreach ($dephp_53 as $dephp_58 => $dephp_59){
            if (in_array($dephp_58, array('sign', 'sign_type', 'i', 'm', 'openid', 'c', 'do', 'p', 'op')) || empty($dephp_59)){
                continue;
            }
            $dephp_57[$dephp_58] = $dephp_59;
        }
        ksort($dephp_57, SORT_STRING);
        $dephp_13 = '';
        foreach ($dephp_57 as $dephp_14 => $dephp_15){
            $dephp_13 .= "{$dephp_14}={$dephp_15}&";
        }
        $dephp_13 = rtrim($dephp_13, '&') . $dephp_56['secret'];
        $dephp_60 = strtolower(md5($dephp_13));
        if ($dephp_55 != $dephp_60){
            return false;
        }
        $dephp_11 = "https://mapi.alipay.com/gateway.do?service=notify_verify&partner={$dephp_56['partner']}&notify_id={$dephp_54}";
        $dephp_23 = @file_get_contents($dephp_11);
        return preg_match('/true$/i', $dephp_23);
    }
    protected function createNonceStr(){
        $dephp_61 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $dephp_62 = '';
        for ($dephp_63 = 0; $dephp_63 < 32; $dephp_63++){
            $dephp_62 .= substr($dephp_61, mt_rand(0, strlen($dephp_61) - 1), 1);
        }
        return $dephp_62;
    }
    protected function formatQuery($dephp_64, $dephp_65 = false){
        if (!is_array($dephp_64) || empty($dephp_64)){
            return;
        }
        ksort($dephp_64);
        $dephp_57 = array();
        foreach ($dephp_64 as $dephp_58 => $dephp_66){
            if ($dephp_58 != 'sign' && $dephp_66 != null && $dephp_66 != 'null'){
                if ($dephp_65){
                    $dephp_66 = urlencode($dephp_66);
                }
                $dephp_57[] = $dephp_58 . '=' . $dephp_66;
            }
        }
        return implode('&', $dephp_57);
    }
}
