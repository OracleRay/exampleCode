<?php require('./view/header.php')?>
<!--body-->
<div class="box category_list">
	<!--文章分类添加-->
	<div class="category_add_form">
		<form method="post" action="?a=category_add">
			分类名称：<input class="cname" type="text" name="name" />
			<input class="sub" type="submit" value="添加" />
		</form>
	</div>
	<!--文章分类列表-->
	<form method="post" action="?a=category_sort">
		<table class="list">
			<tr><td>排序</td><td>分类名称</td><td>操作</td></tr>
			<?php foreach($category as $v):?>
			<tr>
				<td><input type="text" name="id[<?php echo $v['id'];?>]" value="<?php echo $v['sort'];?>"></td>
				<td><?php echo $v['name'];?></td>
				<td><a href="?id=<?php echo $v['id'];?>&a=category_del" onclick="returm confirm('确定要删除该文章分类吗？')">删除</a> | 编辑</td></tr>
			<?php endforeach;?>
		</table>
		<div class="btnbox"><input type="submit" value="保存排序" /></div>
	</form>
</div>
<?php require('./view/footer.php')?>