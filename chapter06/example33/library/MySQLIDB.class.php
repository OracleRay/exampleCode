<?php

/**
 * MySQL数据库操作类（基于 mysql扩展完成）
 * 所有的针对数据库直接操作类，由MySQLDB完成
 */
class MySQLIDB {

    // 数据库连接信息
    private $dbConfig = array(
        'host' => 'localhost', // 主机
        'port' => '3306',      // 端口
        'user' => '',          // 用户
        'pwd' => '',           // 密码
        'charset' => 'utf8',   // 字符集
        'dbname' => '',        // 默认的数据库
    );

    // 数据库连接资源
    private $link;

    // 单例对象
    private static $instance;

    /**
     * 获得单例对象的公共接口方法
     * @param array $params 数据库连接信息
     * @return object 单例的对象
     */
    public static function getInstance($params = array()) {
        // 判断是否没有实例化过
        if (!self::$instance instanceof self) {
            // 实例化并保存
            self::$instance = new self($params);
        }
        // 返回对象
        return self::$instance;
    }

    /**
     * 构造方法
     * @param array $params 关联数组
     */
    private function __construct($params = array()) {
        // 初始化数据库连接信息
        $this->initAttr($params);
        // 连接数据库
        $this->connectServer();
        // 设定字符集
        $this->setCharset();
        // 选择默认数据
        $this->selectDefaultDb();
    }

    public function __destruct() {
        // mysql_close($this->link);
    }

    /**
     * 私有克隆
     */
    private function __clone() {
        
    }

    /**
     * 初始化属性
     * @param array $params 数据库连接信息
     */
    private function initAttr($params) {
        // 初始化属性，使用 array_marge() 函数合并两个数组
        $this->dbConfig = array_merge($this->dbConfig,$params);
    }

    /**
     * 连接目标服务器
     */
    private function connectServer() {
        $host = $this->dbConfig['host'];
        $port = $this->dbConfig['port'];
        $user = $this->dbConfig['user'];
        $pwd = $this->dbConfig['pwd'];
        $dbName = $this->dbConfig['dbname'];
        // 连接数据库服务器
        if ($link = mysqli_connect($host, $user ,$pwd, $dbName, $port)) {
            $this->link = $link;
        } else {
            // 失败
            exit('数据库服务器连接失败，请确认连接信息！' . mysqli_connect_error());
        }
    }

    /**
     * 设定连接字符集
     */
    private function setCharset() {
        mysqli_set_charset($this->link, $this->dbConfig['charset']);
    }

    /**
     * 选择默认数据库
     */
    private function selectDefaultDb() {
        // 判断 $this->dbConfig['dbname'] 是否为空，为空，表示不需要选择数据库
        if ($this->dbConfig['dbname'] == '') {
            return;
        }
        mysqli_select_db($this->link, $this->dbConfig['dbname']);
    }

    /**
     * 执行SQL的方法
     * @param string $sql 待执行的SQL
     * @return mixed 查询语句返回结果集，非查询语句返回 true
     */
    public function query($sql) {
        if ($result = mysqli_query($this->link, $sql)) {
            //执行成功
            return $result;
        } else {
            //执行失败
            echo 'SQL执行失败:<br>';
            echo '错误的SQL为:', $sql, '<br>';
            echo '错误的代码为:', mysqli_errno($this->link), '<br>';
            echo '错误的信息为:', mysqli_error($this->link), '<br>';
            exit;
            // return false;
        }
    }

    /**
     * 查询所有记录
     * @param string $sql 待执行的查询类的SQL
     * @return array 二维数组
     */
    public function fetchAll($sql) {
        if ($result = $this->query($sql)) {
            $rows = array();
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
            mysqli_free_result($result);
            return $rows;
        } else {
            //执行失败
            return false;
        }
    }

    /**
     * 查询单条记录
     * @param string $sql 待执行的查询类的SQL
     * @return array 一维数组
     */
    public function fetchRow($sql) {
        if ($result = $this->query($sql)) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $row;
        } else {
            //执行失败
            return false;
        }
    }

    /**
     * 查询单个数据
     * @param string $sql 待执行的查询类的SQL
     * @return string 查询到的数据
     */
    public function fetchColumn($sql) {
        if ($result = $this->query($sql)) {
            if ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                // 取得其第一个元素
                return $row[0];
            } else {
                return false;
            }
        } else {
            // SQL语句执行失败
            return false;
        }
    }

    /**
     * mysql 转义字符串
     * @param string $data 待转义的字符串
     * @param string 转义后的结果
     */
    public function escapeString($data) {
        return mysqli_real_escape_string($this->link, $data);
    }

    /**
     * 获得当前最新的自动增长ID
     */
    public function lastInsertId() {
        return mysqli_insert_id($this->link);
    }

}
