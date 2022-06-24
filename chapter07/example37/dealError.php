<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>PDO错误处理机制</title>
 </head>
 <body>
<?php

try{
	//连接数据库
	$pdo = new PDO('mysql:host=localhost;dbname=itcast;charset=utf8','root','123456');
	//设置错误处理
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);
	//$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
	//$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	//预处理SQL语句
	$stmt = $pdo->prepare('select * from `article`');
	//执行预处理语句
	$stmt->execute();
	echo '来传智播客学习……';
	//获取错误码
	$code = $stmt->errorCode();
	//判断执行出错，输出相关信息
	if(!empty($code)){
		echo '<br>'.$code.'<br>';
		print_r($stmt->errorInfo());
	}	
}catch(PDOException $e){
	//输出异常信息
	echo $e->getMessage().'<br>';
	//echo $stmt->errorCode().'<br>';
	//print_r($stmt->errorInfo());
}
?>
 </body>
</html>