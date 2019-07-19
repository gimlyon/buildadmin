CREATE TABLE `ba_douyin_gift_rank` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `display_id` varchar(50) DEFAULT NULL COMMENT '抖音号',
  `short_id` bigint(30) unsigned DEFAULT NULL COMMENT '抖音ID',
  `room_id` bigint(30) unsigned DEFAULT NULL COMMENT '直播间ID',
  `nickname` varchar(100) DEFAULT NULL COMMENT '昵称',
  `rank` int(10) unsigned DEFAULT NULL COMMENT '排行',
  `score` int(10) unsigned DEFAULT NULL COMMENT '音浪',
  `avatar_thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '头像',
  `icon_level` varchar(100) NOT NULL DEFAULT '' COMMENT '等级图',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `state` enum('1','2') NOT NULL DEFAULT '1' COMMENT '状态:1=显示,2=隐藏',
  `ranktime` int(10) unsigned DEFAULT NULL COMMENT '榜单时间',
  `createtime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='抖音礼物榜表';

CREATE TABLE `uct_waste_warehouse` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) unsigned DEFAULT NULL COMMENT '负责人ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '仓库ID',
  `branch_id` int(10) unsigned NOT NULL COMMENT '分部ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `province` varchar(50) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(50) NOT NULL DEFAULT '' COMMENT '城市',
  `area` varchar(50) NOT NULL DEFAULT '' COMMENT '区域',
  `detail_address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `state` enum('1','0') NOT NULL DEFAULT '1' COMMENT '状态:1=启用,0=禁用',
  `createtime` int(10) unsigned NULL COMMENT '创建时间',
  `updatetime` int(10) unsigned NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='绿环仓库和分拣点表';

CREATE TABLE `uct_waste_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `standard_price` float(10,2) DEFAULT NULL COMMENT '标准报价(元/kg)',
  `presell_price` float(10,2) DEFAULT NULL COMMENT '预售价(元/kg)',
  `risk_cost` float(10,2) DEFAULT NULL COMMENT '风险成本(元/kg)',
  `image` varchar(100) DEFAULT NULL COMMENT '图片',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `state` enum('1','0') NOT NULL DEFAULT '1' COMMENT '状态:1=启用,0=禁用',
  `createtime` int(10) unsigned NULL COMMENT '创建时间',
  `updatetime` int(10) unsigned NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='废料分类表';

CREATE TABLE `uct_waste_cate_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作者ID',
  `cate_id` int(10) unsigned NOT NULL COMMENT '废料分类ID',
  `type` enum('standard_price','presell_price','risk_cost') NOT NULL COMMENT '类型:standard_price=标准报价(元/kg),presell_price=预售价(元/kg),risk_cost=风险成本(元/kg)',
  `value` float(10,2) DEFAULT NULL COMMENT '变化后的值',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT '操作者IP',
  `createtime` int(10) unsigned NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='废料分类记录表';

CREATE TABLE `uct_waste_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `from_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送者ID',
  `to_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接收者ID',
  `type` enum('default','purchase','sell','customer','evaluate','report') NOT NULL DEFAULT 'default' COMMENT '类型:default=默认,purchase=采购,sell=销售,customer=客户,evaluate=废料评测,report=评测报告',
  `target_id` int(10) unsigned DEFAULT NULL COMMENT '目标ID',
  `level` enum('info','warning') NOT NULL DEFAULT 'info' COMMENT '等级:info=提醒,warning=警告',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '通知内容',
  `is_read` enum('1','0') NOT NULL DEFAULT '0' COMMENT '状态:1=已读,0=未读',
  `readtime` int(10) unsigned NULL COMMENT '阅读时间',
  `createtime` int(10) unsigned NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='废料通知表';

CREATE TABLE `uct_print_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `client_id` varchar(20) NULL COMMENT '应用ID',
  `client_secret` varchar(50) NULL COMMENT '应用密钥',
  `access_token` varchar(50) NULL COMMENT '访问令牌',
  `refresh_token` varchar(50) NULL COMMENT '更新令牌',
  `token_time` int(10) unsigned NULL COMMENT '令牌获取时间',
  `createtime` int(10) unsigned NULL COMMENT '创建时间',
  `updatetime` int(10) unsigned NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='打印配置表';
