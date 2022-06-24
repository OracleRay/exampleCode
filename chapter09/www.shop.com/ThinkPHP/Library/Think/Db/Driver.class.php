<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace Think\Db;
use Think\Config;
use Think\Debug;
use Think\Log;
use PDO;

abstract class Driver {
    // PDO操作实例
    protected $PDOStatement = null;
    // 当前操作所属的模型名
    protected $model      = '_think_';
    // 当前SQL指令
    protected $queryStr   = '';
    protected $modelSql   = array();
    // 最后插入ID
    protected $lastInsID  = null;
    // 返回或者影响记录数
    protected $numRows    = 0;
    // 事务指令数
    protected $transTimes = 0;
    // 错误信息
    protected $error      = '';
    // 数据库连接ID 支持多个连接
    protected $linkID     = array();
    // 当前连接ID
    protected $_linkID    = null;
    // 数据库连接参数配置
    protected $config     = array(
        'type'              =>  '',     // 数据库类型
        'hostname'          =>  '127.0.0.1', // 服务器地址
        'database'          =>  '',          // 数据库名
        'username'          =>  '',      // 用户名
        'password'          =>  '',          // 密码
        'hostport'          =>  '',        // 端口     
        'dsn'               =>  '', //          
        'params'            =>  array(), // 数据库连接参数        
        'charset'           =>  'utf8',      // 数据库编码默认采用utf8  
        'prefix'            =>  '',    // 数据库表前缀
        'debug'             =>  false, // 数据库调试模式
        'deploy'            =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'rw_separate'       =>  false,       // 数据库读写是否分离 主从式有效
        'master_num'        =>  1, // 读写分离后 主服务器数量
        'slave_no'          =>  '', // 指定从服务器序号
        'db_like_fields'    =>  '', 
    );
    // 数据库表达式
    protected $exp = array('eq'=>'=','neq'=>'<>','gt'=>'>','egt'=>'>=','lt'=>'<','elt'=>'<=','notlike'=>'NOT LIKE','like'=>'LIKE','in'=>'IN','notin'=>'NOT IN','not in'=>'NOT IN','between'=>'BETWEEN','not between'=>'NOT BETWEEN','notbetween'=>'NOT BETWEEN');
    // 查询表达式
    protected $selectSql  = 'SELECT%DISTINCT% %FIELD% FROM %TABLE%%FORCE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT% %UNION%%LOCK%%COMMENT%';
    // 查询次数
    protected $queryTimes   =   0;
    // 执行次数
    protected $executeTimes =   0;
    // PDO连接参数
    protected $options = array(
        PDO::ATTR_CASE              =>  PDO::CASE_LOWER,
        PDO::ATTR_ERRMODE           =>  PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS      =>  PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES =>  false,
    );
    protected $bind         =   array(); // 参数绑定

    /**
     * 架构函数 读取数据库配置信息
     * @access public
     * @param array $config 数据库配置数组
     */
    public function __construct($config=''){
        if(!empty($config)) {
            $this->config   =   array_merge($this->config,$config);
            if(is_array($this->config['params'])){
                $this->options  =   $this->config['params'] + $this->options;
            }
        }
    }

    /**
     * 连接数据库方法
     * @access public
     */
    public function connect($config='',$linkNum=0,$autoConnection=false) {
        if ( !isset($this->linkID[$linkNum]) ) {
            if(empty($config))  $config =   $this->config;
            try{
                if(empty($config['dsn'])) {
                    $config['dsn']  =   $this->parseDsn($config);
                }
                if(version_compare(PHP_VERSION,'5.3.6','<=')){ 
                    // 禁用模拟预处理语句
                    $this->options[PDO::ATTR_EMULATE_PREPARES]  =   false;
                }
                $this->linkID[$linkNum] = new PDO( $config['dsn'], $config['username'], $config['password'],$this->options);
            }catch (\PDOException $e) {
                if($autoConnection){
                    trace($e->getMessage(),'','ERR');
                    return $this->connect($autoConnection,$linkNum);
                }elseif($config['debug']){
                    E($e->getMessage());
                }
            }
        }
        return $this->linkID[$linkNum];
    }

    /**
     * 解析pdo连接的dsn信息
     * @access public
     * @param array $config 连接信息
     * @return string
     */
    protected function parseDsn($config){}

    /**
     * 释放查询结果
     * @access public
     */
    public function free() {
        $this->PDOStatement = null;
    }

