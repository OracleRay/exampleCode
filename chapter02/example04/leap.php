<!doctype html>
<html>
 <head>
	<meta charset="utf-8">
	<title>判断是否为闰年</title>
	<style>
	body{ background:url(11.jpg) no-repeat;}
	h2{ text-align:center; }
	p{ padding-left:15px;}
	.box{ height:180px;width:535px; border:1px solid #eee; background-color:white;opacity:0.8;}
	</style>
 </head>
 <body>
  <div class="box">
	<?php
		
		$year = 2015;	

		/*
		 *使用if条件判断语句实现闰年的判断
		if(($year%4==0) && ($year%100!=0) || ($year%400==0)){
 	   	 	$result = '是闰年';
 		}else{
 	    	$result = '不是闰年';
		}
		*/

		//使用三元运算符实现闰年的判断
		$result=(($year % 4 == 0) && ($year % 100 != 0) || ($year % 400 == 0))?'是闰年':'不是闰年';
		echo '<h2>闰年的判断</h2>';
		echo '<p>输入的年份：<input type="text" value="'.$year.'">';
		echo '<p>判断的结果：'.$year.'年'.$result;
	?>	
  </div>	
</body>	
</html>