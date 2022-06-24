<?php
// 初始化数据库操作类
require './init.php';

// 获取展示文章的ID
$id = isset($_GET['id']) ? intval($_GET['id']) :  0;

if ($id) {
    // 根据ID查询该文章
    $sql = "select `title`,`content`,`author`,`addtime`,`cid` from `cms_article` where `id` = $id";
    $rst = $db->fetchRow($sql);
    // 获取分类名称
    $sql = 'select `name` from `cms_category` where `id`=' . $rst['cid'];
    $cname = $db->fetchRow($sql);
    $rst['cname'] = $cname['name'];
    // 更新点击量
    $sql = "update `cms_article` set `hits`=`hits`+1 where `id`=$id";
    $db->query($sql);
    // 根据文章ID获取上一篇文章ID
    $sql = "select `id` from `cms_article` where `id`<{$id} order by `id` desc limit 1";
    $pre = $db->fetchRow($sql);
    // 根据文章ID获取下一篇文章ID
    $sql = "select `id` from `cms_article` where `id`>{$id} order by `id` asc limit 1";
    $next = $db->fetchRow($sql);
    // 判断上一篇文章是否存在
    $pre_link = $pre ? '?id=' . $pre['id'] : '';
    // 判断上一篇文章是否存在
    $next_link = $next ? '?id=' . $next['id'] : '';

    // 判断COOKIE中是否存在history记录
    if (isset($_COOKIE['history'])) {
        // history存在时，取出数据
        // 获取COOKIE，保存到数组中，限制数组最多只能有4个元素
        $cookie_arr = explode(',', $_COOKIE['history'], 4);
        //遍历数组
        foreach ($cookie_arr as $k => $v) {
            // 将数组中的每个元素转换为整型
            $cookie_arr[$k] = intval($cookie_arr[$k]);
            // 如果当前文章id在数组中已经存在，则删除
            if ($v == $id) {
                unset($cookie_arr[$k]);
            }
        }
        // 当数组元素达到4个时，删除最后一个元素
        if (count($cookie_arr) > 3) {
            array_pop($cookie_arr);
        }
        // 将当前访问的文章id添加到数组开头
        array_unshift($cookie_arr, $id);
        // 将数组转换为字符串，重新保存到COOKIE中
        setcookie('history', implode(',', $cookie_arr));
    } else {
        // history不存在时，向COOKIE中保存history记录
        // 通过数组保存浏览历史id
        $cookie_arr = array($id);
        // 将当前文章id保存到COOKIE中
        setcookie('history', $id);
    }
    // 清除历史功能
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'clear') {
            $cookie_arr = array();  // 清除历史记录数组
            setcookie('history', '', time()-1);  // 清除COOKIE
        }
    }

    //$data_history保存COOKIE中的历史记录
    $data_history = array();
    if (count($cookie_arr) > 0) {
        $ids = implode(',', $cookie_arr);
        $sql = "select `id`,`title` from `cms_article` where id in($ids) order by field(id,$ids);";
        $data_history = $db->fetchAll($sql);
    }

    // 加载HTML模板文件
    require './view/article_show.html';
}
