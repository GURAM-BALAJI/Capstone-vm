-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2022 at 12:13 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pesu_vend1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` bigint(20) NOT NULL,
  `admin_email` varchar(1100) NOT NULL,
  `admin_password` varchar(2000) NOT NULL,
  `admin_name` varchar(1100) NOT NULL,
  `admin_phone` bigint(50) NOT NULL,
  `admin_photo` varchar(5000) NOT NULL,
  `admin_dob` date NOT NULL,
  `admin_status` tinyint(1) NOT NULL,
  `users_view` tinyint(1) NOT NULL,
  `users_create` tinyint(1) NOT NULL,
  `users_edit` tinyint(1) NOT NULL,
  `users_del` tinyint(1) NOT NULL,
  `admin_view` tinyint(1) NOT NULL,
  `admin_create` tinyint(1) NOT NULL,
  `admin_edit` tinyint(1) NOT NULL,
  `admin_del` tinyint(1) NOT NULL,
  `items_view` tinyint(1) NOT NULL,
  `items_create` tinyint(1) NOT NULL,
  `items_edit` tinyint(1) NOT NULL,
  `items_del` tinyint(1) NOT NULL,
  `users_special` tinyint(1) NOT NULL,
  `admin_special` tinyint(1) NOT NULL,
  `contact_view` tinyint(1) NOT NULL,
  `contact_edit` tinyint(1) NOT NULL,
  `message_view` tinyint(1) NOT NULL,
  `admin_delete` tinyint(1) NOT NULL,
  `admin_added_date` varchar(20) NOT NULL,
  `admin_updated_date` varchar(20) NOT NULL,
  `display_items_view` tinyint(1) NOT NULL,
  `display_items_edit` tinyint(1) NOT NULL,
  `display_items_create` tinyint(1) NOT NULL,
  `display_items_del` tinyint(1) NOT NULL,
  `history_view` tinyint(1) NOT NULL,
  `orders_view` tinyint(1) NOT NULL,
  `slogan_view` tinyint(1) NOT NULL,
  `slogan_create` tinyint(1) NOT NULL,
  `slogan_edit` tinyint(1) NOT NULL,
  `slogan_del` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_password`, `admin_name`, `admin_phone`, `admin_photo`, `admin_dob`, `admin_status`, `users_view`, `users_create`, `users_edit`, `users_del`, `admin_view`, `admin_create`, `admin_edit`, `admin_del`, `items_view`, `items_create`, `items_edit`, `items_del`, `users_special`, `admin_special`, `contact_view`, `contact_edit`, `message_view`, `admin_delete`, `admin_added_date`, `admin_updated_date`, `display_items_view`, `display_items_edit`, `display_items_create`, `display_items_del`, `history_view`, `orders_view`, `slogan_view`, `slogan_create`, `slogan_edit`, `slogan_del`) VALUES
