<?php

//设定字符集
header('Content-Type:text/html;charset=utf-8');

//连接数据库，设置字符集，选择数据库
mysql_connect('localhost','root','123456') or die('数据库连接失败！');
mysql_query('set names utf8');
mysql_query('use `itcast`') or die('itcast数据库不存在！');

//定义数组$city保存预设的城市下拉列表
$city = array('北京','上海','广州','其他');

//定义数组$skill保存预设的语言技能复选框
$skill = array('HTML','JavaScript','PHP','C++');

//假设当前登录的用户的ID为1
$id = 1;

//判断是否有表单提交
if(!empty($_POST)){
	
	//当有表单提交时，收集表单数据，保存到数据库中

	//显示接收到的表单数据
	var_dump($_POST);

	//指定需要接收的表单字段
	$fields = array('nickname','gender','email','qq','url','city','skill','description');

	//根据程序中定义好的表单字段收集$_POST数据
	foreach($fields as $v){
		//$save_data保存收集到的表单数据，不存在的字段填充空字符串
		$save_data[$v] = isset($_POST[$v]) ? $_POST[$v] : '';
	}

	//单选框处理
	if($save_data['gender']!='男' && $save_data['gender']!='女'){
		die('保存失败：未选择性别。');
	}

	//下拉菜单处理
	if($save_data['city']!='未选择' && !in_array($save_data['city'],$city)){  //判断是否是$city数组中定义的合法值
		die('保存失败：您填写的城市不在允许的城市列表中。');
	}

	//复选框处理
	if(is_array($save_data['skill'])){
		$save_data['skill'] = array_intersect($skill,$save_data['skill']);	//只取出合法的数组元素
		$save_data['skill'] = implode(',',$save_data['skill']);  //将数组转换为用逗号分隔的字符串	
	}else{
		$save_data['skill'] = '';
	}

	//通过循环数组，自动拼接SQL语句，保存到数据库中
	$sql = 'update `userinfo` set ';
	foreach($save_data as $k=>$v){
		$sql .= "`$k`='".mysql_real_escape_string($v)."',"; //拼接每个字段的SQL语句，并对值进行SQL安全转义
	}
	$sql = rtrim($sql,',')." where id=$id"; //rtrim($sql,',')用于去除$sql中的最后一个逗号
	$rst = mysql_query($sql);

	//输出执行结果和调试信息
	echo $rst ? "保存成功：$sql" : "保存失败：$sql<br>".mysql_error();
}

//执行到此处表示没有表单提交，程序将根据id查询用户信息并显示到表单里

//根据指定id查询用户信息
$sql = "select `nickname`,`gender`,`email`,`qq`,`url`,`city`,`skill`,`description` from `userinfo` where `id`=$id";
$rst = mysql_query($sql);

if(!$rst) die(mysql_error());

//$data保存查询到的用户信息
$data = mysql_fetch_assoc($rst);

//判断是否查询到数据
if(!$data){
	die('没有找到ID为'.$id.'的用户信息！');
}

//将skill字段通过“,”分隔符转换为数组
$data['skill'] = explode(',',$data['skill']);

//显示查询出的数据
//var_dump($data);

//加载HTML模板文件
define('APP','itcast');
require 'profile_html.php';
