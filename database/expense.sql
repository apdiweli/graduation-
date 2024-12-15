-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2023 at 01:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expense`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `check_user_action_sp` (IN `_userId` VARCHAR(50) CHARSET utf8, IN `_link` VARCHAR(250) CHARSET utf8, IN `_action` VARCHAR(250) CHARSET utf8)   BEGIN

if EXISTS(SELECT system_links.link FROM user_authority LEFT JOIN system_actions ON user_authority.action = system_actions.id LEFT JOIN system_links ON system_actions.link_id = system_links.id WHERE user_authority.user_id = _userId AND system_links.link = _link AND system_actions.action = _action)THEN

SELECT 'Allow' as Message;


ELSE

SELECT 'Deny' As Message;


END if;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_authorities_sp` (IN `_userId` VARCHAR(250) CHARSET utf8)   BEGIN

SELECT category.id category_id,category.name category_name,`category`.`role`,system_links.id link_id,system_links.name link_name,system_actions.id action_id,system_actions.name action_name  FROM `user_authority` LEFT JOIN system_actions ON user_authority.action = system_actions.id LEFT JOIN system_links on system_actions.link_id = system_links.id LEFT JOIN category ON system_links.category_id = category.id WHERE user_authority.user_id = _userId ORDER BY category.role,system_links.id,system_actions.id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_menu_sp` (IN `_userId` VARCHAR(250) CHARSET utf8)   BEGIN

SELECT category.id category_id,category.name category_name,`category`.`role`,system_links.id link_id,system_links.name link_name,system_links.link  FROM `user_authority` LEFT JOIN system_actions ON user_authority.action = system_actions.id LEFT JOIN system_links on system_actions.link_id = system_links.id LEFT JOIN category ON system_links.category_id = category.id WHERE user_authority.user_id = _userId GROUP BY system_links.id ORDER BY category.role,system_links.id,system_actions.id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_statement_sp` (IN `_userId` VARCHAR(50) CHARSET utf8, IN `_from` DATE, IN `_to` DATE)   BEGIN

set @tbalance = 0;
set @expense = 0;
set @income = 0;

if(_from = '0000-00-00')THEN

CREATE TEMPORARY TABLE tb SELECT expense.date, expense.user_id,if(type = 'Income',amount,0) Income, if(type = 'Expense',amount,0) 'Expense',if(type = 'Income', @tbalance:=@tbalance+amount ,@tbalance:=@tbalance-amount) 'Balance'  FROM expense WHERE expense.user_id = _userId ORDER by expense.date ASC;

SELECT * FROM tb

UNION

SELECT '','', SUM(Income),SUM(Expense), @tbalance FROM tb;


ELSE

CREATE TEMPORARY TABLE tb SELECT expense.date, expense.user_id,if(type = 'Income',amount,0) Income, if(type = 'Expense',amount,0) 'Expense',if(type = 'Income', @tbalance:=@tbalance+amount ,@tbalance:=@tbalance-amount) 'Balance'  FROM expense WHERE expense.user_id = _userId AND expense.date BETWEEN _from and _to ORDER by expense.date ASC;

SELECT * FROM tb

UNION

SELECT '','', SUM(Income),SUM(Expense), @tbalance FROM tb;

