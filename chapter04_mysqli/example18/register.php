<?php
header('content-type:text/html;charset=utf-8');

// 引入表单验证函数库
require 'check_form.lib.php';

// 假设PHP程序收到了用户注册表单
// 演示正确的输入
$data = array(
    'username' => '小明',
    'password' => '123456',
    'email' => 'xiaoming@123.com',
);
// 演示错误的输入
$data = array(
    'username' => '1',
    'password' => '1',
    'email' => 'xiaomingcom',
);
// 为每个字段定义不同的验证函数
$validate = array(
    'username' => 'checkUsername',
    'password' => 'checkPassword',
    'email' => 'checkEmail',
);

// $error数组保存验证失败时的错误信息
$error = array();

// 循环验证每个字段，保存错误信息
foreach ($validate as $k => $v) {
    // 运用可变函数，实现不同字段调用不同函数
    $result = $v($data[$k]);
    if ($result !== true) {
        $error[] = $result;
    }
}

// 如果$error数组为空，说明没有错误
if (empty($error)) {
    exit('表单验证成功');
}

// 运行到此处说明表单验证失败

// 加载HTML模板文件
define('APP', 'itcast');
require 'register_error_html.php';
