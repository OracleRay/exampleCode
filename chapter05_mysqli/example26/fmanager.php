<?php
header('Content-type:text/html;charset=utf-8');
//限制PHP脚本只能访问其所在的目录
ini_set('open_basedir',__DIR__);

//获取文件路径参数
$path = isset($_GET['path']) ? $_GET['path'] : '.';
//保存待处理文件名
$file = '';
//判断 $path 路径是否存在
if(is_file($path)){
	//如果是文件，则取出路径中的文件名
	$file = basename($path);
	//将 $path 转换为目录
	$path = dirname($path);
}elseif(!is_dir($path)){
	//如果既不是文件也不是目录，则程序停止
	die('无效的文件路径参数');
}
/*
  此时有两个变量：
  $path 保存路径
  $file 保存文件名，如果没有文件名则为空字符串
*/
//获取操作参数
$action = isset($_GET['a']) ? $_GET['a'] : '';
switch($action){
	//操作“返回上级目录”
	case 'prev':
		$path = dirname($path);
	break;
	//操作“重命名”
	case 'rename':
		//当有表单提交时
		if(!empty($_POST)){
			//获取目标文件名
			$target = isset($_POST['target']) ? trim($_POST['target']) : '';
			//如果待操作文件不为空，则进行重命名操作
			if($file && $target){
				if(file_exists("$path/$target")){
					die('目标文件已经存在');
				}
				rename("$path/$file","$path/$target");
			}
			//重命名完成后跳转
			header('Location:?path='.$path);
			die;
		}
	break;
	//操作“删除”
	case 'del':
		if($file){
			unlink("$path/$file");
		}
	break;
	//操作“复制”
	case 'copy':
		if($file){
			if(file_exists("$path/$file.bak")){
				die('文件名冲突，复制失败');
			}
			if(!copy("$path/$file", "$path/$file.bak")){
				die('复制文件失败。');
			}
		}
	break;
}
/**
 * 根据路径获取文件列表
 * @param string $path 路径
 * @return array 文件列表数组
 */
function getFileList($path){	
	//保存打开文件的句柄
	$handle = opendir($path);
	//保存文件列表数组，dir保存目录，file保存文件
	$list = array('dir'=>array(),'file'=>array());
	//循环遍历文件列表
	while (false !== ($filename = readdir($handle))){
		//排除当前目录和父级目录
		if($filename != '.' && $filename != '..'){
			//处理文件路径和文件名
			$filepath = "$path/$filename";
			//根据路径获取文件类型
			$filetype = filetype($filepath);
			//如果既不是文件也不是目录，则跳过
			if(!in_array($filetype,array('file','dir'))){
				continue;
			}
			//将文件保存到数组中
			$list[$filetype][] = array(
				//保存文件名和路径
				'filename' => $filename,
				'filepath' => $filepath,
				//保存各种属性
				'filesize' => round(filesize($filepath)/1024),
				'filemtime' => date('Y/m/d H:i:s',filemtime($filepath)),
			);
		}
	}
	//关闭文件句柄
	closedir($handle);
	return $list;
}

//调用函数，获取文件列表
$file_list = getFileList($path);
//加载HTML模板文件
define('APP','itcast');
require 'fmanager_html.php';