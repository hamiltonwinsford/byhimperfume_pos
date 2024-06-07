/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100428
Source Host           : localhost:3306
Source Database       : aplikasi_goldy_pos

Target Server Type    : MYSQL
Target Server Version : 100428
File Encoding         : 65001

Date: 2024-05-31 16:28:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bottle
-- ----------------------------
DROP TABLE IF EXISTS `bottle`;
CREATE TABLE `bottle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bottle_name` varchar(255) DEFAULT NULL,
  `bottle_size` int(11) DEFAULT NULL,
  `bottle_price` decimal(10,2) DEFAULT NULL,
  `bottle_type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of bottle
-- ----------------------------
INSERT INTO `bottle` VALUES ('1', 'Bottle A', '20', null, 'Type A', '2024-05-02 14:38:07', '2024-05-02 07:38:07');
INSERT INTO `bottle` VALUES ('2', 'Bottle A', '4', null, 'Type A', '2024-05-14 13:45:25', '2024-05-14 06:45:25');
INSERT INTO `bottle` VALUES ('3', 'Bottle A', '10', null, 'Type A', '2024-05-14 13:45:35', '2024-05-14 06:45:35');

-- ----------------------------
-- Table structure for branches
-- ----------------------------
DROP TABLE IF EXISTS `branches`;
CREATE TABLE `branches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of branches
-- ----------------------------
INSERT INTO `branches` VALUES ('1', 'Branch A', 'Address', '2024-05-02 02:12:49', '2024-05-02 02:27:24');

-- ----------------------------
-- Table structure for bundles
-- ----------------------------
DROP TABLE IF EXISTS `bundles`;
CREATE TABLE `bundles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `discount_percent` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bundles
-- ----------------------------

-- ----------------------------
-- Table structure for bundle_items
-- ----------------------------
DROP TABLE IF EXISTS `bundle_items`;
CREATE TABLE `bundle_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bundle_id` bigint(20) unsigned DEFAULT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bundle_items_bundle_id_foreign` (`bundle_id`),
  KEY `bundle_items_product_id_foreign` (`product_id`),
  CONSTRAINT `bundle_items_bundle_id_foreign` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`),
  CONSTRAINT `bundle_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bundle_items
-- ----------------------------

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` decimal(11,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of cart
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fragrances_status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'Eau de Toilette (EDT)', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', null, '2024-05-02 02:14:08', '2024-05-02 03:48:11', '1');
INSERT INTO `categories` VALUES ('2', 'Eau de Parfum (EDP)', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', null, '2024-05-02 03:23:24', '2024-05-02 03:48:24', '1');
INSERT INTO `categories` VALUES ('3', 'Perfume', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', null, '2024-05-02 03:23:42', '2024-05-02 03:23:42', '0');
INSERT INTO `categories` VALUES ('4', 'Full Perfume', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', null, '2024-05-02 03:24:00', '2024-05-02 03:24:00', '0');

-- ----------------------------
-- Table structure for current_stock
-- ----------------------------
DROP TABLE IF EXISTS `current_stock`;
CREATE TABLE `current_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `current_stock` decimal(11,3) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of current_stock
-- ----------------------------
INSERT INTO `current_stock` VALUES ('1', '1', '323.979', '2024-05-16 13:21:39', '2024-05-16 06:21:39');
INSERT INTO `current_stock` VALUES ('2', '2', '157.195', '2024-05-16 11:02:26', '2024-05-16 11:02:26');

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('1', 'Kamal', '08123456789', null, null, null, '2024-05-16 04:07:32', '2024-05-16 04:07:32');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for first_stock
-- ----------------------------
DROP TABLE IF EXISTS `first_stock`;
CREATE TABLE `first_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `stock` varchar(255) DEFAULT '',
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of first_stock
-- ----------------------------
INSERT INTO `first_stock` VALUES ('1', '1', '153', '2024-05-15 09:06:54', '2024-05-15 02:06:54');
INSERT INTO `first_stock` VALUES ('2', '2', '154', '2024-05-15 02:07:03', '2024-05-15 02:07:03');
INSERT INTO `first_stock` VALUES ('3', '5', '154', '2024-05-15 02:20:51', '2024-05-15 02:20:51');
INSERT INTO `first_stock` VALUES ('4', '6', '155', '2024-05-15 02:20:58', '2024-05-15 02:20:58');
INSERT INTO `first_stock` VALUES ('5', '7', '155', '2024-05-15 02:21:05', '2024-05-15 02:21:05');

-- ----------------------------
-- Table structure for fragrances
-- ----------------------------
DROP TABLE IF EXISTS `fragrances`;
CREATE TABLE `fragrances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `concentration` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `gram` int(11) DEFAULT NULL,
  `mililiter` int(11) DEFAULT NULL,
  `pump_weight` double DEFAULT NULL,
  `bottle_weight` double DEFAULT NULL,
  `total_weight` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fragrances_bottle_id_foreign` (`product_id`),
  CONSTRAINT `fragrances_bottle_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of fragrances
