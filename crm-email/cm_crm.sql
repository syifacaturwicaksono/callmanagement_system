-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 09, 2026 at 08:18 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cm_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `case_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `pic`, `customer_name`, `customer_email`, `customer_phone`, `case_id`, `subject`, `created_at`, `updated_at`, `attachment`) VALUES
(1, 'Maulida', 'Hartono', 'hartono@gmail.com', '081901768176', '5100082195', 'Dukungan HP Ref. 5100082195 – Pengiriman Quotation\r\n', '2026-04-06 08:43:09', '2026-04-06 08:43:09', NULL),
(2, 'Maulida', 'Alhan', 'alhan@gmail.com', '085158816155', '5100082231', 'Dukungan HP Ref. 5100082231-Penawaran Lebih 1 Part', '2026-04-06 09:06:11', '2026-04-06 09:06:11', NULL),
(3, 'Maulida', 'Alhan', 'alhan@gmail.com', '085158816155', '5100082231', 'Dukungan HP Ref. 5100082231-Penawaran Lebih 1 Part', '2026-04-06 09:11:44', '2026-04-06 09:11:44', NULL),
(4, 'Maulida', 'Hida', 'Hida@gmail.com', '085559477540', '5100082237', 'Dukungan HP Ref. 5100082237 – Pengiriman Quotation\r\n', '2026-04-07 04:43:17', '2026-04-07 04:43:17', NULL),
(5, 'Maulida', 'Ricky Mahendra', 'Rickymahendra@gmail.com', '082138645365', '5100082239', 'Dukungan HP Ref. 5100082239 – Pengiriman Quotation\r\n', '2026-04-07 05:11:50', '2026-04-07 05:11:50', NULL),
(6, 'Maulida', 'Amir', 'Amir@gmail.com', '083117392628', '5100082246', 'Dukungan HP Ref. 5100082246 – Pengiriman Quotation\r\n', '2026-04-07 08:37:26', '2026-04-07 08:37:26', NULL),
(7, 'Maulida', 'Alhan', 'alhan@gmail.com', '085158816155', '5100082231', 'Dukungan HP Ref. 5100082231 – Follow Up Quotation\r\n', '2026-04-08 05:15:07', '2026-04-08 05:15:07', NULL),
(8, 'Maulida', 'Ahmad Rokhi Regar', 'Ahmadrokhiregar@gmail.com', '082134733012', '5100082250', 'Dukungan HP Ref. 5100082250 – Penawaran Repair Mainboard', '2026-04-08 08:19:56', '2026-04-08 08:19:56', NULL),
(9, 'Maulida', 'Nailah Faza Luthfiah', 'Nailah@gmail.com', '083189027068', '5100082256', 'Dukungan HP Ref. 5100082256 – Pengiriman Quotation\r\n', '2026-04-08 08:37:02', '2026-04-08 08:37:02', NULL),
(10, 'Maulida', 'Hendra', 'Hendra@gmail.com', '081225493099', '5100082260', 'Dukungan HP Ref. 5100082260 – Pengiriman Quotation\r\n', '2026-04-08 09:08:26', '2026-04-08 09:08:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wa_body` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `required_fields` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `body`, `wa_body`, `required_fields`, `created_at`, `updated_at`) VALUES
(1, '[2001] Recovery Windows', 'Dukungan HP Ref. {{workorder}}– Recovery Windows', '<p>Yth. Bapak/Ibu <strong>{{customer_name}}</strong>,</p>\r\n\r\n<p>Kami dari <strong>HP Service Center Semarang</strong> ingin menginformasikan mengenai unit Anda <strong>{{unit}}</strong> dengan case id <strong>{{workorder}}</strong> setelah dilakukan pengecekan oleh teknisi ditemukan kendala pada <strong>{{problem}}</strong>, untuk itu unit akan kami coba untuk direcovery dengan <strong>resiko data hilang semua</strong>.</p>\r\n\r\n<p>* Sebagai informasi jika login akun Microsoft Office pada unit akan ter-reset juga, jadi pastikan masih menyimpan akun untuk login, untuk loginnya dilakukan secara mandiri oleh Bapak/Ibu karena terkait privacy.</p>\r\n\r\n<p>Dengan demikian mohon konfirmasi perihal datanya ya. </p>\r\n\r\n<p>{{libur}}</p>\r\n\r\n<p>Terima kasih,<br>\r\nSalam,<br>\r\n{{pic}}<br>\r\n{{sender_position}}<br>\r\n{{company_name}}<br>\r\nTelp: {{sender_phone}}<br>\r\n<img src=\"{{company_logo}}\" \r\n     alt=\"Company Logo\" \r\n     width=\"120\" \r\n     style=\"display:block; width:120px; height:auto; margin-top:10px;\"></p>', 'Yth. Bapak/Ibu *{{customer_name}}*,\r\n\r\nKami dari *HP Service Center Semarang* ingin menginformasikan mengenai unit Anda *{{unit}}* dengan case id *{{workorder}}* setelah dilakukan pengecekan oleh teknisi ditemukan kendala pada {{problem}}, untuk itu unit akan kami coba untuk direcovery dengan *resiko data hilang semua*.  \r\n\r\n* Sebagai informasi jika login akun Microsoft Office pada unit akan ter-reset juga, jadi pastikan masih menyimpan akun untuk login, untuk loginnya dilakukan secara mandiri oleh Bapak/Ibu karena terkait privacy.\r\n\r\nDengan demikian mohon konfirmasi perihal datanya ya. \r\n\r\nTerima kasih,\r\nSalam,\r\n{{pic}}\r\n{{sender_position}}\r\n{{company_name}}', 'null', NULL, '2026-04-09 06:09:10'),
(2, '[2002] Harga Tidak Ekonomis', 'Dukungan HP Ref. {{workorder}} – Harga Tidak Ekonomis', '<p>Yth Bapak/Ibu <strong>{{customer_name}}</strong>,\r\n\r\n<p>Kami dari <strong>HP Service Center Semarang</strong> ingin menginformasikan mengenai unit Anda <strong>{{unit}}</strong> dengan Case ID <strong>{{workorder}}</strong> setelah dilakukan pengecekan, <strong>{{problem}}</strong>. <strong>{{need_part}}</strong>.</p>\r\n\r\n<p>Kami tunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.</p>\r\n\r\n<p>Hormat kami,<br>\r\n{{pic}}<br>\r\n{{sender_position}}<br>\r\n{{company_name}}<br>\r\n<img src=\"{{company_logo}}\" \r\n     alt=\"Company Logo\" \r\n     width=\"120\" \r\n     style=\"display:block; width:120px; height:auto; margin-top:10px;\"></p>', 'Yth Bapak/Ibu *{{customer_name}}*,\r\n\r\nKami dari *HP Service Center Semarang* ingin menginformasikan mengenai unit Anda *{{unit}}* dengan Case ID *{{workorder}}* setelah dilakukan pengecekan, {{problem}}. {{need_part}}.\r\n\r\nKami tunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\n{{pic}}\r\n{{sender_position}}\r\n{{company_name}}', '[\"customer_name\", \"workorder\"]', NULL, '2026-04-09 04:25:41'),
(3, '[2003] Penawaran 1 Part Dan Baru Cek Lainnya', 'Dukungan HP Ref. {{workorder}}– Penawaran 1 Part Dan Baru Cek Lainnya', '<p>Yth Bapak/Ibu <strong>{{customer_name}}</strong>,</p>\r\n\r\n<p>Kami dari <strong>HP Service Center Semarang</strong> ingin menginformasikan mengenai unit Anda <strong>{{unit}}</strong> dengan case id <strong>{{workorder}}</strong> setelah dilakukan pengecekan, <strong>{{problem}}</strong>. Dengan demikian unit harus diganti part <strong>{{need_part}}</strong> dulu baru bisa cek yang lainnya.</p> \r\n\r\n<p>Kami menawarkan penggantian part <strong>{{need_part}}</strong> tsb dengan harga <strong>{{harga}}</strong>/<strong>{{eta}}</strong>. </p>\r\n\r\n<p>Apabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. <br>\r\nUntuk Pembayaran dapat ditransfer ke rekening : <br>\r\n* A/c     : PT. Harmoni Putra Solusindo <br>\r\n* A/n     : 1824567878 <br>\r\n* Bank    : BCA </p>\r\n\r\n<p>Kami tunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.</p>\r\n\r\n<p>Hormat kami,<br>\r\n{{pic}}<br>\r\n{{sender_position}}<br>\r\n{{company_name}}<br>\r\n<img src=\"{{company_logo}}\" \r\n     alt=\"Company Logo\" \r\n     width=\"120\" \r\n     style=\"display:block; width:120px; height:auto; margin-top:10px;\"></p>', 'Yth Bapak/Ibu *{{customer_name}}*,\r\n\r\nKami dari *HP Service Center Semarang* ingin menginformasikan mengenai unit Anda *{{unit}}* dengan case id *{{workorder}}* setelah dilakukan pengecekan, {{problem}}. Dengan demikian unit harus diganti part {{need_part}} dulu baru bisa cek yang lainnya. \r\n\r\nKami menawarkan penggantian part {{need_part}} tsb dengan harga {{harga}}/{{eta}}. \r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. \r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA \r\n\r\nKami tunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\n{{pic}}\r\n{{sender_position}}\r\n{{company_name}}', 'null', NULL, '2026-04-09 04:35:55'),
(4, '[2004] Penawaran Lebih 1 Part', 'Dukungan HP Ref. {{workorder}}-Penawaran Lebih 1 Part', '<p>Yth Bapak/Ibu <strong>{{customer_name}}</strong>,\r\n\r\n<p>Saya <strong>{{pic}}</strong> dari <strong>HP Service Center Semarang</strong> ingin menyampaikan informasi terkait unit Anda <strong>{{unit}}</strong> dengan Case ID <strong>{{workorder}}</strong>. Setelah dilakukan pengecekan, ditemukan adanya kendala pada {{isi_masalah}}. </p>\r\n\r\n<p>Sehubungan dengan hal tersebut, kami menawarkan penggantian sparepart dengan rincian biaya sebagai berikut : <br>\r\n\r\n{{isi_part}}</p>\r\n\r\n<p>Total {{total_harga}} (part indent, estimasi waktu {{eta}}). <br>\r\n\r\nCatatan: Part bergaransi selama 1 bulan. </p>\r\n\r\n<p>Apabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. <br>\r\nUntuk Pembayaran dapat ditransfer ke rekening : <br>\r\n* A/c     : PT. Harmoni Putra Solusindo <br>\r\n* A/n     : 1824567878 <br>\r\n* Bank    : BCA</p>\r\n\r\n<p>Kami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.</p> \r\n\r\n<p>Hormat kami,<br>\r\n{{pic}}<br>\r\n{{sender_position}}<br>\r\n{{company_name}}<br>\r\n<img src=\"{{company_logo}}\" \r\n     alt=\"Company Logo\" \r\n     width=\"120\" \r\n     style=\"display:block; width:120px; height:auto; margin-top:10px;\"></p>', 'Yth Bapak/Ibu *{{customer_name}}*,\r\n\r\nSaya *{{pic}}* dari *HP Service Center Semarang* ingin menyampaikan informasi terkait unit Anda *{{unit}}* dengan Case ID *{{workorder}}*. Setelah dilakukan pengecekan, ditemukan adanya kendala pada {{isi_masalah}}. \r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian sparepart dengan rincian biaya sebagai berikut : \r\n\r\n{{isi_part}}\r\n\r\nTotal {{total_harga}} (part indent, estimasi waktu {{eta}}). \r\n\r\nCatatan: Part bergaransi selama 1 bulan. \r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. \r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA\r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya. \r\n\r\nSalam,\r\n{{pic}}\r\n{{sender_position}}\r\n{{company_name}}', 'null', NULL, '2026-04-09 04:42:55'),
(5, '[2005] Penawaran Repair Mainboard', 'Dukungan HP Ref. {{workorder}} – Penawaran Repair Mainboard', '<p>Yth. Bapak/Ibu <strong>{{customer_name}}</strong>,\r\n\r\n<p>Saya <strong>{{pic}}</strong> dari <strong>HP Service Center Semarang</strong> ingin menyampaikan informasi terkait unit Anda <strong>{{unit}}</strong> dengan Case ID <strong>{{workorder}}</strong>. Setelah dilakukan pengecekan, {{problem}}.</p>\r\n<p>Sehubungan dengan hal tersebut, kami menawarkan untuk dilakukan REPAIR/SERVICE MAINBOARD dulu, baru bisa cek kerusakan yang lain, dengan estimasi biaya repair Rp. {{biaya}} /{{eta}} minggu pengerjaan tergantung dengan tingkat kerusakan mainboardnya. Jika bisa lebih cepat akan langsung kami informasikan kembali.</p>\r\n<p>Kemungkinan berhasil 50:50, namun kami selalu maksimalkan dulu repairnya supaya bisa sukses dan unit kembali hidup. <br> Kami juga sudah sering menangani hal ini, dan banyak juga yang hasilnya good.</p>\r\n\r\n<p>Jika repair nya gagal, resiko bisa membuat unit jadi MATI TOTAL, jika repair gagal, maka hanya dikenakan biaya Rp. 125.000 sebagai ganti biaya analisa troubleshootnya.</p>\r\n\r\n<p>Apabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. <br>\r\nUntuk Pembayaran dapat ditransfer ke rekening : <br>\r\n  * A/c     : PT. Harmoni Putra Solusindo <br>\r\n  * A/n     : 1824567878 <br>\r\n  * Bank    : BCA</p>\r\n\r\n<p>Kami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.</p>\r\n \r\n<p>Salam Hormat,<br>\r\n{{pic}}<br>\r\n{{sender_position}}<br>\r\n{{company_name}}<br>\r\n<img src=\"{{company_logo}}\" \r\n     alt=\"Company Logo\" \r\n     width=\"120\" \r\n     style=\"display:block; width:120px; height:auto; margin-top:10px;\"></p>', 'Yth. Bapak/Ibu *{{customer_name}}*,\r\n\r\nSaya *{{pic}}* dari *HP Service Center Semarang* ingin menyampaikan informasi terkait unit Anda *{{unit}}* dengan Case ID *{{workorder}}*. Setelah dilakukan pengecekan, {{problem}}.\r\nSehubungan dengan hal tersebut, kami menawarkan untuk dilakukan REPAIR/SERVICE MAINBOARD dulu, baru bisa cek kerusakan yang lain, dengan estimasi biaya repair Rp. {{biaya}} /{{eta}} minggu pengerjaan tergantung dengan tingkat kerusakan mainboardnya. Jika bisa lebih cepat akan langsung kami informasikan kembali.\r\nKemungkinan berhasil 50:50, namun kami selalu maksimalkan dulu repairnya supaya bisa sukses dan unit kembali hidup. Kami juga sudah sering menangani hal ini, dan banyak juga yang hasilnya good.\r\n\r\nJika repair nya gagal, resiko bisa membuat unit jadi MATI TOTAL, jika repair gagal, maka hanya dikenakan biaya Rp. 125.000 sebagai ganti biaya analisa troubleshootnya.\r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. \r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n  * A/c     : PT. Harmoni Putra Solusindo \r\n  * A/n     : 1824567878 \r\n  * Bank    : BCA\r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\n{{pic}}\r\n{{sender_position}}\r\n{{company_name}}', 'null', NULL, '2026-04-09 04:50:41'),
(6, '[2006] Pengiriman Quotation', 'Dukungan HP Ref. {{workorder}} – Pengiriman Quotation', '<p>Yth. Bapak/Ibu {{customer_name}},</p>\r\n<p>Saya <strong>{{pic}}</strong> dari <strong>HP Service Center Semarang</strong> ingin menyampaikan informasi terkait unit Anda <strong>{{unit}}</strong> dengan Case ID <strong>{{workorder}}</strong>. Setelah dilakukan pengecekan, ditemukan adanya masalah pada {{problem}}.</p>\r\n<p>Sehubungan dengan hal tersebut, kami menawarkan penggantian part {{problem}} dengan harga Rp. {{harga}} (part indent, estimasi waktu 7–14 hari kerja).<br>\r\nCatatan: Part bergaransi selama 1 bulan.<br>\r\n{{tambahan}}<br>\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%.<br>\r\nPembayaran dapat ditransfer ke rekening berikut:<br>\r\n    • Nama Rekening : PT. Harmoni Putra Solusindo<br>\r\n    • No. Rekening  : 1824567878<br>\r\n    • Bank          : BCA</p>\r\n<p>Kami menunggu konfirmasinya. Terima kasih atas perhatian dan kerja samanya.</p>\r\n \r\n<p>Salam Hormat,<br>\r\n{{pic}}<br>\r\n{{company_name}}</p>\r\n<p><img src=\"{{company_logo}}\" \r\n     alt=\"Company Logo\" \r\n     width=\"120\" \r\n     style=\"display:block; width:120px; height:auto; margin-top:10px;\"></p>', 'Yth. Bapak/Ibu *{{customer_name}}*,\r\n\r\nSaya {{pic}} dari HP Service Center Semarang ingin menyampaikan informasi terkait unit Anda {{unit}} dengan Case ID {{workorder}}. Setelah dilakukan pengecekan, ditemukan adanya kendala pada {{problem}}.\r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian part {{part}} dengan harga Rp. {{harga}} (part indent, estimasi waktu 7–14 hari kerja).\r\nCatatan: Part bergaransi selama 1 bulan.\r\n{{tambahan}}\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%.\r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA \r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\n{{pic}}\r\n{{sender_position}}\r\n{{company_name}}', 'null', NULL, '2026-04-09 04:54:43'),
(7, '[2007] Follow Up Quotation', 'Dukungan HP Ref. {{workorder}} – Follow Up Quotation', '<p>Yth. Bapak/Ibu <strong>{{customer_name}}</strong>,</p>\r\n\r\n<p>Kami dari HP Service Center Semarang, mau reminder perihal penawaran kami untuk unit Anda {{unit}} dengan Case ID <strong>{{workorder}}</strong> kira-kira bagaimana pak kelanjutannya?</p>\r\n\r\n<p>Kami tunggu konfirmasinya.</p>\r\n\r\n<p>Terima kasih,<br>\r\nSalam,<br>\r\n{{pic}}<br>\r\n{{sender_position}}<br>\r\n{{company_name}}<br>\r\nTelp: {{sender_phone}}<br>\r\n<img src=\"{{company_logo}}\" \r\n     alt=\"Company Logo\" \r\n     width=\"120\" \r\n     style=\"display:block; width:120px; height:auto; margin-top:10px;\"></p>', 'Yth. Bapak/Ibu *{{customer_name}}*,\r\n\r\nKami dari *HP Service Center Semarang*, mau reminder perihal penawaran kami untuk unit Anda *{{unit}}* dengan Case ID *{{workorder}}* kira-kira bagaimana Bapak/Ibu untuk kelanjutannya?\r\n\r\nKami tunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\n{{pic}}\r\n{{sender_position}}\r\n{{company_name}}', 'null', NULL, '2026-04-09 06:06:06');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_02_13_025028_create_email_templates_table', 2),
(6, '2026_02_13_034802_create_email_logs_table', 3),
(7, '2026_02_25_033508_add_case_id_to_email_logs_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pics`
--

CREATE TABLE `pics` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pics`
--

INSERT INTO `pics` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Maulida', '2026-04-09 03:34:16', '2026-04-09 03:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cs'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$L9OrgY55adcK32P1mx7N1eNHZ1Smxu2H.y7hQYpV5loTQNElPRAXy', NULL, '2026-03-14 14:37:18', '2026-04-09 04:04:13', 'admin'),
(3, 'CM2', 'cs1@gmail.com', NULL, '$2y$12$CPOg2vgALd5Z3C11tdhaC.AF4aMWkqwpyxMsggU/GSkUW4oSbxfgi', NULL, '2026-03-17 01:51:11', '2026-04-09 04:02:47', 'cm'),
(4, 'CM1', 'cs2@gmail.com', NULL, '$2y$12$G5kk.sweKfhaDvqbKMjbLesFcPFjR./bu5TWytCH0M1f6o10ljyA6', NULL, '2026-03-17 01:56:50', '2026-04-09 04:02:06', 'cm'),
(5, 'CS0', 'cs0@gmail.com', NULL, '$2y$12$.Tj0pv2gK3cjxi1stWvBmeXxHcAjaSyJRldh9H2SLyn3goEXvdIKO', NULL, '2026-03-17 01:58:41', '2026-03-17 01:58:41', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `wa_logs`
--

CREATE TABLE `wa_logs` (
  `id` bigint NOT NULL,
  `pic` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `case_id` varchar(100) DEFAULT NULL,
  `message` text,
  `status` varchar(50) DEFAULT 'sent',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wa_logs`
--

INSERT INTO `wa_logs` (`id`, `pic`, `customer_name`, `customer_phone`, `case_id`, `message`, `status`, `created_at`, `updated_at`) VALUES
(56, 'Maulida', 'Faisal Rachman Hakim', '6282167377711', '5100082220', 'Yth Bapak/Ibu *Faisal Rachman Hakim*,\r\n\r\nSaya *Maulida* dari *HP Service Center Semarang* ingin menyampaikan informasi terkait unit Anda *HP Gaming Pavilion - 15-dk0042tx* dengan Case ID *5100082220*. Setelah dilakukan pengecekan, ditemukan adanya kendala pada Keyboardnya beberapa tombol tidak bisa (q, w, e, r, u, i, o, p), unit cek Bezel kiri ada yang patah. \r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian sparepart dengan rincian biaya sebagai berikut : \r\n\r\n1. Top Cover Keyboard 3.385.000\r\n2. Bezel 1.750.000 (oposional)\r\n3. Biaya Cleaning Repasta 220.000\r\n\r\nTotal 5.355.000 (part indent, estimasi waktu 7-14 hari kerja). \r\n\r\nCatatan: Part bergaransi selama 1 bulan. \r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. \r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA\r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya. \r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-02 09:32:35', '2026-04-02 09:32:35'),
(57, 'Maulida', 'Syahnoon', '6289513919759', '5100082167', 'Yth. Bapak/Ibu *Syahnoon*,\r\n\r\nKami dari *HP Service Center Semarang*, mau reminder perihal penawaran kami untuk unit Anda *HP Laptop 14s-dk1507AU* dengan Case ID *5100082167* kira-kira bagaimana Bapak/Ibu untuk kelanjutannya?\r\n\r\nKami tunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo', 'sent', '2026-04-04 06:01:30', '2026-04-04 06:01:30'),
(58, 'Maulida', 'Barayati', '6281249304551', '5100082193', 'Yth. Bapak/Ibu *Barayati*,\r\n\r\nKami dari *HP Service Center Semarang*, mau reminder perihal penawaran kami untuk unit Anda *HP DeskJet Ink Advantage 2337 All-in-One Printer* dengan Case ID *5100082193* kira-kira bagaimana Bapak/Ibu untuk kelanjutannya?\r\n\r\nKami tunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo', 'sent', '2026-04-04 06:08:05', '2026-04-04 06:08:05'),
(59, 'Maulida', 'Sulistyo', '6281392467115', '5100082194', 'Yth. Bapak/Ibu *Sulistyo*,\r\n\r\nKami dari *HP Service Center Semarang*, mau reminder perihal penawaran kami untuk unit Anda *HP Smart Tank 515 Wireless All-in-One* dengan Case ID *5100082194* kira-kira bagaimana Bapak/Ibu untuk kelanjutannya?\r\n\r\nKami tunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo', 'sent', '2026-04-04 06:09:33', '2026-04-04 06:09:33'),
(60, 'Maulida', 'Tania', '6281547207634', '5100082228', 'Yth. Bapak/Ibu *Tania*,\r\n\r\nSaya Maulida dari HP Service Center Semarang ingin menyampaikan informasi terkait unit Anda HP Laptop 14s-cf2076TU dengan Case ID 5100082228. Setelah dilakukan pengecekan, ditemukan adanya kendala pada Keyboardnya.\r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian part Top Cover Keyboard dengan harga Rp. 2.605.000 (part indent, estimasi waktu 7–14 hari kerja).\r\nCatatan: Part bergaransi selama 1 bulan.\r\n\r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%.\r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA \r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-06 02:09:12', '2026-04-06 02:09:12'),
(62, 'Maulida', 'Hartono', '6281901768176', '5100082195', 'Yth. Bapak/Ibu *Hartono*,\r\n\r\nSaya Maulida dari HP Service Center Semarang ingin menyampaikan informasi terkait unit Anda HP Ink Tank 315 dengan Case ID 5100082195. Setelah dilakukan pengecekan, ditemukan adanya kendala pada unit bocor, sudah dicleaning cuci unit, dirunning cek Mainboardnya rusak.\r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian part Mainboard dengan harga Rp. 640.000 + Biaya analisa troubleshooting 125.000 = 765.000 (part indent, estimasi waktu 7–14 hari kerja).\r\nCatatan: Part bergaransi selama 1 bulan.\r\n\r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%.\r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA \r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-06 08:43:09', '2026-04-06 08:43:09'),
(63, 'Maulida', 'Alhan', '6285158816155', '5100082231', 'Yth Bapak/Ibu *Alhan*,\r\n\r\nSaya *Maulida* dari *HP Service Center Semarang* ingin menyampaikan informasi terkait unit Anda *HP Ink Tank 315* dengan Case ID *5100082231*. Setelah dilakukan pengecekan, ditemukan adanya kendala pada selang inktube nya bocor dan tinta hitam nya habis. \r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian sparepart dengan rincian biaya sebagai berikut : \r\n\r\n1. Selang Inktube 295.000\r\n2. Tinta Hitam 110.000\r\n3. Biaya Analisa Troubleshooting 125.000\r\n\r\nTotal 530.000 (part indent, estimasi waktu 7-14 hari kerja). \r\n\r\nCatatan: Part bergaransi selama 1 bulan. \r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. \r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA\r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya. \r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-06 09:06:11', '2026-04-06 09:06:11'),
(64, 'Maulida', 'Alhan', '6285158816155', '5100082231', 'Yth Bapak/Ibu *Alhan*,\r\n\r\nSaya *Maulida* dari *HP Service Center Semarang* ingin menyampaikan informasi terkait unit Anda *HP Ink Tank 315* dengan Case ID *5100082231*. Setelah dilakukan pengecekan, ditemukan adanya kendala pada selang inktube nya bocor dimakan semut dan tinta hitam nya habis.. \r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian sparepart dengan rincian biaya sebagai berikut : \r\n\r\n1. Selang Inktube 295.000\r\n2. Tinta Hitam 110.000\r\n3. Biaya Analisa Troubleshooting 125.000\r\n\r\nTotal 530.000 (part indent, estimasi waktu 7-14 hari kerja). \r\n\r\nCatatan: Part bergaransi selama 1 bulan. \r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. \r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA\r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya. \r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-06 09:11:44', '2026-04-06 09:11:44'),
(65, 'Maulida', 'Hida', '6285559477540', '5100082237', 'Yth. Bapak/Ibu *Hida*,\r\n\r\nSaya Maulida dari HP Service Center Semarang ingin menyampaikan informasi terkait unit Anda HP Ink Tank 315 dengan Case ID 5100082237. Setelah dilakukan pengecekan, ditemukan adanya kendala pada indikator cartridgenya menyala, unit hank. Cek Mainboardnya rusak, fisik mainboard terkena kotoran tikus.\r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian part Mainboard dengan harga Rp. 640.000 (part indent, estimasi waktu 7–14 hari kerja).\r\nCatatan: Part bergaransi selama 1 bulan.\r\nSebagai informasi, jika printhead terprotect pada mainboard yang rusak, maka untuk penggantian mainboard ini perlu penggantian printheadnya juga 1 set black dan color. (hal ini bisa dicek setelah penggantian mainboard)\r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%.\r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA \r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-07 04:43:17', '2026-04-07 04:43:17'),
(66, 'Maulida', 'Ricky Mahendra', '6282138645365', '5100082239', 'Yth. Bapak/Ibu *Ricky Mahendra*,\r\n\r\nSaya Maulida dari HP Service Center Semarang ingin menyampaikan informasi terkait unit Anda Victus Gaming Laptop 16-s0010AX dengan Case ID 5100082239. Setelah dilakukan pengecekan, ditemukan adanya kendala pada SSDnya overheat, sehingga unit sering mati (SSD yang terpasang 1TB).\r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian part SSD 1TB dengan harga Rp. 3.955.000 + biaya bongkar pemasangan Rp. 195.000 = Rp. 4.150.000 (part indent, estimasi waktu 7–14 hari kerja).\r\nCatatan: Part bergaransi selama 1 bulan.\r\n\r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%.\r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA \r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-07 05:11:50', '2026-04-07 05:11:50'),
(67, 'Maulida', 'Amir', '6283117392628', '5100082246', 'Yth. Bapak/Ibu *Amir*,\r\n\r\nSaya Maulida dari HP Service Center Semarang ingin menyampaikan informasi terkait unit Anda HP Laptop 14s-dk0158AU dengan Case ID 5100082246. Setelah dilakukan pengecekan, ditemukan adanya kendala pada LCDnya flicker.\r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian part LCD Panel dengan harga Rp. 2.050.000 (part indent, estimasi waktu 7–14 hari kerja).\r\nCatatan: Part bergaransi selama 1 bulan.\r\n**)Sebagai informasi unit cek dudukan engsel pada topcover jebol dan kuncian penutup engsel pada ujung-ujungnya patah, jika ingin normal maka perlu penggantian top cover dan hinge cap.\r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%.\r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA \r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-07 08:37:26', '2026-04-07 08:37:26'),
(68, 'Maulida', 'Alhan', '6285158816155', '5100082231', 'Yth. Bapak/Ibu *Alhan*,\r\n\r\nKami dari *HP Service Center Semarang*, mau reminder perihal penawaran kami untuk unit Anda *HP Ink Tank 315* dengan Case ID *5100082231* kira-kira bagaimana Bapak/Ibu untuk kelanjutannya?\r\n\r\nKami tunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo', 'sent', '2026-04-08 05:15:07', '2026-04-08 05:15:07'),
(69, 'Maulida', 'Ahmad Rokhi Regar', '6282134733012', '5100082250', 'Yth. Bapak/Ibu *Ahmad Rokhi Regar*,\r\n\r\nSaya *Maulida* dari *HP Service Center Semarang* ingin menyampaikan informasi terkait unit Anda *Victus Gaming Laptop 16-s0009AX* dengan Case ID *5100082250*. Setelah dilakukan pengecekan, unit awal bisa menyala beberapa detik kemudian kedip-kedip dan blank, seperti yang dikeluhkan. Sudah coba dicompare ram namun masih sama saja. Unit coba dicompare mainboard lain, bisa menyala normal..\r\nSehubungan dengan hal tersebut, kami menawarkan untuk dilakukan REPAIR/SERVICE MAINBOARD dulu, baru bisa cek kerusakan yang lain, dengan estimasi biaya repair Rp. 3.150.000 - 3.500.000 /2-4 mingguan minggu pengerjaan tergantung dengan tingkat kerusakan mainboardnya. Jika bisa lebih cepat akan langsung kami informasikan kembali.\r\nKemungkinan berhasil 50:50, namun kami selalu maksimalkan dulu repairnya supaya bisa sukses dan unit kembali hidup. Kami juga sudah sering menangani hal ini, dan banyak juga yang hasilnya good.\r\n\r\nJika repair nya gagal, resiko bisa membuat unit jadi MATI TOTAL, jika repair gagal, maka hanya dikenakan biaya Rp. 125.000 sebagai ganti biaya analisa troubleshootnya.\r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%. \r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n  * A/c     : PT. Harmoni Putra Solusindo \r\n  * A/n     : 1824567878 \r\n  * Bank    : BCA\r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-08 08:19:56', '2026-04-08 08:19:56'),
(70, 'Maulida', 'Nailah Faza Luthfiah', '6283189027068', '5100082256', 'Yth. Bapak/Ibu *Nailah Faza Luthfiah*,\r\n\r\nSaya Maulida dari HP Service Center Semarang ingin menyampaikan informasi terkait unit Anda HP Laptop PC 14-d2000 (2D127AV) dengan Case ID 5100082256. Setelah dilakukan pengecekan, ditemukan adanya kendala pada SSDnya rusak (SSD terpasang 512GB).\r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian part SSD 512 GB dengan harga Rp. 2.045.000 + biaya bongkar pemasangan Rp. 195.000 = Rp. 2.240.000 (part indent, estimasi waktu 7–14 hari kerja).\r\nCatatan: Part bergaransi selama 1 bulan.\r\n\r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%.\r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA \r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-08 08:37:02', '2026-04-08 08:37:02'),
(71, 'Maulida', 'Hendra', '6281225493099', '5100082260', 'Yth. Bapak/Ibu *Hendra*,\r\n\r\nSaya Maulida dari HP Service Center Semarang ingin menyampaikan informasi terkait unit Anda HP Laptop 14s-fq1136AU dengan Case ID 5100082260. Setelah dilakukan pengecekan, ditemukan adanya kendala pada Keyboardnya, unit cek ada seperti bekas terkena kencing hewan.\r\n\r\nSehubungan dengan hal tersebut, kami menawarkan penggantian part Top Cover Keyboard dengan harga Rp. 2.995.000 (part indent, estimasi waktu 7–14 hari kerja).\r\nCatatan: Part bergaransi selama 1 bulan.\r\n\r\n\r\nApabila Bapak/Ibu setuju, mohon dapat memberikan DP minimal 50%.\r\nUntuk Pembayaran dapat ditransfer ke rekening : \r\n* A/c     : PT. Harmoni Putra Solusindo \r\n* A/n     : 1824567878 \r\n* Bank    : BCA \r\n\r\nKami menunggu konfirmasinya. Terima kasih atas perhatian dan kerjasamanya.\r\n\r\nSalam,\r\nMaulida\r\nCall Management\r\nPT. Harmoni Putra Solusindo\r\n', 'sent', '2026-04-08 09:08:26', '2026-04-08 09:08:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pics`
--
ALTER TABLE `pics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wa_logs`
--
ALTER TABLE `wa_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pics`
--
ALTER TABLE `pics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wa_logs`
--
ALTER TABLE `wa_logs`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
