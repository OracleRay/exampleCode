<?php
/**
 * 初始化数据库连接
 */
function dbInit() {
    static $link; // 利用静态变量保存数据库连接
    if (!$link) {
        $link = mysqli_connect('localhost','root','123456');
        // 判断数据库连接是否成功，如果不成功则显示错误信息并终止脚本继续执行
        if (!$link) {
            exit('连接数据库失败！' . mysqli_connect_error());
        }
        // 设置字符集，选择数据库
        mysqli_set_charset($link, 'utf8');
        mysqli_select_db($link, 'itcast');
    }
    return $link;
}

/**
 * 执行SQL的方法
 * @param string $sql 待执行的SQL
 * @return mixed 失败返回false，成功，如果是查询语句返回结果集，如果非查询类返回true
 */
function query($sql) {
    $link = dbInit();
    if ($result = mysqli_query($link, $sql)) {
        // 执行成功
        return $result;
    } else {
        // 设定失败
        echo 'SQL执行失败:<br>';
        echo '错误的SQL为:', $sql, '<br>';
        echo '错误的代码为:', mysqli_errno($link), '<br>';
        echo '错误的信息为:', mysqli_error($link), '<br>';
        exit;
    }
}

/**
 * 处理结果集中有多条数据的方法
 * @param string $sql 待执行的SQL
 * @return array 返回遍历结果集后的二维数组
 */
function fetchAll($sql) {

    // 执行query()函数
    if ($result = query($sql)) {
        // 执行成功
        // 遍历结果集
        $rows = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        // 释放结果集资源
        mysqli_free_result($result);
        return $rows;
    } else {
        // 执行失败
        return false;
    }
}

/**
 * 处理结果集中只有一条数据的方法
 * @param string $sql 待执行的SQL语句
 * @return array 返回结果集处理后的一维数组
 */
function fetchRow($sql) {
    // 执行query()函数
    if ($result = query($sql)) {
        // 从结果集取得一次数据即可
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row;
    } else {
        return false;
    }
}


/**
 * 对数据进行安全处理
 * @param string $data 待转义字符串
 * @return string 转义后的字符串
 */
function safeHandle($data){
    //转义字符串中的HTML标签
    $data = htmlspecialchars($data);
    //转义字符串中的特殊字符
    $link = dbInit();
    $data = mysqli_real_escape_string($link, $data);
    return $data;
}
