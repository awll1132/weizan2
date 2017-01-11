<?php
defined('IN_IA') or exit('Access Denied');
include("../addons/j_money/jetsum_function.php");
class J_moneyModuleSite extends WeModuleSite
{
    public function doMobileApp()
    {
        global $_GPC, $_W;
        if (!$_W['isajax'])
            die(json_encode(array(
                'success' => false,
                'msg' => "错误！"
            )));
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $cfg       = $this->module['config'];
        if ($operation == "login") {
            $userid = $_POST["userid"];
            $pwd    = $_POST["pwd"];
            $openid = $_POST["openid"];
            if ($openid) {
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and openid=:b limit 1", array(
                    ":b" => $openid
                ));
                if (!$item)
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "用户不存在或者密码错误"
                    )));
                if (!$item['status'])
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "该用户还没有审核，请联系管理员"
                    )));
                pdo_update("j_money_user", array(
                    'lasttime' => TIMESTAMP
                ), array(
                    'id' => $item['id']
                ));
                die(json_encode(array(
                    "success" => true,
                    "islogin" => $item['id']
                )));
            } else {
                if (!$userid || !$pwd)
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "用户名或者密码错误"
                    )));
                $pwd  = md5($_GPC['pwd']);
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and useracount=:a and password=:b limit 1", array(
                    ":a" => $userid,
                    ":b" => $pwd
                ));
                if (!$item)
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "用户不存在或者密码错误"
                    )));
                if (!$item['status'])
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "该用户还没有审核，请联系管理员"
                    )));
                pdo_update("j_money_user", array(
                    'lasttime' => TIMESTAMP
                ), array(
                    'id' => $item['id']
                ));
                die(json_encode(array(
                    "success" => true,
                    "islogin" => $item['id']
                )));
            }
        } elseif ($operation == "scanwechatpay") {
            $qrcode     = $_GPC["qrcode"];
            $fee        = $_GPC["fee"] ? $_GPC["fee"] : 1;
            $deviceinfo = intval($_GPC["userid"]);
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:a and status=1", array(
                ":a" => $deviceinfo
            ));
            if (!$user)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            load()->func('communication');
            $fee        = intval($fee * 100);
            $totalfee   = intval($fee);
            $coupon_fee = 0;
            $marketid   = 0;
            $marketing  = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:d and starttime<=:a and endtime>=:b and status=1 and condition_fee<=:c order by displayorder asc ,id desc limit 1", array(
                ":a" => TIMESTAMP,
                ":b" => TIMESTAMP,
                ":c" => $fee,
                ":d" => $user['pcate']
            ));
            if ($marketing && $marketing['favorabletype'] == 1) {
                if ($marketing['hour']) {
                    $hourary = strpos($marketing['hour'], ",") ? explode(",", $marketing['hour']) : array(
                        $marketing['hour']
                    );
                    if (!in_array(date("H"), $hourary))
                        goto pay;
                }
                if ($marketing['num']) {
                    $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a and createdate =:b ", array(
                        ":a" => $marketing['id'],
                        ":b" => date('Y-m-d')
                    ));
                    if ($marketing['isallnum']) {
                        $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a ", array(
                            ":a" => $marketing['id']
                        ));
                    }
                    if ($numuser >= $marketing['num'])
                        goto pay;
                }
                $favorable = $marketing['favorable'];
                if (strpos($favorable, "|#满减#|")) {
                    $temp     = str_replace("[|#满减#|", "", $favorable);
                    $temp     = str_replace("]", "", $temp);
                    $favorAry = explode("-", $temp);
                    if (count($favorAry) > 1) {
                        $favorAry1 = strpos($favorAry[0], "%") ? intval(str_replace("%", "", $favorAry[0]) * 0.01 * $fee) : $favorAry[0] * 100;
                        $favorAry2 = strpos($favorAry[1], "%") ? intval(str_replace("%", "", $favorAry[1]) * 0.01 * $fee) : $favorAry[1] * 100;
                        if ($favorAry1 >= $favorAry2) {
                            $coupon_fee = $favorAry1;
                        } else {
                            $coupon_fee = mt_rand($favorAry1, $favorAry2);
                        }
                        if ($marketing['isint']) {
                            $coupon_fee = intval(sprintf('%.2f', ($coupon_fee * 0.01))) * 100;
                        }
                        if (count($favorAry) == 3) {
                            if ($coupon_fee > $favorAry[2] * 100)
                                $coupon_fee = $favorAry[2] * 100;
                        }
                        if ($coupon_fee >= $fee)
                            $coupon_fee = 0;
                        $fee      = $fee - $coupon_fee;
                        $marketid = $marketing['id'];
                    }
                }
            }
pay:
            $shop        = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['pcate']
            ));
            $payParama   = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "pay_mchid" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "pay_signkey" => $shop['pay_signkey'] ? $shop['pay_signkey'] : $cfg['pay_signkey'],
                "outTradeNo" => strval(date("YmdHis")),
                "pay_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "sub_appid" => $shop['sub_appid'] ? $shop['sub_appid'] : $cfg['sub_appid'],
                "sub_mch_id" => $shop['sub_mch_id'] ? $shop['sub_mch_id'] : $cfg['sub_mch_id']
            );
            $pay_signkey = trim($shop['pay_signkey']) ? trim($shop['pay_signkey']) : trim($cfg['pay_signkey']);
            $pageparama  = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "mch_id" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "device_info" => $deviceinfo,
                "nonce_str" => getNonceStr(),
                "body" => "微支付收款",
                "detail" => "微支付收款",
                "attach" => "-",
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $fee,
                "fee_type" => "CNY",
                "spbill_create_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "goods_tag" => "000001",
                "auth_code" => $qrcode
            );
            if ($payParama['sub_appid'])
                $pageparama['sub_appid'] = $payParama['sub_appid'];
            if ($payParama['sub_mch_id'])
                $pageparama['sub_mch_id'] = $payParama['sub_mch_id'];
            $data = array(
                "weid" => $_W['uniacid'],
                "userid" => $deviceinfo,
                "groupid" => $user['pcate'],
                "attach" => $_GPC['attach'] ? $_GPC['attach'] : 'PC',
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $totalfee,
                "coupon_fee" => $coupon_fee,
                "cash_fee" => $fee,
                "marketing" => $marketid,
                "createtime" => TIMESTAMP,
                "createdate" => date('Y-m-d'),
                "old_trade_no" => $_GPC['old_trade_no']
            );
            if ($marketid)
                $data['marketing_log'] = $marketing['description'];
            pdo_insert("j_money_trade", $data);
            $sign               = MakeSign($pageparama, $pay_signkey);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/micropay", 10);
            $result             = FromXml($response);
            if ($result['return_code'] != 'SUCCESS') {
                pdo_update("j_money_trade", array(
                    "log" => "收款失败：" . $result['return_msg']
                ), array(
                    "out_trade_no" => $payParama['outTradeNo']
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['return_msg']
                )));
            }
            $insertInfo = array(
                "openid" => $result['openid'],
                "is_subscribe" => $result['is_subscribe'] == "Y" ? 1 : 0,
                "sub_openid" => isset($result['sub_openid']) ? $result['sub_openid'] : "",
                "sub_is_subscribe" => isset($result['sub_is_subscribe']) && $result['sub_is_subscribe'] == "Y" ? 1 : 0,
                "trade_type" => $result['trade_type'],
                "bank_type" => $result['bank_type'],
                "fee_type" => $result['CNY'],
                "transaction_id" => $result['transaction_id'],
                "time_end" => strtotime($result['time_end'])
            );
            if (!intval($data['total_fee']))
                $insertInfo["total_fee"] = intval($result['total_fee']);
            if (!intval($data['coupon_fee']))
                $insertInfo["coupon_fee"] = intval($result['coupon_fee']);
            if (intval($result['cash_fee']))
                $insertInfo["cash_fee"] = intval($result['cash_fee']);
            if ($result['result_code'] == 'SUCCESS') {
                $insertInfo['isconfirm'] = 1;
                $insertInfo['status']    = 1;
            }
            pdo_update("j_money_trade", $insertInfo, array(
                "out_trade_no" => $payParama['outTradeNo']
            ));
            if (!isset($result['out_trade_no']))
                $result['out_trade_no'] = $payParama['outTradeNo'];
            die(json_encode(array(
                "success" => true,
                "items" => $result
            )));
        } elseif ($operation == "qrcodewechat") {
            $fee        = $_GPC["fee"];
            $userOpenid = $_GPC["userid"];
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $userOpenid
            ));
            if (!$user)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            load()->func('communication');
            $fee        = intval($fee * 100);
            $totalfee   = intval($fee);
            $coupon_fee = 0;
            $marketid   = 0;
            $marketing  = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:d and starttime<=:a and endtime>=:b and status=1 and condition_fee<=:c order by displayorder asc ,id desc limit 1", array(
                ":a" => TIMESTAMP,
                ":b" => TIMESTAMP,
                ":c" => $fee,
                ":d" => $user['pcate']
            ));
            if ($marketing && $marketing['favorabletype'] == 1) {
                if ($marketing['hour']) {
                    $hourary = strpos($marketing['hour'], ",") ? explode(",", $marketing['hour']) : array(
                        $marketing['hour']
                    );
                    if (!in_array(date("H"), $hourary))
                        goto appwechatqrcode;
                }
                if ($marketing['num']) {
                    $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status=1 and marketing=:a and createdate =:b ", array(
                        ":a" => $marketing['id'],
                        ":b" => date('Y-m-d')
                    ));
                    if ($marketing['isallnum']) {
                        $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a ", array(
                            ":a" => $marketing['id']
                        ));
                    }
                    if ($numuser >= $marketing['num'])
                        goto appwechatqrcode;
                }
                $favorable = $marketing['favorable'];
                if (strpos($favorable, "|#满减#|")) {
                    $temp     = str_replace("[|#满减#|", "", $favorable);
                    $temp     = str_replace("]", "", $temp);
                    $favorAry = explode("-", $temp);
                    if (count($favorAry) > 1) {
                        $favorAry1 = strpos($favorAry[0], "%") ? intval(str_replace("%", "", $favorAry[0]) * 0.01 * $fee) : $favorAry[0] * 100;
                        $favorAry2 = strpos($favorAry[1], "%") ? intval(str_replace("%", "", $favorAry[1]) * 0.01 * $fee) : $favorAry[1] * 100;
                        if ($favorAry1 >= $favorAry2) {
                            $coupon_fee = $favorAry1;
                        } else {
                            $coupon_fee = mt_rand($favorAry1, $favorAry2);
                        }
                        if ($marketing['isint']) {
                            $coupon_fee = intval(sprintf('%.2f', ($coupon_fee * 0.01))) * 100;
                        }
                        if (count($favorAry) == 3) {
                            if ($coupon_fee > $favorAry[2] * 100)
                                $coupon_fee = $favorAry[2] * 100;
                        }
                        if ($coupon_fee >= $fee)
                            $coupon_fee = 0;
                        $fee      = $fee - $coupon_fee;
                        $marketid = $marketing['id'];
                    }
                }
            }
appwechatqrcode:
            $shop       = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['pcate']
            ));
            $payParama  = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "pay_mchid" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "pay_signkey" => $shop['pay_signkey'] ? $shop['pay_signkey'] : $cfg['pay_signkey'],
                "outTradeNo" => strval(date("YmdHis")),
                "pay_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "sub_appid" => $shop['sub_appid'] ? $shop['sub_appid'] : $cfg['sub_appid'],
                "sub_mch_id" => $shop['sub_mch_id'] ? $shop['sub_mch_id'] : $cfg['sub_mch_id']
            );
            $pageparama = array(
                "appid" => $payParama['appid'],
                "mch_id" => $payParama['pay_mchid'],
                "device_info" => "WEB",
                "nonce_str" => getNonceStr(),
                "body" => "微支付收款",
                "detail" => "微支付收款",
                "attach" => "-",
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $fee,
                "fee_type" => "CNY",
                "spbill_create_ip" => $payParama['spbill_create_ip'],
                "time_start" => date("YmdHis"),
                "time_expire" => date("YmdHis", TIMESTAMP + 600),
                "notify_url" => $cfg['notify_url'],
                "trade_type" => "NATIVE",
                "product_id" => "01"
            );
            if ($payParama['sub_appid'])
                $pageparama['sub_appid'] = $payParama['sub_appid'];
            if ($payParama['sub_mch_id'])
                $pageparama['sub_mch_id'] = $payParama['sub_mch_id'];
            $data = array(
                "weid" => $_W['uniacid'],
                "userid" => $user['id'],
                "groupid" => $user['pcate'],
                "attach" => "扫码收款",
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $totalfee,
                "coupon_fee" => $coupon_fee,
                "cash_fee" => $fee,
                "createtime" => TIMESTAMP,
                "createdate" => date('Y-m-d'),
                "marketing" => $marketid,
                "old_trade_no" => $_GPC['old_trade_no']
            );
            if ($marketid)
                $data['marketing_log'] = $marketing['description'];
            pdo_insert("j_money_trade", $data);
            $sign               = MakeSign($pageparama, $payParama['pay_signkey']);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/unifiedorder", 10);
            $result             = FromXml($response);
            if ($result['return_code'] != 'SUCCESS') {
                pdo_update("j_money_trade", array(
                    "log" => "收款失败：" . $result['return_msg']
                ), array(
                    "out_trade_no" => $payParama['outTradeNo']
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['return_msg']
                )));
            }
            if (isset($result['code_url'])) {
                include('../addons/j_money/phpqrcode.php');
                load()->func('file');
                $dir_url = "../attachment/j_money/" . $_W['uniacid'] . "/";
                mkdirs($dir_url);
                $codename = $userOpenid . "_.png";
                $value    = $result['code_url'];
                if (file_exists($dir_url . $codename))
                    @unlink($dir_url . $codename);
                QRcode::png($value, $dir_url . $codename, "L", 10);
                die(json_encode(array(
                    "success" => true,
                    "qrcode" => $codename . "?v=" . TIMESTAMP,
                    "orderid" => $payParama['outTradeNo']
                )));
            }
            die(json_encode(array(
                "success" => false,
                "msg" => "生成失败"
            )));
        } elseif ($operation == "qrcodealipay") {
            $fee        = $_GPC["fee"];
            $userOpenid = $_GPC["userid"];
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:id ", array(
                ":id" => $userOpenid
            ));
            if (!$user)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            $fee        = intval($fee * 100);
            $totalfee   = intval($fee);
            $coupon_fee = 0;
            $marketid   = 0;
            $marketing  = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:d and starttime<=:a and endtime>=:b and status=1 and favorabletype=1 and condition_fee<=:c order by displayorder asc ,id desc limit 1", array(
                ":a" => TIMESTAMP,
                ":b" => TIMESTAMP,
                ":c" => $fee,
                ":d" => $user['pcate']
            ));
            if ($marketing) {
                if ($marketing['hour']) {
                    $hourary = strpos($marketing['hour'], ",") ? explode(",", $marketing['hour']) : array(
                        $marketing['hour']
                    );
                    if (!in_array(date("H"), $hourary))
                        goto alipay2;
                }
                if ($marketing['num']) {
                    $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a and createdate =:b ", array(
                        ":a" => $marketing['id'],
                        ":b" => date('Y-m-d')
                    ));
                    if ($marketing['isallnum']) {
                        $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a ", array(
                            ":a" => $marketing['id']
                        ));
                    }
                    if ($numuser >= $marketing['num'])
                        goto alipay2;
                }
                $favorable = $marketing['favorable'];
                if (strpos($favorable, "|#满减#|")) {
                    $temp     = str_replace("[|#满减#|", "", $favorable);
                    $temp     = str_replace("]", "", $temp);
                    $favorAry = explode("-", $temp);
                    if (count($favorAry) > 1) {
                        $favorAry1 = strpos($favorAry[0], "%") ? intval(str_replace("%", "", $favorAry[0]) * 0.01 * $fee) : $favorAry[0] * 100;
                        $favorAry2 = strpos($favorAry[1], "%") ? intval(str_replace("%", "", $favorAry[1]) * 0.01 * $fee) : $favorAry[1] * 100;
                        if ($favorAry1 >= $favorAry2) {
                            $coupon_fee = $favorAry1;
                        } else {
                            $coupon_fee = mt_rand($favorAry1, $favorAry2);
                        }
                        if ($marketing['isint']) {
                            $coupon_fee = intval(sprintf('%.2f', ($coupon_fee * 0.01))) * 100;
                        }
                        if (count($favorAry) == 3) {
                            if ($coupon_fee > $favorAry[2] * 100)
                                $coupon_fee = $favorAry[2] * 100;
                        }
                        if ($coupon_fee >= $fee)
                            $coupon_fee = 0;
                        $fee      = $fee - $coupon_fee;
                        $marketid = $marketing['id'];
                    }
                }
            }
alipay2:
            $shop         = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['pcate']
            ));
            $payParama    = array(
                "app_id" => $shop['app_id'] ? $shop['app_id'] : $cfg['app_id'],
                "outTradeNo" => strval(date("YmdHis")),
                "pemurl" => $cfg['pemurl'],
                "merchant_private_key_file" => $cfg['merchant_private_key_file']
            );
            $total_amount = $fee;
            $subject      = "支付宝收款";
            $data         = array(
                "weid" => $_W['uniacid'],
                "userid" => $user['id'],
                "attach" => "扫码收款",
                "groupid" => $user['pcate'],
                "paytype" => 1,
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $totalfee,
                "coupon_fee" => $coupon_fee,
                "cash_fee" => $fee,
                "createtime" => TIMESTAMP,
                "createdate" => date('Y-m-d'),
                "marketing" => $marketid,
                "old_trade_no" => $_GPC['old_trade_no']
            );
            if ($marketid)
                $data['marketing_log'] = $marketing['description'];
            pdo_insert("j_money_trade", $data);
            $postfee = sprintf('%.2f', ($fee * 0.01));
            require_once '../addons/j_money/F2fpay.php';
            $f2fpay   = new F2fpay();
            $response = $f2fpay->qrpay($payParama['outTradeNo'], $postfee, $subject, $payParama);
            $temp     = (array) $response;
            $result   = (array) $temp['alipay_trade_precreate_response'];
            if ($result['code'] == "10000") {
                if (isset($result['qr_code'])) {
                    include('../addons/j_money/phpqrcode.php');
                    load()->func('file');
                    $dir_url = "../attachment/j_money/" . $_W['uniacid'] . "/";
                    mkdirs($dir_url);
                    $codename = $userOpenid . "_.png";
                    $value    = $result['qr_code'];
                    if (file_exists($dir_url . $codename))
                        @unlink($dir_url . $codename);
                    QRcode::png($value, $dir_url . $codename, "L", 10);
                    die(json_encode(array(
                        "success" => true,
                        "qrcode" => $codename . "?v=" . TIMESTAMP,
                        "orderid" => $payParama['outTradeNo']
                    )));
                }
                die(json_encode(array(
                    "success" => false,
                    "msg" => "生成失败"
                )));
            } else {
                pdo_update("j_money_trade", array(
                    "log" => "收款码失败：" . $result['sub_msg']
                ), array(
                    "out_trade_no" => $payParama['outTradeNo']
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['sub_msg']
                )));
            }
            die();
        } elseif ($operation == "checwechatkpay") {
            load()->func('communication');
            $orderid    = $_GPC["orderid"];
            $trade      = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            $shop       = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $trade['groupid']
            ));
            $payParama  = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "pay_mchid" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "pay_signkey" => $shop['pay_signkey'] ? $shop['pay_signkey'] : $cfg['pay_signkey'],
                "outTradeNo" => strval(date("YmdHis")),
                "pay_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "sub_appid" => $shop['sub_appid'] ? $shop['sub_appid'] : $cfg['sub_appid'],
                "sub_mch_id" => $shop['sub_mch_id'] ? $shop['sub_mch_id'] : $cfg['sub_mch_id']
            );
            $pageparama = array(
                "appid" => $payParama['appid'],
                "mch_id" => strval($payParama['pay_mchid']),
                "out_trade_no" => $orderid,
                "nonce_str" => getNonceStr()
            );
            if ($payParama['sub_appid'])
                $pageparama['sub_appid'] = $payParama['sub_appid'];
            if ($payParama['sub_mch_id'])
                $pageparama['sub_mch_id'] = $payParama['sub_mch_id'];
            $sign               = MakeSign($pageparama, $payParama['pay_signkey']);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/orderquery", 10);
            $result             = FromXml($response);
            if ($result['trade_state'] == 'SUCCESS' && $trade['status'] == 0) {
                $insertInfo = array(
                    "openid" => $result['openid'],
                    "is_subscribe" => $result['is_subscribe'] == "Y" ? 1 : 0,
                    "sub_openid" => isset($result['sub_openid']) ? $result['sub_openid'] : "",
                    "sub_is_subscribe" => isset($result['sub_is_subscribe']) && $result['sub_is_subscribe'] == "Y" ? 1 : 0,
                    "trade_type" => $result['trade_type'],
                    "bank_type" => $result['bank_type'],
                    "fee_type" => $result['CNY'],
                    "transaction_id" => $result['transaction_id'],
                    "time_end" => strtotime($result['time_end']),
                    "isconfirm" => 1,
                    "status" => 1
                );
                pdo_update("j_money_trade", $insertInfo, array(
                    "id" => $trade['id']
                ));
                die(json_encode(array(
                    "success" => true
                )));
            }
            die(json_encode(array(
                "success" => false,
                "msg" => $result
            )));
        } elseif ($operation == "checkalipay") {
            load()->func('communication');
            $orderid   = $_GPC["orderid"];
            $trade     = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            $shop      = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $trade['groupid']
            ));
            $payParama = array(
                "app_id" => $shop['app_id'] ? $shop['app_id'] : $cfg['app_id'],
                "outTradeNo" => $orderid,
                "pemurl" => $cfg['pemurl'],
                "merchant_private_key_file" => $cfg['merchant_private_key_file']
            );
            require_once '../addons/j_money/F2fpay.php';
            $cfg      = $this->module['config'];
            $f2fpay   = new F2fpay();
            $response = $f2fpay->query($orderid, $payParama);
            $results  = @json_decode(json_encode($response), true);
            $result   = $results['alipay_trade_query_response'];
            if ($result['code'] == 10003) {
                pdo_update("j_money_trade", array(
                    "log" => "等待客户支付密码"
                ), array(
                    "out_trade_no" => $orderid
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => "等待客户支付密码"
                )));
            } elseif ($result['code'] == 10000) {
                if ($result['trade_status'] == "TRADE_SUCCESS") {
                    $insertdata = array(
                        "status" => 1,
                        "isconfirm" => 1,
                        "transaction_id" => $result['trade_no'],
                        "time_end" => strtotime($result['gmt_payment'])
                    );
                    pdo_update("j_money_trade", $insertdata, array(
                        "out_trade_no" => $orderid
                    ));
                    $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a", array(
                        ":a" => $orderid
                    ));
                    die(json_encode(array(
                        "success" => true,
                        "items" => $trade
                    )));
                } else {
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "等待客户付款"
                    )));
                }
            } else {
                pdo_update("j_money_trade", array(
                    "log" => "收款失败：" . $result['sub_msg']
                ), array(
                    "out_trade_no" => $orderid
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['sub_msg']
                )));
            }
            die();
        } elseif ($operation == "getorderdetail") {
            $orderid = $_GPC["orderid"];
            $trade   = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            die(json_encode(array(
                "success" => true,
                "items" => $trade
            )));
        } elseif ($operation == "mobilemore") {
            $userOpenid = intval($_GPC['userid']);
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:id ", array(
                ":id" => $userOpenid
            ));
            $date       = $_GPC['date'] ? $_GPC['date'] : date("Y-m-d");
            $date       = date("Y-m-d", strtotime($date));
            $pindex     = intval($_GPC['page']) ? intval($_GPC['page']) - 1 : 0;
            $psize      = 10;
            $start      = $pindex * $psize;
            $list       = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createdate=:b and attach<>'-' and attach<>'PC' order by id desc LIMIT " . $start . "," . $psize, array(
                ":a" => $user['id'],
                ":b" => $date
            ));
            if (count($list)) {
                die(json_encode(array(
                    "success" => true,
                    "item" => $list
                )));
            } else {
                die(json_encode(array(
                    "success" => false,
                    "msg" => "没有记录"
                )));
            }
        }
    }
    public function doMobileAjax()
    {
        global $_GPC, $_W;
        if (!$_W['isajax'])
            die(json_encode(array(
                'success' => false,
                'msg' => "错误！"
            )));
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $cfg       = $this->module['config'];
        if ($operation == "login") {
            $userid = $_GPC['userid'];
            $pwd    = $_GPC['pwd'];
            if (!$userid || !$pwd)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "用户名或者密码错误"
                )));
            $pwd  = md5($_GPC['pwd']);
            $item = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and useracount=:a and password=:b limit 1", array(
                ":a" => $userid,
                ":b" => $pwd
            ));
            if (!$item)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "用户不存在或者密码错误"
                )));
            if (!$item['status'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "该用户还没有审核，请联系管理员"
                )));
            isetcookie('islogin', $item['id'], 3600 * $cfg['cookiehold']);
            isetcookie('siteuniacid', $_W['uniacid'], 3600 * $cfg['cookiehold']);
            pdo_update("j_money_user", array(
                'lasttime' => TIMESTAMP
            ), array(
                'id' => $item['id']
            ));
            die(json_encode(array(
                "success" => true
            )));
        }
        if ($operation == "logout") {
            isetcookie('islogin', '', -1);
            isetcookie('siteuniacid', '', -1);
            die(json_encode(array(
                "success" => true
            )));
        }
        if ($operation == "checklogin") {
            $qrcode = $_GPC['qrcodes'];
            if (!$qrcode) {
                $qrcode = TIMESTAMP;
                $data   = array(
                    "weid" => $_W['uniacid'],
                    "sncode" => $qrcode,
                    "createtime" => TIMESTAMP
                );
                pdo_insert("j_money_qrlogin", $data);
                isetcookie('qrcodes', $qrcode, 300);
                die(json_encode(array(
                    "success" => false,
                    "msg" => "二维码过期",
                    "reload" => true
                )));
            }
            $item = pdo_fetch("SELECT * FROM " . tablename('j_money_qrlogin') . " WHERE weid='{$_W['uniacid']}' and sncode=:a ", array(
                ":a" => $qrcode
            ));
            if (!$item)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "登陆方式错误",
                    "reload" => true
                )));
            if ($item['status'] == 0) {
                die(json_encode(array(
                    "success" => false,
                    "msg" => "",
                    "reload" => false
                )));
            }
            $user = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $item['userid']
            ));
            isetcookie('islogin', $user['id'], 3600 * $cfg['cookiehold']);
            isetcookie('siteuniacid', $_W['uniacid'], 3600 * $cfg['cookiehold']);
            pdo_update("j_money_user", array(
                'lasttime' => TIMESTAMP
            ), array(
                'id' => $user['id']
            ));
            die(json_encode(array(
                "success" => true
            )));
        }
        if ($operation == "paywechat") {
            $qrcode     = $_GPC["qrcode"];
            $fee        = $_GPC["fee"] ? $_GPC["fee"] : 1;
            $deviceinfo = intval($_GPC["userid"]);
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:a and status=1", array(
                ":a" => $deviceinfo
            ));
            if (!$user)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            load()->func('communication');
            $fee        = intval($fee * 100);
            $totalfee   = intval($fee);
            $coupon_fee = 0;
            $marketid   = 0;
            $marketing  = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:d and starttime<=:a and endtime>=:b and status=1 and condition_fee<=:c order by displayorder asc ,id desc limit 1", array(
                ":a" => TIMESTAMP,
                ":b" => TIMESTAMP,
                ":c" => $fee,
                ":d" => $user['pcate']
            ));
            if ($marketing && $marketing['favorabletype'] == 1) {
                if ($marketing['hour']) {
                    $hourary = strpos($marketing['hour'], ",") ? explode(",", $marketing['hour']) : array(
                        $marketing['hour']
                    );
                    if (!in_array(date("H"), $hourary))
                        goto pay;
                }
                if ($marketing['num']) {
                    $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a and createdate =:b ", array(
                        ":a" => $marketing['id'],
                        ":b" => date('Y-m-d')
                    ));
                    if ($marketing['isallnum']) {
                        $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a ", array(
                            ":a" => $marketing['id']
                        ));
                    }
                    if ($numuser >= $marketing['num'])
                        goto pay;
                }
                $favorable = $marketing['favorable'];
                if (strpos($favorable, "|#满减#|")) {
                    $temp     = str_replace("[|#满减#|", "", $favorable);
                    $temp     = str_replace("]", "", $temp);
                    $favorAry = explode("-", $temp);
                    if (count($favorAry) > 1) {
                        $favorAry1 = strpos($favorAry[0], "%") ? intval(str_replace("%", "", $favorAry[0]) * 0.01 * $fee) : $favorAry[0] * 100;
                        $favorAry2 = strpos($favorAry[1], "%") ? intval(str_replace("%", "", $favorAry[1]) * 0.01 * $fee) : $favorAry[1] * 100;
                        if ($favorAry1 >= $favorAry2) {
                            $coupon_fee = $favorAry1;
                        } else {
                            $coupon_fee = mt_rand($favorAry1, $favorAry2);
                        }
                        if ($marketing['isint']) {
                            $coupon_fee = intval(sprintf('%.2f', ($coupon_fee * 0.01))) * 100;
                        }
                        if (count($favorAry) == 3) {
                            if ($coupon_fee > $favorAry[2] * 100)
                                $coupon_fee = $favorAry[2] * 100;
                        }
                        if ($coupon_fee >= $fee)
                            $coupon_fee = 0;
                        $fee      = $fee - $coupon_fee;
                        $marketid = $marketing['id'];
                    }
                }
            }
