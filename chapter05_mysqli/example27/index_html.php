<?php if(!defined('APP')) die('error!'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>在线网盘</title>
<style>
	body{ color:#555;  font-size:12px;font-family:"simsun";}
	.box .clear{clear:both;}
	.box a:link, a:visited { color:#555; text-decoration:none; } 
    .box a:hover, a:active { color:#367CBA; text-decoration:underline;}
	.box form{margin:10px;}
	.box .position{margin:10px;}
	.box .sub{background:#F8FCFF; border:1px solid #D5E5F5; width:65px; height:25px; color:#3B80BC; font-weight:bold;cursor:pointer;}
	.box .leftbox{width:238px;float:left;}
	.box .leftbox input[type=text]{width:150px;}
	.box .sub{ margin-left:13px;float:left;}
	.box .file{font-size:12px;width:224px;}
	.box table,tr,td{ width:auto; border:1px solid #DCE9F7; border-collapse:collapse;margin:10px;}
	.box table tr:nth-child(1){ height:30px; background:#F7FAFE;font-weight: bold; color:#367CBA;}
	.box table .filename{ font-weight: bold; color:#367CBA;} 
	.box table td{padding:5px 10px;}
	.box .error{ border:1px solid #FF0000; background:#FFDFDF; color:#FF0000;}
</style>
</head>
<body>
<div class="box">
	<!--错误信息-->
	<?php if(!empty($error)): ?>
		<div class="error"><ul>
			<?php foreach($error as $v): ?>
			<li><?php echo $v; ?></li>
			<?php endforeach; ?>
		</ul></div>
	<?php endif; ?>

	<!--创建文件夹-->
	<form method="post">
		<div class="leftbox">新建文件夹：<input type="text" name="newdir" /></div>
		<input class="sub" type="submit" value="创建" />
	</form>	
	<div class="clear"></div>

	<!--上传文件-->
	<form method="post" action="?folder=<?php echo $folder_id ?>" enctype="multipart/form-data">
		<div class="leftbox"><input type="file" name="file" class="file"></div>
		<input class="sub" type="submit" value="上传" />
	</form>
	<div class="clear"></div>

	<!--目录列表-->
	<div class="position">您的位置：<a href="?folder=0">主目录</a>
		<?php foreach($path as $v): ?>
			&gt; <a href="?folder=<?php echo $v['folder_id']; ?>"><?php echo $v['folder_name']; ?></a>
		<?php endforeach; ?>
	</div>

	<!--文件列表-->
	<table border="1">
		<tr><td>文件名</td><td>大小</td><td>上传时间</td><td>操作</td></tr>
		<!--列出目录-->
		<?php foreach($folder as $v): ?>
			<tr><td><a class="filename" href="?folder=<?php echo $v['folder_id'] ?>"><?php echo $v['folder_name'] ?></a></td><td>-</td><td><?php echo $v['folder_time'] ?></td>
			<td><a href="?folder=<?php echo $v['folder_id'] ?>">打开</a> | <a href="?folder=<?php echo $folder_id ?>&del=<?php echo $v['folder_id'] ?>&type=folder">删除</a></td></tr>
		<?php endforeach; ?>
		<!--列出文件-->
		<?php foreach($file as $v): ?>
			<tr><td><a class="filename" href="?download=<?php echo $v['file_id'] ?>" target="_blank"><?php echo $v['file_name'] ?></a></td><td><?php echo round($v['file_size']/1024) ?>KB</td>
			<td><?php echo $v['file_time'] ?></td>
			<td><a href="?download=<?php echo $v['file_id'] ?>" target="_blank">下载</a> | <a href="?folder=<?php echo $folder_id ?>&del=<?php echo $v['file_id'] ?>&type=file">删除</a></td></tr>
		<?php endforeach; ?>
	</table>
</div>
</body>
</html>