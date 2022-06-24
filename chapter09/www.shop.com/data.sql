
-- 管理员表
create table `shop_admin` (
  `id` tinyint unsigned primary key auto_increment,
  `username` varchar(10) not null unique comment '用户名',
  `password` char(32) not null comment '密码',
  `salt` char(6) not null comment '密钥'
)charset=utf8;

-- 管理员初始数据
insert into `shop_admin` values(1,'admin',md5(concat(md5('123456'),'ItcAst')),'ItcAst');

-- 商品分类
create table `shop_category` (
  `id` int unsigned primary key auto_increment,
  `name` varchar(20) not null comment '分类名',
  `pid` int unsigned not null comment '父分类ID'
)charset=utf8;

-- 商品表
create table `shop_goods` (
  `id` int unsigned primary key auto_increment,
  `category_id` int unsigned not null comment '所属分类ID',
  `sn` varchar(10) not null comment '商品编号',
  `name` varchar(40) not null comment '商品名',
  `price` decimal(10,2) not null comment '价格',
  `stock` int unsigned not null comment '库存量',
  `thumb` varchar(150) not null comment '预览图',
  `on_sale` enum('yes','no') not null comment '是否上架',
  `recommend` enum('yes','no') not null comment '是否推荐',
  `add_time` timestamp not null default current_timestamp comment '添加时间',
  `desc` text not null comment '商品描述',
  `recycle` enum('yes','no') not null comment '是否删除'
)charset=utf8;

-- 用户表
create table `shop_user` (
  `id` int unsigned primary key auto_increment,
  `username` varchar(20) not null unique comment '用户名',
  `password` char(32) not null comment '登录密码',
  `salt` char(6) not null comment '密钥',
  `reg_time` timestamp not null default current_timestamp comment '注册时间',
  `phone` char(11) not null default '' comment '联系电话',
  `email` varchar(30) not null default '' comment '邮箱',
  `consignee` varchar(20) not null default '' comment '收件人',
  `address` varchar(255) not null default '' comment '收货地址'
)charset=utf8;

-- 购物车表
create table `shop_shopcart` (
  `id` int unsigned primary key auto_increment,
  `user_id` int unsigned not null comment '购买者ID',
  `add_time` timestamp not null default current_timestamp comment '加入购物车时间',
  `goods_id` int unsigned not null comment '购买商品ID',
  `num` tinyint unsigned not null comment '购买商品数量'
)charset=utf8;

-- 订单表
create table `shop_order`(
  `id` int unsigned primary key auto_increment,
  `user_id` int unsigned not null comment '购买者用户ID',
  `goods` text not null comment '商品信息',
  `address` text not null comment '收件人信息',
  `price` decimal(10,2) not null comment '订单价格',
  `add_time` timestamp not null default current_timestamp comment '下单时间',
  `cancel` enum('yes','no') not null comment '是否取消',
  `payment` enum('yes','no') not null comment '是否支付'
)charset=utf8 engine=innodb;
