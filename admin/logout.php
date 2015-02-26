<?php
session_start();

require_once '../include/function.php';
//require_once 'include/config.smarty.php';
$_SESSION = array();
$_SESSION['euser'] = 'guest';
setcookie("euser", "guest");
setcookie("epwd", "");
hecho('注销成功!你已经安全退出系统！<br/><a href="login.php">重新登录</a>');

?>