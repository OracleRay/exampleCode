<?php
//声明文件解析的编码格式
header('content-type:text/html;charset=utf-8');
//连接数据库
$link = mysql_connect('localhost','root','123456');
//判断数据库连接是否成功，如果不成功则显示错误信息并终止脚本继续执行
if(!$link){
	die('连接数据库失败！'.mysql_error());
}
//设置字符集，选择数据库
mysql_query('set names utf8');
mysql_query('use itcast');

 //允许排序的字段
$fields = array('e_dept', 'date_of_entry');

 // 初始化排序语句，用来组合排序的order子句
$sql_order = '';

//判断$_GET['order']是否存在，如果存在则将其赋值给$order，如果不存在则把空字符串赋值给$order
$order = isset($_GET['order']) ? $_GET['order'] : '';

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

//判断$order是否存在于合法字段列表$fields中
if(in_array($order,$fields)){
	//判断$_GET['sort']是否存在并且值是否为'desc'
	if( $sort == 'desc'){
		//条件成立，组合order子句   order by 字段 desc
		$sql_order = "order by $order desc";
		//更新$sort为'asc'
		$sort = 'asc';
	}else{
		//条件不成立，组合order子句   order by 字段 asc
		$sql_order = "order by $order asc";
		//更新$sort为'desc'
		$sort = 'desc';
	}
}

//准备SQL语句
$sql = "select * from emp_info $sql_order";

//执行SQL语句，获取结果集
$res = mysql_query($sql,$link);
if(!$res) die(mysql_error());

//定义员工数组，用以保存员工信息
$emp_info = array();

//遍历结果集，获取每位员工的详细数据
while($row = mysql_fetch_assoc($res)){
	$emp_info[] = $row;
}

//设置常量，用以判断视图页面是否由此页面加载
define('APP', 'itcast');

//加载视图页面，显示数据
require './list_html.php';