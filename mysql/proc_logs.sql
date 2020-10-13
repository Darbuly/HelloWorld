/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : jieyi_order_local

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2020-10-13 10:19:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for proc_logs
-- ----------------------------
DROP TABLE IF EXISTS `proc_logs`;
CREATE TABLE `proc_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'mysql调试日志表',
  `type` int(10) DEFAULT '0' COMMENT '0:存储过程；1:某个函数',
  `source` varchar(255) DEFAULT NULL COMMENT '哪个存储过程',
  `message` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
