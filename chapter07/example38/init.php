<?php
header('Content-Type:text/html;charset=utf-8');

define('APP','itcast');

//载入数据库操作文件
require('./lib/MySQLPDO.class.php');

//实例化MySQLPDO类，配置数据库连接信息（读者需要根据自身环境修改此处配置）
$db = MySQLPDO::getInstance(array('user'=>'root','pass'=>'123456','dbname'=>'itcast'));

//保存错误信息
$error = array();
