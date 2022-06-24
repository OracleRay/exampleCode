<?php
header('content-type:text/html;charset=utf-8');
//获取数据库连接并选择数据库
mysql_connect('localhost','root','123456') or die('连接数据库失败！'.mysql_error());
mysql_query('set names utf8');
mysql_query('use itcast');
//获取数据总数
$page_size = 2;
$res = mysql_query('select count(*) from emp_info');
if(!$res) die(mysql_error());

$count = mysql_fetch_row($res);
//取出查询结果中的第一列的值
$count = $count[0];

$max_page = ceil($count/$page_size);
//获取当前选择的页码，并作容错处理
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = $page > $max_page ? $max_page : $page;
$page = $page < 1 ? 1 : $page;

 //组合分页链接
 $page_html = "<a href='./showList.php?page=1'>首页</a>&nbsp;";
 $page_html .= "<a href='./showList.php?page=".(($page - 1) > 0 ? ($page - 1) : 1)."'>上一页</a>&nbsp;";
 $page_html .= "<a href='./showList.php?page=".(($page + 1) < $max_page ? ($page + 1) : $max_page)."'>下一页</a>&nbsp;";
 $page_html .= "<a href='./showList.php?page={$max_page}'>尾页</a>";

//拼接查询语句并执行，获取查询数据
$lim = ($page -1) * $page_size;
$sql = "select * from emp_info limit {$lim},{$page_size}";
$res = mysql_query($sql);
if(!$res) die(mysql_error());

//读取数据并作相关处理
$emp_info = array();
while($row = mysql_fetch_assoc($res)){
	$emp_info[] = $row;
}
//设置常量，用以判断视图页面是否由此页面加载
define('APP', 'itcast');
//载入视图页面
require './list_html.php';