    /**
     * 执行查询 返回数据集
     * @access public
     * @param string $str  sql指令
     * @param boolean $fetchSql  不执行只是获取SQL
     * @return mixed
     */
    public function query($str,$fetchSql=false) {
        $this->initConnect(false);
        if ( !$this->_linkID ) return false;
        $this->queryStr     =   $str;
        if(!empty($this->bind)){
            $that   =   $this;
            $this->queryStr =   strtr($this->queryStr,array_map(function($val) use($that){ return '\''.$that->escapeString($val).'\''; },$this->bind));
        }
        if($fetchSql){
            return $this->queryStr;
        }
        //释放前次的查询结果
        if ( !empty($this->PDOStatement) ) $this->free();
        $this->queryTimes++;
        N('db_query',1); // 兼容代码
        // 调试开始
        $this->debug(true);
        $this->PDOStatement = $this->_linkID->prepare($str);
        if(false === $this->PDOStatement){
            $this->error();
            return false;
        }
        foreach ($this->bind as $key => $val) {
            if(is_array($val)){
                $this->PDOStatement->bindValue($key, $val[0], $val[1]);
            }else{
                $this->PDOStatement->bindValue($key, $val);
            }
        }
        $this->bind =   array();
        $result =   $this->PDOStatement->execute();
        // 调试结束
        $this->debug(false);
        if ( false === $result ) {
            $this->error();
            return false;
        } else {
            return $this->getResult();
        }
    }

    /**
     * 执行语句
     * @access public
     * @param string $str  sql指令
     * @param boolean $fetchSql  不执行只是获取SQL
     * @return mixed
     */
    public function execute($str,$fetchSql=false) {
        $this->initConnect(true);
        if ( !$this->_linkID ) return false;
        $this->queryStr = $str;
        if(!empty($this->bind)){
            $that   =   $this;
            $this->queryStr =   strtr($this->queryStr,array_map(function($val) use($that){ return '\''.$that->escapeString($val).'\''; },$this->bind));
        }
        if($fetchSql){
            return $this->queryStr;
        }
        //释放前次的查询结果
        if ( !empty($this->PDOStatement) ) $this->free();
        $this->executeTimes++;
        N('db_write',1); // 兼容代码
        // 记录开始执行时间
        $this->debug(true);
        $this->PDOStatement =   $this->_linkID->prepare($str);
        if(false === $this->PDOStatement) {
            $this->error();
            return false;
        }
        foreach ($this->bind as $key => $val) {
            if(is_array($val)){
                $this->PDOStatement->bindValue($key, $val[0], $val[1]);
            }else{
                $this->PDOStatement->bindValue($key, $val);
            }
        }
        $this->bind =   array();
        $result =   $this->PDOStatement->execute();
        $this->debug(false);
        if ( false === $result) {
            $this->error();
            return false;
        } else {
            $this->numRows = $this->PDOStatement->rowCount();
            if(preg_match("/^\s*(INSERT\s+INTO|REPLACE\s+INTO)\s+/i", $str)) {
                $this->lastInsID = $this->_linkID->lastInsertId();
            }
            return $this->numRows;
        }
    }

    /**
     * 启动事务
     * @access public
     * @return void
     */
    public function startTrans() {
        $this->initConnect(true);
        if ( !$this->_linkID ) return false;
        //数据rollback 支持
        if ($this->transTimes == 0) {
            $this->_linkID->beginTransaction();
        }
        $this->transTimes++;
        return ;
    }

    /**
     * 用于非自动提交状态下面的查询提交
     * @access public
     * @return boolean
     */
    public function commit() {
        if ($this->transTimes > 0) {
            $result = $this->_linkID->commit();
            $this->transTimes = 0;
            if(!$result){
                $this->error();
                return false;
            }
        }
        return true;
    }

    /**
     * 事务回滚
     * @access public
     * @return boolean
     */
    public function rollback() {
        if ($this->transTimes > 0) {
            $result = $this->_linkID->rollback();
            $this->transTimes = 0;
            if(!$result){
                $this->error();
                return false;
            }
        }
        return true;
    }

    /**
     * 获得所有的查询数据
     * @access private
     * @return array
     */
    private function getResult() {
        //返回数据集
        $result =   $this->PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        $this->numRows = count( $result );
        return $result;
    }

    /**
     * 获得查询次数
     * @access public
     * @param boolean $execute 是否包含所有查询
     * @return integer
     */
    public function getQueryTimes($execute=false){
        return $execute?$this->queryTimes+$this->executeTimes:$this->queryTimes;
    }

    /**
     * 获得执行次数
     * @access public
     * @return integer
     */
    public function getExecuteTimes(){
        return $this->executeTimes;
    }

    /**
     * 关闭数据库
     * @access public
     */
    public function close() {
        $this->_linkID = null;
    }

    /**
     * 数据库错误信息
     * 并显示当前的SQL语句
     * @access public
     * @return string
     */
    public function error() {
        if($this->PDOStatement) {
            $error = $this->PDOStatement->errorInfo();
            $this->error = $error[1].':'.$error[2];
        }else{
            $this->error = '';
        }
        if('' != $this->queryStr){
            $this->error .= "\n [ SQL语句 ] : ".$this->queryStr;
        }
        // 记录错误日志
        trace($this->error,'','ERR');
        if($this->config['debug']) {// 开启数据库调试模式
            E($this->error);
        }else{
            return $this->error;
        }
    }

    /**
     * 设置锁机制
     * @access protected
     * @return string
     */
    protected function parseLock($lock=false) {
        return $lock?   ' FOR UPDATE '  :   '';
    }

