<?php

$sql =<<<EOF
DROP TABLE IF EXISTS `ims_iweite_vods_category`;
DROP TABLE IF EXISTS `ims_iweite_vods_guanggao`;
DROP TABLE IF EXISTS `ims_iweite_vods_jiekou`;
DROP TABLE IF EXISTS `ims_iweite_vods_setting`;
DROP TABLE IF EXISTS `ims_iweite_vods_ziyuan`;
DROP TABLE IF EXISTS `ims_iweite_vods_ziyuan_list`;
EOF;
pdo_run($sql);