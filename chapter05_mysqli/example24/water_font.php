<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>图片添加水印</title>
	<style>
	body{ background:#F1F1F1; }
	img{ width:200px;padding:0px; border:1px solid #999; padding:2px;}
	table{ border-collapse:separate; border:1px solid #f0f0f0; width:350px; text-align:center; margin:0 auto; background:#fff;}
	</style>
</head>
 <body>
<?php
/**
 * 添加水印功能
 * @param string $source 原图
 * @param string $path 水印图片存放路径,默认为空，表示在当前目录
 * @return 
 */
function watermark($source,$path = ''){
	//新图片文件名前缀
	$waterPrefix = 'font_';
	//图片类型和对应创建画布资源的函数名
	$from = array(
		'image/gif'  => 'imagecreatefromgif',
		'image/png'  => 'imagecreatefrompng',
		'image/jpeg' => 'imagecreatefromjpeg'
	);
	//图片类型和对应生成图片的函数名
	$to = array(
		'image/gif'  => 'imagegif',
		'image/png'  => 'imagepng',
		'image/jpeg' => 'imagejpeg'
	);
	
	//获取原图信息
	$src_info = getimagesize($source);
	$src_w = $src_info[0];
	$src_h = $src_info[1];
	//获取各图片对应的创建函数名
	$src_create_fname = $from[$src_info['mime']];
	//使用可变函数来创建画布资源
	$src_img = $src_create_fname($source); 
	//设置字体样式（宋体）
	$font_style = 'C:\Windows\Fonts\simsun.ttc';
	//设置字体颜色
	$color = imagecolorallocate($src_img, 0xff, 0x00, 0xff);

	/**
	 * 生成文字水印
	 * @param resource $src_img 原图像资源
	 * @param int 30     文字大小
	 * @param int 0      文字水印在原图像中的角度
	 * @param int 0,35   文字水印在原图像中的横坐标和纵坐标
	 * @param int $color 文字水印的字体颜色
	 * @param string $font_style   文字水印的字体样式
	 * @param string '快乐学习PHP'  文字水印的文本
	 */
	imagefttext($src_img, 30, 0, 0,35, $color, $font_style, '快乐学习PHP');

	//生成带水印文字的图片路径
	$waterfile = $path.$waterPrefix.$source;
	$generate_fname = $to[$src_info['mime']];			
	if ($generate_fname($src_img,$waterfile)){
		echo "<table cellspacing='10'><tr><th colspan='2'>为图片添加水印</th></tr>";
		echo "<tr><td>原  图  像：</td><td><img src='".$source."' /></td></tr>";
		echo "<tr><td>加水印后：</td><td><img src='".$waterfile."' /></td></tr></table>";
	}else{
		echo "输出水印图片到指定目录出错！";
		return false;
	}
}

//定义原图片路径
$source = 'class.jpg';
//调用函数：在图片中添加文字水印
watermark($source);
?>
 </body>
</html>