<?php

require_once "../include/conn.php";
require_once '../include/check.user.php';
require_once '../include/function.php';

if ($_SESSION['euser'] == 'guest') {
    if ($_POST[login] == '') {
        hecho('您的操作有误，请确认您访问本页的途径！', '错误');
    } else {
        $checkcode = $_POST[checkcode];
        if ($checkcode != $_SESSION[checkcode]) {
            hecho('对不起，您输入的验证码不正确，请重新输入!<br/><button onclick="history.go(-1)">返回上一页</button>',
                '登录失败');
        } else {
            $name = mysql_real_escape_string($_POST[user]);
            $pwd = md5(mysql_real_escape_string($_POST[psw]));
            $sql = mysql_query("select * from users where user='$name' and password='$pwd'");
            $result = mysql_fetch_array($sql);
            if ($result != "") {
                $_SESSION['euser'] = $name;
                $sct = $_POST['savecookie'];
                if ($sct == 0) {
                    $sctt = null;
                } elseif ($sct == 1) {
                    $sctt = time() + 43200;
                } elseif ($sct == 2) {
                    $sctt = time() + 302400;
                }
                setcookie("euser", $name, $sctt);
                setcookie("epwd", base64_encode($pwd), $sctt);
                //$query = mysql_query("select * from `users` where `user`='$name'");
                //$result = mysql_fetch_array($query);
                //$logins = $result[logins]+1;
                //$query = mysql_query("update `users` set `logins`='$logins' where `user`='$name'");
                hecho('登录成功，<a href="index.php">正在跳转到后台首页</a><meta http-equiv=refresh content=1;URL="index.php">');
                //$_SESSION['uid'] = $result[uid];
            } else {
                hecho('对不起，您输入的用户名和/或密码不正确，请重新输入!<br/><button onclick="history.go(-1)">返回上一页</button>',
                    '登录失败');
            }
        }
        for ($i = 0; $i < 4; $i++) {
            $new_number .= dechex(rand(0, 15));
        }
        $_SESSION[checkcode] = $new_number;
    }
} else {
    hecho('<a href="admin.php">正在跳转到后台首页</a><meta http-equiv=refresh content=1;URL="admin.php">', '你已经登录');
}

?>
