<?php define('APP','itcast');?>
<!doctype html>
<html>
<head>
 <meta charset="utf-8">
 <title>网页布局</title>
 <link href="style.css" rel="stylesheet" />
</head>
<body>
	<div class="title">header</div>
	<div class="main">
		<div class="content"><?php include './content.php';?></div>
		<div class="side"><?php include './side.php';?></div>
	</div>
	<div class="footer">footer</div>
</body>
</html>