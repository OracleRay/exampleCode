<?php
require './init.php';

// 清除COOKIE数据
setcookie('username', '', time()-1);
setcookie('password', '', time()-1);

// 清除SESSION数据
unset($_SESSION['userinfo']);

// 如果SESSION中没有其他数据，则销毁SESSION
if (empty($_SESSION)) {
    session_destroy();
}

// 跳转到首页
header('Location: index.php');

// 终止脚本
exit;
