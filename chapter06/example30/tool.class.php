<?php
/**
 * 常用工具类  
 */
class tool {
    /**
     * JavaScript 弹窗并且跳转
     * @param string $info 跳转信息
     * @param string $url 跳转地址
     * @return string 返回能够执行跳转的JavaScript代码
     */
    //该方法在某个操作执行成功并需要跳转到指定页面时使用
    public static function alertGo($info, $url) {
        //弹出一个对话框，提示$info中的信息，然后location跳转到$_url指定的页面
        echo "<script>alert('$info');location.href='$url';</script>";
        exit();
    }
    /**
     * JavaScript 弹窗返回
     * @param string $info 跳转信息 
     * @return string 返回能够执行跳转的JavaScript代码
     */
    //该方法在某个操作执行失败时使用
    public static function alertBack($info) {
        //弹出对话框，提示$info变量中的信息，然后返回上一个访问的页面
        echo "<script>alert('$info');history.back();</script>";
        exit();
    }
}
