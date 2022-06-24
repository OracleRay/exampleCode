<?php
header('content-type:text/html;charset=utf-8');

//trim()函数
echo trim('  测试  ');   //输出结果：“测试”
echo trim('  测 试 ');   //输出结果：“测 试”
echo trim("\n\t测试");   //输出结果：“测试”

//intval()函数
echo intval('123abc');  //输出结果：123
echo intval(' 123abc'); //输出结果：123
echo intval('abc123');  //输出结果：0

//strip_tags()函数
echo strip_tags('<b>测试</b>'); //输出结果：“测试”
echo strip_tags('<传智>播客');  //输出结果：“播客”

//htmlspecialchars()函数
echo htmlspecialchars('<测试>');  //输出结果：“&lt;测试&gt;”
echo htmlspecialchars('<b>测试</b>'); //输出结果：“&lt;b&gt;测试&lt;/b&gt;gt;”