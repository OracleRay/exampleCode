<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>双色球</title>
  <style>
	  figure{display: block;background: black;border-radius: 50%;height: 40px; line-height:38px;width: 40px;margin: 20px 5px; float:left;text-align:center;color:#FFFFFF; font-weight:bolder;}
	 .red{
	  background: -webkit-radial-gradient(10px 10px, circle, #ff0000, #000);
	  background: -moz-radial-gradient(10px 10px, circle, #ff0000, #000);
	  background: -ms-radial-gradient(10px 10px, circle, #ff0000, #000);
	  background: radial-gradient(10px 10px, circle, #ff0000, #000);

	 }
	 .blue{
	  background: -webkit-radial-gradient(10px 10px, circle, #0000ff, #000);
	  background: -moz-radial-gradient(10px 10px, circle, #0000ff, #000);
	  background: -ms-radial-gradient(10px 10px, circle, #0000ff, #000);
	  background: radial-gradient(10px 10px, circle, #0000ff, #000);
	 }	
  </style>
 </head>
 <body>
<?php
	//创建一个1~33的红色球号码区数组
	$red_num = range(1,33);
	//随机从红色球号码区数组中获取6个键
	$keys = array_rand($red_num,6);
	//打乱键顺序
	shuffle($keys);
	//根据键获取红色球号码区数组中相应的值
	foreach($keys as $v){
		//判断：当红球号码是一位数时，在左侧补零
		$red[] = $red_num[$v]<10 ? ('0'.$red_num[$v]) : $red_num[$v];
	}
	//随机从1~16的篮色球号码区中取一个号码
	$blue_num = rand(1,16);
	//判断：当篮球号码是一位数时，在左侧补零
	$blue = $blue_num<10 ? ('0'.$blue_num) : $blue_num;
		
	foreach($red as $v){
		//输出红球号码
		echo "<figure class=\"red\">$v</figure>";
	}
	//输出篮球号码
	echo "<figure class=\"blue\">$blue</figure>";
 ?>          
 </body>
</html>