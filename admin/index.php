<?php

require_once '../include/check.user.php';
require_once '../include/function.php';

if ($_SESSION['euser'] == 'guest')
{
    
    hecho('你还没有登录，请先登录!<br/><a href="login.php">点击登录</a>','提示');
    
} else
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理</title>
</head>

<body>
<p><?php echo $_SESSION['euser'];?>，欢迎您！</p>
<p><a href="settings.php">系统设置</a></p>
<p><a href="content.php">内容管理</a></p>
<p><a href="logout.php">退出管理</a></p>
</body>
</html>
   <?php 
}

?>