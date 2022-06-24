<?php if(!defined('APP')) die('error!'); ?>
<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>PDO基本使用</title>
  <style>
  .tbl{ border:1px solid #174464;border-collapse:collapse; margin:0px auto;}
  .tbl tr{ height:30px;}
  .tbl td{ padding:5px 7px;}
  .tbl tr:nth-child(1){ background:#174464; color:#FFF; font-weight:bold;}
  h2{ text-align:center; color:#174464;}
  </style>
 </head>
 <body>
 	<h2>书籍信息列表</h2>
	<table class="tbl">
	<tr>
		<td>书籍名称</td>
		<td>作者</td>
		<td>出版日期</td>
	</tr>
	<?php foreach($book_info as $row):?>
	<tr>
		<td><?php echo $row['book_name'];?></td>
		<td><?php echo $row['book_author'];?></td>
		<td><?php echo $row['pub_time'];?></td>
	</tr>
	<?php endforeach;?>
	</table>
 </body>
</html>