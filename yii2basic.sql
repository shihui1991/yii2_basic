/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : 127.0.0.1:3306
 Source Schema         : yii2basic

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 23/07/2019 17:41:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment`  (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  INDEX `idx-auth_assignment-user_id`(`user_id`) USING BTREE,
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `idx-auth_item-type`(`type`) USING BTREE,
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child`  (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级ID',
  `parents_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所有上级ID集合',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `uri` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'URI',
  `router` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '路由名称',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标',
  `is_ctrl` tinyint(1) UNSIGNED NOT NULL COMMENT '是否限制',
  `is_show` tinyint(1) UNSIGNED NOT NULL COMMENT '是否显示',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '状态',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `created_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '菜单' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 0, '', '控制台', '/admin/home/index', '', '<i class=\"menu-icon fa fa-tachometer\"></i>', 0, 1, 1, 0, 1563437485, 1563776501);
INSERT INTO `menu` VALUES (2, 0, '', '系统设置', '', '', '<i class=\"menu-icon fa fa-cogs\"></i>', 1, 1, 1, 0, 1563437519, 1563776484);
INSERT INTO `menu` VALUES (3, 2, '2', '菜单管理', '/admin/menu/index', '', '<i class=\"menu-icon fa fa-navicon\"></i>', 1, 1, 1, 0, 1563520031, 1563854415);
INSERT INTO `menu` VALUES (4, 3, '2,3', '添加菜单', '/admin/menu/create', '', '<i class=\"menu-icon fa fa-plus-circle\"></i>', 1, 0, 1, 0, 1563787613, 1563787746);
INSERT INTO `menu` VALUES (5, 3, '2,3', '菜单详情', '/admin/menu/view', '', '<i class=\"menu-icon fa fa-edit\"></i>', 1, 0, 1, 0, 1563787653, 1563787757);
INSERT INTO `menu` VALUES (6, 3, '2,3', '修改菜单', '/admin/menu/update', '', '<i class=\"menu-icon fa fa-info-circle\"></i>', 1, 0, 1, 0, 1563787682, 1563787772);
INSERT INTO `menu` VALUES (7, 3, '2,3', '删除菜单', '/admin/menu/delete', '', '<i class=\"menu-icon fa fa-trash\"></i>', 1, 0, 1, 0, 1563787701, 1563787784);
INSERT INTO `menu` VALUES (8, 2, '2', '角色管理', '/admin/role/index', '', '<i class=\"menu-icon fa fa-user-secret\"></i>', 1, 1, 1, 0, 1563844799, 1563844799);
INSERT INTO `menu` VALUES (9, 8, '2,8', '添加角色', '/admin/role/create', '', '<i class=\"menu-icon fa fa-plus-circle\"></i>', 1, 0, 1, 0, 1563844822, 1563844822);
INSERT INTO `menu` VALUES (10, 8, '2,8', '角色详情', '/admin/role/view', '', '<i class=\"menu-icon fa fa-info-circle\"></i>', 1, 0, 1, 0, 1563844848, 1563844848);
INSERT INTO `menu` VALUES (11, 8, '2,8', '修改角色', '/admin/role/update', '', '<i class=\"menu-icon fa fa-edit\"></i>', 1, 0, 1, 0, 1563844882, 1563844882);
INSERT INTO `menu` VALUES (12, 8, '2,8', '删除角色', '/admin/role/delete', '', '<i class=\"menu-icon fa fa-trash\"></i>', 1, 0, 1, 0, 1563844913, 1563844913);

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apply_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', 1562810591);
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', 1562811075);
INSERT INTO `migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1562811075);
INSERT INTO `migration` VALUES ('m180523_151638_rbac_updates_indexes_without_prefix', 1562811075);
INSERT INTO `migration` VALUES ('m190711_015238_create_menu_table', 1562812683);
INSERT INTO `migration` VALUES ('m190711_022933_create_role_table', 1562812683);
INSERT INTO `migration` VALUES ('m190711_030303_create_user_table', 1562815212);
INSERT INTO `migration` VALUES ('m190711_031139_create_junction_role_and_menu', 1562815212);
INSERT INTO `migration` VALUES ('m190711_034430_create_junction_user_and_role', 1562816758);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级ID',
  `parents_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所有上级ID集合',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `is_root` tinyint(1) UNSIGNED NOT NULL COMMENT '是否超管',
  `created_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for role_menu
-- ----------------------------
DROP TABLE IF EXISTS `role_menu`;
CREATE TABLE `role_menu`  (
  `role_id` int(11) UNSIGNED NOT NULL COMMENT '角色ID',
  `menu_id` int(11) UNSIGNED NOT NULL COMMENT '菜单ID',
  UNIQUE INDEX `roleId_menuId_unique`(`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色授权菜单' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '状态',
  `created_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role`  (
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户ID',
  `role_id` int(11) UNSIGNED NOT NULL COMMENT '角色ID',
  UNIQUE INDEX `userId_roleId_unique`(`user_id`, `role_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户角色' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
