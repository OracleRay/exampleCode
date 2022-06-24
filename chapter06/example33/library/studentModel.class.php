<?php
final class studentModel extends model{
    //该方法会根据传递的id获取相关数据
    public function getById($id){
        //编写根据id获取数据的SQL语句
        $sql = "select * from $this->tableName where id = $id";
        //执行数据库操作类的fetchRow获取数据
        if($data = $this->db->fetchRow($sql)){
            //方法执行成功，返回数据
            return $data;
        }
        //方法执行失败，返回false
        return false;
    }
}