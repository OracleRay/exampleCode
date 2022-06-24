<?php if(!defined('APP')) die('error!');?>
<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>文件管理器</title>
  <style>
	body{ font-size:12px;}
	img{ width:20px;}
	a:link, a:visited { color:#555; text-decoration:none; } 
    a:hover, a:active { color:#ff0000; text-decoration:underline;} 
	.tbl{ border-collapse:collapse; width:98%; margin-top:10px; font-size:12px;}
	.tbl th{ text-align:left; background:#ccc;}
	.tbl th,td{ border:1px solid #eee;}
	span{color:#ff0000;}
  </style>
 </head>
<body>
<!-- 重命名操作区 -->
<?php if($action == 'rename'):?>
	<form method="post">
		将<span><?php echo $file;?></span>重命名为：<input type="text" value="<?php echo $file;?>" name="target" />
		<input type="submit" value="确定" />
	</form>
<?php endif;?>
<!-- 功能按钮区 -->
<a href="?path=<?php echo $path;?>&a=prev">返回上一级目录</a>
<!-- 文件列表区 -->
<table class="tbl">
	<tr><th>名称</th><th>修改日期</th><th>大小</th><th>操作</th></tr>
	<!-- 循环输出目录列表 -->
	<?php foreach($file_list['dir'] as $v): ?>
		<tr><td><a href="?path=<?php echo $v['filepath'];?> "><img src="./img/list.png"><?php echo $v['filename']; ?></a></td>
		<td><?php echo $v['filemtime']; ?></td>
		<td>-</td>
		<td><a href="?path=<?php echo $v['filepath'];?> ">打开</a></td></tr>
	<?php endForeach; ?>
	<!-- 循环输出文件列表 -->
	<?php foreach($file_list['file'] as $v): ?>
		<tr><td><img src="./img/file.png"> <?php echo $v['filename']; ?></td>
		<td><?php echo $v['filemtime']; ?></td>
		<td><?php echo $v['filesize']; ?> KB</td>
		<td>
			<a href="?path=<?php echo $v['filepath'] ?>&a=rename">重命名</a>
			<a href="?path=<?php echo $v['filepath'] ?>&a=copy">复制</a>
			<a href="?path=<?php echo $v['filepath'] ?>&a=del">删除</a>
		</td></tr>
	<?php endForeach; ?>
</table>
</body>
</html>