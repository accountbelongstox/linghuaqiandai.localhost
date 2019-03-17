cloud_sql_startDROP TABLE IF EXISTS `cloud_talk_content`;m;o;n;
CREATE TABLE `cloud_talk_content` (
  `id` int(11) NOT NULL auto_increment,
  `title_id` int(11) NOT NULL,
  `for` int(11) default '0',
  `content` text NOT NULL,
  `time` bigint(12) NOT NULL default '0',
  `username` varchar(30) default NULL,
  `ip` varchar(20) default NULL,
  `update_username` varchar(30) default NULL,
  `visible` int(1) NOT NULL default '1',
  `email` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=549 DEFAULT CHARSET=utf8;m;o;n;
INSERT INTO `cloud_talk_content` (`id`,`title_id`,`for`,`content`,`time`,`username`,`ip`,`update_username`,`visible`,`email`) VALUES
('547','518','0','我是回帖，哈哈哈','1419864554','test004','127.0.0.1','','1','0'),
('548','518','547','我是评论，呵呵呵','1419864597','test004','127.0.0.1','','1','0');m;o;n;
DROP TABLE IF EXISTS `cloud_talk_title`;m;o;n;
CREATE TABLE `cloud_talk_title` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) default NULL,
  `type` int(11) NOT NULL,
  `sequence` int(5) NOT NULL default '0',
  `username` varchar(30) default NULL,
  `time` bigint(12) NOT NULL default '0',
  `last_username` varchar(30) default NULL,
  `last_time` bigint(12) NOT NULL default '0',
  `ip` varchar(20) default NULL,
  `last_ip` varchar(20) default NULL,
  `visible` int(1) NOT NULL default '1',
  `key` varchar(300) default NULL,
  `visit` int(11) NOT NULL default '0',
  `contents` int(5) NOT NULL default '0',
  `email` int(1) NOT NULL default '0',
  `reply_time` bigint(12) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=661 DEFAULT CHARSET=utf8;m;o;n;
DROP TABLE IF EXISTS `cloud_talk_type`;m;o;n;
CREATE TABLE `cloud_talk_type` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `parent` int(11) NOT NULL,
  `sequence` int(5) NOT NULL default '0',
  `visible` int(1) NOT NULL default '1',
  `read_power` text NOT NULL,
  `title_power` text NOT NULL,
  `content_power` text NOT NULL,
  `manager` varchar(30) default NULL,
  `title_sum` int(11) NOT NULL default '0',
  `day_title_sum` int(11) NOT NULL default '0',
  `content_sum` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;m;o;n;
cloud_sql_end