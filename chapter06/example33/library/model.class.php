<?php

class model {

    protected $db;              //数据库操作类实例
    protected $tableName;       //待操作的表名
    protected $fields;          //字段数组（查询用）
    protected $data = array();  //数据数组（添加、修改用）

    public function __construct($tableName) {
        //实例化数据库
        $this->db = MySQLDB::getInstance($GLOBALS['dbConfig']);
        //获取表名
        $this->tableName = $tableName;
    }

    //查询数据
    //如果没有指定$this->fields，则查询所有字段
    public function select() {
        //拼接SQL语句
        if (empty($this->fields)) {
            $sql = "select * from $this->tableName";
        } else {
            $fields = $this->parseFields();
            $sql = "select $fields from $this->tableName";
            //清除本次的字段
            $this->fields = null;
        }
        return $this->db->fetchAll($sql);
    }

    //解析字段（查询用）
    //将 $this->fields 转换为逗号拼接的SQL字段部分
    private function parseFields() {
        if (is_string($this->fields)) {
            $this->fields = explode(',', $this->fields);
        }
        foreach ($this->fields as $k => $v) {
            $this->fields[$k] = "`$v`";
        }
        return implode(',', $this->fields);
    }

    //指定待查询的字段
    public function field($fields) {
        $this->fields = $fields;
        return $this;
    }

    //获取模型中的数据
    public function __get($name) {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    //设置模型中的数据
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    //添加数据
    //添加模型本身的数据
    //如果传递$data参数，则覆盖模型本身的数据
	public function add($data = array()) {
		//合并数组
		$this->data = array_merge($this->data,$data);
		//解析 $this->data 中的数据
		$data = $this->parseData();
		//清除模型中的数据
		$this->data = array();
		//拼接SQL
		$sql = "insert into `{$this->tableName}` ({$data['field']}) values({$data['value']})";
		//返回执行结果
		if ($this->db->query($sql)) {
			return $this->db->lastInsertId();
		}
		return false;
	}

    //解析数据（添加用）
    private function parseData() {
		$field = $value = array();
		foreach ($this->data as $k => $v) {
			$field[] = "`$k`";
			$value[] = "'" . $this->db->escapeString($v) . "'";
		}
		return array(
			'field' => implode(',', $field),
			'value' => implode(',', $value),
		);
    }

}
