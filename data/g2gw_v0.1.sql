CREATE TABLE `brand` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '品牌ID',
`en_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '品牌的英文名称',
`country_code` char(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '国家代码',
`logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '品牌logo的文件路径',
`cn_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '品牌的中文名称',
`introduction` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '品牌简介',
`baidubaike` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '百度百科解释',
`thumbsup` int(11) NULL DEFAULT 0 COMMENT '点赞数量',
`thumbsdown` int(11) NULL DEFAULT 0 COMMENT '吐槽数量',
`company_id` int(11) NULL COMMENT '运营公司',
`comment_count` int(11) NULL DEFAULT 0 COMMENT '评论数量',
`view_count` int(11) NULL DEFAULT 0 COMMENT '浏览次数',
`created_date` datetime NULL,
`updated_date` datetime NULL,
`star_count` int NULL,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=24
COMMENT='品牌信息表';

CREATE TABLE `category` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
`parent_id` int(11) UNSIGNED NULL COMMENT '分类的父分类',
`name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类名称',
`model_type` varchar(20) NULL,
`order` tinyint(5) NULL,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=17
COMMENT='分类信息表\r\n支持无限分类 \r\nid为分类编号 pid为该分类的父分类 pid=0表示该类为顶级分类\r\n商品与品牌共用的分类表';

CREATE TABLE `country` (
`code` char(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '国家代码',
`en_name` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '国家英文名称',
`population` int(11) NULL COMMENT '国家人口',
`cn_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '国家中文名称',
`flag` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '国家旗帜logo路径',
PRIMARY KEY (`code`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='国家表';

CREATE TABLE `ecommerce` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`brand_id` int(11) NULL DEFAULT NULL,
`website` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`is_domestic` smallint(6) NULL DEFAULT NULL COMMENT '网址是国内还是境外0国外1国内',
`accept_order` smallint(6) NULL DEFAULT NULL COMMENT '是否能在线购买1可以0不能',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=24;

CREATE TABLE `user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`password` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`cellphone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`face` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像的文件路径',
`nickname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`auth_key` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '123' COMMENT '用于登录中记住我',
`accessToken` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '123' COMMENT '访问令牌',
`created_at` int(11) NULL COMMENT '用户注册时间',
`updated_at` int(11) NULL COMMENT '修改时间',
`password_hash` varchar(255) NULL,
`password_reset_token` varchar(255) NULL,
`status` smallint(5) NULL COMMENT '用户状态',
`role` smallint(5) NULL,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=3
COMMENT='用户表';

CREATE TABLE `goods` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
`brand_id` int(11) UNSIGNED NOT NULL COMMENT '商品所属品牌ID',
`code` varchar(30) NULL COMMENT '商品编号',
`description` text NULL COMMENT '对商品的基本描述',
`thumbsup` int(11) NULL DEFAULT 0,
`thumbsdown` int(11) NULL DEFAULT 0,
`url` varchar(255) NULL,
`title` varchar(255) NULL,
`comment_status` varchar(20) NULL DEFAULT 'open',
`comment_count` int(11) NULL DEFAULT 0,
`created_date` datetime NULL,
`updated_date` datetime NULL,
`star_count` int(11) NULL DEFAULT 0,
`recomended_count` int(11) NULL DEFAULT 0,
`view_count` int(11) NULL DEFAULT 0 COMMENT '浏览次数',
`status` smallint(5) NOT NULL DEFAULT 1,
PRIMARY KEY (`id`) 
)
COMMENT='商品信息表';

CREATE TABLE `pricehistory` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`goods_id` int(11) NOT NULL COMMENT '商品编号',
`market_price` float NULL COMMENT '市场报价',
`real_price` float NULL COMMENT '实际价格',
`quotation_date` datetime NOT NULL COMMENT '报价时间',
PRIMARY KEY (`id`) 
)
COMMENT='商品历史价格表';

CREATE TABLE `coupon` (
`id` int(11) NOT NULL,
PRIMARY KEY (`id`) 
)
COMMENT='用户优惠券表';

CREATE TABLE `point` (
`id` int(11) NOT NULL,
PRIMARY KEY (`id`) 
)
COMMENT='用户积分表';

CREATE TABLE `company` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '公司ID',
`name` varchar(50) NULL COMMENT '公司名称',
`address` varchar(255) NULL COMMENT '公司地址',
`telphone` varchar(20) NULL COMMENT '公司电话',
`fax` varchar(20) NULL COMMENT '公司传真',
`contact` varchar(30) NULL COMMENT '公司联系人',
`cell` varchar(11) NULL COMMENT '联系人手机',
`qq` varchar(20) NULL COMMENT '联系人QQ号',
`vchat` varchar(20) NULL COMMENT '联系人微信号',
`email` varchar(50) NULL COMMENT '联系人邮箱',
PRIMARY KEY (`id`) 
)
COMMENT='品牌经营公司信息';

