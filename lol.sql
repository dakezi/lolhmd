-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 10 月 20 日 22:13
-- 服务器版本: 5.5.11
-- PHP 版本: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lol`
--

-- --------------------------------------------------------

--
-- 表的结构 `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(100) NOT NULL,
  `enable` int(11) NOT NULL DEFAULT '0',
  `player` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `img` text NOT NULL,
  `localimg` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `daqu` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `content`
--


-- --------------------------------------------------------

--
-- 表的结构 `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `option` varchar(255) NOT NULL,
  `set1` varchar(255) NOT NULL,
  `set2` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `settings`
--

INSERT INTO `settings` (`option`, `set1`, `set2`) VALUES
('imgmode', '0', ''),
('contentnum', '10', ''),
('dq1', '艾欧尼亚 电信一', ''),
('dq2', '比尔吉沃特 网通一', ''),
('dq3', '祖安 电信二', ''),
('dq4', '诺克萨斯 电信三', ''),
('dq5', '德玛西亚 网通二', ''),
('dq6', '班德尔城 电信四', ''),
('dq7', '皮尔特沃夫 电信五', ''),
('dq8', '战争学院 电信六', ''),
('dq9', '弗雷尔卓德 网通三', ''),
('dq10', '巨神峰 电信七', ''),
('dq11', '雷瑟守备 电信八', ''),
('dq12', '无畏先锋 网通四', ''),
('dq13', '裁决之地 电信九', ''),
('dq14', '黑色玫瑰 电信十', ''),
('dq15', '暗影岛 电信十一', ''),
('dq16', '钢铁烈阳 电信十二', ''),
('dq17', '恕瑞玛 网通五', ''),
('dq18', '均衡教派 电信十三', ''),
('dq19', '水晶之痕 电信十四', ''),
('dq20', '教育网专区', ''),
('dq21', '影流 电信十五', ''),
('dq22', '守望之海 电信十六', ''),
('dq23', '扭曲丛林 网通六', ''),
('dq24', '征服之海 电信十七', ''),
('dq25', '卡拉曼达 电信十八', ''),
('dq26', '皮城警备 电信十九', '');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL,
  `face` varchar(100) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `identity` varchar(10) NOT NULL,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`uid`, `user`, `password`, `face`, `status`, `identity`, `name`) VALUES
(1, 'admin', '7fef6171469e80d32c0559f88b377245', '', 1, '', '');
