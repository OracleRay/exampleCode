<?php
//声明文件解析的编码格式
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

// 定义变量，用来保存查询条件，初始化赋值空字符串
$where = '';

// 判断是否有搜索关键字传入
if (isset($_GET['keyword'])) {

    // 将$_GET['keyword']赋值给变量$keyword
    $keyword = $_GET['keyword'];

    // 用户输入的搜索信息不能直接使用，其中可能存在导致SQL语句执行失败的关键字或特殊字符，需要使用mysql_real_escape_string()函数进行转义
    $keyword = mysqli_real_escape_string($link, $keyword);

    // 将转义后的关键字拼接到where条件查询中，并且使用like进行模糊查询
    $where = "where e_name like '%$keyword%'";
}

// 把查询条件$where拼接到SQL语句中
$sql = "select * from emp_info $where";

// 执行SQL语句，获取结果集
$res = mysqli_query($link, $sql);
if (!$res) {
    exit(mysqli_error($link));
}

// 定义员工数组，用以保存员工信息
$emp_info = array();
// 遍历结果集，获取每位员工的详细数据
while ($row = mysqli_fetch_assoc($res)) {
    $emp_info[] = $row;
}
// 设置常量，用以判断视图页面是否由此页面加载
define('APP', 'itcast');
// 加载视图页面，显示数据
require './list_html.php';
