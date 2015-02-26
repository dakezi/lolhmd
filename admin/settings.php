<?php
require_once '../include/check.user.php';
require_once '../include/function.php';

if ($_SESSION['euser'] == 'guest') {

    hecho('你还没有登录，请先登录!<br/><a href="login.php">点击登录</a>', '提示');

} else {
    if ($_POST['submit']) {
        $imgmode = $_POST['imgmode'];
        $cnum = $_POST['cnum'];
        setconfig('imgmode', $imgmode);
        setconfig('contentnum', $cnum);
        $ok=1;
    } else {
        $imgmode = checkconfig('imgmode');
        $cnum = checkconfig('contentnum');
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>设置</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
<?php if($ok) echo '<p>设置已保存！</p>';?>
  <p>图片显示：
<label>
        <input name="imgmode" type="radio" value="0" <?php if($imgmode=="0") echo 'checked="checked"';?> />
    </label>
贴图库
<label> &nbsp;
<input type="radio" name="imgmode" value="1" <?php if($imgmode=="1") echo 'checked="checked"';?>/>
本地图片
&nbsp;</label></p>
  <p>后台管理每页显示个数： 
    <label for="cnum"></label>
    <input name="cnum" type="text" id="cnum" size="4" maxlength="2" value="<?php echo $cnum;?>"/>
  </p>
  <p>
    <input type="submit" name="submit" id="submit" value="提交" />
  </p>
</form>
</body>
</html>
    <?php
}


?>