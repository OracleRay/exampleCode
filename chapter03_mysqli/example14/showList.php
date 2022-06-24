<?php
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

// 获取数据总数
$page_size = 2;
$res = mysqli_query($link, 'select count(*) from emp_info');
if (!$res) {
    exit(mysqli_error($link));
}

$count = mysqli_fetch_row($res);
//取出查询结果中的第一列的值
$count = $count[0];

$max_page = ceil($count / $page_size);
// 获取当前选择的页码，并作容错处理
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = $page > $max_page ? $max_page : $page;
$page = $page < 1 ? 1 : $page;

// 组合分页链接
$page_html = "<a href='./showList.php?page=1'>首页</a>&nbsp;";
$page_html .= "<a href='./showList.php?page=" . (($page - 1) > 0 ? ($page - 1) : 1)."'>上一页</a>&nbsp;";
$page_html .= "<a href='./showList.php?page=" . (($page + 1) < $max_page ? ($page + 1) : $max_page)."'>下一页</a>&nbsp;";
$page_html .= "<a href='./showList.php?page={$max_page}'>尾页</a>";

// 拼接查询语句并执行，获取查询数据
$lim = ($page -1) * $page_size;
$sql = "select * from emp_info limit {$lim}, {$page_size}";
$res = mysqli_query($link, $sql);
if (!$res) {
    exit(mysqli_error($link));
}
//读取数据并作相关处理
$emp_info = array();
while ($row = mysqli_fetch_assoc($res)) {
    $emp_info[] = $row;
}
//设置常量，用以判断视图页面是否由此页面加载
define('APP', 'itcast');
//载入视图页面
require './list_html.php';
