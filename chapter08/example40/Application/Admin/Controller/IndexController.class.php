<?php
//当前控制器的命名空间，对应Application\Admin\Controller目录
namespace Admin\Controller;
//引入的命名空间
use Think\Controller;
//Admin模块Index控制器
class IndexController extends Controller {

	//后台首页
    public function index() {
		//判断用户是否已经登录
        if ($admin_name = session('admin_name')) {
            $this->assign('admin_name', $admin_name);
            $this->display();
        } else {
            $this->error('非法用户，请先登录！', U('login'));
 	    }
 	}

	//登录
    public function login() {
        if (IS_POST) {
            $adminModel = M('admin');
            $adminInfo = $adminModel->create();
            $where = array(
                    'aname' => $adminInfo['aname'],
            );
            if ($realPwd = $adminModel->where($where)->getField('apwd')) {
                if ($realPwd == md5($adminInfo['apwd'])) {
                    session('admin_name', $adminInfo['aname']);
                    $this->success('用户合法，登录中，请稍候...', U('index'));
                    return;
                }
            }
            $this->error('用户名或密码不正确，请重试！');
            return;
        }
        $this->display();
    }

	//退出
	public function logout(){
		session(null);
		$this->success('退出成功。',U('index'));
	}
}