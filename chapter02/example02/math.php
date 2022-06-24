<?php
/*  说明：如果没有HTML的 <meta charset="utf-8"> 指定字符集，中文会出现乱码，
          这是因为浏览器默认编码为gbk。为了防止乱码，可用此方式设置字符集。 */
header('Content-type:text/html;charset=utf-8');
?>
<!doctype html>
<html>
 <head>
  <title>数学运算</title>
  <style>
  body{background-color:#eee; font-size:14px;}
  table {*border-collapse: collapse; /* IE7 and lower */border-spacing: 0;width:100%;color:#2B2B2B;}
  .bordered {border: solid #DADADA 1px; background-color:#fff;text-align:center;}
  .bordered tr,td{border: solid #DADADA 1px;padding:10px;}
  .bordered tr:nth-child(5){text-align:right;}
  .bordered tr:nth-child(6){text-align:right;}
  .bordered tr:nth-child(1){font-weight:bold;}
  span{color:red;}
  </style>
 </head>
 <body>
 <?php

	//定义一个常量，保存所有商品的折扣
	const DISCOUNT = 0.8;

	//所有商品名称
	$fruit1 = '香蕉';    
	$fruit2 = '苹果';
	$fruit3 = '橘子';

	//对应商品的购买数量（斤）
	$fruit1_num = 2;	
	$fruit2_num = 1;
	$fruit3_num = 3;

	//对应商品的价格（元/斤）
	$fruit1_price = 7.99;
	$fruit2_price = 6.89;
	$fruit3_price = 3.99;

	//依次计算每件商品的总价格
	$fruit1_total = $fruit1_num * $fruit1_price;
	$fruit2_total = $fruit2_num * $fruit2_price;
	$fruit3_total = $fruit3_num * $fruit3_price;

	//计算所有商品总价格
	//计算公式：所有商品价格 =（香蕉总价格+苹果总价格+橘子总价格）*商品折扣	
	$total = ($fruit1_total + $fruit2_total + $fruit3_total)*DISCOUNT;

	//拼接商品显示信息，使商品在表格中有条理的显示
	$str  = "<table class=\"bordered\">";
	$str .= "<tr><td>商品名称</td><td>购买数量(斤)</td><td>商品价格(元/斤)</td></tr>";
	$str .= "<tr><td>$fruit1</td><td>$fruit1_num</td><td>$fruit1_price</td></tr>";
	$str .= "<tr><td>$fruit2</td><td>$fruit2_num</td><td>$fruit2_price</td></tr>";
	$str .= "<tr><td>$fruit3</td><td>$fruit3_num</td><td>$fruit3_price</td></tr>";
	$str .= "<tr><td colspan=\"3\">商品折扣：<span>".DISCOUNT."</span></td></tr>";
	$str .= "<tr><td colspan=\"3\">打折后购买商品总价格：<span>{$total}元</span></td></tr>";
	$str .= "</table>";

	//显示输出商品信息echo 
	echo $str;
 ?>	
 </body>
</html>