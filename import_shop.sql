USE `_wshop_test`;

DROP TABLE IF EXISTS `shop`;

CREATE TABLE `shop` (
  `shop_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shop_ref` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `shop_title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `shop_city` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=607 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

insert into `shop`(`shop_id`,`shop_ref`,`shop_title`,`shop_city`) values 
(1, 'shop_1', 'DECATHLON', 'Paris'),
(2, 'shop_2', 'Boîte à chaussures', 'Pau'),
(3, 'shop_3', 'Aroma Zone', 'Toulouse')