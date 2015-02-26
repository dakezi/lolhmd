<?php 
$link=mysql_connect('localhost','用户名','密码') or die("连接网站数据库失败，请稍候再试，如仍有问题，请与网站管理员联系");
mysql_select_db('lol',$link);
mysql_query("set names utf8");
?>
