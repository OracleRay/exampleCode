<?php

header('content-type:text/html;charset=utf-8');


/**
 * 自动加载函数
 */
function __autoload($className){
	require "./$className.class.php";
}

/**
 * 自动加载函数
 * @param string $className 类名
 */
//function user_autoload($className){
//	require "./$className.class.php";
//}

//注册用户自定义加载函数
//spl_autoload_register('user_autoload');
