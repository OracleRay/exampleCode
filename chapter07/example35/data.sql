
-- 创建保存书籍信息的数据表
create table `books`(
	`book_id` int unsigned primary key auto_increment,
	`book_name` varchar(50) not null comment '书籍名称',
	`book_author` varchar(50)  comment '作者',
	`pub_time` varchar(50) comment '出版时间'
)charset=utf8;

insert into `books` values
(1,'PHP程序设计基础教程','传智播客高教产品研发部','2014/08'),
(2,'PHP程序设计高级教程','传智播客高教产品研发部','2015/01'),
(3,'C语言开发入门入门教程','传智播客高教产品研发部','2014/09'),
(4,'Java基础入门','传智播客高教产品研发部','2014/05');