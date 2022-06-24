<!doctype html>
<html>
 <head>
	<meta charset="utf-8">
	<title>判断学生成绩等级</title>
	<style>
	body{ background:url(10.jpg) no-repeat; }
	.box{ height:190px; width:480px; border:1px solid #ccc; text-align:left;background-color:white; opacity:0.8; }
	h2{text-align:center;}
	p{ padding-left:62px;}
	</style>
 </head>
 <body>
<div class="box">
<?php
	//定义变量$name保存学生的名字
	$name = '小明';
	//定义变量$score保存学生的分数
	$score = 78;
	//定义变量$str保存判断结果
	$str = '';
	//判断$score是否为一个有效数值
	if(is_int($score) || is_float($score)){
		//根据分数所在区间，显示相应的得分等级。
		if($score >=90 && $score <=100){
			$str = 'A级';
		}elseif($score >=80 && $score <90){
			$str = 'B级';
		}elseif($score >=70 && $score <80){
			$str = 'C级';
		}elseif($score >=60 && $score <70){
			$str = 'D级';
		}elseif($score >=0 && $score <60){
			$str = 'E级';
		}else{
			$str = '学生成绩范围必须在0~100之间！';
		}
	}else{
		$str = '输入的学生成绩不是数值！';
    }
	echo "<h2>学生成绩等级</h2><p>☞学生姓名：".$name."<p>☞学生分数：".$score."分<p>☞成绩等级：".$str;
?>	
</div>	
</body>	
</html>