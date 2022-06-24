<!doctype html>
<html>
 <head>
	<meta charset="utf-8">
	<title>获取文件后缀</title>
	<style>
	h2{ text-align:center; }
	p{ padding-left:15px;}
	.box{ height:180px;width:100%; border:1px solid #ccc; box-shadow:7px 8px 7px #999;}
	</style>
 </head>
 <body>
<div class="box">
<?php
	//获取文件后缀的函数，参数为文件的路径
	function getFileExt($path){ 
		//获取文件后缀
		$ext = substr($path, strrpos($path,'.')+1); 
		//返回文件后缀 
		return $ext;
	}
	//设置文件的路径
	$path = 'C:\images\apple.jpg';
	//调用函数getFileExt()获取文件后缀
	$ext = getFileExt($path);
	echo '<h2>获取文件后缀</h2>';
	echo "<p>☞文件路径：$path";
	//输出获取的文件后缀
	echo "<p>☞文件后缀：$ext";
?>
</div>	
</body>	
</html>