pay:
            $shop        = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['pcate']
            ));
            $payParama   = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "pay_mchid" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "pay_signkey" => $shop['pay_signkey'] ? $shop['pay_signkey'] : $cfg['pay_signkey'],
                "outTradeNo" => strval(date("YmdHis")),
                "pay_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "sub_appid" => $shop['sub_appid'] ? $shop['sub_appid'] : $cfg['sub_appid'],
                "sub_mch_id" => $shop['sub_mch_id'] ? $shop['sub_mch_id'] : $cfg['sub_mch_id']
            );
            $pay_signkey = trim($shop['pay_signkey']) ? trim($shop['pay_signkey']) : trim($cfg['pay_signkey']);
            $pageparama  = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "mch_id" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "device_info" => $deviceinfo,
                "nonce_str" => getNonceStr(),
                "body" => "微支付收款",
                "detail" => "微支付收款",
                "attach" => "-",
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $fee,
                "fee_type" => "CNY",
                "spbill_create_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "goods_tag" => "000001",
                "auth_code" => $qrcode
            );
            if ($payParama['sub_appid'])
                $pageparama['sub_appid'] = $payParama['sub_appid'];
            if ($payParama['sub_mch_id'])
                $pageparama['sub_mch_id'] = $payParama['sub_mch_id'];
            $data = array(
                "weid" => $_W['uniacid'],
                "userid" => $deviceinfo,
                "groupid" => $user['pcate'],
                "attach" => $_GPC['attach'] ? $_GPC['attach'] : 'PC',
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $totalfee,
                "coupon_fee" => $coupon_fee,
                "cash_fee" => $fee,
                "marketing" => $marketid,
                "createtime" => TIMESTAMP,
                "createdate" => date('Y-m-d'),
                "old_trade_no" => $_GPC['old_trade_no']
            );
            if ($marketid)
                $data['marketing_log'] = $marketing['description'];
            pdo_insert("j_money_trade", $data);
            $sign               = MakeSign($pageparama, $pay_signkey);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/micropay", 10);
            $result             = FromXml($response);
            if ($result['return_code'] != 'SUCCESS') {
                pdo_update("j_money_trade", array(
                    "log" => "收款失败：" . $result['return_msg']
                ), array(
                    "out_trade_no" => $payParama['outTradeNo']
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['return_msg']
                )));
            }
            $insertInfo = array(
                "openid" => $result['openid'],
                "is_subscribe" => $result['is_subscribe'] == "Y" ? 1 : 0,
                "sub_openid" => isset($result['sub_openid']) ? $result['sub_openid'] : "",
                "sub_is_subscribe" => isset($result['sub_is_subscribe']) && $result['sub_is_subscribe'] == "Y" ? 1 : 0,
                "trade_type" => $result['trade_type'],
                "bank_type" => $result['bank_type'],
                "fee_type" => $result['CNY'],
                "transaction_id" => $result['transaction_id'],
                "time_end" => strtotime($result['time_end'])
            );
            if (!intval($data['total_fee']))
                $insertInfo["total_fee"] = intval($result['total_fee']);
            if (!intval($data['coupon_fee']))
                $insertInfo["coupon_fee"] = intval($result['coupon_fee']);
            if (intval($result['cash_fee']))
                $insertInfo["cash_fee"] = intval($result['cash_fee']);
            if ($result['result_code'] == 'SUCCESS') {
                $insertInfo['isconfirm'] = 1;
                $insertInfo['status']    = 1;
            }
            pdo_update("j_money_trade", $insertInfo, array(
                "out_trade_no" => $payParama['outTradeNo']
            ));
            if (!isset($result['out_trade_no']))
                $result['out_trade_no'] = $payParama['outTradeNo'];
            die(json_encode(array(
                "success" => true,
                "items" => $result
            )));
        }
        if ($operation == "qrcodewechat") {
            $fee        = $_GPC["fee"];
            $userOpenid = $_W['openid'] ? $_W['openid'] : die(json_encode(array(
                "success" => false,
                "msg" => "请先登录"
            )));
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and openid=:openid ", array(
                ":openid" => $userOpenid
            ));
            if (!$user)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            load()->func('communication');
            $fee        = intval($fee * 100);
            $totalfee   = intval($fee);
            $coupon_fee = 0;
            $marketid   = 0;
            $marketing  = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:d and starttime<=:a and endtime>=:b and status=1 and condition_fee<=:c order by displayorder asc ,id desc limit 1", array(
                ":a" => TIMESTAMP,
                ":b" => TIMESTAMP,
                ":c" => $fee,
                ":d" => $user['pcate']
            ));
            if ($marketing && $marketing['favorabletype'] == 1) {
                if ($marketing['hour']) {
                    $hourary = strpos($marketing['hour'], ",") ? explode(",", $marketing['hour']) : array(
                        $marketing['hour']
                    );
                    if (!in_array(date("H"), $hourary))
                        goto pay2;
                }
                if ($marketing['num']) {
                    $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status=1 and marketing=:a and createdate =:b ", array(
                        ":a" => $marketing['id'],
                        ":b" => date('Y-m-d')
                    ));
                    if ($marketing['isallnum']) {
                        $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a ", array(
                            ":a" => $marketing['id']
                        ));
                    }
                    if ($numuser >= $marketing['num'])
                        goto pay2;
                }
                $favorable = $marketing['favorable'];
                if (strpos($favorable, "|#满减#|")) {
                    $temp     = str_replace("[|#满减#|", "", $favorable);
                    $temp     = str_replace("]", "", $temp);
                    $favorAry = explode("-", $temp);
                    if (count($favorAry) > 1) {
                        $favorAry1 = strpos($favorAry[0], "%") ? intval(str_replace("%", "", $favorAry[0]) * 0.01 * $fee) : $favorAry[0] * 100;
                        $favorAry2 = strpos($favorAry[1], "%") ? intval(str_replace("%", "", $favorAry[1]) * 0.01 * $fee) : $favorAry[1] * 100;
                        if ($favorAry1 >= $favorAry2) {
                            $coupon_fee = $favorAry1;
                        } else {
                            $coupon_fee = mt_rand($favorAry1, $favorAry2);
                        }
                        if ($marketing['isint']) {
                            $coupon_fee = intval(sprintf('%.2f', ($coupon_fee * 0.01))) * 100;
                        }
                        if (count($favorAry) == 3) {
                            if ($coupon_fee > $favorAry[2] * 100)
                                $coupon_fee = $favorAry[2] * 100;
                        }
                        if ($coupon_fee >= $fee)
                            $coupon_fee = 0;
                        $fee      = $fee - $coupon_fee;
                        $marketid = $marketing['id'];
                    }
                }
            }
pay2:
            $shop       = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['pcate']
            ));
            $payParama  = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "pay_mchid" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "pay_signkey" => $shop['pay_signkey'] ? $shop['pay_signkey'] : $cfg['pay_signkey'],
                "outTradeNo" => strval(date("YmdHis")),
                "pay_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "sub_appid" => $shop['sub_appid'] ? $shop['sub_appid'] : $cfg['sub_appid'],
                "sub_mch_id" => $shop['sub_mch_id'] ? $shop['sub_mch_id'] : $cfg['sub_mch_id']
            );
            $pageparama = array(
                "appid" => $payParama['appid'],
                "mch_id" => $payParama['pay_mchid'],
                "device_info" => "WEB",
                "nonce_str" => getNonceStr(),
                "body" => "微支付收款",
                "detail" => "微支付收款",
                "attach" => "-",
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $fee,
                "fee_type" => "CNY",
                "spbill_create_ip" => $payParama['spbill_create_ip'],
                "time_start" => date("YmdHis"),
                "time_expire" => date("YmdHis", TIMESTAMP + 600),
                "notify_url" => $cfg['notify_url'],
                "trade_type" => "NATIVE",
                "product_id" => "01"
            );
            if ($payParama['sub_appid'])
                $pageparama['sub_appid'] = $payParama['sub_appid'];
            if ($payParama['sub_mch_id'])
                $pageparama['sub_mch_id'] = $payParama['sub_mch_id'];
            $data = array(
                "weid" => $_W['uniacid'],
                "userid" => $user['id'],
                "groupid" => $user['pcate'],
                "attach" => "扫码收款",
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $totalfee,
                "coupon_fee" => $coupon_fee,
                "cash_fee" => $fee,
                "createtime" => TIMESTAMP,
                "createdate" => date('Y-m-d'),
                "marketing" => $marketid,
                "old_trade_no" => $_GPC['old_trade_no']
            );
            if ($marketid)
                $data['marketing_log'] = $marketing['description'];
            pdo_insert("j_money_trade", $data);
            $sign               = MakeSign($pageparama, $payParama['pay_signkey']);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/unifiedorder", 10);
            $result             = FromXml($response);
            if ($result['return_code'] != 'SUCCESS') {
                pdo_update("j_money_trade", array(
                    "log" => "收款失败：" . $result['return_msg']
                ), array(
                    "out_trade_no" => $payParama['outTradeNo']
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['return_msg']
                )));
            }
            if (isset($result['code_url'])) {
                include('../addons/j_money/phpqrcode.php');
                load()->func('file');
                $dir_url = "../attachment/j_money/" . $_W['uniacid'] . "/";
                mkdirs($dir_url);
                $codename = $userOpenid . "_.png";
                $value    = $result['code_url'];
                if (file_exists($dir_url . $codename))
                    @unlink($dir_url . $codename);
                QRcode::png($value, $dir_url . $codename, "L", 10);
                die(json_encode(array(
                    "success" => true,
                    "qrcode" => $dir_url . $codename . "?v=" . TIMESTAMP,
                    "orderid" => $payParama['outTradeNo']
                )));
            }
            die(json_encode(array(
                "success" => false,
                "msg" => "生成失败"
            )));
        }
        if ($operation == "closeqrcodewechat") {
            $orderid            = $_GPC["orderid"];
            $groupid            = pdo_fetchcolumn("SELECT groupid FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            $shop               = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $groupid
            ));
            $payParama          = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "pay_mchid" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "pay_signkey" => $shop['pay_signkey'] ? $shop['pay_signkey'] : $cfg['pay_signkey'],
                "outTradeNo" => strval(date("YmdHis")),
                "pay_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "sub_appid" => $shop['sub_appid'] ? $shop['sub_appid'] : $cfg['sub_appid'],
                "sub_mch_id" => $shop['sub_mch_id'] ? $shop['sub_mch_id'] : $cfg['sub_mch_id']
            );
            $pageparama         = array(
                "appid" => $payParama['appid'],
                "mch_id" => $payParama['pay_mchid'],
                "out_trade_no" => $orderid,
                "nonce_str" => getNonceStr()
            );
            $sign               = MakeSign($pageparama, $payParama['pay_signkey']);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/closeorder", 10);
            $result             = FromXml($response);
            if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
                pdo_update("j_money_trade", array(
                    "log" => "取消订单："
                ), array(
                    "out_trade_no" => $orderid
                ));
                die(json_encode(array(
                    "success" => true,
                    "orderid" => $outTradeNo
                )));
            }
            pdo_update("j_money_trade", array(
                "log" => "取消订单失败：" . $result['return_msg']
            ), array(
                "out_trade_no" => $orderid
            ));
            die(json_encode(array(
                "success" => false,
                "msg" => $result['return_msg']
            )));
        }
        if ($operation == "payalipay") {
            $qrcode     = $_GPC["qrcode"];
            $fee        = $_GPC["fee"] ? $_GPC["fee"] : 1;
            $deviceinfo = intval($_GPC["userid"]);
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:a and status>0", array(
                ":a" => $deviceinfo
            ));
            if (!$user)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            $fee        = intval($fee * 100);
            $totalfee   = intval($fee);
            $coupon_fee = 0;
            $marketid   = 0;
            $marketing  = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:d and starttime<=:a and endtime>=:b and status=1 and favorabletype=1 and condition_fee<=:c order by displayorder asc ,id desc limit 1", array(
                ":a" => TIMESTAMP,
                ":b" => TIMESTAMP,
                ":c" => $fee,
                ":d" => $user['pcate']
            ));
            if ($marketing) {
                if ($marketing['hour']) {
                    $hourary = strpos($marketing['hour'], ",") ? explode(",", $marketing['hour']) : array(
                        $marketing['hour']
                    );
                    if (!in_array(date("H"), $hourary))
                        goto alipay;
                }
                if ($marketing['num']) {
                    $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a and createdate =:b ", array(
                        ":a" => $marketing['id'],
                        ":b" => date('Y-m-d')
                    ));
                    if ($marketing['isallnum']) {
                        $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a ", array(
                            ":a" => $marketing['id']
                        ));
                    }
                    if ($numuser >= $marketing['num'])
                        goto alipay;
                }
                $favorable = $marketing['favorable'];
                if (strpos($favorable, "|#满减#|")) {
                    $temp     = str_replace("[|#满减#|", "", $favorable);
                    $temp     = str_replace("]", "", $temp);
                    $favorAry = explode("-", $temp);
                    if (count($favorAry) > 1) {
                        $favorAry1 = strpos($favorAry[0], "%") ? intval(str_replace("%", "", $favorAry[0]) * 0.01 * $fee) : $favorAry[0] * 100;
                        $favorAry2 = strpos($favorAry[1], "%") ? intval(str_replace("%", "", $favorAry[1]) * 0.01 * $fee) : $favorAry[1] * 100;
                        if ($favorAry1 >= $favorAry2) {
                            $coupon_fee = $favorAry1;
                        } else {
                            $coupon_fee = mt_rand($favorAry1, $favorAry2);
                        }
                        if ($marketing['isint']) {
                            $coupon_fee = intval(sprintf('%.2f', ($coupon_fee * 0.01))) * 100;
                        }
                        if (count($favorAry) == 3) {
                            if ($coupon_fee > $favorAry[2] * 100)
                                $coupon_fee = $favorAry[2] * 100;
                        }
                        if ($coupon_fee >= $fee)
                            $coupon_fee = 0;
                        $fee      = $fee - $coupon_fee;
                        $marketid = $marketing['id'];
                    }
                }
            }
alipay:
            $shop         = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['pcate']
            ));
            $payParama    = array(
                "app_id" => $shop['app_id'] ? $shop['app_id'] : $cfg['app_id'],
                "outTradeNo" => strval(date("YmdHis")),
                "pemurl" => $cfg['pemurl'],
                "merchant_private_key_file" => $cfg['merchant_private_key_file']
            );
            $auth_code    = trim($qrcode);
            $total_amount = $fee;
            $subject      = "支付宝收款";
            $data         = array(
                "weid" => $_W['uniacid'],
                "userid" => $deviceinfo,
                "groupid" => $user['pcate'],
                "attach" => $_GPC['attach'] ? $_GPC['attach'] : "PC",
                "paytype" => 1,
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $totalfee,
                "coupon_fee" => $coupon_fee,
                "cash_fee" => $fee,
                "createtime" => TIMESTAMP,
                "createdate" => date('Y-m-d'),
                "marketing" => $marketid,
                "old_trade_no" => $_GPC['old_trade_no']
            );
            if ($marketid)
                $data['marketing_log'] = $marketing['description'];
            pdo_insert("j_money_trade", $data);
            $postfee = sprintf('%.2f', ($fee * 0.01));
            require_once '../addons/j_money/F2fpay.php';
            $f2fpay   = new F2fpay();
            $response = $f2fpay->barpay($payParama['outTradeNo'], $auth_code, $postfee, $subject, $payParama);
            $temp     = (array) $response;
            $result   = (array) $temp['alipay_trade_pay_response'];
            if ($result['code'] == "10003") {
                die(json_encode(array(
                    "success" => true,
                    "result" => true,
                    "out_trade_no" => $payParama['outTradeNo']
                )));
            } elseif ($result['code'] == "10000") {
                $insertdata = array(
                    "status" => 1,
                    "isconfirm" => 1,
                    "transaction_id" => $result['trade_no'],
                    "time_end" => strtotime($result['gmt_payment'])
                );
                pdo_update("j_money_trade", $insertdata, array(
                    "out_trade_no" => $payParama['outTradeNo']
                ));
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE out_trade_no=:a", array(
                    ":a" => $payParama['outTradeNo']
                ));
                die(json_encode(array(
                    "success" => true,
                    "items" => $item
                )));
            } else {
                pdo_update("j_money_trade", array(
                    "log" => "收款失败：" . $result['sub_msg']
                ), array(
                    "out_trade_no" => $payParama['outTradeNo']
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['sub_msg']
                )));
            }
            die();
        }
        if ($operation == "qrcodealipay") {
            $fee        = $_GPC["fee"];
            $userOpenid = $_W['openid'] ? $_W['openid'] : die(json_encode(array(
                "success" => false,
                "msg" => "请先登录"
            )));
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and openid=:openid ", array(
                ":openid" => $userOpenid
            ));
            if (!$user)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            $fee        = intval($fee * 100);
            $totalfee   = intval($fee);
            $coupon_fee = 0;
            $marketid   = 0;
            $marketing  = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:d and starttime<=:a and endtime>=:b and status=1 and favorabletype=1 and condition_fee<=:c order by displayorder asc ,id desc limit 1", array(
                ":a" => TIMESTAMP,
                ":b" => TIMESTAMP,
                ":c" => $fee,
                ":d" => $user['pcate']
            ));
            if ($marketing) {
                if ($marketing['hour']) {
                    $hourary = strpos($marketing['hour'], ",") ? explode(",", $marketing['hour']) : array(
                        $marketing['hour']
                    );
                    if (!in_array(date("H"), $hourary))
                        goto alipay2;
                }
                if ($marketing['num']) {
                    $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a and createdate =:b ", array(
                        ":a" => $marketing['id'],
                        ":b" => date('Y-m-d')
                    ));
                    if ($marketing['isallnum']) {
                        $numuser = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and status>0 and marketing=:a ", array(
                            ":a" => $marketing['id']
                        ));
                    }
                    if ($numuser >= $marketing['num'])
                        goto alipay2;
                }
                $favorable = $marketing['favorable'];
                if (strpos($favorable, "|#满减#|")) {
                    $temp     = str_replace("[|#满减#|", "", $favorable);
                    $temp     = str_replace("]", "", $temp);
                    $favorAry = explode("-", $temp);
                    if (count($favorAry) > 1) {
                        $favorAry1 = strpos($favorAry[0], "%") ? intval(str_replace("%", "", $favorAry[0]) * 0.01 * $fee) : $favorAry[0] * 100;
                        $favorAry2 = strpos($favorAry[1], "%") ? intval(str_replace("%", "", $favorAry[1]) * 0.01 * $fee) : $favorAry[1] * 100;
                        if ($favorAry1 >= $favorAry2) {
                            $coupon_fee = $favorAry1;
                        } else {
                            $coupon_fee = mt_rand($favorAry1, $favorAry2);
                        }
                        if ($marketing['isint']) {
                            $coupon_fee = intval(sprintf('%.2f', ($coupon_fee * 0.01))) * 100;
                        }
                        if (count($favorAry) == 3) {
                            if ($coupon_fee > $favorAry[2] * 100)
                                $coupon_fee = $favorAry[2] * 100;
                        }
                        if ($coupon_fee >= $fee)
                            $coupon_fee = 0;
                        $fee      = $fee - $coupon_fee;
                        $marketid = $marketing['id'];
                    }
                }
            }
