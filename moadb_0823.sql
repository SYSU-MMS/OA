/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50622
Source Host           : localhost:3306
Source Database       : mydb

Target Server Type    : MYSQL
Target Server Version : 50622
File Encoding         : 65001

Date: 2016-08-23 00:26:17
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
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8 COMMENT='考勤表';

-- ----------------------------
-- Records of moa_attendence
-- ----------------------------


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
) ENGINE=InnoDB AUTO_INCREMENT=591 DEFAULT CHARSET=utf8 COMMENT='课室检查状态表';

-- ----------------------------
-- Records of moa_check
-- ----------------------------


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
) ENGINE=InnoDB AUTO_INCREMENT=990 DEFAULT CHARSET=utf8 COMMENT='常规值班表';

-- ----------------------------
-- Records of moa_duty
-- ----------------------------
INSERT INTO `moa_duty` VALUES ('954', '1', '1', '5,8,9,14');
INSERT INTO `moa_duty` VALUES ('955', '1', '2', '14,17,38');
INSERT INTO `moa_duty` VALUES ('956', '1', '3', '17,22');
INSERT INTO `moa_duty` VALUES ('957', '1', '4', '17,44');
INSERT INTO `moa_duty` VALUES ('958', '1', '5', '44');
INSERT INTO `moa_duty` VALUES ('959', '1', '6', '9,42,44');
INSERT INTO `moa_duty` VALUES ('960', '2', '1', '2,7,8,22');
INSERT INTO `moa_duty` VALUES ('961', '2', '2', '2,43');
INSERT INTO `moa_duty` VALUES ('962', '2', '3', '20,24');
INSERT INTO `moa_duty` VALUES ('963', '2', '4', '20,24,28');
INSERT INTO `moa_duty` VALUES ('964', '2', '5', '18,24');
INSERT INTO `moa_duty` VALUES ('965', '2', '6', '7,13,28,40');
INSERT INTO `moa_duty` VALUES ('966', '3', '1', '6,18,30,34');
INSERT INTO `moa_duty` VALUES ('967', '3', '2', '13,19,32');
INSERT INTO `moa_duty` VALUES ('968', '3', '3', '5,37,39');
INSERT INTO `moa_duty` VALUES ('969', '3', '4', '20,41,42');
INSERT INTO `moa_duty` VALUES ('970', '3', '5', '23,32');
INSERT INTO `moa_duty` VALUES ('971', '3', '6', '7,13,17,19');
INSERT INTO `moa_duty` VALUES ('972', '4', '1', '9,37,43,45');
INSERT INTO `moa_duty` VALUES ('973', '4', '2', '9,45');
INSERT INTO `moa_duty` VALUES ('974', '4', '3', '2,42');
INSERT INTO `moa_duty` VALUES ('975', '4', '4', '2,26');
INSERT INTO `moa_duty` VALUES ('976', '4', '5', '31,36');
INSERT INTO `moa_duty` VALUES ('977', '4', '6', '7,22,26,36');
INSERT INTO `moa_duty` VALUES ('978', '5', '1', '10,34,40,46');
INSERT INTO `moa_duty` VALUES ('979', '5', '2', '5,38,46');
INSERT INTO `moa_duty` VALUES ('980', '5', '3', '5,35');
INSERT INTO `moa_duty` VALUES ('981', '5', '4', '10,27,31');
INSERT INTO `moa_duty` VALUES ('982', '5', '5', '19,27');
INSERT INTO `moa_duty` VALUES ('983', '5', '6', '17,19,21,33');
INSERT INTO `moa_duty` VALUES ('984', '6', '7', '6,16');
INSERT INTO `moa_duty` VALUES ('985', '6', '8', '2,9');
INSERT INTO `moa_duty` VALUES ('986', '6', '9', '2,4,11');
INSERT INTO `moa_duty` VALUES ('987', '7', '7', '12,15');
INSERT INTO `moa_duty` VALUES ('988', '7', '8', '11,15');
INSERT INTO `moa_duty` VALUES ('989', '7', '9', '2,8,29');

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_leaderreport
-- ----------------------------
INSERT INTO `moa_leaderreport` VALUES ('36', '1', '0', '1', '4', '1', '2016-03-14 19:43:48', '<p>1、米玛次仁45分才到公教，且认错态度不好！</p><p></p><p>2、彭琛旷工（这个不说了），引出一个好助理——曾敬文。他在周检很主动帮忙去代检。</p><p></p><p>3、杨治论同学拿着一块抹布擦啊擦，擦啊擦，我都替他辛苦……赞一个！</p><p></p><p>4、早检抽查问题略多：</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;l杨伟成的B205&nbsp;&nbsp;问题一堆，包括投影比例不对，无线麦没有关，麦线没有绕，课件磁盘没有清空，没有签绿板……</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;l李韦贤的B304有线麦声音很奇怪（调过好了），电脑静音</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;l小鑫的D501登记为系统杂音过去发现电脑无声音最后换了麦线</p><p></p><p>5、同时早检发现一堆问题：</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;桠楠没课的课室没开柜门</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;有老助理不知道没课的课室要不要换电池</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新助理（忘了是谁了）第一节没课只是早上有课也开了投影。iPad课室不管三七二十一&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;就开了投影不关。</p><p></p><p>&nbsp;</p><p></p><p>比较好的是早上一群新助理坐在办公桌那里显得很是和谐。还有很多助理表现不错，比如说燕蓝，林圳锐，杨治论，金城开。</p> ## <p>1、彭琛请辞后我让他把今天的工作给完成结果就没后续消息，午检也旷了，晚检也旷了……</p><p></p><p>2、午检发现亚东居然把没课的课室直接给锁了……这老助理也犯这样的错误，羊说得没错，&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我们应该统一没课课室的常检标准。</p><p></p><p>3、新助理除了那么几个杨伟成，次仁，（聂文豪）其他还都挺好的，直接的反应结果就是中午只有一个人微信签到，所有人都回来了，导致的结果就是我从12:30到1:10就只吃了4口饭……</p><p></p><p>4、午检有问题，我还没看到微信呢，卫东就蹭蹭蹭跑过去帮忙解决问题了，积极性太高了！亚东也不错了，前台比较忙，我就直接叫他帮忙去处理问题了！</p> ## <p>1、牛悦代检课室被关，跑遍公教去找楼管真是辛苦了</p><p></p><p>2、我和次仁严肃说明了工作准时负责的重要性，大家继续观察他吧！</p><p></p><p>3、林圳锐走到一饭想起自己还没晚检跑回来晚检，也是够负责的了！</p> ## <p>何卫东&nbsp;&nbsp;&nbsp;太棒了！</p><p>刘亚东&nbsp;&nbsp;&nbsp;也是很棒！</p> ## <p>彭琛&nbsp;&nbsp;唉，别说了。。。</p><p>关欣瑜&nbsp;&nbsp;&nbsp;早检迟到了</p> ## <p>新助理除了个别人（次仁、杨伟成、聂文豪）其他都是很不错的</p><p></p><p>强调一下没有课的课室的常检标准</p><p></p><p>微信签到情况好了很多！</p><p></p><p>彭琛这人，早走早安心！省的天天担心他旷工！</p>', '27,30', '9,43');

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
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_mbcomment
-- ----------------------------


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
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moa_mmsboard
-- ----------------------------


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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='工作通知';

