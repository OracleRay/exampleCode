<?php
//初始化数据库操作类
require('./init.php');
//载入分页类，自动生成分页的HTML链接
require('./lib/page.class.php');


//获取要查询的分类ID，0表示全部
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
//获取当前页码号
$page = isset($_GET['page']) ? intval($_GET['page']) :  1;

//取出分类列表
$sql = 'select `id`,`name` from `cms_category` order by `sort` limit 10';
$category = $db->fetchAll($sql);

//取出文章列表

//获取查询列表条件
$where = '';
if($cid)  $where = "where `cid`=$cid";

//获取总记录数
$sql = "select count(*) as total from `cms_article` $where";
$results = $db->fetchRow($sql);
$total = $results['total'];

//实例化分页类
$Page = new Page($total,2,$page); //Page(总页数，每页显示条数，当前页)
$limit = $Page->getLimit();       //获取分页链接条件
$page_html = $Page->showPage();   //获取分页HTML链接

//分页获取文章列表
$sql = "select `id`,`title`,`content`,`author`,`addtime`,`cid` from `cms_article` $where order by `addtime` desc limit $limit";
$articles = $db->fetchAll($sql);

//通过mbstring扩展截取文章内容作为摘要
foreach($articles as $k=>$v){
	//mb_substr(内容，开始位置，截取长度，字符集)
	$articles[$k]['content'] = mb_substr(trim(strip_tags($v['content'])),0,150,'utf-8').'…… ……';
}

/**
    此时有以下变量需要输出到HTML模板：
	$category  分类列表
    $articles  文章列表
	$page_html 分页导航
 */

//加载HTML模板文件
require('./view/index.php');