<?php require('./view/header.php')?>
<!--body-->
<div class="box add">
<form method="post">
	<div class="classify">
  	文章分类：<select name="category">
				<?php foreach($category as $v):
						if($v['id'] == $rst['cid']):
				?>
				<option value="<?php echo $v['id'];?>" selected><?php echo $v['name'];?></option>
				<?php else: ?>
				<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
				<?php endif;endforeach;?>
  		    </select>
  		    <a href="category.php">分类管理</a>
    </div>
  
	<div class="article">
		<div class="article_title">
			标题：<input type="text" name="title" value="<?php echo $rst['title'];?>" />
			<span>作者：<input type="text" name="author" value="<?php echo $rst['author'];?>" /></span>
		</div>
		
		<div class="article_editor">
			<link href="./lib/umeditor/themes/default/css/umeditor.min.css" rel="stylesheet" />
			<script src="./lib/umeditor/third-party/jquery.min.js"></script>
			<script src="./lib/umeditor/umeditor.config.js"></script>
			<script src="./lib/umeditor/umeditor.min.js"></script>
			<script src="./lib/umeditor/lang/zh-cn/zh-cn.js"></script>
			<script>
				$(function(){
					UM.getEditor('myEditor');
				});
			</script>
			<!--style给定宽度可以影响编辑器的最终宽度-->
			<script type="text/plain" id="myEditor" style="width:1025px;height:250px;" name="content">
				<p><?php echo $rst['content'];?></p>
			</script>
		</div>
	</div>

	<input class="sub" type="submit" value="提交" />
	<input class="cancel" type="button" value="取消"  onclick="{if(confirm('确定要取消添加文章吗?')){window.location.href='index.php';}return false;}" />
</form>
</div>
<?php require('./view/footer.php')?>