<?php

// 初始化数据库操作类
require './init.php';

// 载入分页类，自动生成分页的HTML链接
require './lib/Page.php';

// 获取要查询的分类ID，0表示全部
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
// 获取当前页码号
$page = isset($_GET['page']) ? intval($_GET['page']) :  1;

// 获取查询列表条件
$where = '';
if ($cid) {
    $where = "where `cid`=$cid";
}

// 获取总记录数
$sql = "select count(*) as total from `cms_article` $where";
$results = $db->fetchRow($sql);
$total = $results['total'];

// 实例化分页类
$Page = new \lib\Page($total, 2, $page); // Page(总页数，每页显示条数，当前页)
$limit = $Page->getLimit();       // 获取分页链接条件
$page_html = $Page->showPage();   // 获取分页HTML链接

// 分页获取文章列表
$sql = "select `id`,`title`,`content`,`author`,`addtime`,`cid` from `cms_article` $where order by `addtime` desc limit $limit";
$articles = $db->fetchAll($sql);

// 通过mbstring扩展截取文章内容作为摘要
foreach ($articles as $k => $v) {
    // mb_substr(内容，开始位置，截取长度，字符集)
    $articles[$k]['content'] = mb_substr(trim(strip_tags($v['content'])), 0, 150, 'utf-8').'…… ……';
}

// 获取当前时间向前一周内发表的文章
$where = ' where `addtime` > date_sub(curdate(), INTERVAL 7 DAY)';
// 根据点击量，获取一周内4个点击量最高的文章名称
$sql = "select `id`, `title` from `cms_article` $where order by `hits` desc limit 4";
$hots = $db->fetchAll($sql);

// 判断文章标题的长度，超出规定长度进行截取
foreach ($hots as $k => $v) {
    // 每周热文标题的长度最大为47个字符
    if (mb_strlen($v['title']) > 47) {
        $hots[$k]['title'] = mb_substr(trim(strip_tags($v['title'])), 0, 15, 'utf-8').'···';
    }
}

// 此时有以下变量需要输出到HTML模板：
// $category  分类列表
// $articles  文章列表
// $page_html 分页导航

//加载HTML模板文件
require './view/index.html';
