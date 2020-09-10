/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : laravel58

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 08/05/2020 11:57:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ss_category
-- ----------------------------
DROP TABLE IF EXISTS `ss_category`;
CREATE TABLE `ss_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级分类ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分类类型',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序。越小越靠前',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态。1正常，99禁用',
  `image` varchar(32) NOT NULL DEFAULT '' COMMENT '分类图标',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `delete_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='网站分类表';

-- ----------------------------
-- Records of ss_category
-- ----------------------------
BEGIN;
INSERT INTO `ss_category` VALUES (1, '行业新闻', 0, 1, 0, 1, '', 1581737949, 0, 0);
INSERT INTO `ss_category` VALUES (2, '公司新闻', 0, 1, 0, 1, '', 1581737974, 1581738606, 0);
INSERT INTO `ss_category` VALUES (7, '测试', 0, 1, 0, 1, '', 1588863479, 1588863479, 0);
INSERT INTO `ss_category` VALUES (8, 'ces', 0, 1, 0, 1, '', 1588863768, 1588863768, 0);
INSERT INTO `ss_category` VALUES (9, 'ces', 0, 1, 0, 1, '', 1588863856, 1588863856, 0);
INSERT INTO `ss_category` VALUES (10, 'ces', 0, 1, 0, 1, '', 1588864510, 1588864510, 0);
COMMIT;

-- ----------------------------
-- Table structure for ss_config
-- ----------------------------
DROP TABLE IF EXISTS `ss_config`;
CREATE TABLE `ss_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '网站标题',
  `copyright` varchar(100) NOT NULL DEFAULT '' COMMENT '网站版权',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='网站配置表';

-- ----------------------------
-- Records of ss_config
-- ----------------------------
BEGIN;
INSERT INTO `ss_config` VALUES (1, '郑州拾叁网络科技有限公司', 'ICP 豫备案号 88888888');
COMMIT;

-- ----------------------------
-- Table structure for ss_feedback
-- ----------------------------
DROP TABLE IF EXISTS `ss_feedback`;
CREATE TABLE `ss_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(32) NOT NULL DEFAULT '' COMMENT '邮箱',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '反馈内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态。1待处理，2已处理',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `admin_name` varchar(32) NOT NULL DEFAULT '' COMMENT '处理人姓名',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='网站意见反馈表';

-- ----------------------------
-- Records of ss_feedback
-- ----------------------------
BEGIN;
INSERT INTO `ss_feedback` VALUES (1, '张三', '15924140778', '1120414124@qq.com', '元气满满', 2, '', 1, 'admin', 1581664083, 1581666575);
COMMIT;

-- ----------------------------
-- Table structure for ss_file
-- ----------------------------
DROP TABLE IF EXISTS `ss_file`;
CREATE TABLE `ss_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(200) NOT NULL DEFAULT '' COMMENT '文件地址',
  `original_name` varchar(200) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `gmt_create` datetime DEFAULT NULL COMMENT '创建时间',
  `gmt_update` datetime DEFAULT NULL,
  `note` varchar(500) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='上传文件表';

-- ----------------------------
-- Records of ss_file
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for ss_link
-- ----------------------------
DROP TABLE IF EXISTS `ss_link`;
CREATE TABLE `ss_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='友情链接表';