(1, 'admin@admin.com', '$2y$10$m.Jujnxf/DOaszWax9UrFuIY1KOPUC5/TcqlKRXafFghtYC1klp8q', 'Elon', 96969696, 'kevin-fitzgerald-Z4CfUB0U9aA-unsplash.jpg', '2020-11-10', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, '2021-01-04', '29-07-2022 09:19:21 ', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

--
-- Triggers `admin`
--
DELIMITER $$
CREATE TRIGGER `active_admin` BEFORE UPDATE ON `admin` FOR EACH ROW UPDATE logs SET logs.logs_inactive_admin=logs.logs_inactive_admin+1 WHERE OLD.admin_status=1 AND NEW.admin_status=0
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleted_admin` AFTER UPDATE ON `admin` FOR EACH ROW UPDATE logs SET logs_active_admin=logs.logs_active_admin-1 WHERE NEW.admin_delete = 1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inactive_admin` BEFORE UPDATE ON `admin` FOR EACH ROW UPDATE logs SET logs.logs_inactive_admin=logs.logs_inactive_admin-1 WHERE OLD.admin_status=0 AND NEW.admin_status=1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inactive_admin_on_delete` BEFORE UPDATE ON `admin` FOR EACH ROW UPDATE logs SET logs_inactive_admin=logs.logs_inactive_admin-1 WHERE NEW.admin_status = 0 AND NEW.admin_delete = 1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_admin` AFTER INSERT ON `admin` FOR EACH ROW UPDATE logs SET logs_active_admin=logs.logs_active_admin+1
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` bigint(20) NOT NULL,
  `cart_spring_id` int(11) NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `cart_user_id` bigint(20) NOT NULL,
  `cart_added_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` bigint(20) NOT NULL,
  `contact_name` varchar(2000) NOT NULL,
  `contact_email` varchar(2000) NOT NULL,
  `contact_phone` varchar(100) NOT NULL,
  `contact_subject` varchar(20000) NOT NULL,
  `contact_view` tinyint(1) NOT NULL,
  `contact_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contact_id`, `contact_name`, `contact_email`, `contact_phone`, `contact_subject`, `contact_view`, `contact_date`) VALUES
(32, 'Pradeep RS', 'pradeeprs176@gmail.com', '07619321936', 'dffgxcz', 1, '2022-07-27 00:00:00'),
(33, 'Pradeep RS', 'pradeeprs176@gmail.com', '07619321936', 'sadds', 1, '2022-07-26 00:00:00'),
(34, 'Wedding Photography', 'admin@admin.com', '23424242424', 'gedsfdsg', 1, '2022-07-27 11:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `display_items`
--

CREATE TABLE `display_items` (
  `display_id` bigint(20) NOT NULL,
  `display_items_id` bigint(20) NOT NULL,
  `display_items_add_date` varchar(20) NOT NULL,
  `display_items_updated_date` varchar(20) NOT NULL,
  `display_spring_id` bigint(20) NOT NULL,
  `display_items_qty` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `display_items`
--

INSERT INTO `display_items` (`display_id`, `display_items_id`, `display_items_add_date`, `display_items_updated_date`, `display_spring_id`, `display_items_qty`) VALUES
(3, 3, '25-07-2022 09:31:37 ', '27-07-2022 11:38:04 ', 4, 6),
(4, 2, '27-07-2022 11:37:42 ', '27-07-2022 11:37:42 ', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `history_id` varchar(25) NOT NULL,
  `history_qty` varchar(100) NOT NULL,
  `history_cost` varchar(100) NOT NULL,
  `history_item` varchar(100) NOT NULL,
  `history_date` datetime NOT NULL,
  `history_delivered` int(11) NOT NULL DEFAULT 0,
  `history_user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`history_id`, `history_qty`, `history_cost`, `history_item`, `history_date`, `history_delivered`, `history_user_id`) VALUES
