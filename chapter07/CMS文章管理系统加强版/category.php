<?php
// 初始化数据库操作类
require './init.php';

// 获取操作标识
$a = isset($_GET['a']) ? $_GET['a'] :  '';

// 添加文章分类
if ($a == 'category_add') {
    // 对取得的分类名称进行安全过滤
    $data['name'] = trim(htmlspecialchars($_POST['name']));
    // 判断分类名称是否为空
    if ($data['name'] === '') {
        $error[] = '文章分类名称不能为空！';
    } else {
        // 判断数据库中是否有同名的分类名称
        $sql = "select `id` from `cms_category` where `name`=:name";
        if ($db->data($data)->fetchRow($sql)) {
            $error[] = '该文章分类名称已存在！';
        } else {
            // 插入到数据库
            $sql = "insert into `cms_category`(`name`) values (:name)";
            $db->data($data)->query($sql);
        }
    }
    header('Location: category.php');
    exit;
} elseif ($a == 'category_edit') {  // 文章分类修改
    // 获取提交的数组
    $ids = isset($_POST['ids']) ? (array)$_POST['ids'] : array();
    // 转换为二维数组
    $data = array();
    foreach ($ids as $k => $v) {
        $data[] = array(
            'id' => (int)$k,
            'sort' => isset($v['sort']) ? (int)$v['sort'] : 0,
            'name' => isset($v['name']) && is_string($v['name']) ? trim(htmlspecialchars($v['name'])) : 0
        );
    }
    // 批量保存
    $sql = "update `cms_category` set `sort`=:sort,`name`=:name where `id`=:id";
    $db->data($data)->query($sql, true);
    header('Location: category.php');
    exit;
} elseif ($a == 'category_del') {   // 删除文章分类
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $sql = "select `id` from `cms_article` where `cid`=$id limit 1";
    if ($db->fetchRow($sql)) {
        $error[] = '该文章分类下有文章，不能删除！';
    } else {
        $sql = "delete from `cms_category` where `id`=$id";
        $db->query($sql);
        header('Location: category.php');
        exit;
    }
}

// 加载HTML模板文件
require './view/category_list.html';
