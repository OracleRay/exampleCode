<?php
header('content-type:text/html;charset=utf-8');
//载入interface.php文件
require './interface.php';

//使用implements关键字实现usb接口
class mp3 implements usb{
	public function connect(){
		echo '开始连接<br>';
	}
	public function transfer() {
		echo '开始传输....传输结束<br>';
	}
	public function disconnect() {
 		echo '断开<br>';
 	}
}
$mp3 = new mp3;
$mp3->connect();