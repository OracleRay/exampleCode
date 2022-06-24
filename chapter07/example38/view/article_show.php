<?php require('./view/header.php')?>
<!--body-->
<div class="box article_show">
	<div class="main">
		<div class="show_title"> 
			<h2><?php echo $rst['title'];?></h2>
			<span>时间：<?php echo $rst['addtime'];?></span>
			<span>分类：<?php echo $rst['cname'];?></span>
			<span>作者：<?php echo $rst['author'];?></span>
		</div>
		<div class="content"><?php echo $rst['content'];?> </div>
	
	</div>
	<div class="side">
		<ul>
			<p>推荐文章</p>
			<li> PHP加载MySQL问题</li>
			<li> Eclipse for PHP</li>
			<li> PHP高手干货分享</li>
			<li> PHP函数引用传参数组</li>
		</ul>
	</div>
</div>
<?php require('./view/footer.php')?>