END if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_sp` (IN `_username` VARCHAR(250) CHARSET utf8, IN `_password` VARCHAR(250) CHARSET utf8)   BEGIN


if EXISTS(SELECT * FROM users WHERE users.username = _username and users.password = MD5(_password))THEN	


if EXISTS(SELECT * FROM users WHERE users.username = _username and 	users.status = 'Active')THEN
 
SELECT * FROM users where users.username = _username;

ELSE

SELECT 'Locked' Msg;

end if;
ELSE


SELECT 'Deny' Msg;

END if;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `register_expense_sp` (IN `_id` INT, IN `_amount` FLOAT(11,2), IN `_type` VARCHAR(50) CHARSET utf8, IN `_desc` TEXT CHARSET utf8, IN `_userId` VARCHAR(50) CHARSET utf8)   BEGIN

if EXISTS( SELECT * FROM expense WHERE expense.id = _id)THEN

UPDATE expense SET expense.amount = _amount, expense.type = _type, expense.description = _desc WHERE expense.id = _id;

SELECT 'Updated' as Message;
 
ELSE

if(_type = 'Expense')THEN

if((SELECT get_user_balance_fn(_userId) < _amount ))THEN

SELECT 'Deny' as Message;

ELSE

INSERT into expense(expense.amount,expense.type,expense.description,expense.user_id)
VALUES(_amount,_type,_desc,_userId);

SELECT 'Registered' as Message;

END if;

ELSE

INSERT into expense(expense.amount,expense.type,expense.description,expense.user_id)
VALUES(_amount,_type,_desc,_userId);

SELECT 'Registered' as Message;

END if;

END if;

END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `get_user_balance_fn` (`_userId` VARCHAR(50) CHARSET utf8) RETURNS FLOAT(11,2)  BEGIN

SET @balance = 0.00;

SET @income = (SELECT SUM(expense.amount) FROM expense WHERE expense.type = 'Income' AND expense.user_id = _userId);

SET @expense = (SELECT SUM(expense.amount) FROM expense WHERE expense.type = 'Expense' AND expense.user_id = _userId);

SET @balance = (ifnull(@income,0) - ifnull(@expense,0));

RETURN @balance;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `role` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `icon`, `role`, `date`) VALUES
(9, 'Super ', 'fa-setiing', 'SuperAdmin', '2021-06-30 09:55:47'),
(10, 'Subcriber', 'fa-user', 'Subscriber', '2021-06-30 06:42:29'),
(11, 'Dashboard', 'fa-home', 'Dashboard', '2021-06-30 09:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `amount` float(11,2) NOT NULL,
  `type` varchar(15) NOT NULL,
  `description` text NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `amount`, `type`, `description`, `user_id`, `date`) VALUES
(4, 630.00, 'Income', 'Lacagaa nasoo gashay', 'USR001', '2021-06-22 23:16:04'),
(9, 2323.00, 'Income', '3232', 'USR001', '2021-06-23 00:46:58'),
(11, 64.00, 'Income', 'sasa', 'USR001', '2021-06-23 00:49:03'),
(12, 500.00, 'Expense', 'For My Rent', 'USR001', '2021-06-25 14:01:18'),
(13, 4008.00, 'Expense', 'For Your Purpose', 'USR001', '2021-06-25 14:02:22'),
(14, 500.00, 'Income', 'Website Creation', 'USR001', '2021-07-07 18:10:56'),
(15, 242.00, 'Income', 'sds', 'USR001', '2021-07-07 18:41:16'),
(17, 15000.00, 'Income', 'test', 'USR001', '2023-09-27 11:26:29'),
(18, 15000.00, 'Income', 'test', 'USR001', '2023-09-27 11:41:57'),
(19, 0.00, 'Income', '1', 'USR001', '2023-09-27 11:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `system_actions`
--

CREATE TABLE `system_actions` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `action` varchar(250) NOT NULL,
  `link_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_actions`
--

INSERT INTO `system_actions` (`id`, `name`, `action`, `link_id`, `date`) VALUES
(3, 'Register USer', 'register_user', 4, '2021-06-30 08:57:09'),
(4, 'Update User', 'update_user', 4, '2021-06-30 08:57:31'),
(5, 'Delete User', 'delete_user_info', 4, '2021-06-30 08:57:48'),
(6, 'Dahsboard', 'Dashboard', 5, '2021-06-30 08:58:05'),
(7, 'Register Expense', 'register_expense', 6, '2021-06-30 08:58:47'),
(8, 'Update Expense', 'update_expense', 6, '2021-06-30 08:59:01'),
(9, 'Delete Expense', 'delete_expense_info', 6, '2021-06-30 08:59:17'),
(10, 'Register Category', 'register_category', 7, '2021-06-30 09:00:35'),
(11, 'Update Category', 'update_category', 7, '2021-06-30 09:01:10'),
(12, 'Delete Category', 'delete_category_info', 7, '2021-06-30 09:01:22'),
(13, 'User Authority', 'read_system_authorities', 11, '2021-06-30 09:02:32'),
(14, 'Rergister System Action', 'register_system_action', 8, '2021-06-30 13:30:22'),
(15, 'register System Links', 'register_system_links', 9, '2021-06-30 13:30:55'),
(16, 'User Statement', 'get_user_statement', 10, '2021-06-30 13:31:24'),
(17, 'Read Expense Info', 'get_user_transaction', 6, '2023-09-27 11:45:41'),
(18, 'Get Expense Info', 'get_expense_info', 6, '2023-09-27 11:51:08');

-- --------------------------------------------------------

--
-- Stand-in structure for view `system_authority`
-- (See below for the actual view)
--
CREATE TABLE `system_authority` (
`id` int(11)
,`category` varchar(250)
,`icon` varchar(50)
,`role` varchar(250)
,`link_id` int(11)
,`name` varchar(250)
,`action_id` int(11)
,`action_name` varchar(250)
);

-- --------------------------------------------------------

--
-- Table structure for table `system_links`
--

CREATE TABLE `system_links` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_links`
--

