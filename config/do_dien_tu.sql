-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 22, 2025 lúc 10:44 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `do_dien_tu`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banner`
--

INSERT INTO `banner` (`id`, `title`, `image_url`, `link`, `status`) VALUES
(5, 'kkkk', 'banner2.jpg', '', 'inactive'),
(7, 'hihihihi', 'banner3.jpg', '', 'inactive'),
(8, 'Siêu sale', 'banner1.jpg', '', 'active'),
(9, 'Tivi sắc nét', 'banner4.jpg', '', 'active'),
(10, 'Điều hòa', 'banner5.jpg', '', 'active'),
(11, 'HIHI', 'banner8.jpg', '', 'inactive');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `mactdh` int(11) NOT NULL,
  `madon` int(11) DEFAULT NULL,
  `masp` int(11) DEFAULT NULL,
  `soluong` int(11) DEFAULT NULL,
  `dongia` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`mactdh`, `madon`, `masp`, `soluong`, `dongia`) VALUES
(1, 1, 1, 2, 11990000.00),
(2, 2, 2, 1, 8590000.00),
(3, 3, 35, 5, 33516868.00),
(4, 4, 41, 10, 16890501.00),
(5, 5, 21, 2, 15432828.00),
(6, 5, 30, 1, 12382360.00),
(7, 6, 25, 3, 5791450.00),
(8, 7, 21, 1, 15432828.00),
(9, 8, 35, 3, 33516868.00),
(10, 9, 35, 1, 33516868.00),
(11, 10, 41, 3, 16890501.00),
(12, 11, 1, 2, 12990000.00),
(13, 12, 35, 1, 33516868.00),
(14, 13, 18, 1, 14784392.00),
(15, 14, 21, 1, 15432828.00),
(16, 14, 3, 1, 8990000.00),
(17, 15, 25, 5, 5791450.00),
(18, 15, 35, 1, 33516868.00),
(19, 16, 21, 1, 15432828.00),
(20, 17, 1, 1, 12990000.00),
(21, 18, 1, 1, 12990000.00),
(22, 18, 2, 1, 8590000.00),
(23, 19, 3, 1, 8990000.00),
(24, 20, 1, 4, 12990000.00),
(25, 21, 25, 1, 5791450.00),
(26, 22, 2, 1, 8590000.00),
(27, 23, 25, 3, 5791450.00),
(28, 24, 21, 1, 15432828.00),
(29, 0, 21, 2, 15432828.00),
(30, 0, 2, 1, 8590000.00),
(31, 25, 35, 1, 33516868.00),
(32, 25, 33, 1, 10621687.00),
(33, 26, 39, 1, 25715376.00),
(34, 27, 8, 2, 17594982.00),
(35, 28, 40, 2, 28867045.00),
(36, 29, 45, 1, 33731061.00),
(37, 30, 36, 1, 24159546.00),
(38, 31, 41, 1, 16890501.00),
(39, 32, 2, 1, 8590000.00),
(40, 33, 27, 1, 5374907.00),
(41, 34, 2, 1, 8590000.00),
(42, 35, 1, 1, 12990000.00),
(43, 36, 47, 2, 17631000.00),
(44, 37, 2, 1, 8590000.00),
(45, 37, 47, 1, 17631000.00),
(46, 38, 14, 1, 13241706.00),
(47, 39, 22, 1, 19871077.00),
(48, 40, 25, 1, 5791450.00),
(49, 41, 2, 1, 8590000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('pending','replied') DEFAULT 'pending',
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone`, `message`, `created_at`, `status`, `note`) VALUES
(1, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ', '2025-07-13 22:16:24', 'pending', NULL),
(2, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ', '2025-07-13 22:16:28', 'pending', NULL),
(3, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ', '2025-07-13 22:16:34', 'pending', NULL),
(4, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ', '2025-07-13 22:18:18', 'pending', NULL),
(5, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ hihi', '2025-07-13 22:18:26', 'pending', NULL),
(6, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ hihi', '2025-07-13 22:18:31', 'pending', NULL),
(7, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ hihi', '2025-07-13 22:18:41', 'pending', NULL),
(8, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ hihi', '2025-07-13 22:18:52', 'pending', NULL),
(9, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ hihi', '2025-07-13 22:19:04', 'pending', NULL),
(10, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ hihi', '2025-07-13 22:25:17', 'pending', NULL),
(11, 'duyèn', 'duyen@gmail.com', '0345678888', 'shop rất uy tín ạ hihi', '2025-07-13 22:25:26', 'pending', NULL),
(12, 'duyèn', 'ninhtu1109@gmail.com', '012345678', 'shop uy tín quá ạ\r\n', '2025-07-14 00:15:51', 'pending', NULL),
(13, 'Lưu Văn Minh', 'syminh126@gmail.com', '012345678', 'shop uy tín quá ạ\r\n', '2025-07-14 00:21:00', 'pending', NULL),
(14, 'Lưu Văn Minh', 'syminh1262004@gmail.com', '012345678', 'shop uy tín quá ạ\r\n', '2025-07-14 00:23:02', 'replied', ''),
(15, 'Lưu Văn Minh', 'syminh1262004@gmail.com', '012345678', 'shop uy tín quá ạ\r\n', '2025-07-14 01:03:06', 'pending', NULL),
(16, 'hoa', 'ntp088804@gmail.com', '0123456788', 'shop tuyệt vời lắm ạ', '2025-07-15 09:39:20', 'pending', NULL),
(17, 'Phượng', 'ntp08804@gmail.com', '0123456788', 'shop tuyệt vời lắm ạ', '2025-07-15 09:40:58', 'pending', NULL),
(18, 'Tú', 'ninhtu1109@gmail.com', '012345678', 'xin chào', '2025-07-17 16:04:59', 'replied', ''),
(19, 'duyèn', 'ninhtu1109@gmail.com', '0345678888', 'kkkk', '2025-07-18 13:42:44', 'pending', NULL),
(20, 'duyèn', 'ninhtu1109@gmail.com', '0345678888', 'kkkk', '2025-07-18 13:47:11', 'pending', NULL),
(21, 'duyèn', 'ninhtu1109@gmail.com', '0345678888', 'kkkk', '2025-07-18 13:47:15', 'pending', NULL),
(22, 'duyèn', 'ninhtu1109@gmail.com', '0345678888', 'kkkk', '2025-07-18 13:49:33', 'pending', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `id` int(11) NOT NULL,
  `makh` int(11) DEFAULT NULL,
  `masp` int(11) DEFAULT NULL,
  `madon` int(11) DEFAULT NULL,
  `diem` tinyint(4) DEFAULT NULL,
  `noidung` text DEFAULT NULL,
  `admin_reply` text DEFAULT NULL,
  `thoigian` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`id`, `makh`, `masp`, `madon`, `diem`, `noidung`, `admin_reply`, `thoigian`) VALUES
(1, 7, 21, 0, 5, 'sản phẩm quá chất lượng', NULL, '2025-07-12 22:10:31'),
(2, 7, 2, 0, 5, 'shop tư vấn quá nhiết tình lun ạ', NULL, '2025-07-12 22:11:15'),
(3, 7, 35, 25, 5, 'sản phầm đẹp lắm', 'cảm ơn bạn rất nhiều ạ !', '2025-07-14 01:04:07'),
(4, 7, 41, 31, 5, 'xịn quá ạ\r\n', 'cảm ơn bạn nhìu ạ', '2025-07-14 01:23:44'),
(5, 7, 2, 34, 5, 'xịn quá ạ\r\n', 'cảm ơn bạn ạ', '2025-07-17 15:46:45'),
(6, 7, 1, 35, 5, 'Nét thực sự ạ\r\n', 'Shop cảm ơn bạn nhiều ạ', '2025-07-17 16:01:44'),
(7, 0, 47, 36, 5, 'woww', NULL, '2025-07-20 10:32:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi_nhanhang`
--

CREATE TABLE `diachi_nhanhang` (
  `id` int(11) NOT NULL,
  `makh` int(11) NOT NULL,
  `ten_nguoinhan` varchar(100) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `sodienthoai` varchar(15) NOT NULL,
  `mac_dinh` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `diachi_nhanhang`
--

INSERT INTO `diachi_nhanhang` (`id`, `makh`, `ten_nguoinhan`, `diachi`, `sodienthoai`, `mac_dinh`) VALUES
(0, 0, 'Ninh Công Tú', 'Hà Nội', '0345678999', 1),
(1, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `madon` int(11) NOT NULL,
  `makh` int(11) DEFAULT NULL,
  `ten_nguoinhan` varchar(100) DEFAULT NULL,
  `diachi_nhan` varchar(255) DEFAULT NULL,
  `sdt_nhan` varchar(15) DEFAULT NULL,
  `ngaydat` datetime DEFAULT current_timestamp(),
  `tongtien` decimal(10,2) DEFAULT NULL,
  `trangthai` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`madon`, `makh`, `ten_nguoinhan`, `diachi_nhan`, `sdt_nhan`, `ngaydat`, `tongtien`, `trangthai`) VALUES
(1, 1, NULL, NULL, NULL, '2025-07-06 00:33:43', 23980000.00, 1),
(2, 2, NULL, NULL, NULL, '2025-07-06 05:08:10', 8590000.00, 1),
(3, 3, NULL, NULL, NULL, '2025-07-08 14:26:06', 99999999.99, 1),
(4, 4, NULL, NULL, NULL, '2025-07-10 00:15:15', 99999999.99, 1),
(5, 5, NULL, NULL, NULL, '2025-07-10 00:23:07', 43248016.00, 1),
(6, 6, NULL, NULL, NULL, '2025-07-10 01:37:33', 17374350.00, 1),
(7, 8, NULL, NULL, NULL, '2025-07-10 08:48:58', 15432828.00, 1),
(8, 9, NULL, NULL, NULL, '2025-07-10 09:49:53', 99999999.99, 1),
(9, 10, NULL, NULL, NULL, '2025-07-10 10:29:23', 33516868.00, 1),
(10, 11, NULL, NULL, NULL, '2025-07-10 10:40:54', 50671503.00, 1),
(11, 12, NULL, NULL, NULL, '2025-07-10 10:42:01', 25980000.00, 1),
(12, 13, NULL, NULL, NULL, '2025-07-10 10:55:56', 33516868.00, 1),
(13, 14, NULL, NULL, NULL, '2025-07-10 12:37:02', 14784392.00, 1),
(14, 15, NULL, NULL, NULL, '2025-07-10 12:43:03', 24422828.00, 1),
(15, 17, NULL, NULL, NULL, '2025-07-10 12:56:34', 62474118.00, 1),
(16, 18, NULL, NULL, NULL, '2025-07-10 13:02:45', 15432828.00, 1),
(17, 19, NULL, NULL, NULL, '2025-07-10 13:03:41', 12990000.00, 1),
(18, 20, NULL, NULL, NULL, '2025-07-11 09:08:50', 21580000.00, 1),
(19, 21, NULL, NULL, NULL, '2025-07-11 09:12:49', 8990000.00, 1),
(20, 22, NULL, NULL, NULL, '2025-07-11 09:21:05', 51960000.00, 1),
(21, 23, NULL, NULL, NULL, '2025-07-11 09:23:11', 5791450.00, 1),
(22, 7, NULL, NULL, NULL, '2025-07-11 09:27:45', 8590000.00, 1),
(23, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-11 10:27:48', 17374350.00, 3),
(24, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-11 10:52:19', 15432828.00, 4),
(25, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-12 22:40:48', 44138555.00, 4),
(26, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-12 22:51:52', 25715376.00, 3),
(27, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-12 23:23:25', 35189964.00, 3),
(28, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-12 23:25:39', 57734090.00, 3),
(29, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-12 23:27:52', 33731061.00, 3),
(30, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-12 23:29:27', 24159546.00, 3),
(31, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-14 01:22:23', 16890501.00, 3),
(32, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-15 01:39:13', 8590000.00, 2),
(33, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-15 09:37:51', 5374907.00, 3),
(34, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-17 15:31:10', 8590000.00, 4),
(35, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-17 16:00:58', 12990000.00, 3),
(36, 0, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-20 10:31:33', 35262000.00, 4),
(37, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-20 22:12:40', 26221000.00, 4),
(38, 7, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-20 22:20:46', 13241706.00, 0),
(39, 26, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-20 23:23:57', 19871077.00, 0),
(40, 29, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-21 00:26:32', 5791450.00, 0),
(41, 29, 'Ninh Công Tú', 'Hà Nội', '0345678999', '2025-07-22 15:15:33', 8590000.00, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `footer_content`
--

CREATE TABLE `footer_content` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `footer_content`
--

INSERT INTO `footer_content` (`id`, `content`, `type`) VALUES
(1, '<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\">\n\n<style>\n  .footer {\n    background-color: #007acc;\n    color: #ffffff;\n    padding: 50px 20px 30px;\n    font-family: \'Segoe UI\', sans-serif;\n  }\n\n  .footer .container {\n    max-width: 1200px;\n    margin: auto;\n    display: flex;\n    flex-wrap: wrap;\n    justify-content: space-between;\n    gap: 50px;\n  }\n\n  .footer h2 {\n    color: #ffffff;\n    font-size: 24px;\n    margin-bottom: 10px;\n  }\n\n  .footer h3 {\n    color: #ffc107; /* màu vàng nổi bật */\n    font-size: 20px;\n    margin-bottom: 15px;\n  }\n\n  .footer p, .footer a {\n    color: #e0f7ff; /* trắng xanh nhạt */\n    font-size: 15px;\n    line-height: 1.7;\n    text-decoration: none;\n  }\n\n  .footer a:hover {\n    color: #ffc107;\n    text-decoration: underline;\n  }\n\n  .social-icons a {\n    font-size: 24px;\n    margin-right: 20px;\n    color: #ffffff;\n    transition: color 0.3s ease;\n  }\n\n  .social-icons a:hover {\n    color: #ffc107;\n  }\n\n  .footer-bottom {\n    text-align: center;\n    border-top: 1px solid #ffffff33;\n    margin-top: 40px;\n    padding-top: 20px;\n    font-size: 14px;\n    color: #e0f7ff;\n  }\n\n  @media (max-width: 768px) {\n    .footer .container {\n      flex-direction: column;\n      align-items: flex-start;\n    }\n  }\n</style>\n\n<footer class=\"footer\">\n  <div class=\"container\">\n    <!-- Cột thông tin -->\n    <div class=\"footer-info\">\n      <h2>HihiMart</h2>\n      <p>Điện tử uy tín - Giá tốt mỗi ngày</p>\n      <p><i class=\"fas fa-map-marker-alt\"></i> 147B P. Tân Mai, Tân Mai, Hoàng Mai, Hà Nội</p>\n      <p><i class=\"fas fa-phone-alt\"></i> <a href=\"tel:19008386\">1900 8386</a></p>\n      <p><i class=\"fas fa-envelope\"></i> <a href=\"mailto:support@hihimart.vn\">support@hihimart.vn</a></p>\n    </div>\n\n    <!-- Cột mạng xã hội -->\n    <div class=\"footer-social\">\n      <h3>Kết nối với chúng tôi</h3>\n      <div class=\"social-icons\">\n        <a href=\"#\"><i class=\"fab fa-facebook-f\"></i></a>\n        <a href=\"#\"><i class=\"fab fa-instagram\"></i></a>\n        <a href=\"#\"><i class=\"fab fa-youtube\"></i></a>\n        <a href=\"#\"><i class=\"fab fa-tiktok\"></i></a>\n      </div>\n    </div>\n  </div>\n\n  <div class=\"footer-bottom\">\n    &copy; 2025 HihiMart. All rights reserved.\n  </div>\n</footer>', 'user');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `makh` int(11) NOT NULL,
  `tenkh` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `diachi` varchar(255) DEFAULT NULL,
  `sodienthoai` varchar(15) DEFAULT NULL,
  `trangthai` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`makh`, `tenkh`, `email`, `password`, `diachi`, `sodienthoai`, `trangthai`) VALUES
(1, 'ninhtu', 'tuninh@gmail.com', '$2y$10$x0ys7KMZMkAas8MofvHFE.BRlrLJh2msi0XvyeeUQ9y/eoJ66DmMi', 'Nam Định', '0123456789', 1),
(2, 'ss', 'a@gmail.com', NULL, 'aa', '0123567899', 1),
(3, 'hhh', 'hh@gmail.com', NULL, 'ha noi', '0333444555', 1),
(4, 'minhhi', 'minh@gmail.com', NULL, 'aa', '0333333333', 1),
(5, 'đ', 'ddd@gmail.com', NULL, 'aa', 'aa', 1),
(6, 'tu', 'tu@gmail.com', NULL, 'kk', '012345678', 1),
(7, 'kaka', 'kaka@gmail.com', '$2y$10$0p56qNx5O2TgXEVvhnwT.uOjM8XIKLvVhsvOoI2fUpeXqZrdflpKi', 'Nam Định', '012345678', 1),
(8, 'kaka', 'kaka@gmail.com', NULL, 'Nam Đinh', '012345678', 1),
(9, 'tu', 'kaka@gmail.com', NULL, 'kk', '0222222222', 1),
(10, 'tu88', 'tu@gmail.com', NULL, 'Hà Nội', '012345689', 1),
(11, 'tu88', 'kaka@gmail.com', NULL, 'Hà Nội', '0222222222', 1),
(12, 'tu88', 'kaka@gmail.com', NULL, 'Hà Nội', '0222222222', 1),
(13, 'tu', 'tu@gmail.com', NULL, 'Hà Nội', '0222222222', 1),
(14, 'tu88', 'kaka@gmail.com', NULL, 'Hà Nội', '0222222222', 1),
(15, 'tu', 'kaka@gmail.com', NULL, 'Hà Nội', '0222222222', 1),
(16, 'nct', 'nct@gmail.com', '$2y$10$DVtoenHd3NqH2OmCaoAYaeJ74bHrVs7auGCzSjSTpKqkrIvvYO3uK', 'Hà Nội', '034567899', 1),
(17, 'nct', 'nct@gmail.com', NULL, 'Hà Nội', '034567899', 1),
(18, 'nct', 'nct@gmail.com', NULL, 'Hà Nội', '034567899', 1),
(19, 'nct', 'nct@gmail.com', NULL, 'Hà Nội', '0222222222', 1),
(20, 'nct', 'kaka@gmail.com', NULL, 'Hà Nội', '0222222222', 1),
(21, 'nct', 'kaka@gmail.com', NULL, 'Hà Nội', '0222222222', 1),
(22, 'nct', 'nct@gmail.com', NULL, 'Nam Định', '0123456789', 1),
(23, 'tu', 'kaka@gmail.com', NULL, 'Hà Nội', '0222222222', 1),
(24, 'ninh tu', 'tudz@gmail.com', '$2y$10$llYccCuSvVdnQSztyXzQI.ZrErh0cFZ8diUdJ0ZT4m6v2BDlbSC.C', 'aaa', '0123456789', 1),
(26, 'aaaa', 'huhu@gmail.com', '$2y$10$zOu75.47Rs0qrsHPvus4UuDKe8XhK8/CSYySZ/RWSg2CbT6emqVNS', 'nam dinh', '0123466789', 1),
(27, 'Ninh Công Tú', 'h@gmail.com', '$2y$10$jUmTyu3g3DmZnyfBkhRFr.tg9QYRnnkRNQjmvKiqnHHYIZuODRUQS', 'Ninh Bình', '0123456788', 1),
(28, 'tu8688', 't@gmail.com', '$2y$10$/KlEzfR2ETXtuwdc03dAsu5IzhqTnjzZrRIv65DE4YpFalAGEcCsy', 'aaaaaaaaaaaaa', '0123456666', 1),
(29, 'Ninh Công Tú', 'tudeptrai@gmail.com', '$2y$10$afsW10DQHy1FBAbfrWeqiOrydiQSZ969GMSM/dMUrAo4bPHPChwvi', 'Nam Định', '0123456868', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisp`
--

CREATE TABLE `loaisp` (
  `maloai` int(11) NOT NULL,
  `tenloai` varchar(100) DEFAULT NULL,
  `mota` text DEFAULT NULL,
  `trangthai` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisp`
--

INSERT INTO `loaisp` (`maloai`, `tenloai`, `mota`, `trangthai`) VALUES
(1, 'Tivi', NULL, 1),
(2, 'Tủ lạnh', NULL, 1),
(3, 'Máy giặt', NULL, 1),
(4, 'Điều hòa', NULL, 1),
(5, 'Điện thoại', NULL, 1),
(6, 'Máy tính xách tay', NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `log_admin`
--

CREATE TABLE `log_admin` (
  `id` int(11) NOT NULL,
  `noidung` varchar(255) NOT NULL,
  `thoigian` datetime NOT NULL DEFAULT current_timestamp(),
  `admin_username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `log_admin`
--

INSERT INTO `log_admin` (`id`, `noidung`, `thoigian`, `admin_username`) VALUES
(1, 'Duyệt đơn hàng mã #34', '2025-07-17 15:38:20', 'unknown'),
(2, 'Chuyển đơn hàng mã #34 sang trạng thái Đang giao', '2025-07-17 15:38:36', 'unknown'),
(3, 'Xác nhận đơn hàng mã #34 đã giao thành công', '2025-07-17 15:38:42', 'unknown'),
(4, 'Duyệt đơn hàng mã #35', '2025-07-17 16:01:03', 'unknown'),
(5, 'Chuyển đơn hàng mã #35 sang trạng thái Đang giao', '2025-07-17 16:01:08', 'unknown'),
(6, 'Xác nhận đơn hàng mã #35 đã giao thành công', '2025-07-17 16:01:09', 'unknown'),
(7, 'Xác nhận đơn hàng mã #35 đã giao thành công', '2025-07-17 16:01:17', 'unknown'),
(8, 'Xác nhận đơn hàng mã #35 đã giao thành công', '2025-07-17 16:01:46', 'unknown'),
(9, 'Duyệt đơn hàng mã #36', '2025-07-20 10:32:00', 'unknown'),
(10, 'Chuyển đơn hàng mã #36 sang trạng thái Đang giao', '2025-07-20 10:32:05', 'unknown'),
(11, 'Xác nhận đơn hàng mã #36 đã giao thành công', '2025-07-20 10:32:19', 'unknown'),
(12, 'Duyệt đơn hàng mã #37', '2025-07-20 22:12:47', 'unknown'),
(13, 'Chuyển đơn hàng mã #37 sang trạng thái Đang giao', '2025-07-20 22:12:50', 'unknown'),
(14, 'Xác nhận đơn hàng mã #37 đã giao thành công', '2025-07-20 22:12:53', 'unknown'),
(15, 'Duyệt đơn hàng mã #41', '2025-07-22 15:15:46', 'unknown'),
(16, 'Chuyển đơn hàng mã #41 sang trạng thái Đang giao', '2025-07-22 15:15:53', 'unknown'),
(17, 'Xác nhận đơn hàng mã #41 đã giao thành công', '2025-07-22 15:16:03', 'unknown');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `marquee`
--

CREATE TABLE `marquee` (
  `id` int(11) NOT NULL,
  `noidung` text NOT NULL,
  `trangthai` tinyint(4) DEFAULT 1,
  `vaitro` enum('admin','user') DEFAULT 'user',
  `ngaytao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `marquee`
--

INSERT INTO `marquee` (`id`, `noidung`, `trangthai`, `vaitro`, `ngaytao`) VALUES
(1, 'Chào mừng bạn iu trở lại! Hãy kiểm tra các thông báo và cập nhật mới nhất.', 1, 'user', '2025-07-10 09:24:12'),
(2, 'hello MInh lọ', 0, 'admin', '2025-07-10 09:24:12'),
(3, 'Chào admin! Kiểm tra đơn hàng và sản phẩm mới cập nhật.', 1, 'admin', '2025-07-10 09:24:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu_content`
--

CREATE TABLE `menu_content` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(64) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `type` varchar(20) NOT NULL DEFAULT 'user',
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `menu_content`
--

INSERT INTO `menu_content` (`id`, `label`, `url`, `icon`, `position`, `type`, `parent_id`) VALUES
(1, 'Dashboard', 'index.php', 'bi bi-house-door', 1, 'admin', NULL),
(2, 'Quản lý sản phẩm', 'index.php?page=product', 'bi bi-box', 2, 'admin', NULL),
(3, 'Quản lý đơn hàng', 'index.php?page=order', 'bi bi-receipt', 3, 'admin', NULL),
(4, 'Quản lý banner', 'index.php?page=banner', 'bi bi-image', 4, 'admin', NULL),
(5, 'Quản lý menu', 'index.php?page=topmenu', 'bi bi-list', 5, 'admin', NULL),
(6, 'Quản lý footer', 'index.php?page=footer', 'bi bi-layout-text-window-reverse', 6, 'admin', NULL),
(7, 'Liên hệ', 'index.php?page=contact_admin', 'bi bi-envelope', 7, 'admin', NULL),
(9, 'Trang chủ', '/do_dien_tu/index.php', 'bi-house-door', 1, 'user', NULL),
(10, 'Điện thoại', 'index.php?controller=product&action=category&maloai=5', 'bi-phone', 2, 'user', NULL),
(11, 'Laptop', 'index.php?controller=product&action=category&maloai=6', 'bi-laptop', 3, 'user', NULL),
(12, 'Tivi', '/do_dien_tu/index.php?controller=product&action=category&cat=tv', 'bi-tv', 4, 'user', NULL),
(13, 'Tủ lạnh', 'index.php?controller=product&action=category&maloai=2', 'bi-snow', 5, 'user', NULL),
(14, 'Máy giặt', 'index.php?controller=product&action=category&maloai=3', 'bi-droplet-half', 6, 'user', NULL),
(18, 'Tin tức', '/do_dien_tu/index.php?controller=news&action=index', 'bi-newspaper', 10, 'user', NULL),
(19, 'Liên hệ', '/do_dien_tu/index.php?controller=contact&action=index', 'bi-envelope', 11, 'user', NULL),
(20, 'Quản lý khuyến mại', 'index.php?page=sale', 'bi bi-lightning-fill', 8, 'admin', NULL),
(23, 'Quản lý chữ chạy', 'index.php?page=marquee', '', 10, 'admin', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sales`
--

INSERT INTO `sales` (`id`, `title`, `description`, `start_time`, `end_time`, `status`) VALUES
(1, 'hh', 'ssss', '2025-07-15 09:50:00', '2025-07-15 23:50:00', 0),
(3, 'Siêu sale ngày hè', 'Mua sắm thả ga', '2025-07-17 09:20:00', '2025-07-25 23:50:00', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sale_products`
--

CREATE TABLE `sale_products` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sale_products`
--

INSERT INTO `sale_products` (`id`, `sale_id`, `product_id`, `sale_price`, `quantity`) VALUES
(4, 3, 35, 30516868, 3),
(7, 3, 43, 31202000, 5),
(9, 3, 47, 17631000, 8),
(11, 3, 24, 9473000, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `masp` int(11) NOT NULL,
  `tensp` varchar(255) DEFAULT NULL,
  `hinhanh` varchar(255) DEFAULT NULL,
  `dongia` decimal(10,2) DEFAULT NULL,
  `mota` text DEFAULT NULL,
  `ngaythem` datetime DEFAULT current_timestamp(),
  `trangthai` tinyint(4) DEFAULT 1,
  `luotmua` int(11) DEFAULT 0,
  `soluong` int(11) DEFAULT 0,
  `math` int(11) DEFAULT 1,
  `maloai` int(11) DEFAULT NULL,
  `hot` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`masp`, `tensp`, `hinhanh`, `dongia`, `mota`, `ngaythem`, `trangthai`, `luotmua`, `soluong`, `math`, `maloai`, `hot`) VALUES
(1, 'Smart Tivi Samsung 55 inch 4K', 'tivi/samsung-4k-55-inch.jpg', 12990000.00, 'Tivi Samsung với độ phân giải 4K, hỗ trợ Youtube, Netflix.', '2025-07-06 00:10:30', 1, 0, 19, 15, 1, 0),
(2, 'Tủ lạnh Panasonic Inverter 300L', 'tu_lanh/1-1020x570.jpg', 8590000.00, 'Tủ lạnh ngăn đá dưới, tiết kiệm điện năng, dung tích 300L.', '2025-07-06 00:10:30', 1, 0, 9, 21, 2, 1),
(3, 'Máy giặt LG 9kg AI DD', 'may_giat/inverter-9-kg.jpg', 8990000.00, 'Máy giặt cửa trước, cảm biến AI thông minh, chống xoắn rối.', '2025-07-06 00:10:30', 1, 0, 3, 8, 3, 0),
(4, 'Điều hòa LG DUALCOOL Inverter 12.000 BTU (1.5 HP) IEC12G1', 'dieu_hoa/daikin-inverter-1-5-hp.jpg', 11500000.00, 'Bảng thông số kỹ thuật của Điều hòa LG DUALCOOL Inverter 12.000 BTU (1.5 HP) IEC12G1\r\nĐánh giá chi tiết sản phẩm điều hòa LG DUALCOOL Inverter 12.000 BTU (1.5 HP) IEC12G1\r\nSở hữu Dual Inverter – Làm lạnh nhanh, vận hành bền bỉ\r\nĐiều hòa LG DUALCOOL Inverter 12.000 BTU (1.5 HP) IEC12G1 với kW Manager – Chủ động tiết kiệm điện ngay trên đầu ngón tay\r\nĐiều hòa LG DUALCOOL Inverter 12.000 BTU (1.5 HP) IEC12G1 được trang bị Freeze Cleaning – Công nghệ làm sạch dàn lạnh bằng băng\r\nLG ThinQ – Điều khiển thông minh qua điện thoại\r\nMàng lọc bụi mịn – Bảo vệ đường hô hấp\r\nDàn tản nhiệt mạ vàng – Chống ăn mòn, kéo dài tuổi thọ\r\nChức năng tự làm sạch của điều hòa LG DUALCOOL Inverter 12.000 BTU (1.5 HP) IEC12G1 – Ngăn chặn mùi hôi và vi khuẩn\r\nLàm lạnh nhanh – Sảng khoái tức thì', '2025-07-06 00:10:30', 1, 0, 6, 9, 4, 0),
(5, 'Smart Tivi LG 43 inch 4K', 'tivi/smart-tivi-lg-ai-4k-43.jpg', 10048582.00, 'Smart Tivi LG 43 inch 4K chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-22 12:54:30', 1, 0, 19, 6, 1, 1),
(6, 'Tủ lạnh Toshiba Inverter 321 lít GR-RB405WEA-PMV(06)-MG', 'tu_lanh/tu-lanh-toshiba-inverter-321-lit.jpg', 19338475.00, 'Tủ lạnh Toshiba 2 cánh 321L chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-16 12:54:30', 1, 0, 17, 21, 2, 0),
(7, 'Máy giặt Samsung 10kg Inverter', 'may_giat/samsung_ai_inverter_10kg.jpg', 5145465.00, 'Máy giặt Samsung AI Inverter 10kg WW10T634DLX/SV là dòng máy giặt cửa trước của thương hiệu Samsung, mang đến trải nghiệm làm sạch quần áo nhanh chóng và hiệu quả. Được trang bị hàng loạt công nghệ tiên tiến như AI Control, Digital Inverter hay AI Dispenser, thiết bị này không chỉ tiết kiệm thời gian giặt giũ mà còn giảm chi phí điện năng tiêu thụ hàng tháng. Với khối lượng giặt lên đến 10kg, Samsung AI Inverter sẽ là lựa chọn phù hợp cho những gia đình có từ 5 đến 7 thành viên.', '2025-06-26 12:54:30', 1, 0, 6, 22, 3, 0),
(8, 'Điều hòa Panasonic 1HP', 'dieu_hoa/panasonic-cu-cs-n9wkh-8m.jpg', 17594982.00, 'Điều hòa Panasonic 1HP chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-07-02 12:54:30', 1, 0, 6, 23, 4, 0),
(9, 'Smart Tivi Sony 65 inch OLED', 'tivi/sony-k-65s30-4k-65-inch.jpg', 15594451.00, 'Smart Tivi Sony 65 inch OLED chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-11 12:54:30', 1, 0, 7, 14, 1, 0),
(10, 'Tủ lạnh Aqua Inverter 550 lít Side By Side AQR-S612XA(WCB)', 'tu_lanh/tu-lanh-aqua-inverter-550-lit.jpg', 18721198.00, 'Đặc điểm nổi bật\r\n\r\nCông nghệ DEO Fresh khử mùi, kháng khuẩn hiệu quả, đảm bảo môi trường trong tủ trong lành.\r\nCông nghệ Twin Inverter tiết kiệm điện, vận hành êm ái, giảm thiểu tiếng ồn.\r\nHơi lạnh được phân bổ đồng đều khắp không gian tủ với công nghệ làm lạnh đa chiều.\r\nNgăn lấy nước ngoài tiện lợi, không cần mở cửa tránh thất thoát hơi lạnh.\r\nBảng điều khiển cảm ứng bên ngoài cửa tủ, dễ dàng thay đổi cài đặt chỉ với một chạm.\r\nThiết kế tủ Side by Side tối ưu không gian, dung tích sử dụng 550 lít phù hợp gia đình 4 - 5 người.', '2025-06-26 12:54:30', 1, 0, 7, 21, 2, 0),
(11, 'Máy giặt Toshiba 7kg', 'may_giat/product-293579-070823.jpg', 14447413.00, 'Máy giặt Toshiba 7kg chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-07-03 12:54:30', 1, 0, 6, 22, 3, 0),
(12, 'Điều hòa Casper 2HP Inverter', 'dieu_hoa/may-lanh-casper_main_269_1020.jpg', 19383290.00, 'Điều hòa Casper 2HP Inverter chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-21 12:54:30', 1, 0, 5, 23, 4, 0),
(13, 'Smart Tivi Samsung 4K 50 inch UA50DU8000', 'tivi/tivi-tcl-l50e5900-1-700x467-1.jpg', 17688084.00, 'Với Smart Tivi Samsung 4K 50 inch UA50DU8000, gia đình bạn sẽ có những phút giây giải trí hoàn hảo thông qua hình ảnh sắc nét và âm thanh sống động. Tivi tích hợp nhiều công nghệ tiên tiến như Dynamic Crystal Color, Crystal 4K, Adaptive Sound, OTS,... tạo ra những khung hình rực rỡ và giai điệu bao trùm. Với thiết kế tinh tế cùng màn hình 50 inch, đây sẽ là lựa chọn lý tưởng cho bất kỳ ai mong muốn nâng cấp trải nghiệm giải trí tại gia.\r\n\r\nThiết kế hiện đại, cứng cáp và vững vàng.\r\nCông nghệ ánh sáng tự nhiên cho hình ảnh chân thực và bảo vệ mắt khi nhìn lâu.\r\nHệ điều hành Android mang đến nhiều ứng dụng giải trí hấp dẫn.', '2025-06-19 12:54:30', 1, 0, 8, 15, 1, 0),
(14, 'Tủ lạnh Hitachi Inverter 569 lít Side By Side R-MX800GVGV0 GBK', 'tu_lanh/tu-lanh-hitachi-569.jpg', 13241706.00, 'Tủ lạnh Hitachi chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-26 12:54:30', 1, 0, 13, 21, 2, 0),
(15, 'Máy giặt Electrolux 9kg', 'may_giat/may-giat-electrolux-inverter-9-kg.jpg', 17426948.00, 'Máy giặt Electrolux 9kg chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-26 12:54:30', 1, 0, 11, 22, 3, 0),
(16, 'Điều hòa LG DualCool Inverter', 'dieu_hoa/iec12g1n-1.jpg', 9153823.00, 'Điều hòa LG DualCool Inverter chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-07-01 12:54:30', 1, 0, 19, 9, 4, 0),
(17, 'Xiaomi Smart Display S Mini LED 75 inch 4K L75MA-SPLEA', 'tivi/sanco-h32t200-1-700x467.jpg', 32590000.00, 'Xiaomi Smart Display S Mini LED 4K 75 inch 2025 (L75MA-SPLEA) là một sản phẩm vượt trội trong dòng TV thông minh của Xiaomi, mang đến trải nghiệm giải trí đỉnh cao cho người dùng. Với màn hình Mini LED 4K 75 inch kết hợp công nghệ Dolby Vision IQ và HDR10+, thiết bị này hiển thị hình ảnh sắc nét và có độ tương phản cao. Cùng với âm thanh mạnh mẽ từ các công nghệ hàng đầu như Dolby Audio, DTS-X và Dolby Atmos, TV hứa hẹn sẽ đem lại trải nghiệm giải trí toàn diện tại gia.\r\n\r\nViền màn hình siêu mỏng mang đến cảm giác xem rộng rãi\r\nXiaomi Smart Display S Mini LED 4K 75 inch 2025 gây ấn tượng với người dùng bởi thiết kế hiện đại và tinh tế. Với viền màn hình siêu mỏng, TV này mang lại cảm giác rộng rãi hơn, giúp bạn tận hưởng trọn vẹn các nội dung giải trí từ mọi góc nhìn. Chân đế được thiết kế dạng chữ V úp ngược, đảm bảo sự ổn định trên các bề mặt khác nhau, tạo cảm giác chắc chắn cho người dùng. Ngoài ra, bạn có thể tháo rời chân đế và treo TV lên tường nếu muốn tiết kiệm không gian.\r\n\r\nVới kích thước màn hình lên đến 75 inch, chiếc tivi xiaomi này đặc biệt phù hợp cho những không gian lớn như phòng khách, nơi bạn có thể tận hưởng một góc nhìn rộng và hình ảnh sắc nét dù ngồi ở bất kỳ vị trí nào. Tông màu đen chủ đạo của tivi cũng dễ dàng hòa hợp với mọi không gian nội thất, tạo cảm giác tối giản và hiện đại.', '2025-07-01 12:54:30', 1, 0, 9, 20, 1, 0),
(18, 'Tủ lạnh Sharp 180 lít SJ-194E-BS', 'tu_lanh/tu-lanh-sharp.jpg', 14784392.00, 'Đặc điểm nổi bật\r\n\r\nLàm đá nhanh gấp 2 lần tủ lạnh thường.\r\nPhân tử bạc Nano Ag+ khử mùi hôi cho tủ lạnh.\r\nKệ kính có khả năng chịu lực cao.', '2025-06-22 12:54:30', 1, 0, 6, 21, 2, 0),
(19, 'Máy giặt Panasonic Inverter 11.5 kg NA-V115FA1LV', 'may_giat/at-panasonic-inverter-11-5-kg.jpg', 14444227.00, 'Đặc điểm nổi bật\r\n\r\nKhối lượng giặt 11.5 kg thích hợp với gia đình trên 7 thành viên.\r\nCông nghệ StainMaster+ giặt nước nóng giúp loại bỏ các tác nhân dị ứng và vết bẩn cứng đầu.\r\nCông nghệ 3Di Inverter giúp tiết kiệm điện, nước hiệu quả. \r\nCông nghệ AI Smart Wash cảm biến thông minh, giặt tối ưu và tiết kiệm chi phí.\r\nTự động vệ sinh lồng giặt & vòng đệm mỗi lần giặt giúp hạn chế vi khuẩn bám lên quần áo. \r\nCông nghệ Econavi cảm biến tự điều chỉnh mực nước, tải trọng, nâng cao hiệu quả giặt. ', '2025-06-15 12:54:30', 1, 0, 6, 22, 3, 0),
(20, 'Điều hòa 2 chiều Daikin Inverter 9200 BTU ATHF25XVMV', 'dieu_hoa/may-lanh-daikin-inverter-2-chieu.jpg', 10063756.00, 'Điều hòa Daikin 2 chiều chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-20 12:54:30', 1, 0, 9, 23, 4, 0),
(21, 'Smart Tivi QLED Samsung 4K 55 inch QA55Q80D [ 55Q80D ]', 'tivi/tivi-qled-samsung-4k.jpg', 15432828.00, 'Tivi QLED Samsung 4K 55inch QA55QN80D tinh giản với thiết kế thanh mảnh, khung hình 55 inch độ phân giải 4K sắc nét, màn hình QLED kết hợp công nghệ Quantum Dot cho hình ảnh rực rỡ, hiển thị 100% dải màu, Dolby Atmos cho âm thanh vòm sống động, hệ điều hành Tizen™ với kho ứng dụng phong phú, điều khiển bằng giọng nói với trợ lý ảo Bixby có tiếng Việt,… cùng nhiều tiện ích thông minh khác.', '2025-07-07 12:54:30', 1, 0, 3, 15, 1, 0),
(22, 'Tủ lạnh Samsung Inverter 616 lít Side By Side Family Hub RS64T5F01B4/SV', 'tu_lanh/samsung-rs64t5f01b4.jpg', 19871077.00, 'Đặc điểm nổi bật\r\n\r\nMàn hình cảm ứng FamilyBoard giúp quản lý thực phẩm, giải trí đa phương tiện.\r\nTiết kiệm điện, bền bỉ với công nghệ Digital Inverter.\r\nThêm nhiều không gian lưu trữ hơn với viền tủ mỏng SpaceMax.\r\nTiện lợi với ngăn lấy nước ngoài và chức năng làm đá tự động.\r\nHơi lạnh toả đều và ổn định với công nghệ làm lạnh dạng vòm.\r\nKháng khuẩn, khử mùi hiệu quả với bộ lọc than hoạt tính.\r\nBảo quản rau quả tốt hơn với ngăn rau quả giữ ẩm.', '2025-07-01 12:54:30', 1, 0, 16, 16, 2, 0),
(23, 'Máy giặt Toshiba 8kg AW-M905BV(MK)', 'may_giat/aw-m905bvmk-2.jpg', 11033849.00, 'Máy giặt Toshiba 8kg AW-M905BV(MK) là chiếc máy giặt cửa trên được ra mắt năm 2022 của thương hiệu Toshiba. Máy có thiết kế theo phong cách hiện đại, đơn giản, cửa máy đặt phía trên, phù hợp cho những nơi bị hạn chế về mặt không gian. Bên cạnh đó, sản phẩm còn tích hợp nhiều công nghệ và tiện ích thông minh giúp đảm bảo quần áo của bạn được làm sạch hiệu quả, lưu hương lâu dài, giữ màu tươi tắn như mới.', '2025-06-18 12:54:30', 1, 0, 11, 22, 3, 0),
(24, 'Máy lạnh Midea Inverter 1 HP MAFA-09CDN8', 'dieu_hoa/midea-inverter-1-hp.jpg', 11636513.00, 'Loại máy: 1 chiều (chỉ làm lạnh)\r\nInverter: Có Inverter\r\nCông suất làm lạnh:\r\n1 HP - 9.000 BTU\r\nPhạm vi làm lạnh hiệu quả:\r\nDưới 15m² (từ 30 đến 45m³)\r\nĐộ ồn trung bình (được đo trong phòng thí nghiệm):\r\nDàn lạnh: 33 dB - Dàn nóng: 54.5 dB\r\nDòng sản phẩm: 2024\r\nSản xuất tại: Thái Lan\r\nThời gian bảo hành cục lạnh, cục nóng:\r\n3 năm\r\nThời gian bảo hành máy nén: 5 năm\r\nChất liệu dàn tản nhiệt: Ống dẫn gas bằng Đồng - Lá tản nhiệt bằng Nhôm mạ Hyper Grapfins\r\nLoại Gas: R-32', '2025-06-09 12:54:30', 1, 0, 10, 23, 4, 0),
(25, 'Tivi Xiaomi A2 55 inch', 'tivi/xiaomi-tv-a2-32.jpg', 5791450.00, 'Tivi Xiaomi A2 55 inch chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-07-03 12:54:30', 1, 0, 4, 20, 1, 0),
(26, 'Tủ lạnh Funiki 120 lít HR T6120TDG', 'tu_lanh/tu-lanh-funiki-120.jpg', 17014438.00, 'Tủ lạnh mini Funiki chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-22 12:54:30', 1, 0, 6, 21, 2, 0),
(27, 'Máy giặt Candy cửa trước', 'may_giat/may-giat-candy.jpg', 5374907.00, 'Máy giặt Candy cửa trước chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-27 12:54:30', 1, 0, 9, 8, 3, 0),
(28, 'Điều hòa âm trần LG', 'dieu_hoa/diu-hoa-cassette-1.jpg', 11842442.00, 'Điều hòa âm trần LG chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-29 12:54:30', 1, 0, 11, 9, 4, 0),
(29, 'Google Tivi Sony 4K 55 inch KD-55X85K [55X85K] - Chính Hãng', 'tivi/untitled-2.jpg', 15214361.00, 'Tivi LED Philips chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-14 12:54:30', 1, 0, 10, 14, 1, 0),
(30, 'Tủ lạnh Electrolux Inverter 335 lít EBB3742K-H', 'tu_lanh/electrolux-ebb3742k.jpg', 12382360.00, 'Đặc điểm nổi bật\r\n\r\nChế biến thực phẩm tươi sống nhanh chóng với ngăn đông mềm TasteSeal -2 độ C suốt 7 ngày.\r\nHiệu quả tiết kiệm điện cao với công nghệ Inverter.\r\nLàm lạnh và duy trì nhiệt độ ổn định, giữ thực phẩm tươi lâu với công nghệ EvenTemp.\r\nLoại bỏ vi khuẩn, khử mùi hiệu quả nhờ công nghệ Taste Guard.\r\nBảo quản rau củ tươi lâu trong ngăn chứa lớn, khép kín và điều chỉnh được độ ẩm.\r\nLấy nước bên ngoài nhanh chóng, tiện lợi với bình chứa nước đến 4 lít.\r\nPhù hợp cho gia đình từ 3 - 4 người với dung tích 335 lít.', '2025-07-06 12:54:30', 1, 0, 19, 21, 2, 0),
(31, 'Máy giặt Midea 10kg', 'may_giat/midea.jpg', 14794318.00, 'Máy giặt Midea 10kg chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-06-09 12:54:30', 1, 0, 15, 17, 3, 0),
(32, 'Máy lạnh Sharp 1 HP AH-A9UEW', 'dieu_hoa/sharp-ah-a9uew-1-700x467.jpg', 19381098.00, 'Đặc điểm nổi bật\r\n\r\nLàm lạnh nhanh Powerful Jet.\r\nChế độ Gentle Cool Air bảo vệ người lớn tuổi và trẻ nhỏ không bị cảm lạnh.\r\nChế độ Comfort duy trì nhiệt độ ổn định giúp tiết kiệm thêm khoảng 20% điện năng.\r\nNhiệt độ thấp nhất là 14 độ C cung cấp hơi lạnh sâu hơn.', '2025-06-09 12:54:30', 1, 0, 10, 23, 4, 0),
(33, 'Google Tivi Sony 4K 65 inch K-65S25VM2', 'tivi/google-tivi-sony-4k-65-inch.jpg', 10621687.00, 'Đặc điểm nổi bật\r\n\r\nMàn hình 65 inch 4K hiển thị sắc nét, lý tưởng cho trải nghiệm giải trí sống động trong không gian rộng.\r\n4K X-Reality PRO nâng cấp hình ảnh từ nguồn thấp, tái tạo chi tiết rõ ràng hơn.\r\nMotionflow XR 200 giảm nhòe, làm mượt cảnh chuyển động nhanh khi xem phim hoặc thể thao.\r\nDolby Atmos & DTS Digital Surround tái hiện âm thanh vòm lan tỏa, tạo cảm giác chân thực.\r\nHệ điều hành Google TV dễ dùng, tích hợp kho ứng dụng giải trí phong phú.\r\nMicro tích hợp trên tivi hỗ trợ ra lệnh giọng nói rảnh tay bằng tiếng Việt.', '2025-06-19 12:54:30', 1, 0, 11, 14, 1, 0),
(34, 'Tủ lạnh LG Side by Side lấy nước ngoài 641L màu đen LSI63BLMA', 'tu_lanh/thum-1600x1062.jpg', 16511229.00, 'Tủ lạnh side-by-side LG chất lượng cao, tiết kiệm điện, bảo hành 2 năm.', '2025-07-02 12:54:30', 1, 0, 17, 7, 2, 0),
(35, 'Laptop Dell Inspiron 15', 'laptop/text_d_i_12__2_1.jpg', 33516868.00, 'Laptop Dell Inspiron 15 chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-07-06 12:54:31', 1, 0, 5, 25, 6, 0),
(36, 'Laptop Asus VivoBook', 'laptop/text_ng_n_40__2_24_2_1.jpg', 24159546.00, 'Laptop Asus VivoBook chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-06-30 12:54:31', 1, 0, 9, 26, 6, 0),
(37, 'MacBook Air M2', 'laptop/image_1396_1.jpg', 27229922.00, 'MacBook Air M2 chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-06-25 12:54:31', 1, 0, 11, 1, 6, 0),
(38, 'Laptop HP Pavilion', 'laptop/group_828_1.jpg', 35682688.00, 'Laptop HP Pavilion chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-06-26 12:54:31', 1, 0, 11, 12, 6, 0),
(39, 'Điện thoại iPhone 14 Pro 128GB', 'dien_thoai/iphone14-pro-1-750x500.jpg', 25715376.00, 'Điện thoại iPhone 14 Pro chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-06-30 12:54:31', 1, 0, 6, 1, 5, 0),
(40, 'Samsung Galaxy S23 Ultra', 'dien_thoai/s23-ultra-tim_6_2_1.jpg', 28867045.00, 'Samsung Galaxy S23 Ultra chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-06-14 12:54:31', 1, 0, 4, 2, 5, 0),
(41, 'Điện thoại Xiaomi Redmi Note 13 Pro+ 5G 8GB/256GB', 'dien_thoai/xiaomi-redmi-note-13.jpg', 16890501.00, 'Xiaomi Redmi Note 13 chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-07-07 12:54:31', 1, 0, 1, 3, 5, 0),
(42, 'OPPO Reno11', 'dien_thoai/opporeno11_1_2_1.jpg', 27810990.00, 'OPPO Reno11 chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-06-20 12:54:31', 1, 0, 14, 4, 5, 0),
(43, 'Laptop Lenovo IdeaPad 5', 'laptop/group_658_2.jpg', 34668964.00, 'Laptop Lenovo IdeaPad 5 chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-07-05 12:54:31', 1, 0, 10, 1, 6, 0),
(44, 'Điện thoại realme C55 8GB/256GB', 'dien_thoai/realme-c55-black-1-1-750x500.jpg', 17343182.00, 'Điện thoại Realme C55 chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-06-23 12:54:31', 1, 0, 10, 13, 5, 1),
(45, 'Điện thoại iPhone 16 Pro Max 256GB', 'dien_thoai/iphone-16-pro-max-titan.jpg', 33731061.00, 'iPhone 16 Pro Max chính hãng, cấu hình tốt, bảo hành 12 tháng.', '2025-07-05 12:54:31', 1, 0, 20, 1, 5, 0),
(46, 'Điện thoại Vivo V30', 'dien_thoai/vivo-v30-xanh-1-750x500.jpg', 18101611.00, 'Tính Năng Nổi Bật\n4K HDR GoogleTV\nTích hợp trợ lý ảo Google Assistant\nThiết kế TV màn hình tràn viền, chân đế có vân\nCông nghệ tạo màu Triluminos PRO với hơn 1 tỷ màu sắc sống động\nYoutube, Netflix, FPT Play, Galaxy Play, VieON,…\nRemote RMF-TX800P mới – Tích hợp micro tìm kiếm bằng giọng nói\nThông Tin Sản Phẩm\nGoogle Tivi Sony 4K 55 inch KD-55X85K sở hữu thiết kế màn hình lớn 85 inch, với tỉ lệ khung hình sắc nét 4K, cho trải nghiệm nghe nhìn sống động với các công nghệ hình ảnh, âm thanh đỉnh cao Triluminos Pro, DTS Digital Surround, Dolby Atmos,… cùng nhiều tiện ích thông minh tích hợp điều khiển tivi bằng giọng nói rảnh tay không remote đem đến phút giây giải trí đáng kinh ngạc cho người xem.', '2025-06-30 12:54:31', 1, 0, 14, 5, 5, 0),
(47, 'iPhone 15 128GB', 'dien_thoai/iphone-15-hong.jpg', 19590000.00, 'Với iPhone 15, bạn sẽ được tận hưởng những trải nghiệm cao cấp trên một thiết bị bền bỉ và thanh lịch. Sản phẩm gây ấn tượng với màn hình Dynamic Island, camera độ phân giải siêu cao cùng nhiều chế độ quay chụp xuất sắc. Nhờ cổng USB-C, trải nghiệm kết nối của iPhone 15 thực sự khác biệt so với các thế hệ trước.', '2025-07-15 13:21:00', 1, 0, 17, 1, 5, 1),
(48, 'iPhone 16 Pro 128GB', 'dien_thoai/iphone_16_pro.jpg', 28390000.00, 'Với chip A18 Pro đẳng cấp, iPhone 16 Pro đem lại trải nghiệm bứt phá trong mọi tác vụ. Sản phẩm được gia tăng mạnh mẽ về thời lượng pin và có nút Điều Khiển Camera hoàn toàn mới. Ngoài ra, đây còn là dòng iPhone đầu tiên được thiết kế để vận hành với bộ tính năng Apple Intelligence tiện dụng.  ', '2025-07-18 14:10:15', 1, 0, 20, 1, 5, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham_dichvu`
--

CREATE TABLE `sanpham_dichvu` (
  `id` int(11) NOT NULL,
  `masp` int(11) NOT NULL,
  `ten_goi` varchar(255) NOT NULL,
  `mota` text DEFAULT NULL,
  `giacu` int(11) DEFAULT NULL,
  `giamoi` int(11) DEFAULT NULL,
  `dacdiem` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham_dichvu`
--

INSERT INTO `sanpham_dichvu` (`id`, `masp`, `ten_goi`, `mota`, `giacu`, `giamoi`, `dacdiem`) VALUES
(0, 47, 'free', '', 19590000, 18590000, '0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham_khuyenmai`
--

CREATE TABLE `sanpham_khuyenmai` (
  `id` int(11) NOT NULL,
  `masp` int(11) NOT NULL,
  `noidung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan_admin`
--

CREATE TABLE `taikhoan_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `quyen` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan_admin`
--

INSERT INTO `taikhoan_admin` (`id`, `username`, `password`, `email`, `quyen`) VALUES
(2, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@gmail.com', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuonghieu`
--

CREATE TABLE `thuonghieu` (
  `math` int(11) NOT NULL,
  `tenthuonghieu` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `maloai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thuonghieu`
--

INSERT INTO `thuonghieu` (`math`, `tenthuonghieu`, `logo`, `maloai`) VALUES
(1, 'Apple', NULL, 5),
(2, 'Samsung', NULL, 5),
(3, 'Xiaomi', NULL, 5),
(4, 'Oppo', NULL, 5),
(5, 'Vivo', NULL, 5),
(6, 'LG', NULL, 1),
(7, 'LG', NULL, 2),
(8, 'LG', NULL, 3),
(9, 'LG', NULL, 4),
(11, 'LG', NULL, 6),
(12, 'HP', NULL, 6),
(13, 'realme', NULL, 5),
(14, 'Sony', NULL, 1),
(15, 'Samsung', NULL, 1),
(16, 'Samsung', NULL, 2),
(17, 'Samsung', NULL, 3),
(18, 'Samsung', NULL, 4),
(19, 'Samsung', NULL, 6),
(20, 'Xiaomi', NULL, 1),
(21, ' Inverter', NULL, 2),
(22, ' Inverter', NULL, 3),
(23, ' Inverter', NULL, 4),
(24, 'Lenovo', NULL, 6),
(25, 'Dell', NULL, 6),
(26, 'Asus', NULL, 6);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`mactdh`),
  ADD KEY `madon` (`madon`),
  ADD KEY `masp` (`masp`);

--
-- Chỉ mục cho bảng `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_review` (`makh`,`masp`,`madon`);

--
-- Chỉ mục cho bảng `diachi_nhanhang`
--
ALTER TABLE `diachi_nhanhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `makh` (`makh`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`madon`),
  ADD KEY `makh` (`makh`);

--
-- Chỉ mục cho bảng `footer_content`
--
ALTER TABLE `footer_content`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`makh`);

--
-- Chỉ mục cho bảng `loaisp`
--
ALTER TABLE `loaisp`
  ADD PRIMARY KEY (`maloai`);

--
-- Chỉ mục cho bảng `log_admin`
--
ALTER TABLE `log_admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `marquee`
--
ALTER TABLE `marquee`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menu_content`
--
ALTER TABLE `menu_content`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sale_products`
--
ALTER TABLE `sale_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`masp`),
  ADD KEY `maloai` (`maloai`);

--
-- Chỉ mục cho bảng `sanpham_dichvu`
--
ALTER TABLE `sanpham_dichvu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `masp` (`masp`);

--
-- Chỉ mục cho bảng `sanpham_khuyenmai`
--
ALTER TABLE `sanpham_khuyenmai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `masp` (`masp`);

--
-- Chỉ mục cho bảng `taikhoan_admin`
--
ALTER TABLE `taikhoan_admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`math`),
  ADD KEY `maloai` (`maloai`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  MODIFY `mactdh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `madon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `footer_content`
--
ALTER TABLE `footer_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `makh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `log_admin`
--
ALTER TABLE `log_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `menu_content`
--
ALTER TABLE `menu_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `sale_products`
--
ALTER TABLE `sale_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `masp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `thuonghieu`
--
ALTER TABLE `thuonghieu`
  MODIFY `math` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `sale_products`
--
ALTER TABLE `sale_products`
  ADD CONSTRAINT `sale_products_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_sanpham_loai` FOREIGN KEY (`maloai`) REFERENCES `loaisp` (`maloai`);

--
-- Các ràng buộc cho bảng `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD CONSTRAINT `thuonghieu_ibfk_1` FOREIGN KEY (`maloai`) REFERENCES `loaisp` (`maloai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
