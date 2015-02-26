<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查询</title>
<script language="javascript" type="text/javascript">
function RefreshImage(){
var elid =document.getElementById("im");
elid.src=elid.src+'?';
}
</script>
</head>

<body>

<?php
include_once ('include/conn.php');
include_once ('include/function.php');
session_start();
if ($_POST) {
    $checkcode = $_POST[code];
    if ($checkcode != $_SESSION[checkcode]) {
        echo '对不起，您输入的验证码不正确，请刷新验证码，再重新输入!';
    } else {
        $player = mysql_real_escape_string($_POST[player]);
        $daqu = mysql_real_escape_string($_POST[daqu]);
        if ($player == '') {
            echo '玩家名必须填写';
        } else {
            $sql = mysql_query("SELECT * FROM `content` WHERE `player` = '$player' AND `daqu`='$daqu'");
            $num = mysql_numrows($sql);
            $result = mysql_fetch_array($sql);
            if ($num > 0) {
                $n = 0;
                do {
                    $time[$n] = date('Y-m-d h:i:sa', $result['time']);
                    $content[$n] = $result[content];
                    $enable[$n] = $result[enable];
                    $img[$n] = $result[img];
                    $limg[$n] = $result[localimg];
                    $n = $n + 1;
                } while ($result = mysql_fetch_array($sql));
                $imgmode=checkconfig('imgmode');
                echo '共有' . $num . '条记录<br/>';
                for ($i = 0; $i < $num; $i++) {
                    echo '报告时间：' . $time[$i] . '<br/>';
                    if($enable[$i]==0) echo "该条记录还未通过审核<br/>";
                    echo '说明：' . $content[$i] . '<br/>';
                    echo '图片：<br/>';
                    if($imgmode==0){
                        $imgarray=explode(',',$img[$i]);
                    }else{
                        $imgarray=explode(',',$limg[$i]);
                    }
                    foreach($imgarray as $imgurl)
                    echo '<img src="' . $imgurl . '"/><br/>';
                    echo '<br/>';
                }
            } else {
                echo '没有查询到玩家' . $player .'（'.checkdq($daqu).'）的记录。';
            }
        }
    }
}
$_SESSION[checkcode] = rand(10000, 99999);
?>

<form id="form1" name="form1" method="post" action="">
  <p>玩家名：
    <input name="player" type="text" id="player" size="20" maxlength="100" />
  </p>
  <p>玩家所在大区：
    <select id="daqu"  name="daqu">
  <?php echo dqlist(); ?>
  </select>
  </p>
  <p>验证码：
    <label for="code"></label>
    <input name="code" type="text" id="code" size="6" maxlength="4" />
  <img src="include/checkcode.php?<%{math equation=rand(1,100)}%>" alt="验证码加载中" id="im" align="absmiddle" style="cursor:pointer" onmouseup="RefreshImage()"/><span class="STYLE4">&nbsp;点击刷新</span></p>
  <p>
    <input type="submit" name="button" id="button" value="提交" />
  </p>
</form>
</body>
</html>