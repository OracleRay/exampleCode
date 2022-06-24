<?php
//声明文件解析的编码格式
header('content-type:text/html;charset=utf-8');
require './public_function.php';
//初始化数据库
dbInit();
//准备SQL语句
$sql = 'select * from emp_info';
//定义员工数组，用以保存员工信息,执行SQL语句，获取结果集
$emp_info = fetchAll($sql);
//设置常量，用以判断视图页面是否由此页面加载
define('APP', 'itcast');
//加载视图页面，显示数据
require './list_html.php';