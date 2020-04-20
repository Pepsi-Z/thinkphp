/*
 Navicat MySQL Data Transfer

 Source Server         : Mysql_localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : thinkphp

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 22/05/2019 22:17:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for shop_cate
-- ----------------------------
DROP TABLE IF EXISTS `shop_cate`;
CREATE TABLE `shop_cate`  (
  `cid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `cname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类别名称',
  `pid` int(10) UNSIGNED NOT NULL COMMENT '父类id',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属关系',
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shop_cate
-- ----------------------------
INSERT INTO `shop_cate` VALUES (1, '茶类', 0, '0,');
INSERT INTO `shop_cate` VALUES (2, '畜牧产品', 0, '0,');
INSERT INTO `shop_cate` VALUES (3, '粮食', 0, '0,');
INSERT INTO `shop_cate` VALUES (4, '蔬菜', 0, '0,');
INSERT INTO `shop_cate` VALUES (5, '水产品', 0, '0,');
INSERT INTO `shop_cate` VALUES (8, '铁观音', 1, '0,1,');
INSERT INTO `shop_cate` VALUES (9, '大红袍', 1, '0,1,');
INSERT INTO `shop_cate` VALUES (10, '鸡蛋', 2, '0,2,');
INSERT INTO `shop_cate` VALUES (11, '腊肉', 2, '0,2,');
INSERT INTO `shop_cate` VALUES (12, '大米', 3, '0,3,');
INSERT INTO `shop_cate` VALUES (13, '小米', 3, '0,3,');
INSERT INTO `shop_cate` VALUES (14, '胡萝卜', 4, '0,4,');
INSERT INTO `shop_cate` VALUES (15, '黄瓜', 4, '0,4,');
INSERT INTO `shop_cate` VALUES (16, '干虾仁', 5, '0,5,');
INSERT INTO `shop_cate` VALUES (17, '虾', 5, '0,5,');

-- ----------------------------
-- Table structure for shop_details
-- ----------------------------
DROP TABLE IF EXISTS `shop_details`;
CREATE TABLE `shop_details`  (
  `did` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '详情ID',
  `orders_oid` char(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属订单号',
  `gid` int(10) UNSIGNED NOT NULL COMMENT '商品ID',
  `price` decimal(9, 2) NOT NULL COMMENT '商品购买价格',
  `cnt` int(11) NOT NULL COMMENT '购买数量',
  PRIMARY KEY (`did`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 44 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of shop_details
-- ----------------------------
INSERT INTO `shop_details` VALUES (43, '20190522220451193', 10, 8888.00, 2);
INSERT INTO `shop_details` VALUES (42, '20190522214216915', 10, 8888.00, 3);
INSERT INTO `shop_details` VALUES (41, '20190522214047887', 10, 8888.00, 2);
INSERT INTO `shop_details` VALUES (40, '20190522213922255', 2, 99.00, 1);
INSERT INTO `shop_details` VALUES (39, '20190522213719538', 2, 99.00, 2);
INSERT INTO `shop_details` VALUES (38, '20190522213451327', 2, 99.00, 1);
INSERT INTO `shop_details` VALUES (37, '20190522212531516', 10, 8888.00, 1);

-- ----------------------------
-- Table structure for shop_goods
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods`;
CREATE TABLE `shop_goods`  (
  `gid` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品表主键',
  `gname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称',
  `cate_id` int(10) UNSIGNED NOT NULL COMMENT '商品分类',
  `price` decimal(8, 2) NOT NULL COMMENT '单价',
  `stock` int(10) UNSIGNED NOT NULL COMMENT '库存量',
  `salecnt` int(11) NULL DEFAULT NULL COMMENT '卖货量',
  `gpic` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品图片',
  `gdesc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品描述',
  `status` int(11) NULL DEFAULT NULL COMMENT '商品状态 1 新品 2 上架 3 下架',
  `ctime` int(11) NULL DEFAULT NULL COMMENT '商品创建时间',
  PRIMARY KEY (`gid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shop_goods
-- ----------------------------
INSERT INTO `shop_goods` VALUES (4, '铁观音', 8, 555.00, 943, 1, '20190520/2e761c446ffe54db1bf61c208a269797.jpg', '铁观音                                ', 2, 1530009085);
INSERT INTO `shop_goods` VALUES (1, '蚕豆', 3, 100.00, 18, 2, '20190520/05add8cd58bc785f7d39565147f87e07.jpg', '蚕豆', 2, 1558357868);
INSERT INTO `shop_goods` VALUES (2, '鸡蛋', 10, 99.00, 977, 3, '20190520/444ece4780ef4b8a68400fa772cdce7e.jpg', '鸡蛋', 2, 1530009046);
INSERT INTO `shop_goods` VALUES (3, '大豆', 3, 99.00, 990, 4, '20190520/c2ea98fc5ef60227ae70f53f4f5e6952.jpg', '大豆', 2, 1530009069);
INSERT INTO `shop_goods` VALUES (5, '大米', 12, 99.00, 994, 5, '20190520/cad3e12e5a59cd59b30ede05f9baa60d.jpg', '大米啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', 2, 1530009104);
INSERT INTO `shop_goods` VALUES (6, '红米', 3, 99.00, 1000, 6, '20190520/461f91eed9a07b4ef4b84d61a36b0547.jpg', '红米啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', 1, 1530009125);
INSERT INTO `shop_goods` VALUES (7, '小米', 13, 99.00, 0, 7, '20190520/9c9743158b9ea9e9a3930b793d84eb5a.jpg', '小米阿啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', 1, 1530009145);
INSERT INTO `shop_goods` VALUES (11, '腊肉', 11, 8888.00, 10, 8, '20190520/b877b7b27f6a5d4c6d30fc2c3e899f67.jpg', '腊肉咔咔咔啊啊啊啊啊啊啊啊啊啊啊啊啊啊阿', 3, NULL);
INSERT INTO `shop_goods` VALUES (8, '虾', 17, 8888.00, 23, 9, '20190520/01e67fef19ff2d397c7d2f7c0b939e9c.jpg', '你看啥啊啊啊啊啊啊啊啊啊啊阿啊啊啊啊啊阿啊啊啊啊', 2, NULL);
INSERT INTO `shop_goods` VALUES (9, '干虾仁', 16, 8888.00, 50, 10, '20190520/5053044b77fe53c4a12838eb48dd434a.jpg', '哒哒哒啊啊啊啊啊阿啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', 2, NULL);
INSERT INTO `shop_goods` VALUES (10, '黄瓜', 15, 8888.00, 92, 23, '20190520/a87102e58310473689d8ca44ae9577a4.jpg', '哒哒哒啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', 2, NULL);
INSERT INTO `shop_goods` VALUES (12, '胡萝卜1', 14, 1111.00, 1000, 12, '20190520/199144c813939715c2942992d24fe34b.jpg', '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', 2, NULL);
INSERT INTO `shop_goods` VALUES (13, '胡萝卜2', 14, 1111.00, 1000, 4, '20190520/199144c813939715c2942992d24fe34b.jpg', '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', 2, NULL);

-- ----------------------------
-- Table structure for shop_orders
-- ----------------------------
DROP TABLE IF EXISTS `shop_orders`;
CREATE TABLE `shop_orders`  (
  `oid` char(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '订单号',
  `total` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '金额',
  `cnt` int(11) NOT NULL DEFAULT 0 COMMENT '购买数量',
  `user_uid` int(10) NOT NULL COMMENT '购买用户id',
  `rec` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '收货人',
  `addr` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '收货地址',
  `tel` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '收货人电话',
  `status` int(255) NOT NULL COMMENT '订单状态（1.代发货 2.已发货）',
  `umsg` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '订单备注',
  `create_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '购买时间',
  PRIMARY KEY (`oid`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shop_orders
-- ----------------------------
INSERT INTO `shop_orders` VALUES ('20190522214023979', 0.00, 0, 1, '', '', '', 1, '', '1558532423');
INSERT INTO `shop_orders` VALUES ('20190522213922255', 99.00, 1, 1, 'asdasdasd', 'dasdas', 'asdasdas', 2, 'dasdas', '1558532362');
INSERT INTO `shop_orders` VALUES ('20190522213451327', 99.00, 1, 1, 'dd', 'dd', 'dd', 3, 'dd', '1558532091');
INSERT INTO `shop_orders` VALUES ('20190522213719538', 198.00, 2, 1, 'sssss', 'sss', 'ssss', 2, 'ssss', '1558532239');
INSERT INTO `shop_orders` VALUES ('20190522214047887', 17776.00, 2, 1, '黄瓜', '黄瓜', '黄瓜', 2, '黄瓜', '1558532447');
INSERT INTO `shop_orders` VALUES ('20190522214216915', 26664.00, 3, 1, '辅导辅导辅导', '辅导辅导辅导', '辅导辅导辅导', 3, '辅导辅导辅导', '1558532536');
INSERT INTO `shop_orders` VALUES ('20190522220451193', 17776.00, 2, 1, '测试', '测试', '测试', 2, '测试', '1558533891');

-- ----------------------------
-- Table structure for shop_users
-- ----------------------------
DROP TABLE IF EXISTS `shop_users`;
CREATE TABLE `shop_users`  (
  `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `uname` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '账号',
  `upwd` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '密码',
  `sex` enum('w','m','x') CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '性别',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '' COMMENT '联系电话',
  `addr` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '地址',
  `auth` int(255) NOT NULL COMMENT '权限(1.超级管理员 2.普通管理员)',
  `create_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '创建时间',
  `hp` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '头像',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 36 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shop_users
-- ----------------------------
INSERT INTO `shop_users` VALUES (1, 'admin', '202cb962ac59075b964b07152d234b70', 'x', '14584514587', '', 1, '1530707337', '20190522/1863a6fc8f614c82f89e4c987bd09973.jpg');
INSERT INTO `shop_users` VALUES (15, 'www', 'd2f2297d6e829cd3493aa7de4416a18f', 'm', '123132132132', '', 2, '1530589334', '');
INSERT INTO `shop_users` VALUES (17, '嘻嘻', '202cb962ac59075b964b07152d234b70', 'w', '14578965478', '', 2, '1530623773', '');
INSERT INTO `shop_users` VALUES (22, 'zeze', '202cb962ac59075b964b07152d234b70', 'm', '15478546845', '', 2, '1530756732', '');
INSERT INTO `shop_users` VALUES (23, 'wahaha', 'c4ca4238a0b923820dcc509a6f75849b', 'w', '15478546845', '', 3, '1530781027', '20180705/b52535634bc5e0ee7e561fae7506f548.jpg');
INSERT INTO `shop_users` VALUES (24, '嗯嗯', 'c4ca4238a0b923820dcc509a6f75849b', 'm', '14587564514', '', 3, '1530787787', '');
INSERT INTO `shop_users` VALUES (25, '啦啦', 'c4ca4238a0b923820dcc509a6f75849b', 'm', '14587546354', '', 3, '1530791460', '20180705/203869c9695712958ae5d39e4fb68773.jpg');
INSERT INTO `shop_users` VALUES (29, '啪啪', '202cb962ac59075b964b07152d234b70', 'm', '15478547547', '', 3, '1530793483', '');
INSERT INTO `shop_users` VALUES (30, '一样', 'e10adc3949ba59abbe56e057f20f883e', 'w', '125321643', '', 3, '1530794429', '');
INSERT INTO `shop_users` VALUES (31, '123123', '4297f44b13955235245b2497399d7a93', 'm', '123123', '', 0, '1530795294', '');
INSERT INTO `shop_users` VALUES (32, '123', '4297f44b13955235245b2497399d7a93', 'm', '123123', '', 3, '1530795369', '');
INSERT INTO `shop_users` VALUES (33, '4321', '202cb962ac59075b964b07152d234b70', 'm', '123', '', 3, '1530795400', '20180705/1044d772b350de32d3a7bed5b39ff5df.jpg');
INSERT INTO `shop_users` VALUES (34, 'biubiu', '202cb962ac59075b964b07152d234b70', 'w', '15486475146', '', 3, '1531099672', '20180709/21221774c1d820c925d4049dc5df33fd.jpg');
INSERT INTO `shop_users` VALUES (35, '123456', '202cb962ac59075b964b07152d234b70', 'm', '2132143243245', NULL, 0, '1557927747', '');

SET FOREIGN_KEY_CHECKS = 1;
