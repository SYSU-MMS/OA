/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50622
Source Host           : localhost:3306
Source Database       : mydb

Target Server Type    : MYSQL
Target Server Version : 50622
File Encoding         : 65001

Date: 2016-08-31 23:59:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for moa_apply
-- ----------------------------
DROP TABLE IF EXISTS `moa_apply`;
CREATE TABLE `moa_apply` (
  `applyid` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL COMMENT '申请发起人wid',
  `dealer` int(11) NOT NULL COMMENT '处理人wid',
  `substitor` int(11) DEFAULT NULL COMMENT '代班人wid',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '申请类别：\n0 - 请假\n1 - 被代班',
  `worktype` int(11) NOT NULL DEFAULT '0' COMMENT '工作类型：\n0 - 值班\n1 - 常检\n2 - 周检\n3 - 拍摄',
  `checkid` int(11) DEFAULT NULL,
  `dutyid` int(11) DEFAULT NULL COMMENT '申请的值班时段',
  PRIMARY KEY (`applyid`),
  KEY `wid_idx` (`sender`,`dealer`,`substitor`),
  KEY `checkid_idx` (`checkid`),
  KEY `dutyid_idx` (`dutyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代换请假申请表';

-- ----------------------------
-- Records of moa_apply
-- ----------------------------

-- ----------------------------
-- Table structure for moa_attendence
-- ----------------------------
DROP TABLE IF EXISTS `moa_attendence`;
CREATE TABLE `moa_attendence` (
  `attend_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '出勤记录id',
  `wid` int(11) NOT NULL COMMENT '考勤人wid',
  `timestamp` datetime NOT NULL COMMENT '出勤记录时间戳',
  `weekcount` int(11) NOT NULL COMMENT '周次',
  `weekday` int(11) NOT NULL COMMENT '星期',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '考勤类型：\n0 - 值班\n1 - 早检\n2 - 午检3 - 晚检4 - 周检',
  `dutyPeriod` int(11) DEFAULT NULL COMMENT '值班时间段',
  `isLate` int(11) NOT NULL DEFAULT '0' COMMENT '是否迟到：\n0 - 否\n1 - 是',
  `isSubstitute` int(11) NOT NULL DEFAULT '0' COMMENT '是否代别人的班：\n0 - 否\n1 - 是',
  `substituteFor` int(11) DEFAULT NULL COMMENT '被代班者的wid',
  `applyid` int(11) DEFAULT NULL COMMENT '代检代班审计单id',
  PRIMARY KEY (`attend_id`),
  KEY `fk_MOA_Attendence_MOA_Worker1_idx` (`wid`),
  KEY `applyid_idx` (`applyid`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8 COMMENT='考勤表';

-- ----------------------------
-- Records of moa_attendence
-- ----------------------------
INSERT INTO `moa_attendence` VALUES ('241', '1', '2016-08-28 17:18:58', '0', '7', '1', null, '0', '0', null, null);
INSERT INTO `moa_attendence` VALUES ('242', '1', '2016-08-28 17:24:27', '0', '7', '2', null, '0', '0', null, null);
INSERT INTO `moa_attendence` VALUES ('243', '1', '2016-08-29 21:42:45', '1', '1', '0', '6', '0', '1', '100', null);
INSERT INTO `moa_attendence` VALUES ('244', '1', '2016-08-30 22:24:48', '1', '2', '1', null, '0', '0', null, null);
INSERT INTO `moa_attendence` VALUES ('245', '1', '2016-08-30 22:25:00', '1', '2', '2', null, '0', '0', null, null);
INSERT INTO `moa_attendence` VALUES ('246', '58', '2016-08-30 23:56:52', '1', '2', '1', null, '0', '0', null, null);
INSERT INTO `moa_attendence` VALUES ('247', '58', '2016-08-30 23:56:56', '1', '2', '2', null, '0', '0', null, null);
INSERT INTO `moa_attendence` VALUES ('248', '58', '2016-08-30 23:57:01', '1', '2', '3', null, '0', '0', null, null);
INSERT INTO `moa_attendence` VALUES ('249', '1', '2016-08-31 20:31:07', '1', '3', '1', null, '0', '0', null, null);

-- ----------------------------
-- Table structure for moa_check
-- ----------------------------
DROP TABLE IF EXISTS `moa_check`;
CREATE TABLE `moa_check` (
  `checkid` int(11) NOT NULL AUTO_INCREMENT COMMENT '常检状态记录id',
  `weekcount` int(11) NOT NULL COMMENT '发生这条记录是第几周',
  `weekday` int(11) NOT NULL COMMENT '星期几的检查：\n周检：0\n常检：1-5',
  `type` int(11) NOT NULL COMMENT '类型：\n0 - 早检\n1 - 午检\n2 - 晚检\n3 - 周检',
  `roomid` int(11) NOT NULL,
  `actual_wid` int(11) NOT NULL COMMENT '早检实际的wid',
  `isChecked` int(11) NOT NULL DEFAULT '0' COMMENT '是否检查完毕：\n0 - 否\n1 - 是，正常\n2 - 是，课室有故障',
  `problemid` int(11) DEFAULT NULL COMMENT '故障说明',
  `timestamp` datetime DEFAULT NULL COMMENT '情况签写时间戳',
  `light` int(11) DEFAULT NULL COMMENT '周检灯时',
  PRIMARY KEY (`checkid`),
  KEY `wid_idx` (`actual_wid`),
  KEY `fk_MOA_Check_MOA_CheckRoom1_idx` (`roomid`),
  KEY `pid_idx` (`problemid`)
) ENGINE=InnoDB AUTO_INCREMENT=639 DEFAULT CHARSET=utf8 COMMENT='课室检查状态表';

-- ----------------------------
-- Records of moa_check
-- ----------------------------
INSERT INTO `moa_check` VALUES ('599', '0', '7', '0', '10101', '1', '2', '233', '2016-08-28 17:18:58', null);
INSERT INTO `moa_check` VALUES ('600', '0', '7', '0', '10102', '1', '1', null, '2016-08-28 17:18:58', null);
INSERT INTO `moa_check` VALUES ('601', '0', '7', '0', '10103', '1', '1', null, '2016-08-28 17:18:58', null);
INSERT INTO `moa_check` VALUES ('602', '0', '7', '0', '10104', '1', '1', null, '2016-08-28 17:18:58', null);
INSERT INTO `moa_check` VALUES ('603', '0', '7', '0', '10105', '1', '1', null, '2016-08-28 17:18:58', null);
INSERT INTO `moa_check` VALUES ('604', '0', '7', '1', '10101', '1', '1', null, '2016-08-28 17:24:27', null);
INSERT INTO `moa_check` VALUES ('605', '0', '7', '1', '10102', '1', '2', '234', '2016-08-28 17:24:27', null);
INSERT INTO `moa_check` VALUES ('606', '0', '7', '1', '10103', '1', '1', null, '2016-08-28 17:24:27', null);
INSERT INTO `moa_check` VALUES ('607', '0', '7', '1', '10104', '1', '1', null, '2016-08-28 17:24:27', null);
INSERT INTO `moa_check` VALUES ('608', '0', '7', '1', '10105', '1', '1', null, '2016-08-28 17:24:27', null);
INSERT INTO `moa_check` VALUES ('609', '1', '2', '0', '10101', '1', '1', null, '2016-08-30 22:24:48', null);
INSERT INTO `moa_check` VALUES ('610', '1', '2', '0', '10102', '1', '1', null, '2016-08-30 22:24:48', null);
INSERT INTO `moa_check` VALUES ('611', '1', '2', '0', '10103', '1', '1', null, '2016-08-30 22:24:48', null);
INSERT INTO `moa_check` VALUES ('612', '1', '2', '0', '10104', '1', '1', null, '2016-08-30 22:24:48', null);
INSERT INTO `moa_check` VALUES ('613', '1', '2', '0', '10105', '1', '1', null, '2016-08-30 22:24:48', null);
INSERT INTO `moa_check` VALUES ('614', '1', '2', '1', '10101', '1', '2', '235', '2016-08-30 22:25:00', null);
INSERT INTO `moa_check` VALUES ('615', '1', '2', '1', '10102', '1', '1', null, '2016-08-30 22:25:00', null);
INSERT INTO `moa_check` VALUES ('616', '1', '2', '1', '10103', '1', '1', null, '2016-08-30 22:25:00', null);
INSERT INTO `moa_check` VALUES ('617', '1', '2', '1', '10104', '1', '1', null, '2016-08-30 22:25:00', null);
INSERT INTO `moa_check` VALUES ('618', '1', '2', '1', '10105', '1', '1', null, '2016-08-30 22:25:00', null);
INSERT INTO `moa_check` VALUES ('619', '1', '2', '0', '30212', '58', '1', null, '2016-08-30 23:56:52', null);
INSERT INTO `moa_check` VALUES ('620', '1', '2', '0', '30213', '58', '2', '236', '2016-08-30 23:56:52', null);
INSERT INTO `moa_check` VALUES ('621', '1', '2', '0', '30214', '58', '1', null, '2016-08-30 23:56:52', null);
INSERT INTO `moa_check` VALUES ('622', '1', '2', '0', '30215', '58', '1', null, '2016-08-30 23:56:52', null);
INSERT INTO `moa_check` VALUES ('623', '1', '2', '0', '30216', '58', '1', null, '2016-08-30 23:56:52', null);
INSERT INTO `moa_check` VALUES ('624', '1', '2', '1', '30212', '58', '1', null, '2016-08-30 23:56:56', null);
INSERT INTO `moa_check` VALUES ('625', '1', '2', '1', '30213', '58', '1', null, '2016-08-30 23:56:56', null);
INSERT INTO `moa_check` VALUES ('626', '1', '2', '1', '30214', '58', '1', null, '2016-08-30 23:56:56', null);
INSERT INTO `moa_check` VALUES ('627', '1', '2', '1', '30215', '58', '1', null, '2016-08-30 23:56:56', null);
INSERT INTO `moa_check` VALUES ('628', '1', '2', '1', '30216', '58', '1', null, '2016-08-30 23:56:56', null);
INSERT INTO `moa_check` VALUES ('629', '1', '2', '2', '30212', '58', '1', null, '2016-08-30 23:57:01', null);
INSERT INTO `moa_check` VALUES ('630', '1', '2', '2', '30213', '58', '2', '237', '2016-08-30 23:57:01', null);
INSERT INTO `moa_check` VALUES ('631', '1', '2', '2', '30214', '58', '1', null, '2016-08-30 23:57:01', null);
INSERT INTO `moa_check` VALUES ('632', '1', '2', '2', '30215', '58', '1', null, '2016-08-30 23:57:01', null);
INSERT INTO `moa_check` VALUES ('633', '1', '2', '2', '30216', '58', '1', null, '2016-08-30 23:57:01', null);
INSERT INTO `moa_check` VALUES ('634', '1', '3', '0', '10101', '1', '1', null, '2016-08-31 20:31:07', null);
INSERT INTO `moa_check` VALUES ('635', '1', '3', '0', '10102', '1', '1', null, '2016-08-31 20:31:07', null);
INSERT INTO `moa_check` VALUES ('636', '1', '3', '0', '10103', '1', '1', null, '2016-08-31 20:31:07', null);
INSERT INTO `moa_check` VALUES ('637', '1', '3', '0', '10104', '1', '1', null, '2016-08-31 20:31:07', null);
INSERT INTO `moa_check` VALUES ('638', '1', '3', '0', '10105', '1', '1', null, '2016-08-31 20:31:07', null);

-- ----------------------------
-- Table structure for moa_checkroom
-- ----------------------------
DROP TABLE IF EXISTS `moa_checkroom`;
CREATE TABLE `moa_checkroom` (
  `roomid` int(11) NOT NULL AUTO_INCREMENT COMMENT '课室id',
  `room` varchar(8) NOT NULL DEFAULT 'A205' COMMENT '课室位置',
  `wid` int(11) DEFAULT NULL COMMENT '负责课室助理的wid',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态：\n0 - 正常\n1 - 不存在\n2 - 有故障',
  `description` varchar(128) DEFAULT 'OK' COMMENT '故障说明备注',
  `ipAddress` varchar(20) DEFAULT NULL COMMENT '课室ip地址',
  PRIMARY KEY (`roomid`),
  KEY `wid_idx` (`wid`)
) ENGINE=InnoDB AUTO_INCREMENT=30302 DEFAULT CHARSET=utf8 COMMENT='课室表';

-- ----------------------------
-- Records of moa_checkroom
-- ----------------------------
INSERT INTO `moa_checkroom` VALUES ('10101', 'A101', '1', '0', 'OK', '127.0.0.1');
INSERT INTO `moa_checkroom` VALUES ('10102', 'A102', '1', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('10103', 'A103', '1', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('10104', 'A104', '1', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('10105', 'A105', '1', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30201', 'C201', '2', '0', 'OK', '127.1.1.0');
INSERT INTO `moa_checkroom` VALUES ('30202', 'C202', '2', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30203', 'C203', '2', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30204', 'C204', '2', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30205', 'C205', '2', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30206', 'C206', '2', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30207', 'A401', '4', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30208', 'A402', '4', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30209', 'A403', '4', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30210', 'A404', '4', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30211', 'A405', '4', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30212', 'A201', '7', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30213', 'A202', '7', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30214', 'A203', '7', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30215', 'A301', '7', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30216', 'A302', '7', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30217', 'A204', '9', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30218', 'A207', '9', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30219', 'B303', '9', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30220', 'B304', '9', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30221', 'A306', '9', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30222', 'A501', '13', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30223', 'A502', '13', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30224', 'A503', '13', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30225', 'A504', '13', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30226', 'A505', '13', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30227', 'B101', '15', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30228', 'B102', '15', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30229', 'B103', '15', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30230', 'B104', '15', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30231', 'B201', '15', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30232', 'B202', '15', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30233', 'B203', '17', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30234', 'B204', '17', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30235', 'B205', '17', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30236', 'B301', '17', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30237', 'B302', '17', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30238', 'B401', '19', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30239', 'B402', '19', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30240', 'B403', '19', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30241', 'B501', '19', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30242', 'B502', '19', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30243', 'C101', '21', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30244', 'C102', '21', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30245', 'C103', '21', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30246', 'C104', '21', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30247', 'C105', '21', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30248', 'C301', '25', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30249', 'C302', '25', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30250', 'C303', '25', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30251', 'C304', '25', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30252', 'C305', '27', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30253', 'C401', '27', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30254', 'C402', '27', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30255', 'C403', '27', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30256', 'C404', '27', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30257', 'B503', '29', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30258', 'C501', '29', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30259', 'C502', '29', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30260', 'C503', '29', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30261', 'C504', '29', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30262', 'D101', '31', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30263', 'D102', '31', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30264', 'D103', '31', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30265', 'D104', '31', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30266', 'D205', '31', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30267', 'D201', '33', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30268', 'D202', '33', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30269', 'D203', '33', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30270', 'D204', '33', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30271', 'E201', '33', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30272', 'D301', '35', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30273', 'D302', '35', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30274', 'D303', '35', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30275', 'D304', '35', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30276', 'D401', '35', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30277', 'D402', '37', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30278', 'D403', '37', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30279', 'D501', '37', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30280', 'D502', '37', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30281', 'D503', '37', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30282', 'E101', '39', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30283', 'E103', '39', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30284', 'E104', '39', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30285', 'E105', '39', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30286', 'E205', '39', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30287', 'E202', '41', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30288', 'E203', '41', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30289', 'E204', '41', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30290', 'E302', '41', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30291', 'E303', '41', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30292', 'E304', '43', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30293', 'E305', '43', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30294', 'E403', '43', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30295', 'E404', '43', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30296', 'E405', '43', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30297', 'E402', '45', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30298', 'E502', '45', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30299', 'E503', '45', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30300', 'E504', '45', '0', 'OK', null);
INSERT INTO `moa_checkroom` VALUES ('30301', 'E505', '45', '0', 'OK', null);

-- ----------------------------
-- Table structure for moa_duty
-- ----------------------------
DROP TABLE IF EXISTS `moa_duty`;
CREATE TABLE `moa_duty` (
  `dutyid` int(11) NOT NULL AUTO_INCREMENT COMMENT '值班时段id',
  `weekday` int(11) DEFAULT NULL COMMENT '星期几：1-7',
  `period` int(11) DEFAULT NULL COMMENT '时间段：1-9',
  `wids` varchar(20) NOT NULL COMMENT '正常值班者的wid，以半角逗号分割',
  PRIMARY KEY (`dutyid`)
) ENGINE=InnoDB AUTO_INCREMENT=1026 DEFAULT CHARSET=utf8 COMMENT='常规值班表';

-- ----------------------------
-- Records of moa_duty
-- ----------------------------
INSERT INTO `moa_duty` VALUES ('990', '1', '1', '56');
INSERT INTO `moa_duty` VALUES ('991', '1', '2', '100');
INSERT INTO `moa_duty` VALUES ('992', '1', '3', '93');
INSERT INTO `moa_duty` VALUES ('993', '1', '4', '60');
INSERT INTO `moa_duty` VALUES ('994', '1', '5', '59,60');
INSERT INTO `moa_duty` VALUES ('995', '1', '6', '58');
INSERT INTO `moa_duty` VALUES ('996', '2', '1', '56');
INSERT INTO `moa_duty` VALUES ('997', '2', '2', '60');
INSERT INTO `moa_duty` VALUES ('998', '2', '3', '59');
INSERT INTO `moa_duty` VALUES ('999', '2', '4', '60,61');
INSERT INTO `moa_duty` VALUES ('1000', '2', '5', '58');
INSERT INTO `moa_duty` VALUES ('1001', '2', '6', '57');
INSERT INTO `moa_duty` VALUES ('1002', '3', '1', '58');
INSERT INTO `moa_duty` VALUES ('1003', '3', '2', '58');
INSERT INTO `moa_duty` VALUES ('1004', '3', '3', '59');
INSERT INTO `moa_duty` VALUES ('1005', '3', '4', '58,60');
INSERT INTO `moa_duty` VALUES ('1006', '3', '5', '59');
INSERT INTO `moa_duty` VALUES ('1007', '3', '6', '58');
INSERT INTO `moa_duty` VALUES ('1008', '4', '1', '59');
INSERT INTO `moa_duty` VALUES ('1009', '4', '2', '60');
INSERT INTO `moa_duty` VALUES ('1010', '4', '3', '79');
INSERT INTO `moa_duty` VALUES ('1011', '4', '4', '59');
INSERT INTO `moa_duty` VALUES ('1012', '4', '5', '59');
INSERT INTO `moa_duty` VALUES ('1013', '4', '6', '58');
INSERT INTO `moa_duty` VALUES ('1014', '5', '1', '59');
INSERT INTO `moa_duty` VALUES ('1015', '5', '2', '58');
INSERT INTO `moa_duty` VALUES ('1016', '5', '3', '63');
INSERT INTO `moa_duty` VALUES ('1017', '5', '4', '61');
INSERT INTO `moa_duty` VALUES ('1018', '5', '5', '60');
INSERT INTO `moa_duty` VALUES ('1019', '5', '6', '58');
INSERT INTO `moa_duty` VALUES ('1020', '6', '7', '58');
INSERT INTO `moa_duty` VALUES ('1021', '6', '8', '60,62');
INSERT INTO `moa_duty` VALUES ('1022', '6', '9', '60');
INSERT INTO `moa_duty` VALUES ('1023', '7', '7', '58');
INSERT INTO `moa_duty` VALUES ('1024', '7', '8', '61,62');
INSERT INTO `moa_duty` VALUES ('1025', '7', '9', '59');

-- ----------------------------
-- Table structure for moa_dutyout
-- ----------------------------
DROP TABLE IF EXISTS `moa_dutyout`;
CREATE TABLE `moa_dutyout` (
  `doid` int(11) NOT NULL AUTO_INCREMENT COMMENT '故障出勤id',
  `dutyid` int(11) NOT NULL COMMENT '值班时段id',
  `wid` int(11) NOT NULL DEFAULT '0' COMMENT '出勤者wid，管理员为0',
  `weekcount` varchar(45) NOT NULL COMMENT '第几周发生了这个记录',
  `outtimestamp` datetime NOT NULL COMMENT '时间戳',
  `roomid` int(11) NOT NULL COMMENT '课室id',
  `problemid` int(11) DEFAULT NULL COMMENT '故障描述',
  PRIMARY KEY (`doid`),
  KEY `roomid_idx` (`roomid`),
  KEY `dutyid_idx` (`dutyid`),
  KEY `wid_idx` (`wid`),
  KEY `pid_idx` (`problemid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='值班故障出勤记录';

-- ----------------------------
-- Records of moa_dutyout
-- ----------------------------

-- ----------------------------
-- Table structure for moa_leaderreport
-- ----------------------------
DROP TABLE IF EXISTS `moa_leaderreport`;
CREATE TABLE `moa_leaderreport` (
  `lrid` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL COMMENT '组长wid',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态位：\n0 - 正常\n1 - 已删除',
  `group` int(11) NOT NULL DEFAULT '0' COMMENT '组别：\n0 - N\n1 - A\n2 - B',
  `weekcount` int(11) NOT NULL COMMENT '第几周：1-18',
  `weekday` int(11) NOT NULL COMMENT '星期几：1-5',
  `timestamp` datetime NOT NULL COMMENT '发表时间戳',
  `body` varchar(2560) DEFAULT 'Nothing' COMMENT '坐班日志正文',
  `bestlist` varchar(128) DEFAULT NULL COMMENT '优秀助理wid，以半角逗号分割',
  `badlist` varchar(128) DEFAULT NULL COMMENT '异常助理wid，以半角逗号分割',
  PRIMARY KEY (`lrid`),
  KEY `wid_idx` (`wid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_leaderreport
-- ----------------------------

-- ----------------------------
-- Table structure for moa_log
-- ----------------------------
DROP TABLE IF EXISTS `moa_log`;
CREATE TABLE `moa_log` (
  `logid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dash_wid` int(11) NOT NULL COMMENT '操作人wid',
  `affect_wid` int(11) DEFAULT NULL COMMENT '受影响人wid，如果为空就是批量操作，内容见description',
  `description` varchar(2048) NOT NULL DEFAULT 'nothing' COMMENT '事务记录',
  `logtimestamp` datetime NOT NULL COMMENT '操作时间戳',
  PRIMARY KEY (`logid`),
  KEY `wid_idx` (`dash_wid`,`affect_wid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统日志，包括用户修改、工时变化等';

-- ----------------------------
-- Records of moa_log
-- ----------------------------

-- ----------------------------
-- Table structure for moa_lostfound
-- ----------------------------
DROP TABLE IF EXISTS `moa_lostfound`;
CREATE TABLE `moa_lostfound` (
  `lfid` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL COMMENT '登记人工号id',
  `founder` varchar(45) DEFAULT NULL,
  `state` int(11) NOT NULL COMMENT '状态码：\n0 - 还未被领取\n1 - 已领取',
  `owner_sid` varchar(10) DEFAULT NULL COMMENT '领取人学号',
  `owner_name` varchar(24) DEFAULT NULL COMMENT '领取人姓名',
  `title` varchar(128) NOT NULL COMMENT '拾获物品',
  `description` varchar(1024) DEFAULT NULL COMMENT '物品描述',
  PRIMARY KEY (`lfid`),
  KEY `wid_idx` (`wid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_lostfound
-- ----------------------------

-- ----------------------------
-- Table structure for moa_mbcomment
-- ----------------------------
DROP TABLE IF EXISTS `moa_mbcomment`;
CREATE TABLE `moa_mbcomment` (
  `mbcid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `bpid` int(11) NOT NULL,
  `state` int(11) NOT NULL COMMENT '状态码：\n0 - 正常\n1 - 已删除',
  `uid` int(11) NOT NULL COMMENT '评论人uid',
  `mbctimestamp` datetime NOT NULL COMMENT '评论时间戳',
  `body` varchar(2560) DEFAULT 'Nothing' COMMENT '评论本体',
  PRIMARY KEY (`mbcid`),
  KEY `uid_idx` (`uid`),
  KEY `bpid_idx` (`bpid`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_mbcomment
-- ----------------------------
INSERT INTO `moa_mbcomment` VALUES ('153', '138', '0', '111', '2016-08-28 11:01:50', 'yeah~');

-- ----------------------------
-- Table structure for moa_mmsboard
-- ----------------------------
DROP TABLE IF EXISTS `moa_mmsboard`;
CREATE TABLE `moa_mmsboard` (
  `bpid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '发帖人uid，0则是匿名',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态码：\n0 - 正常\n1 - 被删除',
  `bptimestamp` datetime NOT NULL COMMENT '发帖时间戳',
  `body` varchar(2560) DEFAULT 'nothing',
  PRIMARY KEY (`bpid`),
  KEY `uid_idx` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_mmsboard
-- ----------------------------
INSERT INTO `moa_mmsboard` VALUES ('138', '111', '0', '2016-08-28 10:44:30', '<p>We&nbsp;are&nbsp;伐木累</p>');

-- ----------------------------
-- Table structure for moa_msgcomments
-- ----------------------------
DROP TABLE IF EXISTS `moa_msgcomments`;
CREATE TABLE `moa_msgcomments` (
  `cmid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `state` int(11) NOT NULL COMMENT '状态码：\n0 - 正常\n1 - 已删除',
  `mid` int(11) NOT NULL COMMENT '主信息id',
  `wid` int(11) NOT NULL COMMENT '评论人wid',
  `body` varchar(2560) DEFAULT 'Nothing' COMMENT '评论本体',
  PRIMARY KEY (`cmid`),
  KEY `mid_idx` (`mid`),
  KEY `wid_idx` (`wid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_msgcomments
-- ----------------------------

-- ----------------------------
-- Table structure for moa_notice
-- ----------------------------
DROP TABLE IF EXISTS `moa_notice`;
CREATE TABLE `moa_notice` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL COMMENT '通知发送者wid',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态码:\n0 - 正常\n1 - 已删除',
  `timestamp` datetime NOT NULL COMMENT '发送时间戳',
  `title` varchar(128) DEFAULT 'no title' COMMENT '通知标题',
  `body` varchar(10240) DEFAULT 'nothing' COMMENT '通知内容',
  PRIMARY KEY (`nid`),
  KEY `wid_idx` (`wid`),
  CONSTRAINT `wid` FOREIGN KEY (`wid`) REFERENCES `moa_worker` (`wid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='工作通知';

-- ----------------------------
-- Records of moa_notice
-- ----------------------------
INSERT INTO `moa_notice` VALUES ('21', '1', '0', '2016-08-28 10:54:48', '人工智能 （计算机科学的一个分支）', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人工智能（Artificial&nbsp;Intelligence），英文缩写为AI。它是研究、开发用于模拟、延伸和扩展人的智能的理论、方法、技术及应用系统的一门新的技术科学。&nbsp;人工智能是计算机科学的一个分支，它企图了解智能的实质，并生产出一种新的能以人类智能相似的方式做出反应的智能机器，该领域的研究包括机器人、语言识别、图像识别、自然语言处理和专家系统等。人工智能从诞生以来，理论和技术日益成熟，应用领域也不断扩大，可以设想，未来人工智能带来的科技产品，将会是人类智慧的“容器”。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人工智能是对人的意识、思维的信息过程的模拟。人工智能不是人的智能，但能像人那样思考、也可能超过人的智能。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人工智能是一门极富挑战性的科学，从事这项工作的人必须懂得计算机知识，心理学和哲学。人工智能是包括十分广泛的科学，它由不同的领域组成，如机器学习，计算机视觉等等，总的说来，人工智能研究的一个主要目标是使机器能够胜任一些通常需要人类智能才能完成的复杂工作。但不同的时代、不同的人对这种“复杂工作”的理解是不同的。[1]&nbsp;</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人工智能的定义可以分为两部分，即“人工”和“智能”。“人工”比较好理解，争议性也不大。有时我们会要考虑什么是人力所能及制造的，或者人自身的智能程度有没有高到可以创造人工智能的地步，等等。但总的来说，“人工系统”就是通常意义下的人工系统。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;关于什么是“智能”，就问题多多了。这涉及到其它诸如意识（CONSCIOUSNESS）、自我（SELF）、思维（MIND）（包括无意识的思维（UNCONSCIOUS_MIND））等等问题。人唯一了解的智能是人本身的智能，这是普遍认同的观点。但是我们对我们自身智能的理解都非常有限，对构成人的智能的必要元素也了解有限，所以就很难定义什么是“人工”制造的“智能”了。因此人工智能的研究往往涉及对人的智能本身的研究。其它关于动物或其它人造系统的智能也普遍被认为是人工智能相关的研究课题。</p><p>人工智能在计算机领域内，得到了愈加广泛的重视。并在机器人，经济政治决策，控制系统，仿真系统中得到应用。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;尼尔逊教授对人工智能下了这样一个定义：“人工智能是关于知识的学科――怎样表示知识以及怎样获得知识并使用知识的科学。”而另一个美国麻省理工学院的温斯顿教授认为：“人工智能就是研究如何使计算机去做过去只有人才能做的智能工作。”这些说法反映了人工智能学科的基本思想和基本内容。即人工智能是研究人类智能活动的规律，构造具有一定智能的人工系统，研究如何让计算机去完成以往需要人的智力才能胜任的工作，也就是研究如何应用计算机的软硬件来模拟人类某些智能行为的基本理论、方法和技术。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人工智能是计算机学科的一个分支，二十世纪七十年代以来被称为世界三大尖端技术之一（空间技术、能源技术、人工智能）。也被认为是二十一世纪三大尖端技术（基因工程、纳米科学、人工智能）之一。这是因为近三十年来它获得了迅速的发展，在很多学科领域都获得了广泛应用，并取得了丰硕的成果，人工智能已逐步成为一个独立的分支，无论在理论和实践上都已自成一个系统。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人工智能是研究使计算机来模拟人的某些思维过程和智能行为（如学习、推理、思考、规划等）的学科，主要包括计算机实现智能的原理、制造类似于人脑智能的计算机，使计算机能实现更高层次的应用。人工智能将涉及到计算机科学、心理学、哲学和语言学等学科。可以说几乎是自然科学和社会科学的所有学科，其范围已远远超出了计算机科学的范畴，人工智能与思维科学的关系是实践和理论的关系，人工智能是处于思维科学的技术应用层次，是它的一个应用分支。从思维观点看，人工智能不仅限于逻辑思维，要考虑形象思维、灵感思维才能促进人工智能的突破性的发展，数学常被认为是多种学科的基础科学，数学也进入语言、思维领域，人工智能学科也必须借用数学工具，数学不仅在标准逻辑、模糊数学等范围发挥作用，数学进入人工智能学科，它们将互相促进而更快地发展。[2]&nbsp;</p><p></p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;例如繁重的科学和工程计算本来是要人脑来承担的，如今计算机不但能完成这种计算，而且能够比人脑做得更快、更准确，因此当代人已不再把这种计算看作是“需要人类智能才能完成的复杂任务”，可见复杂工作的定义是随着时代的发展和技术的进步而变化的，人工智能这门科学的具体目标也自然随着时代的变化而发展。它一方面不断获得新的进展，另一方面又转向更有意义、更加困难的目标。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;通常，“机器学习”的数学基础是“统计学”、“信息论”和“控制论”。还包括其他非数学学科。这类“机器学习”对“经验”的依赖性很强。计算机需要不断从解决一类问题的经验中获取知识，学习策略，在遇到类似的问题时，运用经验知识解决问题并积累新的经验，就像普通人一样。我们可以将这样的学习方式称之为“连续型学习”。但人类除了会从经验中学习之外，还会创造，即“跳跃型学习”。这在某些情形下被称为“灵感”或“顿悟”。一直以来，计算机最难学会的就是“顿悟”。或者再严格一些来说，计算机在学习和“实践”方面难以学会“不依赖于量变的质变”，很难从一种“质”直接到另一种“质”，或者从一个“概念”直接到另一个“概念”。正因为如此，这里的“实践”并非同人类一样的实践。人类的实践过程同时包括经验和创造。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;这是智能化研究者梦寐以求的东西。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2013年，帝金数据普数中心数据研究员S.C&nbsp;WANG开发了一种新的数据分析方法，该方法导出了研究函数性质的新方法。作者发现，新数据分析方法给计算机学会“创造”提供了一种方法。本质上，这种方法为人的“创造力”的模式化提供了一种相当有效的途径。这种途径是数学赋予的，是普通人无法拥有但计算机可以拥有的“能力”。从此，计算机不仅精于算，还会因精于算而精于创造。计算机学家们应该斩钉截铁地剥夺“精于创造”的计算机过于全面的操作能力，否则计算机真的有一天会“反捕”人类。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当回头审视新方法的推演过程和数学的时候，作者拓展了对思维和数学的认识。数学简洁，清晰，可靠性、模式化强。在数学的发展史上，处处闪耀着数学大师们创造力的光辉。这些创造力以各种数学定理或结论的方式呈现出来，而数学定理最大的特点就是：建立在一些基本的概念和公理上，以模式化的语言方式表达出来的包含丰富信息的逻辑结构。应该说，数学是最单纯、最直白地反映着（至少一类）创造力模式的学科。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1956年夏季，以麦卡赛、明斯基、罗切斯特和申农等为首的一批有远见卓识的年轻科学家在一起聚会，共同研究和探讨用机器模拟智能的一系列有关问题，并首次提出了“人工智能”这一术语，它标志着“人工智能”这门新兴学科的正式诞生。IBM公司“深蓝”电脑击败了人类的世界国际象棋冠军更是人工智能技术的一个完美表现。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;从1956年正式提出人工智能学科算起，50多年来，取得长足的发展，成为一门广泛的交叉和前沿科学。总的说来，人工智能的目的就是让计算机这台机器能够像人一样思考。如果希望做出一台能够思考的机器，那就必须知道什么是思考，更进一步讲就是什么是智慧。什么样的机器才是智慧的呢？科学家已经作出了汽车，火车，飞机，收音机等等，它们模仿我们身体器官的功能，但是能不能模仿人类大脑的功能呢？到目前为止，我们也仅仅知道这个装在我们天灵盖里面的东西是由数十亿个神经细胞组成的器官，我们对这个东西知之甚少，模仿它或许是天下最困难的事情了。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当计算机出现后，人类开始真正有了一个可以模拟人类思维的工具，在以后的岁月中，无数科学家为这个目标努力着。如今人工智能已经不再是几个科学家的专利了，全世界几乎所有大学的计算机系都有人在研究这门学科，学习计算机的大学生也必须学习这样一门课程，在大家不懈的努力下，如今计算机似乎已经变得十分聪明了。例如，1997年5月，IBM公司研制的深蓝（DEEP&nbsp;BLUE）计算机战胜了国际象棋大师卡斯帕洛夫（KASPAROV）。大家或许不会注意到，在一些地方计算机帮助人进行其它原来只属于人类的工作，计算机以它的高速和准确为人类发挥着它的作用。人工智能始终是计算机科学的前沿学科，计算机编程语言和其它计算机软件都因为有了人工智能的进展而得以存在。</p>');

-- ----------------------------
-- Table structure for moa_nschedule
-- ----------------------------
DROP TABLE IF EXISTS `moa_nschedule`;
CREATE TABLE `moa_nschedule` (
  `nsid` int(11) NOT NULL AUTO_INCREMENT COMMENT '空余时间id',
  `wid` int(11) NOT NULL COMMENT '助理工号id',
  `groupid` varchar(1) NOT NULL COMMENT '组别：A、B、C、N',
  `period` varchar(205) NOT NULL COMMENT '时间段',
  PRIMARY KEY (`nsid`),
  KEY `wid_idx` (`wid`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='空余时间总表';

-- ----------------------------
-- Records of moa_nschedule
-- ----------------------------
INSERT INTO `moa_nschedule` VALUES ('2', '56', 'C', 'MON1,MON2,MON6,FRI1,FRI2,FRI3,FRI4,FRI5');
INSERT INTO `moa_nschedule` VALUES ('3', '57', 'B', 'MON4,MON5,MON6,TUE6,WED4,WED5,WED6,THU5,THU6,FRI4,FRI5,FRI6');
INSERT INTO `moa_nschedule` VALUES ('4', '58', 'C', 'MON1,MON2,MON6,TUE3,WED3,WED6,THU6');
INSERT INTO `moa_nschedule` VALUES ('5', '59', 'C', 'WED6,THU3,THU4,THU5,THU6,FRI3,FRI4,FRI5,FRI6');
INSERT INTO `moa_nschedule` VALUES ('6', '60', 'C', 'THU1,THU2,THU3,THU4,THU5,THU6,FRI1,FRI2,FRI3,FRI4,FRI5,FRI6');
INSERT INTO `moa_nschedule` VALUES ('7', '61', 'C', 'WED6,THU1,THU4,THU5,FRI1,FRI2,FRI6,SAT1,SAT3,SUN1');
INSERT INTO `moa_nschedule` VALUES ('8', '62', 'C', 'SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('9', '63', 'C', 'MON4,MON5,TUE2,TUE3,TUE4,TUE5,THU6,FRI1,FRI2');
INSERT INTO `moa_nschedule` VALUES ('10', '64', 'C', 'MON3,MON4,TUE3,TUE4,WED3,WED4,WED5,THU1,THU2,THU3,FRI2,FRI3,FRI6');
INSERT INTO `moa_nschedule` VALUES ('11', '65', 'B', 'MON5,TUE5,THU4,FRI1,FRI4,FRI5,FRI6');
INSERT INTO `moa_nschedule` VALUES ('12', '66', 'B', 'MON3,TUE4,WED2,WED4,FRI1');
INSERT INTO `moa_nschedule` VALUES ('13', '67', 'B', 'TUE1,TUE2,WED2,WED3,WED6,FRI1,FRI2,FRI3,FRI4,FRI5,FRI6');
INSERT INTO `moa_nschedule` VALUES ('14', '68', 'C', 'MON1,TUE1,TUE5,WED1,WED5,THU1,FRI1');
INSERT INTO `moa_nschedule` VALUES ('15', '69', 'N', 'MON6,TUE1,TUE6,WED3,WED4,WED5,THU3');
INSERT INTO `moa_nschedule` VALUES ('16', '70', 'C', 'FRI1,FRI2,FRI4,FRI5,FRI6,SAT1,SUN1');
INSERT INTO `moa_nschedule` VALUES ('17', '71', 'A', 'TUE6,THU6,FRI3,FRI6');
INSERT INTO `moa_nschedule` VALUES ('18', '72', 'C', 'MON6,TUE6,WED6,THU6,FRI6,SAT1,SAT2,SAT3');
INSERT INTO `moa_nschedule` VALUES ('19', '73', 'C', 'MON6,TUE1,TUE6,WED3,WED6,THU6,FRI6,SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('20', '74', 'C', 'MON1,MON2,MON3,MON4,MON5,WED3,WED4,WED5,WED6,THU1,THU2,THU3,THU4,THU5,THU6,FRI1,FRI2,FRI3,FRI6');
INSERT INTO `moa_nschedule` VALUES ('21', '75', 'C', 'MON2,MON3,MON4,MON5,TUE6,WED4,WED5,WED6,THU1,THU2,THU4,THU5');
INSERT INTO `moa_nschedule` VALUES ('22', '76', 'B', 'MON2,MON3,MON4,TUE2,TUE3,TUE4,WED3,WED4,WED5,WED6,THU2,FRI2,FRI5');
INSERT INTO `moa_nschedule` VALUES ('23', '77', 'A', 'FRI1');
INSERT INTO `moa_nschedule` VALUES ('24', '78', 'A', 'MON4,TUE1,TUE6,WED4,WED5,FRI1');
INSERT INTO `moa_nschedule` VALUES ('25', '79', 'C', 'SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('26', '80', 'C', 'WED6,THU6,FRI4,FRI5,FRI6,SAT1,SAT2,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('27', '81', 'C', 'MON5,MON6,TUE2,WED2,THU2');
INSERT INTO `moa_nschedule` VALUES ('28', '82', 'C', 'MON1,MON6,TUE6,FRI5,FRI6,SAT1,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('29', '83', 'C', 'MON1,MON2,MON3,MON4,MON5,WED1,WED2,WED3,WED4,WED5,THU1,THU2,THU3,THU4,THU5,FRI1,FRI2,FRI3,FRI4,FRI5,SAT1,SAT2,SUN1,SUN2');
INSERT INTO `moa_nschedule` VALUES ('30', '84', 'C', 'SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('31', '85', 'A', 'MON1,MON4,TUE1,TUE4,TUE6');
INSERT INTO `moa_nschedule` VALUES ('32', '86', 'N', 'WED1,FRI1,FRI2,FRI6,SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('33', '87', 'C', 'MON1,MON2,MON3,MON4,MON5,TUE3,TUE6,THU3,FRI1,FRI3,FRI4,FRI5');
INSERT INTO `moa_nschedule` VALUES ('34', '88', 'C', 'TUE1,TUE2,TUE3,TUE4,TUE5,TUE6,WED1,WED2,WED3,WED4,WED5,WED6,SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('35', '89', 'C', 'TUE6,WED1,WED2,THU1,THU2');
INSERT INTO `moa_nschedule` VALUES ('36', '90', 'B', 'MON3,MON6,TUE4,TUE5,THU4,THU5,FRI4,FRI5,FRI6');
INSERT INTO `moa_nschedule` VALUES ('37', '91', 'B', 'MON4,MON5,MON6,TUE2,TUE3,WED4,WED5,WED6,THU6,FRI6,SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('38', '92', 'C', 'MON1,MON2,MON5,TUE6,WED1,WED2,WED3,THU2,THU3,FRI3,FRI4,FRI5,FRI6,SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('39', '93', 'C', 'TUE5,TUE6,WED1,WED4,FRI4,FRI5');
INSERT INTO `moa_nschedule` VALUES ('40', '94', 'C', 'MON6,TUE6,WED6,THU6,FRI6');
INSERT INTO `moa_nschedule` VALUES ('41', '95', 'C', 'MON2,TUE3,WED3,WED4,THU3,THU6,FRI3,FRI4,FRI5,FRI6');
INSERT INTO `moa_nschedule` VALUES ('42', '96', 'C', 'MON5,MON6,TUE3,WED1,WED2,WED3,WED6,THU2,THU3,FRI3,FRI4,FRI5,FRI6,SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');
INSERT INTO `moa_nschedule` VALUES ('43', '97', 'C', 'MON4,WED1,WED2,WED3,THU1,THU2,THU3,FRI1,FRI2,FRI3');
INSERT INTO `moa_nschedule` VALUES ('44', '98', 'B', 'MON6,TUE4,TUE5,THU4,THU5');
INSERT INTO `moa_nschedule` VALUES ('45', '99', 'B', 'MON6,FRI4,FRI5,FRI6,SAT2');
INSERT INTO `moa_nschedule` VALUES ('46', '100', 'A', 'MON3,MON4,MON5,TUE3,WED3,WED4,WED5,THU3,THU4,THU5,THU6,FRI1,FRI2,FRI3,FRI4,FRI5,FRI6,SAT1,SUN1');
INSERT INTO `moa_nschedule` VALUES ('47', '101', 'C', 'TUE2,TUE3,TUE4,TUE5,TUE6,WED2,WED3,WED4,WED5,WED6');
INSERT INTO `moa_nschedule` VALUES ('48', '102', 'C', 'MON3,MON4,MON5,MON6,SAT1,SAT2');
INSERT INTO `moa_nschedule` VALUES ('49', '103', 'C', 'MON3,MON6,TUE1,TUE2,TUE3,WED1,WED2,WED3,WED4,WED5,FRI1,FRI2,FRI3,FRI4,FRI5,FRI6,SAT1,SAT2,SAT3,SUN1,SUN2,SUN3');

-- ----------------------------
-- Table structure for moa_oamessage
-- ----------------------------
DROP TABLE IF EXISTS `moa_oamessage`;
CREATE TABLE `moa_oamessage` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL COMMENT '发信人wid',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态码：\n0 - 正常\n1 - 已删除',
  `visibility` int(11) NOT NULL COMMENT '可见性：\n（管理层可见所有广播）\n0 - 私信\n1 - 所有人广播\n2 - A组广播\n3 - B组广播\n4 - C组广播\n5 - 常检助理广播\n6 - 拍摄组广播\n7 - 管理层可见',
  `timestamp` datetime NOT NULL COMMENT '发表时间戳',
  `receive_uids` varchar(128) DEFAULT NULL COMMENT '收件人uid，以半角逗号分开，只在私信时有效',
  `body` varchar(2560) DEFAULT 'Nothing' COMMENT '私信主体',
  PRIMARY KEY (`mid`),
  KEY `wid_idx` (`wid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_oamessage
-- ----------------------------

-- ----------------------------
-- Table structure for moa_problem
-- ----------------------------
DROP TABLE IF EXISTS `moa_problem`;
CREATE TABLE `moa_problem` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `founder_wid` int(11) NOT NULL,
  `solve_wid` int(11) DEFAULT NULL COMMENT '解决人wid，为空未解决',
  `roomid` int(11) DEFAULT NULL,
  `description` varchar(2048) NOT NULL DEFAULT 'nothing' COMMENT '故障描述',
  `solution` varchar(2048) DEFAULT NULL COMMENT '解决方法',
  `found_time` datetime NOT NULL,
  `solved_time` datetime NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `wid_idx` (`founder_wid`,`solve_wid`),
  KEY `roomid_idx` (`roomid`)
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8 COMMENT='故障表';

-- ----------------------------
-- Records of moa_problem
-- ----------------------------
INSERT INTO `moa_problem` VALUES ('233', '1', null, '10101', '电脑丢失', null, '2016-08-28 17:18:58', '2016-08-28 17:18:58');
INSERT INTO `moa_problem` VALUES ('234', '1', null, '10102', 'rt', null, '2016-08-28 17:24:27', '2016-08-28 17:24:27');
INSERT INTO `moa_problem` VALUES ('235', '1', null, '10101', '好啊', null, '2016-08-30 22:25:00', '2016-08-30 22:25:00');
INSERT INTO `moa_problem` VALUES ('236', '58', null, '30213', '有问题', null, '2016-08-30 23:56:52', '2016-08-30 23:56:52');
INSERT INTO `moa_problem` VALUES ('237', '58', null, '30213', '让人', null, '2016-08-30 23:57:01', '2016-08-30 23:57:01');

-- ----------------------------
-- Table structure for moa_syslog
-- ----------------------------
DROP TABLE IF EXISTS `moa_syslog`;
CREATE TABLE `moa_syslog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '操作类型：\n0 - 常检情况登记\n1 - ',
  PRIMARY KEY (`id`),
  KEY `uid_idx` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_syslog
-- ----------------------------

-- ----------------------------
-- Table structure for moa_user
-- ----------------------------
DROP TABLE IF EXISTS `moa_user`;
CREATE TABLE `moa_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户唯一id',
  `username` varchar(45) NOT NULL COMMENT '登录用户名',
  `password` varchar(45) NOT NULL COMMENT '登录密码',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '用户级别：0 - 普通助理 1 - 组长 2 - 负责人助理 3 - 助理负责人 4 - 管理员 5 - 办公室负责人',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态号：\n0 - 正常\n1 - 锁定\n2 - 已删除',
  `name` varchar(64) NOT NULL DEFAULT 'unknown' COMMENT '用户姓名',
  `description` varchar(64) DEFAULT NULL COMMENT '备注',
  `indate` datetime DEFAULT NULL COMMENT '入职日期',
  `phone` varchar(16) DEFAULT NULL COMMENT '手机号',
  `shortphone` varchar(16) DEFAULT NULL COMMENT '手机短号',
  `address` varchar(64) DEFAULT NULL COMMENT '宿舍号',
  `qq` varchar(16) DEFAULT NULL COMMENT 'QQ号码',
  `wechat` varchar(64) DEFAULT NULL COMMENT '微信id',
  `creditcard` varchar(32) DEFAULT NULL COMMENT '信用卡号',
  `studentid` varchar(16) DEFAULT NULL COMMENT '学号',
  `school` varchar(45) DEFAULT NULL COMMENT '学院',
  `contribution` float NOT NULL DEFAULT '0' COMMENT '历史总工时',
  `totalPenalty` float NOT NULL DEFAULT '0' COMMENT '历史总扣除工时',
  `totalLeave` int(11) NOT NULL DEFAULT '0' COMMENT '历史总请假数',
  `totalAbsence` int(11) NOT NULL DEFAULT '0' COMMENT '历史总旷工数',
  `totalBest` int(11) NOT NULL DEFAULT '0' COMMENT '历史总优秀助理次数',
  `totalBad` int(11) NOT NULL DEFAULT '0' COMMENT '历史总异常助理次数',
  `totalPerfect` int(11) NOT NULL DEFAULT '0' COMMENT '历史总常检优秀数',
  `totalCheck` int(11) NOT NULL DEFAULT '0' COMMENT '总被抽查次数',
  `avatar` varchar(64) NOT NULL DEFAULT 'default.png' COMMENT '头像文件名',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8 COMMENT='系统用户表';

-- ----------------------------
-- Records of moa_user
-- ----------------------------
INSERT INTO `moa_user` VALUES ('111', 'ad', '04d4710a36d3fe01678dacef8349f894', '6', '0', '多媒体er', null, '2012-12-19 15:59:46', '13824421887', '661141', '至善园2号234', '1021265972', 'weixin1021265972', '6216611900010780565', '12330200', '数据科学与计算机学院', '527', '0', '0', '0', '0', '0', '0', '0', '111_20160822221358.png');
INSERT INTO `moa_user` VALUES ('198', 'mms_00', '96e79218965eb72c92a549dd5a330112', '5', '0', '李文杰', null, '2010-06-15 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('203', 'mms01', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '曾敬文', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('204', 'mms02', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '曾振杰', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('205', 'mms03', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '陈靖雯', null, '2016-08-17 00:00:00', null, null, null, null, null, null, null, null, '2', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('206', 'mms04', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '陈思宇', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('207', 'mms05', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '陈甜甜', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('208', 'mms06', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '陈洵', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('209', 'mms07', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '方佳', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('210', 'mms08', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '关欣瑜', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('211', 'mms09', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '郭小兰', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('212', 'mms10', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '洪金城', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('213', 'mms11', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '黄敏怡', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('214', 'mms12', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '黄燕蓝', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('215', 'mms13', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '江科衡', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('216', 'mms14', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '金诚开', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('217', 'mms15', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '亢辈辈', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('218', 'mms16', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '寇桠楠', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('219', 'mms17', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '李超群', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('220', 'mms18', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '李萌', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('221', 'mms19', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '李韋賢', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('222', 'mms20', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '李先明', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('223', 'mms21', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '李子强', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('224', 'mms22', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '练思成', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('225', 'mms23', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '梁飞远', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('226', 'mms24', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '林雨洁', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('227', 'mms25', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '林圳锐', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('228', 'mms26', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '林志远', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('229', 'mms27', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '牛悦', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('230', 'mms28', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '沈阳洋', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('231', 'mms29', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '谭龄', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('232', 'mms30', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '王鉴', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('233', 'mms31', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '吴笛', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('234', 'mms32', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '吴英健', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('235', 'mms33', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '吴玉婷', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('236', 'mms34', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '伍时建', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('237', 'mms35', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '许超凡', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('238', 'mms36', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '杨容', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('239', 'mms37', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '杨治论', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('240', 'mms38', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '尹豪', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('241', 'mms39', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '余安娜', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('242', 'mms40', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '余潮鑫', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('243', 'mms41', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '张明', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('244', 'mms42', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '张文婷', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('245', 'mms43', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '张小鑫', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('246', 'mms44', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '张志坚', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('247', 'mms45', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '张子鹏', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('248', 'mms46', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '张梓灏', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('249', 'mms47', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '钟怡', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('250', 'mms48', '4baaabedbb8ae10ecf210802bfcf5e5d', '0', '0', '周俊晓', null, '2016-08-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');

-- ----------------------------
-- Table structure for moa_worker
-- ----------------------------
DROP TABLE IF EXISTS `moa_worker`;
CREATE TABLE `moa_worker` (
  `wid` int(11) NOT NULL AUTO_INCREMENT COMMENT '工号id，0预留给管理员',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '用户级别：0 - 普通助理 1 - 组长 2 - 负责人助理 3 - 助理负责人 4 - 管理员 5 - 办公室负责人',
  `group` int(11) NOT NULL DEFAULT '0' COMMENT '组别：\n0 - N\n1 - A\n2 - B\n3 - C\n4 - 拍摄\n5 - 网页',
  `worktime` float NOT NULL DEFAULT '0' COMMENT '本月工时',
  `lastmonth` datetime DEFAULT NULL COMMENT '最后一次结算工时的时间',
  `classroom` varchar(64) DEFAULT NULL COMMENT '负责常检课室，以半角逗号分割',
  `week_classroom` varchar(45) DEFAULT NULL COMMENT '负责周检课室，以半角逗号分割',
  `leave` int(11) NOT NULL DEFAULT '0' COMMENT '本月请假次数',
  `absence` int(11) NOT NULL DEFAULT '0' COMMENT '本月旷工次数',
  `penalty` float NOT NULL DEFAULT '0' COMMENT '本月扣除工时',
  `best` int(11) NOT NULL DEFAULT '0' COMMENT '本月获优秀助理次数',
  `bad` int(11) NOT NULL DEFAULT '0' COMMENT '本月获异常助理次数',
  `perfect` int(11) NOT NULL DEFAULT '0' COMMENT '本月常检优秀次数',
  `checks` int(11) NOT NULL DEFAULT '0' COMMENT '本月被抽查次数',
  PRIMARY KEY (`wid`),
  KEY `fk_MOA_Worker_MOA_User_idx` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COMMENT='助理表';

-- ----------------------------
-- Records of moa_worker
-- ----------------------------
INSERT INTO `moa_worker` VALUES ('1', '111', '0', '1', '218', null, 'A101,A102,A103,A104,A105', 'A101,A102', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('51', '198', '5', '0', '0', null, null, null, '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('56', '203', '0', '1', '0', null, 'A101,A102,A103,A104,A105', 'A101,A102', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('57', '204', '0', '1', '0', null, 'A101,A102,A103,A104,A105', 'A103,A104,A105', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('58', '205', '0', '2', '2', null, 'A201,A202,A203,A301,A302', 'A301,A302', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('59', '206', '0', '1', '0', null, 'A201,A202,A203,A301,A302', 'A201,A202,A203', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('60', '207', '0', '1', '0', null, 'A204,A207,B303,B304,A306', 'A204,A207', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('61', '208', '0', '1', '0', null, 'A204,A207,B303,B304,A306', 'B303,B304,A306', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('62', '209', '0', '1', '0', null, 'A401,A402,A403,A404,A405', 'A401,A402', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('63', '210', '0', '1', '0', null, 'A401,A402,A403,A404,A405', 'A403,A404,A405', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('64', '211', '0', '1', '0', null, 'A501,A502,A503,A504,A505', 'A501,A502', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('65', '212', '0', '1', '0', null, 'A501,A502,A503,A504,A505', 'A503,A504,A505', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('66', '213', '0', '1', '0', null, 'B101,B102,B103,B104,B201,B202', 'B101,B102,B103', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('67', '214', '0', '1', '0', null, 'B101,B102,B103,B104,B201,B202', 'B104,B201,B202', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('68', '215', '0', '1', '0', null, 'B203,B204,B205,B301,B302', 'B301,B302', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('69', '216', '0', '1', '0', null, 'B203,B204,B205,B301,B302', 'B203,B204,B205', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('70', '217', '0', '1', '0', null, 'B401,B402,B403,B501,B502', 'B501,B502', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('71', '218', '0', '1', '0', null, 'B401,B402,B403,B501,B502', 'B401,B402,B403', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('72', '219', '0', '1', '0', null, 'C101,C102,C103,C104,C105', 'C101,C102', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('73', '220', '0', '1', '0', null, 'C101,C102,C103,C104,C105', 'C103,C104,C105', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('74', '221', '0', '1', '0', null, 'C202,C203,C204,C205,C206', 'C202,C203', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('75', '222', '0', '1', '0', null, 'C202,C203,C204,C205,C206', 'C204,C205,C206', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('76', '223', '0', '1', '0', null, 'C201,C301,C302,C303,C304', 'C201,C301', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('77', '224', '0', '1', '0', null, 'C201,C301,C302,C303,C304', 'C302,C303,C304', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('78', '225', '0', '1', '0', null, 'C305,C401,C402,C403,C404', 'C305,C404', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('79', '226', '0', '1', '0', null, 'C305,C401,C402,C403,C404', 'C401,C402,C403', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('80', '227', '0', '1', '0', null, 'B503,C501,C502,C503,C504', 'B503,C504', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('81', '228', '0', '1', '0', null, 'B503,C501,C502,C503,C504', 'C501,C502,C503', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('82', '229', '0', '1', '0', null, 'D101,D102,D103,D104,D205', 'D104,D205', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('83', '230', '0', '1', '0', null, 'D101,D102,D103,D104,D205', 'D101,D102,D103', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('84', '231', '0', '1', '0', null, 'D201,D202,D203,D204,E201', 'D201,E201', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('85', '232', '0', '1', '0', null, 'D201,D202,D203,D204,E201', 'D202,D203,D204', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('86', '233', '0', '1', '0', null, 'D301,D302,D303,D304,D401', 'D301,D401', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('87', '234', '0', '1', '0', null, 'D301,D302,D303,D304,D401', 'D302,D303,D304', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('88', '235', '0', '1', '0', null, 'D402,D403,D501,D502,D503', 'D402,D403', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('89', '236', '0', '1', '0', null, 'D402,D403,D501,D502,D503', 'D501,D502,D503', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('90', '237', '0', '1', '0', null, 'E101,E103,E104,E105,E205', 'E105,E205', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('91', '238', '0', '1', '0', null, 'E101,E103,E104,E105,E205', 'E101,E103,E104', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('92', '239', '0', '1', '0', null, 'E202,E203,E204,E302,E303', 'E302,E303', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('93', '240', '0', '1', '0', null, 'E202,E203,E204,E302,E303', 'E202,E203,E204', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('94', '241', '0', '1', '0', null, 'E304,E305,E403,E404,E405', 'E304,E305', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('95', '242', '0', '1', '0', null, 'E304,E305,E403,E404,E405', 'E403,E404,E405', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('96', '243', '0', '1', '0', null, 'E402,E502,E503,E504,E505', 'E402,E502', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('97', '244', '0', '1', '0', null, 'E402,E502,E503,E504,E505', 'E503,E504,E505', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('98', '245', '0', '1', '0', null, '', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('99', '246', '0', '1', '0', null, '', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('100', '247', '0', '1', '0', null, '', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('101', '248', '0', '1', '0', null, '', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('102', '249', '0', '1', '0', null, '', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('103', '250', '0', '1', '0', null, '', '', '0', '0', '0', '0', '0', '0', '0');
