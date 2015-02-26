<?php

require_once '../include/check.user.php';
require_once '../include/function.php';

if ($_SESSION['euser'] == 'guest')
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登陆</title>
<style type="text/css">
<!--
.STYLE1 {font-size: 24px}
.STYLE2 {font-size: 16px}
.STYLE3 {
	font-size: 36px;
	font-weight: bold;
}
.STYLE4 {
	color: #999999;
	font-size: small;
}
-->
</style>
<script language="javascript" type="text/javascript">
function RefreshImage(){
var elid =document.getElementById("im");
elid.src=elid.src+'?';
}
</script>
</head>

<body>
<form action="check_login.php" method="post" name="form1" target="_self" id="form1">
<table width="501" border="0" align="center" cellpadding="2" cellspacing="0" bordercolor="#003300">
  <tr>
    <td colspan="2" align="center" bgcolor="#CC9900"><span class="STYLE1">管理登陆</span></td>
  </tr>
  <tr>
    <td width="160" align="center" bgcolor="#CCFF00"><span class="STYLE2">用户名：</span></td>
    <td width="337" align="left" bgcolor="#CCFF00">
      <label>
        <input name="user" type="text" class="STYLE2" id="user" size="20" maxlength="20" />
        </label>	</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCFF00"><span class="STYLE2">密码：</span></td>
    <td align="left" bgcolor="#CCFF00"><label>
      <input name="psw" type="password" class="STYLE2" id="psw" size="20" maxlength="20" />
    </label></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCFF00" class="STYLE2">验证码：</td>
    <td align="left" valign="middle" bgcolor="#CCFF00" class="STYLE2"><label>
      <input name="checkcode" type="text" id="checkcode" size="10" maxlength="4" />
      <img src="../include/checkcode.php?<%{math equation=rand(1,100)}%>" alt="验证码加载中" id="im" align="absmiddle" style="cursor:pointer" onmouseup="RefreshImage()"/><span class="STYLE4">&nbsp;点击刷新</span></label></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#CCFF00" class="STYLE2"><label>保存登录状态：
        <select name="savecookie" id="savecookie">
          <option value="0">不保存</option>
          <option value="1">保存1天</option>
          <option value="2">保存1周</option>
        </select>
    </label></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle" bgcolor="#CCFF00"><a href="register.php"></a>
      <input name="login" type="submit" class="STYLE2" id="login" value="登陆" />      
      &nbsp;&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
    <?php
} else
{
    hecho('你已经登录，请不要重复访问本页面!<br/><a href="index.php">后台首页</a>','提示');
}

?>