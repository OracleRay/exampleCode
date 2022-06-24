<!doctype html>
<html>
 <head>
	<meta charset="utf-8">
	<title>打印金字塔</title>
	<style>
	.box{background-color:#000; margin:3px;padding:2px;font-size:24px;font-weight:bold; color: #FFFF00;font-family:"simsun";line-height:28px;}
	.out{border:solid 3px #000; float:left;overflow:hidden;}
	</style>
 </head>
 <body>
  <div class="out">
	<div class="box">
		<?php
			//金字塔的初始行数
			$line = 1;
			while($line <= 5){
				//组成金字塔空格和星星的初始位置
				$empty_pos = $star_pos = 1;
				//金字塔每行输出的最多空格数
				$empty = 5 - $line; 
				//组成金字塔每行的最多星星数
				$star = 2*$line-1;
				//输出金字塔每行的空格
				while($empty_pos <= $empty){
					echo '&nbsp;';
					++$empty_pos;
				}
				//输出金字塔每行的星星
				while($star_pos <= $star){
					echo '*';
					++$star_pos;
				}
				echo '<br>';
				$line++;
			}
		?>
	</div>	
  </div>
</body>	
</html>