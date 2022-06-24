<?php

header('content-type:text/html;charset=utf-8');
require './MySQLIDB.class.php';

$params = array(
    'user' => 'root',
    'pwd' => '123456'
);

$mysql = MySQLIDB::getInstance($params);

$mysql2 = MySQLIDB::getInstance($params);


echo '<pre>';

var_dump($mysql, $mysql2);