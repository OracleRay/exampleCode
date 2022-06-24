<?php

//设定字符集
header('Content-Type:text/html;charset=utf-8');

/*
	//查看提交的表单
	var_dump($_POST);

	//获取注册用户的信息
	echo '<h2>接收到新用户注册！</h2>';
	echo '<p>用户名：'.$_POST['username'].'</p>';
	echo '<p>密码：'.$_POST['password'].'</p>';
	echo '<p>邮箱：'.$_POST['email'].'</p>';
	echo '<p>IP地址：'.$_SERVER['REMOTE_ADDR'].'</p>';
	echo '<p>浏览器环境：'.$_SERVER['HTTP_USER_AGENT'].'</p>';
	echo '<p>请求来源：'.$_SERVER['HTTP_REFERER'].'</p>';
*/

//当没有表单提交时退出程序
if(empty($_POST)){
	die('没有表单提交，程序退出');
}

//判断表单中各字段是否都已填写
$check_fields = array('username','password','email');
foreach($check_fields as $v){
	if(empty($_POST[$v])){
		die('错误：'.$v.'字段不能为空！');
	}
}

//接收需要处理的表单字段
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

//连接数据库，设置字符集，选择数据库
mysql_connect('localhost','root','123456') or die('数据库连接失败！');
mysql_query('set names utf8');
mysql_query('use `itcast`') or die('itcast数据库不存在！');

//防止SQL注入
$username = mysql_real_escape_string($username);
$email = mysql_real_escape_string($email);

//判断用户名是否存在
$sql = "select `id` from `user` where `username`='$username'";
$rst = mysql_query($sql);
if(mysql_fetch_row($rst)){
	die('用户名已经存在，请换个用户名。');
}

//使用MD5增强密码安全性
$password = md5($password);

//拼接SQL语句
$sql = "insert into `user` (`username`,`password`,`email`) values ('$username','$password','$email')";

//执行SQL语句
$rst = mysql_query($sql);

//输出执行的SQL语句和执行结果，便于调试程序
echo "SQL语句：$sql<br>";
if($rst){
	echo '执行成功';
}else{
	echo '执行失败：'.mysql_error();
}