alipay2:
            $shop         = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['pcate']
            ));
            $payParama    = array(
                "app_id" => $shop['app_id'] ? $shop['app_id'] : $cfg['app_id'],
                "outTradeNo" => strval(date("YmdHis")),
                "pemurl" => $cfg['pemurl'],
                "merchant_private_key_file" => $cfg['merchant_private_key_file']
            );
            $total_amount = $fee;
            $subject      = "支付宝收款";
            $data         = array(
                "weid" => $_W['uniacid'],
                "userid" => $user['id'],
                "attach" => "扫码收款",
                "groupid" => $user['pcate'],
                "paytype" => 1,
                "out_trade_no" => $payParama['outTradeNo'],
                "total_fee" => $totalfee,
                "coupon_fee" => $coupon_fee,
                "cash_fee" => $fee,
                "createtime" => TIMESTAMP,
                "createdate" => date('Y-m-d'),
                "marketing" => $marketid,
                "old_trade_no" => $_GPC['old_trade_no']
            );
            if ($marketid)
                $data['marketing_log'] = $marketing['description'];
            pdo_insert("j_money_trade", $data);
            $postfee = sprintf('%.2f', ($fee * 0.01));
            require_once '../addons/j_money/F2fpay.php';
            $f2fpay   = new F2fpay();
            $response = $f2fpay->qrpay($payParama['outTradeNo'], $postfee, $subject, $payParama);
            $temp     = (array) $response;
            $result   = (array) $temp['alipay_trade_precreate_response'];
            if ($result['code'] == "10000") {
                if (isset($result['qr_code'])) {
                    include('../addons/j_money/phpqrcode.php');
                    load()->func('file');
                    $dir_url = "../attachment/j_money/" . $_W['uniacid'] . "/";
                    mkdirs($dir_url);
                    $codename = $userOpenid . "_.png";
                    $value    = $result['qr_code'];
                    if (file_exists($dir_url . $codename))
                        @unlink($dir_url . $codename);
                    QRcode::png($value, $dir_url . $codename, "L", 10);
                    die(json_encode(array(
                        "success" => true,
                        "qrcode" => $dir_url . $codename . "?v=" . TIMESTAMP,
                        "orderid" => $payParama['outTradeNo']
                    )));
                }
                die(json_encode(array(
                    "success" => false,
                    "msg" => "生成失败"
                )));
            } else {
                pdo_update("j_money_trade", array(
                    "log" => "收款码失败：" . $result['sub_msg']
                ), array(
                    "out_trade_no" => $payParama['outTradeNo']
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['sub_msg']
                )));
            }
            die();
        }
        if ($operation == "checktradestatus") {
            $orderid = $_GPC["orderid"];
            if (!$orderid)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "订单编号不能为空"
                )));
            $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            if (!$trade)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "交易不存在"
                )));
            if ($trade['refundtime'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "订单在" . date("Y-m-d H:i", $trade['refundtime']) . "退款成功"
                )));
            if ($trade['status'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "交易成功"
                )));
            $shop = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $trade['groupid']
            ));
            if ($trade['paytype'] == 1) {
                $payParama = array(
                    "app_id" => $shop['app_id'] ? $shop['app_id'] : $cfg['app_id'],
                    "outTradeNo" => $orderid,
                    "pemurl" => $cfg['pemurl'],
                    "merchant_private_key_file" => $cfg['merchant_private_key_file']
                );
                require_once '../addons/j_money/F2fpay.php';
                $cfg      = $this->module['config'];
                $f2fpay   = new F2fpay();
                $response = $f2fpay->query($orderid, $payParama);
                $results  = @json_decode(json_encode($response), true);
                $result   = $results['alipay_trade_query_response'];
                if ($result['code'] == 10000) {
                    if ($result['trade_status'] == "TRADE_SUCCESS") {
                        $insertdata = array(
                            "status" => 1,
                            "isconfirm" => 1,
                            "transaction_id" => $result['trade_no'],
                            "time_end" => strtotime($result['gmt_payment'])
                        );
                        pdo_update("j_money_trade", $insertdata, array(
                            "out_trade_no" => $orderid
                        ));
                        die(json_encode(array(
                            "success" => false,
                            "msg" => "交易成功"
                        )));
                    }
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "交易失败"
                    )));
                } else {
                    pdo_update("j_money_trade", array(
                        "log" => "收款失败：" . $result['sub_msg']
                    ), array(
                        "out_trade_no" => $orderid
                    ));
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "交易失败:" . $result['sub_msg']
                    )));
                }
            } else {
                $payParama  = array(
                    "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                    "pay_mchid" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                    "pay_signkey" => $shop['pay_signkey'] ? $shop['pay_signkey'] : $cfg['pay_signkey'],
                    "outTradeNo" => strval(date("YmdHis")),
                    "pay_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                    "sub_appid" => $shop['sub_appid'] ? $shop['sub_appid'] : $cfg['sub_appid'],
                    "sub_mch_id" => $shop['sub_mch_id'] ? $shop['sub_mch_id'] : $cfg['sub_mch_id']
                );
                $pageparama = array(
                    "appid" => $payParama['appid'],
                    "mch_id" => strval($payParama['pay_mchid']),
                    "out_trade_no" => $orderid,
                    "nonce_str" => getNonceStr()
                );
                if ($payParama['sub_appid'])
                    $pageparama['sub_appid'] = $payParama['sub_appid'];
                if ($payParama['sub_mch_id'])
                    $pageparama['sub_mch_id'] = $payParama['sub_mch_id'];
                $sign               = MakeSign($pageparama, $payParama['pay_signkey']);
                $pageparama['sign'] = $sign;
                $xml                = ToXml($pageparama);
                $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/orderquery", 10);
                $result             = FromXml($response);
                if ($result['trade_state'] == 'SUCCESS' && $trade['status'] == 0) {
                    $insertInfo = array(
                        "openid" => $result['openid'],
                        "is_subscribe" => $result['is_subscribe'] == "Y" ? 1 : 0,
                        "trade_type" => $result['trade_type'],
                        "bank_type" => $result['bank_type'],
                        "fee_type" => $result['CNY'],
                        "transaction_id" => $result['transaction_id'],
                        "time_end" => strtotime($result['time_end']),
                        "isconfirm" => 1,
                        "status" => 1
                    );
                    pdo_update("j_money_trade", $insertInfo, array(
                        "id" => $trade['id']
                    ));
                    die(json_encode(array(
                        "success" => true,
                        "msg" => "交易成功"
                    )));
                }
                die(json_encode(array(
                    "success" => true,
                    "msg" => "交易失败"
                )));
            }
            die(json_encode(array(
                "success" => true,
                "msg" => "交易失败"
            )));
        }
        if ($operation == "checwechatkpay") {
            load()->func('communication');
            $orderid    = $_GPC["orderid"];
            $trade      = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            $shop       = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $trade['groupid']
            ));
            $payParama  = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "pay_mchid" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "pay_signkey" => $shop['pay_signkey'] ? $shop['pay_signkey'] : $cfg['pay_signkey'],
                "outTradeNo" => strval(date("YmdHis")),
                "pay_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "sub_appid" => $shop['sub_appid'] ? $shop['sub_appid'] : $cfg['sub_appid'],
                "sub_mch_id" => $shop['sub_mch_id'] ? $shop['sub_mch_id'] : $cfg['sub_mch_id']
            );
            $pageparama = array(
                "appid" => $payParama['appid'],
                "mch_id" => strval($payParama['pay_mchid']),
                "out_trade_no" => $orderid,
                "nonce_str" => getNonceStr()
            );
            if ($payParama['sub_appid'])
                $pageparama['sub_appid'] = $payParama['sub_appid'];
            if ($payParama['sub_mch_id'])
                $pageparama['sub_mch_id'] = $payParama['sub_mch_id'];
            $sign               = MakeSign($pageparama, $payParama['pay_signkey']);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/orderquery", 10);
            $result             = FromXml($response);
            if ($result['trade_state'] == 'SUCCESS' && $trade['status'] == 0) {
                $insertInfo = array(
                    "openid" => $result['openid'],
                    "is_subscribe" => $result['is_subscribe'] == "Y" ? 1 : 0,
                    "sub_openid" => isset($result['sub_openid']) ? $result['sub_openid'] : "",
                    "sub_is_subscribe" => isset($result['sub_is_subscribe']) && $result['sub_is_subscribe'] == "Y" ? 1 : 0,
                    "trade_type" => $result['trade_type'],
                    "bank_type" => $result['bank_type'],
                    "fee_type" => $result['CNY'],
                    "transaction_id" => $result['transaction_id'],
                    "time_end" => strtotime($result['time_end']),
                    "isconfirm" => 1,
                    "status" => 1
                );
                pdo_update("j_money_trade", $insertInfo, array(
                    "id" => $trade['id']
                ));
            }
            die(json_encode(array(
                "success" => true,
                "items" => $result
            )));
        }
        if ($operation == "checkalipay") {
            load()->func('communication');
            $orderid   = $_GPC["orderid"];
            $trade     = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            $shop      = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $trade['groupid']
            ));
            $payParama = array(
                "app_id" => $shop['app_id'] ? $shop['app_id'] : $cfg['app_id'],
                "outTradeNo" => $orderid,
                "pemurl" => $cfg['pemurl'],
                "merchant_private_key_file" => $cfg['merchant_private_key_file']
            );
            require_once '../addons/j_money/F2fpay.php';
            $cfg      = $this->module['config'];
            $f2fpay   = new F2fpay();
            $response = $f2fpay->query($orderid, $payParama);
            $results  = @json_decode(json_encode($response), true);
            $result   = $results['alipay_trade_query_response'];
            if ($result['code'] == 10003) {
                pdo_update("j_money_trade", array(
                    "log" => "等待客户支付密码"
                ), array(
                    "out_trade_no" => $orderid
                ));
                die(json_encode(array(
                    "success" => true,
                    "result" => true,
                    "out_trade_no" => $orderid
                )));
            } elseif ($result['code'] == 10000) {
                if ($result['trade_status'] == "TRADE_SUCCESS") {
                    $insertdata = array(
                        "status" => 1,
                        "isconfirm" => 1,
                        "transaction_id" => $result['trade_no'],
                        "time_end" => strtotime($result['gmt_payment'])
                    );
                    pdo_update("j_money_trade", $insertdata, array(
                        "out_trade_no" => $orderid
                    ));
                    $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a", array(
                        ":a" => $orderid
                    ));
                    die(json_encode(array(
                        "success" => true,
                        "items" => $trade
                    )));
                } else {
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "等待客户付款"
                    )));
                }
            } else {
                pdo_update("j_money_trade", array(
                    "log" => "收款失败：" . $result['sub_msg']
                ), array(
                    "out_trade_no" => $orderid
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['sub_msg']
                )));
            }
            die();
        }
        if ($operation == "reverse") {
            $orderid = $_GPC["orderid"];
            $trade   = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            if ($trade['status'])
                die();
            $mch_id             = $cfg['pay_mchid'];
            $pay_signkey        = $cfg['pay_signkey'];
            $pageparama         = array(
                "appid" => $cfg['appid'],
                "mch_id" => strval($mch_id),
                "out_trade_no" => $orderid,
                "nonce_str" => getNonceStr()
            );
            $sign               = MakeSign($pageparama, $pay_signkey);
            $pageparama['sign'] = $sign;
            $xml                = array2xml($pageparama);
            $extras             = array();
            $certfile           = "../attachment/j_money/cert_2/" . $_W['uniacid'] . "/" . $cfg['apiclient_cert'];
            $keyfile            = "../attachment/j_money/cert_2/" . $_W['uniacid'] . "/" . $cfg['apiclient_key'];
            if (!file_exists($certfile) || !file_exists($certfile)) {
                $data = array(
                    "log" => "撤销订单时:读取证书失败"
                );
                pdo_update("j_money_trade", $data, array(
                    "id" => $trade['id']
                ));
                die();
            }
            $extras['CURLOPT_SSLCERT'] = $certfile;
            $extras['CURLOPT_SSLKEY']  = $keyfile;
            load()->func('communication');
            $resp = ihttp_request("https://api.mch.weixin.qq.com/secapi/pay/reverse", $xml, $extras);
            if (is_error($resp)) {
                $procResult = $resp;
            }
            $arr = FromXml($resp['content']);
            die();
        }
        if ($operation == "marketing") {
            $orderid = $_GPC["orderid"];
            if (!$orderid)
                die("订单号不能为空");
            $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            $user  = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $trade['userid']
            ));
            if ($trade['paytype']) {
                die(json_encode(array(
                    "success" => false,
                    "msg" => "支付订单没有后续方案"
                )));
            }
            if (!$trade || !$trade['status'] || !$trade['openid'])
                die("订单异常");
            if ($trade['marketing'])
                die("已有营销方案");
            $marketlist = pdo_fetchall("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:d and starttime<=:a and endtime>=:b and status=1 and favorabletype>1 and condition_fee<=:c order by displayorder asc,id desc", array(
                ":a" => $trade['time_end'],
                ":b" => $trade['time_end'],
                ":c" => $trade['cash_fee'],
                ":d" => $user['pcate']
            ));
            if (!count($marketlist) || !$marketlist)
                die("没有符合营销方案");
            $openid = $trade['sub_openid'] ? $trade['sub_openid'] : $trade['openid'];
            $data   = array(
                "weid" => $_W['uniacid'],
                "out_trade_no" => $orderid,
                "createtime" => TIMESTAMP,
                "openid" => $openid
            );
            pdo_insert("j_money_reward", $data);
            $markid = 0;
            foreach ($marketlist as $row) {
                if ($markid)
                    break;
                $flag = false;
                switch ($row['condition']) {
                    case 1:
                        $flag = true;
                        break;
                    case 4:
                        $flag = true;
                        break;
                    case 2:
                        load()->model('mc');
                        $uid = mc_openid2uid($openid);
                        if ($uid) {
                            $u_groupid = mc_fetch($openid, "groupid");
                            $groupary  = strpos($row['condition_member'], ",") ? explode(",", $row['condition_member']) : array(
                                $row['condition_member']
                            );
                            if (!in_array($u_groupid, $groupary))
                                $flag = true;
                        }
                        break;
                    case 3:
                        $isAdd = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE openid=:a", array(
                            ":a" => $openid
                        ));
                        if (!$isAdd)
                            $flag = true;
                        break;
                    case 5:
                        $followtime = pdo_fetchcolumn("SELECT followtime FROM " . tablename('mc_mapping_fans') . " WHERE openid=:a", array(
                            ":a" => $openid
                        ));
                        if ($followtime) {
                            if (TIMESTAMP - $followtime >= $row['condition_attendtime'] * 86400) {
                                $flag = true;
                            }
                        }
                        break;
                }
                if (!$flag)
                    continue;
                if ($row['num']) {
                    $where         = $row["isallnum"] ? "" : " and createtime>='" . strtotime(date("Y-m-d") . " 00:00") . "' and createtime<='" . strtotime(date("Y-m-d") . " 23:59") . "'";
                    $hadfavorCount = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_reward') . " WHERE weid=:a and favorabletype=:b $where", array(
                        ":a" => $_W['uniacid'],
                        ":b" => $row['favorabletype']
                    ));
                    if ($hadfavorCount >= $row['num'])
                        continue;
                }
                pdo_update("j_money_reward", array(
                    "favorabletype" => $row['favorabletype'],
                    "favorable" => $row['favorable'],
                    "marketid" => $row["id"],
                    "marketing_log" => $row["description"]
                ), array(
                    "out_trade_no" => $orderid
                ));
                pdo_update("j_money_trade", array(
                    "marketing" => $row["id"],
                    "marketing_log" => $row["description"]
                ), array(
                    "id" => $trade['id']
                ));
                $markid    = $row['id'];
                $favorable = $row['favorable'];
                switch ($row['favorabletype']) {
                    case 2:
                        if (strpos($favorable, "|#红包#|")) {
                            $temp     = str_replace("[|#红包#|", "", $favorable);
                            $temp     = str_replace("]", "", $temp);
                            $favorAry = explode("-", $temp);
                            $fee      = 0;
                            if (count($favorAry) == 2) {
                                $favorAry1 = intval($favorAry[0] * 100);
                                $favorAry2 = intval($favorAry[1] * 100);
                                if ($favorAry1 >= $favorAry2) {
                                    $fee = $favorAry1;
                                } else {
                                    $fee = mt_rand($favorAry1, $favorAry2);
                                }
                                if ($fee >= 100) {
                                    $this->_sendpack($openid, $orderid, $fee, $cfg);
                                } else {
                                    pdo_update("j_money_reward", array(
                                        "favorabletype" => "2",
                                        "favorable" => $row['favorable'],
                                        'condition' => $row['condition'],
                                        "reward" => $fee,
                                        "log" => "金额不足1元，不发送红包"
                                    ), array(
                                        "out_trade_no" => $orderid
                                    ));
                                }
                            }
                        }
                        break;
                    case 3:
                        if (strpos($favorable, "|#卡券#|")) {
                            $temp     = str_replace("[|#卡券#|", "", $favorable);
                            $temp     = str_replace("]", "", $temp);
                            $favorAry = strpos($temp, ",") ? explode(",", $temp) : array(
                                $temp
                            );
                            shuffle($favorAry);
                            $cardkey = $favorAry[0];
                            $wxcard  = json_decode($cfg['wxcard'], true);
                            if ($wxcard[$cardkey]) {
                                $markid     = $row['id'];
                                $updateData = array(
                                    'marketid' => $markid,
                                    'favorabletype' => 3,
                                    'favorable' => $row['favorable'],
                                    'condition' => $row['condition'],
                                    'reward' => $wxcard[$cardkey],
                                    'status' => 0,
                                    'gettype' => 1,
                                    'log' => '获得卡券'
                                );
                                pdo_update("j_money_reward", $updateData, array(
                                    "out_trade_no" => $orderid
                                ));
                                if ($trade['is_subscribe']) {
                                    $result = $this->sendCard($openid, $wxcard[$cardkey]);
                                    if ($result['errcode'] == 0) {
                                        pdo_update("j_money_reward", array(
                                            "status" => 1,
                                            "completed" => 1,
                                            "gettype" => 0,
                                            "endtime" => TIMESTAMP
                                        ), array(
                                            "out_trade_no" => $orderid
                                        ));
                                    }
                                }
                                die(json_encode($result));
                            }
                        }
                        break;
                    case 4:
                        if (strpos($row['favorable'], "|#抽奖#|")) {
                            $temp     = str_replace("[|#抽奖#|", "", $favorable);
                            $temp     = str_replace("]", "", $temp);
                            $favorAry = intval($temp);
                            if ($favorAry) {
                                $markid     = $row['id'];
                                $updateData = array(
                                    'marketid' => $markid,
                                    'favorabletype' => 4,
                                    'condition' => $row['condition'],
                                    'favorable' => $row['favorable'],
                                    'reward' => $favorAry,
                                    'status' => 1,
                                    'gettype' => 1,
                                    'log' => '获得' . $favorAry . '次抽奖机会'
                                );
                                pdo_update("j_money_reward", $updateData, array(
                                    "out_trade_no" => $orderid
                                ));
                                $insert = array(
                                    'weid' => $_W['uniacid'],
                                    'gid' => $row['gid'],
                                    'from_user' => $openid
                                );
                                for ($i = 0; $i < $favorAry; $i++) {
                                    pdo_insert("j_money_lottery", $insert);
                                }
                            }
                        }
                        break;
                }
            }
            die();
        }
        if ($operation == "isprint") {
            $orderid = $_GPC["orderid"];
            $trade   = pdo_fetch("SELECT id,isprint FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            if (!$trade)
                die("1");
            $temp = pdo_update("j_money_trade", array(
                "isprint" => $trade['isprint'] + 1
            ), array(
                "id" => $trade['id']
            ));
            die($temp);
        }
        if ($operation == "getcounterrecord") {
            $userid = $_GPC['islogin'];
            $date   = isset($_GPC['date']) ? $_GPC['date'] : date('Y-m-d');
            if (!$userid)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            $list            = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createdate=:b order by id desc", array(
                ":a" => $userid,
                ":b" => $date
            ));
            $cash_fee_wechat = 0;
            $cash_fee_ali    = 0;
            $i               = 0;
            $templist        = array();
            foreach ($list as $row) {
                if ($row['status']) {
                    if ($row['paytype']) {
                        $cash_fee_ali = $cash_fee_ali + $row['cash_fee'];
                    } else {
                        $cash_fee_wechat = $cash_fee_wechat + $row['cash_fee'];
                    }
                }
                if ($i < 10) {
                    $templist[$i]               = $row;
                    $templist[$i]['paytype']    = $row['paytype'] ? "支付宝" : "微信";
                    $templist[$i]['createtime'] = date("H:i", $row['createtime']);
                    $templist[$i]['total_fee']  = sprintf('%.2f', ($row['total_fee'] / 100));
                    $templist[$i]['coupon_fee'] = sprintf('%.2f', ($row['coupon_fee'] / 100));
                    $templist[$i]['cash_fee']   = sprintf('%.2f', ($row['cash_fee'] / 100));
                }
                $i++;
            }
            $num = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_carduser') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createtime>=:b and createtime<=:c", array(
                ':a' => $userid,
                ':b' => strtotime(date("Y-m-d 00:00:00")),
                ':c' => strtotime(date("Y-m-d 23:59:59"))
            ));
            die(json_encode(array(
                "success" => true,
                "num" => $num,
                "item" => $templist,
                "cash_fee_w" => sprintf('%.2f', ($cash_fee_wechat / 100)),
                "cash_fee_a" => sprintf('%.2f', ($cash_fee_ali / 100))
            )));
        }
        if ($operation == "getcounternoprintrecord") {
            $userid = $_GPC['islogin'];
            $date   = isset($_GPC['date']) ? $_GPC['date'] : date('Y-m-d');
            if (!$userid)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            $list     = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createdate=:b and status>0 and isprint=0  order by id desc", array(
                ":a" => $userid,
                ":b" => $date
            ));
            $i        = 0;
            $templist = array();
            foreach ($list as $row) {
                if ($i < 10) {
                    $templist[$i]               = $row;
                    $templist[$i]['paytype']    = $row['paytype'] ? "支付宝" : "微信";
                    $templist[$i]['createtime'] = date("H:i", $row['createtime']);
                    $templist[$i]['total_fee']  = sprintf('%.2f', ($row['total_fee'] / 100));
                    $templist[$i]['coupon_fee'] = sprintf('%.2f', ($row['coupon_fee'] / 100));
                    $templist[$i]['cash_fee']   = sprintf('%.2f', ($row['cash_fee'] / 100));
                }
                $i++;
            }
            $num = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}'  and userid=:a and createdate=:b and status=1 and isprint=0 ", array(
                ":a" => $userid,
                ":b" => $date
            ));
            die(json_encode(array(
                "success" => true,
                "num" => $num,
                "item" => $templist
            )));
        }
        if ($operation == "game") {
            $rid    = intval($_GPC['id']);
            $openid = $_W['openid'] ? $_W['openid'] : $_GPC['from_user_oauth'];
            if (!$openid)
                die(json_encode(array(
                    'err' => 1,
                    'msg' => '微信登陆才能玩游戏哦~'
                )));
            $play_count = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_lottery') . " WHERE gid=:a and createtime=0 and from_user=:b ", array(
                ":a" => $rid,
                ":b" => $openid
            ));
            if (!$play_count)
                die(json_encode(array(
                    'err' => 1,
                    'msg' => '您已经没有抽奖机会了哦'
                )));
            $gameid = pdo_fetchcolumn("SELECT id FROM " . tablename('j_money_lottery') . " WHERE gid=:a and createtime=0 and from_user=:b order by id asc limit 1", array(
                ":a" => $rid,
                ":b" => $openid
            ));
            $item   = pdo_fetch("SELECT * FROM " . tablename('j_money_lotterygame') . " WHERE id=:a ", array(
                ":a" => $rid
            ));
            $list   = pdo_fetchall("SELECT * FROM " . tablename('j_money_award') . " WHERE gid=:a and renum>0 ORDER BY id asc", array(
                ":a" => $rid
            ));
            if ($item['status'] != 1)
                die(json_encode(array(
                    'err' => 1,
                    'msg' => '游戏已结束了哦'
                )));
            if ($item['starttime'] > TIMESTAMP)
                die(json_encode(array(
                    'err' => 1,
                    'msg' => '游戏还没有开始哦'
                )));
            if ($item['endtime'] < TIMESTAMP)
                die(json_encode(array(
                    'err' => 1,
                    'msg' => '游戏已结束了哦'
                )));
            $prize_arr = array();
            $i         = 1;
            foreach ($list as $row) {
                $data = array(
                    "id" => $i,
                    "sid" => $row['id'],
                    "title" => $row['level'],
                    "is" => $row['isprize'],
                    "deg" => $row['deg'],
                    "probalilty" => $row['probalilty']
                );
                array_push($prize_arr, $data);
                $i++;
            }
            $arr = array();
            foreach ($prize_arr as $key => $val) {
                $arr[$val['id']] = $val['probalilty'];
            }
            $proSum = array_sum($arr);
            $result = "";
            foreach ($arr as $key => $proCur) {
                $randNum = mt_rand(1, $proSum);
                if ($randNum <= $proCur) {
                    $result = $key;
                    break;
                } else {
                    $proSum -= $proCur;
                }
            }
            $res       = $prize_arr[$result - 1];
            $prizeItem = pdo_fetch("SELECT * FROM " . tablename('j_money_award') . " WHERE id = '" . $res['sid'] . "' ");
            if ($res['is'] == 1 && $prizeItem['leavel'] > 0) {
                $countman   = pdo_fetchcolumn("select count(*) FROM " . tablename('j_money_lottery') . " WHERE gid=:a and createtime>0", array(
                    ":a" => $rid
                ));
                $countPrize = pdo_fetchcolumn("select count(*) FROM " . tablename('j_money_lottery') . " where gid=:a and aid='" . $res['sid'] . "' ", array(
                    ":a" => $rid
                ));
                if ($countman < $prizeItem['leavel'] * ($countPrize + 1)) {
                    $other         = pdo_fetch("SELECT * FROM " . tablename('j_money_award') . " WHERE gid = '" . $rid . "' and isprize=0 order by probalilty desc limit 1");
                    $res['sid']    = $other['id'];
                    $res['level']  = $other['level'];
                    $res['title']  = $other['title'];
                    $res['deg']    = $other['deg'];
                    $res['credit'] = $other['credit'];
                    $res['is']     = 0;
                }
            }
            $data       = array(
                'aid' => $res['sid'],
                'award' => $res['title'],
                "isprize" => $res['is'],
                'createtime' => TIMESTAMP
            );
            $res['msg'] = "抱歉，没有抽奖奖品哦~";
            if ($res['is'] == 1) {
                pdo_update('j_money_award', array(
                    'renum' => $prizeItem['renum'] - 1
                ), array(
                    'id' => $res['sid']
                ));
                $cfg = $this->module['config'];
                if (strpos($prizeItem['description'], "|#红包#|")) {
                    $temp     = str_replace("[|#红包#|", "", $prizeItem['description']);
                    $temp     = str_replace("]", "", $temp);
                    $favorAry = explode("-", $temp);
                    $fee      = 0;
                    if (count($favorAry) == 2) {
                        $favorAry1 = intval($favorAry[0] * 100);
                        $favorAry2 = intval($favorAry[1] * 100);
                        if ($favorAry1 >= $favorAry2) {
                            $fee = $favorAry1;
                        } else {
                            $fee = mt_rand($favorAry1, $favorAry2);
                        }
                        $fee               = $fee >= 100 ? $fee : 100;
                        $result            = $this->_sendpack2($openid, $fee, $cfg);
                        $data['prizetype'] = 1;
                        $data['award']     = "微信现金红包";
                        $data['status']    = 1;
                        $data['sncode']    = $fee;
                        if (!$result || $result['errno'] != 0) {
                            $res['msg'] = "恭喜您获得微信现金红包一个<br>" . json_encode($result);
                        } else {
                            $res['msg']      = "恭喜您获得微信现金红包一个";
                            $data['gettime'] = TIMESTAMP;
                        }
                    }
                } elseif (strpos($prizeItem['description'], "|#卡券#|")) {
                    $temp     = str_replace("[|#卡券#|", "", $prizeItem['description']);
                    $temp     = str_replace("]", "", $temp);
                    $favorAry = strpos($temp, ",") ? explode(",", $temp) : array(
                        $temp
                    );
                    shuffle($favorAry);
                    $cardkey = $favorAry[0];
                    $wxcard  = json_decode($cfg['wxcard'], true);
                    if ($wxcard[$cardkey]) {
                        $result = $this->sendCard($openid, $wxcard[$cardkey]);
                        if ($result['errcode'] == 0) {
                            $res['msg']        = "恭喜您获得卡券一张";
                            $data['prizetype'] = 2;
                            $data['award']     = "卡券一张";
                            $data['gettime']   = TIMESTAMP;
                            $data['status']    = 1;
                            $data['sncode']    = $wxcard[$cardkey];
                        } else {
                            $res['msg']        = "恭喜您获得卡券一张，请在公众号发送【兑奖】后，回到本页面领取哦";
                            $data['prizetype'] = 2;
                            $data['award']     = "卡券一张";
                            $data['sncode']    = $wxcard[$cardkey];
                        }
                    }
                } else {
                    $res['msg']        = "恭喜您,抽中了" . $res['title'] . " " . $prizeItem['description'] . "";
                    $data['prizetype'] = 0;
                    $data['sncode']    = $gameid . '-' . getNonceStr(5);
                }
            }
            pdo_update('j_money_lottery', $data, array(
                'id' => $gameid
            ));
            die(json_encode($res));
        }
        if ($operation == "checkcard") {
            $islogin = $_GPC['islogin'];
            if (!$islogin)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            $user = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:id ", array(
                ":id" => $islogin
            ));
            if (!$user)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            $code = $_GPC['code'];
            if (!$code)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "卡券ID不能为空"
                )));
            $cfg = $this->module['config'];
            load()->func('communication');
            $shop       = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['groupid']
            ));
            $acid       = pdo_fetchcolumn("SELECT acid FROM " . tablename('account') . " WHERE uniacid=:uniacid ", array(
                ':uniacid' => $_W['uniacid']
            ));
            $acc        = WeAccount::create($acid);
            $tokens     = $acc->fetch_token();
            $pageparama = json_encode(array(
                "code" => $code
            ));
            $resp       = ihttp_request("https://api.weixin.qq.com/card/code/get?access_token=" . $tokens, $pageparama, $xml);
            if (is_error($resp))
                $procResult = $resp;
            $result = @json_decode($resp['content'], true);
            if ($result['errcode'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "卡券查询失败，原因：" . $result['errmsg']
                )));
            $cardid           = $result['card']['card_id'];
            $begin_time       = $result['card']['begin_time'];
            $end_time         = $result['card']['end_time'];
            $can_consume      = $result['can_consume'];
            $user_card_status = $result['user_card_status'];
            $openid           = $result['openid'];
            if ($begin_time > TIMESTAMP || $end_time < TIMESTAMP)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "该卡券不可用，原因：该卡券使用时间为：" . date("y-m-d H:i", $begin_time) . "-" . date("y-m-d H:i", $end_time)
                )));
            $cardstatus = array(
                "CONSUMED" => "已使用",
                "EXPIRE" => "已过期",
                "GIFT_TIMEOUT" => "转赠超时",
                "DELETE" => "已删除",
                "UNAVAILABLE" => "已失效",
                "invalid serial code" => "已被朋友使用"
            );
            if (!$can_consume) {
                die(json_encode(array(
                    "success" => false,
                    "msg" => $cardstatus[$user_card_status]
                )));
            }
            $coupon = pdo_fetch("SELECT * FROM " . tablename('coupon') . " WHERE uniacid=:a and card_id=:b", array(
                ':a' => $_W['uniacid'],
                ':b' => $cardid
            ));
            if (!$coupon) {
                $coupon     = array();
                $pageparama = json_encode(array(
                    "card_id" => $cardid
                ));
                $resp       = ihttp_request("https://api.weixin.qq.com/card/get?access_token=" . $tokens, $pageparama, $xml);
                if (is_error($resp))
                    die(json_encode(array(
                        "success" => false,
                        "msg" => $resp
                    )));
                $cardinfo          = @json_decode($resp['content'], true);
                $coupon['type']    = strtolower($cardinfo['card']['card_type']);
                $coupon['msg']     = $cardinfo['card'][$coupon['type']]['default_detail'] ? $cardinfo['card'][$coupon['type']]['default_detail'] : $cardinfo['card'][$coupon['type']]['base_info']['description'];
                $coupon['typestr'] = "线上卡券";
            } else {
                switch ($coupon['type']) {
                    case "discount":
                        $coupon["msg"]     = "" . sprintf('%.2f', ($coupon['extra'] / 100)) . "折";
                        $coupon["typestr"] = "折扣券";
                        break;
                    case "cash":
                        $extra             = iunserializer($coupon['extra']);
                        $coupon["msg"]     = "满" . $extra['least_cost'] . "减" . $extra['reduce_cost'];
                        $coupon["typestr"] = "代金券";
                        break;
                    case "gift":
                        $coupon["msg"]     = "" . $coupon['extra'] . "";
                        $coupon["typestr"] = "礼品券";
                        break;
                    case "groupon":
                        $coupon["msg"]     = "" . $coupon['extra'] . "";
                        $coupon["typestr"] = "团购券";
                        break;
                    case "general_coupon":
                        $coupon["msg"]     = "" . $coupon['extra'] . "";
                        $coupon["typestr"] = "优惠券";
                        break;
                }
            }
            $coupon['openid'] = $openid;
            $coupon['code']   = $code;
            die(json_encode(array(
                "success" => true,
                "item" => $coupon
            )));
        }
        if ($operation == "cardcheck") {
            $islogin = $_GPC['islogin'];
            if (!$islogin)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            $user = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:id ", array(
                ":id" => $islogin
            ));
            if (!$user)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "请先登录"
                )));
            $code = $_GPC['code'];
            if (!$code)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "卡券ID不能为空"
                )));
            $cfg = $this->module['config'];
            load()->func('communication');
            $shop       = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['groupid']
            ));
            $acid       = pdo_fetchcolumn("SELECT acid FROM " . tablename('account') . " WHERE uniacid=:uniacid ", array(
                ':uniacid' => $_W['uniacid']
            ));
            $acc        = WeAccount::create($acid);
            $tokens     = $acc->fetch_token();
            $pageparama = json_encode(array(
                "code" => $code
            ));
            $resp       = ihttp_request("https://api.weixin.qq.com/card/code/consume?access_token=" . $tokens, $pageparama, $xml);
            if (is_error($resp)) {
                $procResult = $resp;
            }
            $arr = @json_decode($resp['content'], true);
            if ($arr['errcode'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "核销失败。失败原因：" . json_encode($arr)
                )));
            $cardid = $arr['card']['card_id'];
            $openid = $arr['openid'];
            if (!$cardid || !$openid)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "核销失败。失败原因：" . json_encode($arr)
                )));
            $coupon = pdo_fetch("SELECT * FROM " . tablename('coupon') . " WHERE uniacid=:a and card_id=:b", array(
                ':a' => $_W['uniacid'],
                ':b' => $cardid
            ));
            if ($coupon) {
                $data = array(
                    "weid" => $_W['uniacid'],
                    "openid" => $openid,
                    "userid" => $islogin,
                    "cardid" => $cardid,
                    "code" => $code,
                    "type" => $coupon['type'],
                    "title" => $coupon['title'],
                    "sub_title" => $coupon['sub_title'],
                    "description" => $coupon['description'],
                    "extra" => $coupon['extra'],
                    "createtime" => TIMESTAMP
                );
            } else {
                $pageparama = json_encode(array(
                    "card_id" => $cardid
                ));
                $resp       = ihttp_request("https://api.weixin.qq.com/card/get?access_token=" . $tokens, $pageparama, $xml);
                if (is_error($resp))
                    die(json_encode(array(
                        "success" => false,
                        "msg" => $resp
                    )));
                $cardinfo = @json_decode($resp['content'], true);
                $cardtype = strtolower($cardinfo['card']['card_type']);
                $c_info   = $cardinfo['card'][$cardtype]['base_info'];
                $data     = array(
                    "weid" => $_W['uniacid'],
                    "openid" => $openid,
                    "userid" => $islogin,
                    "cardid" => $cardid,
                    "code" => $code,
                    "createtime" => TIMESTAMP,
                    "type" => strtolower($cardinfo['card']['card_type']),
                    "title" => $c_info['title'],
                    "sub_title" => $c_info['sub_title'],
                    "description" => $cardinfo['card'][$cardtype]['default_detail'],
                    "extra" => ''
                );
            }
            pdo_insert("j_money_carduser", $data);
            $data['id'] = pdo_insertid();
            $num        = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_carduser') . " WHERE userid=:a and createtime>=:b and createtime<=:c", array(
                ':a' => $islogin,
                ':b' => strtotime(date("Y-m-d 00:00:00")),
                ':c' => strtotime(date("Y-m-d 23:59:59"))
            ));
            die(json_encode(array(
                "success" => true,
                "item" => $data,
                "num" => $num
            )));
        }
        if ($operation == "tempmsg") {
            $orderid = $_GPC["orderid"];
            if (!$orderid)
                die("订单号不能为空");
            $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            if ($trade['sub_openid']) {
                if (!$trade['sub_is_subscribe'])
                    die('没有关注，发送失败');
            } else {
                if (!$trade['is_subscribe'])
                    die('没有关注，发送失败');
            }
            $temstr  = urldecode($cfg['tempparama']);
            $tempstr = str_replace("|#单号#|", $trade['out_trade_no'], $temstr);
            $tempstr = str_replace("|#时间#|", date("y-m-d H:i", $trade['time_end']), $tempstr);
            $tempstr = str_replace("|#总金额#|", "￥" . sprintf('%.2f', ($trade['total_fee'] / 100)) . "元", $tempstr);
            $tempstr = str_replace("|#优惠金额#|", "￥" . sprintf('%.2f', ($trade['coupon_fee'] / 100)) . "元", $tempstr);
            $tempstr = str_replace("|#实付金额#|", "￥" . sprintf('%.2f', ($trade['cash_fee'] / 100)) . "元", $tempstr);
            $tempstr = str_replace("|#支付方式#|", "微信支付", $tempstr);
            if ($trade['marketing']) {
                $marking = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE id=:a ", array(
                    ":a" => $trade['marketing']
                ));
                if ($marking['description']) {
                    $tempstr = str_replace("|#优惠#|", $marking['description'], $tempstr);
                }
            }
            $tempstr = str_replace("|#优惠#|", '', $tempstr);
            $itemary = json_decode($tempstr, true);
            $temp    = array();
            foreach ($itemary as $key => $val) {
                $temp[$key] = array(
                    "value" => $val['value'],
                    "color" => $val['color'] ? $val['color'] : "#333333"
                );
            }
            $url = $cfg["tempurl"];
            if ($marking['favorabletype'] == 4) {
                $gamestatus = pdo_fetchcolumn("SELECT status FROM " . tablename('j_money_lotterygame') . " WHERE id=:a ", array(
                    ":a" => $marking['gid']
                ));
                if ($gamestatus == 1) {
                    $temp['remark']["value"] = "您获得抽奖机会哦，请点击本详情进入抽奖";
                    $url                     = $_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&id=" . $marking['gid'] . "&do=game&m=j_money";
                }
            }
            $acid   = pdo_fetchcolumn("SELECT acid FROM " . tablename('account') . " WHERE uniacid=:uniacid ", array(
                ':uniacid' => $_W['uniacid']
            ));
            $acc    = WeAccount::create($acid);
            $openid = $trade['sub_openid'] ? $trade['sub_openid'] : $trade['openid'];
            $data   = $acc->sendTplNotice($openid, $cfg["tempid"], $temp, $url, "#FF0000");
            $result = json_decode($data, true);
            if ($result['errcode'] != 0) {
                pdo_update("j_money_trade", array(
                    "log" => $data
                ), array(
                    "out_trade_no" => $orderid
                ));
            }
            die(json_encode($data));
        }
        if ($operation == "mobilemore") {
            $userOpenid = $_W['openid'] ? $_W['openid'] : die(json_encode(array(
                "success" => false
            )));
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and openid=:openid ", array(
                ":openid" => $userOpenid
            ));
            $pindex     = intval($_GPC['page']) ? intval($_GPC['page']) - 1 : 0;
            $psize      = 5;
            $start      = $pindex * $psize;
            $date       = $_GPC['date'] ? $_GPC['date'] : date("Y-m-d");
            $list       = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createdate=:b and attach<>'-' and attach<>'PC' order by id desc LIMIT " . $start . "," . $psize, array(
                ":a" => $user['id'],
                ":b" => $date
            ));
            $total      = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createdate=:b and attach<>'-' and attach<>'PC' ", array(
                ":a" => $user['id'],
                ":b" => date("Y-m-d")
            ));
            if (count($list)) {
                die(json_encode(array(
                    "success" => true,
                    "item" => $list
                )));
            } else {
                die(json_encode(array(
                    "success" => false
                )));
            }
        }
        if ($operation == "refundorder") {
            $orderid = $_GPC["orderid"];
            if (!$orderid)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "订单号不能为空"
                )));
            $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            if (!$trade)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "订单号不能为空"
                )));
            if (!$trade['status'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "该订单没有付款"
                )));
            if ($trade['refundstatus'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "该订单已退款"
                )));
            $shop = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $trade['groupid']
            ));
            if (!$cfg['refunder'] && !$shop['refunder'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "无退款处理人"
                )));
            $refund_trade_no = TIMESTAMP;
            pdo_update("j_money_trade", array(
                "refund_fee" => $trade['cash_fee'],
                "refund_trade_no" => TIMESTAMP
            ), array(
                "out_trade_no" => $orderid
            ));
            $acid   = pdo_fetchcolumn("SELECT acid FROM " . tablename('account') . " WHERE uniacid=:uniacid ", array(
                ':uniacid' => $_W['uniacid']
            ));
            $acc    = WeAccount::create($acid);
            $url    = $_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=refund&m=j_money&orderid=" . $orderid;
            $temp   = array(
                "first" => array(
                    "value" => "您有新的退款要处理",
                    "color" => "#FF0000"
                ),
                "orderProductPrice" => array(
                    "value" => sprintf('%.2f', ($trade['cash_fee'] / 100)),
                    "color" => "#FF0000"
                ),
                "orderProductName" => array(
                    "value" => "电脑端退款申请",
                    "color" => "#333333"
                ),
                "orderName" => array(
                    "value" => $orderid,
                    "color" => "#333333"
                ),
                "remark" => array(
                    "value" => "请点击此信息进行退款操作",
                    "color" => "#333333"
                )
            );
            $data   = $acc->sendTplNotice($shop['refunder'] ? $shop['refunder'] : $cfg['refunder'], $cfg["tempid2"], $temp, $url, "#FF0000");
            $result = json_decode($data, true);
            die(json_encode(array(
                "success" => true
            )));
        }
        if ($operation == "refundexcute") {
            $orderid = $_GPC["orderid"];
            if (!$orderid)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "订单号不能为空"
                )));
            if (!$_W['openid'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "无退款处理人"
                )));
            $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            if (!$trade)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "订单号不能为空"
                )));
            if (!$trade['status'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "该订单没有付款"
                )));
            if ($trade['refundstatus'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "该订单已退款"
                )));
            if (!$cfg['refunder'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "无退款处理人"
                )));
            if ($cfg['refunder'] != $_W['openid'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "非法登陆"
                )));
            $shop       = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $trade['groupid']
            ));
            $payParama  = array(
                "appid" => $shop['appid'] ? $shop['appid'] : $cfg['appid'],
                "pay_mchid" => strval($shop['pay_mchid']) ? strval($shop['pay_mchid']) : strval($cfg['pay_mchid']),
                "pay_signkey" => $shop['pay_signkey'] ? $shop['pay_signkey'] : $cfg['pay_signkey'],
                "pay_ip" => $shop['pay_ip'] ? $shop['pay_ip'] : $cfg['pay_ip'],
                "sub_appid" => $shop['sub_appid'] ? $shop['sub_appid'] : $cfg['sub_appid'],
                "sub_mch_id" => $shop['sub_mch_id'] ? strval($shop['sub_mch_id']) : strval($cfg['sub_mch_id']),
                "apiclient_cert" => $shop['apiclient_cert'] ? '../attachment/j_money/cert_2/' . $_W['uniacid'] . "/" . $trade['groupid'] . "/" . $shop['apiclient_cert'] : '../attachment/j_money/cert_2/' . $_W['uniacid'] . "/" . $cfg['apiclient_cert'],
                "apiclient_key" => $shop['apiclient_key'] ? '../attachment/j_money/cert_2/' . $_W['uniacid'] . "/" . $trade['groupid'] . "/" . $shop['apiclient_key'] : '../attachment/j_money/cert_2/' . $_W['uniacid'] . "/" . $cfg['apiclient_key']
            );
            $pageparama = array(
                "appid" => $payParama['appid'],
                "mch_id" => $payParama['pay_mchid'],
                "device_info" => $trade['userid'],
                "nonce_str" => getNonceStr(),
                "out_trade_no" => $orderid,
                "out_refund_no" => $trade['refund_trade_no'],
                "total_fee" => $trade['cash_fee'],
                "refund_fee" => $trade['refund_fee'],
                "op_user_id" => $trade['userid']
            );
            if ($payParama['sub_appid'])
                $pageparama['sub_appid'] = $payParama['sub_appid'];
            if ($payParama['sub_mch_id'])
                $pageparama['sub_mch_id'] = $payParama['sub_mch_id'];
            $sign               = MakeSign($pageparama, $payParama['pay_signkey']);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $pemary             = array(
                "cert" => $payParama['apiclient_cert'],
                "key" => $payParama['apiclient_key']
            );
            $response           = postXmlAndPemCurl($xml, "https://api.mch.weixin.qq.com/secapi/pay/refund", $pemary);
            $result             = FromXml($response);
            if ($result['return_code'] != 'SUCCESS') {
                pdo_update("j_money_trade", array(
                    "log" => "退款失败：" . $result['return_msg']
                ), array(
                    "out_trade_no" => $orderid
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['return_msg']
                )));
            }
            pdo_update("j_money_trade", array(
                "refundstatus" => 1,
                "refundtime" => TIMESTAMP,
                "status" => 2
            ), array(
                "out_trade_no" => $orderid
            ));
            die(json_encode(array(
                "success" => true
            )));
        }
        if ($operation == "checkrefundorder") {
            $orderid = $_GPC["orderid"];
            if (!$orderid)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "订单号不能为空"
                )));
            $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $orderid
            ));
            if (!$trade)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "订单号不能为空"
                )));
            $pageparama = array(
                "appid" => $cfg['appid'],
                "mch_id" => strval($cfg['pay_mchid']),
                "device_info" => $trade['userid'],
                "nonce_str" => getNonceStr(),
                "out_trade_no" => $orderid
            );
            if ($cfg['sub_appid']) {
                $pageparama['sub_appid'] = $cfg['sub_appid'];
            }
            if ($cfg['sub_mch_id']) {
                $pageparama['sub_mch_id'] = $cfg['sub_mch_id'];
            }
            $sign               = MakeSign($pageparama, $cfg['pay_signkey']);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/refundquery", 10);
            $result             = FromXml($response);
            if ($result['return_code'] != 'SUCCESS') {
                pdo_update("j_money_trade", array(
                    "log" => "退款失败：" . $result['return_msg']
                ), array(
                    "out_trade_no" => $orderid
                ));
                die(json_encode(array(
                    "success" => false,
                    "msg" => $result['return_msg']
                )));
            }
            if ($result['result_code'] == 'SUCCESS') {
                pdo_update("j_money_trade", array(
                    "refundstatus" => 1,
                    "refundtime" => TIMESTAMP,
                    "status" => 2
                ), array(
                    "out_trade_no" => $orderid
                ));
                die(json_encode(array(
                    "success" => true,
                    "status" => 1
                )));
            } else {
                die(json_encode(array(
                    "success" => true,
                    "status" => 0
                )));
            }
        }
        if ($operation == "share2friend") {
            $id   = $_GPC['id'];
            $item = pdo_fetch("SELECT * FROM " . tablename('j_money_article') . " WHERE id =:id and weid=:a", array(
                ':id' => $id,
                ':a' => $_W['uniacid']
            ));
            if (!$item)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "error"
                )));
            pdo_update("j_money_article", array(
                "sharecount" => $item['sharecount'] + 1
            ), array(
                "id" => $id
            ));
            if (!$item['status'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "活动已关闭或暂停"
                )));
            if (TIMESTAMP < $item['starttime'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "活动还没有开始"
                )));
            if (TIMESTAMP > $item['endtime'])
                die(json_encode(array(
                    "success" => false,
                    "msg" => "活动已结束了哦"
                )));
            $openid = $_W["openid"] ? $_W["openid"] : $_GPC["from_user_oauth"];
            if (!$openid)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "openid error"
                )));
            $isGet = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_view') . " WHERE aid=:id and openid=:a", array(
                ':id' => $id,
                ':a' => $openid
            ));
            if ($isGet)
                die(json_encode(array(
                    "success" => false,
                    "msg" => "您已经领取过了哦"
                )));
            $data = array(
                "weid" => $_W['uniacid'],
                "aid" => $id,
                "openid" => $openid,
                "status" => 1,
                "prizetype" => $item['prizetype'],
                "favorable" => $item['favorable'],
                "createtime" => TIMESTAMP
            );
            pdo_insert("j_money_view", $data);
            die(json_encode(array(
                "success" => true
            )));
        }
    }
    public function doMobileRefund()
    {
        global $_GPC, $_W;
        $orderid = $_GPC["orderid"];
        if (!$_W['openid'] || !$orderid)
            message("非法登陆");
        $cfg = $this->module['config'];
        if ($cfg['refunder'] != $_W['openid'])
            message("非法登陆");
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $trade     = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
            ":a" => $orderid
        ));
        include $this->template('refund');
    }
    public function doMobileIndex()
    {
        global $_GPC, $_W;
        $ismobile = isMobile();
        if ($ismobile || $_W['openid']) {
            header("location:" . $this->createMobileUrl("mobile"));
            exit();
        }
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $cfg       = $this->module['config'];
        if ($operation == 'display') {
            isetcookie('islogin', '', -1);
            if ($cfg['login_pc_type'] == 1) {
                $qrcode = $_GPC['qrcodes'];
                if (!$qrcode) {
                    $qrcode = TIMESTAMP;
                    $data   = array(
                        "weid" => $_W['uniacid'],
                        "sncode" => $qrcode,
                        "createtime" => TIMESTAMP
                    );
                    pdo_insert("j_money_qrlogin", $data);
                    isetcookie('qrcodes', $qrcode, 300);
                }
                $url = urlencode($_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=login&m=j_money&qrcode=" . $qrcode);
            }
        } else {
            $islogin = $_GPC['islogin'];
            if (!$islogin) {
                header("Location:" . $this->createMobileUrl("index"));
                exit();
            }
            $user = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:id ", array(
                ":id" => $islogin
            ));
            if (!$user || !$user['status'])
                message("用户不存在或没有权限");
            if (!$user['login_pc'] || !$user['login_m']) {
                if (!$user['login_pc']) {
                    if (!$ismobile)
                        message("您的账号禁止在电脑端登录！");
                }
                if (!$user['login_m']) {
                    if ($ismobile)
                        message("您的账号禁止在移动端登录！");
                }
            }
            $shop      = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $user['pcate']
            ));
            $group     = pdo_fetchcolumn("SELECT companyname FROM " . tablename('j_money_group') . " WHERE id=:a", array(
                ":a" => $user['pcate']
            ));
            $marketing = pdo_fetchall("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:c and status=1 and starttime<=:a and endtime>=:b order by displayorder asc ,id desc", array(
                ":a" => TIMESTAMP,
                ":b" => TIMESTAMP,
                ":c" => $user['pcate']
            ));
            $printDoc  = $shop['payreceipt'] ? $shop['payreceipt'] : pdo_fetchcolumn("SELECT id FROM " . tablename('j_money_print') . " WHERE weid='{$_W['uniacid']}' and pcate=0 order by isdefault desc,id desc limit 1 ");
            $printDoc2 = $shop['couponreceipt'] ? $shop['couponreceipt'] : pdo_fetchcolumn("SELECT id FROM " . tablename('j_money_print') . " WHERE weid='{$_W['uniacid']}' and pcate=1 order by isdefault desc,id desc limit 1 ");
            $btnlist   = pdo_fetchall("SELECT * FROM " . tablename('j_money_extend') . " WHERE weid='{$_W['uniacid']}' and status=1 order by id asc ");
        }
        if ($_GPC['small']) {
            include $this->template('indexsmall');
        } else {
            include $this->template('index');
        }
    }
    public function doMobileCounthistory()
    {
        global $_GPC, $_W;
        $islogin = $_GPC['islogin'];
        if (!$islogin) {
            header("Location:" . $this->createMobileUrl("index"));
            exit();
        }
        $userinfo  = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:id ", array(
            ":id" => $islogin
        ));
        $groupname = pdo_fetchcolumn("SELECT companyname FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:id ", array(
            ":id" => $userinfo['pcate']
        ));
        $where2    = " and groupid='" . $userinfo['pcate'] . "' ";
        $where     = $_GPC['date'] ? " and createdate='" . $_GPC['date'] . "'" : " and createdate like '%" . date('Y-m') . "%'";
        if ($_GPC['userid'])
            $where .= " and userid='" . intval($_GPC['userid']) . "'";
        $pindex  = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
        $psize   = 10;
        $start   = ($pindex - 1) * $psize;
        $list    = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}'  $where $where2 order by id desc LIMIT " . $start . "," . $psize);
        $total   = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='" . $_W['uniacid'] . "'  $where $where2");
        $pager   = pagination($total, $pindex, $psize);
        $allItem = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}'  $where $where2 ");
        foreach ($allItem as $row) {
            if ($row['status'] == 1) {
                if ($row['total_fee']) {
                    if (!$row['paytype']) {
                        $payAry['wechart']['all']       = $payAry['wechart']['all'] + $row['total_fee'];
                        $payAry['wechart']['all-count'] = $payAry['wechart']['all-count'] + 1;
                    } else {
                        $payAry['alipay']['all']       = $payAry['alipay']['all'] + $row['total_fee'];
                        $payAry['alipay']['all-count'] = $payAry['alipay']['all-count'] + 1;
                    }
                }
                if ($row['coupon_fee']) {
                    if (!$row['paytype']) {
                        $payAry['wechart']['coupon']       = $payAry['wechart']['coupon'] + $row['coupon_fee'];
                        $payAry['wechart']['coupon-count'] = $payAry['wechart']['coupon-count'] + 1;
                    } else {
                        $payAry['alipay']['coupon']       = $payAry['alipay']['coupon'] + $row['coupon_fee'];
                        $payAry['alipay']['coupon-count'] = $payAry['alipay']['coupon-count'] + 1;
                    }
                }
                if ($row['cash_fee']) {
                    if (!$row['paytype']) {
                        $payAry['wechart']['cash_fee']       = $payAry['wechart']['cash_fee'] + $row['cash_fee'];
                        $payAry['wechart']['cash_fee-count'] = $payAry['wechart']['cash_fee-count'] + 1;
                    } else {
                        $payAry['alipay']['cash_fee']       = $payAry['alipay']['cash_fee'] + $row['cash_fee'];
                        $payAry['alipay']['cash_fee-count'] = $payAry['alipay']['cash_fee-count'] + 1;
                    }
                }
            }
        }
        $datelist = pdo_fetchall("SELECT createdate FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}'  group by createdate order by id desc  ");
        $user     = pdo_fetchall("SELECT * FROM " . tablename('j_money_user') . " WHERE weid = '{$_W['uniacid']}' and pcate=:a order by id desc", array(
            ":a" => $userinfo['pcate']
        ));
        $userList = array();
        foreach ($user as $row) {
            $userList[$row['id']] = $row['realname'];
        }
        $data = array(
            "CFT" => "零钱包",
            "ICBC_DEBIT" => "工商银行(借记卡)",
            "ICBC_CREDIT" => "工商银行(信用卡)",
            "ABC_DEBIT" => "农业银行(借记卡)",
            "ABC_CREDIT" => "农业银行(信用卡)",
            "PSBC_DEBIT" => "邮政储蓄银行(借记卡)",
            "PSBC_CREDIT" => "邮政储蓄银行(信用卡)",
            "CCB_DEBIT" => "建设银行(借记卡)",
            "CCB_CREDIT" => "建设银行(信用卡)",
            "CMB_DEBIT" => "招商银行(借记卡)",
            "CMB_CREDIT" => "招商银行(信用卡)",
            "BOC_DEBIT" => "中国银行(借记卡)",
            "BOC_CREDIT" => "中国银行(信用卡)",
            "COMM_DEBIT" => "交通银行(借记卡)",
            "SPDB_DEBIT" => "浦发银行(借记卡)",
            "SPDB_CREDIT" => "浦发银行(信用卡)",
            "GDB_DEBIT" => "广发银行(借记卡)",
            "GDB_CREDIT" => "广发银行(信用卡)",
            "CMBC_DEBIT" => "民生银行(借记卡)",
            "CMBC_CREDIT" => "民生银行(信用卡)",
            "PAB_DEBIT" => "平安银行(借记卡)",
            "PAB_CREDIT" => "平安银行(信用卡)",
            "CEB_DEBIT" => "光大银行(借记卡)",
            "CEB_CREDIT" => "光大银行(信用卡)",
            "CIB_DEBIT" => "兴业银行(借记卡)",
            "CIB_CREDIT" => "兴业银行(信用卡)",
            "CITIC_DEBIT" => "中信银行(借记卡)",
            "CITIC_CREDIT" => "中信银行(信用卡)",
            "BOSH_DEBIT" => "上海银行(借记卡)",
            "BOSH_CREDIT" => "上海银行(信用卡)",
            "CRB_DEBIT" => "华润银行(借记卡)",
            "HZB_DEBIT" => "杭州银行(借记卡)",
            "HZB_CREDIT" => "杭州银行(信用卡)",
            "BSB_DEBIT" => "包商银行(借记卡)",
            "BSB_CREDIT" => "包商银行(信用卡)",
            "CQB_DEBIT" => "重庆银行(借记卡)",
            "SDEB_DEBIT" => "顺德农商行(借记卡)",
            "SZRCB_DEBIT" => "深圳农商银行(借记卡)",
            "HRBB_DEBIT" => "哈尔滨银行(借记卡)",
            "BOCD_DEBIT" => "成都银行(借记卡)",
            "GDNYB_DEBIT" => "南粤银行(借记卡)",
            "GDNYB_CREDIT" => "南粤银行(信用卡)",
            "GZCB_DEBIT" => "广州银行(借记卡)",
            "GZCB_CREDIT" => "广州银行(信用卡)",
            "JSB_DEBIT" => "江苏银行(借记卡)",
            "JSB_CREDIT" => "江苏银行(信用卡)",
            "NBCB_DEBIT" => "宁波银行(借记卡)",
            "NBCB_CREDIT" => "宁波银行(信用卡)",
            "NJCB_DEBIT" => "南京银行(借记卡)",
            "JZB_DEBIT" => "晋中银行(借记卡)",
            "KRCB_DEBIT" => "昆山农商(借记卡)",
            "LJB_DEBIT" => "龙江银行(借记卡)",
            "LNNX_DEBIT" => "辽宁农信(借记卡)",
            "LZB_DEBIT" => "兰州银行(借记卡)",
            "WRCB_DEBIT" => "无锡农商(借记卡)",
            "ZYB_DEBIT" => "中原银行(借记卡)",
            "ZJRCUB_DEBIT" => "浙江农信(借记卡)",
            "WZB_DEBIT" => "温州银行(借记卡)",
            "XAB_DEBIT" => "西安银行(借记卡)",
            "JXNXB_DEBIT" => "江西农信(借记卡)",
            "NCB_DEBIT" => "宁波通商银行(借记卡)",
            "NYCCB_DEBIT" => "南阳村镇银行(借记卡)",
            "NMGNX_DEBIT" => "内蒙古农信(借记卡)",
            "SXXH_DEBIT" => "陕西信合(借记卡)",
            "SRCB_CREDIT" => "上海农商银行(信用卡)",
            "SJB_DEBIT" => "盛京银行(借记卡)",
            "SDRCU_DEBIT" => "山东农信(借记卡)",
            "SRCB_DEBIT" => "上海农商银行(借记卡)",
            "SCNX_DEBIT" => "四川农信(借记卡)",
            "QLB_DEBIT" => "齐鲁银行(借记卡)",
            "QDCCB_DEBIT" => "青岛银行(借记卡)",
            "PZHCCB_DEBIT" => "攀枝花银行(借记卡)",
            "ZJTLCB_DEBIT" => "浙江泰隆银行(借记卡)",
            "TJBHB_DEBIT" => "天津滨海农商行(借记卡)",
            "WEB_DEBIT" => "微众银行(借记卡)",
            "YNRCCB_DEBIT" => "云南农信(借记卡)",
            "WFB_DEBIT" => "潍坊银行(借记卡)",
            "WHRC_DEBIT" => "武汉农商行(借记卡)",
            "ORDOSB_DEBIT" => "鄂尔多斯银行(借记卡)",
            "XJRCCB_DEBIT" => "新疆农信银行(借记卡)",
            "ORDOSB_CREDIT" => "鄂尔多斯银行(信用卡)",
            "CSRCB_DEBIT" => "常熟农商银行(借记卡)",
            "JSNX_DEBIT" => "江苏农商行(借记卡)",
            "GRCB_CREDIT" => "广州农商银行(信用卡)",
            "GLB_DEBIT" => "桂林银行(借记卡)",
            "GDRCU_DEBIT" => "广东农信银行(借记卡)",
            "GDHX_DEBIT" => "广东华兴银行(借记卡)",
            "FJNX_DEBIT" => "福建农信银行(借记卡)",
            "DYCCB_DEBIT" => "德阳银行(借记卡)",
            "DRCB_DEBIT" => "东莞农商行(借记卡)",
            "CZCB_DEBIT" => "稠州银行(借记卡)",
            "CZB_DEBIT" => "浙商银行(借记卡)",
            "CZB_CREDIT" => "浙商银行(信用卡)",
            "GRCB_DEBIT" => "广州农商银行(借记卡)",
            "CSCB_DEBIT" => "长沙银行(借记卡)",
            "CQRCB_DEBIT" => "重庆农商银行(借记卡)",
            "CBHB_DEBIT" => "渤海银行(借记卡)",
            "BOIMCB_DEBIT" => "内蒙古银行(借记卡)",
            "BOD_DEBIT" => "东莞银行(借记卡)",
            "BOD_CREDIT" => "东莞银行(信用卡)",
            "BOB_DEBIT" => "北京银行(借记卡)",
            "BNC_DEBIT" => "江西银行(借记卡)",
            "BJRCB_DEBIT" => "北京农商行(借记卡)",
            "AE_CREDIT" => "AE(信用卡)",
            "GYCB_CREDIT" => "贵阳银行(信用卡)",
            "JSHB_DEBIT" => "晋商银行(借记卡)",
            "JRCB_DEBIT" => "江阴农商行(借记卡)",
            "JNRCB_DEBIT" => "江南农商(借记卡)",
            "JLNX_DEBIT" => "吉林农信(借记卡)",
            "JLB_DEBIT" => "吉林银行(借记卡)",
            "JJCCB_DEBIT" => "九江银行(借记卡)",
            "HXB_DEBIT" => "华夏银行(借记卡)",
            "HXB_CREDIT" => "华夏银行(信用卡)",
            "HUNNX_DEBIT" => "湖南农信(借记卡)",
            "HSB_DEBIT" => "徽商银行(借记卡)",
            "HSBC_DEBIT" => "恒生银行(借记卡)",
            "HRXJB_DEBIT" => "华融湘江银行(借记卡)",
            "HNNX_DEBIT" => "河南农信(借记卡)",
            "HKBEA_DEBIT" => "东亚银行(借记卡)",
            "HEBNX_DEBIT" => "河北农信(借记卡)",
            "HBNX_DEBIT" => "湖北农信(借记卡)",
            "HBNX_CREDIT" => "湖北农信(信用卡)",
            "GYCB_DEBIT" => "贵阳银行(借记卡)",
            "GSNX_DEBIT" => "甘肃农信(借记卡)",
            "JCB_CREDIT" => "JCB(信用卡)",
            "MASTERCARD_CREDIT" => "MASTERCARD(信用卡)",
            "VISA_CREDIT" => "VISA(信用卡)"
        );
        include $this->template('history');
    }
    public function doMobileMobile()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $cfg       = $this->module['config'];
        $isLogin   = $_GPC['islogin'];
        if ($operation == "paysuccess") {
            $tradeid = $_GPC['tradeid'];
            if (!$tradeid)
                message("无数据请求", $this->createMobileUrl('mobile'));
            $trade    = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
                ":a" => $tradeid
            ));
            $list     = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createdate=:b and status>0 and isprint=0 order by id desc limit 0,10", array(
                ":a" => $userid,
                ":b" => $date
            ));
            $i        = 0;
            $templist = array();
            foreach ($list as $row) {
                if ($i < 10) {
                    $templist[$i]               = $row;
                    $templist[$i]['paytype']    = $row['paytype'] ? "支付宝" : "微信";
                    $templist[$i]['createtime'] = date("H:i", $row['createtime']);
                    $templist[$i]['total_fee']  = sprintf('%.2f', ($row['total_fee'] / 100));
                    $templist[$i]['coupon_fee'] = sprintf('%.2f', ($row['coupon_fee'] / 100));
                    $templist[$i]['cash_fee']   = sprintf('%.2f', ($row['cash_fee'] / 100));
                }
                $i++;
            }
            $num = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createdate=:b and status=1 and isprint=0 ", array(
                ":a" => $userid,
                ":b" => $date
            ));
            include $this->template('mobilepayseccess');
            exit();
        } elseif ($operation == "history") {
            $userOpenid = $_W['openid'] ? $_W['openid'] : message("非法登陆");
            $user       = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and openid=:openid ", array(
                ":openid" => $userOpenid
            ));
            $date       = $_GPC['date'] ? $_GPC['date'] : date("Y-m-d");
            $list       = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createdate=:b and attach<>'-' and attach<>'PC' order by id desc limit 0,5", array(
                ":a" => $user['id'],
                ":b" => $date
            ));
            $num        = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and userid=:a and createdate=:b and attach<>'-' and attach<>'PC' ", array(
                ":a" => $user['id'],
                ":b" => $date
            ));
            include $this->template('mobilehistory');
            exit();
        } elseif ($operation == "login") {
            if ($isLogin) {
                header("location:" . $this->createMobileUrl("mobile"));
                exit();
            }
            $userOpenid = $_W['openid'] ? $_W['openid'] : message("非法登陆");
            if (!$cfg['login_m_type']) {
                $user = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and openid=:openid ", array(
                    ":openid" => $userOpenid
                ));
                if (!$user['login_m'])
                    message("您的账号禁止在移动端登录！");
                isetcookie('islogin', $user['id'], 3600 * $cfg['cookiehold']);
                header("location:" . $this->createMobileUrl("mobile"));
                exit();
            }
        } else {
            if (!$isLogin) {
                header("location:" . $this->createMobileUrl("mobile", array(
                    "op" => "login"
                )));
                exit();
            }
            $user = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:id ", array(
                ":id" => $isLogin
            ));
            if (!$user || !$user['status'])
                message("抱歉您的账号暂时无法使用");
            $group     = pdo_fetchcolumn("SELECT companyname FROM " . tablename('j_money_group') . " WHERE id=:a", array(
                ":a" => $user['pcate']
            ));
            $marketing = pdo_fetchall("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and groupid=:c and status=1 and starttime<=:a and endtime>=:b order by displayorder asc ,id desc", array(
                ":a" => TIMESTAMP,
                ":b" => TIMESTAMP,
                ":c" => $user['pcate']
            ));
        }
        include $this->template('mobile');
    }
    public function doMobilePrinter()
    {
        global $_GPC, $_W;
        $islogin = $_GPC['islogin'];
        if (!$islogin)
            die("请先登录");
        $id      = $_GPC['id'];
        $pcate   = intval($_GPC['cid']);
        $tradeid = $_GPC['tradeid'];
        $trade   = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a ", array(
            ":a" => $tradeid
        ));
        $shop    = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
            ":a" => $trade['groupid']
        ));
        if ($shop['payreceipt'] && !$pcate)
            $id = $shop['payreceipt'];
        if ($shop['couponreceipt'] && $pcate)
            $id = $shop['couponreceipt'];
        $print = pdo_fetch("SELECT * FROM " . tablename('j_money_print') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
            ":a" => $id
        ));
        $user  = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and id=:id and status=1", array(
            ":id" => $islogin
        ));
        if (!$print)
            die('1');
        if (!$user)
            die('2');
        if (!$trade)
            die('3');
        $cfg = $this->module['config'];
        if (!$pcate) {
            $data     = array(
                "CFT" => "零钱包",
                "ICBC_DEBIT" => "工商银行(借记卡)",
                "ICBC_CREDIT" => "工商银行(信用卡)",
                "ABC_DEBIT" => "农业银行(借记卡)",
                "ABC_CREDIT" => "农业银行(信用卡)",
                "PSBC_DEBIT" => "邮政储蓄银行(借记卡)",
                "PSBC_CREDIT" => "邮政储蓄银行(信用卡)",
                "CCB_DEBIT" => "建设银行(借记卡)",
                "CCB_CREDIT" => "建设银行(信用卡)",
                "CMB_DEBIT" => "招商银行(借记卡)",
                "CMB_CREDIT" => "招商银行(信用卡)",
                "BOC_DEBIT" => "中国银行(借记卡)",
                "BOC_CREDIT" => "中国银行(信用卡)",
                "COMM_DEBIT" => "交通银行(借记卡)",
                "SPDB_DEBIT" => "浦发银行(借记卡)",
                "SPDB_CREDIT" => "浦发银行(信用卡)",
                "GDB_DEBIT" => "广发银行(借记卡)",
                "GDB_CREDIT" => "广发银行(信用卡)",
                "CMBC_DEBIT" => "民生银行(借记卡)",
                "CMBC_CREDIT" => "民生银行(信用卡)",
                "PAB_DEBIT" => "平安银行(借记卡)",
                "PAB_CREDIT" => "平安银行(信用卡)",
                "CEB_DEBIT" => "光大银行(借记卡)",
                "CEB_CREDIT" => "光大银行(信用卡)",
                "CIB_DEBIT" => "兴业银行(借记卡)",
                "CIB_CREDIT" => "兴业银行(信用卡)",
                "CITIC_DEBIT" => "中信银行(借记卡)",
                "CITIC_CREDIT" => "中信银行(信用卡)",
                "BOSH_DEBIT" => "上海银行(借记卡)",
                "BOSH_CREDIT" => "上海银行(信用卡)",
                "CRB_DEBIT" => "华润银行(借记卡)",
                "HZB_DEBIT" => "杭州银行(借记卡)",
                "HZB_CREDIT" => "杭州银行(信用卡)",
                "BSB_DEBIT" => "包商银行(借记卡)",
                "BSB_CREDIT" => "包商银行(信用卡)",
                "CQB_DEBIT" => "重庆银行(借记卡)",
                "SDEB_DEBIT" => "顺德农商行(借记卡)",
                "SZRCB_DEBIT" => "深圳农商银行(借记卡)",
                "HRBB_DEBIT" => "哈尔滨银行(借记卡)",
                "BOCD_DEBIT" => "成都银行(借记卡)",
                "GDNYB_DEBIT" => "南粤银行(借记卡)",
                "GDNYB_CREDIT" => "南粤银行(信用卡)",
                "GZCB_DEBIT" => "广州银行(借记卡)",
                "GZCB_CREDIT" => "广州银行(信用卡)",
                "JSB_DEBIT" => "江苏银行(借记卡)",
                "JSB_CREDIT" => "江苏银行(信用卡)",
                "NBCB_DEBIT" => "宁波银行(借记卡)",
                "NBCB_CREDIT" => "宁波银行(信用卡)",
                "NJCB_DEBIT" => "南京银行(借记卡)",
                "JZB_DEBIT" => "晋中银行(借记卡)",
                "KRCB_DEBIT" => "昆山农商(借记卡)",
                "LJB_DEBIT" => "龙江银行(借记卡)",
                "LNNX_DEBIT" => "辽宁农信(借记卡)",
                "LZB_DEBIT" => "兰州银行(借记卡)",
                "WRCB_DEBIT" => "无锡农商(借记卡)",
                "ZYB_DEBIT" => "中原银行(借记卡)",
                "ZJRCUB_DEBIT" => "浙江农信(借记卡)",
                "WZB_DEBIT" => "温州银行(借记卡)",
                "XAB_DEBIT" => "西安银行(借记卡)",
                "JXNXB_DEBIT" => "江西农信(借记卡)",
                "NCB_DEBIT" => "宁波通商银行(借记卡)",
                "NYCCB_DEBIT" => "南阳村镇银行(借记卡)",
                "NMGNX_DEBIT" => "内蒙古农信(借记卡)",
                "SXXH_DEBIT" => "陕西信合(借记卡)",
                "SRCB_CREDIT" => "上海农商银行(信用卡)",
                "SJB_DEBIT" => "盛京银行(借记卡)",
                "SDRCU_DEBIT" => "山东农信(借记卡)",
                "SRCB_DEBIT" => "上海农商银行(借记卡)",
                "SCNX_DEBIT" => "四川农信(借记卡)",
                "QLB_DEBIT" => "齐鲁银行(借记卡)",
                "QDCCB_DEBIT" => "青岛银行(借记卡)",
                "PZHCCB_DEBIT" => "攀枝花银行(借记卡)",
                "ZJTLCB_DEBIT" => "浙江泰隆银行(借记卡)",
                "TJBHB_DEBIT" => "天津滨海农商行(借记卡)",
                "WEB_DEBIT" => "微众银行(借记卡)",
                "YNRCCB_DEBIT" => "云南农信(借记卡)",
                "WFB_DEBIT" => "潍坊银行(借记卡)",
                "WHRC_DEBIT" => "武汉农商行(借记卡)",
                "ORDOSB_DEBIT" => "鄂尔多斯银行(借记卡)",
                "XJRCCB_DEBIT" => "新疆农信银行(借记卡)",
                "ORDOSB_CREDIT" => "鄂尔多斯银行(信用卡)",
                "CSRCB_DEBIT" => "常熟农商银行(借记卡)",
                "JSNX_DEBIT" => "江苏农商行(借记卡)",
                "GRCB_CREDIT" => "广州农商银行(信用卡)",
                "GLB_DEBIT" => "桂林银行(借记卡)",
                "GDRCU_DEBIT" => "广东农信银行(借记卡)",
                "GDHX_DEBIT" => "广东华兴银行(借记卡)",
                "FJNX_DEBIT" => "福建农信银行(借记卡)",
                "DYCCB_DEBIT" => "德阳银行(借记卡)",
                "DRCB_DEBIT" => "东莞农商行(借记卡)",
                "CZCB_DEBIT" => "稠州银行(借记卡)",
                "CZB_DEBIT" => "浙商银行(借记卡)",
                "CZB_CREDIT" => "浙商银行(信用卡)",
                "GRCB_DEBIT" => "广州农商银行(借记卡)",
                "CSCB_DEBIT" => "长沙银行(借记卡)",
                "CQRCB_DEBIT" => "重庆农商银行(借记卡)",
                "CBHB_DEBIT" => "渤海银行(借记卡)",
                "BOIMCB_DEBIT" => "内蒙古银行(借记卡)",
                "BOD_DEBIT" => "东莞银行(借记卡)",
                "BOD_CREDIT" => "东莞银行(信用卡)",
                "BOB_DEBIT" => "北京银行(借记卡)",
                "BNC_DEBIT" => "江西银行(借记卡)",
                "BJRCB_DEBIT" => "北京农商行(借记卡)",
                "AE_CREDIT" => "AE(信用卡)",
                "GYCB_CREDIT" => "贵阳银行(信用卡)",
                "JSHB_DEBIT" => "晋商银行(借记卡)",
                "JRCB_DEBIT" => "江阴农商行(借记卡)",
                "JNRCB_DEBIT" => "江南农商(借记卡)",
                "JLNX_DEBIT" => "吉林农信(借记卡)",
                "JLB_DEBIT" => "吉林银行(借记卡)",
                "JJCCB_DEBIT" => "九江银行(借记卡)",
                "HXB_DEBIT" => "华夏银行(借记卡)",
                "HXB_CREDIT" => "华夏银行(信用卡)",
                "HUNNX_DEBIT" => "湖南农信(借记卡)",
                "HSB_DEBIT" => "徽商银行(借记卡)",
                "HSBC_DEBIT" => "恒生银行(借记卡)",
                "HRXJB_DEBIT" => "华融湘江银行(借记卡)",
                "HNNX_DEBIT" => "河南农信(借记卡)",
                "HKBEA_DEBIT" => "东亚银行(借记卡)",
                "HEBNX_DEBIT" => "河北农信(借记卡)",
                "HBNX_DEBIT" => "湖北农信(借记卡)",
                "HBNX_CREDIT" => "湖北农信(信用卡)",
                "GYCB_DEBIT" => "贵阳银行(借记卡)",
                "GSNX_DEBIT" => "甘肃农信(借记卡)",
                "JCB_CREDIT" => "JCB(信用卡)",
                "MASTERCARD_CREDIT" => "MASTERCARD(信用卡)",
                "VISA_CREDIT" => "VISA(信用卡)"
            );
            $content  = $print['content'];
            $printDoc = str_replace("|#收银员姓名#|", $user['realname'], $content);
            $printDoc = str_replace("|#收银时间#|", $trade['time_end'] ? date("Y-m-d H:i:s", $trade['time_end']) : 0, $printDoc);
            $printDoc = str_replace("|#总金额#|", sprintf('%.2f', ($trade['total_fee'] / 100)), $printDoc);
            $printDoc = str_replace("|#优惠金额#|", sprintf('%.2f', ($trade['coupon_fee'] / 100)), $printDoc);
            $printDoc = str_replace("|#实收金额#|", sprintf('%.2f', ($trade['cash_fee'] / 100)), $printDoc);
            $printDoc = str_replace("|#付款银行#|", $trade['paytype'] ? "支付宝" : "微信" . $data[$trade['bank_type']], $printDoc);
            $printDoc = str_replace("|#付款终端#|", $trade['attach'] == '-' || $trade['attach'] == 'PC' ? "电脑端" : "移动端", $printDoc);
            $printDoc = str_replace("|#单号#|", $trade['out_trade_no'], $printDoc);
            $printDoc = str_replace("|#原单号#|", $trade['old_trade_no'], $printDoc);
            $qrcode1  = encrypt($tradeid, 'E', $cfg['encryptcode']);
            $qrcode   = urlencode(base64_encode($qrcode1));
            $uniacid  = $cfg['creadit_uniacid'] ? $cfg['creadit_uniacid'] : $_W['uniacid'];
            $url      = trueUrl2Shorturl($_W['siteroot'] . "app/index.php?i=" . $uniacid . "&c=entry&do=getcredit&m=j_money&qrcode=" . $qrcode);
            $printDoc = str_replace("|#积分二维码#|", $url, $printDoc);
        } else {
            $cardtype = array(
                "discount" => "折扣券",
                "cash" => "代金券",
                "gift" => "礼品券",
                "groupon" => "团购券",
                "general_coupon" => "优惠券"
            );
            $content  = $print['content'];
            $printDoc = str_replace("|#收银员姓名#|", $user['realname'], $content);
            $printDoc = str_replace("|#兑换时间#|", date("Y-m-d H:i:s", $trade['createtime']), $printDoc);
            $printDoc = str_replace("|#卡券内容#|", $trade['description'], $printDoc);
            $printDoc = str_replace("|#卡券标题#|", $trade['title'], $printDoc);
            $printDoc = str_replace("|#卡券副标题#|", $trade['sub_title'], $printDoc);
            $printDoc = str_replace("|#卡券类型#|", $cardtype[$trade['type']], $printDoc);
            switch ($coupon['type']) {
                case "gift":
                case "groupon":
                case "general_coupon":
                    $trade["typestr"] = $coupon['extra'];
                    break;
                case "discount":
                    $trade["typestr"] = "" . sprintf('%.2f', ($coupon['extra'] / 100)) . "折";
                    break;
                case "cash":
                    $extra            = iunserializer($coupon['extra']);
                    $trade["typestr"] = "满" . $extra['least_cost'] . "减" . $extra['reduce_cost'];
                    break;
            }
            $printDoc = str_replace("|#卡券优惠#|", $trade["typestr"], $printDoc);
        }
        include $this->template('print');
    }
    public function doMobilePrintother()
    {
        global $_GPC, $_W;
        $islogin = $_GPC['islogin'];
        if (!$islogin)
            die("请先登录");
        $id  = $_GPC['id'];
        $url = $_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=extension&m=j_money&extend_modal=" . $_GPC['extend_modal'] . "&ordersn=" . $_GPC['ordersn'] . "&op=" . $_GPC['extend_modal_op'] . "&id=" . $id;
        load()->func('communication');
        $result   = ihttp_get($url);
        $printdoc = $result['content'];
        var_dump($printdoc);
        $cfg = $this->module['config'];
        include $this->template('printother');
    }
    public function doMobileOauthcredit()
    {
        global $_W, $_GPC;
        $code = $_GPC['code'];
        $cfg  = $this->module['config'];
        if (!empty($code)) {
            load()->func('communication');
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $_W['account']['key'] . "&secret=" . $_W['account']['secret'] . "&code={$code}&grant_type=authorization_code";
            $ret = ihttp_get($url);
            if (!is_error($ret)) {
                $auth = @json_decode($ret['content'], true);
                if (is_array($auth) && !empty($auth['openid'])) {
                    $openid                 = $auth['openid'];
                    $url                    = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $auth['access_token'] . '&openid=' . $auth['openid'] . '&lang=zh_CN';
                    $ret                    = ihttp_get($url);
                    $auth                   = @json_decode($ret['content'], true);
                    $fansinfo['nickname']   = $auth['nickname'];
                    $fansinfo['sex']        = $auth['sex'];
                    $fansinfo['headimgurl'] = $auth['headimgurl'];
                    $fans                   = pdo_fetch("SELECT * FROM " . tablename('mc_mapping_fans') . " WHERE uniacid='{$_W['uniacid']}' and openid=:a ", array(
                        ":a" => $openid
                    ));
                    if (!$fans || $fans['follow'] == 0) {
                        include $this->template('creditpage');
                        exit();
                    }
                    $orderid = $_GPC['j_money_qrcode' . $_W['uniacid']];
                    if (!$orderid)
                        message("抱歉，编码错误");
                    $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and out_trade_no=:a and status>0", array(
                        ":a" => $orderid
                    ));
                    if (!$trade)
                        message("抱歉，编码错误!");
                    if ($trade['credit'] * 100 > 0)
                        message("抱歉，积分已被领取了哦！");
                    $credit = $cfg['creadit'] * $trade['cash_fee'];
                    load()->model('mc');
                    $uid = $fans['uid'];
                    if (!$uid) {
                        $uid = mc_update($openid, array(
                            'nickname' => $fansinfo['nickname']
                        ));
                        if (!$uid)
                            message("系统异常，请联系管理员");
                    }
                    mc_credit_update($uid, "credit1", $credit, array(
                        "",
                        "收银台消费扫码获得积分,ID：" . $trade['id']
                    ));
                    $allcredit = mc_credit_fetch($uid, array(
                        'credit1'
                    ));
                    pdo_update("j_money_trade", array(
                        "credit" => $credit
                    ), array(
                        "id" => $trade['id']
                    ));
                    include $this->template('creditpage');
                    exit();
                } else {
                    die('抱歉，微信授权失败');
                }
            } else {
                die('微信授权失败');
            }
        }
        die('微信授权失败');
    }
    public function doMobileGetcredit()
    {
        global $_W, $_GPC;
        $qrcode  = strval($_GPC['qrcode']);
        $qrcode1 = base64_decode(urldecode(urldecode(strval($qrcode))));
        $cfg     = $this->module['config'];
        $orderid = encrypt(trim($qrcode1), 'D', $cfg['encryptcode']);
        if (!$orderid)
            message("抱歉，编码错误");
        isetcookie('j_money_qrcode' . $_W['uniacid'], $orderid, 86400);
        $callback = urlencode($_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=oauthcredit&m=j_money&qrcode=" . $qrcode);
        $forward  = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $_W['account']['key'] . "&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
        header('location:' . $forward);
        exit();
    }
    public function doMobileOauthlogin()
    {
        global $_W, $_GPC;
        $code   = $_GPC['code'];
        $qrcode = intval($_GPC['qrcode']);
        $cfg    = $this->module['config'];
        if (!empty($code)) {
            load()->func('communication');
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $_W['account']['key'] . "&secret=" . $_W['account']['secret'] . "&code={$code}&grant_type=authorization_code";
            $ret = ihttp_get($url);
            if (!is_error($ret)) {
                $auth = @json_decode($ret['content'], true);
                if (is_array($auth) && !empty($auth['openid'])) {
                    $openid = $auth['openid'];
                    $user   = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}' and openid=:a ", array(
                        ":a" => $openid
                    ));
                    if (!$user)
                        message("您没权使用本系统！");
                    if (!$user['login_pc'])
                        message("您的账号禁止在电脑端登录！");
                    $item = pdo_fetch("SELECT * FROM " . tablename('j_money_qrlogin') . " WHERE sncode=:a and status=0 and openid='' and userid='' ", array(
                        ':a' => $qrcode
                    ));
                    if (!$item)
                        message("抱歉，该二维码已过期！");
                    if (TIMESTAMP - $item['createtime'] > 60 * 5)
                        message("抱歉，该二维码已过期！");
                    pdo_update('j_money_qrlogin', array(
                        "status" => 1,
                        "openid" => $openid,
                        "userid" => $user['id']
                    ), array(
                        "id" => $item['id']
                    ));
                    message("登陆成功");
                    exit();
                } else {
                    die('抱歉，微信授权失败');
                }
            } else {
                die('微信授权失败');
            }
        }
        die('微信授权失败');
    }
    public function doMobileLogin()
    {
        global $_W, $_GPC;
        $qrcode   = strval($_GPC['qrcode']);
        $reply    = pdo_fetchcolumn("SELECT * FROM " . tablename('account_wechats') . " WHERE uniacid=:a ", array(
            ':a' => $_W['uniacid']
        ));
        $callback = urlencode($_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=oauthlogin&m=j_money&qrcode=" . $qrcode);
        $forward  = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $_W['account']['key'] . "&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
        header('location:' . $forward);
        exit();
    }
    public function doMobileGame()
    {
        global $_GPC, $_W;
        $id = intval($_GPC['id']);
        if (empty($id))
            message('活动已经删除！');
        $item = pdo_fetch("SELECT * FROM " . tablename('j_money_lotterygame') . " WHERE id =:id ", array(
            ':id' => $id
        ));
        if (empty($item))
            message('活动已经删除！');
        $openid = $_W['openid'] ? $_W['openid'] : $_GPC['from_user_oauth'];
        $cfg    = $this->module['config'];
        if (empty($openid)) {
            $callback = urlencode($_W['siteroot'] . 'app' . str_replace("./", "/", $this->createMobileurl('oauth', array(
                'id' => $id
            ))));
            $forward  = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $cfg['appid'] . "&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
            header('location:' . $forward);
        }
        $isfollow = pdo_fetchcolumn("SELECT follow FROM " . tablename('mc_mapping_fans') . " WHERE openid =:openid ", array(
            ":openid" => $openid
        ));
        if (!$isfollow)
            message("请先关注我们的公众号哦", $item['gzurl'], "error");
        $prizelist = pdo_fetchall("SELECT * FROM " . tablename('j_money_award') . " WHERE gid =:id and isprize=1 order by id desc", array(
            ':id' => $id
        ));
        $prizeary  = array();
        foreach ($prizelist as $row) {
            $prizeary[$row['id']] = $row['level'];
        }
        $isGetPrize = pdo_fetchall("SELECT * FROM " . tablename('j_money_lottery') . " WHERE gid =:id and from_user=:f and isprize=1 order by id asc", array(
            ':id' => $id,
            ':f' => $openid
        ));
        $flag       = 1;
        $gamecount  = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_lottery') . " WHERE gid =:id and createtime=0", array(
            ':id' => $id
        ));
        if (!$gamecount) {
            $flag = 0;
        }
        include $this->template('game');
    }
    public function doMobileOauth()
    {
        global $_W, $_GPC;
        $code = $_GPC['code'];
        load()->func('communication');
        $id  = intval($_GPC['id']);
        $cfg = $this->module['config'];
        if (!empty($code)) {
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $cfg['appid'] . "&secret=" . $cfg['secret'] . "&code={$code}&grant_type=authorization_code";
            $ret = ihttp_get($url);
            if (!is_error($ret)) {
                $auth = @json_decode($ret['content'], true);
                if (is_array($auth) && !empty($auth['openid'])) {
                    $url  = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $auth['access_token'] . '&openid=' . $auth['openid'] . '&lang=zh_CN';
                    $ret  = ihttp_get($url);
                    $auth = @json_decode($ret['content'], true);
                    isetcookie('from_user_oauth', $auth['openid'], 86400);
                    isetcookie('nickname', $auth['nickname'], 86400);
                    isetcookie('headimgurl', $auth['headimgurl'], 86400);
                    $forward = $_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=game&m=j_money&id=" . $id . "&wxref=mp.weixin.qq.com#wechat_redirect";
                    header('location:' . $forward);
                    exit;
                } else {
                    die('抱歉，微信授权失败');
                }
            } else {
                die('微信授权失败');
            }
        } else {
            $forward = $_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=game&m=j_money&id=" . $id . "&wxref=mp.weixin.qq.com#wechat_redirect";
            header('location: ' . $forward);
            exit;
        }
    }
    public function doMobileShareoauth()
    {
        global $_W, $_GPC;
        $code = $_GPC['code'];
        load()->func('communication');
        $id  = intval($_GPC['id']);
        $cfg = $this->module['config'];
        if (!empty($code)) {
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $cfg['appid'] . "&secret=" . $cfg['secret'] . "&code={$code}&grant_type=authorization_code";
            $ret = ihttp_get($url);
            if (!is_error($ret)) {
                $auth = @json_decode($ret['content'], true);
                if (is_array($auth) && !empty($auth['openid'])) {
                    $url  = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $auth['access_token'] . '&openid=' . $auth['openid'] . '&lang=zh_CN';
                    $ret  = ihttp_get($url);
                    $auth = @json_decode($ret['content'], true);
                    isetcookie('from_user_oauth', $auth['openid'], 86400);
                    isetcookie('nickname', $auth['nickname'], 86400);
                    isetcookie('headimgurl', $auth['headimgurl'], 86400);
                    $forward = $_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=share&m=j_money&id=" . $id . "&wxref=mp.weixin.qq.com#wechat_redirect";
                    header('location:' . $forward);
                    exit;
                } else {
                    die('抱歉，微信授权失败');
                }
            } else {
                die('微信授权失败');
            }
        } else {
            $forward = $_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=share&m=j_money&id=" . $id . "&wxref=mp.weixin.qq.com#wechat_redirect";
            header('location: ' . $forward);
            exit;
        }
    }
    public function doMobileShare()
    {
        global $_W, $_GPC;
        $id = strval($_GPC['id']);
        if (!$id)
            die();
        $openid = $_W["openid"] ? $_W["openid"] : $_GPC["from_user_oauth"];
        $cfg    = $this->module['config'];
        if (!$openid) {
            $callback = urlencode($_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&do=shareoauth&m=j_money&id=" . $id);
            $forward  = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $cfg['appid'] . "&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
            header('location:' . $forward);
            exit();
        }
        $item = pdo_fetch("SELECT * FROM " . tablename('j_money_article') . " WHERE id =:id and weid=:a", array(
            ':id' => $id,
            ':a' => $_W['uniacid']
        ));
        if (!$item)
            message("活动不存在或者已删除");
        if (!$item['status'])
            message("活动已关闭");
        if (TIMESTAMP < $item['starttime'])
            message("活动还没有开始哦，开始时间：" . date("Y-m-d H:i", $item['starttime']));
        if (TIMESTAMP > $item['endtime'])
            message("活动已在" . date("Y-m-d H:i", $item['starttime']) . "结束了哦");
        pdo_update("j_money_article", array(
            "viewcount" => $item['viewcount'] + 1
        ), array(
            "id" => $id
        ));
        $cardArry = $this->getCardTicket($item['favorable'], $openid);
        include $this->template('share');
    }
    public function getCardTicket($card_id, $openid)
    {
        global $_W, $_GPC;
        $data = pdo_fetch("SELECT * FROM " . tablename('j_money_cardticket') . " WHERE weid='" . $_W['uniacid'] . "' ");
        load()->func('communication');
        if ($data['createtime'] < time()) {
            $tokens = WeAccount::token();
            $url    = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=" . $tokens . "&type=wx_card";
            $res    = json_decode($this->httpGet($url));
            $now    = TIMESTAMP;
            $now    = intval($now) + 7200;
            $ticket = $res->ticket;
            $insert = array(
                'weid' => $_W['uniacid'],
                'createtime' => $now,
                'ticket' => $ticket
            );
            if (empty($data)) {
                pdo_insert('j_money_cardticket', $insert);
            } else {
                pdo_update('j_money_cardticket', $insert, array(
                    'id' => $data['id']
                ));
            }
        } else {
            $ticket = $data['ticket'];
        }
        $now       = time();
        $timestamp = $now;
        $nonceStr  = getNonceStr();
        $card_id   = $card_id;
        $openid    = $openid;
        $string    = "card_id=$card_id&jsapi_ticket=$ticket&noncestr=$nonceStr$openid=$openid&timestamp=$timestamp";
        $arr       = array(
            $card_id,
            $ticket,
            $nonceStr,
            $openid,
            $timestamp
        );
        asort($arr, SORT_STRING);
        $sortString = "";
        foreach ($arr as $temp) {
            $sortString = $sortString . $temp;
        }
        $signature = sha1($sortString);
        $cardArry  = array(
            'code' => "",
            'openid' => $openid,
            'timestamp' => $now,
            'signature' => $signature,
            'cardId' => $card_id,
            'ticket' => $ticket,
            'nonceStr' => $nonceStr
        );
        return $cardArry;
    }
    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
    public function doWebMember()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $cfg       = $this->module['config'];
        if ($operation == "display") {
            $list = pdo_fetchall("SELECT * FROM " . tablename('j_money_user') . " WHERE weid = '{$_W['uniacid']}' order by id desc");
        } elseif ($operation == 'post') {
            $id = $_GPC['id'];
            if ($id) {
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_user') . " WHERE id = :id ", array(
                    ':id' => $id
                ));
            } else {
                if ($cfg['usernum']) {
                    $allgroup = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}'");
                    if ($allgroup >= $cfg['usernum'])
                        message("只能添加" . $cfg['usernum'] . "个坐席，增加请联系服务商");
                }
            }
            $list = pdo_fetchall("SELECT * FROM " . tablename('j_money_group') . " WHERE weid = '{$_W['uniacid']}' order by id desc");
            if (checksubmit('submit')) {
                $data = array(
                    'useracount' => $_GPC['useracount'],
                    'weid' => $_W['uniacid'],
                    'realname' => $_GPC['realname'],
                    'openid' => $_GPC['openid'],
                    'mobile' => $_GPC['mobile'],
                    'password' => $_GPC['password'] ? md5($_GPC['password']) : '',
                    'login_pc' => intval($_GPC['login_pc']),
                    'login_m' => intval($_GPC['login_m']),
                    'status' => intval($_GPC['status']),
                    'pcate' => intval($_GPC['pcate'])
                );
                if (!$data['pcate'])
                    message("请选择所属组别");
                if ($id) {
                    if (!$data['password'])
                        unset($data['password']);
                    unset($data['useracount']);
                    pdo_update("j_money_user", $data, array(
                        "id" => $id
                    ));
                } else {
                    if ($cfg['usernum']) {
                        $allgroup = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_user') . " WHERE weid='{$_W['uniacid']}'");
                        if ($allgroup >= $cfg['usernum'])
                            message("只能添加" . $cfg['usernum'] . "个坐席，增加请联系服务商");
                    }
                    $isUsed = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_user') . " WHERE weid = '{$_W['uniacid']}' and useracount=:a", array(
                        ":a" => $data['useracount']
                    ));
                    if ($isUsed) {
                        message("【" . $data['useracount'] . "】已经被使用，请更换其他工号");
                    }
                    $data['createtime'] = TIMESTAMP;
                    pdo_insert("j_money_user", $data);
                    $id = pdo_insertid();
                }
                message("修改完成", $this->createWebUrl('member', array(
                    'op' => 'post',
                    'id' => $id
                )), 'success');
            }
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if ($id) {
                pdo_delete('j_money_user', array(
                    'id' => $id
                ));
            }
            message("删除成功", $this->createWebUrl('member'), 'success');
        }
        include $this->template('member');
    }
    public function doWebGroup()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $cfg       = $this->module['config'];
        if ($operation == "display") {
            $list     = pdo_fetchall("SELECT * FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}' order by id desc ");
            $user     = pdo_fetchall("SELECT pcate FROM " . tablename('j_money_user') . " WHERE weid = '{$_W['uniacid']}' order by id desc ");
            $userList = array();
            foreach ($user as $row) {
                if (!isset($userList[$row['pcate']]))
                    $userList[$row['pcate']] = 0;
                $userList[$row['pcate']] = intval($userList[$row['pcate']]) + 1;
            }
        } elseif ($operation == 'post') {
            $id = $_GPC['id'];
            if ($id) {
                $category = pdo_fetch("SELECT * FROM " . tablename('j_money_group') . " WHERE id = :id ", array(
                    ':id' => $id
                ));
            } else {
                if ($cfg['groupnum']) {
                    $allgroup = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}'");
                    if ($allgroup >= $cfg['groupnum'])
                        message("只能添加" . $cfg['groupnum'] . "个组别，增加请联系服务商");
                }
            }
            $receipt1 = pdo_fetchall("SELECT * FROM " . tablename('j_money_print') . " WHERE weid='{$_W['uniacid']}' and pcate=0 order by id desc ");
            $receipt2 = pdo_fetchall("SELECT * FROM " . tablename('j_money_print') . " WHERE weid='{$_W['uniacid']}' and pcate=1 order by id desc ");
            if (checksubmit('submit')) {
                $data = array(
                    'weid' => $_W['uniacid'],
                    'logo' => trim($_GPC['logo']),
                    'bg' => trim($_GPC['bg']),
                    'companyname' => $_GPC['companyname'],
                    'description' => $_GPC['description'],
                    'appid' => trim($_GPC['appid']),
                    'app_id' => trim($_GPC['app_id']),
                    'sub_appid' => trim($_GPC['sub_appid']),
                    'sub_mch_id' => trim($_GPC['sub_mch_id']),
                    'appsecret' => trim($_GPC['appsecret']),
                    'pay_name' => $_GPC['pay_name'],
                    'pay_mchid' => $_GPC['pay_mchid'],
                    'pay_signkey' => $_GPC['pay_signkey'],
                    'app_id' => trim($_GPC['app_id']),
                    'pay_signkey' => $_GPC['pay_signkey'],
                    'needtable' => intval($_GPC['needtable']),
                    'refunder' => trim($_GPC['refunder']),
                    'tempid' => trim($_GPC['tempid']),
                    'tempid2' => trim($_GPC['tempid2']),
                    'tempurl' => trim($_GPC['tempurl']),
                    'qrcode' => trim($_GPC['qrcode']),
                    'creadit' => trim($_GPC['creadit']),
                    'creditbtn' => trim($_GPC['creditbtn']),
                    'printpagewidth' => trim($_GPC['printpagewidth']),
                    'printnum' => trim($_GPC['printnum']),
                    'payreceipt' => intval($_GPC['payreceipt']),
                    'couponreceipt' => intval($_GPC['couponreceipt'])
                );
                if (!$id) {
                    if ($cfg['groupnum']) {
                        $allgroup = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_group') . " WHERE weid='{$_W['uniacid']}'");
                        if ($allgroup >= $cfg['groupnum'])
                            message("只能添加" . $cfg['groupnum'] . "个组别，增加请联系服务商");
                    }
                    $isUsed = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_group') . " WHERE weid = '{$_W['uniacid']}' and companyname=:a", array(
                        ":a" => $data['companyname']
                    ));
                    if ($isUsed)
                        message("【" . $data['companyname'] . "】已经被使用");
                    pdo_insert("j_money_group", $data);
                    $id = pdo_insertid();
                }
                load()->func('file');
                $dir_url = '../attachment/j_money/cert_2/' . $_W['uniacid'] . "/" . $id . "/";
                mkdirs($dir_url);
                if ($_FILES["rootca"]["name"]) {
                    if (file_exists($dir_url . "rootca.pem"))
                        @unlink($dir_url . "rootca.pem");
                    $data['rootca'] = "rootca.pem";
                    move_uploaded_file($_FILES["rootca"]["tmp_name"], $dir_url . "rootca.pem");
                }
                if ($_FILES["apiclient_cert"]["name"]) {
                    if (file_exists($dir_url . "apiclient_cert.pem"))
                        @unlink($dir_url . "apiclient_cert.pem");
                    $data['apiclient_cert'] = "apiclient_cert.pem";
                    move_uploaded_file($_FILES["apiclient_cert"]["tmp_name"], $dir_url . "apiclient_cert.pem");
                }
                if ($_FILES["apiclient_key"]["name"]) {
                    if (file_exists($dir_url . "apiclient_key.pem"))
                        @unlink($dir_url . "apiclient_key.pem");
                    $data['apiclient_key'] = "apiclient_key.pem";
                    move_uploaded_file($_FILES["apiclient_key"]["tmp_name"], $dir_url . "apiclient_key.pem");
                }
                if ($_FILES["alipay_key"]["name"]) {
                    if (file_exists($dir_url . "alipay_key.pem"))
                        @unlink($dir_url . "alipay_key.pem");
                    $data['alipay_key'] = "alipay_key.pem";
                    move_uploaded_file($_FILES["alipay_key"]["tmp_name"], $dir_url . "alipay_key.pem");
                }
                pdo_update("j_money_group", $data, array(
                    "id" => $id
                ));
                message("修改完成", $this->createWebUrl('group', array(
                    'op' => 'post',
                    'id' => $id
                )), 'success');
            }
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if ($id) {
                $isUsed = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_user') . " WHERE weid = '{$_W['uniacid']}' and pcate=:a", array(
                    ":a" => $id
                ));
                if ($isUsed)
                    message("该组别下还有人员，不能直接删除！");
                pdo_delete('j_money_group', array(
                    'id' => $id
                ));
            }
            message("删除成功", $this->createWebUrl('group'), 'success');
        }
        include $this->template('category');
    }
    public function doWebPrint()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == "display") {
            $list = pdo_fetchall("SELECT * FROM " . tablename('j_money_print') . " WHERE weid = '{$_W['uniacid']}' order by id desc");
            if (checksubmit('submit')) {
                $id = $_GPC['id'];
                if (!$id)
                    message("请选择要导入的模板内容");
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_print') . " WHERE weid = '{$_W['uniacid']}' and id = :id ", array(
                    ':id' => $id
                ));
                if (!$item)
                    message("请选择要导入的模板内容");
                if (!$_FILES["printtxt"]["name"])
                    message("请选择要导入的文件");
                load()->func('file');
                $dir_url = IA_ROOT . '/attachment/j_money/temp/' . $_W['uniacid'] . "/";
                mkdirs($dir_url);
                if (file_exists($dir_url . "print.txt"))
                    @unlink($dir_url . "print.txt");
                $filename = "print.txt";
                $a        = move_uploaded_file($_FILES["printtxt"]["tmp_name"], $dir_url . $filename);
                $txt      = file_get_contents($dir_url . $filename);
                pdo_update("j_money_print", array(
                    "content" => $txt
                ), array(
                    "id" => $id
                ));
                message("导入完成", $this->createWebUrl('print', array(
                    'op' => 'post',
                    'id' => $id
                )), 'success');
            }
        } elseif ($operation == 'output') {
            $id = $_GPC['id'];
            if (!$id)
                message("请选择要导出的模板内容");
            $item = pdo_fetch("SELECT * FROM " . tablename('j_money_print') . " WHERE weid = '{$_W['uniacid']}' and id = :id ", array(
                ':id' => $id
            ));
            if (!$item)
                message("请选择要导出的模板内容");
            header("Content-type:application/octet-stream ");
            header("Accept-Ranges:bytes");
            header("Content-Disposition:attachment;filename=" . $item['title'] . ".txt ");
            header("Expires:0 ");
            header("Cache-Control:must-revalidate,post-check=0,pre-check=0 ");
            header("Pragma:public");
            echo $item['content'];
            die();
        } elseif ($operation == 'input') {
        } elseif ($operation == 'post') {
            $id = $_GPC['id'];
            if ($id)
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_print') . " WHERE id = :id ", array(
                    ':id' => $id
                ));
            if (checksubmit('submit')) {
                $content = htmlspecialchars_decode(str_replace('&#039;', '\"', $_GPC['content']));
                $array   = explode("\n", $content);
                if (count($array)) {
                    $temp     = $array[0];
                    $temp     = str_replace("LODOP.PRINT_INITA(", "", $temp);
                    $temp     = str_replace(");", "", $temp);
                    $ary      = explode(",", $temp);
                    $array[0] = "LODOP.PRINT_INITA(0,0," . $ary[2] . "," . $ary[3] . ",'小票打印页');";
                }
                $data = array(
                    'content' => implode("\n", $array),
                    'weid' => $_W['uniacid'],
                    'title' => $_GPC['title'],
                    'pcate' => intval($_GPC['pcate'])
                );
                if ($id) {
                    pdo_update("j_money_print", $data, array(
                        "id" => $id
                    ));
                } else {
                    pdo_insert("j_money_print", $data);
                    $id = pdo_insertid();
                }
                message("修改完成", $this->createWebUrl('print', array(
                    'op' => 'post',
                    'id' => $id
                )), 'success');
            }
            include $this->template('print-edit');
            exit();
        } elseif ($operation == 'isdefault') {
            $id = intval($_GPC['id']);
            if ($id) {
                $pcate = pdo_fetchcolumn("SELECT pcate FROM " . tablename('j_money_print') . " WHERE id = :id ", array(
                    ':id' => $id
                ));
                pdo_update("j_money_print", array(
                    "isdefault" => 0
                ), array(
                    "weid" => $_W['uniacid'],
                    "pcate" => $pcate
                ));
                pdo_update("j_money_print", array(
                    "isdefault" => 1
                ), array(
                    "id" => $id
                ));
            }
            message("修改完成", $this->createWebUrl('print'), 'success');
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if ($id) {
                pdo_delete('j_money_print', array(
                    'id' => $id
                ));
            }
            message("删除成功", $this->createWebUrl('print'), 'success');
        }
        include $this->template('print');
    }
    public function doWebArtcle()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == "display") {
            $list = pdo_fetchall("SELECT * FROM " . tablename('j_money_article') . " WHERE weid = '{$_W['uniacid']}' order by id desc");
        } elseif ($operation == 'post') {
            $id = $_GPC['id'];
            if ($id) {
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_article') . " WHERE id = :id ", array(
                    ':id' => $id
                ));
            } else {
                $item = array(
                    "starttime" => strtotime(date("Y-m-d H:i")),
                    "endtime" => strtotime(date("Y-m-d H:i"))
                );
            }
            if (checksubmit('submit')) {
                $data = array(
                    'weid' => $_W['uniacid'],
                    'title' => $_GPC['title'],
                    'status' => $_GPC['status'],
                    'description' => strval($_GPC['description']),
                    'thumb' => $_GPC['thumb'],
                    'prizetype' => $_GPC['prizetype'],
                    'favorable' => $_GPC['favorable'],
                    'starttime' => strtotime($_GPC['gametime']['start']),
                    'endtime' => strtotime($_GPC['gametime']['end']),
                    'content' => htmlspecialchars_decode($_GPC['content']),
                    'favorable' => $_GPC['favorable']
                );
                if ($id) {
                    pdo_update("j_money_article", $data, array(
                        "id" => $id
                    ));
                } else {
                    $data['createtime'] = TIMESTAMP;
                    pdo_insert("j_money_article", $data);
                    $id = pdo_insertid();
                }
                message("修改完成", $this->createWebUrl('artcle', array(
                    'op' => 'post',
                    'id' => $id
                )), 'success');
            }
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if ($id) {
                pdo_delete('j_money_article', array(
                    'id' => $id
                ));
            }
            message("删除成功", $this->createWebUrl('artcle'), 'success');
        }
        include $this->template('article');
    }
    public function doWebCard()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == "display") {
            $list = pdo_fetchall("SELECT * FROM " . tablename('j_money_card') . " WHERE weid = '{$_W['uniacid']}' order by id desc");
        } elseif ($operation == 'post') {
            $id = $_GPC['id'];
            if ($id)
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_card') . " WHERE id = :id ", array(
                    ':id' => $id
                ));
            if (checksubmit('submit')) {
                $data = array(
                    'weid' => $_W['uniacid'],
                    'title' => $_GPC['title'],
                    'cardid' => $_GPC['cardid'],
                    'description' => strval($_GPC['description'])
                );
                if ($id) {
                    pdo_update("j_money_card", $data, array(
                        "id" => $id
                    ));
                } else {
                    $ishad = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_card') . " WHERE cardid = :a ", array(
                        ':a' => $data['cardid']
                    ));
                    if ($ishad)
                        message("该卡券已经存在，不能重复添加！");
                    pdo_insert("j_money_card", $data);
                    $id = pdo_insertid();
                }
                message("修改完成", $this->createWebUrl('card', array(
                    'op' => 'post',
                    'id' => $id
                )), 'success');
            }
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if ($id) {
                pdo_delete('j_money_card', array(
                    'id' => $id
                ));
            }
            message("删除成功", $this->createWebUrl('card'), 'success');
        }
        include $this->template('card');
    }
    public function doWebFunction()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == "display") {
            $where = '';
            if ($_GPC['groupid'])
                $where .= " and groupid='" . $_GPC['groupid'] . "' ";
            $pindex    = intval($_GPC['page']) ? intval($_GPC['page']) - 1 : 0;
            $psize     = 20;
            $start     = $pindex * $psize;
            $list      = pdo_fetchall("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' $where order by groupid asc, status desc,displayorder asc,id desc LIMIT " . $start . "," . $psize);
            $total     = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_marketing') . " WHERE weid='" . $_W['uniacid'] . "' $where ");
            $pager     = pagination($total, $pindex, $psize);
            $grouplist = pdo_fetchall("SELECT * FROM " . tablename("j_money_group") . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY id asc");
            $groupary  = array();
            foreach ($grouplist as $row) {
                $groupary[$row['id']] = $row['companyname'];
            }
        } elseif ($operation == 'post') {
            $id = intval($_GPC['id']);
            if ($id)
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and id=:a", array(
                    ':a' => $id
                ));
            $item['starttime'] = $item['starttime'] ? $item['starttime'] : TIMESTAMP;
            $item['endtime']   = $item['endtime'] ? $item['endtime'] : TIMESTAMP;
            $hourlist          = array(
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                13,
                14,
                15,
                16,
                17,
                18,
                19,
                20,
                21,
                22,
                23
            );
            $group             = pdo_fetchall("SELECT * FROM " . tablename("j_money_group") . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY id asc");
            $grouplist         = pdo_fetchall("SELECT * FROM " . tablename("mc_groups") . " WHERE uniacid = '" . $_W['uniacid'] . "' ORDER BY `orderlist` asc");
            $groupary          = array();
            $groupary2         = array();
            foreach ($grouplist as $row) {
                $groupary2[]               = $row['groupid'];
                $groupary[$row['groupid']] = $row['title'];
            }
            $gamelist = pdo_fetchall("SELECT * FROM " . tablename('j_money_lotterygame') . " WHERE weid='{$_W['uniacid']}' and status=1 order by id desc ");
            $cfg      = $this->module['config'];
            if (checksubmit('submit')) {
                $data = array(
                    'displayorder' => intval($_GPC['displayorder']),
                    'weid' => $_W['uniacid'],
                    'groupid' => intval($_GPC['groupid']),
                    'status' => intval($_GPC['status']),
                    'isint' => intval($_GPC['isint']),
                    'title' => $_GPC['title'],
                    'starttime' => strtotime($_GPC['gametime']['start']),
                    'endtime' => strtotime($_GPC['gametime']['end']),
                    'hour' => implode(",", $_GPC['hour']),
                    'num' => intval($_GPC['num']),
                    'favorabletype' => intval($_GPC['favorabletype']),
                    'gid' => intval($_GPC['gid']),
                    'condition_fee' => intval($_GPC['condition_fee'] * 100),
                    'favorable' => $_GPC['favorable'],
                    'isallnum' => intval($_GPC['isallnum']),
                    'condition' => intval($_GPC['condition']),
                    'condition_attendtime' => intval($_GPC['condition_attendtime']),
                    'condition_member' => implode(",", $_GPC['condition_member']),
                    'description' => $_GPC['description']
                );
                if ($id) {
                    unset($data['favorabletype']);
                    pdo_update("j_money_marketing", $data, array(
                        "id" => $id
                    ));
                } else {
                    pdo_insert("j_money_marketing", $data);
                    $id = pdo_insertid();
                }
                message("修改完成", $this->createWebUrl('function'), 'success');
            }
        } elseif ($operation == 'statistical') {
            $id = intval($_GPC['id']);
            if ($id)
                $item = pdo_fetch("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' and id=:a", array(
                    ':a' => $id
                ));
            $list = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE marketing=:a order by id desc", array(
                ':a' => $id
            ));
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if ($id) {
                if (!$_W['isfounder'])
                    message('删除订单必须是管理员方能删除！');
                pdo_delete('j_money_marketing', array(
                    'id' => $id
                ));
            }
            message("删除成功", $this->createWebUrl('function'), 'success');
        }
        include $this->template('function');
    }
    public function doWebHistory()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == "display") {
            $where = $where2 = "";
            if ($_GPC['userid'])
                $where2 .= " and userid='" . $_GPC['userid'] . "'";
            if ($_GPC['year'])
                $where .= " and year(createdate)='" . $_GPC['year'] . "'";
            if ($_GPC['month'])
                $where .= " and month(createdate)='" . $_GPC['month'] . "'";
            if ($_GPC['day'])
                $where .= " and dayofmonth(createdate)='" . $_GPC['day'] . "'";
            if ($_GPC['groupid'])
                $where2 .= " and groupid='" . $_GPC['groupid'] . "' ";
            if ($_GPC['keyword'])
                $where2 .= " and (out_trade_no='" . $_GPC['keyword'] . "' or old_trade_no ='" . $_GPC['keyword'] . "')";
            if ($_GPC['isexplode']) {
                $list      = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' $where $where2 order by id desc ");
                $user      = pdo_fetchall("SELECT * FROM " . tablename('j_money_user') . " WHERE weid = '{$_W['uniacid']}' order by id desc ");
                $grouplist = pdo_fetchall("SELECT * FROM " . tablename('j_money_group') . " WHERE weid = '{$_W['uniacid']}' order by id asc ");
                $marklist  = pdo_fetchall("SELECT id,description FROM " . tablename('j_money_marketing') . " WHERE weid = '{$_W['uniacid']}' order by id asc ");
                $userList  = array();
                $groupids  = array();
                $markary   = array();
                foreach ($marklist as $row) {
                    $markary[$row['id']] = $row['description'];
                }
                foreach ($grouplist as $row) {
                    $groupids[$row['id']] = $row['companyname'];
                }
                foreach ($user as $row) {
                    $userList[$row['id']]['name']  = $row['useracount'] . '(' . $row['realname'] . ')';
                    $userList[$row['id']]['group'] = $groupids[$row['pcate']];
                }
                $tableheader = array(
                    '单号',
                    '原单号',
                    '时间',
                    '支付方式',
                    '收银员',
                    '所在组别',
                    '订单金额',
                    '优惠金额',
                    '实际支付',
                    '优惠方案',
                    '状态'
                );
                foreach ($parama as $index => $row) {
                    array_push($tableheader, $index);
                }
                $html = "\xEF\xBB\xBF";
                foreach ($tableheader as $value) {
                    $html .= $value . "\t ,";
                }
                $html .= "\n";
                foreach ($list as $row) {
                    $html .= $row['out_trade_no'] . "\t ,";
                    $html .= $row['old_trade_no'] . "\t ,";
                    $html .= $row['createdate'] . "\t ,";
                    $html .= ($row['paytype'] ? "支付宝" : "微信") . "\t ,";
                    $html .= addslashes($userList[$row['userid']]['name']) . "\t ,";
                    $html .= addslashes($userList[$row['userid']]['group']) . "\t ,";
                    $html .= addslashes("￥" . sprintf('%.2f', ($row['total_fee'] / 100))) . "\t ,";
                    $html .= addslashes("￥" . sprintf('%.2f', ($row['coupon_fee'] / 100))) . "\t ,";
                    $html .= addslashes("￥" . sprintf('%.2f', ($row['cash_fee'] / 100))) . "\t ,";
                    $html .= addslashes($row['marketing_log']) . "\t ,";
                    $html .= ($row['status'] ? ($row['status'] == 1 ? "成功" : "已退款") : "失败") . "\t ,";
                    $html .= "\n";
                }
                header("Content-type:text/csv");
                header("Content-Disposition:attachment; filename=收银情况_" . TIMESTAMP . ".csv");
                echo $html;
                exit();
            }
            $pindex                            = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
            $psize                             = 10;
            $start                             = ($pindex - 1) * $psize;
            $list                              = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}'  $where $where2 order by id desc LIMIT " . $start . "," . $psize);
            $total                             = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_trade') . " WHERE weid='" . $_W['uniacid'] . "' $where $where2");
            $pager                             = pagination($total, $pindex, $psize);
            $allItem                           = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' $where $where2 ");
            $payAry                            = array();
            $payAry['wechart']['all']          = 0;
            $payAry['wechart']['all-count']    = 0;
            $payAry['wechart']['coupon']       = 0;
            $payAry['wechart']['coupon-count'] = 0;
            $payAry['wechart']['fee']          = 0;
            $payAry['wechart']['fee-count']    = 0;
            $payAry['alipay']['all']           = 0;
            $payAry['alipay']['all-count']     = 0;
            $payAry['alipay']['coupon']        = 0;
            $payAry['alipay']['coupon-count']  = 0;
            $payAry['alipay']['fee']           = 0;
            $payAry['alipay']['fee-count']     = 0;
            foreach ($allItem as $row) {
                if ($row['status'] == 1) {
                    if ($row['total_fee']) {
                        if (!$row['paytype']) {
                            $payAry['wechart']['all']       = $payAry['wechart']['all'] + $row['total_fee'];
                            $payAry['wechart']['all-count'] = $payAry['wechart']['all-count'] + 1;
                        } else {
                            $payAry['alipay']['all']       = $payAry['alipay']['all'] + $row['total_fee'];
                            $payAry['alipay']['all-count'] = $payAry['alipay']['all-count'] + 1;
                        }
                    }
                    if ($row['coupon_fee']) {
                        if (!$row['paytype']) {
                            $payAry['wechart']['coupon']       = $payAry['wechart']['coupon'] + $row['coupon_fee'];
                            $payAry['wechart']['coupon-count'] = $payAry['wechart']['coupon-count'] + 1;
                        } else {
                            $payAry['alipay']['coupon']       = $payAry['alipay']['coupon'] + $row['coupon_fee'];
                            $payAry['alipay']['coupon-count'] = $payAry['alipay']['coupon-count'] + 1;
                        }
                    }
                    if ($row['cash_fee']) {
                        if (!$row['paytype']) {
                            $payAry['wechart']['cash_fee']       = $payAry['wechart']['cash_fee'] + $row['cash_fee'];
                            $payAry['wechart']['cash_fee-count'] = $payAry['wechart']['cash_fee-count'] + 1;
                        } else {
                            $payAry['alipay']['cash_fee']       = $payAry['alipay']['cash_fee'] + $row['cash_fee'];
                            $payAry['alipay']['cash_fee-count'] = $payAry['alipay']['cash_fee-count'] + 1;
                        }
                    }
                }
            }
            $year      = pdo_fetchall("SELECT year(createdate) as y FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' group by year(createdate) order by id asc  ");
            $month     = array(
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12
            );
            $day       = array(
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                13,
                14,
                15,
                16,
                17,
                18,
                19,
                20,
                21,
                22,
                23,
                24,
                25,
                26,
                27,
                28,
                29,
                30,
                31
            );
            $user      = pdo_fetchall("SELECT id,useracount,realname,pcate FROM " . tablename('j_money_user') . " WHERE weid = '{$_W['uniacid']}' order by id desc ");
            $userList  = array();
            $groupids  = array();
            $grouplist = pdo_fetchall("SELECT * FROM " . tablename('j_money_group') . " WHERE weid = '{$_W['uniacid']}' order by id asc ");
            foreach ($grouplist as $row) {
                $groupids[$row['id']] = $row['companyname'];
            }
            foreach ($user as $row) {
                $userList[$row['id']] = $groupids[$row['pcate']] . "-" . $row['useracount'] . '(' . $row['realname'] . ')';
            }
            $data = array(
                "CFT" => "零钱包",
                "ICBC_DEBIT" => "工商银行(借记卡)",
                "ICBC_CREDIT" => "工商银行(信用卡)",
                "ABC_DEBIT" => "农业银行(借记卡)",
                "ABC_CREDIT" => "农业银行(信用卡)",
                "PSBC_DEBIT" => "邮政储蓄银行(借记卡)",
                "PSBC_CREDIT" => "邮政储蓄银行(信用卡)",
                "CCB_DEBIT" => "建设银行(借记卡)",
                "CCB_CREDIT" => "建设银行(信用卡)",
                "CMB_DEBIT" => "招商银行(借记卡)",
                "CMB_CREDIT" => "招商银行(信用卡)",
                "BOC_DEBIT" => "中国银行(借记卡)",
                "BOC_CREDIT" => "中国银行(信用卡)",
                "COMM_DEBIT" => "交通银行(借记卡)",
                "SPDB_DEBIT" => "浦发银行(借记卡)",
                "SPDB_CREDIT" => "浦发银行(信用卡)",
                "GDB_DEBIT" => "广发银行(借记卡)",
                "GDB_CREDIT" => "广发银行(信用卡)",
                "CMBC_DEBIT" => "民生银行(借记卡)",
                "CMBC_CREDIT" => "民生银行(信用卡)",
                "PAB_DEBIT" => "平安银行(借记卡)",
                "PAB_CREDIT" => "平安银行(信用卡)",
                "CEB_DEBIT" => "光大银行(借记卡)",
                "CEB_CREDIT" => "光大银行(信用卡)",
                "CIB_DEBIT" => "兴业银行(借记卡)",
                "CIB_CREDIT" => "兴业银行(信用卡)",
                "CITIC_DEBIT" => "中信银行(借记卡)",
                "CITIC_CREDIT" => "中信银行(信用卡)",
                "BOSH_DEBIT" => "上海银行(借记卡)",
                "BOSH_CREDIT" => "上海银行(信用卡)",
                "CRB_DEBIT" => "华润银行(借记卡)",
                "HZB_DEBIT" => "杭州银行(借记卡)",
                "HZB_CREDIT" => "杭州银行(信用卡)",
                "BSB_DEBIT" => "包商银行(借记卡)",
                "BSB_CREDIT" => "包商银行(信用卡)",
                "CQB_DEBIT" => "重庆银行(借记卡)",
                "SDEB_DEBIT" => "顺德农商行(借记卡)",
                "SZRCB_DEBIT" => "深圳农商银行(借记卡)",
                "HRBB_DEBIT" => "哈尔滨银行(借记卡)",
                "BOCD_DEBIT" => "成都银行(借记卡)",
                "GDNYB_DEBIT" => "南粤银行(借记卡)",
                "GDNYB_CREDIT" => "南粤银行(信用卡)",
                "GZCB_DEBIT" => "广州银行(借记卡)",
                "GZCB_CREDIT" => "广州银行(信用卡)",
                "JSB_DEBIT" => "江苏银行(借记卡)",
                "JSB_CREDIT" => "江苏银行(信用卡)",
                "NBCB_DEBIT" => "宁波银行(借记卡)",
                "NBCB_CREDIT" => "宁波银行(信用卡)",
                "NJCB_DEBIT" => "南京银行(借记卡)",
                "JZB_DEBIT" => "晋中银行(借记卡)",
                "KRCB_DEBIT" => "昆山农商(借记卡)",
                "LJB_DEBIT" => "龙江银行(借记卡)",
                "LNNX_DEBIT" => "辽宁农信(借记卡)",
                "LZB_DEBIT" => "兰州银行(借记卡)",
                "WRCB_DEBIT" => "无锡农商(借记卡)",
                "ZYB_DEBIT" => "中原银行(借记卡)",
                "ZJRCUB_DEBIT" => "浙江农信(借记卡)",
                "WZB_DEBIT" => "温州银行(借记卡)",
                "XAB_DEBIT" => "西安银行(借记卡)",
                "JXNXB_DEBIT" => "江西农信(借记卡)",
                "NCB_DEBIT" => "宁波通商银行(借记卡)",
                "NYCCB_DEBIT" => "南阳村镇银行(借记卡)",
                "NMGNX_DEBIT" => "内蒙古农信(借记卡)",
                "SXXH_DEBIT" => "陕西信合(借记卡)",
                "SRCB_CREDIT" => "上海农商银行(信用卡)",
                "SJB_DEBIT" => "盛京银行(借记卡)",
                "SDRCU_DEBIT" => "山东农信(借记卡)",
                "SRCB_DEBIT" => "上海农商银行(借记卡)",
                "SCNX_DEBIT" => "四川农信(借记卡)",
                "QLB_DEBIT" => "齐鲁银行(借记卡)",
                "QDCCB_DEBIT" => "青岛银行(借记卡)",
                "PZHCCB_DEBIT" => "攀枝花银行(借记卡)",
                "ZJTLCB_DEBIT" => "浙江泰隆银行(借记卡)",
                "TJBHB_DEBIT" => "天津滨海农商行(借记卡)",
                "WEB_DEBIT" => "微众银行(借记卡)",
                "YNRCCB_DEBIT" => "云南农信(借记卡)",
                "WFB_DEBIT" => "潍坊银行(借记卡)",
                "WHRC_DEBIT" => "武汉农商行(借记卡)",
                "ORDOSB_DEBIT" => "鄂尔多斯银行(借记卡)",
                "XJRCCB_DEBIT" => "新疆农信银行(借记卡)",
                "ORDOSB_CREDIT" => "鄂尔多斯银行(信用卡)",
                "CSRCB_DEBIT" => "常熟农商银行(借记卡)",
                "JSNX_DEBIT" => "江苏农商行(借记卡)",
                "GRCB_CREDIT" => "广州农商银行(信用卡)",
                "GLB_DEBIT" => "桂林银行(借记卡)",
                "GDRCU_DEBIT" => "广东农信银行(借记卡)",
                "GDHX_DEBIT" => "广东华兴银行(借记卡)",
                "FJNX_DEBIT" => "福建农信银行(借记卡)",
                "DYCCB_DEBIT" => "德阳银行(借记卡)",
                "DRCB_DEBIT" => "东莞农商行(借记卡)",
                "CZCB_DEBIT" => "稠州银行(借记卡)",
                "CZB_DEBIT" => "浙商银行(借记卡)",
                "CZB_CREDIT" => "浙商银行(信用卡)",
                "GRCB_DEBIT" => "广州农商银行(借记卡)",
                "CSCB_DEBIT" => "长沙银行(借记卡)",
                "CQRCB_DEBIT" => "重庆农商银行(借记卡)",
                "CBHB_DEBIT" => "渤海银行(借记卡)",
                "BOIMCB_DEBIT" => "内蒙古银行(借记卡)",
                "BOD_DEBIT" => "东莞银行(借记卡)",
                "BOD_CREDIT" => "东莞银行(信用卡)",
                "BOB_DEBIT" => "北京银行(借记卡)",
                "BNC_DEBIT" => "江西银行(借记卡)",
                "BJRCB_DEBIT" => "北京农商行(借记卡)",
                "AE_CREDIT" => "AE(信用卡)",
                "GYCB_CREDIT" => "贵阳银行(信用卡)",
                "JSHB_DEBIT" => "晋商银行(借记卡)",
                "JRCB_DEBIT" => "江阴农商行(借记卡)",
                "JNRCB_DEBIT" => "江南农商(借记卡)",
                "JLNX_DEBIT" => "吉林农信(借记卡)",
                "JLB_DEBIT" => "吉林银行(借记卡)",
                "JJCCB_DEBIT" => "九江银行(借记卡)",
                "HXB_DEBIT" => "华夏银行(借记卡)",
                "HXB_CREDIT" => "华夏银行(信用卡)",
                "HUNNX_DEBIT" => "湖南农信(借记卡)",
                "HSB_DEBIT" => "徽商银行(借记卡)",
                "HSBC_DEBIT" => "恒生银行(借记卡)",
                "HRXJB_DEBIT" => "华融湘江银行(借记卡)",
                "HNNX_DEBIT" => "河南农信(借记卡)",
                "HKBEA_DEBIT" => "东亚银行(借记卡)",
                "HEBNX_DEBIT" => "河北农信(借记卡)",
                "HBNX_DEBIT" => "湖北农信(借记卡)",
                "HBNX_CREDIT" => "湖北农信(信用卡)",
                "GYCB_DEBIT" => "贵阳银行(借记卡)",
                "GSNX_DEBIT" => "甘肃农信(借记卡)",
                "JCB_CREDIT" => "JCB(信用卡)",
                "MASTERCARD_CREDIT" => "MASTERCARD(信用卡)",
                "VISA_CREDIT" => "VISA(信用卡)"
            );
        } elseif ($operation == 'post') {
            $where = $where2 = "";
            if ($_GPC['userid'])
                $where2 .= " and userid='" . $_GPC['userid'] . "'";
            $start = $_GPC['search']['start'] ? $_GPC['search']['start'] : date("Y-m-d");
            $end   = $_GPC['search']['end'] ? $_GPC['search']['end'] : date("Y-m-d");
            $where .= " and createdate>='" . $start . "' and createdate<='" . $end . "'";
            if ($_GPC['groupid']) {
                $u_list = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_user') . " WHERE pcate=:a", array(
                    ":a" => $_GPC['groupid']
                ));
                if ($u_list)
                    $where2 .= " and userid in(SELECT id FROM " . tablename('j_money_user') . " WHERE pcate='" . $_GPC['groupid'] . "')";
            }
            $list     = pdo_fetchall("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and refundstatus=0 $where $where2 and status>0 order by id asc");
            $listary  = array();
            $totalary = array(
                "total" => 0,
                "cash" => 0,
                "coupon" => 0,
                "num" => 0
            );
            foreach ($list as $row) {
                $totalary['total']  = $totalary['total'] + $row['total_fee'];
                $totalary['cash']   = $totalary['cash'] + $row['cash_fee'];
                $totalary['coupon'] = $totalary['coupon'] + $row['coupon_fee'];
                $totalary['num']    = $totalary['num'] + 1;
                if (!isset($listary[$row['createdate']])) {
                    $listary[$row['createdate']] = array(
                        "wechat" => 0,
                        "ali" => 0,
                        "total" => 0,
                        "coupon" => 0,
                        "num" => 0
                    );
                }
                if ($row['paytype']) {
                    $listary[$row['createdate']]['ali'] = $listary[$row['createdate']]['ali'] + $row['total_fee'];
                } else {
                    $listary[$row['createdate']]['wechat'] = $listary[$row['createdate']]['wechat'] + $row['total_fee'];
                }
                $listary[$row['createdate']]['total']  = $listary[$row['createdate']]['total'] + $row['total_fee'];
                $listary[$row['createdate']]['coupon'] = $listary[$row['createdate']]['coupon'] + $row['coupon_fee'];
                $listary[$row['createdate']]['num']    = $listary[$row['createdate']]['num'] + 1;
            }
            $datediff   = intval((strtotime($end) - strtotime($start)) / 60 / 60 / 24);
            $dateary    = array();
            $fee_wechat = array();
            $fee_ali    = array();
            $fee_total  = array();
            for ($i = 0; $i <= $datediff; $i++) {
                $date         = date("Y-m-d", strtotime("+" . $i . " day", strtotime($start)));
                $dateary[]    = $date;
                $fee_wechat[] = sprintf('%.2f', ($listary[$date]['wechat'] * 0.01));
                $fee_ali[]    = sprintf('%.2f', ($listary[$date]['ali'] * 0.01));
                $fee_total[]  = sprintf('%.2f', (($listary[$date]['wechat'] + $listary[$date]['ali']) * 0.01));
            }
            $dateary_str    = implode("','", $dateary);
            $fee_wechat_str = implode(",", $fee_wechat);
            $fee_ali_str    = implode(",", $fee_ali);
            $fee_total_str  = implode(",", $fee_total);
            $user           = pdo_fetchall("SELECT id,useracount,realname,pcate FROM " . tablename('j_money_user') . " WHERE weid = '{$_W['uniacid']}' order by id desc ");
            $userList       = array();
            $groupids       = array();
            $grouplist      = pdo_fetchall("SELECT * FROM " . tablename('j_money_group') . " WHERE weid = '{$_W['uniacid']}' order by id asc ");
            foreach ($grouplist as $row) {
                $groupids[$row['id']] = $row['companyname'];
            }
            foreach ($user as $row) {
                $userList[$row['id']] = $groupids[$row['pcate']] . "-" . $row['useracount'] . '(' . $row['realname'] . ')';
            }
        } elseif ($operation == 'card') {
            $where = $where2 = "";
            $start = $_GPC['search']['start'] ? $_GPC['search']['start'] : date("Y-m-d");
            $end   = $_GPC['search']['end'] ? $_GPC['search']['end'] : date("Y-m-d");
            $where .= " and createtime>='" . strtotime($start) . "' and createtime<='" . strtotime($end) . "'";
            $where2 .= " and addtime>='" . strtotime($start) . "' and addtime<='" . strtotime($end) . "'";
            $couponType = array(
                "cash" => "代金券",
                "gift" => "礼品券",
                "groupon" => "团购券",
                "discount" => "折扣券",
                "general_coupon" => "优惠券"
            );
            $couponList = pdo_fetchall("SELECT * FROM " . tablename('coupon') . " WHERE uniacid='{$_W['uniacid']}' order by id desc");
            $recordary  = array();
            $totalAll   = array(
                "total" => 0,
                "used" => 0
            );
            foreach ($couponList as $row) {
                $recordary[$row['card_id']]['total'] = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('coupon_record') . " WHERE uniacid='{$_W['uniacid']}' and card_id=:a $where2 ", array(
                    ":a" => $row['card_id']
                ));
                $recordary[$row['card_id']]['used']  = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_carduser') . " WHERE weid='{$_W['uniacid']}' and cardid=:a $where", array(
                    ":a" => $row['card_id']
                ));
                $totalAll['"total"']                 = $totalAll['"total"'] + $recordary[$row['card_id']]['total'];
                $totalAll['"used"']                  = $totalAll['"used"'] + $recordary[$row['card_id']]['used'];
            }
        } elseif ($operation == 'clear') {
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if ($id) {
                if (!$_W['isfounder'])
                    message('删除订单必须是管理员方能删除！');
                pdo_delete('j_money_trade', array(
                    'id' => $id
                ));
            }
            message("删除成功", $this->createWebUrl('history'), 'success');
        }
        include $this->template('history');
    }
    public function doWebWajax()
    {
        global $_GPC, $_W;
        if (!$_W['isajax'])
            die(json_encode(array(
                'success' => false,
                'msg' => "错误！"
            )));
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $cfg       = $this->module['config'];
        if ($operation == "cheackwechatpay") {
            load()->func('communication');
            $id          = $_GPC["id"];
            $trade       = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $id
            ));
            $mch_id      = $cfg['pay_mchid'];
            $pay_signkey = $cfg['pay_signkey'];
            $pageparama  = array(
                "appid" => $cfg['appid'],
                "mch_id" => strval($mch_id),
                "out_trade_no" => $orderid,
                "nonce_str" => getNonceStr()
            );
            if ($cfg['sub_appid']) {
                $pageparama['sub_appid'] = $cfg['sub_appid'];
            }
            if ($cfg['sub_mch_id']) {
                $pageparama['sub_mch_id'] = $cfg['sub_mch_id'];
            }
            $sign               = MakeSign($pageparama, $pay_signkey);
            $pageparama['sign'] = $sign;
            $xml                = ToXml($pageparama);
            $response           = postXmlCurl($xml, "https://api.mch.weixin.qq.com/pay/orderquery", 10);
            $result             = FromXml($response);
            if ($result['trade_state'] == 'SUCCESS' && $trade['status'] == 0) {
                $insertInfo = array(
                    "openid" => $result['openid'],
                    "is_subscribe" => $result['is_subscribe'] == "Y" ? 1 : 0,
                    "trade_type" => $result['trade_type'],
                    "bank_type" => $result['bank_type'],
                    "fee_type" => $result['CNY'],
                    "transaction_id" => $result['transaction_id'],
                    "time_end" => strtotime($result['time_end']),
                    "isconfirm" => 1,
                    "status" => 1
                );
                pdo_update("j_money_trade", $insertInfo, array(
                    "id" => $trade['id']
                ));
                die(json_encode(array(
                    "success" => true
                )));
            }
            die(json_encode(array(
                "success" => false
            )));
        }
        if ($operation == "cheackalipay") {
            load()->func('communication');
            $id    = $_GPC["id"];
            $trade = pdo_fetch("SELECT * FROM " . tablename('j_money_trade') . " WHERE weid='{$_W['uniacid']}' and id=:a ", array(
                ":a" => $id
            ));
            require_once '../addons/j_money/F2fpay.php';
            $cfg      = $this->module['config'];
            $f2fpay   = new F2fpay();
            $response = $f2fpay->query($orderid, $cfg);
            $results  = @json_decode(json_encode($response), true);
            $result   = $results['alipay_trade_query_response'];
            if ($result['code'] == 10000) {
                if ($result['trade_status'] == "TRADE_SUCCESS") {
                    $insertdata = array(
                        "status" => 1,
                        "isconfirm" => 1,
                        "transaction_id" => $result['trade_no'],
                        "time_end" => strtotime($result['gmt_payment'])
                    );
                    pdo_update("j_money_trade", $insertdata, array(
                        "id" => $id
                    ));
                    die(json_encode(array(
                        "success" => true
                    )));
                } else {
                    die(json_encode(array(
                        "success" => false
                    )));
                }
            }
            die(json_encode(array(
                "success" => false
            )));
        }
    }
    public function doWebStatistical()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == "display") {
            $pindex = intval($_GPC['page']) ? intval($_GPC['page']) - 1 : 0;
            $psize  = 20;
            $start  = $pindex * $psize;
            $list   = pdo_fetchall("SELECT * FROM " . tablename('j_money_marketing') . " WHERE weid='{$_W['uniacid']}' order by status desc,displayorder asc,id desc LIMIT " . $start . "," . $psize);
            $total  = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_marketing') . " WHERE weid='" . $_W['uniacid'] . "'  ");
            $pager  = pagination($total, $pindex, $psize);
        }
    }
    public function doWebLottery()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == "display") {
            $pindex    = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
            $psize     = 10;
            $start     = ($pindex - 1) * $psize;
            $list      = pdo_fetchall("SELECT * FROM " . tablename('j_money_lotterygame') . " WHERE weid='{$_W['uniacid']}' order by id desc LIMIT " . $start . "," . $psize);
            $total     = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('j_money_lotterygame') . " WHERE weid='" . $_W['uniacid'] . "' ");
            $pager     = pagination($total, $pindex, $psize);
            $prizelist = array();
            $list2     = pdo_fetchall("SELECT * FROM " . tablename('j_money_award') . " WHERE weid='{$_W['uniacid']}' and isprize=1 order by id asc");
            foreach ($list2 as $row) {
                $prizelist[$row['gid']][] = $row;
            }
        } elseif ($operation == 'post') {
            $id = $_GPC['id'];
            if ($id) {
                $reply = pdo_fetch("SELECT * FROM " . tablename('j_money_lotterygame') . " WHERE id = :id ", array(
                    ':id' => $id
                ));
                $list  = pdo_fetchall("SELECT * FROM " . tablename("j_money_award") . " WHERE gid = :gid ORDER BY `id` asc", array(
                    ':gid' => $id
                ));
            }
            $reply['zppic']         = $reply['zppic'] ? $reply['zppic'] : '../addons/j_money/template/img/6prize.png';
            $reply['thumb_pointer'] = $reply['thumb_pointer'] ? $reply['thumb_pointer'] : '../addons/j_money/template/img/pointer.gif';
            if (checksubmit('submit')) {
                $insert = array(
                    'weid' => $_W['uniacid'],
                    'thumb' => $_GPC['thumb'],
                    'clientpic' => $_GPC['clientpic'],
                    'pointer' => $_GPC['pointer'],
                    'description' => $_GPC['description'],
                    'title' => $_GPC['title'],
                    'zppic' => $_GPC['zppic'],
                    'rule' => htmlspecialchars_decode($_GPC['rule']),
                    'starttime' => strtotime($_GPC['acttime']['start']),
                    'endtime' => strtotime($_GPC['acttime']['end']),
                    'status' => intval($_GPC['status']),
                    'gzurl' => strval($_GPC['gzurl']),
                    'sharedes' => strval($_GPC['sharedes']),
                    'thumb_bg' => strval($_GPC['thumb_bg']),
                    'thumb_pointer' => strval($_GPC['thumb_pointer']),
                    'bgcolor' => strval($_GPC['bgcolor'])
                );
                if ($id) {
                    pdo_update("j_money_lotterygame", $insert, array(
                        "id" => $id
                    ));
                    foreach ($_GPC['award-level'] as $index => $row) {
                        $data = array(
                            'level' => $_GPC['award-level'][$index],
                            'title' => $_GPC['award-title'][$index],
                            'total' => $_GPC['award-total'][$index],
                            'renum' => $_GPC['award-renum'][$index],
                            'description' => $_GPC['award-description'][$index],
                            'thumb' => $_GPC['award-thumb'][$index],
                            'credit' => intval($_GPC['award-credit'][$index]),
                            'isprize' => intval($_GPC['award-isprize'][$index]),
                            'leavel' => intval($_GPC['award-leavel'][$index]),
                            'probalilty' => $_GPC['award-probalilty'][$index],
                            'deg' => $_GPC['award-deg'][$index]
                        );
                        pdo_update('j_money_award', $data, array(
                            'id' => $index
                        ));
                    }
                } else {
                    $insert['status'] = 1;
                    pdo_insert("j_money_lotterygame", $insert);
                    $id = pdo_insertid();
                    foreach ($_GPC['award-level-new'] as $index => $row) {
                        $data = array(
                            'gid' => $id,
                            'weid' => $_W['uniacid'],
                            'level' => $_GPC['award-level-new'][$index],
                            'leavel' => intval($_GPC['award-leavel-new'][$index]),
                            'thumb' => $_GPC['award-thumb-new'][$index],
                            'credit' => intval($_GPC['award-credit-new'][$index]),
                            'title' => $_GPC['award-title-new'][$index],
                            'description' => $_GPC['award-description-new'][$index],
                            'isprize' => intval($_GPC['award-isprize-new'][$index]),
                            'total' => $_GPC['award-total-new'][$index],
                            'renum' => $_GPC['award-total-new'][$index],
                            'probalilty' => $_GPC['award-probalilty-new'][$index],
                            'deg' => $_GPC['award-deg-new'][$index]
                        );
                        pdo_insert('j_money_award', $data);
                    }
                }
                message("修改完成", $this->createWebUrl('lottery', array(
                    'op' => 'post',
                    'id' => $id
                )), 'success');
            }
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if ($id) {
                pdo_delete('j_money_award', array(
                    'gid' => $id
                ));
                pdo_delete('j_money_lotterygame', array(
                    'id' => $id
                ));
            }
            message("删除成功", $this->createWebUrl('lottery'), 'success');
        }
        include $this->template('lottery');
    }
    public function doWebJoiner()
    {
        global $_GPC, $_W;
        $id        = intval($_GPC['id']);
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if (checksubmit('getprize')) {
            pdo_query("update " . tablename('j_money_lottery') . " set status=1,gettime='" . TIMESTAMP . "' where id  IN  ('" . implode("','", $_GPC['select']) . "')");
            message('标记成功！', $this->createWebUrl('joiner', array(
                'id' => $id,
                'page' => $_GPC['page']
            )));
        }
        if (!empty($_GPC['wid'])) {
            $wid = intval($_GPC['wid']);
            pdo_update('j_money_lottery', array(
                'status' => intval($_GPC['status']),
                'gettime' => TIMESTAMP
            ), array(
                'id' => $wid
            ));
            message('标识成功！', $this->createWebUrl('joiner', array(
                'id' => $id,
                'page' => $_GPC['page']
            )));
        }
        if ($operation == 'display') {
            $pindex = max(1, intval($_GPC['page']));
            $psize  = 50;
            $where  = "";
            if ($_GPC['prizeid'])
                $where .= " and aid = '" . $_GPC['prizeid'] . "' ";
            if ($_GPC['sncode'])
                $where .= " and sncode = '" . $_GPC['sncode'] . "' ";
            $item      = pdo_fetch("SELECT * FROM " . tablename('j_money_lotterygame') . " WHERE id = '$id' limit 1");
            $prizelist = pdo_fetchall("SELECT * FROM " . tablename('j_money_award') . " WHERE gid = '$id' and isprize=1 order by id asc");
            $sql       = "SELECT * FROM " . tablename('j_money_lottery') . "  WHERE gid = '$id' and weid='{$_W['uniacid']}' and isprize=1 $where order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}";
            $list      = pdo_fetchall($sql);
            if (!empty($list)) {
                $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('j_money_lottery') . " WHERE gid = '$id' and isprize=1 and weid='{$_W['uniacid']}' $where");
                $pager = pagination($total, $pindex, $psize);
            }
            $alljoin = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('j_money_lottery') . "  WHERE gid = '$id' and weid='{$_W['uniacid']}' and aid>0");
        }
        include $this->template('joiner');
    }
    public function doWebExtendbtn()
    {
        global $_GPC, $_W;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == "display") {
            $list = pdo_fetchall("SELECT * FROM " . tablename('j_money_extend') . " WHERE weid='{$_W['uniacid']}' order by id desc ");
        } elseif ($operation == 'post') {
            $id = $_GPC['id'];
            if ($id)
                $category = pdo_fetch("SELECT * FROM " . tablename('j_money_extend') . " WHERE id = :id ", array(
                    ':id' => $id
                ));
            if (checksubmit('submit')) {
                $data = array(
                    'weid' => $_W['uniacid'],
                    'status' => intval($_GPC['status']),
                    'btnname' => $_GPC['btnname'],
                    'btnurl' => $_GPC['btnurl'],
                    'jsurl' => $_GPC['jsurl2'],
                    'cssurl' => $_GPC['cssurl2']
                );
                load()->func('file');
                $dir_url = '../attachment/j_money/js/' . $_W['uniacid'] . "/";
                mkdirs($dir_url);
                if ($_FILES["jsurl"]["name"]) {
                    if (file_exists($dir_url . $category["jsurl"]))
                        @unlink($dir_url . $category["jsurl"]);
                    $data['jsurl'] = TIMESTAMP . ".js";
                    move_uploaded_file($_FILES["jsurl"]["tmp_name"], $dir_url . $data['jsurl']);
                }
                if ($_FILES["cssurl"]["name"]) {
                    if (file_exists($dir_url . $category["cssurl"]))
                        @unlink($dir_url . $category["cssurl"]);
                    $data['cssurl'] = TIMESTAMP . ".css";
                    move_uploaded_file($_FILES["cssurl"]["tmp_name"], $dir_url . $data['cssurl']);
                }
                if ($id) {
                    pdo_update("j_money_extend", $data, array(
                        "id" => $id
                    ));
                } else {
                    pdo_insert("j_money_extend", $data);
                    $id = pdo_insertid();
                }
                message("修改完成", $this->createWebUrl('extendbtn', array(
                    'op' => 'post',
                    'id' => $id
                )), 'success');
            }
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if ($id) {
                $category = pdo_fetch("SELECT * FROM " . tablename('j_money_extend') . " WHERE id = :id ", array(
                    ':id' => $id
                ));
                load()->func('file');
                $dir_url = '../attachment/j_money/js/' . $_W['uniacid'] . "/";
                if (file_exists($dir_url . $category["jsurl"]))
                    @unlink($dir_url . $category["jsurl"]);
                pdo_delete('j_money_extend', array(
                    'id' => $id
                ));
            }
            message("删除成功", $this->createWebUrl('extendbtn'), 'success');
        }
        include $this->template('extendbtn');
    }
    public function _sendpack($openid, $orderid = 0, $fee = 0, $cfg = array())
    {
        global $_W;
        if ($fee < 100)
            return false;
        $url                  = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        $pars                 = array();
        $pars['nonce_str']    = random(32);
        $pars['mch_billno']   = $cfg['mchid'] . date('YmdHis') . rand(1000, 9999);
        $pars['mch_id']       = $cfg['pay_mchid'];
        $pars['wxappid']      = $cfg['appid'];
        $pars['send_name']    = $cfg['pay_name'];
        $pars['re_openid']    = $openid;
        $pars['total_amount'] = $fee;
        $pars['total_num']    = 1;
        $pars['wishing']      = "微信支付，便捷生活";
        $pars['client_ip']    = $cfg['pay_ip'];
        $pars['act_name']     = $cfg['pay_name'];
        $pars['remark']       = $cfg['pay_name'];
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key=" . $cfg['pay_signkey'];
        $pars['sign']              = strtoupper(md5($string1));
        $xml                       = array2xml($pars);
        $extras                    = array();
        $extras['CURLOPT_CAINFO']  = IA_ROOT . '/attachment/j_money/cert_2/' . $_W['uniacid'] . '/' . $cfg['rootca'];
        $extras['CURLOPT_SSLCERT'] = IA_ROOT . '/attachment/j_money/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_cert'];
        $extras['CURLOPT_SSLKEY']  = IA_ROOT . '/attachment/j_money/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_key'];
        $procResult                = null;
        load()->func('communication');
        $resp = ihttp_request($url, $xml, $extras);
        if (is_error($resp)) {
            $procResult = $resp;
        } else {
            $arr = json_decode(json_encode((array) simplexml_load_string($resp['content'])), true);
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new \DOMDocument();
            if ($dom->loadXML($xml)) {
                $xpath = new \DOMXPath($dom);
                $code  = $xpath->evaluate('string(//xml/return_code)');
                $ret   = $xpath->evaluate('string(//xml/result_code)');
                if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                    $procResult = array(
                        'errno' => 0,
                        'error' => 'success'
                    );
                } else {
                    $error      = $xpath->evaluate('string(//xml/err_code_des)');
                    $procResult = array(
                        'errno' => -2,
                        'error' => $error
                    );
                }
            } else {
                $procResult = array(
                    'errno' => -1,
                    'error' => '未知错误'
                );
            }
        }
        $rec              = array();
        $rec['log']       = $error;
        $rec['reward']    = $fee;
        $rec['completed'] = $rec['status'] = $procResult['errno'] != 0 ? $procResult['errno'] : 1;
        if ($rec['completed'] == 1)
            $rec['endtime'] = TIMESTAMP;
        pdo_update('j_money_reward', $rec, array(
            'out_trade_no' => $orderid
        ));
        return $procResult;
    }
    public function _sendpack2($openid, $fee = 0, $cfg = array())
    {
        global $_W;
        if ($fee < 100)
            return false;
        $url                  = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        $pars                 = array();
        $pars['nonce_str']    = random(32);
        $pars['mch_billno']   = $cfg['mchid'] . date('YmdHis') . rand(1000, 9999);
        $pars['mch_id']       = $cfg['pay_mchid'];
        $pars['wxappid']      = $cfg['appid'];
        $pars['send_name']    = $cfg['pay_name'];
        $pars['re_openid']    = $openid;
        $pars['total_amount'] = $fee;
        $pars['total_num']    = 1;
        $pars['wishing']      = "微信支付，便捷生活";
        $pars['client_ip']    = $cfg['pay_ip'];
        $pars['act_name']     = $cfg['pay_name'];
        $pars['remark']       = $cfg['pay_name'];
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key=" . $cfg['pay_signkey'];
        $pars['sign']              = strtoupper(md5($string1));
        $xml                       = array2xml($pars);
        $extras                    = array();
        $extras['CURLOPT_CAINFO']  = IA_ROOT . '/attachment/j_money/cert_2/' . $_W['uniacid'] . '/' . $cfg['rootca'];
        $extras['CURLOPT_SSLCERT'] = IA_ROOT . '/attachment/j_money/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_cert'];
        $extras['CURLOPT_SSLKEY']  = IA_ROOT . '/attachment/j_money/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_key'];
        $procResult                = null;
        load()->func('communication');
        $resp = ihttp_request($url, $xml, $extras);
        if (is_error($resp)) {
            $procResult = $resp;
        } else {
            $arr = json_decode(json_encode((array) simplexml_load_string($resp['content'])), true);
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new \DOMDocument();
            if ($dom->loadXML($xml)) {
                $xpath = new \DOMXPath($dom);
                $code  = $xpath->evaluate('string(//xml/return_code)');
                $ret   = $xpath->evaluate('string(//xml/result_code)');
                if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                    $procResult = array(
                        'errno' => 0,
                        'error' => 'success'
                    );
                } else {
                    $error      = $xpath->evaluate('string(//xml/err_code_des)');
                    $procResult = array(
                        'errno' => -2,
                        'error' => $error
                    );
                }
            } else {
                $procResult = array(
                    'errno' => -1,
                    'error' => '未知错误'
                );
            }
        }
        return $procResult;
    }
    public function sendCard($openid, $cardid)
    {
        global $_W;
        if (strlen($cardid) < 5)
            return false;
        $acid = $_W['account']['acid'];
        if (!$acid) {
            $acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account') . " WHERE uniacid=:uniacid ", array(
                ':uniacid' => $_W['uniacid']
            ));
        }
        $acc               = WeAccount::create($acid);
        $ticket            = $this->getCard();
        $pars['nonce_str'] = random(32);
        $pars['code']      = "";
        $pars['openid']    = $openid;
        $pars['timestamp'] = TIMESTAMP;
        $pars['signature'] = "";
        $string1           = $pars['timestamp'] . $pars['nonce_str'] . $pars['code'] . $ticket . $cardid;
        $pars['signature'] = sha1($string1);
        $sendata           = array(
            "card_id" => $cardid,
            "card_ext" => array(
                "code" => $pars['code'],
                "openid" => $pars['openid'],
                "timestamp" => $pars['timestamp'],
                "signature" => $pars['signature']
            )
        );
        $data              = $acc->sendCustomNotice(array(
            'touser' => $openid,
            'msgtype' => 'wxcard',
            'wxcard' => $sendata
        ));
        return $data;
    }
    public function getCard()
    {
        global $_W;
        load()->func('cache');
        $wxcard = cache_load("wxcard");
        if (!$wxcard || $wxcard['extime'] < TIMESTAMP) {
            load()->func('communication');
            $acid    = pdo_fetchcolumn("SELECT acid FROM " . tablename('account') . " WHERE uniacid=:uniacid ", array(
                ':uniacid' => $_W['uniacid']
            ));
            $acc     = WeAccount::create($acid);
            $tokens  = $acc->fetch_token();
            $url     = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=" . $tokens . "&type=wx_card";
            $content = ihttp_get($url);
            if (is_error($content))
                return false;
            $token = @json_decode($content['content'], true);
            if (empty($token) || !is_array($token)) {
                $errorinfo = substr($content['meta'], strpos($content['meta'], '{'));
                $errorinfo = @json_decode($errorinfo, true);
                return false;
            }
            $record           = array();
            $record['ticket'] = $token['ticket'];
            $record['expire'] = TIMESTAMP + $token['expires_in'];
            cache_write("wxcard", array(
                "ticket" => $record['ticket'],
                "expire" => $record['expire']
            ));
            return $record['ticket'];
        }
        return $wxcard['ticket'];
    }
    public function doWebExtendfun()
    {
        global $_W, $_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == "display") {
            $hostdir    = "../addons/j_money/extension/";
            $filesnames = scandir($hostdir);
            $extendlist = array();
            foreach ($filesnames as $name) {
                if ($name == "." || $name == "..")
                    continue;
                $extendlist[] = $name;
            }
        } else {
        }
        include $this->template('extend');
    }
    public function doMobileExtension()
    {
        global $_W, $_GPC;
        $Extension_modal = $_GPC['extend_modal'];
        $Extension_do    = $_GPC['extend_do'] ? $_GPC['extend_do'] : "Main";
        include_once 'template/extension/' . strtolower($Extension_modal) . '/site.php';
        $modalClass = new $Extension_modal();
        call_user_func(array(
            $modalClass,
            $Extension_do
        ));
    }
}