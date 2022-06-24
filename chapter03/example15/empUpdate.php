<?php
//声明文件解析的编码格式
header('content-type:text/html;charset=utf-8');
//引入功能函数文件
require './public_function.php';
//初始化数据库
dbInit();

//获取要编辑的员工的id
$e_id = isset($_GET['e_id']) ? intval($_GET['e_id']) : 0;

//判断是否有POST数据提交
if(!empty($_POST)){
	
	 //定义变量$update，用来保存处理后的员工数据
	$update = array();
	
	//定义合法字段数组
	$fields = array('e_name','e_dept','date_of_birth','date_of_entry');

	//遍历$_POST，获取更新员工数据的键和值
	foreach($fields as $v){

		$data = isset($_POST[$v]) ? $_POST[$v] : '';

		if($data=='') die($v.'字段不能为空');

		//值也就是该字段保存的数据，对其进行安全处理
		$data = safeHandle($data);

		//把键和值按照sql更新语句中的语法要求连接，并存入到$update数组中
		$update[] = "`$v`='$data'";
	}

	//把$update数组元素使用逗号连接，赋值给$update_str
	$update_str = implode(',', $update);

	//组合sql语句
	$sql = "update `emp_info` set $update_str where  `e_id`=$e_id";

	if($res = query($sql)){
		header("Location: ./showList.php");
		die;
	}else{
		die('员工信息修改失败');
	}
}else{
    //当没有表单提交时，查询当前要编辑的员工信息，展示到页面中

	//编写SQL语句，查询相应ID的员工数据
	$sql = "select * from `emp_info` where `e_id`=$e_id";

	//获取一行数据
	$emp_info = fetchRow($sql);

	//显示员工修改页面
	define('APP', 'itcast');
	require './update_html.php';
}

