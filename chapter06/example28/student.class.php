<?php
//定义student类
class student{
	//声明成员属性$name,用来保存学生的姓名
	public $name;
	//声明成员属性$student_id，用来保存学生的年龄
	public $student_id;
	//声明成员属性$age,用来保存学生的年龄
	public $age;

	//声明成员方法introduce()，调用该方法让学生进行自我介绍
	public function introduce(){
		echo "大家好，我是{$this->name},今年{$this->age}岁。<br/>我的学号是{$this->student_id},很高兴认识大家。";
	}

	//声明成员方法study()，调用该方法让学生开始学习
	public function study($time){
		$time = date("Y年m月d日 H:i:s",$time);
		echo "当前时间为{$time},学习中，请勿打扰....";
	}
}