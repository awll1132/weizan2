<?php

$info = pdo_fetch("select * from " . tablename('sz_yi_plugin') . " where identity= 'return'  order by id desc limit 1");
if(!$info){
    $sql = "INSERT INTO " . tablename('sz_yi_plugin') . " (`displayorder`, `identity`, `name`, `version`, `author`, `status`, `category`) VALUES(0, 'return', 'Ü¿ÖÚÈ«·µ', '1.78', '¹Ù·½', 1, 'sale');";
    pdo_fetchall($sql);
}

if(!pdo_fieldexists('sz_yi_dispatch', 'supplier_uid')){
    pdo_fetchall("ALTER TABLE " . tablename('sz_yi_dispatch') . " ADD `supplier_uid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('sz_yi_bonus_level', 'status')){
    pdo_fetchall("ALTER TABLE " . tablename('sz_yi_bonus_level') . " ADD `status` tinyint(2) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sz_yi_supplier_apply', 'apply_ordergoods_ids')){
    pdo_fetchall("ALTER TABLE " . tablename('sz_yi_supplier_apply') . " ADD `apply_ordergoods_ids` text NOT NULL;");
}
if (!pdo_fieldexists('sz_yi_member', 'bonus_status')) 
{
	pdo_fetchall('ALTER TABLE ' . tablename('sz_yi_member') . " ADD `bonus_status` TINYINT(1) DEFAULT '0';");
}
if (!pdo_fieldexists('sz_yi_member', 'bonus_province')) 
{
	pdo_fetchall('ALTER TABLE ' . tablename('sz_yi_member') . " ADD `bonus_province` varchar(50) DEFAULT '';");
}
if (!pdo_fieldexists('sz_yi_member', 'bonus_city')) 
{
	pdo_fetchall('ALTER TABLE ' . tablename('sz_yi_member') . " ADD `bonus_city` varchar(50) DEFAULT '';");
}
if (!pdo_fieldexists('sz_yi_member', 'bonus_district')) 
{
	pdo_fetchall('ALTER TABLE ' . tablename('sz_yi_member') . " ADD `bonus_district` varchar(50) DEFAULT '';");
}
if (!pdo_fieldexists('sz_yi_member', 'bonus_area_commission')) 
{
	pdo_fetchall('ALTER TABLE ' . tablename('sz_yi_member') . " ADD `bonus_area_commission` decimal(10,2) DEFAULT '0.00';");
}
if (!pdo_fieldexists('sz_yi_goods', 'bonusmoney')) 
{
	pdo_fetchall('ALTER TABLE ' . tablename('sz_yi_goods') . " ADD `bonusmoney` DECIMAL(10,2) DEFAULT '0.00';");
}
