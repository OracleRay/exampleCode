<?php
//声明文件解析的编码格式
header('content-type:text/html;charset=utf-8');
//数据库配置
$dbConfig = array(
    'user' => 'root',
    'pwd' => '123456',
    'dbname' => 'itcast'
);
//使用__autoload()启动自动加载
function __autoload($className) {
    require "./library/$className.class.php";
}
//定义model方法用来实例化模型类
function model($tableName) {
    $model = $tableName . 'Model';
    return new $model($tableName);
}
