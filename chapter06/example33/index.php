<?php
//载入init.php文件
require './init.php';
//调用model()函数，传入要操作的数据表名以获取对应模型类对象
$student = model('student');

//通过$student对象调用field()方法指定查询的字段，调用select()方法执行查询
//$data = $student->field('name,birthday')->select();
//输出查询的数据结果
//var_dump($data);

//以下演示两种创建数据的方式
$student->name = '小红';   //通过对象数组保存学生数据
$studentData = array(      //通过传递数组保存学生数据
    'gender' => '女',
    'birthday' => '1990-08-21',
);
//调用add()方法，并接收方法返回值
if ($studentId = $student->add($studentData)) {
    //如果返回了新添加的学生id，则根据id获取学生信息
    $studentInfo = $student->getById($studentId);
    echo '<pre>';
    //打印输出学生信息
    var_dump($studentInfo);
}