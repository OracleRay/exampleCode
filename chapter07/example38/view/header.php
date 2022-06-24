<?php if(!defined('APP')) die('access denied'); ?>
<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>文章管理系统</title>
	<link href="./css/article.css" rel="stylesheet" />
 </head>
 <body>
 	<!--header-->
 	<div class="header">
		<!--网页头信息-->
		<div class="title"><img src="./image/title.png"></div>
		<!--分类导航栏-->
		<div class="nav">
			<ul>
				<li><a href="index.php">首页</a></li>
				<?php foreach($category as $v):?>
				<li><a href="index.php?cid=<?php echo $v['id'];?>"><?php echo $v['name'];?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
	
	</div>
	<!--错误信息-->
	<?php if(!empty($error)): ?>
		<div class="error"><ul>
			<?php foreach($error as $v): ?>
			<li><?php echo $v; ?></li>
			<?php endforeach; ?>
		</ul></div>
	<?php endif; ?>