<?php if(!defined('APP')) die('error!'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>文章阅读</title>
<style>
body{margin:0;padding:0;}
.box{margin:20px;border:1px solid #C8D8F2;background:#f5f8fd;font-size:14px;}
.box .content{margin:20px;}
.box .page{margin-left:20px;}
.box .history{margin:20px;}
.box a{color:#0033ff;}
</style>
</head>
<body>
<div class="box">
	<div class="content">
		<!-- 文章标题 --> <?php echo $data[0]; ?>
		<!-- 文章内容 --> <p><?php echo $data[1]; ?></p>
	</div>
	<div class="page">
		<a href="?id=<?php echo $id_prev; ?>">上一篇</a>
		<a href="?id=<?php echo $id_next; ?>">下一篇</a>
	</div>
	<div class="history">
		浏览历史：（<a href="?action=clear">清除历史</a>）
		<ul><?php
			foreach($data_history as $k=>$v){
				echo "<li><a href=\"?id=$k\">$v</a></li>";
			}
		?></ul>
	</div>
</div>
</div>
</body>
</html>