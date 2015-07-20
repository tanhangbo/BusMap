-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 07 月 20 日 13:29
-- 服务器版本: 5.0.90
-- PHP 版本: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `bus_detail`
--

CREATE TABLE IF NOT EXISTS `bus_detail` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `main_id` int(10) unsigned NOT NULL,
  `time` time NOT NULL,
  `place` varchar(50) collate utf8_unicode_ci NOT NULL,
  `xy` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `main_to_detail` (`main_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=170 ;

--
-- 转存表中的数据 `bus_detail`
--

INSERT INTO `bus_detail` (`id`, `main_id`, `time`, `place`, `xy`) VALUES
(1, 1, '08:20:00', 'start to move', '121.483076,31.243499'),
(2, 1, '08:20:00', 'next step', '121.484477,31.242696'),
(3, 1, '08:20:00', 'high way', '121.474739,31.23331'),
(12, 2, '08:20:00', 'start to move', '121.503809,31.245536'),
(13, 2, '08:20:00', 'next step', '121.517499,31.238559'),
(17, 2, '08:20:00', 'high way', '121.519906,31.235379');

-- --------------------------------------------------------

--
-- 表的结构 `main`
--

CREATE TABLE IF NOT EXISTS `main` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `which_time` varchar(4) collate utf8_unicode_ci NOT NULL COMMENT '时段',
  `which_bus` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '车次',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `main`
--

INSERT INTO `main` (`id`, `which_time`, `which_bus`) VALUES
(1, 'idx0', 'A'),
(2, 'idx0', 'B'),
(3, 'idx0', 'C'),
(4, 'idx0', 'D'),
(5, 'idx0', 'E'),
(7, 'idx0', 'F'),
(12, 'idx1', 'A'),
(13, 'idx1', 'B'),
(14, 'idx1', 'D'),
(15, 'idx1', 'E'),
(19, 'idx2', 'A'),
(20, 'idx2', 'B'),
(21, 'idx2', 'C'),
(22, 'idx2', 'D'),
(25, 'idx3', 'A'),
(26, 'idx3', 'B');
