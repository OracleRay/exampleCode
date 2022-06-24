<?php
header('content-type:text/html;charset=utf-8');
//载入goods类文件
require './goods.class.php';

//定义phone类，继承goods类

class phone extends goods{
	//由于父类getName方法是抽象方法，因此在这里必须实现
	public function getName(){
		return '手机型号为：'.$this->name; //实现与book类不同
	}
}
//实例化phone类，phone类继承了goods类，具有构造方法，需要传递相关参数
$p = new phone('MI4s',1999);
echo $p->getName();
echo '<hr>';
//父类good类中getPrice是final方法，无法被重写
echo $p->getPrice();