INSERT INTO `system_links` (`id`, `name`, `link`, `category_id`, `date`) VALUES
(4, 'USer', 'user.php', 9, '2021-06-30 07:25:28'),
(5, 'Dashboard', 'dashboard.php', 11, '2021-06-30 08:54:24'),
(6, 'Expense', 'expense.php', 10, '2021-06-30 08:54:43'),
(7, 'Category', 'category.php', 9, '2021-06-30 08:55:02'),
(8, 'System Actions', 'system_actions.php', 9, '2021-06-30 08:55:23'),
(9, 'System Links', 'system_links.php', 9, '2021-06-30 08:55:39'),
(10, 'User Statement', 'user_statement.php', 10, '2021-06-30 08:56:05'),
(11, 'User Authority', 'user_authority.php', 9, '2021-06-30 08:56:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'Active',
  `image` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `status`, `image`, `date`) VALUES
('USR003', 'Mchamouda', '827ccb0eea8a706c4c34a16891f84e7b', 'Active', 'USR003.png', '2021-06-27 21:17:05'),
('USR004', 'Mchamoudadev', '827ccb0eea8a706c4c34a16891f84e7b', 'Active', 'USR004.png', '2021-06-27 21:17:37'),
('USR005', 'McHamuda', '202cb962ac59075b964b07152d234b70', 'Active', 'USR005.png', '2021-06-27 23:01:22'),
('USR006', 'Ha', '202cb962ac59075b964b07152d234b70', 'Active', 'USR006.png', '2021-06-27 23:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_authority`
--

CREATE TABLE `user_authority` (
  `id` int(11) NOT NULL,
  `user_id` varchar(15) NOT NULL,
  `action` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_authority`
--

INSERT INTO `user_authority` (`id`, `user_id`, `action`) VALUES
(111, 'USR005', '7'),
(112, 'USR005', '8'),
(113, 'USR005', '9'),
(114, 'USR005', '17'),
(115, 'USR005', '18');

-- --------------------------------------------------------

--
-- Structure for view `system_authority`
--
DROP TABLE IF EXISTS `system_authority`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `system_authority`  AS SELECT `category`.`id` AS `id`, `category`.`name` AS `category`, `category`.`icon` AS `icon`, `category`.`role` AS `role`, `system_links`.`id` AS `link_id`, `system_links`.`name` AS `name`, `system_actions`.`id` AS `action_id`, `system_actions`.`name` AS `action_name` FROM ((`category` left join `system_links` on(`category`.`id` = `system_links`.`category_id`)) left join `system_actions` on(`system_links`.`id` = `system_actions`.`link_id`)) ORDER BY `category`.`role` ASC, `system_links`.`id` ASC, `system_actions`.`id` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_actions`
--
ALTER TABLE `system_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_link` (`link_id`);

--
-- Indexes for table `system_links`
--
ALTER TABLE `system_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_link_catgory` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_authority`
--
ALTER TABLE `user_authority`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `system_actions`
--
ALTER TABLE `system_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `system_links`
--
ALTER TABLE `system_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_authority`
--
ALTER TABLE `user_authority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `system_actions`
--
ALTER TABLE `system_actions`
  ADD CONSTRAINT `action_link` FOREIGN KEY (`link_id`) REFERENCES `system_links` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `system_links`
--
ALTER TABLE `system_links`
  ADD CONSTRAINT `system_link_catgory` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
