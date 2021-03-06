<?php

/**
 * 文件上传类
 */
class upload {

    //允许上传的文件类型数组
    private $allow_types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif');
    //允许上传的文件最大尺寸，1048576表示大小为1M
    private $max_size = 1048576;
    //上传的文件保存在服务器中的目录位置
    private $upload_path = './';
    //上传文件时产生的错误
    private $error = '';
    
    /**
     * 构造方法
     * @param array $params 用来修改成员属性的数组数据
     */
    public function __construct($params = array()) {

        //判断$params中是否有types元素，如果有则把types元素的值赋值给$allow_types属性
        if(isset($params['types'])) $this->allow_types = $params['types'];

        //判断$params中是否有size元素，如果有则把size元素的值赋值给$max_size属性
        if(isset($params['size'])) $this->max_size = $params['size'];

        //判断$params中是否有path元素，如果有则把path元素的值赋值给$upload_path属性
        if(isset($params['path'])) $this->upload_path = $params['path'];

    }
    
    
    
    /**
     * 上传文件的函数
     * @param array $file 包含文件的5个信息的数据
     * @param string $prefix 前缀
     * @return string 目标文件名
     */
    public function up($file, $prefix = '') {
        //是否有错误
        if ($file['error'] != 0) {
			$upload_errors = array(
				1 => '文件过大，超过了PHP配置的限制',
				2 => '文件过大，超过了Form表单中的限制',
				3 => '文件没有上传完毕',
				4 => '文件没有上传',
				6 => '没有找到临时上传目录',
				7 => '临时文件写入失败',
			);
			$this->error = isset($upload_errors[$file['error']]) ? $upload_error[$file['error']] : '未知错误';
			return false;
        }

        //判断文件类型是否存在于$allow_type中
        if (!in_array($file['type'], $this->allow_types)) {
			//如果不存在，则更新属性$error，把相关错误信息赋值给该属性，最后返回 false
            $this->error = '该类型不能上传，允许的类型为：' . implode('|', $this->allow_types);
            return false;
        }

        //判断文件大小是否超过$max_size 规定的值
        if ($file['size'] > $this->max_size) {
			//如果超过了，则更新属性$error，把相关错误信息赋值给该属性，最后返回 false
            $this->error = '文件不能超过' . $this->max_size . '字节';
            return false;
        }

        //确定新文件名，生成唯一的文件名-同时保持原有的文件扩展名
        $new_file = uniqid($prefix) . strrchr($file['name'], '.');
        //确定当前的子目录
        $sub_path = date('YmdH');
		//确定上传文件的全路径
		$upload_path = $this->upload_path . $sub_path;
        //判断这个目录是否存在
        if (!is_dir($upload_path)) {
            //不存在，则创建
            mkdir($upload_path);
        }
        //移动文件
        if (move_uploaded_file($file['tmp_name'], $upload_path . '/' . $new_file)) {
            //成功则返回这个文件的目录地址
            return $sub_path . '/' . $new_file;
        } else {
            //失败则更新属性$error，把相关错误信息赋值给该属性，最后返回false
            $this->error = '移动失败';
            return false;
        }
    }

    public function getError() {
        //获取私有属性$error
        return $this->error;
    }
    
    public function __destruct() {
        echo "<p class='box'>upload对象被销毁的时间为：".date("H:i:s").'</p>';
    }

}
