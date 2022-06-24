-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-10-23 02:28:43
-- 服务器版本： 5.7.12-log
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itcast_shop`
--

-- --------------------------------------------------------

--
-- 表的结构 `shop_admin`
--

CREATE TABLE `shop_admin` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `username` varchar(10) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `salt` char(6) NOT NULL COMMENT '密钥'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `shop_admin`
--

INSERT INTO `shop_admin` (`id`, `username`, `password`, `salt`) VALUES
(1, 'admin', '56802b0058be8a26bd633d5f46760dfb', 'ItcAst');

-- --------------------------------------------------------

--
-- 表的结构 `shop_category`
--

CREATE TABLE `shop_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL COMMENT '分类名',
  `pid` int(10) UNSIGNED NOT NULL COMMENT '父分类ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `shop_category`
--

INSERT INTO `shop_category` (`id`, `name`, `pid`) VALUES
(1, '图书', 0),
(2, '音像', 1),
(3, 'IT类', 1),
(4, '少儿', 1),
(5, '管理', 1),
(6, '生活', 1),
(7, '艺术', 1),
(8, '音乐', 2),
(9, '影视', 2),
(10, '游戏', 2),
(11, 'PHP书籍', 3),
(12, 'JAVA书籍', 3),
(13, 'MySQL书籍', 3),
(14, 'C语言书籍', 3),
(15, '网页书籍', 3),
(16, '少儿英语', 4),
(17, '少儿文学', 4),
(18, '经济', 5),
(19, '金融', 5),
(20, '投资', 5),
(21, '旅游', 6),
(22, '运动', 6),
(23, '摄影', 7),
(24, '设计', 7),
(25, '绘画', 7),
(26, '家用电器', 0),
(27, '手机', 0),
(28, '服装', 0),
(29, '美妆个护', 0),
(30, '电脑、办公', 0),
(31, '运动户外', 0),
(32, '家具、厨具', 0),
(33, '电视机', 26),
(34, '空调', 26),
(35, '洗衣机', 26),
(36, '曲面电视', 33),
(37, '超薄电视', 33),
(38, '壁挂式空调', 34),
(39, '柜式空调', 34),
(40, '中央空调', 34),
(41, '滚筒洗衣机', 35),
(42, '洗烘一体机', 35),
(43, '波轮洗衣机', 35),
(44, '迷你洗衣机', 35);

-- --------------------------------------------------------

--
-- 表的结构 `shop_goods`
--

CREATE TABLE `shop_goods` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL COMMENT '所属分类ID',
  `sn` varchar(10) NOT NULL COMMENT '商品编号',
  `name` varchar(40) NOT NULL COMMENT '商品名',
  `price` decimal(10,2) NOT NULL COMMENT '价格',
  `stock` int(10) UNSIGNED NOT NULL COMMENT '库存量',
  `thumb` varchar(150) NOT NULL COMMENT '预览图',
  `on_sale` enum('yes','no') NOT NULL COMMENT '是否上架',
  `recommend` enum('yes','no') NOT NULL COMMENT '是否推荐',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `desc` text NOT NULL COMMENT '商品描述',
  `recycle` enum('yes','no') NOT NULL COMMENT '是否删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `shop_goods`
--

