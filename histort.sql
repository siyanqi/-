CREATE TABLE ls_video
(
   id int(11) unsigned not null auto_increment,
   uid int(11) NOT NULL DEFAULT '0' COMMENT '用户id 0为平台上传',
   video_title varchar(150) not null default '' comment '视频标题',
   rake int(11) unsigned not null default 0 comment '排序',
   video_img varchar(150) not null default '' comment '视频封页',
   video varchar(150) not null default '' comment '视频',
   is_show tinyint unsigned not null default '1' comment '是否显示：1：显示，0：不显示',
   add_time int unsigned not null comment '添加时间',
	 video_desc longtext comment '视频描述',
	 share_num int(11) unsigned not null DEFAULT 0 comment '分享数量',
	 like_num int(11) unsigned not null DEFAULT 0 comment '点赞数量',
	 PRIMARY key (id)
) engine=MyISAM default charset=utf8 comment '视频表';

CREATE TABLE ls_category
(
    id int(11) unsigned not null auto_increment,
    category_name varchar(150) not null default '' comment '分类名称',
    rake int(11) unsigned not null DEFAULT 0 comment '排序',
    is_show tinyint unsigned not null default '1' comment '是否显示：1：显示，0：不显示',
    add_time int unsigned not null comment '添加时间',
    PRIMARY  KEY (id)
)engine=MyISAM default charset=utf8 comment '分类表';

CREATE TABLE ls_video_category
(
  id int(11) unsigned not null auto_increment,
  video_id int(11) unsigned not null DEFAULT 0 comment '视频id',
  category_id int(11) unsigned not null DEFAULT 0 comment '视频id',
  PRIMARY KEY (id),
  key video_id(video_id),
  key category_id(category_id)
)engine=MyISAM default charset=utf8 comment '视频分类表';

CREATE TABLE `ls_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(500) not null DEFAULT '' COMMENT '评论内容',
  `uid` int(11) not null DEFAULT '0' COMMENT '评论人id',
  `video_id` int(11) NOT null DEFAULT '0' COMMENT '视频id',
  `comment_time` int(11) null DEFAULT '0' comment '评论时间',
  `reply_uid` int(11) not null DEFAULT '0' COMMENT '回复人uid（uid 对 reply_uid 做评论',
  `state` tinyint(1) not null DEFAULT '0' COMMENT '0显示 1不显示',
  PRIMARY KEY (`id`),
  key video_id(video_id)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='视频评论表';

CREATE TABLE `ls_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '点赞人uid',
  `upvote` tinyint(1) NOT NULL DEFAULT '0' COMMENT '点赞与否 0 未点赞 1 已点赞',
  `video_id` int(11) NOT NULL DEFAULT '0' COMMENT '视频id',
  `upvote_time` int(11) not null DEFAULT '0' COMMENT '点赞时间',
  PRIMARY KEY (id),
  key video_id(video_id)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='人脉圈点赞表';

CREATE TABLE ls_user (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` int(11) NOT NULL DEFAULT '0' COMMENT '微信id',
  `user_name` varchar(150) not null default '' comment '用户名',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `sex` smallint(1) NOT NULL DEFAULT '0' COMMENT '性别；0：保密，1：男；2：女',
  `qrcode` varchar(255) NOT NULL DEFAULT '' COMMENT '用户二维码',
  `address` varchar(500) not NULL DEFAULT '' COMMENT '地址',
  `province` varchar(100) not NULL DEFAULT '' COMMENT '省',
  `city` varchar(100) not NULL DEFAULT '' COMMENT '市',
  `area` varchar(100) not NULL DEFAULT '' COMMENT '地区',
  `state` tinyint(1) not NULL DEFAULT '0' COMMENT '0、正常用户、1、被封号',
  `last_login_time` int(11)  not null DEFAULT '0' COMMENT '最后登录时间',
  `create_time` int(11)  not null DEFAULT '0' COMMENT '注册时间',
  `coins` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户金币',
  PRIMARY KEY (uid),
  key openid(openid)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='用户表';

CREATE TABLE ls_collect (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `video_id` int(11) NOT NULL DEFAULT '0' COMMENT '视频id',
  PRIMARY KEY (id),
  key uid(uid),
  key video_id(video_id)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='用户收藏表';

CREATE TABLE `ls_admin` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL COMMENT '账号',
  `password` char(32) NOT NULL COMMENT '密码',
  `is_use` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用 1：启用0：禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';
