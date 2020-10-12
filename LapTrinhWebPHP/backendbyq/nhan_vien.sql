-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 30, 2020 lúc 05:09 AM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `nhan_vien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `pro_id` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `pro_name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `pro_quantity` int(20) NOT NULL,
  `pro_cate` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `pro_saleprice` int(20) NOT NULL,
  `pro_purchaseprice` int(20) NOT NULL,
  `pro_image` varchar(50) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `pro_quantity`, `pro_cate`, `pro_saleprice`, `pro_purchaseprice`, `pro_image`) VALUES
('banana-2', 'chuối tàu', 5000, 'banana', 200000, 500000, 'app/images/banana-2.txt'),
('durian-1', 'sầu riêng', 2313, 'durian', 300000, 1000000, 'app/images/durian-1.txt'),
('tomato-1', 'cà chua thái', 6000, 'tomato', 230000, 600000, 'app/images/tomato-1.txt'),
('watermelon-1', 'Dưa hấu', 6000, 'watermelon', 600000, 1000000, 'app/images/watermelon-1.txt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products_categories`
--

CREATE TABLE `products_categories` (
  `proCate_ID` int(100) NOT NULL,
  `proCate_code` text CHARACTER SET utf8 NOT NULL,
  `proCate_des` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `products_categories`
--

INSERT INTO `products_categories` (`proCate_ID`, `proCate_code`, `proCate_des`) VALUES
(7, 'apple', 'Táo'),
(10, 'banana', 'bananamy'),
(11, 'tomato', 'cà chua'),
(12, 'watermelon', 'dưa hấu'),
(13, 'durian', 'sầu riêng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `date` date DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `phone`, `email`, `password`, `sex`, `date`, `role`, `address`, `created`) VALUES
(117, 'quang nguyễn', '2313123', 'quang1999@gmail.com', '$2y$11$9jdoMaBUYtRf9wpp1RHEoOEXqwnDyvATAJSMXwZ6I1bf0JFzROk6u', 'Nam', '2020-07-21', 'ADMIN', 'Hà Nội', '2020-07-09 17:15:15'),
(119, 'huong', '31233123', 'huong2000@gmail.com', '$2y$11$.NI6mhS0xHxeq8.zHL4jkOeWESR1Z26uZkHMABNeDCF44PWd084Lq', 'Nữ', '2020-07-09', 'NV', 'Hải Phòng', '2020-07-08 09:54:46'),
(120, 'hung', '3123123123', 'hung1999@gmail.com', '$2y$11$Wz1Tf7u4Hv51aEvSmEdGL.THqq82PojYfl9I5qWuPbCS1i1qcVTY.', 'Nữ', '2020-07-04', 'NV', 'Hà Nội', '2020-07-08 09:57:38'),
(123, 'manh', '312312333', 'manh1999@gmail.com', '$2y$11$lTGneXlqBGHAIljJrUs3FeRjhxU1.Fcg0mu9O8qs90J4xc.gyQ2fy', 'Nam', '2020-07-10', 'NV', 'Hà Nội', '2020-07-09 17:09:55'),
(124, 'thang', '33333', 'thang1999@gmail.com', '$2y$11$cR3JkOFXjzFAJwVxHdxar.G8ZiqpXwMOS0/XcO2vahi82QKgMFm7S', 'Nam', '2020-07-23', 'NV', 'Hà Nội', '2020-07-09 19:17:27'),
(125, 'Dũng', '312333', 'dung1999@gmail.com', '$2y$11$si.IH2sHii0RhEq0OhQpP.1dz1p8Vv4PZq.5ji2Fh.To4oObLZfnC', 'Nam', '2020-07-23', 'NV', 'Hà Nội', '2020-07-09 20:51:21'),
(126, 'hải', '131233', 'hai1999@gmail.com', '$2y$11$f0GoEmfQ7kIPalmIwkn8cehFZAkVvnAvxtPZJDayY5pMSR3GebOGS', 'Nam', '2020-07-11', 'NV', 'Hà Nội', '2020-07-09 20:51:48'),
(128, 'hoang', '2333', 'hoang1999@gmail.com', '$2y$11$55rvLO1Zni6HFtw4d3auj.F9xwW8FAqfz2gK.8jVofbbNzps7FUbC', 'Nam', '2020-08-09', 'NV', 'Hà Nội', '2020-07-29 11:15:45');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`);

--
-- Chỉ mục cho bảng `products_categories`
--
ALTER TABLE `products_categories`
  ADD PRIMARY KEY (`proCate_ID`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `products_categories`
--
ALTER TABLE `products_categories`
  MODIFY `proCate_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
