
-- 创建保存文件信息的数据表
create table `netdisk_file`(
    `file_id` int unsigned primary key auto_increment,
    `file_name` varchar(255) not null comment '文件名',
    `file_save` varchar(255) not null comment '文件保存地址',
    `file_size` int unsigned not null comment '文件大小',
    `file_time` timestamp default current_timestamp not null comment '文件上传时间',
    `folder_id` int unsigned not null comment '文件所属目录'
)charset=utf8;

-- 创建保存目录信息的数据表
create table `netdisk_folder`(
    `folder_id` int unsigned primary key auto_increment,
    `folder_name` varchar(255) not null comment '目录名',
    `folder_time` timestamp default current_timestamp not null comment '创建时间',
    `folder_path` varchar(255) not null comment '目录路径',
    `folder_pid` int unsigned not null comment '父级目录'
)charset=utf8;

-- 为`netdisk_folder`表添加测试数据：
INSERT INTO `netdisk_folder` VALUES 
('1', 'test01',CURRENT_TIMESTAMP , '0', '0'),
('2', 'test02',CURRENT_TIMESTAMP , '0', '0'),
('3', 'test03',CURRENT_TIMESTAMP , '1', '1');

