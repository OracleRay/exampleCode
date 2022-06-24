<?php

header('Content-Type:text/html;charset=utf-8');

// 载入数据库操作文件
require './lib/MySQLPDO.php';

// 实例化MySQLPDO类，配置数据库连接信息（读者需要根据自身环境修改此处配置）
$db_config = array('user'=>'root','pass'=>'123456','dbname'=>'itcast');
$db = \lib\MySQLPDO::getInstance($db_config);

// 保存错误信息
$error = array();

// 启动SESSION
session_start();

// 判断SESSION中是否存在用户信息
if (isset($_SESSION['userinfo'])) {
    // 用户信息存在，说明用户已经登录
    $login = true;   // 保存用户登录状态
    $userinfo = $_SESSION['userinfo'];  // 获取用户信息
} else {
    // 用户信息不存在，说明用户没有登录
    $login = false;
}

// 取出文章分类列表
$sql = 'select `id`,`name`,`sort` from `cms_category` order by `sort`';
$category = $db->fetchAll($sql);
