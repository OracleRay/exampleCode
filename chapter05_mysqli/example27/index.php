<?php
// 字符集
header('content-type:text/html;charset=utf-8');
// 载入数据库操作文件
require './public_function.php';
// 连接数据库，选择数据库，设定字符集
dbInit();

// 保存错误信息
$error = array();
// 获取用户请求的目录ID，0表示根目录
$folder_id = isset($_GET['folder']) ? intval($_GET['folder']) : 0;

// ------------------基本操作
// 创建文件夹
if (isset($_POST['newdir'])) {
    
    // 取得文件名并进行安全过滤
    $newdir = trim(safeHandle($_POST['newdir']));

    // 文件名不能为空
    if ($newdir == '') {
        $error[] = '创建文件夹失败，文件名不能为空';
    } else {
        // 禁止相同目录创建同名文件夹
        $sql = "select folder_id from netdisk_folder where folder_pid = $folder_id and folder_name = '$newdir' limit 1";
        if (fetchRow($sql)) {
            $error[] = '创建文件夹失败，该文件夹已存在！';
        } else {
            // 查询父ID文件夹的路径
            $sql = "select folder_path from netdisk_folder where folder_id = $folder_id";
            $parent_path = fetchRow($sql);
            $parent_path = $parent_path['folder_path'];
            $parent_path = $parent_path ? "$parent_path,$folder_id" : $folder_id;
            // 将新文件夹保存到数据库中
            $sql = "insert into netdisk_folder (folder_name,folder_time,folder_path,folder_pid) values ('$newdir',now(),'$parent_path',$folder_id)";
            if (!query($sql)) {
                $error[] =  '创建文件夹失败！';
            }
        }
    }
}

// 删除文件或目录
elseif (isset($_GET['del']) && isset($_GET['type'])) {
    // 获取待删除的文件或目录的ID
    $del_id = intval($_GET['del']);
    // 删除某个文件
    if ($_GET['type'] == 'file') {
        // 取出原文件名
        $sql = "select file_save from `netdisk_file` where file_id = $del_id";
        if (!$rst = fetchRow($sql)) {
            $error[] = '删除的文件记录不存在！';
        } else {
            // 删除文件
            if (is_file($rst['file_save'])) {
                unlink($rst['file_save']);
            }
            // 删除记录
            $sql = "delete from `netdisk_file` where file_id = $del_id";
            if (!query($sql)) {
                $error[] =  '删除记录失败！';
            }
        }
        // 删除某个目录（递归删除内部的文件和目录）
    } elseif ($_GET['type'] == 'folder') {
        // 取出所有子目录ID
        $sql = "select folder_path from `netdisk_folder` where folder_id = $del_id";
        if (!$rst = fetchRow($sql)) {
            $error[] = '删除的目录不存在！';
        } else {
            // 取出所有子目录ID，包括自身
            $del_ids = array($del_id); // 将本身追加到目录ID数组
            $sql = $rst['folder_path'] ? $rst['folder_path'].','.$del_id : $del_id;
            $sql = "select folder_id from `netdisk_folder` where folder_path = '$sql' or folder_path like '$sql,%'";
            if ($rst = fetchAll($sql)) {
                foreach ($rst as $v) {
                    $del_ids[] = $v['folder_id'];
                }
            }
            $del_ids = implode(',', $del_ids);
            // 删除所有子目录中的文件
            // 1. 取出文件地址并删除文件
            $sql = "select `file_save` from `netdisk_file` where folder_id in ($del_ids)";
            if ($rst = fetchAll($sql)) {
                foreach ($rst as $v) {
                    if (is_file($v['file_save'])) {
                        unlink($v['file_save']);
                    }
                }
            }
            // 2. 删除记录
            $sql = "delete from `netdisk_file` where folder_id in ($del_ids)";
            if (!query($sql)) {
                $error[] =  '删除文件记录失败！';
            }
            // 删除所有目录
            $sql = "delete from `netdisk_folder` where folder_id in ($del_ids)";
            if (!query($sql)) {
                $error[] =  '删除目录记录失败！';
            }
        }
    }
}

