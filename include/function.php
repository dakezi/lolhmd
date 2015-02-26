<?php

/**
 * @author jacy
 * @copyright 2014
 */

//功能模块

function runget($url) //运行curl的get功能

{
    global $cookie_file;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    $data = curl_exec($ch);
    $code = (curl_getinfo($ch, CURLINFO_HTTP_CODE));
    curl_close($ch);
    return array("code" => $code, "data" => $data);
}

function runpost($url, $post) //运行curl的post功能
{
    global $cookie_file;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    $data = curl_exec($ch);
    $code = (curl_getinfo($ch, CURLINFO_HTTP_CODE));
    curl_close($ch);
    return array("code" => $code, "data" => $data);
}

function filearray($arr)
{ //文件表单域数据转置
    $n = count($arr[name]);
    for ($i = 0; $i < $n; $i++) {
        $out[$i][name] = $arr[name][$i];
        $out[$i][type] = $arr[type][$i];
        $out[$i][tmp_name] = $arr[tmp_name][$i];
        $out[$i][error] = $arr[error][$i];
        $out[$i][size] = $arr[size][$i];
    }
    return $out;
}

function checkconfig($option)
{
    $query = mysql_query("select * from `settings` where `option`='$option'");
    $result = mysql_fetch_array($query);
    return $result[set1];
}

function setconfig($option, $value)
{
    $query = mysql_query("update `settings` set `set1`='$value' where `option`='$option'");
    $result = mysql_affected_rows();
    return $result;
}

function dqlist()
{ //输出大区html表单(仅option)
    $query = mysql_query("select * from `settings` where `option` LIKE 'dq%'");
    $result = mysql_fetch_array($query);
    do {
        $out .= '<option value="' . $result['option'] . '">' . $result['set1'] .
            '</option>';
    } while ($result = mysql_fetch_array($query));
    return $out;
}

function checkdq($dqid)
{ //获得大区名
    $dqid = mysql_real_escape_string($dqid);
    $query = mysql_query("select * from `settings` where `option` = '$dqid'");
    $result = mysql_fetch_array($query);
    return $result['set1'];
}

// 获取IP地址（摘自discuz）
function getIp()
{
    $ip = '未知IP';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return is_ip($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : $ip;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return is_ip($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] :
            $ip;
    } else {
        return is_ip($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $ip;
    }
}
function is_ip($str)
{
    $ip = explode('.', $str);
    for ($i = 0; $i < count($ip); $i++) {
        if ($ip[$i] > 255) {
            return false;
        }
    }
    return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $str);
}

function hecho($str, $title = "提示信息")
{
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
</head>

<body>
<?php echo $str; ?>
</body>
</html>
<?php
}
?>