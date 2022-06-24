

-- 管理员表
create table `stu_admin` (
  `aid` int unsigned primary key  auto_increment comment '管理员id',
  `aname` varchar(20) not null comment '管理员登录名',
  `apwd` char(32) not null comment '管理员密码'
)charset=utf8;

-- 管理员信息
insert into `stu_admin` values(null,'admin',md5('123456'));

-- 专业表
create table `stu_major` (
  `major_id` int unsigned primary key auto_increment comment '专业id',
  `major_name` varchar(20) not null comment '专业名'
) charset=utf8;

-- 测试数据
insert into `stu_major` values (1, '应用物理学');
insert into `stu_major` values (2, '电子信息科学与技术');

-- 班级表
create table `stu_class` (
  `class_id` int unsigned primary key auto_increment comment '班级id',
  `class_name` varchar(8) not null comment '班级名',
  `major_id` int unsigned not null comment '专业id'
) charset=utf8;

-- 测试数据
insert into `stu_class` values (1, '20150101', 1);
insert into `stu_class` values (2, '20150102', 1);

-- 学生表
create table `stu_student` (
  `student_id` int unsigned primary key auto_increment,
  `student_number` int unsigned unique key,
  `student_name` varchar(20) not null,
  `student_birthday` date not null,
  `student_gender` enum('女','男') not null default '男',
  `class_id` int unsigned not null
) charset=utf8;

-- 测试数据

insert into `stu_student` values 
(1,'2015010101', '张三', '1990-7-18', '男',1),
(2,'2015010102', '李四', '1993-5-4', '女',1),
(3,'2015010201', '王五', '1990-11-20', '男',2);

