<?php

require_once '../include/check.user.php';
require_once '../include/function.php';

if ($_SESSION['euser'] == 'guest') {

    hecho('你还没有登录，请先登录!<br/><a href="login.php">点击登录</a>', '提示');

} else {
    if ($_GET['type'] == 'yes') {
        $enable = 1;
    } else {
        $enable = 0;
    }
    if ($_GET['action']) {
        $nid = (int)$_GET['id'];
        if ($_GET['action'] == 'detail') {
            $sql = mysql_query("select * from content where `id`=$nid");
            $content = mysql_fetch_array($sql);
            if ($content) {
                $imgmode = checkconfig('imgmode');
                $time = date('Y-m-d h:i:sa', $content['time']);
                $id = '&amp;id=' . $nid;
                $hpage = '&amp;page=' . $page;
                $htype = '&amp;type=' . $_GET['type'];
                $info = '
                报告时间：' . $time . '<br/>';

                $info .= '玩家名：' . $content['player'] . '</br>说明：' . $content['content'] .
                    '<br/>图片：<br/>';
                if ($imgmode == 0) {
                    $imgarray = explode(',', $content['img']);
                } else {
                    $imgarray = explode(',', $content['localimg']);
                }
                foreach ($imgarray as $imgurl){
                    if($imgmode!=0)
                    $imgurl='../'.$imgurl;
                    $info .= '<img src="' . $imgurl . '"/><br/>';
                    }
                if ($content['enable'] == 0)
                    $info .= "</br>该条记录还未通过审核";
                $info .= '</br>操作该条：<a href="?action=accept' . $id . $hpage . $htype .
                    '">通过</a> <a href="?action=reject' . $id . $hpage . $htype .
                    '">驳回</a> <a href="?action=delete' . $id . $hpage . $htype . '">删除</a>';
                $info .= '<br/>操作其他：<br/>';
            } else {
                $info = '该条目不存在或已删除!';
            }

        } elseif ($_GET['action'] == 'accept') {
            $query = mysql_query("update `content` set `enable`=1 where `id`='$nid'");
            $result = mysql_affected_rows();
            if ($result)
                $info = '成功接受该条！';
            else
                $info = '操作失败，该条目可能已被操作，或者该条不存在或已删除，或数据库出错！';

        } elseif ($_GET['action'] == 'reject') {
            $query = mysql_query("update `content` set `enable`=0 where `id`='$nid'");
            $result = mysql_affected_rows();
            if ($result)
                $info = '成功驳回该条！';
            else
                $info = '操作失败，该条目可能已被操作，或者该条不存在或已删除，或数据库出错！';

        } elseif ($_GET['action'] == 'delete') {
            $query = mysql_query("DELETE FROM `content` WHERE `id`='$nid' LIMIT 1");
            $result = mysql_affected_rows();
            if ($result)
                $info = '成功删除该条！';
            else
                $info = '操作失败，该条目可能不存在或已被删除，或数据库出错！';
        }
        //$info = 'action!';
    }
    $cnum = (int)checkconfig('contentnum');
    $page = (int)mysql_real_escape_string($_GET[page]);
    $sqlnum = mysql_query("select count(*) from content where `enable`='$enable'");
    $allnum = mysql_result($sqlnum, 0); //获取总数
    $allpage = ceil($allnum / $cnum); //计算总页数
    if (is_int($page)) { //检查get的页数合法性
        if ($page < 1 or $page > $allpage)
            $page = 1;
    } else {
        $page = 1;
    }
    if (is_int($cnum)) {
        if ($cnum < 1)
            $cnum = 10;
    } else {
        $cnum = 10;
    }
    $startnum = ($page - 1) * $cnum; //sql查询位置
    if ($allnum > 0) {
        $sql = mysql_query("select * from content where `enable`='$enable' limit $startnum, $cnum");
        $content = mysql_fetch_array($sql); //获取指定个数的信息
        if ($content) {
            $n = 0;
            do { //遍历内容
                $contentarray[$n] = $content;
                $n = $n + 1;
            } while ($content = mysql_fetch_array($sql));
            //print_r($contentarray);
            if ($page > 1 and $page != $allpage) { //计算上下页
                $nextpage = $page + 1;
                $prepage = $page - 1;
            } elseif ($page == 1 and $allpage != 1) {
                $nextpage = $page + 1;
            } elseif ($page > 1 and $page == $allpage) {
                $prepage = $page - 1;
            }
        } else {
            $error = '还没有人提交内容或者数据库发生错误！';
        }
    } else {
        $error = '还没有人提交内容或者全部已/未审核!';
    }
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理内容</title>
</head>

<body>
<p>查看：<a href="?type=no">未审核</a> <a href="?type=yes">已审核</a></p>
<?php if ($error) {
        echo $error;
    } else {
        echo '<p>' . $info . '</p>' ?>
<table width="1024" border="1">
  <tr>
    <td width="39">序号</td>
    <td width="100">时间</td>
    <td width="182">玩家名</td>
    <td width="384">说明</td>
    <td width="149">报告者IP</td>
    <td width="130">操作</td>
  </tr>
  <?php
        $n = 1;
        $hpage = '&amp;page=' . $page;
        $htype = '&amp;type=' . $_GET['type'];
        foreach ($contentarray as $list) {
            $id = '&amp;id=' . $list['id'];
            echo '
  <tr>
    <td>' . $n . '</td>
    <td>' . date('Y-m-d h:i:sa', $list['time']) . '</td>
    <td>' . $list['player'] . '（'.checkdq($list['daqu']).'）</td>
    <td>' . $list['content'] . '</td>
    <td>' . $list['ip'] . '</td>
    <td><a href="?action=detail' . $id . $hpage . $htype .
                '">详细</a> <a href="?action=accept' . $id . $hpage . $htype .
                '">通过</a> <a href="?action=reject' . $id . $hpage . $htype .
                '">驳回</a> <a href="?action=delete' . $id . $hpage . $htype . '">删除</a></td>
  </tr>
  ';
        $n++;}
?>
</table>
<p><?php
        echo '第' . $page . '/' . $allpage . '页 <a href="?page=1' . $htype .
            '">首页 </a> <a href="?page=' . $prepage . $htype . '">上一页 </a> <a href="?page=' .
            $nextpage . $htype . '">下一页 </a> <a href="?page=' . $allpage . $htype .
            '">尾页</a>'; ?></p>
<?php } ?>
<a href="index.php">返回管理台首页</a>
</body>
</html>
    <?php
}
?>