-- ----------------------------
-- Records of moa_notice
-- ----------------------------
INSERT INTO `moa_notice` VALUES ('9', '1', '0', '2016-05-14 20:02:49', '今日头条', '发工资啦');
INSERT INTO `moa_notice` VALUES ('10', '1', '0', '2016-05-14 20:03:32', '今日头条', '发工资啦');
INSERT INTO `moa_notice` VALUES ('11', '1', '0', '2016-05-25 14:55:44', '多媒体清明节假期值班安排', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;教务处教学工作安排：4月4日(星期一)为清明节，4月4日(星期一)清明节放假。</p><p>多媒体清明节假期值班安排如下：</p><p>2015.4.4（星期一）：放假。</p>');
INSERT INTO `moa_notice` VALUES ('12', '1', '0', '2016-05-25 16:22:24', '林佳喉咙痛', '<p>好痛、、阿丹哈佛撒娇的随叫随到</p><p></p>');
INSERT INTO `moa_notice` VALUES ('13', '1', '0', '2016-05-25 16:24:37', '有没有那么一首歌，会让你轻轻跟着和，牵动我们曾经过去，回忆它不会沉默', '<p>有啊有啊~</p>');
INSERT INTO `moa_notice` VALUES ('14', '49', '0', '2016-05-25 16:28:49', '苹果iPhone 7 备货量巨大 准备打脸所有分析师', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;先前有外资预估，iPhone&nbsp;7下半年上市后，至今年底的备货量约6,500万支。实际走访供应链后发现，苹果下达的备货量为7,200万支起跳，追平先前在全球热销的iPhone&nbsp;6系列备货纪录，高标甚至上看7,800万支，优于市场预期。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;苹果今年展开机海战略，预计在9月13日发表下世代旗舰机种，市场盛传为iPhone&nbsp;7、iPhone&nbsp;7&nbsp;Plus以及iPhone&nbsp;7&nbsp;Pro或iPhone&nbsp;7&nbsp;Plus&nbsp;premium。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;据了解，鸿海旗下富士康仍握有iPhone&nbsp;7新机多数组装订单，和硕则取得部分代工单。由于新机机身比前几代更薄，加上有双镜头、及部分玻璃机壳设计，组装难度更高，在苹果登高一呼，要求供应链年底前备足至少7,200万支iPhone&nbsp;7系列新机下，鸿海、和硕角色更吃重。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;因应新机庞大备货需求，富士康周末网站已刊登新人力招募讯息，官方帐号本周末起也连续三天发出招工注意事项。业界预期，从组装厂产线速度而言，关键组件供应商包含大立光、台郡、臻鼎等，6月将开始面对显著增加的拉货需求。业界观察，先前日本熊本地震干扰部分光学组件供应量，使得日系软板供货比重间接下滑，台系供应商供应占比相对提高。</p>');
INSERT INTO `moa_notice` VALUES ('15', '48', '0', '2016-05-25 16:35:34', '2012级本科生毕业论文工作安排（NEW!） ', '<p>各位同学：</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本科生毕业论文（含毕业设计）是本科教学阶段培养学生综合素质与创新、实践能力的重要环节，请同学们严格参照附件《中山大学本科生毕业论文（设计）写作与印制规范》进行撰写。其中对毕业论文（设计）封面、开题报告、过程检查情况记录、学术诚信声明等，学校都有相应要求及模板（详见附件）。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;为加强对毕业论文的全面质量管理，进一步规范毕业论文的写作，现就有关安排通知如下：</p><p></p><p>一、2016年3月31日前——提交论文初稿</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学生提交毕业论文初稿给导师审阅,导师参照《中山大学本科生毕业论文的有关规定》及学院对毕业论文写作要求的相关规定，给出论文的修改意见并反馈给学生。此时的论文初稿不需要上传学院FTP。</p><p></p><p>二、2016年4月20日前——提交论文电子版</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学生根据导师给出的修改意见，对论文做出修改后交给导师，由导师对论文作初步形式审查，并给出论文的评阅意见及初评成绩，由学生提交导师评审后的论文电子版。（具体提交的空间地址是：ftp://my.ss.sysu.edu.cn/~sstheses，学生需把毕业论文（含《数据科学与计算机学院本科生毕业论文形式自查表》）和代码分别压缩上传到相应的专业方向文件夹中，文件名：学号+姓名。学生匿名登录即可上传，只可上传，不可下载、删除、覆盖，学生应通过检查上传后文件的大小判断是否成功上传。若要提交新版本，则应在文件名后加后缀序号再提交新版本（如第二次上传文件名：10382221张某某1，第三次上传：10382221张某某2）。学院会以文件名后最大的序号为最终版本。</p><p></p><p>三、2016年4月30日前——论文形式审查</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学院聘请教学督导员对学生提交的论文电子版进行形式审查（格式、排版等），未通过形式审查的学生请在5月8日前修改论文,并上传修改后的论文。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（在论文上传期限结束之后，管理员将只保留最后一次上传的论文，并重命名为：学号+姓名。）</p><p></p><p>四、2016年5月8日前---提交论文终稿</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学生须按照最后形式审查提出的意见，与导师交流后进行修改完善，重新提交完善后的论文电子版，同时打印、装订论文，在论文相应位置签名，并请导师在纸质版论文上给出评语及签名后，按班级提交给学院教务员。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;对于学生重新提交的论文（含电子版与纸质版），学院还将邀请个别教学督导员进行审查，如果发现学生未对形式审查的意见作相应修改，仍出现形式审查中发现的排版与格式问题，将对该学生的毕业论文作延迟答辩处理。&nbsp;&nbsp;&nbsp;</p><p></p><p>五、2016年5月16日前——公布答辩名单</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学院根据以下范围确定参加论文答辩的学生名单并公布给学生。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、初评成绩为“优秀”的论文必须参加答辩。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、导师认为有必要答辩但又没有初评为“优秀”的论文；导师以书面形式推荐的论文也必须参加答辩。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、对论文终稿进行形式审查的督导员认为有必要答辩的论文。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4、学生对初评成绩有异议者，可以书面方式申请参加答辩，以获得重新评定成绩的机会。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5、由学院在初评成绩为“良好”、“中等”和“及格”的论文中随机抽取30%的论文参加答辩。</p><p></p><p>六、2016年5月19~20日——学院组织论文答辩</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;毕业论文答辩是重要的本科教学环节，学生无正当理由缺席答辩者，一律按“不及格”评定毕业论文成绩；实习、找工作、试用期等，均不成为申请不答辩的正当理由。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;没有按时上传论文电子版及终稿者，论文成绩一律评定为“不及格”。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学生如因有特殊情况不能参加答辩，须至少提前3天提出书面申请，填写《数据科学与计算机学院本科生毕业论文免答辩申请表》，并附上证明材料交学院本科教务办，经学院主管教学的领导批准方可不参加答辩。获准不参加论文答辩者，其论文的最终成绩不得评为“优秀”，最终成绩由学院组织的教学督导员审核后确定。未获批准而不参加论文答辩者，论文成绩一律评定为“不及格”。</p><p></p>');
INSERT INTO `moa_notice` VALUES ('16', '1', '0', '2016-05-25 16:37:25', '数据科学与计算机学院2016年接收转专业学生面试通知', '<p>致申请转入我院软件工程、计算机类专业的同学：</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我院定于2016年5月9日（周一）下午1:30对申请转入学生进行面试，面试共分三组进行(A201，A202，A203)，分组名单到场公布。请同学们当天1:15到学院大楼A101讲学厅报到（出示有效证件）。面试名单请查看附件：</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;附件1：2016年接收转入数据科学与计算机学院计算机类专业学生面试名单（公布）</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;附件2：2016年接收转入数据科学与计算机学院软件工程专业学生面试名单（公布）</p><p></p>');
INSERT INTO `moa_notice` VALUES ('17', '48', '0', '2016-05-25 16:38:27', '学校党委陈春声书记到我院调研指导党建工作', '<p>5月11日下午，学校党委陈春声书记一行到我院调研党建工作。校党委办公室主任陈险峰、校党委学生工作部部长莫华、校纪委办公室副主任胡国方、校党委组织部副部长郭予填、校党委宣传部新闻秘书黄爱成等陪同调研。</p><p></p><p>我院党委书记谢曼华，院长钱德沛，副院长马啸、杨宏奇、肖侬，党委副书记谭英耀，院长助理韦宝典，广州超算中心主任卢宇彤等党政领导班子成员及学院各教工党支部书记、部分党员代表参加了会议。</p><p></p><p>DSC_8924</p><p></p><p>陈春声书记调研我院党建工作座谈会现场</p><p></p><p>谢曼华书记围绕学院党建工作基本情况及主要特色、意识形态与文化建设工作、党风廉政建设、人才引进工作、加强人才培养等5方面的内容做了专题汇报。</p><p></p><p>DSC_8945</p><p></p><p>谢曼华书记作报告</p><p></p><p>与会人员就如何加强和改进学院党建工作、学院党委应如何为高质量地完成人才培养、科学研究、学科建设、人才队伍建设等中心工作提供服务支持和组织保障展开了热烈讨论，并提出了宝贵意见。</p><p></p><p>DSC_8957</p><p></p><p>钱德沛院长发言</p><p></p><p>陈春声书记在听取汇报和讨论后做了总结讲话。他对我院的党建工作做了充分肯定，认为学院党委在学院整合和组建过程中发挥了积极的作用；赞赏我院党政领导班子团结、进取、有为，能坚持党政联席会制度，为学院发展提供了良好的制度保障，学院人才引进及培育初见成效。</p><p></p><p>DSC_8998</p><p></p><p>陈春声书记讲话</p><p></p><p>同时，陈春声书记也对学院的党建工作提出了四点希望：一是希望党政领导班子要更加牢固地树立党建主业意识，加强教师党员发展、廉政风险防控以及党建制度建设；二是希望学院加大力度引进和培育优秀人才；三是希望学院实现计算机学科水平的跨越式发展；四是主动关注并适应学校建设布局调整及综合改革的态势，在学校改革发展中主动寻求机会和空间。（黄玲娟）</p><p></p>');
INSERT INTO `moa_notice` VALUES ('18', '1', '0', '2016-05-25 16:39:09', '学术报告：中国计算机学会(CCF)走进中山大学', '<p>学术报告：中国计算机学会(CCF)走进中山大学</p><p></p><p>题目：漫谈论文质量与学术评价-兼谈为什么对研究生毕业发表论文要制定标准？</p><p></p><p>报告人：杨士强教授，清华大学</p><p></p><p>时间：&nbsp;5月15日（周日）&nbsp;&nbsp;晚上&nbsp;7:00&nbsp;-&nbsp;8:00</p><p></p><p>地点：中山大学东校区数据科学与计算机学院A101</p><p></p><p>报告摘要：</p><p></p><p>研究生是学校学科建设的生力军，特别是博士研究生的培养质量是学术水平的重要体现。为了鼓励研究生发表高水平学术论文，提高研究生学术水平，中国计算机学会&nbsp;（CCF）制定了针对不同学科方向的学术期刊和会议列表。</p><p></p><p>本报告中，讲者将结合在学位分委员会主席岗位上遇到的实际问题，有针对性地解答如何提高研究生的学术追求？如何选拔与培养博士生？为什么要对博士生毕业要求制定标准等问题。</p><p></p><p>报告人简介：</p><p></p><p>杨士强教授，清华大学，博士生导师。&nbsp;“CCF走进高校”特邀讲者、CCF杰出演讲者、CCF监事长；清华大学计算机系学位分委员会主席、国家级计算机实验教学示范中心主任；研究领域为多媒体技术与系统，曾担任CCF多媒体技术专委会主任，CCF理事。IEEE高级会员，参与组织多次国内外学术会议，曾获IEEE&nbsp;TCVST、ACM&nbsp;MM等国际期刊、会议最佳论文奖；获北京市师德先进个人、教学名师等称号。</p><p></p>');
INSERT INTO `moa_notice` VALUES ('19', '49', '0', '2016-05-25 16:39:54', '学术报告：基于可能性测度的计算树逻辑模型检测', '<p>题目:</p><p></p><p>基于可能性测度的计算树逻辑模型检测</p><p></p><p></p><p>摘要：</p><p></p><p>信息系统的功能正确性验证和性能可满足性验证是信息系统可信性的重要方面。模型检测是一种很重要的自动化验证技术，是形式化验证的一种主要研究方向，而量化模型检测是当前模型检测技术的一种主要研究分支，形成信息系统的功能正确性验证和性能可满足性验证的主要方法之一。本报告将主要讲述新近提出的基于可能性测度的模型检测方法—基于广义可能性测度的计算树逻辑(CTL)模型检测，它是和概率模型检测互补的一种模型检测方法。我们提出了基于广义可能性测度的CTL模型检测方法：模型用广义可能性Kripke结构表示，性质用广义可能性计算树逻辑（CTL）表示，证明了广义可能性CTL在表达能力方面强于经典CTL，模型检测算法采用矩阵运算，其具有多项式时间复杂性。</p><p></p><p></p><p></p><p>李永明简介</p><p></p><p></p><p>1966年3月生，陕西省大荔县人，教授，博士生导师。</p><p></p><p>主要研究方向：非经典计算理论、定量模型检测、计算智能、量子信息学、格上拓扑学。</p><p></p><p>2001年国务院政府特殊津贴获得者，2002教育部第三届“高校青年教师奖”（教育部高层次人才奖励计划），陕西省三秦人才津贴获得者。担任国际IEEE计算智能模糊系统技术委员会委员，中国系统工程学会模糊数学与模糊系统委员会副主任委员，全国运筹学会智能计算学会副理事长，全国高等师范学校计算机教育委员会副理事长。</p><p></p><p></p><p></p><p>时间：&nbsp;5月19号（周四）上午10点</p><p></p><p>地点：数据科学与计算机学院A201</p>');
INSERT INTO `moa_notice` VALUES ('20', '1', '0', '2016-05-27 02:15:30', '美丽人生', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;林语堂给人生列出了几个公式：</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1)Reality&nbsp;—&nbsp;Dreams&nbsp;＝&nbsp;Animal&nbsp;Being</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2)Reality&nbsp;＋&nbsp;Dreams&nbsp;＝A&nbsp;heartache(usually&nbsp;called&nbsp;Idealism)</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3)Reality&nbsp;＋&nbsp;Humor&nbsp;＝&nbsp;Realism(also&nbsp;called&nbsp;Conservatism)</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4)Dreams&nbsp;－&nbsp;Humor&nbsp;＝&nbsp;Fanaticism</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5)Dreams&nbsp;＋&nbsp;Humor&nbsp;＝&nbsp;Fantasy</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6)Reality&nbsp;＋&nbsp;Dreams&nbsp;＋&nbsp;Humor&nbsp;＝&nbsp;Wisdom</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;他把他心目中理想的人生设想成R3D2H3S2的人，就是有三分现实主义，两份理想主义，三分幽默（自嘲），两分多愁善感的人。数字表示程度，4为最高级。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guido，我把他看作是H4的人物。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;这是一个关于H4人的传说。</p><p></p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;这部片子，我看得泣不成声，心情却是一直很舒服很舒服。我欣赏那些将悲伤和灾难当笑话的人，或者更应该用崇敬这个词来形容。他人说，不可以凭名字来猜测一部片子的内容，这个快乐的传说根本不快乐。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;不是的，不是。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我从来没有看过这么快乐的片子，还有其它比儿子的世界更好的角度去看纳粹么？</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;一个游戏。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是个“快乐”的二战。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;儿子那个看到真坦克的表情，我想我一辈子都不会忘记。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;这种被精心保护的快乐心灵，这样伟大的父爱，这种胆敢对苦难用游戏来掩饰，有乐观来面对的人。读了这个传说，我们哭泣着快乐。</p><p></p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guido，杀不住车，被当成纳粹军首领被欢迎</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guido，随口掰自己是个王子，将要会见公主，就接住了从天而降的公主</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guido，用机智骗倒审视官，装成他在宣扬民族主义的场合上大闹一通</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guido，曲解叔本华的理论，用意念唤得公主一瞥</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guido，下雨天的红地毯，从天而降的钥匙，适当时候被换回来的帽子，他那段真情表白，顶着贵宾犬的盘子，直到他骑着青马像一个真的王子出场，把公主偷走。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;以上没有一处不是让人忍俊不禁，对其胆大妄为，出奇的好运气，以及幽默式智慧的感叹。Guido从来没有像一个真正的王子出现，每一处他的处境都有尴尬之处，都有为难之点，而他从不以为然，用一种幽默自嘲而不失尊严的态度处理。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;故事的前半段，我只看到了在和平社会中爱情。认为Guido更多的像一个小丑而不是一个王子，这段爱情更多的像一个欺骗人的童话而不是现实，公主喜欢的更多的是一时的幻想性的感动而不是长久现实的考虑。那时的我没有看明白这个传说，其实是关于一个Humor4人的传记。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当灾难降临的时候，生活中最强悍的感情是Humor。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我以为面对困苦，最普通的反应是怨天尤人，是抱怨生活的不幸，悲苦命运的不公。这是平常人。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;优之为默然处之，安之若素，这样的人可以被称赞包容度大，忍耐力强。这是忍士，我们称其坚忍不拔。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;再优之是不畏困难，奋力反抗，不承认世间的非人道。这是勇士，是战士，是那些最终可能改变历史的人，我们或称其为英雄，或称尊其为领袖。像斯巴达克领导斗兽场的人们起义那样。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;还有一种人，他没有强大的征服和领导欲望，他没有成为大人物的愿望，他只是当他的小市民，希望自己的家人幸福安康。同时，他的H值，教他对现实种种灾难无畏。他没有干上大事情，却用他的精神力量，成为最伟大的人。H4的人有最强悍的心灵，就像Guido。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我不知道还有什么，比一个彻底了解集中营现实境况的父亲，用各种方法去保护自己孩子的心灵更伟大的举动。比一个能够冒着生命危险给自己妻子带去安慰的丈夫更完美的角色。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guido之前的小丑感彻底淡去，展现在眼前的是一个伟大的父亲和丈夫。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;他为了令儿子相信所有的痛苦只是一个游戏的种种，为报平安的广播，为妻子播出的歌剧。都只有他才做得出来，这里面有小聪明，更有敢于嘲笑生活的心理，这是一种humor，虽然我无法用词汇很好的表达这种态度。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;可以说，Guido的离开，我是大大的愣住了。我以为他这般的幸运，这般的才智，这个传说，总是会为他设置一个happy&nbsp;ending的。林语堂含义里头的humor是跟reality联系在一起的。没有看到残酷的现实，我们并不会懂得humor。所以这部剧给了我们一个小小残忍的玩笑，那个最乐观的人，死去了，最终成为一个传说。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;在这部久仰大名的片子里头，噼里啪啦的哭泣，我始终是快乐的，并且感悟到H在我们生活中的无与伦比的地位。</p>');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='空余时间总表';

