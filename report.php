<?php
include_once ('include/TieTuKu.class.php');
include_once ('include/conn.php');
include_once ('include/function.php');
include_once ('include/uploadimg.php');

session_start();
define('MY_ACCESSKEY', '227122201303a2da26d76f3c76203d7fb3f269b4'); //获取地址:http://open.tietuku.com/manager
define('MY_SECRETKEY', '3a8d4f791f7f2609df74a684a482a0148b736d9f'); //获取地址:http://open.tietuku.com/manager
if ($_POST) {
    $checkcode = $_POST[code];
    if ($checkcode != $_SESSION[checkcode]) {
        hecho('对不起，您输入的验证码不正确，请刷新提交页面的验证码，再重新输入!<br/><button onclick="history.go(-1)">返回上一页</button>',
            '登录失败');
    } else {
        $player = mysql_real_escape_string($_POST[player]);
        $content = mysql_real_escape_string($_POST[content]);
        $daqu = mysql_real_escape_string($_POST[daqu]);
        if ($player == '' || $content == '') {
            hecho('玩家名和说明必须填写！<br/><button onclick="history.go(-1)">返回上一页</button>');
        } elseif (!checkdq($daqu)) {
            hecho('大区提交有误，请刷新提交页面重新提交，如有疑问请与管理员联系<br/><button onclick="history.go(-1)">返回上一页</button>');
        } else {
            $ttk = new TTKClient(MY_ACCESSKEY, MY_SECRETKEY); //贴图库上传
            $res = $ttk->curlUpFile('10624', 'file'); //贴图库相册id
            $result = json_decode($res);
            foreach ((array)$result as $obj) {
                    if ($img)
                        $img = $img . ',' . ($obj->linkurl);
                    else
                        $img = $obj->linkurl;
                }
            if ($res == '') {
                hecho('贴图库错误，请重试，如仍然错误，联系管理员<br/><button onclick="history.go(-1)">返回上一页</button>');
            } elseif ($res == 'null') {
                hecho('图片上传失败，可能是没有选择要上传的图片<br/><button onclick="history.go(-1)">返回上一页</button>');
            } elseif($img==''){
                hecho('图片上传失败，可能是图片格式不正确或者网络太差导致上传中断，请重试，如重复提示请与管理员联系<br/><button onclick="history.go(-1)">返回上一页</button>');
            }
            else {
                $file = filearray($_FILES['file']); //本地上传
                $upfile = new upfile();
                for ($i = 0; $i < 5; $i++) {
                    if ($file[$i][error] == 0) {
                        $upfile->uploadfile($file[$i], $filename);
                        if ($limg)
                            $limg = $limg . ',' . $filename;
                        else
                            $limg = $filename;
                    }
                }
                date_default_timezone_set("Asia/Hong_Kong");
                $time = time();
                $ip = getIp();
                $query = mysql_query("INSERT INTO `content` (`id`, `time`, `enable`, `player`, `content`, `img`, `localimg`, `ip`, `daqu`) VALUES (NULL, '$time', '0', '$player', '$content', '$img', '$limg', '$ip', '$daqu')");
                hecho('恭喜！提交成功，请等待管理员审核！<br/><a href="index.html">返回首页</a>');
            }
        }
    }
    $_SESSION[checkcode] = rand(10000, 99999);
} else {
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提交报告</title>
<script language="javascript" type="text/javascript">
function RefreshImage(){
var elid =document.getElementById("im");
elid.src=elid.src+'?';
}
</script>
</head>

<body>
<form method="post" enctype="multipart/form-data" action="report.php" accept-charset="utf-8">
  <p>
    <label for="player"></label>
    玩家名：
    <input name="player" type="text" id="player" size="20" maxlength="100" />
  </p>
  <p>所在大区：
  <select id="daqu"  name="daqu">
  <?php echo dqlist(); ?>
  </select>
  </p>
  <p>说明：</p>
  <p>
    <label for="content"></label>
    <textarea name="content" id="content" cols="45" rows="10"></textarea>
  </p>
  <p>上传图片（1-5张，支持jpg, png, gif格式）：<br/>
    <input type="file" name="file[]" value="" placeholder="">
    <br/>
    <input type="file" name="file[]" value="" placeholder="">
    <br/>
    <input type="file" name="file[]" value="" placeholder="">
    <br/>
    <input type="file" name="file[]" value="" placeholder="">
    <br/>
    <input type="file" name="file[]" value="" placeholder="">
  </p>
  <p>验证码： 
    <label for="code"></label>
    <input name="code" type="text" id="code" size="6" maxlength="4" />
    <img src="include/checkcode.php?<%{math equation=rand(1,100)}%>" alt="验证码加载中" id="im" align="absmiddle" style="cursor:pointer" onmouseup="RefreshImage()"/><span class="STYLE4">&nbsp;点击刷新</span>
  </p>
  <p>（如果提交失败，需点击刷新验证码再重新提交）</p>
  <input type="submit" name="submit" id="submit" value="提交" />
</form>
</body>
</html>

    <?php

}
?>