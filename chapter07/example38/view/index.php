<?php require('./view/header.php')?>
<!--body-->
<div class="box">
	<div class="main">
	<ul>
		<?php foreach($articles as $row):?>
			<li><span class="article_title"><a href="article_show.php?id=<?php echo $row['id'];?>"><?php echo $row['title'];?></a></span>
			<span class="ope"><a href="article_edit.php?id=<?php echo $row['id'];?>">编辑</a>&nbsp;
			<a href="article_del.php?id=<?php echo $row['id'];?>" onclick="return confirm('确定要删除该文章吗?')">删除</a></span>
			<p class="article_content"><?php echo $row['content'];?></p>
			<p class="article_show"><a href="article_show.php?id=<?php echo $row['id'];?>">点击查看全文&gt;&gt;</a></p>
			<p>发表时间：<span class="article_label"><?php echo $row['addtime'];?> </span>　
			作者：<span class="article_label"><?php echo $row['author'];?> </span></p></li>
		<?php endforeach;?>
		<div class="page" id="page"><?php echo $page_html;?></div>
	</ul>
	</div>
	<div class="side">
		<a href="./article_add.php"><div class="add_article"><img src="./image/add.png">发表文章</div></a>
		<p>每周热文</p>
		<ul><li>PHP加载MySQL问题</li>
		<li>Eclipse for PHP</li>
		<li>PHP高手干货分享</li>
		<li>PHP函数引用传参数组</li></ul>
		<p>专栏推荐</p>
		<ul><li>Smarty在ThinkPHP中的问题</li>
		<li>PHP程序员求职</li>
		<li>PHP的学习模式是怎样的</li>
		<li>喜报！广州传智PHP毕业就业率</li></ul>
	</div>
</div>
<?php require('./view/footer.php')?>