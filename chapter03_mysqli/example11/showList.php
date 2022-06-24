<?php
// 声明文件解析的编码格式
header('content-type:text/html;charset=utf-8');

// 连接数据库
$link = mysqli_connect('localhost','root','123456');
// 判断数据库连接是否成功，如果不成功则显示错误信息并终止脚本继续执行
if (!$link) {
    exit('连接数据库失败！' . mysqli_connect_error());
}
// 设置字符集，选择数据库
mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'itcast');

// 准备SQL语句
$sql = 'select * from `emp_info`';

// 执行SQL语句，获取结果集
$res = mysqli_query($link, $sql);
if (!$res) {
    exit(mysqli_error($link));
}

// 定义员工数组，用以保存员工信息
$emp_info = array();

// 遍历结果集，获取每位员工的详细数据
while ($row = mysqli_fetch_assoc($res)) {
    //把从结果集中取出的每一行数据赋值给$emp_info数组
    $emp_info[] = $row;
}

// 设置常量，用以判断视图页面是否由此页面加载
define('APP', 'itcast');
// 加载视图页面，显示数据
require './list_html.php';
