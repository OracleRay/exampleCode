<?php

require './init.php';

// 没有表单提交时，显示注册页面
if (empty($_POST)) {
    require './view/register.html';
    exit;
}
// 执行到此处说明有表单提交

// 判断表单中各字段是否都已填写
$check_fields = array('username', 'password', 'email');
foreach ($check_fields as $v) {
    if (empty($_POST[$v])) {
        $error[] = '错误：' . $v . '字段不能为空！';
    }
}
if (!empty($error)) {
    require './view/register.html';
    exit;
}

// 接收需要处理的表单字段
$username = trim($_POST['username']);
$password = $_POST['password'];
$email = trim($_POST['email']);

// 载入表单验证函数库，验证用户名和密码格式
require './lib/check_form.php';
if (($result = checkUsername($username)) !== true) {
    $error[] = $result;
}
if (($result = checkPassword($password)) !== true) {
    $error[] = $result;
}
if (($result = checkEmail($email)) !== true) {
    $error[] = $result;
}
if (!empty($error)) {
    require './view/register.html';
    exit;
}

//判断用户名是否存在
$sql = "select `id` from `cms_user` where `username`=:username";
if ($db->data(array('username'=> $username))->fetchRow($sql)) {
    $error[] = '用户名已经存在，请换个用户名。';
    require './view/register.html';
    exit;
}

// 生成密码盐
$salt = md5(uniqid(microtime()));

// 提升密码安全
$password = md5($salt.md5($password));

// 拼接SQL语句
$sql = "insert into `cms_user` (`username`,`password`,`salt`,`email`) values (:username,:password,:salt,:email)";

//执行SQL语句
$data = array('username'=> $username, 'password'=> $password, 'salt'=> $salt, 'email'=> $email);

$rst = $db->data($data)->query($sql);

if ($rst) {
    //用户注册成功，自动登录
    
    //获取新注册用户的ID
    $id = $db->lastInsertId();
    
    $_SESSION['userinfo'] = array(
        'id' => $id,               // 将用户id保存到SESSION
        'username' => $username    // 将用户名保存到SESSION
    );

    //注册成功，自动跳转到会员中心
    echo '<script>alert("注册成功！");window.location.href="index.php"; </script>';
    exit;
} else {
    $error[] = '注册失败，数据库操作失败。';
    require './view/register.html';
    exit;
}

require './view/register.html';
