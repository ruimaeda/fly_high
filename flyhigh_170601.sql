-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017 年 6 月 01 日 10:11
-- サーバのバージョン： 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flyhigh`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `country_code` varchar(255) NOT NULL,
  `country_area` varchar(255) CHARACTER SET utf8 NOT NULL,
  `delete_flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_code`, `country_area`, `delete_flag`) VALUES
(0, 'Madagascar', 'MG', 'africa', 1),
(1, 'Iceland', 'IS', 'europe', 1),
(2, 'Ireland', 'IE', 'europe', 0),
(3, 'Azerbaijan', 'AZ', 'europe', 1),
(4, 'Afganistan', 'AF', 'asia', 1),
(5, 'United States', 'US', 'notrth_america', 0),
(6, 'Virgin Islands, U.S.', 'VI', 'north_america', 1),
(7, 'American Samoa', 'AS', 'oceania', 1),
(8, 'United Arab Emirates', 'AE', 'asia', 0),
(9, 'Algeria', 'DZ', 'africa', 1),
(10, 'Argentina', 'AR', 'south_america', 1),
(11, 'Aruba', 'AL', 'south_america', 1),
(12, 'Albania', 'AL', 'europe', 1),
(13, 'Armenia', 'AM', 'europe', 1),
(14, 'Armenia', 'AM', 'europe', 1),
(15, 'Anguilla', 'AI', 'europe', 1),
(16, 'Angola', 'AO', 'africa', 1),
(17, 'Antigua and Barbuda', 'AG', 'south_america', 1),
(18, 'Andora', 'AD', 'europe', 1),
(19, 'Yemen', 'YE', 'asia', 1),
(20, 'United Kingdom', 'GB', 'europe', 1),
(21, 'British Indian Ocean Territory', 'IO', 'oceania', 1),
(22, 'Virgin Islands, British', 'VG', 'south_america', 1),
(23, 'Israel', 'IL', 'asia', 1),
(24, 'Italy', 'IT', 'europe', 1),
(25, 'Iraq', 'IQ', 'asia', 1),
(26, 'Iran', 'IR', 'asia', 1),
(27, 'India', 'IN', 'asia', 1),
(28, 'Indonesia', 'ID', 'asia', 0),
(29, 'Wallis and Futuna', 'WF', 'oceania', 1),
(30, 'Uganda', 'UG', 'africa', 1),
(31, 'Ukraine', 'UA', 'europe', 1),
(32, 'Uzbekistan', 'UZ', 'asia', 1),
(33, 'Uruguay', 'UY', 'south_america', 1),
(34, 'Ecuador', 'EC', 'south_america', 1),
(35, 'Egypt', 'EG', 'africa', 1),
(36, 'Estonia', 'EE', 'europe', 1),
(37, 'Ethiopia', 'ET', 'africa', 1),
(38, 'Eritrea', 'ER', 'africa', 1),
(39, 'El Salvador', 'SV', 'south_america', 1),
(40, 'Australia', 'AU', 'oceania', 0),
(41, 'Austria', 'AT', 'europe', 1),
(42, 'Aland Islands', 'AX', 'europe', 1),
(43, 'Oman', 'OM', 'asia', 1),
(44, 'Netherlands', 'NL', 'europe', 1),
(45, 'Ghana', 'GH', 'africa', 1),
(46, 'Cape Verde', 'CV', 'africa', 1),
(47, 'Guernsey', 'GG', 'europe', 1),
(48, 'Guyana', 'GY', 'south_america', 1),
(49, 'Kazakhstan', 'KZ', 'asia', 1),
(50, 'Qatar', 'QA', 'asia', 0),
(51, 'United States Minor Outlying Islands', 'UM', 'oceania', 1),
(52, 'Canada', 'CA', 'north_america', 0),
(53, 'Gabon', 'GA', 'africa', 1),
(54, 'Cameroon', 'CM', 'africa', 1),
(55, 'Gambia', 'GM', 'africa', 1),
(56, 'Cambodia', 'KH', 'asia', 0),
(57, 'Saipan', 'MP', 'oceania', 0),
(58, 'Guinea', 'GN', 'africa', 1),
(59, 'Guinea-Bissau', 'GW', 'africa', 1),
(60, 'Cyprus', 'CY', 'europe', 1),
(61, 'Cuba', 'CU', 'south_america', 1),
(62, 'Curacao', 'CW', 'south_america', 1),
(63, 'Greece', 'GR', 'europe', 1),
(64, 'Kiribati', 'KI', 'oceania', 1),
(65, 'Kyrgyzstan', 'KG', 'asia', 1),
(66, 'Guatemala', 'GT', 'south_america', 1),
(67, 'Guadeloupe', 'GP', 'south_america', 1),
(68, 'Guam', 'GU', 'oceania', 0),
(69, 'Kuwait', 'KW', 'asia', 1),
(70, 'Cook Islands', 'CK', 'oceania', 1),
(71, 'Greenland', 'GL', 'europe', 1),
(72, 'Christmas Island', 'CX', 'oceania', 1),
(73, 'Grenada', 'GD', 'south_america', 1),
(74, 'Croatia', 'HR', 'europe', 1),
(75, 'Cayman Islands', 'KY', 'south_america', 1),
(76, 'Kenya', 'KE', 'africa', 1),
(77, 'Cote dIvoire', 'CI', 'africa', 1),
(78, 'Cocos Islands', 'CC', 'oceania', 1),
(79, 'Costa Rica', 'CR', 'south_america', 1),
(80, 'Comoros', 'KM', 'oceania', 1),
(81, 'Colombia', 'CO', 'south_america', 1),
(82, 'Congo', 'CG', 'africa', 1),
(83, 'Congo the Democratic Republic of the', 'CD', 'africa', 1),
(84, 'Saudi Arabia', 'SA', 'asia', 1),
(85, 'South Georgia and the South Sandwich Islands', 'GS', 'south_america', 1),
(86, 'Samoa', 'WS', 'oceania', 1),
(87, 'Sao Tome and Principe', 'ST', 'africa', 1),
(88, 'Saint Barthelemy', 'BL', 'souteh_america', 1),
(89, 'Zambia', 'ZM', 'africa', 1),
(90, 'Saint Pierre and Miquelon', 'PM', 'north_america', 1),
(91, 'San Marino', 'SM', 'europe', 1),
(92, 'Saint Martin', 'MF', 'south_america', 1),
(93, 'Sierra Leone', 'SL', 'africa', 1),
(94, 'Djibouti', 'DJ', 'africa', 1),
(95, 'Gibraltar', 'GI', 'europe', 1),
(96, 'Jersey', 'JE', 'europe', 1),
(97, 'Jamaica', 'JM', 'south_america', 1),
(98, 'Gerogia', 'GE', 'europe', 1),
(99, 'Syrian Arab Republic', 'SY', 'asia', 1),
(100, 'Singapore', 'SG', 'asia', 0),
(101, 'Sint Maarten', 'SX', 'south_america', 1),
(102, 'Zimbabwe', 'ZW', 'africa', 1),
(103, 'Switzerland', 'CH', 'europe', 1),
(104, 'Sweden', 'SE', 'europe', 1),
(105, 'Sudan', 'SD', 'africa', 1),
(106, 'Svalbard and Jan Mayen', 'SJ', 'europe', 1),
(107, 'Spain', 'ES', 'europe', 1),
(108, 'Suriname', 'SR', 'south_america', 1),
(109, 'Sri Lanka', 'LK', 'asia', 1),
(110, 'Slovakia', 'SK', 'europe', 1),
(111, 'Slovania', 'SI', 'europe', 1),
(112, 'Swaziland', 'SZ', 'africa', 1),
(113, 'Seychelles', 'SC', 'oceania', 1),
(114, 'Equatorial Guinea', 'GQ', 'africa', 1),
(115, 'Senegal', 'SN', 'africa', 1),
(116, 'Serbia', 'RS', 'europe', 1),
(117, 'Saint Kitts and Nexis', 'KN', 'south_america', 1),
(118, 'Saint Vincent and the Grenadines', 'SH', 'africa', 1),
(119, 'Saint Helena, Ascension and Tristan da Cunha', 'SH', 'africa', 1),
(120, 'Saint Lucia', 'LC', 'south_america', 1),
(121, 'Somalia', 'SO', 'africa', 1),
(122, 'Solomon Islands', 'SB', 'oceania', 1),
(123, 'Turks and Caicos Islands', 'TC', 'south_america', 1),
(124, 'Thailand', 'TH', 'asia', 0),
(125, 'Korea', 'TH', 'asia', 0),
(126, 'Taiwan', 'TW', 'asia', 0),
(127, 'Tajikistan', 'TJ', 'asia', 1),
(128, 'Tanzania', 'TZ', 'africa', 1),
(129, 'Czechia', 'CZ', 'europe', 1),
(130, 'Chad', 'TD', 'africa', 1),
(131, 'Central African Republic', 'CF', 'africa', 1),
(132, 'China', 'CN', 'asia', 0),
(133, 'Tunisia', 'TN', 'africa', 1),
(134, 'Korea Democratica People\'s Republic of', 'KP', 'asia', 1),
(135, 'Chile', 'CL', 'south_america', 1),
(136, 'Tuvalu', 'TV', 'oceania', 1),
(137, 'Denmark', 'DK', 'europe', 1),
(138, 'Germany', 'DE', 'europe', 1),
(139, 'Togo', 'TG', 'africa', 1),
(140, 'Tokelau', 'TK', 'oceania', 1),
(141, 'Dominican Republic', 'DO', 'south_america', 1),
(142, 'Dominica', 'DM', 'south_america', 1),
(143, 'Trinidad and Tobago', 'TM', 'south_america', 1),
(144, 'Turkmenistan', 'TM', 'asia', 1),
(145, 'Turkey', 'TR', 'asia', 1),
(146, 'Tonga', 'TO', 'oceania', 1),
(147, 'Nigeria', 'NG', 'africa', 1),
(148, 'Nauru', 'NR', 'oceania', 1),
(149, 'Namibia', 'NA', 'africa', 1),
(150, 'Antarctica', 'AQ', 'oceania', 1),
(151, 'Niue', 'NU', 'oceania', 1),
(152, 'Nicaragua', 'NI', 'south_america', 1),
(153, 'Niger', 'NE', 'africa', 1),
(154, 'Japan', 'JP', 'asia', 1),
(155, 'Western Sahara', 'EH', 'africa', 1),
(156, 'New Caledonia', 'NC', 'oceania', 1),
(157, 'New Zealand', 'NZ', 'oceania', 0),
(158, 'Nepal', 'NP', 'asia', 1),
(159, 'Norfolk Island', 'NF', 'oceania', 1),
(160, 'Norway', 'NO', 'europe', 1),
(161, 'Heard Island and McDonald Islands', 'HM', 'oceania', 1),
(162, 'bahrain', 'BH', 'asia', 1),
(163, 'Haiti', 'HT', 'south_america', 1),
(164, 'Pakistan', 'PK', 'asia', 1),
(165, 'Vatican City State', 'VA', 'europe', 1),
(166, 'Panama', 'PA', 'south_america', 1),
(167, 'Vanuatu', 'VU', 'oceania', 1),
(168, 'Bahamas', 'BS', 'south_america', 1),
(169, 'papua New Guniea', 'PG', 'oceania', 1),
(170, 'Bermuda', 'BM', 'south_america', 1),
(171, 'Palau', 'PW', 'oceania', 1),
(172, 'Paraguay', 'PY', 'south_america', 1),
(173, 'Barbados', 'BB', 'south_america', 1),
(174, 'Palestian teritory', 'PS', 'asia', 1),
(175, 'Hungary', 'HU', 'europe', 1),
(176, 'Bangladesh', 'BD', 'asia', 1),
(177, 'Timor-Leste', 'TL', 'asia', 1),
(178, 'Pitcairn', 'PN', 'oceania', 1),
(179, 'Fiji', 'FJ', 'oceania', 1),
(180, 'Philippines', 'PH', 'asia', 0),
(181, 'Finland', 'FI', 'europe', 0),
(182, 'Bhutan', 'BT', 'asia', 1),
(183, 'Bouvet Island', 'BV', 'oceania', 1),
(184, 'Puerto Rico', 'PR', 'south_america', 1),
(185, 'Faroe Island', 'FO', 'europe', 1),
(186, 'Falkland Island', 'FK', 'south_america', 1),
(187, 'Brazil', 'BR', 'south_america', 1),
(188, 'France', 'FR', 'europe', 1),
(189, 'French Guiana', 'GH', 'south_america', 1),
(190, 'French Polynesia', 'PF', 'oceania', 1),
(191, 'French Southern Territories', 'TF', 'oceania', 1),
(192, 'Bulgaria', 'BG', 'europe', 1),
(193, 'burkina Faso', 'BF', 'africa', 1),
(194, 'Brunei Darussalam', 'BN', 'asia', 1),
(195, 'Burundi', 'BI', 'africa', 1),
(196, 'Viet Nam', 'VN', 'asia', 0),
(197, 'Benin', 'BJ', 'africa', 1),
(198, 'Venezuela', 'VE', 'south_america', 1),
(199, 'Belarus', 'BY', 'europe', 1),
(200, 'Belize', 'BZ', 'south_america', 1),
(201, 'Peru', 'PE', 'south_amrica', 1),
(202, 'Belgium', 'BE', 'europe', 1),
(203, 'Poland', 'PL', 'europe', 1),
(204, 'Bosnia and Herzegovina', 'BA', 'europe', 1),
(205, 'Botswana', 'BW', 'africa', 1),
(206, 'Bonaire, Saint Eustatius and Saba', 'BQ', 'south_america', 1),
(207, 'Bolivia', 'BO', 'south_amrica', 1),
(208, 'Portugal', 'PT', 'europe', 1),
(209, 'Hong Kong', 'HK', 'asia', 0),
(210, 'Honduras', 'HN', 'south_america', 1),
(211, 'Marshall Islands', 'MH', 'oceania', 1),
(212, 'Macedonia', 'MK', 'europe', 1),
(213, 'Madagascar', 'MG', 'africa', 1),
(214, 'Mayotte', 'YT', 'oceania', 1),
(215, 'Malawi', 'MW', 'africa', 1),
(216, 'Mali', 'ML', 'africa', 1),
(217, 'Malta', 'MT', 'europe', 1),
(218, 'Martinique', 'MQ', 'south_america', 1),
(219, 'Malaysia', 'asia', 'MY', 0),
(220, 'Isle of Man', 'IM', 'europe', 1),
(221, 'Micronesia', 'FM', 'oceania', 1),
(222, 'South Africa', 'ZA', 'africa', 1),
(223, 'South Sudan', 'SS', 'africa', 1),
(224, 'Myanmar', 'MM', 'asia', 1),
(225, 'Mexico', 'MX', 'north_america', 1),
(226, 'Mauritius', 'MU', 'africa', 1),
(227, 'MR', 'africa', 'Mauritania', 1),
(228, 'Mozambique', 'MZ', 'africa', 1),
(229, 'Monaco', 'MC', 'europe', 1),
(230, 'Maldives', 'MV', 'oceania', 1),
(231, 'Moldova', 'MD', 'africa', 1),
(232, 'Morocco', 'MA', 'africa', 1),
(233, 'Mongolia', 'MN', 'asia', 1),
(234, 'Montenegro', 'ME', 'europe', 1),
(235, 'Montserrat', 'MS', 'south_america', 1),
(236, 'Jordan', 'JO', 'asia', 1),
(237, 'Laos', 'LA', 'asia', 1),
(238, 'Latvia', 'LV', 'europe', 1),
(239, 'Lithuania', 'LT', 'europe', 1),
(240, 'Libya', 'LY', 'africa', 1),
(241, 'Liechetenstein', 'LI', 'europe', 1),
(242, 'Liberia', 'LR', 'africa', 1),
(243, 'Romania', 'RO', 'europe', 1),
(244, 'Luxembourg', 'LU', 'europe', 1),
(245, 'Rwanda', 'RW', 'africa', 1),
(246, 'Lesotho', 'LS', 'africa', 1),
(247, 'Lebanon', 'LB', 'asia', 1),
(248, 'Reunion', 'RE', 'oceania', 1),
(249, 'Russia', 'RU', 'europe', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `country_styles`
--

CREATE TABLE `country_styles` (
  `country_style_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `sale_text` text CHARACTER SET utf8 NOT NULL,
  `sale_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sale_category` varchar(255) CHARACTER SET utf8 NOT NULL,
  `picture_path` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sale_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `sales`
