<?php
require_once 'conn.php';
session_start();

if (empty($_SESSION['euser'])) {
    if (empty($_COOKIE['euser'])) {
        setcookie("euser", "guest");
        setcookie("epwd", "");
        $_SESSION['euser'] = 'guest';
    } else {
        if ($_COOKIE['euser'] != 'guest') {
            $user = mysql_real_escape_string($_COOKIE['euser']);
            $pwd = mysql_real_escape_string(base64_decode($_COOKIE['epwd']));
            $sql = mysql_query("select * from users where user='$user' and password='$pwd'");
            $result = mysql_fetch_array($sql);
            if ($result == '') {
                setcookie("euser", "guest");
                setcookie("epwd", "");
                $_SESSION['euser'] = 'guest';
                //$_SESSION['uid']=$result[uid];
            } else {
                $_SESSION['euser'] = $user;
                //$_SESSION['uid'] = $result[uid];
            }
        }
    }
}
?>