-- ----------------------------
-- Records of moa_nschedule
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8 COMMENT='故障表';

-- ----------------------------
-- Records of moa_problem
-- ----------------------------


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
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8 COMMENT='系统用户表';

-- ----------------------------
-- Records of moa_user
-- ----------------------------
INSERT INTO `moa_user` VALUES ('111', 'ad', '523af537946b79c4f8369ed39ba78605', '6', '0', '林伟彬', null, '2012-12-19 15:59:46', '13824421887', '661141', '至善园2号234', '1021265972', 'weixin1021265972', '6216611900010780565', '12330200', '数据科学与计算机学院', '519', '0', '0', '0', '0', '0', '0', '0', '111_20160822221358.png');
INSERT INTO `moa_user` VALUES ('112', 'as', '523af537946b79c4f8369ed39ba78605', '0', '0', '云过', null, null, '13000000000', '663344', '二二34', '23424325', '24352打个饭', '1214141421424323333', '34234', '广东工大', '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('126', 'mms_01', '96e79218965eb72c92a549dd5a330112', '1', '0', '陈晓丽', null, '2011-11-09 00:00:00', '13570402091', '632091', '', '', '', '6216343453445354664', '', '', '278.5', '0', '0', '0', '0', '0', '0', '0', '126_20160321015538.png');
INSERT INTO `moa_user` VALUES ('127', 'mms_02', '96e79218965eb72c92a549dd5a330112', '1', '0', '林佳', null, '2013-03-12 00:00:00', '13632459711', '669711', '至善园2号234', '7482780', 'rinkako', '6216611900010779888', '12330198', '数据科学与计算机学院', '0', '0', '0', '0', '0', '0', '0', '0', '127_20160322170658.png');
INSERT INTO `moa_user` VALUES ('151', 'mms_04', '96e79218965eb72c92a549dd5a330112', '3', '0', '林嘉欣', null, '2016-02-15 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('152', 'mms_08', '96e79218965eb72c92a549dd5a330112', '0', '0', '奥巴马', null, '2016-02-15 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('153', 'mms_11', '96e79218965eb72c92a549dd5a330112', '0', '2', '李先明', null, '2016-02-08 00:00:00', '13888888888', '888888', '', '34343', 'sdfs1231', '', '1455555', '', '1', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('154', 'mms_12', '96e79218965eb72c92a549dd5a330112', '0', '0', '李荷', null, '2016-02-05 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('155', 'mms_13', '96e79218965eb72c92a549dd5a330112', '0', '0', '李梓茵', null, '2016-01-31 00:00:00', null, null, null, null, null, null, null, null, '3.5', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('156', 'mms_14', '96e79218965eb72c92a549dd5a330112', '0', '0', '曾振杰', null, '2015-12-29 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('157', 'mms_15', '96e79218965eb72c92a549dd5a330112', '0', '0', '关欣瑜', null, '2016-01-08 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('158', 'mms_16', '96e79218965eb72c92a549dd5a330112', '0', '0', '张子鹏', null, '2016-01-04 00:00:00', null, null, null, null, null, null, null, null, '4', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('159', 'mms_17', '96e79218965eb72c92a549dd5a330112', '0', '0', '余安娜', null, '2016-01-13 00:00:00', '', '', '', '', '', '6216234242893483733', '', '', '113', '6.5', '0', '0', '0', '0', '0', '0', '159_20160321015301.png');
INSERT INTO `moa_user` VALUES ('160', 'mms_18', '96e79218965eb72c92a549dd5a330112', '0', '0', '蔡双棋', null, '2015-12-27 00:00:00', '', '', '', '', '', '', '', '', '10.5', '0', '0', '0', '0', '0', '0', '0', '160_20160821190424.png');
INSERT INTO `moa_user` VALUES ('161', 'mms_19', '96e79218965eb72c92a549dd5a330112', '0', '0', '张梓灏', null, '2015-12-21 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('162', 'mms_20', '96e79218965eb72c92a549dd5a330112', '0', '0', '吴玉婷', null, '2016-01-01 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('163', 'mms_21', '96e79218965eb72c92a549dd5a330112', '0', '0', '沈阳洋', null, '2015-12-28 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('164', 'mms_22', '96e79218965eb72c92a549dd5a330112', '0', '0', '李超群', null, '2015-12-10 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('165', 'mms_23', '96e79218965eb72c92a549dd5a330112', '0', '0', '陈靖雯', null, '2016-01-05 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('166', 'mms_24', '96e79218965eb72c92a549dd5a330112', '0', '0', '张文婷', null, '2016-02-05 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('167', 'mms_25', '96e79218965eb72c92a549dd5a330112', '0', '0', '钟怡', null, '2016-03-07 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('168', 'mms_26', '96e79218965eb72c92a549dd5a330112', '0', '0', '林志远', null, '2016-04-08 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('169', 'mms_27', '96e79218965eb72c92a549dd5a330112', '0', '0', '刑宇静', null, '2016-01-12 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('170', 'mms_28', '96e79218965eb72c92a549dd5a330112', '0', '0', '余湖鑫', null, '2015-12-27 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('171', 'mms_29', '96e79218965eb72c92a549dd5a330112', '0', '0', '林雨洁', null, '2015-11-30 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('172', 'mms_30', '96e79218965eb72c92a549dd5a330112', '0', '0', '蓝秉南', null, '2015-10-26 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('173', 'mms_31', '96e79218965eb72c92a549dd5a330112', '0', '0', '郭小兰', null, '2015-09-29 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('174', 'mms_32', '96e79218965eb72c92a549dd5a330112', '0', '0', '黄敏怡', null, '2015-08-31 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('175', 'mms_33', '96e79218965eb72c92a549dd5a330112', '0', '0', '刘亚东', null, '2015-07-27 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('176', 'mms_34', '96e79218965eb72c92a549dd5a330112', '0', '0', '谭杰雄', null, '2015-06-30 00:00:00', null, null, null, null, null, null, null, null, '5', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('177', 'mms_35', '96e79218965eb72c92a549dd5a330112', '0', '0', '吴笛', null, '2015-06-03 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('178', 'mms_36', '96e79218965eb72c92a549dd5a330112', '0', '0', '何卫东', null, '2015-06-25 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('179', 'mms_37', '96e79218965eb72c92a549dd5a330112', '0', '0', '王鉴', null, '2015-06-23 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('180', 'mms_38', '96e79218965eb72c92a549dd5a330112', '0', '0', '张承灏', null, '2015-07-02 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('181', 'mms_39', '96e79218965eb72c92a549dd5a330112', '0', '0', '许超凡', null, '2015-08-06 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('182', 'mms_40', '96e79218965eb72c92a549dd5a330112', '0', '0', '周俊晓', null, '2015-09-02 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('183', 'mms_41', '96e79218965eb72c92a549dd5a330112', '0', '0', '江浩', null, '2015-10-08 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('184', 'mms_42', '96e79218965eb72c92a549dd5a330112', '0', '0', '尹豪', null, '2015-09-22 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('185', 'mms_43', '96e79218965eb72c92a549dd5a330112', '0', '0', '胡倩榕', null, '2015-09-30 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('186', 'mms_44', '96e79218965eb72c92a549dd5a330112', '0', '0', '童辉祁', null, '2015-10-01 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('187', 'mms_45', '96e79218965eb72c92a549dd5a330112', '0', '0', '亢辈辈', null, '2015-11-04 00:00:00', null, null, null, null, null, null, null, null, '7.5', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('188', 'mms_46', '96e79218965eb72c92a549dd5a330112', '0', '0', '洪振伟', null, '2015-11-04 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('189', 'mms_47', '96e79218965eb72c92a549dd5a330112', '0', '0', '梁飞远', null, '2015-12-02 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('190', 'mms_48', '96e79218965eb72c92a549dd5a330112', '0', '0', '张小鑫', null, '2016-01-06 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('191', 'mms_49', '96e79218965eb72c92a549dd5a330112', '0', '0', '彭琛', null, '2016-02-02 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('192', 'mms_50', '96e79218965eb72c92a549dd5a330112', '0', '0', '陈思宇', null, '2016-02-26 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('193', 'mms_51', '96e79218965eb72c92a549dd5a330112', '0', '0', '张志坚', null, '2016-02-26 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('194', 'mms_52', '96e79218965eb72c92a549dd5a330112', '0', '0', '伍时建', null, '2016-02-16 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('197', 'mms_05', '96e79218965eb72c92a549dd5a330112', '1', '2', '方佳', null, '2014-06-24 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('198', 'mms_00', '96e79218965eb72c92a549dd5a330112', '5', '0', '李文杰', null, '2010-06-15 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');
INSERT INTO `moa_user` VALUES ('199', 'mms_88', '96e79218965eb72c92a549dd5a330112', '4', '2', '曾子俊', null, '2013-06-18 00:00:00', null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', '0', '0', '0', 'default.png');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='助理表';

-- ----------------------------
-- Records of moa_worker
-- ----------------------------
INSERT INTO `moa_worker` VALUES ('1', '111', '0', '1', '210', null, 'A101,A102,A103,A104,A105', 'A101,A102', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('2', '112', '0', '2', '0', null, 'C201,C202,C203,C204,C205,C206', 'C201,C202,C203', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('4', '152', '0', '2', '0', null, 'A401,A402,A403,A404,A405', 'A403,A404,A405', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('5', '153', '0', '1', '1', null, 'A101,A102,A103,A104,A105', 'A101,A102', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('6', '154', '0', '2', '0', null, 'A101,A102,A103,A104,A105', 'A103,A104,A105', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('7', '155', '0', '1', '3.5', null, 'A201,A202,A203,A301,A302', 'A301,A302', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('8', '156', '0', '2', '0', null, 'A201,A202,A203,A301,A302', 'A201,A202,A203', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('9', '157', '0', '1', '0', null, 'A204,A207,B303,B304,A306', 'A204,A207', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('10', '158', '0', '2', '4', null, 'A204,A207,B303,B304,A306', 'B303,B304,A306', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('11', '159', '0', '1', '73', null, 'A401,A402,A403,A404,A405', 'A401,A402', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('12', '160', '0', '2', '10.5', null, 'A401,A402,A403,A404,A405', 'A403,A404,A405', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('13', '161', '0', '1', '0', null, 'A501,A502,A503,A504,A505', 'A501,A502', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('14', '162', '0', '2', '0', null, 'A501,A502,A503,A504,A505', 'A503,A504,A505', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('15', '163', '0', '1', '0', null, 'B101,B102,B103,B104,B201,B202', 'B101,B102,B103', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('16', '164', '0', '2', '0', null, 'B101,B102,B103,B104,B201,B202', 'B104,B201,B202', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('17', '165', '0', '1', '0', null, 'B203,B204,B205,B301,B302', 'B301,B302', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('18', '166', '0', '2', '0', null, 'B203,B204,B205,B301,B302', 'B203,B204,B205', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('19', '167', '0', '1', '0', null, 'B401,B402,B403,B501,B502', 'B501,B502', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('20', '168', '0', '2', '0', null, 'B401,B402,B403,B501,B502', 'B401,B402,B403', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('21', '169', '0', '1', '0', null, 'C101,C102,C103,C104,C105', 'C101,C102', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('22', '170', '0', '2', '0', null, 'C101,C102,C103,C104,C105', 'C103,C104,C105', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('23', '171', '0', '1', '0', null, 'C202,C203,C204,C205,C206', 'C202,C203', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('24', '172', '0', '2', '0', null, 'C202,C203,C204,C205,C206', 'C204,C205,C206', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('25', '173', '0', '1', '0', null, 'C201,C301,C302,C303,C304', 'C201,C301', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('26', '174', '0', '2', '0', null, 'C201,C301,C302,C303,C304', 'C302,C303,C304', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('27', '175', '0', '1', '0', null, 'C305,C401,C402,C403,C404', 'C305,C404', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('28', '176', '0', '2', '5', null, 'C305,C401,C402,C403,C404', 'C401,C402,C403', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('29', '177', '0', '1', '0', null, 'B503,C501,C502,C503,C504', 'B503,C504', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('30', '178', '0', '2', '0', null, 'B503,C501,C502,C503,C504', 'C501,C502,C503', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('31', '179', '0', '1', '0', null, 'D101,D102,D103,D104,D205', 'D104,D205', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('32', '180', '0', '2', '0', null, 'D101,D102,D103,D104,D205', 'D101,D102,D103', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('33', '181', '0', '1', '0', null, 'D201,D202,D203,D204,E201', 'D201,E201', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('34', '182', '0', '2', '0', null, 'D201,D202,D203,D204,E201', 'D202,D203,D204', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('35', '183', '0', '1', '0', null, 'D301,D302,D303,D304,D401', 'D301,D401', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('36', '184', '0', '2', '0', null, 'D301,D302,D303,D304,D401', 'D302,D303,D304', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('37', '185', '0', '1', '0', null, 'D402,D403,D501,D502,D503', 'D402,D403', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('38', '186', '0', '2', '0', null, 'D402,D403,D501,D502,D503', 'D501,D502,D503', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('39', '187', '0', '1', '7.5', null, 'E101,E103,E104,E105,E205', 'E105,E205', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('40', '188', '0', '2', '0', null, 'E101,E103,E104,E105,E205', 'E101,E103,E104', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('41', '189', '0', '1', '0', null, 'E202,E203,E204,E302,E303', 'E302,E303', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('42', '190', '0', '2', '0', null, 'E202,E203,E204,E302,E303', 'E202,E203,E204', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('43', '191', '0', '1', '0', null, 'E304,E305,E403,E404,E405', 'E304,E305', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('44', '192', '0', '2', '0', null, 'E304,E305,E403,E404,E405', 'E403,E404,E405', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('45', '193', '0', '1', '0', null, 'E402,E502,E503,E504,E505', 'E402,E502', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('46', '194', '0', '2', '0', null, 'E402,E502,E503,E504,E505', 'E503,E504,E505', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('47', '197', '1', '0', '0', null, null, null, '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('48', '126', '1', '0', '63', null, null, null, '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('49', '127', '1', '0', '0', null, null, null, '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('50', '151', '3', '0', '0', null, null, null, '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('51', '198', '5', '0', '0', null, null, null, '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('52', '199', '4', '0', '0', null, null, null, '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('53', '200', '1', '0', '0', null, null, null, '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `moa_worker` VALUES ('54', '201', '2', '0', '0', null, null, null, '0', '0', '0', '0', '0', '0', '0');
