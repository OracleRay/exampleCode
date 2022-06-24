<?php
/*
 * 定义usb接口
 */
interface usb{
	public function connect();     //连接
	public function transfer();    //传输数据
	public function disconnect();  //断开连接
}