    /**
     * set分析
     * @access protected
     * @param array $data
     * @return string
     */
    protected function parseSet($data) {
        foreach ($data as $key=>$val){
            if(is_array($val) && 'exp' == $val[0]){
                $set[]  =   $this->parseKey($key).'='.$val[1];
            }elseif(is_null($val)){
                $set[]  =   $this->parseKey($key).'=NULL';
            }elseif(is_scalar($val)) {// 过滤非标量数据
                if(0===strpos($val,':') && in_array($val,array_keys($this->bind)) ){
                    $set[]  =   $this->parseKey($key).'='.$this->escapeString($val);
                }else{
                    $name   =   count($this->bind);
                    $set[]  =   $this->parseKey($key).'=:'.$name;
                    $this->bindParam($name,$val);
                }
            }
        }
        return ' SET '.implode(',',$set);
    }

    /**
     * 参数绑定
     * @access protected
     * @param string $name 绑定参数名
     * @param mixed $value 绑定值
     * @return void
     */
    protected function bindParam($name,$value){
        $this->bind[':'.$name]  =   $value;
    }

    /**
     * 字段名分析
     * @access protected
     * @param string $key
     * @return string
     */
    protected function parseKey(&$key) {
        return $key;
    }
    
    /**
     * value分析
     * @access protected
     * @param mixed $value
     * @return string
     */
    protected function parseValue($value) {
        if(is_string($value)) {
            $value =  strpos($value,':') === 0 && in_array($value,array_keys($this->bind))? $this->escapeString($value) : '\''.$this->escapeString($value).'\'';
        }elseif(isset($value[0]) && is_string($value[0]) && strtolower($value[0]) == 'exp'){
            $value =  $this->escapeString($value[1]);
        }elseif(is_array($value)) {
            $value =  array_map(array($this, 'parseValue'),$value);
        }elseif(is_bool($value)){
            $value =  $value ? '1' : '0';
        }elseif(is_null($value)){
            $value =  'null';
        }
        return $value;
    }

    /**
     * field分析
     * @access protected
     * @param mixed $fields
     * @return string
     */
    protected function parseField($fields) {
        if(is_string($fields) && '' !== $fields) {
            $fields    = explode(',',$fields);
        }
        if(is_array($fields)) {
            // 完善数组方式传字段名的支持
            // 支持 'field1'=>'field2' 这样的字段别名定义
            $array   =  array();
            foreach ($fields as $key=>$field){
                if(!is_numeric($key))
                    $array[] =  $this->parseKey($key).' AS '.$this->parseKey($field);
                else
                    $array[] =  $this->parseKey($field);
            }
            $fieldsStr = implode(',', $array);
        }else{
            $fieldsStr = '*';
        }
        //TODO 如果是查询全部字段，并且是join的方式，那么就把要查的表加个别名，以免字段被覆盖
        return $fieldsStr;
    }

    /**
     * table分析
     * @access protected
     * @param mixed $table
     * @return string
     */
    protected function parseTable($tables) {
        if(is_array($tables)) {// 支持别名定义
            $array   =  array();
            foreach ($tables as $table=>$alias){
                if(!is_numeric($table))
                    $array[] =  $this->parseKey($table).' '.$this->parseKey($alias);
                else
                    $array[] =  $this->parseKey($alias);
            }
            $tables  =  $array;
        }elseif(is_string($tables)){
            $tables  =  explode(',',$tables);
            array_walk($tables, array(&$this, 'parseKey'));
        }
        return implode(',',$tables);
    }

    /**
     * where分析
     * @access protected
     * @param mixed $where
     * @return string
     */
    protected function parseWhere($where) {
        $whereStr = '';
        if(is_string($where)) {
            // 直接使用字符串条件
            $whereStr = $where;
        }else{ // 使用数组表达式
            $operate  = isset($where['_logic'])?strtoupper($where['_logic']):'';
            if(in_array($operate,array('AND','OR','XOR'))){
                // 定义逻辑运算规则 例如 OR XOR AND NOT
                $operate    =   ' '.$operate.' ';
                unset($where['_logic']);
            }else{
                // 默认进行 AND 运算
                $operate    =   ' AND ';
            }
            foreach ($where as $key=>$val){
                if(is_numeric($key)){
                    $key  = '_complex';
                }
                if(0===strpos($key,'_')) {
                    // 解析特殊条件表达式
                    $whereStr   .= $this->parseThinkWhere($key,$val);
                }else{
                    // 查询字段的安全过滤
                    // if(!preg_match('/^[A-Z_\|\&\-.a-z0-9\(\)\,]+$/',trim($key))){
                    //     E(L('_EXPRESS_ERROR_').':'.$key);
                    // }
                    // 多条件支持
                    $multi  = is_array($val) &&  isset($val['_multi']);
                    $key    = trim($key);
                    if(strpos($key,'|')) { // 支持 name|title|nickname 方式定义查询字段
                        $array =  explode('|',$key);
                        $str   =  array();
                        foreach ($array as $m=>$k){
                            $v =  $multi?$val[$m]:$val;
                            $str[]   = $this->parseWhereItem($this->parseKey($k),$v);
                        }
                        $whereStr .= '( '.implode(' OR ',$str).' )';
                    }elseif(strpos($key,'&')){
                        $array =  explode('&',$key);
                        $str   =  array();
                        foreach ($array as $m=>$k){
                            $v =  $multi?$val[$m]:$val;
                            $str[]   = '('.$this->parseWhereItem($this->parseKey($k),$v).')';
                        }
                        $whereStr .= '( '.implode(' AND ',$str).' )';
                    }else{
                        $whereStr .= $this->parseWhereItem($this->parseKey($key),$val);
                    }
                }
                $whereStr .= $operate;
            }
            $whereStr = substr($whereStr,0,-strlen($operate));
        }
        return empty($whereStr)?'':' WHERE '.$whereStr;
    }

