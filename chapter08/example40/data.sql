
-- 管理员表
create table `stu_admin` (
  `aid` int unsigned primary key  auto_increment comment '管理员id',
  `aname` varchar(20) not null comment '管理员登录名',
  `apwd` char(32) not null comment '管理员密码'
)charset=utf8;

-- 管理员信息
insert into `stu_admin` values(null,'admin',md5('123456'));
