<?php

require './init.php';

// 未登录不允许访问
if (!$login) {
    header('Location: login.php');
    exit;
}

// 定义数组$city保存预设的城市下拉列表
$city = array('北京','上海','广州','其他');

// 定义数组$skill保存预设的语言技能复选框
$skill = array('HTML','JavaScript','PHP','C++');

// 获取登录的用户的ID
$id = $userinfo['id'];

//判断是否有表单提交
if (!empty($_POST)) {
    // 当有表单提交时，收集表单数据，保存到数据库中

    // 指定需要接收的表单字段
    $fields = array('nickname','gender','email','qq','url','city','skill','description');

    // 根据程序中定义好的表单字段收集$_POST数据
    foreach ($fields as $v) {
        //$save_data保存收集到的表单数据，不存在的字段填充空字符串
        $save_data[$v] = isset($_POST[$v]) ? $_POST[$v] : '';
    }

    // 单选框处理
    if ($save_data['gender']!='男' && $save_data['gender']!='女') {
        $error[] = '保存失败：未选择性别。';
        require './view/profile.html';
        exit;
    }

    // 下拉菜单处理
    if ($save_data['city']!='未选择' && !in_array($save_data['city'], $city)) {  //判断是否是$city数组中定义的合法值
        $error[] = '保存失败：您填写的城市不在允许的城市列表中。';
        require './view/profile.html';
        exit;
    }

    // 复选框处理
    if (is_array($save_data['skill'])) {
        $save_data['skill'] = array_intersect($skill, $save_data['skill']); //只取出合法的数组元素
        $save_data['skill'] = implode(',', $save_data['skill']);  //将数组转换为用逗号分隔的字符串
    } else {
        $save_data['skill'] = '';
    }

    //通过循环数组，自动拼接SQL语句，保存到数据库中
    $sql = 'update `cms_userinfo` set ';
    foreach ($save_data as $k => $v) {
        $sql .= "`$k`=:$k,"; //拼接每个字段的SQL语句
    }
    $sql = rtrim($sql, ',') . " where id=$id"; //rtrim($sql,',')用于去除$sql中的最后一个逗号
    $rst = $db->data($save_data)->query($sql);

    //输出执行结果和调试信息
    $error[] = $rst ? "保存成功" : "保存失败";
}

// 执行到此处表示没有表单提交，程序将根据id查询用户信息并显示到表单里

// 根据指定id查询用户信息
$sql = "select `nickname`,`gender`,`email`,`qq`,`url`,`city`,`skill`,`description` from `cms_userinfo` where `id`=$id";
$data = $db->fetchRow($sql);

// 判断是否查询到数据
if (!$data) {
    // 数据不存在时添加
    $data = array(
        'id' => $id,
        'nickname' => '',
        'gender' => '男',
        'skill' => '',
        'email' => '',
        'qq' => '',
        'url' => '',
        'city' => '',
        'skill' => '',
        'description' => ''
    );
    $sql = 'insert into `cms_userinfo` (`'.implode('`,`', array_keys($data)).'`) values (:'.implode(',:', array_keys($data)).')';
    $db->data($data)->query($sql);
}

// 将skill字段通过“,”分隔符转换为数组
$data['skill'] = explode(',', $data['skill']);

// 加载HTML模板文件
require './view/profile.html';