// 上传文件
elseif (!empty($_FILES['file'])) {
    $upload_file = $_FILES['file'];
    if ($upload_file['error'] >0) {
        $error[] = '文件上传失败！错误代码：'.$upload_file['error'];
    } else {

        // 取得原文件名（仿SQL注入）
        $filename = trim(safeHandle($upload_file['name']));

        // 判断文件名是否已经存在
        $sql = "select file_id from netdisk_file where file_name = '$filename' and folder_id = $folder_id limit 1";
        $file_path = fetchRow($sql);
        $file_path = isset($file_path['file_id']) ? $file_path['file_id'] : '';
        if ($file_path) {
            $error[] = '上传文件失败：文件名冲突！';
        } else {
            // 执行文件上传操作
            
            // 拼接保存目录
            $file_save_path = './uploads/'.date('Y-m/d/');
            // 递归创建文件夹
            if (!file_exists($file_save_path)) {
                mkdir($file_save_path, 0777, true);
            }
            // 拼接文件名
            $file_save_path .= uniqid().'.dat';
            // 保存文件
            if (move_uploaded_file($upload_file['tmp_name'], $file_save_path)) {
                // 获取文件大小
                $file_size = filesize($file_save_path);
                // 添加到数据库记录
                $sql = "insert into netdisk_file (file_name,file_save,file_size,file_time,folder_id) values
				        ('$filename', '$file_save_path','$file_size',now(),$folder_id)";
                if (!query($sql)) {
                    // 文件上传成功，但数据库添加失败，则删除上传的文件
                    unlink($file_save_path);
                    $error[] = '文件上传失败：写入数据库时发生错误。';
                }
            }
        }
    }
}

// 下载文件
elseif (isset($_GET['download'])) {
    // 过滤输入
    $file_id = intval($_GET['download']);
    // 判断文件是否存在，取出文件保存位置
    $sql = "select file_save,file_name from netdisk_file where file_id = $file_id";
    if ($download_file = fetchRow($sql)) {
        // 获取文件大小
        $file_size = filesize($download_file['file_save']);
        // 设置HTTP响应消息为文件下载
        header('content-type:octet-stream');
        header('content-length: ' . $file_size);
        header('content-disposition: attachment;filename="' . $download_file['file_name'] . '"');
        // 以只读的方式打开文件
        $fp = fopen($download_file['file_save'], 'r');
        // 读取文件并输出
        $buffer = 1024;   // 缓存
        $file_count = 0;  // 文件大小计数
        // 判断文件指针是否结束
        while (!feof($fp) && ($file_size - $file_count > 0)) {
            $file_data = fread($fp, $buffer);
            $file_count += $buffer;
            echo $file_data;
        }
        fclose($fp); // 关闭文件
        // 终止脚本
        exit;
    } else {
        $error[] = '文件不存在!';
    }
}

// ------------------实现网盘文件列表
// 请求目录不是根目录时，获取当前访问目录的信息
$path = array();
if ($folder_id != 0) {

    // 根据当前目录ID查询目录列表
    $sql = "select folder_name,folder_path from netdisk_folder where folder_id = $folder_id";
    $current_folder = fetchRow($sql);
    $file_ids = $current_folder['folder_path'];
    // 根据ID路径查询所有父级目录的信息
    $sql = "select folder_id,folder_name from netdisk_folder where folder_id in($file_ids)";
    $path = fetchAll($sql);
    // 将当前目录追加到路径数组的末尾
    $path[] = array(
        'folder_id' => $folder_id,
        'folder_name' => $current_folder['folder_name'],
    );
}

// 获取指定目录下的所有文件夹
$sql = "select folder_id,folder_name,folder_time from netdisk_folder where folder_pid = $folder_id";
$folder = fetchAll($sql);

// 获取指定目录下的所有文件
$sql = "select file_id,file_name,file_save,file_size,file_time from netdisk_file where folder_id = $folder_id";
$file = fetchAll($sql);

// 加载HTML模板文件
define('APP', 'itcast');
require('./index_html.php');
