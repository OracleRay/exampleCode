<?php

//设定字符集
header('Content-Type:text/html;charset=utf-8');

echo '<title>表单控件生成</title>';

//生成一组单选按钮
//$name string 表示单选按钮的name属性
//$value array 表示单选按钮的value属性
//$checked string 表示单选按钮默认选中的value
function make_radio($name,$value,$checked){
	$html = ''; //$html保存拼接的HTML
	foreach($value as $v){
		if($checked == $v){
			$html .= "<input type=\"radio\" name=\"$name\" value=\"$v\" checked />$v ";
		}else{
			$html .= "<input type=\"radio\" name=\"$name\" value=\"$v\" />$v ";
		}
	}
	return $html; //返回拼接结果
}

//生成一组单选按钮
$value = array('苹果','香蕉','橘子','番茄');
echo make_radio('fruit',$value,'香蕉');