    // where子单元分析
    protected function parseWhereItem($key,$val) {
        $whereStr = '';
        if(is_array($val)) {
            if(is_string($val[0])) {
				$exp	=	strtolower($val[0]);
                if(preg_match('/^(eq|neq|gt|egt|lt|elt)$/',$exp)) { // 比较运算
                    $whereStr .= $key.' '.$this->exp[$exp].' '.$this->parseValue($val[1]);
                }elseif(preg_match('/^(notlike|like)$/',$exp)){// 模糊查找
                    if(is_array($val[1])) {
                        $likeLogic  =   isset($val[2])?strtoupper($val[2]):'OR';
                        if(in_array($likeLogic,array('AND','OR','XOR'))){
                            $like       =   array();
                            foreach ($val[1] as $item){
                                $like[] = $key.' '.$this->exp[$exp].' '.$this->parseValue($item);
                            }
                            $whereStr .= '('.implode(' '.$likeLogic.' ',$like).')';                          
                        }
                    }else{
                        $whereStr .= $key.' '.$this->exp[$exp].' '.$this->parseValue($val[1]);
                    }
                }elseif('bind' == $exp ){ // 使用表达式
                    $whereStr .= $key.' = :'.$val[1];
                }elseif('exp' == $exp ){ // 使用表达式
                    $whereStr .= $key.' '.$val[1];
                }elseif(preg_match('/^(notin|not in|in)$/',$exp)){ // IN 运算
                    if(isset($val[2]) && 'exp'==$val[2]) {
                        $whereStr .= $key.' '.$this->exp[$exp].' '.$val[1];
                    }else{
                        if(is_string($val[1])) {
                             $val[1] =  explode(',',$val[1]);
                        }
                        $zone      =   implode(',',$this->parseValue($val[1]));
                        $whereStr .= $key.' '.$this->exp[$exp].' ('.$zone.')';
                    }
                }elseif(preg_match('/^(notbetween|not between|between)$/',$exp)){ // BETWEEN运算
                    $data = is_string($val[1])? explode(',',$val[1]):$val[1];
                    $whereStr .=  $key.' '.$this->exp[$exp].' '.$this->parseValue($data[0]).' AND '.$this->parseValue($data[1]);
                }else{
                    E(L('_EXPRESS_ERROR_').':'.$val[0]);
                }
            }else {
                $count = count($val);
                $rule  = isset($val[$count-1]) ? (is_array($val[$count-1]) ? strtoupper($val[$count-1][0]) : strtoupper($val[$count-1]) ) : '' ; 
                if(in_array($rule,array('AND','OR','XOR'))) {
                    $count  = $count -1;
                }else{
                    $rule   = 'AND';
                }
                for($i=0;$i<$count;$i++) {
                    $data = is_array($val[$i])?$val[$i][1]:$val[$i];
                    if('exp'==strtolower($val[$i][0])) {
                        $whereStr .= $key.' '.$data.' '.$rule.' ';
                    }else{
                        $whereStr .= $this->parseWhereItem($key,$val[$i]).' '.$rule.' ';
                    }
                }
                $whereStr = '( '.substr($whereStr,0,-4).' )';
            }
        }else {
            //对字符串类型字段采用模糊匹配
            $likeFields   =   $this->config['db_like_fields'];
            if($likeFields && preg_match('/^('.$likeFields.')$/i',$key)) {
                $whereStr .= $key.' LIKE '.$this->parseValue('%'.$val.'%');
            }else {
                $whereStr .= $key.' = '.$this->parseValue($val);
            }
        }
        return $whereStr;
    }

    /**
     * 特殊条件分析
     * @access protected
     * @param string $key
     * @param mixed $val
     * @return string
     */
    protected function parseThinkWhere($key,$val) {
        $whereStr   = '';
        switch($key) {
            case '_string':
                // 字符串模式查询条件
                $whereStr = $val;
                break;
            case '_complex':
                // 复合查询条件
                $whereStr = substr($this->parseWhere($val),6);
                break;
            case '_query':
                // 字符串模式查询条件
                parse_str($val,$where);
                if(isset($where['_logic'])) {
                    $op   =  ' '.strtoupper($where['_logic']).' ';
                    unset($where['_logic']);
                }else{
                    $op   =  ' AND ';
                }
                $array   =  array();
                foreach ($where as $field=>$data)
                    $array[] = $this->parseKey($field).' = '.$this->parseValue($data);
                $whereStr   = implode($op,$array);
                break;
        }
        return '( '.$whereStr.' )';
    }

