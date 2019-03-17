cloud_sql_startDROP TABLE IF EXISTS `cloud_slider_group`;m;o;n;
CREATE TABLE `cloud_slider_group` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) default NULL,
  `style` varchar(100) NOT NULL,
  `width` varchar(30) default NULL,
  `height` varchar(30) default NULL,
  `editor` varchar(30) default NULL,
  `time` bigint(12) NOT NULL default '0',
  `duration` int(11) NOT NULL default '20',
  `delay` int(11) NOT NULL default '20',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;m;o;n;
INSERT INTO `cloud_slider_group` (`id`,`title`,`style`,`width`,`height`,`editor`,`time`,`duration`,`delay`) VALUES
('5','手机版 头部广告','swipe','100%','560px','4','1420099187','20','20'),
('4','电脑版 头部广告','basic_linear','1339px','300px','4','1396246502','20','20'),
('6','手机版主页幻灯片','basic_linear','100%','100%','4','1389750438','22','22'),
('13','旅游 电脑版','basic_linear','1189px','450px','4','1411978964','20','20'),
('15','店铺 电脑版','swipe','1130px','450px','4','1408198211','20','20'),
('16','分类信息 广告位','swipe','800px','450px','4','1416917965','20','20');m;o;n;
DROP TABLE IF EXISTS `cloud_slider_img`;m;o;n;
CREATE TABLE `cloud_slider_img` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` varchar(11) default NULL,
  `name` varchar(100) default NULL,
  `url` varchar(300) default NULL,
  `target` varchar(10) default '_self',
  `sequence` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;m;o;n;
INSERT INTO `cloud_slider_img` (`id`,`group_id`,`name`,`url`,`target`,`sequence`) VALUES
('35','5','#','#','_self','0'),
('31','5','#','#','_self','0'),
('30','5','#','#','_self','0'),
('59','13','1','#','_self','0'),
('33','6','#','#','_self','0'),
('61','13','3','#','_self','0'),
('34','6','#','#','_self','0'),
('32','6','#','#','_self','0'),
('52','4','3','#','_self','0'),
('51','4','2','#','_self','0'),
('50','4','1','#','_self','0'),
('60','13','2','#','_self','0'),
('56','14','2','#','_self','0'),
('57','14','1','#','_self','0'),
('58','14','3','#','_self','0'),
('66','15','#','./index.php?cloud=index.user','_self','0'),
('67','15','#','#','_self','0'),
('68','15','#','#','_self','0'),
('69','16','#','#','_self','0'),
('70','16','#','#','_self','0'),
('71','16','#','#','_self','0');m;o;n;
cloud_sql_end