('53aP5sziI0SCTJP', '1,1', '50,30', '3,4', '2022-07-31 04:15:19', 2, 131),
('93KUAPnxYJhawFu', '1', '50', '3', '2022-08-02 10:44:31', 2, 131),
('ccFb205xntrgPa1', '1', '30', '4', '2022-07-31 08:23:32', 1, 131),
('cTIhJoddGRVyeCC', '1', '50', '3', '2022-07-31 08:13:02', 3, 131),
('FMM1w6VpjUsKNtf', '1', '30', '4', '2022-07-31 08:21:57', 2, 131),
('GjHkR0ozJyfd9ck', '1', '50', '3', '2022-07-31 04:14:41', 2, 131),
('Hr9SYyG8PxcvvPA', '4', '30', '4', '2022-07-31 08:16:04', 3, 131),
('I66f4pLV4d7fx2I', '1', '50', '3', '2022-08-02 09:56:43', 2, 131),
('IjmvMqelcUrodhr', '3', '30', '4', '2022-07-31 08:17:12', 1, 131),
('iZfLERSfnBFp1UC', '1', '50', '3', '2022-07-31 04:11:21', 2, 131),
('MSn2BkPMJf8ohnD', '1', '50', '3', '2022-07-31 01:40:15', 3, 131),
('ONIeCzCEaEAUW7Q', '1', '50', '3', '2022-07-31 03:47:51', 1, 131),
('QEiunXAeSfOauZ8', '1', '30', '4', '2022-07-31 04:21:32', 2, 131),
('Tql3HOadwKgK9yU', '1', '50', '3', '2022-08-03 01:51:51', 2, 131),
('WNSPJyBl3q8TQb2', '1', '50', '3', '2022-08-02 10:52:48', 2, 131);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `items_id` bigint(20) NOT NULL,
  `items_name` varchar(5010) NOT NULL,
  `items_image` varchar(1000) NOT NULL,
  `items_cost` bigint(20) NOT NULL,
  `items_delete` tinyint(1) NOT NULL,
  `items_add_date` varchar(20) NOT NULL,
  `items_updated_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`items_id`, `items_name`, `items_image`, `items_cost`, `items_delete`, `items_add_date`, `items_updated_date`) VALUES
(1, 'brike', '2022-03-02_1646238597.jpg', 20, 1, '2022-03-02 21:59:57', ''),
(2, 'Green Lays', '2022-07-25_1658771252.png', 30, 0, '2022-03-02 22:08:54', '25-07-2022 11:17:32 '),
(3, 'Butter Biscuits ', '2022-07-25_1658765093.jpeg', 50, 0, '25-07-2022 09:28:32 ', '25-07-2022 09:44:08 ');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `logs_id` int(11) NOT NULL,
  `logs_order` int(11) NOT NULL,
  `logs_active_users` int(11) NOT NULL,
  `logs_inactive_users` int(11) NOT NULL,
  `logs_active_admin` int(11) NOT NULL,
  `logs_inactive_admin` int(11) NOT NULL,
  `logs_amount` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`logs_id`, `logs_order`, `logs_active_users`, `logs_inactive_users`, `logs_active_admin`, `logs_inactive_admin`, `logs_amount`) VALUES
(1, 1, 2, 0, 1, 0, 10790);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(20) NOT NULL,
  `message` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `message`) VALUES
(1, ' '),
(2, ''),
(3, 'hey!!, join us www.pesuvend.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` varchar(25) NOT NULL,
  `orders_qty` varchar(100) NOT NULL,
  `orders_cost` varchar(100) NOT NULL,
  `orders_items` varchar(100) NOT NULL,
  `orders_user_id` bigint(20) NOT NULL,
  `orders_date` datetime NOT NULL,
  `orders_delivered` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `orders_qty`, `orders_cost`, `orders_items`, `orders_user_id`, `orders_date`, `orders_delivered`) VALUES
('Up5ibHfBSRnMMjb', '2', '50', '3', 131, '2022-08-03 01:52:08', 0);

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `deleted_order` AFTER DELETE ON `orders` FOR EACH ROW UPDATE logs SET logs_order=logs.logs_order-1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleted_order_insert_history` BEFORE DELETE ON `orders` FOR EACH ROW INSERT INTO history (`history_id`,`history_qty`,`history_cost`,`history_item`,`history_date`,`history_delivered`,`history_user_id`) VALUES (OLD.orders_id,OLD.orders_qty,OLD.orders_cost,OLD.orders_items,OLD.orders_date,OLD.orders_delivered,OLD.orders_user_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_order` AFTER INSERT ON `orders` FOR EACH ROW UPDATE logs SET logs_order=logs.logs_order+1
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `semopher`
--