    /**
     * limit分析
     * @access protected
     * @param mixed $lmit
     * @return string
     */
    protected function parseLimit($limit) {
        return !empty($limit)?   ' LIMIT '.$limit.' ':'';
    }

    /**
     * join分析
     * @access protected
     * @param mixed $join
     * @return string
     */
    protected function parseJoin($join) {
        $joinStr = '';
        if(!empty($join)) {
            $joinStr    =   ' '.implode(' ',$join).' ';
        }
        return $joinStr;
    }

    /**
     * order分析
     * @access protected
     * @param mixed $order
     * @return string
     */
    protected function parseOrder($order) {
        if(is_array($order)) {
            $array   =  array();
            foreach ($order as $key=>$val){
                if(is_numeric($key)) {
                    $array[] =  $this->parseKey($val);
                }else{
                    $array[] =  $this->parseKey($key).' '.$val;
                }
            }
            $order   =  implode(',',$array);
        }
        return !empty($order)?  ' ORDER BY '.$order:'';
    }

    /**
     * group分析
     * @access protected
     * @param mixed $group
     * @return string
     */
    protected function parseGroup($group) {
        return !empty($group)? ' GROUP BY '.$group:'';
    }

    /**
     * having分析
     * @access protected
     * @param string $having
     * @return string
     */
    protected function parseHaving($having) {
        return  !empty($having)?   ' HAVING '.$having:'';
    }

    /**
     * comment分析
     * @access protected
     * @param string $comment
     * @return string
     */
    protected function parseComment($comment) {
        return  !empty($comment)?   ' /* '.$comment.' */':'';
    }

    /**
     * distinct分析
     * @access protected
     * @param mixed $distinct
     * @return string
     */
    protected function parseDistinct($distinct) {
        return !empty($distinct)?   ' DISTINCT ' :'';
    }

    /**
     * union分析
     * @access protected
     * @param mixed $union
     * @return string
     */
    protected function parseUnion($union) {
        if(empty($union)) return '';
        if(isset($union['_all'])) {
            $str  =   'UNION ALL ';
            unset($union['_all']);
        }else{
            $str  =   'UNION ';
        }
        foreach ($union as $u){
            $sql[] = $str.(is_array($u)?$this->buildSelectSql($u):$u);
        }
        return implode(' ',$sql);
    }

    /**
     * 参数绑定分析
     * @access protected
     * @param array $bind
     * @return array
     */
    protected function parseBind($bind){
        $this->bind   =   array_merge($this->bind,$bind);
    }

    /**
     * index分析，可在操作链中指定需要强制使用的索引
     * @access protected
     * @param mixed $index
     * @return string
     */
    protected function parseForce($index) {
        if(empty($index)) return '';
        if(is_array($index)) $index = join(",", $index);
        return sprintf(" FORCE INDEX ( %s ) ", $index);
    }

    /**
     * ON DUPLICATE KEY UPDATE 分析
     * @access protected
     * @param mixed $duplicate 
     * @return string
     */
    protected function parseDuplicate($duplicate){
        return '';
    }

