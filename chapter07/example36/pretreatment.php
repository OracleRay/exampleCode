<?php
header('Content-Type:text/html;charset=utf-8');
try{
	//连接数据库
	$pdo = new PDO("mysql:host=localhost;dbname=itcast;charset=utf8","root","123456");
	
	//预处理的SQL语句
	$stmt = $pdo->prepare("insert into `books`(`book_name`,`book_author`) values(?,?)");
	
	//为占位符绑定变量
	$stmt->bindParam(1,$name);
	$stmt->bindParam(2,$author);
	
	//准备数据
	$data = array(
		array('PHP第一本教材','传智播客高教产品研发部'),
		array('PHP第二本教材','传智播客高教产品研发部'),
		array('PHP第三本教材','传智播客高教产品研发部'),
		array('PHP第四本教材','传智播客高教产品研发部'),
		array('PHP第五本教材','传智播客高教产品研发部')
	);
	

	foreach($data as $row){
		
		//为绑定的变量赋值
		$name = $row[0];
		$author = $row[1];
		
		//执行预处理语句
		$stmt->execute();
	}
	
}catch(PDOException $e){
	//输出异常信息
	echo $e->getMessage().'<br>';
}
