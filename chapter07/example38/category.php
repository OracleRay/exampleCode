<?php
//初始化数据库操作类
require('./init.php');

//获取操作标识
$a = isset($_GET['a']) ? $_GET['a'] :  '';

//添加文章分类
if($a == 'category_add'){
	
	//对取得的分类名称进行安全过滤
	$data['name'] = trim(htmlspecialchars($_POST['name']));
	
	//判断分类名称是否为空
	if($data['name'] === ''){
		$error[] = '文章分类名称不能为空！';
	}else{
		
		//判断数据库中是否有同名的分类名称
		$sql = "select `id` from `cms_category` where `name`=:name";

		if($db->data($data)->fetchRow($sql)){
			$error[] = '该文章分类名称已存在！';
		}else{
			//插入到数据库
			$sql = "insert into `cms_category`(`name`) values (:name)";
			$db->data($data)->query($sql);
		}	
	}

}

//文章分类排序
elseif($a == 'category_sort'){
	//获取提交的数组
	$ids = isset($_POST['id']) ? (array)$_POST['id'] : array();
	//转换为二维数组
	$data = array();	
	foreach($ids as $k=>$v){
		$data[] = array(
			'id' => (int)$k,
			'sort' => (int)$v
		);
	}
	//批量保存
	$sql = "update `cms_category` set `sort`=:sort where `id`=:id";
	$db->data($data)->query($sql,true);
}


//删除文章分类
elseif($a == 'category_del'){

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	$sql = "select `id` from `cms_article` where `cid`=$id limit 1";
	
	if($db->fetchRow($sql)){
		$error[] = '该文章分类下有文章，不能删除！';
	}else{
		$sql = "delete from `cms_category` where `id`=$id";
		$db->query($sql);
	}
}


//取出文章分类列表
$sql = 'select `id`,`name`,`sort` from `cms_category` order by `sort`';
$category = $db->fetchAll($sql);


//加载HTML模板文件
require('./view/category_list.php');