    /**
     * 插入记录
     * @access public
     * @param mixed $data 数据
     * @param array $options 参数表达式
     * @param boolean $replace 是否replace
     * @return false | integer
     */
    public function insert($data,$options=array(),$replace=false) {
        $values  =  $fields    = array();
        $this->model  =   $options['model'];
        $this->parseBind(!empty($options['bind'])?$options['bind']:array());
        foreach ($data as $key=>$val){
            if(is_array($val) && 'exp' == $val[0]){
                $fields[]   =  $this->parseKey($key);
                $values[]   =  $val[1];
            }elseif(is_null($val)){
                $fields[]   =   $this->parseKey($key);
                $values[]   =   'NULL';
            }elseif(is_scalar($val)) { // 过滤非标量数据
                $fields[]   =   $this->parseKey($key);
                if(0===strpos($val,':') && in_array($val,array_keys($this->bind))){
                    $values[]   =   $this->parseValue($val);
                }else{
                    $name       =   count($this->bind);
                    $values[]   =   ':'.$name;
                    $this->bindParam($name,$val);
                }
            }
        }
        // 兼容数字传入方式
        $replace= (is_numeric($replace) && $replace>0)?true:$replace;
        $sql    = (true===$replace?'REPLACE':'INSERT').' INTO '.$this->parseTable($options['table']).' ('.implode(',', $fields).') VALUES ('.implode(',', $values).')'.$this->parseDuplicate($replace);
        $sql    .= $this->parseComment(!empty($options['comment'])?$options['comment']:'');
        return $this->execute($sql,!empty($options['fetch_cql']) ? true : false):M
    }

*  ` /*h
0    * ���量插e��许录M
     * @access publia
     * @p!ram mixed $dateSeT 数���集
    "j @param array $options 参慰表达式
     * @param boolean $replace 是否replacd
     * PRepurn false | inteedr
     */
    public fuNcvimn insertEll($dataWet,$optigj{=arra}(1,$ruplace=false) {M
        $values 0=  array();
        $this->mO`el  =   $options{'model'U;
       "if(!isarray($dataSet[0])) return false;
        $thIs->parSeBind(!empty($options['bine']i?$gptions['"int']:qrray());
0       $fields =   arr`y_map(ar2ay($this,'parseKey'),arrayOkeys($dataSgt[0]));
    `   foreach ($dataSet as $data){
            $value   =  array();
            foreach ($dipa as $kei=>$va|){
          "     if*is]asr�y($val) f& 'exp' == $val[0]){J                   �$vAlua[]`  =    $val[1]+
     ("   `     }elseIf(is_null($val)){
    0               $value[]   =   'NULL';
                }elseif(is_scalar($va,))s
                    �f(0===strpos( val,':')(&& in_arsay($val,arb�y_keys($this->bi.$))){
    $                0  -value[]   =   -this->parseValue($val);
        0    �      }ehse{
 ! `                    $name   (   =   coufv($th!s->bind);
                        $value[] " =   ':'.$name;
   $ `                  $thism>bindParam($name,$vAe):
                    }        $       }
            }
      �(    $values[]  0 =!'�ELECT('.implode(',', $valua);
    0   }
        $sq|   =( 'INSERT InTO '.$this->parseTable($o@tignC['table'])*' ('.implode(',', $fiexdS).'( '.implode(' UNION"AlL ',$values);
(       $sql   .= $this->parseComm�nt(!empty($options['commenp'])?$opti�.s['comMeft']:'�);
        ret5rn $this->extcute($sql,!ei�Ty($kptions['fatch_sql']9 ? true : galse);
    }

    /**
    0* ယ过Select方式插入记录
     *"@access public
0    *  p`rqM string $fields 要插入的数据表字段��
    �+D`%ral(sTriNg $table 要��內����Ų据表名
     * @parai crra9 $oqtion  查询数据参数
     *(@return false | integer
   ! */
    tublic f}ncvion selectInsgrt( figl`r,$ta�ld( optiojs=array()) [
      $$t(i{->model  =   ,options['moDe,'];
        $this->pirseBiod( �mptY($options['bind'])?$optionS[#bind']:array());
     "  if(Is_qtring($fields�)   $fields    = explode(','�$fields);
      ! !Rray_walk$fielDs, aszay(4this, 'parseK�Y'));	J     �  $sqj   =    'YNSERT KN\O '&$thm2m>parseTarle($tablw).' h'.impmode(',', $fields).') ';*  $     $spl   .= $this->buileSelectSqm($optimns);
!       return $this->execute($sql,!empty(dop5iOnsZ'fatch_sql']) ? true :�false);
    }

    /
*
   � *"更新Ȯ�录
     * @Aca$ss`publycM
     * @param mixed $dat` 数据
     * @param array $options 表达式
     * @rittrn falsa | Ynteger
     */
    public function epdate($datq,$oqtions) {
        $this->model  =  0$optionsS'model'];
 $      $t(as->parseBind(!empty($options'bind�])?$options['bio`'M:array());
        $table  =   $this->parseTable($options['table']);	
      " $sql   = 'UPDATE ' . $table . $this->par�eSet($dcta);
  (     if(strpos($table$',')){// 多表更新攫持JOHN操作
            $sql .= $this->parseJoin(!empty($options['jgiN'])?$options['join']:'59;*        }
        $sql .= $thir->parseWhere(!empty($options[gwh%re'])?,options['where'M:'');
        if(!strps($tarle,',')){
            //  单表更新搯持order和lmit
    (       $sql   .=  $this->parseOrder(!emqty($optionsZ'order'])? optionw['o0�er']:'')
     "    0    (.$4hiq->pqrseLimit(!empty)$oxuions['limit'])?$oPtions['lima�']:'');
        �
        $sql .= � $t(is->parseComment(!empty($o0tiofs['comment'])?$options['coiment'Y:'');
        return $thi�-6exdcute($sq�l!empty($o�tio�s['fEtch_sql'}) ? true ; false){
    }

  @ /**
     *"删除记录
     * @access public
 ( 0 * @param aRray $opt)ons 衩辞嬏
     * @return nalse | integer
     */
    pubLic function delete($options=array()) {
        $this->iodel  =$  $N@tions['model'];
  `     $this->paRceBind(!empty($options[&bijd']+?$options['rind']:array()y;
$       $table  =   $this->parseTable($ptions['table'])?
     #  $sql    =   /DELETE FROM '.$table;
�     $ if)rtrpks$teble,',')){/? Ť�表�Ƞ除支持USING和JOIN擅���
            if(!empty($options['using'\)){
                $sql .= ' USING '.$this-~parsgTable($options['using']).' ';
            }
    �     ( $sql .= 4tH)s->parseJoin(!empt9($options['join')?&options['join']z'');
 �      }
        %sql .= $4hiw->parseWhere(!empty($options['where'])?$options['hmre']:'');-
        if(!strpos($tabme',')){
            //$单表ሠ�0支持order咬limi�
            $sql .= $thiS->parsE_bder(!empty(dgptions['order'])?$optionr['grder']:'')
            .�thir->ParseLimmt(!emrty$option�['lim)p'])?$options['limmt']:'');
        }
      ! $sql .?   $this->parsdComme.t(!em0tx(doptions[gcomme.t'])?$options['comment]z'');
   �    return $thiw->exe#ute($sq|,!eMpty8$options['fatch_sql']) ? true : false)
    }

    /
*
     * 查找覰��
     * @access public
     * @param ar�ay $options 表达式
     * @return m)xed
  (  */
    `ublic functioN relect($options=array(i) {
   0 �  $this->model  =   $options['Model'];
        $this->parseBind(!empty($optioNs['bind'U)?$opdignw['bind']:ar2ay());
        $sql    = $this->buildSelectSql($options);-
        $result  $= $this->query($sql,!empty(dkptions[#fetch_sql']) ? truu :`fslse);
   $    return $res�|t;
    }

(   /**
     * 生�Ȑ��询SQL
     * @a�cgss!pub�ic
     * @param array $ox|kOn{ ȡ�达式
     * Dret}zn strijg
     */
    public fulction buildSele#tSql($options=array(�) {
        if(isse�($options['pa'e'])) {
            /o ⠹据页数计算limit
      "     list($page,$listVows� h = " $options['page'];  !         $qaoe    =  $page60 ? $page 2 1;      �     $ListRows=  ,,	stPows>0 ? $listRows : (is_numeri#($options['limit'](?$opt�onr['limit']:20);
            $offsgu  =  $listRos*($page-1);
            $options['limit'\ =  &offset.','.$listPows;
     )! }
        $sql  = $ this-�p)pS%Qql($th)s)>select�ql,$gptionr)+
   "    return $sql;M
    }-

    /**
�   :!��⍢�PL语句中ࡨ达���
     * Daccess public
     * @param�array $options 表达徏
     * @return string
     */
    publ�c function parseSql($sql,$optio~s=array()){
        $sql   = str_replace(
$       $ $ array('%TABLE%','%DISDINA\%','eBIELD%','%JOIN$','%WhERE%',#%GRGTP$','%HAVING%','$ORDUR%','%LIMIT%#,'-UNION'',&%LOCK%','%COMMENT%&,'%FORCE%'),
        (   array(
               0$this->parseTable($options['tab|e']	$J                $this->parseDisuinct,isqut($options['distinctg])?$opvions['distinct']false)-
   � `          $this>parseField(!empty($opteons['field'])?$mptions['field]:'*'),
 0              $this->parseJoin(!empty($kptions['join'])?$options['joio']:''),
                $this->parseWhere(!e}pty($options['vher�'])?$options['where']:'')
 0        $     $this->parsdCroup8!ampty($options['group'])?$optiOns['group']:''),
$               $this->parseHaviNg(!empty($options['having'])$options['having'Y:''),
           $    $this->parsaOsder(!emp|y($eptions['�rder']i?$optiOns['order']:''),
                $this%>parseLimit(!empty($oPtions[7limit'])?$options['limit']:''+,
    $          �$thir-~parslUnion(!empty($op�ioos_'union'])$gptions[&union'}:''!.
�           �   $this->pqrseDock(isset(�options['lock')?$options�&nock']:false),
    "           $thic->parseComment(!empty($optigns['comment'])?$options['comment']*''),
$        �  !   $thks->par3eForce(!em0ty($options['fkrge'])?$optioNs['force']:''	
            ),$sql);
        r%turn  sql;    }

    /**
   $ * 获取最近一次查询的sql诩句 
     * @param$stsing $model  樁型名
     * @access publIc
(    * @return string
(    */
    rublic`functioj getLastSql($model='') {
        return $model?$dhis->modelSql[%iodel]:$�his->quezyQtr;�
    �

    /**
     * 获取��近插入的ID
     * @acceqs public
     * @return string*     */
    public funbtiongetLAstInsID() {
        r�turn $vhis-lastI.sID;
`  (}

    /
*
    `*$膷取最迓的错���信扯
 $   * @access public
     * @retur. St�ing
 0 ( :/
    public fqn#tion getError(- {
        return $thic-<error;
    ]

    /** !�  * SQL指令安奨过滤
     * @access public
     * @param`strifg $str` SQL字符串
     * @return strijg
     */
    publmk function esbapeSt�ing($s|p) �
       `return Addslaqhes($str);
    }

    /
*
 !   * 讶置当前操作校型
     * @!ccess ptblic     * @param string $model  模型名
( (  * @return vgid
     */
    puclic function setModel($model){
   "    $this->model =  $model;
    }	

    /**
     * 数��纓鰃试 记录当቉SPL
!"   * @access protected
 "   * @p`Ram(boolean $start  调试开始樇讐 tr}e 开始 fa�s% 结束
2    */
    protected funadion debug($start) {
        if($this,~config['debug']) {// 伀启数据库调试檡弇
   (   0(   ifh$qtart) {
"               G('qu%ryStartTime');
""       `  }elqe{
                $thys->modelSql[$this->mode|]   = $$this->queryStr;
                //$this->model  =   'think_';
        !$      �/ 记录操作结柟时间
                G('queryEndTime');J�               trac�($this-:quezyStr.'([ RunTime:'.G*'queryStartTIme','qu�ryEndVime').'3 ]/,'&('WQL');
   �        }
 �      }
    y

    /**
  $  * ň�始��数据庑h��接
 !   *�@access protecued     "$@papam boolean $master 主服务�(
     * Hreturn void
     */
    protected function initConnek($masteb=vrue) {
       "i&(!ampty($thi{->�onfig['depnoy']))
`           // 采���分Ÿ�弟�0���库
"           $txis->_linkID = $this->multiConnect($master-;
        else
       $"   // 默认单数据库
  � $       if$( !$this->_linkAD ) $this->_linkID = $this->connect();J   !}

    /**
�    * 连接分布式服䊡器
    * @access protected
     * @para} foolEan $master �;服���器     *"@peturn void�
     */
    protected funcuion multiConnect($master=false) {
        // 刎布式数䍮岓酁置解䞐
(       $_config['usevnamu']    =   explode)'-',$thms->congig['username'])�
    "   $_config['password']    =   explode(',',$this->co~f�g['pissword'])+
        ,_confi/['hostname']    =   extlode(',7�$this->config['hostname']);
    0   $_config['hostport']    =  �explode(',',$this->config['hortport']);
        $_config['d!taBase']    =   explode(',',$this->config['databasa']);
�`      $_condig[�d[f']0        �!  explode(',',$this->c/n�ig['dsn']);
   "    $_config['ghirset/]     =   exPlode(#,',$this->config['chdrset']);

        $m !   =   floor(mt_rand(2,$this->connig['master_num']-!));
        // 数据库꯻写昭带分离
�       if($thks->gondig['rw�separate']){$    $   (  // 丛从弋采用诺写分离
  a0        if($masterh
  `       `     // 主服튡器写健
                $r  =   $m;
  !         else{
                if(is_numdric($thi{->config['s|Ave_no'])) {?/ 指�>�服傡器读
 "       `          $r - $thks->config['slave_no'];
   �     "& (   }elsey
             (     // ��操作连接从服务器�
                    $r = gloor)mt_rand($this->config['master_numg],coun4(%_confi'['hostname'])-1));   // 每次随�ܺ连接的数据庳
   `    d       }
            }
 "      }else{
           !// 读熙操作不区分服加흈
     "     `$r"= floop(mt_rand(0,cotnt8$_config['hostname'Y)-1));   // 殏次���机连接暄数��媓
        ]
        
     �0 if($m != $r ){
            $dB_master  =   a2ray(
                'username'  =>  issat$_config['username'][$m\($_c�nf)g['usernamm'][$m]:$_conbic['u3ername'][0],
       (        &pAs�word'  => �isset($_confac['pa�sword'][$m])?$_config['password'][$m]:$_config['pawsword'][0],
                '(ostname'  =>  isset($_config['hostname'][$m])?$_config�'hostname'M[$m]:$_confiw['hostname'][8M,
                'hostport'  =>  isset($_cnfig['hostport%][$m])?$^confi'['howtpost'][$e]:$_config['hostport']{0],
                'databasg'  =>  isset($_config['database'][$m])?$_config['database'][$m]:$_config['database'][0],*   $     `     'ds.'       }>  isset($_config['dsn']K$m])?�_config['dsn'][$m]:$_con&ic[%`qn'][0],
           �    'charseT'(  5>  issev(4_cOnfig[%charset'][$m])?$_conf�e['cxarsed'][$m]:$_config[chabset'[1M,            );
0       }
        $fb_config = array(
     0      'username'  =>  isset($_config{'username'][$r]+?$_config['username'][$r]:$_config['user.ame'][2],M            gparsword'  =>  isset($Gconf�g[7`asswOrd'][$r])?$_config['password%][$r];$^config['password'M[0],
            'hostname'  =>  isset(,_config['hostname'][$r�)?$_config['hostname'][$r_:$_cknfig['hostname'][0],
            'hostpozt' (=>  isset!$_confie['h�stplrt'][$r])?$_config['hosdPort'][$rM:$_conFig['ho3tport'][0],J            'data"ase'  =>  isset($_condig['datarase'][$r])?$_config['datab!se'][$r]:$_config['Databasg'][0],
       $ "  'dsn'       =>  isset($_config['dsn'][$rY)?$_config['fsn'][$r]:$[ckLfig['dsn'][0],
            'chars%t'   5>  i3set,$_config[/c(arset'][$r])?$_cmnfig['charsat'][$r]:$_config['clazset'][2]$
       ();
        return $this,>connect($db_cnnfig,$r,$r$== $m ? false : $db_master);
  � }

 0 /**
  ($ + 析构斱法
     * @access �ublic
    "*/
    pmb,ic funbt�on __destruct() {
        // 释放查询
        if ($this->DOStAdement){J           �$this->free();
 !$     }        // �3闭连Ɗ�
     !  this->close();    }
}