-- ----------------------------
-- Records of ss_link
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for ss_log
-- ----------------------------
DROP TABLE IF EXISTS `ss_log`;
CREATE TABLE `ss_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '管理员id',
  `operate_module` varchar(50) DEFAULT '' COMMENT '请求控制器',
  `operate_action` varchar(50) DEFAULT '' COMMENT '请求方法',
  `operate_url` varchar(200) DEFAULT '' COMMENT '请求URL',
  `content` varchar(255) DEFAULT '' COMMENT '日志内容',
  `ip` varchar(20) DEFAULT '' COMMENT 'IP',
  `module` tinyint(1) DEFAULT '0' COMMENT '前、后台',
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ss_log
-- ----------------------------
BEGIN;
INSERT INTO `ss_log` VALUES (1, 1, 'category', 'store', '/admin/category', '新增分类', '127.0.0.1', 1, 1588863479);
INSERT INTO `ss_log` VALUES (2, 1, 'login', 'login', '/admin/login', '登录后台', '127.0.0.1', 1, 1588866742);
INSERT INTO `ss_log` VALUES (3, 1, 'login', 'login', '/admin/login', '登录后台', '127.0.0.1', 1, 1588906078);
COMMIT;

-- ----------------------------
-- Table structure for ss_manager
-- ----------------------------
DROP TABLE IF EXISTS `ss_manager`;
CREATE TABLE `ss_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(100) NOT NULL DEFAULT '' COMMENT '密码',
  `remember_token` varchar(100) NOT NULL DEFAULT '' COMMENT 'session令牌',
  `gmt_last_login` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_ip` varchar(50) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT '父级管理员id',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `is_system` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否系统用户',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

-- ----------------------------
-- Records of ss_manager
-- ----------------------------
BEGIN;
INSERT INTO `ss_manager` VALUES (1, 'admin', '$2y$10$K9ZqSDPveI6zuQjOgJj3OeWibeAevedhv5E6vOSLCo2qizF1GAUw.', 'dLzNcAgSABMrvLoWIo1T9jrgiS6cBP4z9Hf7B6IORhvGHDp9UltycumZZmpf', '2020-05-08 10:47:58', '127.0.0.1', 1, '0,1,1,', 1, 1, '2020-02-19 09:55:12', '2020-05-08 10:47:58', NULL);
INSERT INTO `ss_manager` VALUES (2, 'test11', '$2y$10$Ujyg8YXL9SGVaqNFf9slbOwNhaWBO3hqvpMEpLozqM8u6E7vP9hZK', 'PtmQwtKVTFPenmidu7NxC7DF1NzOn5DojN2vxkfzIL9WBw6nSfavItdQZOCQ', '2020-02-13 09:46:46', '127.0.0.1', 1, '0,1,1,2,', 1, 0, '2020-02-19 09:55:12', '2020-02-19 09:54:43', NULL);
INSERT INTO `ss_manager` VALUES (3, 'ssss', '$2y$10$w4kWVn6/JZrnziMkV0/bJ.KoAfAIrN9vAXtOFO5ZQh9mjfQoK.jhm', '', NULL, '', 1, '0,1,1,3,', 1, 0, '2020-02-19 09:55:12', '2020-02-19 09:55:12', NULL);
COMMIT;

-- ----------------------------
-- Table structure for ss_menu
-- ----------------------------
DROP TABLE IF EXISTS `ss_menu`;
CREATE TABLE `ss_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '编码',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '菜单地址',
  `grade` tinyint(4) NOT NULL DEFAULT '0' COMMENT '菜单等级',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '菜单排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '菜单状态',
  `module` tinyint(4) NOT NULL DEFAULT '0' COMMENT '所属模块',
  `is_system` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否系统菜单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

-- ----------------------------
-- Records of ss_menu
-- ----------------------------
BEGIN;
INSERT INTO `ss_menu` VALUES (1, '系统配置', 'system', 0, '0,1,1', '/system', 1, 1, 1, 1, 0);
INSERT INTO `ss_menu` VALUES (2, '管理员管理', 'manager', 1, '0,1,2', '/manager', 2, 2, 1, 1, 0);
INSERT INTO `ss_menu` VALUES (3, '角色管理', 'role', 1, '0,1,3', '/role', 2, 3, 1, 1, 0);
INSERT INTO `ss_menu` VALUES (4, '权限管理', 'permission', 1, '0,1,4', '/permission', 2, 4, 1, 1, 1);
INSERT INTO `ss_menu` VALUES (5, '菜单管理', 'menu', 1, '0,1,5', '/menu', 2, 5, 1, 1, 1);
INSERT INTO `ss_menu` VALUES (6, '网站配置', 'config', 1, '0,1,1,15', '/config', 2, 5, 1, 1, 0);
INSERT INTO `ss_menu` VALUES (9, '分类管理', 'category', 1, '0,1,1,19', '/category', 2, 9, 1, 1, 0);
INSERT INTO `ss_menu` VALUES (10, '反馈管理', 'feedback', 1, '0,1,1,20', '/feedback', 2, 10, 1, 1, 0);
INSERT INTO `ss_menu` VALUES (11, '日志列表', 'log', 1, '0,1,1,11', '/log', 2, 11, 1, 1, 0);
COMMIT;

