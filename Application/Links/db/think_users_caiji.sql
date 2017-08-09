/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : phpbc

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-08-09 16:22:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for think_users_caiji
-- ----------------------------
DROP TABLE IF EXISTS `think_users_caiji`;
CREATE TABLE `think_users_caiji` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `true_name` varchar(20) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `islock` int(11) DEFAULT '0' COMMENT '1表示锁定 0表示未锁',
  `question` varchar(100) DEFAULT NULL,
  `answer` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `regtime` int(11) DEFAULT '0',
  `logintime` int(11) DEFAULT '0',
  `loginnum` int(11) DEFAULT '0',
  `face` varchar(100) DEFAULT NULL COMMENT '头像',
  `loginip` varchar(255) DEFAULT NULL,
  `info` text,
  `regip` varchar(255) DEFAULT NULL,
  `sex` int(11) DEFAULT '1',
  `isdel` int(11) DEFAULT '0' COMMENT '1表示已删除',
  `tj` int(11) DEFAULT '0' COMMENT '1表示推荐的明星',
  `companystatus` int(11) DEFAULT '0' COMMENT '0表示普通用户，1表示企业用户',
  `adminid` int(11) DEFAULT '0',
  `macaddress` varchar(50) DEFAULT NULL,
  `starttime` int(11) DEFAULT '0',
  `groupid` int(11) DEFAULT '0',
  `endtime` int(11) DEFAULT '0',
  `phonecheck` int(2) DEFAULT NULL,
  `checkemail` int(2) DEFAULT NULL,
  `openid` varchar(100) DEFAULT NULL,
  `third_party` int(11) DEFAULT '0',
  `tag` text,
  `mycode` varchar(10) DEFAULT NULL,
  `sign_num` int(11) DEFAULT '0',
  `sign_time` int(11) DEFAULT '0',
  `sum_integral` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
