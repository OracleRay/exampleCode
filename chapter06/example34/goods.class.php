<?php
/**
 * 定义商品类，使用abstract将类声明为抽象类
 * 该类提供基础属性$name，$price，构造方法
 * 类中使用abstract将getName()方法声明为抽象方法，继承该类的子类必须实现该方法，但是实现过程可以不同。
 * 类中使用final关键字将getPrice()方法声明为final方法，final关键字限制了子类必须存在该方法并且不能被重写。
 */
abstract class goods{
	public $name;   //商品名称
	public $price;  //商品价格

	//构造方法，初始化对象的$name和$price属性
	public function __construct($name, $price) {
		$this->name = $name;
		$this->price = $price;
	}

	//限制非抽象子类都要实现getName的方法，但是可以不同
	abstract protected function getName();

	//要求每个子类都必须要有相同的返回原始价格的方法
	final public function getPrice() {
		return $this->price;
	}
}