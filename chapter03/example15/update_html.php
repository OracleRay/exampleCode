<?php if(!defined('APP')) die('error!');?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>员工信息编辑</title>
<link rel="stylesheet" href="./js/jquery.datetimepicker.css"/ >
<script src="./js/jquery.js"></script>
<script src="./js/jquery.datetimepicker.js"></script>
<script>
	$(function(){
		$('#date_of_birth').datetimepicker({lang:'ch'});
		$('#date_of_entry').datetimepicker({lang:'ch'});
	});
</script>
<style>
body{background-color:#eee;margin:0;padding:0;}
.box{width:400px;margin:15px auto;padding:20px;border:1px solid #ccc;background-color:#fff;}
.box h1{font-size:20px;text-align:center;}
.profile-table{margin:0 auto;}
.profile-table th{font-weight:normal;text-align:right;}
.profile-table input[type="text"]{width:180px;border:1px solid #ccc;height:22px;padding-left:4px;}
.profile-table .button{background-color:#0099ff;border:1px solid #0099ff;color:#fff;width:80px;height:25px;margin:0 5px;cursor:pointer;}
.profile-table .td-btn{text-align:center;padding-top:10px;}
.profile-table th,.profile-table td{padding-bottom:10px;}
.profile-table td{font-size:14px;}
.profile-table .txttop{vertical-align:top;}
.profile-table select{border:1px solid #ccc;min-width:80px;height:25px;}
.profile-table .description{font-size:13px;width:250px;height:60px;border:1px solid #ccc;}
</style>
</head>
<body>
<div class="box">
	<h1>修改员工信息</h1>
	<form method="post">
	<table class="profile-table">
		<tr><th>姓名：</th><td><input type="text" name="e_name" value="<?php echo $emp_info['e_name']; ?>"/></td></tr>
		<tr><th>所属部门：</th><td><input type="text" name="e_dept" value="<?php echo $emp_info['e_dept']; ?>"/></td></tr>
		<tr><th>出生年月：</th><td><input id="date_of_birth" name="date_of_birth" type="text" value="<?php echo $emp_info['date_of_birth']; ?>"></td></tr>
		<tr><th>入职日期：</th><td><input id="date_of_entry" name="date_of_entry" type="text" value="<?php echo $emp_info['date_of_entry']; ?>"></td></tr>
		<tr><td colspan="2" class="td-btn">
		<input type="submit" value="保存资料" class="button" />
		<input type="reset" value="重新填写" class="button" />
		</td></tr>
	</table>
	</form>
</div>
</body>
</html>