INSERT INTO `shop_goods` (`id`, `category_id`, `sn`, `name`, `price`, `stock`, `thumb`, `on_sale`, `recommend`, `add_time`, `desc`, `recycle`) VALUES
(1, 3, '0001', 'Objective-C入门教程', '34.00', 1000, '2017-10/23/59ed4e1098a87.png', 'yes', 'no', '2017-10-23 02:04:00', '<p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\"><span style=\"font-weight:bolder;\">“</span>Objective-C是一种面向对象编程语言，目前是用于iOS设备开发的主流语言。本书作为iOS开发的入门教材，站在初学者的角度，以形象的比喻、实用的案例，通俗易懂的语言，详细讲解了Objective-C语言。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">全书分为9章，前8章主要讲解了Objective-C的基本知识，包括开发工具的安装使用、面向对象思想、分类、foundation框架、文件操作，以及在程序中，如何调试程序、处理错误等。第9章则带领大家开发了第一个iOS程序，帮助大家增加学习Objective-C语言的兴趣和自信心。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本教材附有配套视频、源代码、习题、教学课件等资源，而且为了帮助初学者更好地学习本教材中的内容，还提供了在线答疑，希望得到更多读者的关注。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书既可作为高等院校本、专科计算机相关的程序设计课程教材，也可作为iOS技术基础的培训教材，是一本适合广大计算机编程初学者的入门级教材。<span style=\"font-weight:bolder;\">”</span></p><p><br /></p>', 'no'),
(2, 11, '0002', 'PHP网站开发实例教程', '45.00', 1000, '2017-10/23/59ed505fbd3bb.png', 'yes', 'yes', '2017-10-23 02:13:51', '<p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">PHP是一种运行于服务器端并完全跨平台的嵌入式脚本编程语言，是目前开发各类Web应用的主流语言之一。《PHP网站开发实例教程》就是面向初学者推出的一本案例驱动式教材，通过丰富实用的案例，全面讲解了PHP网站的开发技术。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">全书共9章，第1章讲解PHP开发环境搭建，通过部署网站的方式，让初学者了解基于PHP和MySQL的成熟开源项目的运行过程，第2章以趣味的案例学习PHP语法基础，第3章通过开发企业员工管理系统来学习PHP的数据库操作，第4通过用户登录注册、表单验证、保存用户资料、保存浏览历史、保存登录状态等案例学习Web表单与会话，第5章通过验证码、头像上传、缩略图、图片水印、文件管理器、在线网盘等案例来学习文件与图像技术，然后第6～8章通过常用类库封装、文章管理系统、学生管理系统等实用案例学习面向对象编程、PDO和ThinkPHP框架，最后一章通过开发实战项目——电子商城网站，综合运用本书所学的知识，让读者迅速积累项目开发经验。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书附有配套视频、源代码、习题、教学课件等资源，而且为了帮助初学者更好地学习本书讲解的内容，还提供了在线答疑，希望得到更多读者的关注。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书适合作为高等院校计算机相关专业程序设计或者Web项目开发的教材，也可作为PHP技术入门的培训教材，是一本适合广大计算机编程爱好者的优秀读物。</p><p><br /></p>', 'no'),
(3, 13, '0003', 'MySQL数据库入门', '40.00', 1000, '2017-10/23/59ed50f07f88a.png', 'yes', 'yes', '2017-10-23 02:16:16', '<p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">MySQL数据库是以“客户端/服务器”模式实现的，是一个多用户、多线程的小型数据库服务器。MySQL因为其稳定、可靠、快速、管理方便以及支持众多系统平台的特点，成为世界范围内最流行的开源数据库之一。《MySQL》就是面向数据库初学者特地推出的一本进阶学习的入门教材，本教材站在初学者的角度，以形象的比喻、丰富的图解、实用的案例、通俗易懂的语言详细讲解了MySQL开发和管理技术。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">全书共8章，第1-5章主要讲解了MySQL中的基础操作，包括数据库基础知识、MySQL的安装配置及使用、数据库和表的基本操作、单表中数据的增删改查操作以及多表中数据的增删改查操作。第6-8章则围绕数据库开发的一些高级知识展开讲解，包括事务与存储过程、视图、数据的备份与还原以及数据库的用户和权限管理。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本教材附有配套视频、源代码、习题、教学课件等资源，而且为了帮助初学者更好地学习本教材中的内容，还提供了在线答疑，希望得到更多读者的关注。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本教材既可作为高等院校本、专科计算机相关专业的数据库开发与管理教材，也可作为数据库开发基础的培训教材，是一本适合广大计算机编程爱好者的优秀读物。</p><p><br /></p>', 'no'),
(4, 12, '0004', 'Java基础入门', '45.00', 1000, '2017-10/23/59ed51734fccb.png', 'yes', 'yes', '2017-10-23 02:18:27', '<p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书从初学者的角度，以形象的比喻、丰富的图解、实用的案例、通俗易懂的语言详细讲解了Java开发中重点用到的多种技术。本书共11章，第1章详细讲解了Java开发环境的搭建及其Java的运行机制，第2章详细讲解了Java的基本语法，在讲解语法过程中，通过演示错误的案例加深初学者的印象。第3章和第4章，透彻讲解了面向对象的思想，采用典型详实的例子，通俗易懂的语言阐述面向对象中的抽象概念。在以后的多线程、常用API、集合、IO、GUI、网络编程章节中，通过剖析案例，分析代码结构含义、解决常见问题等方式，从高屋建瓴的角度，帮助初学者培养良好的编程习惯。最后，通过Eclipse开发工具的相关讲解，帮助初学者熟悉实际开发中开发工具的使用。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书附有配套视频、源代码、测试题、教学PPT、教学实施案例、教学设计大纲等配套资源。为了帮助初学者及时地解决学习过程中遇到的问题，专门提供了在线答疑平台，希望得到更多读者的关注。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书既可作为高等院校本、专科计算机相关专业的课程设计教材，也可作为Java技术基础的培训教材，是一本适合广大计算机编程者的入门级教材。</p><p><br /></p>', 'no'),
(5, 12, '0005', 'JavaWeb程序开发入门', '45.00', 1000, '2017-10/23/59ed51d5ca44d.png', 'yes', 'yes', '2017-10-23 02:20:06', '<p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书从Web开发初学者的角度出发，深刻且通俗地揭示了Java Web开发的内幕。全书共9章，详细讲解了从XML基础到HTTP协议，从Tomcat开发Web站点到HttpServletResponse和HttpservletRequest的应用，从Servlet技术到JSP技术，以及Cookie，Session，JavaBean等Java Web开发的各个方面的知识和技巧。采用深入浅出、通俗易懂语言阐述其中涉及的概念，并通过结合典型详实的Web应用案例、分析案例代码、解决常见问题等方式，帮助初学者真正明白Web应用程序开发的全过程。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书为JavaWeb开发入门教材，让初学者达到能够灵活使用Java语言开发Web应用程序的程度。为了让初学者易于学习，本书力求内容通俗易懂，讲解寓教于乐。对于初学者较难理解的专业术语，本书都进行了形象地解释，有些还提供了图例。初学者经常会遇到这样的情况，即书中讲解的技术能够理解，但不知道如何应用，为此书中针对每个知识点，精心设计了相应的经典案例，目的是为了让学习者不但能掌握和理解这些知识点，并且还可以清楚地知道在实际工作中如何去运用，并且通过这些案例突出技术的应用价值。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书附有配套视频、源代码、习题、教学课件等资源，而且为了帮助初学者更好地学习本书讲解的内容，还提供了在线答疑，希望得到更多读者的关注。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书适合作为高等院校计算机相关专业程序设计或者Web项目开发的教材，是一本适合广大计算机编程爱好者的优秀读物。</p><p><br /></p>', 'no'),
(6, 11, '0006', 'PHP程序设计基础教程', '40.00', 1000, '2017-10/23/59ed522f303e5.png', 'yes', 'no', '2017-10-23 02:21:35', '<p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">PHP是一种运行于服务器端并完全跨平台的嵌入式脚本编程语言，是目前开发各类Web应用的主流语言之一。《PHP程序设计基础教程》就是面向初学者特地推出的一本进阶学习的书籍，本书从初学者的角度，以形象的比喻、丰富的图解、实用的案例、通俗易懂的语言详细讲解了PHP语言。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书附有配套的教学PPT、题库、教学视频、源代码、教学补充案例、教学设计等资源。同时，为了帮助初学者及时地解决学习过程中遇到的问题，传智播客还专门提供了免费的在线答疑平台，并承诺在3小时内针对问题给予解答。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书可作为高等院校本、专科计算机相关专业程序设计类课程专用教材。</p><p><br /></p>', 'no'),
(7, 11, '0007', 'PHP程序设计高级教程', '45.00', 1000, '2017-10/23/59ed5296f157e.png', 'yes', 'no', '2017-10-23 02:23:19', '<p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">PHP是一种运行于服务器端并完全跨平台的嵌入式脚本编程语言，是目前开发各类Web应用的主流语言之一。本书就是面向具备PHP编程基础的学习者推出的一本进阶教材，以精心设计的应用案例、阶段案例和项目实战，全面讲解了PHP中级项目的开发技术。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">全书共10章，第1章讲解PHP的数据库操作，包括mysql、mysqli和PDO扩展的使用。第2章讲解MVC设计模式，包括MVC典型实现和MVC留言板案例。第3章讲解Smarty模板引擎，包括Smarty的详解和在项目中的应用。第4～5章讲解Web前端技术Ajax和jQuery，包括Ajax的使用、JSON数据格式、Ajax应用案例和jQuery的详解、jQuery的Ajax操作。第6～7章讲解ThinkPHP框架，包括ThinkPHP的详解和使用进阶。第8～9章是项目实战，讲解了电子商务网站的开发过程。第10章讲解Linux环境，包括Linux的安装与使用、LAMP环境搭建和项目部署。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书附有配套视频、源代码、习题、教学课件等资源，而且为了帮助初学者更好地学习本书讲解的内容，还提供了在线答疑，希望得到更多读者的关注。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书适合作为高等院校计算机相关专业程序设计或者Web项目开发的教材，也可作为PHP进阶提高的培训教材，是一本适合广大计算机编程爱好者的优秀读物。</p><p><br /></p>', 'no'),
(8, 11, '0008', 'PHP+Ajax+jQuery网站开发项目式教程', '43.00', 1000, '2017-10/23/59ed533159b0c.png', 'yes', 'yes', '2017-10-23 02:25:53', '<p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">PHP是一种运行于服务器端并完全跨平台的嵌入式脚本编程语言，是目前Web应用开发的主流语言之一。本书是面向初学者推出的一本项目式教程，通过丰富的项目，全面讲解了PHP网站的开发技术。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书共8个项目，41个任务。首先通过成熟开源项目的部署，让初学者深刻的了解到基于PHP和MySQL的项目运行过程；然后完成学生星座判断、个性标签制作、用户头像上传、登录验证码等多个任务，将PHP的基础语法、Web表单与会话技术、文件与图像技术运用到项目开发中，达到学用结合的目的；接着通过员工信息管理以及新闻发布系统的开发，全面学习面向对象编程和PHP如何操作MySQL数据库；再接着完成瀑布流布局、三级联动、无刷新分页、JSONP跨域请求等多个任务，学会使用jQuery和Ajax技术完成项目特效。最后综合运用本书所学的知识和MVC框架，开发电子商务网站，让读者融会贯通、迅速积累项目开发经验。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书附有配套视频、源代码、习题、教学课件等资源，为了帮助初学者更好地学习本书所讲解的内容，还提供了在线答疑，希望更多的读者提供帮助。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">书适合作为高等院校计算机相关专业程序设计或者Web应用开发的教材，也可作为PHP技术基础的培训教材，同时也是一本适合广大计算机编程爱好者的优秀读物。</p><p><br /></p>', 'no'),
(9, 11, '0008', 'PHP+MySQL网站开发项目式教程', '45.00', 1000, '2017-10/23/59ed537b28ea9.png', 'yes', 'yes', '2017-10-23 02:27:07', '<p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书是一本PHP + MySQL的入门书籍，适合初学者使用。全书采用项目式的编写体例，共分为初级、中级和高级3个项目，在每个项目中，有开发背景、需求分析、系统分析、知识讲解、代码实现和扩展提高等模块。通过这种形式，将读者代入到一个接近真实的项目开发环境中，将学习的基础知识在项目中实践，以达到学习巩固以及融会贯通的目的，并且提高编程者的项目经验。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">在设置课程内容时，以Web开发方向为目标，不局限于PHP与MySQL的基础知识，还会将服务器搭建、Web原理、Web安全、功能设计、网站建设、效率优化、用户体验、JavaScript交互、移动端等多个方面融入其中，使读者站在Web开发的整体方向思考问题，具备对整个网站的设计和开发能力。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书附有配套视频、源代码、习题、教学课件等资源，为了帮助初学者更好地学习本书所讲解的内容，还提供了在线答疑，希望更多的读者提供帮助。</p><p style=\"margin-top:0px;margin-bottom:0px;line-height:40px;height:auto;text-indent:2em;font-size:16px;color:rgb(51,51,51);font-family:\'Microsoft YaHei\';white-space:normal;\">本书适合作为高等院校计算机相关专业程序设计或者Web应用开发的教材，也可作为PHP技术基础的培训教材，同时也是一本适合广大计算机编程爱好者的优秀读物。</p><p><br /></p>', 'no');