-- ----------------------------
-- Table structure for ss_permission
-- ----------------------------
DROP TABLE IF EXISTS `ss_permission`;
CREATE TABLE `ss_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `code` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属菜单id',
  `module` tinyint(4) NOT NULL DEFAULT '0' COMMENT '所属模块',
  `is_system` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否系统权限',
  PRIMARY KEY (`id`),
  UNIQUE KEY `wx_permissions_code_unique` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COMMENT='权限表';

-- ----------------------------
-- Records of ss_permission
-- ----------------------------
BEGIN;
INSERT INTO `ss_permission` VALUES (1, '菜单列表', 'menu.index', '', 5, 1, 1);
INSERT INTO `ss_permission` VALUES (2, '菜单添加', 'menu.create,menu.store', '', 5, 1, 1);
INSERT INTO `ss_permission` VALUES (3, '菜单修改', 'menu.edit,menu.update', '', 5, 1, 1);
INSERT INTO `ss_permission` VALUES (4, '菜单查看', 'menu.show', '', 5, 1, 1);
INSERT INTO `ss_permission` VALUES (5, '菜单删除', 'menu.destroy', '', 5, 1, 1);
INSERT INTO `ss_permission` VALUES (6, '管理员列表', 'manager.index', '', 2, 1, 0);
INSERT INTO `ss_permission` VALUES (7, '管理员添加', 'manager.create,manager.store', '', 2, 1, 0);
INSERT INTO `ss_permission` VALUES (8, '管理员修改', 'manager.edit,manager.update', '', 2, 1, 0);
INSERT INTO `ss_permission` VALUES (9, '管理员查看', 'manager.show', '', 2, 1, 0);
INSERT INTO `ss_permission` VALUES (10, '管理员删除', 'manager.destroy', '', 2, 1, 0);
INSERT INTO `ss_permission` VALUES (11, '权限列表', 'permission.index', '', 4, 1, 1);
INSERT INTO `ss_permission` VALUES (12, '权限添加', 'permission.create,permission.store', '', 4, 1, 1);
INSERT INTO `ss_permission` VALUES (13, '权限修改', 'permission.edit,permission.update', '', 4, 1, 1);
INSERT INTO `ss_permission` VALUES (14, '权限查看', 'permission.show', '', 4, 1, 1);
INSERT INTO `ss_permission` VALUES (15, '权限删除', 'permission.destroy', '', 4, 1, 1);
INSERT INTO `ss_permission` VALUES (16, '角色列表', 'role.index', '', 3, 1, 0);
INSERT INTO `ss_permission` VALUES (17, '角色添加', 'role.create,role.store', '', 3, 1, 0);
INSERT INTO `ss_permission` VALUES (18, '角色修改', 'role.edit,role.update', '', 3, 1, 0);
INSERT INTO `ss_permission` VALUES (19, '角色查看', 'role.show', '', 3, 1, 0);
INSERT INTO `ss_permission` VALUES (20, '角色删除', 'role.destroy', '', 3, 1, 0);
INSERT INTO `ss_permission` VALUES (21, '角色授权', 'role.authority', '', 3, 1, 0);
INSERT INTO `ss_permission` VALUES (22, '网站配置', 'config.index', '', 6, 1, 0);
INSERT INTO `ss_permission` VALUES (23, '网站配置修改', 'config.update', '', 6, 1, 0);
INSERT INTO `ss_permission` VALUES (26, '分类列表', 'category.index', ' ', 9, 1, 0);
INSERT INTO `ss_permission` VALUES (27, '分类新增', 'category.create,category.store', ' ', 9, 1, 0);
INSERT INTO `ss_permission` VALUES (28, '分类编辑', 'category.edit,category.update', ' ', 9, 1, 0);
INSERT INTO `ss_permission` VALUES (29, '分类删除', 'category.destroy', ' ', 9, 1, 0);
INSERT INTO `ss_permission` VALUES (30, '反馈列表', 'feedback.index', ' ', 10, 1, 0);
INSERT INTO `ss_permission` VALUES (31, '反馈处理', 'feedback.edit,feedback.update', ' ', 10, 1, 0);
INSERT INTO `ss_permission` VALUES (32, '反馈删除', 'feedback.destroy', ' ', 10, 1, 0);
INSERT INTO `ss_permission` VALUES (33, '日志列表', 'log.index', '', 11, 1, 0);
COMMIT;

-- ----------------------------
-- Table structure for ss_permission_role
-- ----------------------------
DROP TABLE IF EXISTS `ss_permission_role`;
CREATE TABLE `ss_permission_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `module` tinyint(4) NOT NULL DEFAULT '0' COMMENT '所属模块',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COMMENT='权限角色表';

-- ----------------------------
-- Records of ss_permission_role
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for ss_role
-- ----------------------------
DROP TABLE IF EXISTS `ss_role`;
CREATE TABLE `ss_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(10) NOT NULL DEFAULT '0' COMMENT '父级角色id',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',
  `name` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) DEFAULT NULL,
  `module` tinyint(4) NOT NULL DEFAULT '0' COMMENT '所属模块',
  `is_system` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
-- Records of ss_role
-- ----------------------------
BEGIN;
INSERT INTO `ss_role` VALUES (1, 1, '0,1,', '超级管理员', '这是超级管理员', 1, 1, 0, 0);
INSERT INTO `ss_role` VALUES (2, 1, '0,1,2,', '测试管理员', '', 1, 0, 0, 0);
INSERT INTO `ss_role` VALUES (3, 1, '0,1,3,', '测试', NULL, 1, 0, 0, 1582088917);
COMMIT;

-- ----------------------------
-- Table structure for ss_role_user
-- ----------------------------
DROP TABLE IF EXISTS `ss_role_user`;
CREATE TABLE `ss_role_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `module` tinyint(4) NOT NULL DEFAULT '0' COMMENT '所属模块',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='管理员角色表';

-- ----------------------------
-- Records of ss_role_user
-- ----------------------------
BEGIN;
INSERT INTO `ss_role_user` VALUES (1, 1, 1, 1);
INSERT INTO `ss_role_user` VALUES (2, 2, 2, 1);
INSERT INTO `ss_role_user` VALUES (3, 3, 2, 1);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
