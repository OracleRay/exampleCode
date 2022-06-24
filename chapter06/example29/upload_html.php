<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>用户头像上传</title>
	<style>
		body{ background:#ccc; font-family:"华文中宋";}
		.box{ width:320px; border: solid #ccc 1px; background:#fff; margin:0 auto; padding:0 0 10px 60px;}
		img{ width:90px; float:left;padding:2px;border:1px solid #999;}
		.exist{ float:left;}
		.upload{ clear:both; padding-top:15px; }
		h2{ padding-left:60px;font-size:20px;}
		.sub{ margin-left:85px; background:#0099FF; border:1px solid #55BBFF; width:85px; height:30px; color:#FFFFFF; font-size:13px; font-weight:bold; cursor:pointer; margin-top:5px;}
	</style>
</head>
<body>
	<div class="box">
		<h2>编辑用户头像</h2>
		<p>用户姓名：小明</p>
		<p class="exist">现有头像：</p>
		<img src="<?php echo './'.$pic_path; ?>" onerror="this.src='./default.jpg'" />
		<form action="./upload_object.php" method="post" enctype="multipart/form-data">
			<p class="upload">上传头像：<input name="pic" type="file"/></p>
			<p><input class="sub" type="submit" value="保存头像"></p>
		</form>
	</div>
</body>
</html>