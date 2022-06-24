<?php
header('content-type:text/html;charset=utf-8');
//载入goods类文件
require './goods.class.php';

//定义book类，继承goods类
class book extends goods{
	//由于父类getName方法是抽象方法，因此在这里必须实现
	public function getName(){
		return '书名：《'.$this->name.'》';
	}
}

//实例化book类，book类继承了goods类，具有构造方法，需要传递相关参数
$book = new book('PHP高级教程',45);

echo $book->getName();
echo '<hr>';

//父类good类中getPrice是final方法，无法被重写
echo $book->getPrice();