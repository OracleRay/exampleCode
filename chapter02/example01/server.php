<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>服务器信息</title>
  <style>
  body{background-color:#eee; font-size:14px;}
  table {*border-collapse: collapse; /* IE7 and lower */border-spacing: 0;width: 330px;color:#2B2B2B;}
  .bordered {border: solid #DADADA 1px;padding-top:10px; background-color:#fff;}
  .bordered tr,td{padding:10px;text-align:right;}
  .bordered th{border-bottom: solid #DFE4E7 1px;text-align:left; padding-bottom:5px;text-indent:28px;}
  .bordered td:nth-child(2){text-align:left;}
  </style>
 </head>
 <body>
  <table class="bordered">
	<tr><th colspan="2">服务器信息展示</th></tr>
	<tr><td>当前PHP版本号：</td><td><?php echo PHP_VERSION;?></td></tr>
	<tr><td>操作系统的类型:</td><td><?php echo PHP_OS;?></td></tr>
	<tr><td>当前服务器时间:</td><td><?php echo date('Y-m-d H:i:s');?></td></tr>
  </table>	
 </body>
</html>