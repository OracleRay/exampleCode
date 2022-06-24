<?php if(!defined('APP')) die('error!'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>欢迎登录</title>
<style>
body{background-color:#eee;margin:0;padding:0;}
.reg{width:400px;margin:15px;padding:20px;border:1px solid #ccc;background-color:#fff;}
.reg .title{text-align:center;padding-bottom:10px;}
.reg th{font-weight:normal;text-align:right;}
.reg input{width:180px;border:1px solid #ccc;height:20px;padding-left:4px;}
.reg .button{background-color:#0099ff;border:1px solid #0099ff;color:#fff;width:80px;height:25px;margin:0 5px;cursor:pointer;}
.reg .td-btn{text-align:center;padding-top:10px;}
.error-box{width:378px;margin:15px;padding:10px;background:#FFF0F2;border:1px dotted #ff0099;font-size:14px;color:#ff0000;}
.error-box ul{margin:10px;padding-left:25px;}
</style>
</head>
<body>
<form method="post">
<table class="reg">
	<tr><td class="title" colspan="2">欢迎登录</td></tr>
	<tr><th>用户名：</th><td><input type="text" name="username" /></td></tr>
	<tr><th>密码：</th><td><input type="password" name="password" /></td></tr>
	<tr><td colspan="2" class="td-btn">
	<input type="submit" value="登录" class="button" />
	<input type="reset" value="重新填写" class="button" />
	</td></tr>
</table>
</form>
<?php if(!empty($error)): ?>
	<div class="error-box">登录失败，错误信息如下：
		<ul><?php foreach($error as $v) echo "<li>$v</li>"; ?></ul>
	</div>
<?php endIf; ?>
</body>
</html>