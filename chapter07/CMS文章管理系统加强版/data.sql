
-- 创建保存文章分类信息的数据表
create table `cms_category`(
    `id` int unsigned primary key auto_increment,
    `name` varchar(255) not null comment '分类名称',
    `sort` int default 0 not null comment '排序'
)charset=utf8;


-- 创建保存文章信息的数据表
create table `cms_article`(
    `id` int unsigned primary key auto_increment,
    `title` varchar(255) not null comment '文章标题',
    `content` text not null comment '文章内容',
    `author` varchar(255) not null comment '作者',
    `addtime` timestamp default current_timestamp not null comment '添加时间',
    `cid` int unsigned not null comment '文章所属分类',
    `hits` int unsigned not null default 0
)charset=utf8;

-- 用户表
create table `cms_user` (
  `id` int unsigned primary key auto_increment,
  `username` varchar(10) not null unique,
  `password` char(32) not null,
  `salt` char(32) not null,
  `email` varchar(40) not null
)charset=utf8;


-- 用户信息表
create table `cms_userinfo`(
    `id` int unsigned primary key auto_increment,
    `nickname` varchar(10) not null,
    `gender` enum('男','女') not null,
    `email` varchar(40) not null,
    `qq` varchar(20) not null,
    `url` varchar(200) not null,
    `city` varchar(10) not null,
    `skill` text not null,
    `description` text not null
)charset=utf8;