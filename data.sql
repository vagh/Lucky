CREATE TABLE `luck_awards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '名称',
  `year` date DEFAULT NULL COMMENT '工作年限',
  `depart` varchar(160) DEFAULT NULL COMMENT '所属部门',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '中奖类型 1一等奖 2二等奖 3...以此类推',
  `flag` tinyint(1) DEFAULT '0' COMMENT '中奖情况[0 - 未中奖 | 1 - 中奖 ]',
  PRIMARY KEY (`id`),
  KEY `idx_depart` (`depart`,`flag`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=278 DEFAULT CHARSET=utf8 COMMENT='人员列表';

CREATE TABLE `luck_depart` (
  `dname` varchar(100) DEFAULT NULL COMMENT '部门名称',
  `num` smallint(3) unsigned DEFAULT NULL COMMENT '可获奖人数',
  `prize` smallint(3) NOT NULL DEFAULT '0' COMMENT '已中奖人数',
  UNIQUE KEY `idx_depart` (`dname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门中奖率列表';