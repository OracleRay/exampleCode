<?php if(!defined('APP')) exit('error!');?>
<h2>PHP培训开班信息</h2>
<ul>
	<?php 
		$arr = array(
			array('PHP基础班','北京--第35期（2015年03月06号）','北京--第36期（2015年04月06号）','广州--第10期（2015年04月22号）'),
			array('PHP就业班','北京--第36期（2015年04月07号）','广州--第09期（2015年04月06号）'),
			array('PHP远程班','基础班--第35期（2015年03月06号）','就业班--第36期（2015年04月07号）')
		);
		foreach($arr as $values):
			foreach($values as $k => $v):
				echo $k > 0 ? "<li>$v</li>" : "<p>$v</p>";
			endforeach;
		endforeach;
	?>
</ul>