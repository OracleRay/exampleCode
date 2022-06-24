<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>九九乘法表</title>
  <style>
  	body{ background:url(04.jpg);}
	table {  *border-collapse: separate; /* IE7 and lower */border-spacing: 2px;width: 100%; margin:80px auto 10px;}
	.bordered tr,td{ border:solid #ccc 1px; padding:5px;text-align:center; background-color: #FEFEFE;  opacity:0.8;} 
 </style>
 </head>
 <body>
  <table class="bordered">
	<?php
		//循环九九乘法表的层数
		for($i=1; $i<10; ++$i){
			echo '<tr>';
			//循环每层中单元格的个数
			for($j=1;$j<=$i; $j++){
				//计算每层中的乘法
				echo "<td>{$j}×{$i}=".$j*$i.'</td>';
			}
			echo '</tr>';
		}		
	?>
  </table>
 </body>
</html>