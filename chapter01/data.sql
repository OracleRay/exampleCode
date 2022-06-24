
-- 查看数据库中现有的数据库
show databases;

-- 为MySQL指定字符集，避免中文乱码问题
set names gbk;

-- 创建itcast数据库
create database `itcast`;

-- 选择itcast数据库
use `itcast`;

-- 查看所有表
show tables;

-- 删除itcast数据库
drop database `itcast`;

-- 创建student表，保存学生信息
create table `student` (
    `id` int unsigned primary key auto_increment,
    `name` varchar(4) not null comment '姓名',
    `gender` enum('男','女') default '男' not null comment '性别',
    `birthday` date not null comment '出生日期'
)charset=utf8;

-- 查看表结构
desc `student`;

-- 查看建表SQL
show create table `student`\G

-- 删除student表
drop table `student`;

-- 为student表中添加数据
insert into `student` (`name`, `gender`, `birthday`) values
  ('张三', '男', '1994-01-20'),
  ('李四', '男', '1993-10-15'),
  ('王五', '女', '1993-12-02');

-- 将student表中所有的记录查询出来
select * from `student`;

-- 查询出所有性别为“男”的学生
select * from `student` where `gender` = '男';

-- 查询出学号为2的学生的姓名和性别
select `name`,`gender` from `student` where `id` = 2;

-- 查询出所有姓氏为“张”的男学生
select * from `student` where `gender` = '男' and `name` like '张%';

-- 将所有男学生按照出生日期升序排列
select * from `student` where `gender` = '男' order by `birthday` asc;

-- 将ID为2的学生（张三）的名字修改为“赵六”，将性别（男）修改为“女”
update `student` set `name` = '赵六', `gender` = '女' where `id` = 2;

-- 将ID为2的学生记录删除
delete from `student` where `id` = 2;

-- 清空student表中所有的记录
truncate `student`;