CREATE TABLE `comment` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`parent_id` int(11) NULL DEFAULT NULL,
`model_type` varchar(20) NULL COMMENT '评论类型 \r\n//商品评论\r\nconst COMMENT_TYPE_GOODS = 0;\r\n//品牌评论\r\nconst COMMENT_TYPE_BRAND= 10;\r\n//一般购物信息评论\r\nconst COMMENT_TYPE_GENERALINFO= 20;\r\n//促销活动评论\r\nconst COMMENT_TYPE_PROMOTION= 30;',
`model_id` int(11) NULL COMMENT '   /**\r\n     * 商品评论类时modelid对应商品ID\r\n     * 品牌评论类时modelid对应品牌ID\r\n     * 购物信息评论类时modelid对应信息ID\r\n     * 促销活动类时modelid对应促销活动ID\r\n     */',
`approved` varchar(10) NULL DEFAULT 'Y',
`thumbsup` int(11) NOT NULL DEFAULT 0 COMMENT '大拇指点赞',
`thumbsdown` int(11) NOT NULL DEFAULT 0 COMMENT '大拇指吐槽',
`content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
`created_date` datetime NULL,
`updated_date` datetime NULL,
`userid` int(11) NULL DEFAULT NULL COMMENT '对应用户ID',
`author` varchar(30) NULL,
`author_ip` varchar(30) NULL,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=1;

CREATE TABLE `album` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`model_type` varchar(20) NOT NULL COMMENT '图片类型\r\n1、评论类图片const COMMENT_TYPE = 0;\r\n2、商品信息类图片const GOODS_TYPE=10;\r\n3、一般类购物信息图片类const GENERALINFO_TYPE=20;\r\n4、用户头像类 const USER_TYPE=30;',
`model_id` int(11) NOT NULL COMMENT '当图片类型type为评论类时modelid对应评论ID\r\n当图片类型type为商品信息类图片时modelid对应商品ID\r\n当图片类型为一般类信息类时modelid对应一般信息类ID\r\n当图片类型为用户头像时modelid对应用户ID\r\n',
`filename` varchar(255) NULL,
`created_date` datetime NULL,
`updated_date` datetime NULL,
`is_default` tinyint(5) NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `relationships_map` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`relationship_id` int(11) NULL COMMENT '关系ID',
`userid` int(11) NULL COMMENT '用户ID',
`model_type` varchar(20) NULL COMMENT '数据类型',
`model_id` int(11) NULL COMMENT '数据ID',
`created_date` datetime NULL,
PRIMARY KEY (`id`) 
)
COMMENT='用户与数据对象的关系表 例如：用户喜欢某一商品 某一品牌 都是一种关系';

CREATE TABLE `relationships` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
PRIMARY KEY (`id`) 
)
COMMENT='关系表 例如：用户喜欢某种东西 喜欢就称为一种关系';

CREATE TABLE `posts` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`post_title` varchar(100) NULL,
`post_content` text NULL,
`post_type` varchar(20) NULL,
`post_status` varchar(20) NULL,
`url` varchar(100) NULL,
`created_date` datetime NULL,
`updated_date` datetime NULL,
`userid` int(11) NULL,
`comment_count` int(11) NULL DEFAULT 0 COMMENT '评论次数',
`thumbsup` int(11) NULL DEFAULT 0 COMMENT '点赞次数',
`thumbsdown` int(11) NULL DEFAULT 0 COMMENT '吐槽数',
`effective_date` datetime NULL,
`expired_date` datetime NULL,
`view_count` int(11) NULL DEFAULT 0 COMMENT '浏览次数',
`star_count` int(11) NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `tag` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(20) NULL,
`count` int(11) NULL,
`model_type` varchar(20) NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `tagmap` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`tagid` int(11) NULL,
`model_type` varchar(20) NULL,
`model_id` int(11) NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `category_map` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`model_id` int(11) NOT NULL COMMENT '商品唯一ID',
`model_type` varchar(20) NULL,
`category_id` int(11) NOT NULL COMMENT '商品分类ID',
PRIMARY KEY (`id`) 
)
COMMENT='商品与商品分类对应表';

CREATE TABLE `auth_assignment` (
`item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`user_id` int(11) NOT NULL,
`created_at` int(11) NULL DEFAULT NULL,
PRIMARY KEY (`item_name`, `user_id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `auth_item` (
`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`type` int(11) NOT NULL,
`description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
`rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
`created_at` int(11) NULL DEFAULT NULL,
`updated_at` int(11) NULL DEFAULT NULL,
PRIMARY KEY (`name`) ,
INDEX `rule_name` (`rule_name`),
INDEX `idx-auth_item-type` (`type`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `auth_item_child` (
`parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (`parent`, `child`) ,
INDEX `child` (`child`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `auth_rule` (
`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
`created_at` int(11) NULL DEFAULT NULL,
`updated_at` int(11) NULL DEFAULT NULL,
PRIMARY KEY (`name`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `auth_assignment` ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`);
ALTER TABLE `auth_item` ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`);
ALTER TABLE `auth_item_child` ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`);
ALTER TABLE `auth_item_child` ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`);