-- ----------------------------
INSERT INTO `fragrances` VALUES ('1', 'BM32', '5', '2', '114', '570', '10', '30', '154', '2024-05-14 04:15:52', '2024-05-15 02:16:09');
INSERT INTO `fragrances` VALUES ('2', 'BM31', null, '1', null, null, null, null, '153', '2024-05-15 02:17:23', '2024-05-15 02:17:23');
INSERT INTO `fragrances` VALUES ('3', 'BM33', null, '5', null, null, null, null, '155', '2024-05-15 02:19:44', '2024-05-15 02:19:44');
INSERT INTO `fragrances` VALUES ('4', 'BM34', null, '6', null, null, null, null, '154', '2024-05-15 02:20:11', '2024-05-15 02:20:11');
INSERT INTO `fragrances` VALUES ('5', 'BM35', null, '7', null, null, null, null, '155', '2024-05-15 02:20:30', '2024-05-15 02:20:30');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_reset_tokens_table', '1');
INSERT INTO `migrations` VALUES ('3', '2014_10_12_200000_add_two_factor_columns_to_users_table', '1');
INSERT INTO `migrations` VALUES ('4', '2019_08_19_000000_create_failed_jobs_table', '1');
INSERT INTO `migrations` VALUES ('5', '2019_12_14_000001_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` VALUES ('6', '2024_03_09_065251_add_roles_at_users', '1');
INSERT INTO `migrations` VALUES ('7', '2024_03_18_062710_create_categories_table', '1');
INSERT INTO `migrations` VALUES ('8', '2024_03_18_075712_create_products_table', '1');
INSERT INTO `migrations` VALUES ('9', '2024_03_26_051102_create_bundles_table', '1');
INSERT INTO `migrations` VALUES ('10', '2024_03_26_051335_create_bundle_items_table', '1');
INSERT INTO `migrations` VALUES ('11', '2024_03_26_051409_create_promotions_table', '1');
INSERT INTO `migrations` VALUES ('12', '2024_03_26_051432_create_customers_table', '1');
INSERT INTO `migrations` VALUES ('13', '2024_03_26_051500_create_fregrances_table', '1');
INSERT INTO `migrations` VALUES ('14', '2024_03_26_051608_create_branches_table', '1');
INSERT INTO `migrations` VALUES ('15', '2024_03_26_051633_create_transactions_table', '1');
INSERT INTO `migrations` VALUES ('16', '2024_03_26_051654_create_transaction_items_table', '1');
INSERT INTO `migrations` VALUES ('17', '2024_03_26_051715_create_stock_cards_table', '1');
INSERT INTO `migrations` VALUES ('18', '2024_03_26_055506_add_fragrances_status_at_categories', '1');
INSERT INTO `migrations` VALUES ('19', '2024_04_25_014537_add_branch_id_to_user', '1');
INSERT INTO `migrations` VALUES ('20', '2024_04_25_030846_add_branch_id_to_products', '1');

-- ----------------------------
-- Table structure for opname
-- ----------------------------
DROP TABLE IF EXISTS `opname`;
CREATE TABLE `opname` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `g_to_ml` varchar(255) DEFAULT NULL,
  `ml_to_g` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of opname
-- ----------------------------
INSERT INTO `opname` VALUES ('1', '1', '1.055\r\n', '0.948\r\n', '2024-05-15 09:35:32', '2024-05-15 09:35:32');
INSERT INTO `opname` VALUES ('2', '2', '1.064\r\n', '0.94\r\n', '2024-05-15 09:35:39', '2024-05-15 09:35:39');
INSERT INTO `opname` VALUES ('3', '5', '1.037\r\n', '0.964\r\n', '2024-05-15 09:35:45', '2024-05-15 09:35:45');
INSERT INTO `opname` VALUES ('4', '6', '1.064\r\n', '0.94\r\n', '2024-05-15 09:35:51', '2024-05-15 09:35:51');
INSERT INTO `opname` VALUES ('5', '7', '1.004\r\n', '0.996\r\n', '2024-05-15 09:35:57', '2024-05-15 09:35:57');

-- ----------------------------
-- Table structure for other_product
-- ----------------------------
DROP TABLE IF EXISTS `other_product`;
CREATE TABLE `other_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` varchar(255) DEFAULT NULL,
  `product_description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of other_product
-- ----------------------------
INSERT INTO `other_product` VALUES ('1', 'Product A', '100000', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content', '_20240504022119.jpg', '2024-05-04 02:21:19', '2024-05-04 02:21:19');

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` bigint(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_favorite` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_branch_id_foreign` (`branch_id`),
  CONSTRAINT `products_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', '1', 'BM31', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', null, '500', '1', '1', '1', '2024-05-02 02:14:31', '2024-05-15 02:15:56', '1');
INSERT INTO `products` VALUES ('2', '1', 'BM32', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', '_20240514041552.jpg', '300', '1', '1', '1', '2024-05-14 04:15:52', '2024-05-15 02:16:09', '1');
INSERT INTO `products` VALUES ('5', '1', 'BM33', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', null, '450', '1', '1', '1', '2024-05-15 02:19:44', '2024-05-15 02:19:44', '1');
INSERT INTO `products` VALUES ('6', '1', 'BM34', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', null, '500', '1', '1', '1', '2024-05-15 02:20:11', '2024-05-15 02:20:11', '1');
INSERT INTO `products` VALUES ('7', '1', 'BM35', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', null, '400', '1', '1', '1', '2024-05-15 02:20:30', '2024-05-15 02:20:30', '1');

-- ----------------------------
-- Table structure for promotions
-- ----------------------------
DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `discount_percent` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of promotions
-- ----------------------------
INSERT INTO `promotions` VALUES ('1', 'Promotions A', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', '2024-05-23', '2024-05-25', '10.00', '2024-05-14 04:12:06', '2024-05-14 04:13:32');

-- ----------------------------
-- Table structure for promotion_bundle
-- ----------------------------
DROP TABLE IF EXISTS `promotion_bundle`;
CREATE TABLE `promotion_bundle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_promotion` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `other_product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of promotion_bundle
-- ----------------------------
INSERT INTO `promotion_bundle` VALUES ('1', 'Promo Idul Adha', '1', '2', '400000.00', '2024-05-31', '2024-06-15', '2024-05-31 13:14:54', '2024-05-31 13:14:54', null);

-- ----------------------------
-- Table structure for seeds
-- ----------------------------
DROP TABLE IF EXISTS `seeds`;
CREATE TABLE `seeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seed_code` varchar(255) DEFAULT NULL,
  `seed_name` varchar(255) DEFAULT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `density` varchar(255) DEFAULT NULL,
  `dispenser_weight` double DEFAULT NULL,
  `total_ml` varchar(255) DEFAULT NULL,
  `total_gram` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of seeds
-- ----------------------------
INSERT INTO `seeds` VALUES ('1', '9038234', 'Name A', 'Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', '20', '20', '20', '20', '2024-05-02 10:47:10', '2024-05-02 03:47:10');

-- ----------------------------
-- Table structure for stock_cards
-- ----------------------------
DROP TABLE IF EXISTS `stock_cards`;
CREATE TABLE `stock_cards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `fragrance_id` bigint(20) unsigned DEFAULT NULL,
  `stock_in` int(11) DEFAULT NULL,
  `stock_out` int(11) DEFAULT NULL,
  `calc_g` varchar(255) DEFAULT NULL,
  `calc_ml` varchar(255) DEFAULT NULL,
  `real_g` varchar(255) DEFAULT NULL,
  `real_ml` varchar(255) DEFAULT NULL,
  `difference_g` varchar(255) DEFAULT '',
  `difference_ml` varchar(255) DEFAULT '',
  `stock_opname_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_cards_product_id_foreign` (`product_id`),
  KEY `stock_cards_branch_id_foreign` (`branch_id`),
  KEY `stock_cards_fragrance_id_foreign` (`fragrance_id`),
  CONSTRAINT `stock_cards_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `stock_cards_fragrance_id_foreign` FOREIGN KEY (`fragrance_id`) REFERENCES `fragrances` (`id`),
  CONSTRAINT `stock_cards_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of stock_cards
-- ----------------------------
INSERT INTO `stock_cards` VALUES ('1', '1', '1', '2', '233', '227', '227', '240', '217', '228.935', '-10.14', '-10.7', null, null, null);
INSERT INTO `stock_cards` VALUES ('2', '2', '1', '1', '0', '6', '148', '156', '149', '157.159', '0.688', '0.7258', null, null, null);
INSERT INTO `stock_cards` VALUES ('3', '1', '1', null, '145', '50', '250.6', '237.5688', '153', '145.044', '', '', '2024-05-16', '2024-05-16 06:21:07', '2024-05-16 06:21:07');
INSERT INTO `stock_cards` VALUES ('4', '1', '1', null, '145', '50', '250.6', '237.5688', '153', '145.044', '', '', '2024-05-16', '2024-05-16 06:21:39', '2024-05-16 06:21:39');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_supplier` varchar(255) DEFAULT NULL,
  `no_telp_supplier` varchar(255) DEFAULT NULL,
  `address_supplier` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('1', 'Supplier A', '08123456789', 'Alamat Lengkap', '2024-05-02 13:32:18', '2024-05-02 06:32:18');

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_number` varchar(255) DEFAULT '',
  `transaction_date` date DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `customer_id` bigint(20) unsigned DEFAULT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  KEY `transactions_customer_id_foreign` (`customer_id`),
  KEY `transactions_branch_id_foreign` (`branch_id`),
  CONSTRAINT `transactions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  CONSTRAINT `transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES ('10', 'INV/20240516/585', '2024-05-24', '2', '1', '1', '25000.00', '0.00', '1', '2024-05-16 04:09:22', '2024-05-16 04:09:22');
INSERT INTO `transactions` VALUES ('11', 'INV/20240516/585', '2024-05-31', '2', '1', '1', '50000.00', '0.00', '1', '2024-05-16 04:09:22', '2024-05-16 04:09:22');

-- ----------------------------
-- Table structure for transaction_items
-- ----------------------------
DROP TABLE IF EXISTS `transaction_items`;
CREATE TABLE `transaction_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) unsigned DEFAULT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `discount_amount` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_items_transaction_id_foreign` (`transaction_id`),
  KEY `transaction_items_product_id_foreign` (`product_id`),
  CONSTRAINT `transaction_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `transaction_items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of transaction_items
-- ----------------------------
INSERT INTO `transaction_items` VALUES ('1', '10', '1', '50', '500.00', '25000.00', null, '2024-05-16 04:09:22', '2024-05-16 04:09:22');
INSERT INTO `transaction_items` VALUES ('2', '11', '1', '50', '500.00', '50000.00', null, '2024-05-16 04:09:22', '2024-05-16 04:09:22');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user','staff') NOT NULL DEFAULT 'user',
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_branch_id_foreign` (`branch_id`),
  CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Admin', 'admin@gmail.com', null, '$2y$10$l6cYkyCvWoWTt9pfDx2dcOz7.xn9h5M5VsOZe3qYpt5iI3FKQABzO', null, null, null, null, null, '2024-05-02 02:14:53', 'admin', null);
INSERT INTO `users` VALUES ('2', 'Kamal', 'kamal@gmail.com', null, '$2y$12$rbjHlVN9ui7/4v/ooeiA/OCcJENJbS0yeO2MmP.KCg1ZPRUb8GFju', null, null, null, null, '2024-05-02 02:15:34', '2024-05-04 03:08:50', 'staff', '1');
INSERT INTO `users` VALUES ('3', 'Bambang', 'bambang@gmail.com', null, '$2y$12$ZLjdizp.sUeFPFssWCF.Z.HN94hPurSUTZ8hXMTHNyQMk/D3kae.2', null, null, null, null, '2024-05-02 02:19:54', '2024-05-04 02:50:07', 'user', null);
INSERT INTO `users` VALUES ('4', 'Ica', 'ica@gmail.com', null, '$2y$10$l6cYkyCvWoWTt9pfDx2dcOz7.xn9h5M5VsOZe3qYpt5iI3FKQABzO', null, null, null, null, null, '2024-05-04 03:06:10', 'user', '1');
SET FOREIGN_KEY_CHECKS=1;
