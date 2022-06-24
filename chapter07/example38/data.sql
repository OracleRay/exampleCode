
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
    `cid` int unsigned not null comment '文章所属分类'
)charset=utf8;