-- --------------------------------------------------------

--
-- 表的结构 `shop_order`
--

CREATE TABLE `shop_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '购买者用户ID',
  `goods` text NOT NULL COMMENT '商品信息',
  `address` text NOT NULL COMMENT '收件人信息',
  `price` decimal(10,2) NOT NULL COMMENT '订单价格',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '下单时间',
  `cancel` enum('yes','no') NOT NULL COMMENT '是否取消',
  `payment` enum('yes','no') NOT NULL COMMENT '是否支付'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `shop_shopcart`
--

CREATE TABLE `shop_shopcart` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '购买者ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '加入购物车时间',
  `goods_id` int(10) UNSIGNED NOT NULL COMMENT '购买商品ID',
  `num` tinyint(3) UNSIGNED NOT NULL COMMENT '购买商品数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `shop_user`
--

CREATE TABLE `shop_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '登录密码',
  `salt` char(6) NOT NULL COMMENT '密钥',
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `consignee` varchar(20) NOT NULL DEFAULT '' COMMENT '收件人',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shop_admin`
--
ALTER TABLE `shop_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `shop_category`
--
ALTER TABLE `shop_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_goods`
--
ALTER TABLE `shop_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_order`
--
ALTER TABLE `shop_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_shopcart`
--
ALTER TABLE `shop_shopcart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_user`
--
ALTER TABLE `shop_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `shop_admin`
--
ALTER TABLE `shop_admin`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `shop_category`
--
ALTER TABLE `shop_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- 使用表AUTO_INCREMENT `shop_goods`
--
ALTER TABLE `shop_goods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `shop_order`
--
ALTER TABLE `shop_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `shop_shopcart`
--
ALTER TABLE `shop_shopcart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `shop_user`
--
ALTER TABLE `shop_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
