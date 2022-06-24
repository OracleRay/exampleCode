<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>订货单显示</title>
  <style>
  table {  *border-collapse: collapse; /* IE7 and lower */border-spacing: 0;width: 100%;}
  .bordered {border: solid #ccc 1px;-moz-border-radius: 6px;-webkit-border-radius: 6px;border-radius: 6px;text-align:center;}
  .bordered tr,td{ border:solid #ccc 1px; padding:10px;}
  .bordered tr:nth-child(1){ background-color:#dce9f9;}
  .bordered td:nth-child(1){ width:70px;}
  .bordered tr:nth-child(5){ text-align:right; }
  span{ color:red;font-weight:bold;}
  h2{ text-align:center; margin:9px 0;}
  </style>
 </head>
 <body>
	<?php
		//定义数组，存储订货单中商品信息
		$goods = array(
		 array('name'=>'主板','price'=>'379','producing'=>'广东','num'=>3),
		 array('name'=>'显卡','price'=>'799','producing'=>'上海','num'=>2),
		 array('name'=>'硬盘','price'=>'589','producing'=>'北京','num'=>5)
		);
		//商品价格总计
		$total = 0;
		//拼接订货单中信息
		$str = '<h2>商品订货单</h2>';
		$str .= '<table class="bordered">';
		$str .= '<tr><td>商品名称</td><td>单价(元)</td><td>产地</td><td>数量(个)</td><td>总价(元)</td></tr>';
		//循环数组
		foreach($goods as $values){
			$str .= '<tr>';
			foreach($values as $v){
				$str .='<td>'.$v.'</td>';
			}
			//计算并拼接每件商品的总价格
			$sum = $values['price']*$values['num'];
			$str .= '<td>'.$sum.'</td>';
            $str .= '</tr>';
			//计算订货单中所有商品总价格
			$total += $sum;
		}
		$str .= '<tr><td colspan="5">小计：<span>'.$total.'元</span></td></tr></table>';
		echo $str;
	?>	
 </body>
</html>