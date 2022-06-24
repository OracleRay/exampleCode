<?php
header('content-type:text/html;charset=utf-8');

// 未指定过期时间，在会话结束时过期
setcookie('city', '北京市');

// 半小时后过期（60*30 = 1800）
setcookie('city', '北京市', time() + 1800);

// 一小时后过期（60*60 = 3600）
setcookie('city', '北京市', time() + 3600);

// 一天后过期
setcookie('city', '北京市', time() + 60 * 60 * 24);

// 立即过期（删除COOKIE）
setcookie('city', '', time() - 1);

// 判断COOKIE中是否存在city数据
if (isset($_COOKIE['city'])) {
    // 存在
    $city = $_COOKIE['city'];  // 从COOKIE中获取City数据
} else {
    // 不存在
}