CREATE TABLE `semopher` (
  `semopher_id` int(11) NOT NULL,
  `semopher_value` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semopher`
--

INSERT INTO `semopher` (`semopher_id`, `semopher_value`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sessionss`
--

CREATE TABLE `sessionss` (
  `sessions_id` bigint(20) NOT NULL,
  `sessions_user_id` bigint(20) NOT NULL,
  `sessions_cookies_id` varchar(40) NOT NULL,
  `sessions_created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessionss`
--

INSERT INTO `sessionss` (`sessions_id`, `sessions_user_id`, `sessions_cookies_id`, `sessions_created_date`) VALUES
(1, 131, 'ac21cb966d06570e1311659477864', '2022-08-03 03:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `slogan`
--

CREATE TABLE `slogan` (
  `slogan_id` int(11) NOT NULL,
  `slogan_sentance` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slogan`
--

INSERT INTO `slogan` (`slogan_id`, `slogan_sentance`) VALUES
(2, 'Your stomach is not a dustbin; fill it with some healthy stuff.'),
(3, 'Your stomach shouldn\'t be a waist basket.'),
(4, 'No development with an empty stomach'),
(5, 'Don\'t let your hungry stomach quake, come along and buy some snack!'),
(6, 'Your stomach needs me'),
(7, 'Listen to your stomach, it\'s calling for Magnesium'),
(8, 'It will fill your stomach as well as your heart.'),
(9, 'Don\'t make your stomach a dustbin, eat right and healthy.'),
(10, 'Don\'t use your stomach as a trash can!'),
(11, 'Junk belongs in the trash, not in your stomach! '),
(12, 'Makes your stomach feel good.'),
(13, 'Take your stomach on a joy ride with yummy.'),
(14, 'Give your stomach the taste of love.'),
(15, 'The urge to fill your hungry stomach.'),
(16, 'A Trendy snack means Hungry Stomach.'),
(17, 'We are for your hungry stomach'),
(18, 'You cant live a full life on an empty stomach.'),
(19, 'Good Stomach Good Digest'),
(20, 'We cant stomach this find a cure.'),
(21, 'A day is best started on a full stomach.'),
(22, 'A full stomach means a happy heart. Happy Day.'),
(23, 'Your Stomach Is Empty.');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` bigint(20) NOT NULL,
  `transaction_user_id` bigint(20) NOT NULL,
  `transaction_send_to` varchar(1100) NOT NULL,
  `transaction_amount` varchar(2000) NOT NULL,
  `transaction_order` varchar(25) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `transaction_added_by` bigint(20) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `transaction_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `transaction_user_id`, `transaction_send_to`, `transaction_amount`, `transaction_order`, `transaction_date`, `transaction_added_by`, `transaction_type`, `transaction_status`) VALUES
(201, 131, '', '500.00', 'NB', '2022-07-25 18:20:01', 131, 5, 'TXN_SUCCESS'),
(202, 131, '', '100.00', 'NB', '2022-07-25 18:20:33', 131, 0, 'TXN_SUCCESS'),
(203, 131, '', '900.00', 'NB', '2022-07-25 21:59:15', 131, 0, 'TXN_SUCCESS'),
(204, 131, '', '200.00', 'NB', '2022-07-25 21:59:36', 131, 5, 'TXN_SUCCESS'),
(205, 131, '', '300.00', 'NB', '2022-07-25 22:00:03', 131, 5, 'TXN_SUCCESS'),
(206, 131, '', '500.00', 'NB', '2022-07-25 22:01:12', 131, 5, 'TXN_SUCCESS'),
(207, 131, '12345675342', '-1000', 'pay friend', '2022-07-25 10:29:05', 131, 2, ''),
(208, 132, '9108667341', '1000', 'pay friend', '2022-07-25 10:29:05', 131, 2, ''),
(209, 132, '9108667341', '-1010', 'pay friend', '2022-07-25 10:37:11', 132, 2, ''),
(210, 131, '12345675342', '1010', 'pay friend', '2022-07-25 10:37:11', 132, 2, ''),
(211, 131, '', '200.00', 'NB', '2022-07-26 15:29:59', 131, 5, 'TXN_SUCCESS'),
(212, 131, 'Recharged', '100.00', 'NB', '2022-07-26 15:36:19', 131, 0, 'TXN_SUCCESS'),
(213, 131, 'Order', '130', 'Ordered', '0000-00-00 00:00:00', 131, 1, ''),
(214, 131, 'Order', '30', 'Ordered', '0000-00-00 00:00:00', 131, 1, ''),
(215, 131, 'Order', '30', 'Ordered', '2022-07-27 03:06:48', 131, 1, ''),
(216, 131, 'Order', '30', 'Ordered', '2022-07-27 15:07:59', 131, 1, ''),
(217, 131, 'Order', '30', 'Ordered', '2022-07-27 03:09:17', 131, 1, ''),
(218, 134, '0', '43', 'login', '0000-00-00 00:00:00', 1, 0, ''),
(219, 132, 'Added Manually', '100', 'add amount', '0000-00-00 00:00:00', 1, 0, ''),
(220, 132, 'Added Manually', '-10', 'add amount', '0000-00-00 00:00:00', 1, 0, ''),
(221, 132, 'Added Manually', '10', 'add amount', '0000-00-00 00:00:00', 1, 0, ''),
(222, 131, 'Added Manually', '-30', 'add amount', '0000-00-00 00:00:00', 1, 0, ''),
(223, 132, 'Added Manually', '-100', 'add amount', '0000-00-00 00:00:00', 1, 0, ''),
(224, 131, 'Order', '50', 'Ordered', '2022-07-27 04:49:59', 131, 1, ''),
(225, 132, 'Added Manually', '10', 'add amount', '0000-00-00 00:00:00', 1, 0, ''),
(226, 131, 'Recharged', '100.00', 'NB', '2022-07-27 23:18:09', 131, 0, 'TXN_SUCCESS'),
(227, 131, '12345675342', '-1000', 'pay friend', '2022-07-27 11:18:46', 131, 2, ''),
(228, 132, '9108667341', '1000', 'pay friend', '2022-07-27 11:18:46', 131, 2, ''),
(229, 131, 'Recharged', '100.00', 'NB', '2022-07-28 21:02:31', 131, 0, 'TXN_SUCCESS'),
(230, 131, 'Recharged', '100.00', 'NB', '2022-07-28 21:03:04', 131, 0, 'TXN_SUCCESS'),
(231, 131, 'Recharged', '100.00', 'NB', '2022-07-28 21:03:21', 131, 0, 'TXN_SUCCESS'),
(232, 131, 'Recharged', '100.00', 'NB', '2022-07-28 21:03:38', 131, 0, 'TXN_SUCCESS'),
(233, 131, 'Recharged', '100', 'ORDS85163882', '2022-07-28 10:22:17', 131, 5, 'TXN_INIT'),
(234, 131, 'Recharged', '100', 'ORDS89951854', '2022-07-28 10:29:00', 131, 5, 'TXN_INIT'),
(235, 131, 'Recharged', '50', 'ORDS99899930', '2022-07-28 10:32:02', 131, 5, 'TXN_SUCCESS'),
(236, 131, 'Recharged', '100', 'ORDS38341480', '2022-07-28 10:32:22', 131, 5, 'TXN_INIT'),
(237, 131, 'Recharged', '50', 'ORDS90064865', '2022-07-28 10:34:21', 131, 5, 'TXN_INIT'),
(238, 131, 'Recharged', '100', 'ORDS9474214', '2022-07-28 10:34:43', 131, 5, 'TXN_INIT'),
(239, 131, 'Recharged', '100', 'ORDS12783727', '2022-07-28 10:37:54', 131, 5, 'TXN_SUCCESS'),
(240, 131, 'Recharged', '100', 'ORDS73871561', '2022-07-28 10:43:21', 131, 5, 'TXN_INIT'),
(241, 131, 'Recharged', '100', 'ORDS86072762', '2022-07-28 10:48:21', 131, 5, 'TXN_SUCCESS'),
(242, 131, 'Recharged', '100', 'ORDS12440641', '2022-07-28 10:52:07', 131, 5, 'TXN_FAILURE'),
(243, 131, 'Recharged', '100', 'ORDS47401475', '2022-07-28 10:53:42', 131, 5, 'TXN_FAILURE'),
(244, 131, 'Recharged', '100', '131741541659029455', '2022-07-28 11:00:55', 131, 5, 'TXN_SUCCESS'),
(245, 131, 'Recharged', '100', '131261531659029777', '2022-07-28 23:06:20', 131, 5, 'TXN_SUCCESS'),
(246, 131, 'Recharged', '100', '131761051659029829', '2022-07-28 23:07:13', 131, 5, 'TXN_SUCCESS'),
(247, 131, 'Recharged', '100', '131449171659030665', '2022-07-28 11:21:05', 131, 5, 'TXN_INIT'),
(248, 131, 'Recharged', '100', '131812131659030787', '0000-00-00 00:00:00', 131, 5, 'TXN_SUCCESS'),
(249, 131, 'Recharged', '500', '131725381659030870', '2022-07-28 23:24:33', 131, 5, 'TXN_SUCCESS'),
(100000, 131, 'Order', '50', '', '2022-07-30 07:49:51', 131, 1, ''),
(100001, 131, 'Order', '50', '', '2022-07-30 07:52:26', 131, 1, ''),
(100002, 131, 'Order', '100', '', '2022-07-30 09:37:17', 131, 1, ''),
(100003, 131, 'Order', '50', '', '2022-07-30 10:45:32', 131, 1, ''),
(100004, 131, 'Order', '50', '', '2022-07-30 11:54:06', 131, 1, ''),
(100005, 131, 'Order', '50', '', '2022-07-31 12:44:59', 131, 1, ''),
(100006, 131, 'Order', '220', '', '2022-07-31 12:48:38', 131, 1, ''),
(100007, 131, 'Order', '50', '', '2022-07-31 12:53:41', 131, 1, ''),
(100008, 131, 'Order', '-100', '', '2022-07-31 01:24:43', 131, 1, ''),
(100009, 131, 'Refunded', '100', '', '2022-07-31 01:27:13', 131, 1, ''),
(100010, 131, 'Refunded', '100', '', '2022-07-31 01:27:15', 131, 1, ''),
(100011, 131, 'Refunded', '100', '', '2022-07-31 01:27:53', 131, 1, ''),
(100012, 131, 'Order', '-50', '', '2022-07-31 01:29:33', 131, 1, ''),
(100013, 131, 'Refunded', '50', '', '2022-07-31 01:30:33', 131, 1, ''),
(100014, 131, 'Order', '-50', '', '2022-07-31 01:31:28', 131, 1, ''),
(100015, 131, 'Refunded', '50', '', '2022-07-31 01:32:03', 131, 1, ''),
(100016, 131, 'Order', '-50', '', '2022-07-31 01:32:30', 131, 1, ''),
(100017, 131, 'Refunded', '50', '', '2022-07-31 01:33:32', 131, 1, ''),
(100018, 131, 'Order', '-50', '', '2022-07-31 01:35:27', 131, 1, ''),
(100019, 131, 'Refunded', '50', '', '2022-07-31 01:36:27', 131, 1, ''),
(100020, 131, 'Order', '-50', '', '2022-07-31 01:40:15', 131, 1, ''),
(100021, 131, 'Refunded', '50', '', '2022-07-31 01:55:15', 131, 1, ''),
(100022, 131, 'Order', '-50', '', '2022-07-31 03:47:51', 131, 1, ''),
(100023, 131, 'Order', '-50', '', '2022-07-31 04:11:21', 131, 1, ''),
(100024, 131, 'Refunded', '50', '', '2022-07-31 04:12:19', 131, 1, ''),
(100025, 131, 'Order', '-50', '', '2022-07-31 04:14:41', 131, 1, ''),
(100026, 131, 'Refunded', '50', '', '2022-07-31 04:14:43', 131, 1, ''),
(100027, 131, 'Order', '-80', '', '2022-07-31 04:15:19', 131, 1, ''),
(100028, 131, 'Refunded', '80', '', '2022-07-31 04:21:16', 131, 1, ''),
(100029, 131, 'Order', '-30', '', '2022-07-31 04:21:32', 131, 1, ''),
(100030, 131, 'Refunded', '30', '', '2022-07-31 04:21:45', 131, 1, ''),
(100031, 131, 'Order', '-50', '', '2022-07-31 08:13:02', 131, 1, ''),
(100032, 131, 'Refunded', '50', '', '2022-07-31 08:13:15', 131, 1, ''),
(100033, 131, 'Order', '-120', '', '2022-07-31 08:16:04', 131, 1, ''),
(100034, 131, 'Refunded', '120', '', '2022-07-31 08:16:17', 131, 1, ''),
(100035, 131, 'Order', '-90', '', '2022-07-31 08:17:12', 131, 1, ''),
(100036, 131, 'Order', '-30', '', '2022-07-31 08:21:57', 131, 1, ''),
(100037, 131, 'Refunded', '30', '', '2022-07-31 08:23:23', 131, 1, ''),
(100038, 131, 'Order', '-30', '', '2022-07-31 08:23:32', 131, 1, ''),
(100039, 131, 'Ordered', '-50', 'I66f4pLV4d7fx2I', '2022-08-02 09:56:43', 131, 1, ''),
(100040, 131, 'Refunded', '50', '', '2022-08-02 09:59:18', 131, 3, ''),
(100041, 131, 'Ordered', '-50', '93KUAPnxYJhawFu', '2022-08-02 09:59:31', 131, 1, ''),
(100042, 131, 'Refunded', '50', '', '2022-08-02 10:52:43', 131, 3, ''),
(100043, 131, 'Ordered', '-50', 'WNSPJyBl3q8TQb2', '2022-08-02 10:52:48', 131, 1, ''),
(100044, 131, 'Refunded', '50', '', '2022-08-02 10:54:24', 131, 3, ''),
(100045, 131, 'Ordered', '-50', 'Tql3HOadwKgK9yU', '2022-08-03 01:51:51', 131, 1, ''),
(100046, 131, 'Refunded', '50', '', '2022-08-03 01:52:00', 131, 3, ''),
(100047, 131, 'Ordered', '-100', 'Up5ibHfBSRnMMjb', '2022-08-03 01:52:08', 131, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `user_email` varchar(5000) NOT NULL,
  `user_password` varchar(5000) NOT NULL,
  `name` varchar(500) NOT NULL,
  `user_phone` varchar(50) NOT NULL,
  `user_status` tinyint(1) NOT NULL,
  `user_photo` varchar(2000) NOT NULL,
  `user_delete` tinyint(1) NOT NULL,
  `user_added_date` varchar(20) NOT NULL,
  `user_updated_date` varchar(20) NOT NULL,
  `user_amount` bigint(20) NOT NULL,
  `updated_by_id` bigint(20) NOT NULL,
  `user_token` varchar(255) NOT NULL,
  `user_semaphore` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_password`, `name`, `user_phone`, `user_status`, `user_photo`, `user_delete`, `user_added_date`, `user_updated_date`, `user_amount`, `updated_by_id`, `user_token`, `user_semaphore`) VALUES
(131, 'Balaji@gmail.com', '$2y$10$Sz/BnYaiAvH4gd/AQNDNLuYiu5Iwk7/a0eb3neXy.iF.mfyMMBIMC', 'Balaji', '9108667341', 1, '', 0, '16-07-2022 01:38:13 ', '03-08-2022 02:51:23 ', 9780, 1, '0', 0),
(132, 'srinivas@gmail.com', '$2y$10$m.Jujnxf/DOaszWax9UrFuIY1KOPUC5/TcqlKRXafFghtYC1klp8q', 'srinivas', '12345675342', 1, '2022-07-25_1658767797.jpg', 0, '25-07-2022 10:16:36 ', '25-07-2022 10:16:36 ', 1010, 1, '', 0),
(134, 'pppp@gmail.com', '$2y$10$Xr/7cZHgoU/GePK5.WcNSeyO0mK7Shdvu0aBR6KHNDDQXtsLlx47O', 'Pradeep RS', '8660901237', 0, '', 1, '27-07-2022 04:00:51 ', '27-07-2022 04:00:51 ', 43, 0, '', 0);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `active_users` BEFORE UPDATE ON `users` FOR EACH ROW UPDATE logs SET logs.logs_inactive_users=logs.logs_inactive_users+1 WHERE OLD.user_status=1 AND NEW.user_status=0
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `amount_update` BEFORE UPDATE ON `users` FOR EACH ROW UPDATE logs SET logs_amount=(logs_amount+(NEW.user_amount-OLD.user_amount)) WHERE NEW.user_amount!=OLD.user_amount
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleted_users` AFTER UPDATE ON `users` FOR EACH ROW UPDATE logs SET logs_active_users=logs.logs_active_users-1 WHERE NEW.user_delete = 1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inactive_users` BEFORE UPDATE ON `users` FOR EACH ROW UPDATE logs SET logs.logs_inactive_users=logs.logs_inactive_users-1 WHERE OLD.user_status=0 AND NEW.user_status=1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inactive_users_on_delete` BEFORE UPDATE ON `users` FOR EACH ROW UPDATE logs SET logs_inactive_users=logs.logs_inactive_users-1 WHERE NEW.user_status = 0 AND NEW.user_delete = 1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_user` AFTER INSERT ON `users` FOR EACH ROW UPDATE logs SET logs_active_users=logs.logs_active_users+1
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `display_items`
--
ALTER TABLE `display_items`
  ADD PRIMARY KEY (`display_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`items_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sessions_id`);

--
-- Indexes for table `slogan`
--
ALTER TABLE `slogan`
  ADD PRIMARY KEY (`slogan_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100035;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `display_items`
--
ALTER TABLE `display_items`
  MODIFY `display_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `items_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `sessions_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slogan`
--
ALTER TABLE `slogan`
  MODIFY `slogan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100048;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
