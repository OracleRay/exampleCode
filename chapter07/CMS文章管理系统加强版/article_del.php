<?php
//初始化数据库操作类
require './init.php';

//获取删除文章ID
$id = isset($_GET['id']) ? intval($_GET['id']) :  0;

if ($id) {
    $sql = "delete from `cms_article` where `id` = $id";
    $db->query($sql);
    //跳转到首页
    header("location:index.php");
    exit;
}