--

INSERT INTO `sales` (`sale_id`, `sale_text`, `sale_title`, `sale_category`, `picture_path`, `sale_created`) VALUES
(1, 'test sale', 'why dont you go cebu?', 'sale', 'none', '2017-05-29 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `styles`
--

CREATE TABLE `styles` (
  `style_id` int(11) NOT NULL,
  `style_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `delete_flag` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `styles`
--

INSERT INTO `styles` (`style_id`, `style_name`, `delete_flag`) VALUES
(1, 'alone', 0),
(2, 'couple', 0),
(3, 'family', 0),
(4, 'food', 0),
(5, 'resort', 0),
(6, 'nature', 0),
(7, 'ruins', 0),
(8, 'shopping', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nick_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `age` varchar(100) CHARACTER SET utf8 NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 NOT NULL,
  `income` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_purpose` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_budget` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_period` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_country` varchar(100) CHARACTER SET utf8 NOT NULL,
  `travel_time` varchar(100) CHARACTER SET utf8 NOT NULL,
  `know_flyhigh` varchar(100) CHARACTER SET utf8 NOT NULL,
  `demand` text CHARACTER SET utf8 NOT NULL,
  `delete_flag` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `nick_name`, `email`, `password`, `role`, `gender`, `age`, `address`, `income`, `travel_purpose`, `travel_budget`, `travel_period`, `travel_country`, `travel_time`, `know_flyhigh`, `demand`, `delete_flag`, `created`, `modified`) VALUES
(1, 'tabippo', 'tabippo@gmail', '29a8d928ecdcf7f8b0835ebd2a65c3f8509a62c2', 1, '', '', '', '', '', '', '', '', '', '', '', 0, '2017-05-29 20:17:56', '2017-05-29 12:18:31'),
(2, 'yuki', 'yuki@gmail', '29a8d928ecdcf7f8b0835ebd2a65c3f8509a62c2', 0, '', '', '', '', '', '', '', '', '', '', '', 0, '2017-05-29 20:19:04', '2017-05-29 12:19:45'),
(3, 'manato', 'manato@gmail', '29a8d928ecdcf7f8b0835ebd2a65c3f8509a62c2', 0, '', '', '', '', '', '', '', '', '', '', '', 0, '2017-05-29 20:23:26', '2017-05-29 12:23:54');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_countries`
--

CREATE TABLE `user_countries` (
  `user_country_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_sales`
--

CREATE TABLE `user_sales` (
  `user_sale_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `country_styles`
--
ALTER TABLE `country_styles`
  ADD PRIMARY KEY (`country_style_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`style_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_countries`
--
ALTER TABLE `user_countries`
  ADD PRIMARY KEY (`user_country_id`);

--
-- Indexes for table `user_sales`
--
ALTER TABLE `user_sales`
  ADD PRIMARY KEY (`user_sale_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country_styles`
--
ALTER TABLE `country_styles`
  MODIFY `country_style_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `styles`
--
ALTER TABLE `styles`
  MODIFY `style_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_countries`
--
ALTER TABLE `user_countries`
  MODIFY `user_country_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_sales`
--
ALTER TABLE `user_sales`
  MODIFY `user_sale_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
