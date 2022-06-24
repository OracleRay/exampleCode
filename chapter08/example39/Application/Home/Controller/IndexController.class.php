<?php
//当前控制器的命名空间，对应Application\Home\Controller目录
namespace Home\Controller;
//引用的命名空间，对应ThinkPHP\Library\Think目录
use Think\Controller;
//Index控制器
class IndexController extends Controller {

    public function index() {
        //获取服务器软件信息，并分割成数组
        $version_arr = explode(' ', $_SERVER['SERVER_SOFTWARE']);
        //从$version_arr数组中获取apache版本信息
        $serverInfo['apache_version'] = $version_arr[0];
        //从$version_arr数组中获取系统版本信息
        $serverInfo['server_version'] = $version_arr[1];
        //从$version_arr数组中获取php版本信息
        $serverInfo['php_version'] = $version_arr[2];
        //获取服务器当前时间
        $serverInfo['server_time'] = date('Y-m-d H:i:s', time());
        //获取当前脚本地址
        $serverInfo['script_path'] = $_SERVER['SCRIPT_FILENAME'];
        //使用ThinkPHP提供的assign()方法向视图文件分配数据
		$this->assign('serverInfo', $serverInfo);
        //使用ThinkPHP提供的display()方法调用视图页面
        $this->display();
    }

}
