/*
 Navicat Premium Data Transfer

 Source Server         : bima
 Source Server Type    : MySQL
 Source Server Version : 50513 (5.5.13)
 Source Host           : localhost:3306
 Source Schema         : bima

 Target Server Type    : MySQL
 Target Server Version : 50513 (5.5.13)
 File Encoding         : 65001

 Date: 06/04/2023 22:40:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bayar_hutang
-- ----------------------------
DROP TABLE IF EXISTS `bayar_hutang`;
CREATE TABLE `bayar_hutang`  (
  `no_bayar` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_input` datetime NOT NULL,
  `no_transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_bayar` decimal(10, 0) NOT NULL,
  `jumlah` decimal(10, 0) NOT NULL,
  `sisa` decimal(10, 0) NOT NULL,
  `modifiedby` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`no_bayar`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bayar_hutang
-- ----------------------------

-- ----------------------------
-- Table structure for bayar_hutang_d
-- ----------------------------
DROP TABLE IF EXISTS `bayar_hutang_d`;
CREATE TABLE `bayar_hutang_d`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `no_bayar` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_bayar` datetime NULL DEFAULT NULL,
  `jns_bayar` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_kas` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kartu` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kartu` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bank_kartu` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nilai_bayar` decimal(10, 0) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bayar_hutang_d
-- ----------------------------

-- ----------------------------
-- Table structure for bayar_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `bayar_transaksi`;
CREATE TABLE `bayar_transaksi`  (
  `no_bayar` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_input` datetime NOT NULL,
  `no_transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_bayar` decimal(10, 0) NOT NULL,
  `jumlah` decimal(10, 0) NOT NULL,
  `sisa` decimal(10, 0) NOT NULL,
  `kode_kas` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `modifiedby` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`no_bayar`) USING BTREE,
  INDEX `bayar_transaksi_index`(`no_transaksi`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bayar_transaksi
-- ----------------------------
INSERT INTO `bayar_transaksi` VALUES ('BP00001', '2022-12-27 11:38:37', 'JL00001', 40000, 50000, 0, 'Kas Kecil', 'admin');

-- ----------------------------
-- Table structure for bayar_transaksi_d
-- ----------------------------
DROP TABLE IF EXISTS `bayar_transaksi_d`;
CREATE TABLE `bayar_transaksi_d`  (
  `id` int(10) UNSIGNED NOT NULL,
  `no_bayar` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_bayar` datetime NULL DEFAULT NULL,
  `jns_bayar` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_kas` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kartu` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kartu` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bank_kartu` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nilai_bayar` decimal(10, 0) NOT NULL DEFAULT 0
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bayar_transaksi_d
-- ----------------------------
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00002', '2023-01-23 23:49:49', NULL, 'Kas Kecil', NULL, NULL, NULL, 40000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00001', '2022-12-27 11:38:37', NULL, 'Kas Kecil', NULL, NULL, NULL, 40000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00004', '2022-12-27 11:37:46', NULL, 'Kas Kecil', NULL, NULL, NULL, 20000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00003', '2022-12-27 11:35:57', NULL, 'Kas Kecil', NULL, NULL, NULL, 40000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00002', '2022-12-27 11:35:32', NULL, 'Kas Kecil', NULL, NULL, NULL, 40000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00001', '2022-12-27 11:31:57', NULL, 'Kas Kecil', NULL, NULL, NULL, 20000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00001', '2022-12-27 11:27:18', NULL, 'Kas Kecil', NULL, NULL, NULL, 10000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00001', '2022-12-27 11:24:47', NULL, 'Kas Kecil', NULL, NULL, NULL, 5000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00001', '2022-12-27 11:22:54', NULL, 'Kas Kecil', NULL, NULL, NULL, 20000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00001', '2022-12-27 11:19:43', NULL, 'Kas Kecil', NULL, NULL, NULL, 10000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00001', '2022-12-27 11:09:16', NULL, 'Kas Kecil', NULL, NULL, NULL, 40000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00001', '2022-12-27 10:38:42', NULL, 'Kas Kecil', NULL, NULL, NULL, 40000);
INSERT INTO `bayar_transaksi_d` VALUES (0, 'BP00001', '2022-07-03 12:35:50', NULL, 'Kas Kecil', NULL, NULL, NULL, 40000);

-- ----------------------------
-- Table structure for dkey
-- ----------------------------
DROP TABLE IF EXISTS `dkey`;
CREATE TABLE `dkey`  (
  `id` int(11) NOT NULL,
  `value` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dkey
-- ----------------------------
INSERT INTO `dkey` VALUES (1, 'b9a595cf4090ddf5a09083f5ed6b26a9');

-- ----------------------------
-- Table structure for dkey_temp
-- ----------------------------
DROP TABLE IF EXISTS `dkey_temp`;
CREATE TABLE `dkey_temp`  (
  `id` int(11) NOT NULL,
  `value` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dkey_temp
-- ----------------------------
INSERT INTO `dkey_temp` VALUES (1, 'b9a595cf4090ddf5a09083f5ed6b26a9');

-- ----------------------------
-- Table structure for history_stock
-- ----------------------------
DROP TABLE IF EXISTS `history_stock`;
CREATE TABLE `history_stock`  (
  `Id_stock` int(11) NOT NULL AUTO_INCREMENT,
  `Tanggal` datetime NULL DEFAULT NULL,
  `Kode_Produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Transaksi` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Dokumen` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Masuk` decimal(16, 2) NULL DEFAULT NULL,
  `Keluar` decimal(16, 2) NULL DEFAULT NULL,
  `Laststock` decimal(16, 0) NULL DEFAULT NULL,
  `ModifiedBy` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id_stock`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 25 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of history_stock
-- ----------------------------
INSERT INTO `history_stock` VALUES (1, '2021-07-24 21:09:03', 'pin', 'Pembuatan Master Barang', 'Stok Awal', 100.00, 0.00, 100, 'admin');
INSERT INTO `history_stock` VALUES (15, '2021-07-26 15:40:37', 'Roll up ', 'Pembelian Barang', 'PB00001', 100.00, 0.00, 190, 'admin');
INSERT INTO `history_stock` VALUES (20, '2022-05-11 16:21:02', 'qwe', 'Pembuatan Master Barang', 'Stok Awal', 1000.00, 0.00, 1000, 'sabil');
INSERT INTO `history_stock` VALUES (4, '2021-07-24 21:33:09', 'pin', 'Penjualan Umum', 'JL00005', 0.00, 20.00, 25, 'admin');
INSERT INTO `history_stock` VALUES (5, '2021-07-24 21:54:16', 'Bahan Frontlite 280gr Grade A', 'Pembuatan Master Barang', 'Stok Awal', 50.00, 0.00, 50, 'admin');
INSERT INTO `history_stock` VALUES (6, '2021-07-24 21:55:00', 'Bahan Frontlite 280gr Grade A', 'Penjualan Umum', 'JL00006', 0.00, 2.00, 48, 'admin');
INSERT INTO `history_stock` VALUES (7, '2021-07-24 21:55:55', 'Bahan Frontlite 280gr Grade A', 'Penjualan Umum', 'JL00007', 0.00, 10.00, 38, 'admin');
INSERT INTO `history_stock` VALUES (8, '2021-07-24 22:01:38', 'pin', 'Pembelian Barang', 'PB00001', 100.00, 0.00, 125, 'admin');
INSERT INTO `history_stock` VALUES (9, '2021-07-24 23:20:57', 'kaos putih', 'Pembuatan Master Barang', 'Stok Awal', 50.00, 0.00, 50, 'admin');
INSERT INTO `history_stock` VALUES (10, '2021-07-24 23:23:03', 'kaos putih', 'Penjualan Umum', 'JL00008', 0.00, 20.00, 30, 'admin');
INSERT INTO `history_stock` VALUES (11, '2021-07-25 09:07:06', 'kaos putih', 'Penjualan Umum', 'JL00010', 0.00, 10.00, 20, 'admin');
INSERT INTO `history_stock` VALUES (12, '2021-07-26 14:13:31', 'Roll up ', 'Pembuatan Master Barang', 'Stok Awal', 100.00, 0.00, 100, 'admin');
INSERT INTO `history_stock` VALUES (21, '2022-05-11 16:21:28', 'qwe', 'Pembuatan Master Barang', 'Stok Awal', 4000.00, 0.00, 5000, 'sabil');
INSERT INTO `history_stock` VALUES (17, '2021-07-26 21:39:28', 'Roll up ', 'Pembelian Barang', 'PB00003', 150.00, 0.00, 340, 'admin');
INSERT INTO `history_stock` VALUES (18, '2021-07-26 22:44:34', 'DSP Roll up 60x160', 'Pembuatan Master Barang', 'Stok Awal', 100.00, 0.00, 100, 'admin');
INSERT INTO `history_stock` VALUES (19, '2021-07-26 22:58:47', 'DSP X baner', 'Pembuatan Master Barang', 'Stok Awal', 100.00, 0.00, 100, 'admin');
INSERT INTO `history_stock` VALUES (22, '2022-05-11 16:34:07', 'qwe', 'Pembuatan Master Barang', 'Stok Awal', 0.00, 0.00, 0, 'sabil');
INSERT INTO `history_stock` VALUES (23, '2022-05-11 16:44:11', 'DSP Roll up 60x160', 'Pembuatan Master Barang', 'Stok Awal', 900.00, 0.00, 1000, 'sabil');
INSERT INTO `history_stock` VALUES (24, '2022-05-12 11:50:41', 'qwe', 'Pembuatan Master Barang', 'Stok Awal', 500.00, 0.00, 500, 'sabil');

-- ----------------------------
-- Table structure for itemestimasi
-- ----------------------------
DROP TABLE IF EXISTS `itemestimasi`;
CREATE TABLE `itemestimasi`  (
  `No_ItemTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Kode_Produk` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Nama_Produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p` decimal(16, 2) NULL DEFAULT NULL,
  `l` decimal(16, 2) NULL DEFAULT NULL,
  `Qty` decimal(16, 2) NULL DEFAULT NULL,
  `satuan` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cost` decimal(16, 2) NULL DEFAULT NULL,
  `sales` decimal(16, 2) NULL DEFAULT NULL,
  `subtotal_sales` decimal(16, 2) NULL DEFAULT NULL,
  `finishing` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `namafile` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isdimensi` tinyint(1) NULL DEFAULT NULL,
  `distock` tinyint(1) NULL DEFAULT NULL,
  `isopen` tinyint(1) NULL DEFAULT NULL,
  `TglModified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_ItemTransaksi`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of itemestimasi
-- ----------------------------

-- ----------------------------
-- Table structure for itempembelian
-- ----------------------------
DROP TABLE IF EXISTS `itempembelian`;
CREATE TABLE `itempembelian`  (
  `No_ItemTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Kode_Produk` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Nama_Produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p` decimal(16, 2) NULL DEFAULT NULL,
  `l` decimal(16, 2) NULL DEFAULT NULL,
  `Qty` decimal(16, 0) NULL DEFAULT NULL,
  `satuan` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cost` decimal(16, 0) NULL DEFAULT NULL,
  `sales` decimal(16, 0) NULL DEFAULT NULL,
  `subtotal_sales` decimal(16, 0) NULL DEFAULT NULL,
  `finishing` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `namafile` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isdimensi` tinyint(1) NULL DEFAULT NULL,
  `distock` tinyint(1) NULL DEFAULT NULL,
  `isopen` tinyint(1) NULL DEFAULT NULL,
  `TglModified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_ItemTransaksi`) USING BTREE,
  INDEX `itempembelian_index`(`No_Transaksi`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of itempembelian
-- ----------------------------

-- ----------------------------
-- Table structure for itempesanan
-- ----------------------------
DROP TABLE IF EXISTS `itempesanan`;
CREATE TABLE `itempesanan`  (
  `No_ItemTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Kode_Produk` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Nama_Produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p` decimal(16, 2) NULL DEFAULT NULL,
  `l` decimal(16, 2) NULL DEFAULT NULL,
  `Qty` decimal(16, 0) NULL DEFAULT NULL,
  `satuan` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cost` decimal(16, 0) NULL DEFAULT NULL,
  `sales` decimal(16, 0) NULL DEFAULT NULL,
  `subtotal_sales` decimal(16, 0) NULL DEFAULT NULL,
  `finishing` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `namafile` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isdimensi` tinyint(1) NULL DEFAULT NULL,
  `distock` tinyint(1) NULL DEFAULT NULL,
  `isopen` tinyint(1) NULL DEFAULT NULL,
  `TglModified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_ItemTransaksi`) USING BTREE,
  INDEX `itempesanan_index`(`No_Transaksi`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 27 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of itempesanan
-- ----------------------------

-- ----------------------------
-- Table structure for itemreturbeli
-- ----------------------------
DROP TABLE IF EXISTS `itemreturbeli`;
CREATE TABLE `itemreturbeli`  (
  `No_ItemTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Kode_Produk` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Nama_Produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p` decimal(16, 2) NULL DEFAULT NULL,
  `l` decimal(16, 2) NULL DEFAULT NULL,
  `Qty` decimal(16, 0) NULL DEFAULT NULL,
  `satuan` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cost` decimal(16, 0) NULL DEFAULT NULL,
  `sales` decimal(16, 0) NULL DEFAULT NULL,
  `subtotal_sales` decimal(16, 0) NULL DEFAULT NULL,
  `finishing` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `namafile` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isdimensi` tinyint(1) NULL DEFAULT NULL,
  `distock` tinyint(1) NULL DEFAULT NULL,
  `isopen` tinyint(1) NULL DEFAULT NULL,
  `TglModified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_ItemTransaksi`) USING BTREE,
  INDEX `itemreturbeli_index`(`No_Transaksi`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of itemreturbeli
-- ----------------------------

-- ----------------------------
-- Table structure for itemtransaksi
-- ----------------------------
DROP TABLE IF EXISTS `itemtransaksi`;
CREATE TABLE `itemtransaksi`  (
  `No_ItemTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Kode_Produk` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Nama_Produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p` decimal(16, 2) NULL DEFAULT NULL,
  `l` decimal(16, 2) NULL DEFAULT NULL,
  `Qty` decimal(16, 0) NULL DEFAULT NULL,
  `satuan` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cost` decimal(16, 0) NULL DEFAULT NULL,
  `sales` decimal(16, 0) NULL DEFAULT NULL,
  `subtotal_sales` decimal(16, 0) NULL DEFAULT NULL,
  `finishing` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `namafile` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isdimensi` tinyint(1) NULL DEFAULT NULL,
  `distock` tinyint(1) NULL DEFAULT NULL,
  `isopen` tinyint(1) NULL DEFAULT NULL,
  `TglModified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_ItemTransaksi`) USING BTREE,
  INDEX `itemtransaksi_index`(`No_Transaksi`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 65 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of itemtransaksi
-- ----------------------------
INSERT INTO `itemtransaksi` VALUES (63, 'JL00001', '2022-12-27 11:38:30', 'BNR 280', 'Banner Frontlite 280', 2.00, 1.00, 1, 'PCS', 10000, 20000, 40000, '', '', '', 1, NULL, NULL, '2022-12-27 11:38:30', 'admin');

-- ----------------------------
-- Table structure for itemtransaksi_spesial
-- ----------------------------
DROP TABLE IF EXISTS `itemtransaksi_spesial`;
CREATE TABLE `itemtransaksi_spesial`  (
  `No_ItemTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Kode_Produk` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Nama_Produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p` decimal(16, 2) NULL DEFAULT NULL,
  `l` decimal(16, 2) NULL DEFAULT NULL,
  `Qty` decimal(16, 0) NULL DEFAULT NULL,
  `satuan` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cost` decimal(16, 0) NULL DEFAULT NULL,
  `sales` decimal(16, 0) NULL DEFAULT NULL,
  `subtotal_sales` decimal(16, 0) NULL DEFAULT NULL,
  `finishing` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `namafile` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `isdimensi` tinyint(1) NULL DEFAULT NULL,
  `distock` tinyint(1) NULL DEFAULT NULL,
  `isopen` tinyint(1) NULL DEFAULT NULL,
  `TglModified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_ItemTransaksi`) USING BTREE,
  INDEX `itemtransaksi_spesial_index`(`No_Transaksi`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of itemtransaksi_spesial
-- ----------------------------

-- ----------------------------
-- Table structure for jabatan
-- ----------------------------
DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan`  (
  `Kode_jabatan` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_Jabatan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Kode_jabatan`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jabatan
-- ----------------------------
INSERT INTO `jabatan` VALUES ('MGR', 'Manager');
INSERT INTO `jabatan` VALUES ('KSR', 'Kasir');
INSERT INTO `jabatan` VALUES ('SPV', 'Supervisor');
INSERT INTO `jabatan` VALUES ('OPT', 'Operator');
INSERT INTO `jabatan` VALUES ('DGR', 'Desain Grafis');
INSERT INTO `jabatan` VALUES ('OWR', 'Owner');

-- ----------------------------
-- Table structure for jurnal
-- ----------------------------
DROP TABLE IF EXISTS `jurnal`;
CREATE TABLE `jurnal`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `no_jurnal` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tanggal` datetime NULL DEFAULT NULL,
  `Dokumen` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `debet` int(11) NULL DEFAULT NULL,
  `kredit` int(11) NULL DEFAULT NULL,
  `ModifiedBy` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`, `no_jurnal`) USING BTREE,
  INDEX `jurnal_index`(`Dokumen`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 136 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jurnal
-- ----------------------------
INSERT INTO `jurnal` VALUES (130, 'JT00001', '2022-12-27 11:38:30', 'JL00001', 40000, 40000, 'admin', 'Piutang Pesanan Nomor JL00001');
INSERT INTO `jurnal` VALUES (131, 'JT00001', '2022-12-27 11:38:30', 'JL00001', 20000, 20000, 'admin', 'HPP Pesanan Nomor JL00001');
INSERT INTO `jurnal` VALUES (132, 'JT00131', '2022-12-27 11:38:37', 'JL00001-BP00001', 40000, 40000, 'admin', 'Bayar Piutang Pesanan Nomor JL00001');

-- ----------------------------
-- Table structure for jurnal_d
-- ----------------------------
DROP TABLE IF EXISTS `jurnal_d`;
CREATE TABLE `jurnal_d`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `no_jurnal` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tanggal` datetime NULL DEFAULT NULL,
  `kode` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `posting` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Dokumen` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `debet` int(11) NULL DEFAULT NULL,
  `kredit` int(11) NULL DEFAULT NULL,
  `ModifiedBy` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 271 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jurnal_d
-- ----------------------------
INSERT INTO `jurnal_d` VALUES (259, 'JT00001', '2022-12-27 11:38:30', '103', 'Piutang Usaha', 'JL00001', 40000, 0, 'admin');
INSERT INTO `jurnal_d` VALUES (260, 'JT00001', '2022-12-27 11:38:30', '400', 'Penjualan', 'JL00001', 0, 40000, 'admin');
INSERT INTO `jurnal_d` VALUES (261, 'JT00260', '2022-12-27 11:38:30', '503', 'Harga Pokok Penjualan', 'JL00001-HPP', 20000, 0, 'admin');
INSERT INTO `jurnal_d` VALUES (262, 'JT00260', '2022-12-27 11:38:30', '102', 'Persediaan Barang Dagang', 'JL00001-HPP', 0, 20000, 'admin');
INSERT INTO `jurnal_d` VALUES (263, 'JT00262', '2022-12-27 11:38:37', '103', 'Piutang Usaha', 'JL00001-BP00001', 0, 40000, 'admin');
INSERT INTO `jurnal_d` VALUES (264, 'JT00262', '2022-12-27 11:38:37', '101', 'Kas', 'JL00001-BP00001', 40000, 0, 'admin');

-- ----------------------------
-- Table structure for karyawan
-- ----------------------------
DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE `karyawan`  (
  `NIK` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Username` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Password` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nama_Pegawai` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Alamat_pegawai` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Kode_jabatan` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`NIK`) USING BTREE,
  INDEX `karyawan_index`(`NIK`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of karyawan
-- ----------------------------
INSERT INTO `karyawan` VALUES ('001', 'admin', 'admin', 'admin', NULL, 'Manager');
INSERT INTO `karyawan` VALUES ('002', 'desain', 'desain', 'desain', NULL, 'Desain Grafis');
INSERT INTO `karyawan` VALUES ('003', 'kasir', 'kasir', 'kasir', NULL, 'Kasir');
INSERT INTO `karyawan` VALUES ('004', 'operator', 'operator', 'operator', NULL, 'Operator');
INSERT INTO `karyawan` VALUES ('005', 'supervisor', 'supervisor', 'supervisor', NULL, 'Supervisor');
INSERT INTO `karyawan` VALUES ('007', 'owner', 'owner', 'owner', 'Surabaya', 'Owner');

-- ----------------------------
-- Table structure for kas
-- ----------------------------
DROP TABLE IF EXISTS `kas`;
CREATE TABLE `kas`  (
  `Id_kas` int(11) NOT NULL AUTO_INCREMENT,
  `Tanggal` datetime NULL DEFAULT NULL,
  `kode_kas` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Keterangan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Dokumen` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Masuk` int(11) NULL DEFAULT NULL,
  `Keluar` int(11) NULL DEFAULT NULL,
  `ModifiedBy` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_kas`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 49 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kas
-- ----------------------------
INSERT INTO `kas` VALUES (2, '2021-07-13 09:28:39', 'Kas Kecil', 'Awal Transaksi', 'KI00001', 0, 0, 'admin', 0);
INSERT INTO `kas` VALUES (46, '2022-12-27 11:38:37', 'Kas Kecil', 'Pembayaran Kas Kecil (JL00001)', 'BP00001', 40000, 0, 'admin', 0);
INSERT INTO `kas` VALUES (45, '2022-12-27 11:38:04', 'Kas Kecil', 'Pembatalan Penjualan (JL00004)', 'Pembatalan', 0, 40000, 'admin', 0);
INSERT INTO `kas` VALUES (44, '2022-12-27 11:38:01', 'Kas Kecil', 'Pembatalan Penjualan (JL00005)', 'Pembatalan', 0, 20000, 'admin', 0);
INSERT INTO `kas` VALUES (43, '2022-12-27 11:37:58', 'Kas Kecil', 'Pembatalan Penjualan (JL00006)', 'Pembatalan', 0, 40000, 'admin', 0);
INSERT INTO `kas` VALUES (42, '2022-12-27 11:37:54', 'Kas Kecil', 'Pembatalan Penjualan (JL00007)', 'Pembatalan', 0, 20000, 'admin', 0);
INSERT INTO `kas` VALUES (41, '2022-12-27 11:37:46', 'Kas Kecil', 'Pembayaran Kas Kecil (JL00007)', 'BP00004', 20000, 0, 'admin', 0);
INSERT INTO `kas` VALUES (39, '2022-12-27 11:35:32', 'Kas Kecil', 'Pembayaran Kas Kecil (JL00004)', 'BP00002', 40000, 0, 'admin', 0);
INSERT INTO `kas` VALUES (40, '2022-12-27 11:35:57', 'Kas Kecil', 'Pembayaran Kas Kecil (JL00006)', 'BP00003', 40000, 0, 'admin', 0);
INSERT INTO `kas` VALUES (38, '2022-12-27 11:31:57', 'Kas Kecil', 'Pembayaran Kas Kecil (JL00005)', 'BP00001', 20000, 0, 'admin', 0);
INSERT INTO `kas` VALUES (47, '2023-01-23 23:49:49', 'Kas Kecil', 'Pembayaran Kas Kecil (JL00002)', 'BP00002', 40000, 0, 'admin', 0);
INSERT INTO `kas` VALUES (48, '2023-01-23 23:50:56', 'Kas Kecil', 'Pembatalan Penjualan (JL00002)', 'Pembatalan', 0, 40000, 'admin', 0);

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `keterangan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`keterangan`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES ('');
INSERT INTO `kategori` VALUES ('BAHAN');
INSERT INTO `kategori` VALUES ('DISPLAY');
INSERT INTO `kategori` VALUES ('DTF');
INSERT INTO `kategori` VALUES ('FINISHING');
INSERT INTO `kategori` VALUES ('INDOOR');
INSERT INTO `kategori` VALUES ('LASER A3+');
INSERT INTO `kategori` VALUES ('MEMBER');
INSERT INTO `kategori` VALUES ('MESIN');
INSERT INTO `kategori` VALUES ('OFFSET');
INSERT INTO `kategori` VALUES ('OUTDOOR');
INSERT INTO `kategori` VALUES ('PENUNJANG');
INSERT INTO `kategori` VALUES ('POLYFLEX');
INSERT INTO `kategori` VALUES ('SPAREPART');
INSERT INTO `kategori` VALUES ('SUBLIM');
INSERT INTO `kategori` VALUES ('UV');

-- ----------------------------
-- Table structure for kurir
-- ----------------------------
DROP TABLE IF EXISTS `kurir`;
CREATE TABLE `kurir`  (
  `kode` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `telepon` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`kode`, `urut`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kurir
-- ----------------------------
INSERT INTO `kurir` VALUES ('JNE', 'JNE', 'Surabaya', '081234567890', 1);

-- ----------------------------
-- Table structure for laststock
-- ----------------------------
DROP TABLE IF EXISTS `laststock`;
CREATE TABLE `laststock`  (
  `Id_Stock` int(11) NOT NULL AUTO_INCREMENT,
  `Tanggal` datetime NULL DEFAULT NULL,
  `Kode_produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Laststock` decimal(16, 0) NOT NULL,
  `Qty_Last_terima` decimal(16, 2) NULL DEFAULT NULL,
  `tgl_Last_terima` datetime NULL DEFAULT NULL,
  `Qty_Last_Out` decimal(16, 2) NULL DEFAULT NULL,
  `Tgl_last_Out` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `expired` date NULL DEFAULT NULL,
  PRIMARY KEY (`Id_Stock`) USING BTREE,
  UNIQUE INDEX `Kode_produk`(`Kode_produk`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of laststock
-- ----------------------------
INSERT INTO `laststock` VALUES (1, '2021-07-24 22:01:38', 'pin', 125, 100.00, '2021-07-24 22:01:38', 20.00, '2021-07-24 21:33:09', 'admin', NULL);
INSERT INTO `laststock` VALUES (2, '2021-07-24 21:55:55', 'Bahan Frontlite 280gr Grade A', 38, NULL, NULL, 10.00, '2021-07-24 21:55:55', 'admin', NULL);
INSERT INTO `laststock` VALUES (3, '2021-07-25 09:07:06', 'kaos putih', 20, NULL, NULL, 10.00, '2021-07-25 09:07:06', 'admin', NULL);
INSERT INTO `laststock` VALUES (4, '2021-07-26 21:39:28', 'Roll up ', 340, 150.00, '2021-07-26 21:39:28', 10.00, '2021-07-26 17:36:13', 'admin', NULL);
INSERT INTO `laststock` VALUES (6, '2021-07-26 22:58:47', 'DSP X baner', 100, NULL, NULL, NULL, NULL, 'admin', NULL);

-- ----------------------------
-- Table structure for lembur
-- ----------------------------
DROP TABLE IF EXISTS `lembur`;
CREATE TABLE `lembur`  (
  `No_Lembur` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Jam_Mulai` time NOT NULL,
  `Jam_Selesai` time NOT NULL,
  `Keterangan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nominal` decimal(16, 0) NOT NULL
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lembur
-- ----------------------------

-- ----------------------------
-- Table structure for m_akun
-- ----------------------------
DROP TABLE IF EXISTS `m_akun`;
CREATE TABLE `m_akun`  (
  `kode` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `stat_trans` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_grup` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `dk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `saldo` decimal(10, 2) NULL DEFAULT 0.00,
  PRIMARY KEY (`kode`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_akun
-- ----------------------------
INSERT INTO `m_akun` VALUES ('101', 'Kas', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('102', 'Persediaan Barang Dagang', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('103', 'Piutang Usaha', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('104', 'Penyisihan Piutang Usaha', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('105', 'Wesel Tagih', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('106', 'Perlengkapan', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('107', 'Iklan Dibayar Dimuka', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('108', 'Sewa Dibayar Dimuka', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('109', 'Asuransi Dibayar Dimuka', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('111', 'Peralatan', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('112', 'Akumulasi Penyusutan Peralatan', 'Y', '1', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('113', 'Kendaraan', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('114', 'Akumulasi Penyusutan Peralatanan Kendaraan', 'Y', '1', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('115', 'Gedung', 'Y', '1', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('116', 'Akumulasi Penyusutan Gedung', 'Y', '1', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('201', 'Utang Usaha/Dagang', 'Y', '2', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('202', 'Utang Wesel', 'Y', '2', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('203', 'Utang Gaji', 'Y', '2', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('204', 'Utang Pajak Penghasilan', 'Y', '2', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('205', 'Utang Hipotek', 'Y', '2', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('206', 'Utang Obligasi', 'Y', '2', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('300', 'Modal/Ekuitas', 'Y', '3', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('301', 'Prive', 'Y', '3', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('400', 'Penjualan', 'Y', '4', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('401', 'Retur Penjualan', 'Y', '4', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('402', 'Potongan Penjualan', 'Y', '4', 'D', 0.00);
INSERT INTO `m_akun` VALUES ('500', 'Pembelian', 'Y', '5', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('501', 'Beban Angkut Pembelian', 'Y', '5', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('502', 'Potongan Pembelian', 'Y', '5', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('600', 'Beban Gaji Karyawan', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('601', 'Beban Gaji Outsourcing', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('602', 'Beban Sewa Gedung', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('603', 'Beban Asuransi', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('604', 'Beban Penyesuaian Piutang', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('605', 'Beban Perlengkapan Kantor', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('606', 'Beban Perlengkapan Toko', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('607', 'Beban Iklan', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('608', 'Beban Penyusutan Peralatan', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('609', 'Beban Penyusutan Gedung', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('610', 'Beban Bunga', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('611', 'Beban Listrik Dan Telepon', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('612', 'Beban Administrasi Dan Umum', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('613', 'Biaya Lain-Lain', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('503', 'Harga Pokok Penjualan', 'Y', '5', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('614', 'Biaya Operasional Kantor', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('615', 'Biaya Ongkos Kirim dan Ekspedisi', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('616', 'Beban BPJS', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('617', 'Beban PDAM', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('618', 'Beban Internet', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('619', 'Biaya Import', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('620', 'Biaya Mantainance dan Sparepart', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('621', 'Biaya Peralatan', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('622', 'Biaya Marketing', 'Y', '6', 'K', 0.00);
INSERT INTO `m_akun` VALUES ('623', 'Beban Tunjangan Hari Raya', 'Y', '6', 'K', 0.00);

-- ----------------------------
-- Table structure for m_kas
-- ----------------------------
DROP TABLE IF EXISTS `m_kas`;
CREATE TABLE `m_kas`  (
  `kode` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `saldo` decimal(10, 2) NULL DEFAULT 0.00,
  PRIMARY KEY (`kode`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_kas
-- ----------------------------
INSERT INTO `m_kas` VALUES ('Kas Kecil', 'Kas Kecil', 0.00);
INSERT INTO `m_kas` VALUES ('Kas Utama', 'Kas Utama', 0.00);
INSERT INTO `m_kas` VALUES ('BCA', 'BCA', 0.00);
INSERT INTO `m_kas` VALUES ('BNI', 'BNI', 0.00);
INSERT INTO `m_kas` VALUES ('Semua', 'Semua', 0.00);
INSERT INTO `m_kas` VALUES ('MDR', 'MANDIRI', 0.00);

-- ----------------------------
-- Table structure for pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan`  (
  `kode` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `telepon` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `member` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`kode`, `urut`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelanggan
-- ----------------------------
INSERT INTO `pelanggan` VALUES ('C00001', 'UMUM', 'UMUM', '62812345678', 'UMUM', 1);
INSERT INTO `pelanggan` VALUES ('C00002', 'samiran', 'aaa', '628123456789', 'MEMBER', 1);
INSERT INTO `pelanggan` VALUES ('C00003', 'udin', 'surabaya', '62812345789', 'UMUM', 1);

-- ----------------------------
-- Table structure for pembelian
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian`  (
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Status_Bayar` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Status_Transaksi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_qty` decimal(16, 0) NULL DEFAULT NULL,
  `total_item` decimal(16, 0) NULL DEFAULT NULL,
  `total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `pajak` decimal(16, 0) NULL DEFAULT NULL,
  `biaya_lain` decimal(16, 0) NULL DEFAULT NULL,
  `potongan` decimal(16, 0) NULL DEFAULT NULL,
  `net_total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `total_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `total_kembali` decimal(16, 0) NULL DEFAULT NULL,
  `sisa_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `no_supplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_supplier` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_supplier` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_supplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kurir` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kurir` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_cs` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kasir` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_sales` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waktu_bayar` datetime NULL DEFAULT NULL,
  `kassa` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tgl_Modified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_Transaksi`) USING BTREE,
  INDEX `pembelian_index`(`No_Transaksi`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pembelian
-- ----------------------------

-- ----------------------------
-- Table structure for perusahaan
-- ----------------------------
DROP TABLE IF EXISTS `perusahaan`;
CREATE TABLE `perusahaan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nama_perusahaan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Alamat` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Telepon` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `gambar` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_gmbr` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `catatan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of perusahaan
-- ----------------------------
INSERT INTO `perusahaan` VALUES (1, 'BIMA Digital Printing', 'Surabaya', '081234567899', 'C:\\Images\\logob21.jpg', 'logob21.jpg', 'bima@gmail.com', 'Transfer Rekening BCA no.1515151515 a.n Bos Bima ');

-- ----------------------------
-- Table structure for pesanan
-- ----------------------------
DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE `pesanan`  (
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Status_Bayar` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Status_Transaksi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_qty` decimal(16, 0) NULL DEFAULT NULL,
  `total_item` decimal(16, 0) NULL DEFAULT NULL,
  `total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `pajak` decimal(16, 0) NULL DEFAULT NULL,
  `biaya_lain` decimal(16, 0) NULL DEFAULT NULL,
  `potongan` decimal(16, 0) NULL DEFAULT NULL,
  `net_total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `total_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `total_kembali` decimal(16, 0) NULL DEFAULT NULL,
  `sisa_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `no_pemesan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_pemesan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_pemesan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_pemesan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `membership` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kirim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kirim` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kirim` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kirim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kurir` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kurir` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_cs` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kasir` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_sales` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `worker` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waktu_bayar` datetime NULL DEFAULT NULL,
  `kassa` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_jatuhtempo` date NULL DEFAULT NULL,
  `tgl_deadline` date NULL DEFAULT NULL,
  `no_estimasi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tgl_Modified` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_Transaksi`) USING BTREE,
  INDEX `pesanan_index`(`No_Transaksi`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pesanan
-- ----------------------------

-- ----------------------------
-- Table structure for pesanan_temp
-- ----------------------------
DROP TABLE IF EXISTS `pesanan_temp`;
CREATE TABLE `pesanan_temp`  (
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Status_Bayar` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Status_Transaksi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_qty` decimal(16, 0) NULL DEFAULT NULL,
  `total_item` decimal(16, 0) NULL DEFAULT NULL,
  `total_sales` decimal(16, 2) NULL DEFAULT NULL,
  `pajak` decimal(16, 2) NULL DEFAULT NULL,
  `biaya_lain` decimal(16, 2) NULL DEFAULT NULL,
  `potongan` decimal(16, 2) NULL DEFAULT NULL,
  `net_total_sales` decimal(16, 2) NULL DEFAULT NULL,
  `total_bayar` decimal(16, 2) NULL DEFAULT NULL,
  `total_kembali` decimal(16, 2) NULL DEFAULT NULL,
  `sisa_bayar` decimal(16, 2) NULL DEFAULT NULL,
  `no_pemesan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_pemesan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_pemesan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_pemesan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `membership` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kirim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kirim` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kirim` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kirim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kurir` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kurir` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_cs` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kasir` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_sales` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `worker` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waktu_bayar` datetime NULL DEFAULT NULL,
  `kassa` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_jatuhtempo` date NULL DEFAULT NULL,
  `tgl_deadline` date NULL DEFAULT NULL,
  `no_estimasi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tgl_Modified` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_Transaksi`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pesanan_temp
-- ----------------------------

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `Kode_Produk` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nama_Produk` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Kategori` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Satuan` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga_beli` int(16) NOT NULL,
  `isdimensi` tinyint(1) NULL DEFAULT NULL,
  `distock` tinyint(1) NULL DEFAULT NULL,
  `dijual` tinyint(1) NULL DEFAULT NULL,
  `dibeli` tinyint(1) NULL DEFAULT NULL,
  `isopen` tinyint(1) NULL DEFAULT NULL,
  `click` int(10) UNSIGNED NULL DEFAULT NULL,
  `hargaclick` int(16) NULL DEFAULT NULL,
  `ModifiedBY` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tgl_Modified` datetime NULL DEFAULT NULL,
  INDEX `produk_index`(`Kode_Produk`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES ('SUB Lanyard', 'Tali Lanyard ID Printing', 'SUBLIM', 'PCS', 8500, 0, 0, 0, 0, NULL, 0, 0, 'admin', '2021-07-26 22:57:10');
INSERT INTO `produk` VALUES ('LAM D A3', 'Laminasi Doff A3', 'FINISHING', 'PCS', 800, 0, 0, 1, 0, NULL, 0, 0, 'admin', '2021-07-26 22:53:31');
INSERT INTO `produk` VALUES ('OFF Brosur A5 1 Sisi 1000 Lbr', 'OFF Brosur A5 1 Sisi 1000 Lbr', 'OFFSET', 'PAKET', 150000, 0, 0, 1, 0, NULL, 0, 0, 'admin', '2021-07-26 22:54:36');
INSERT INTO `produk` VALUES ('OFF Brosur A5 2 sisi 1000 Lbr', 'OFF Brosur A5 2 sisi 1000 Lbr', 'OFFSET', 'PAKET', 250000, 0, 0, 0, 0, NULL, 0, 0, 'admin', '2021-07-26 22:55:44');
INSERT INTO `produk` VALUES ('LAM G A3', 'Laminasi Glossy A3', 'FINISHING', 'PCS', 800, 0, 0, 0, 0, NULL, 0, 0, 'admin', '2021-07-26 22:52:26');
INSERT INTO `produk` VALUES ('SUB Jersey Printing', 'Jersey Printing', 'SUBLIM', 'PCS', 65000, 0, 0, 1, 0, NULL, 0, 0, 'admin', '2021-07-26 22:51:23');
INSERT INTO `produk` VALUES ('DTF PET Meteran ', 'DTF PET Meteran 60x100', 'DTF', 'METER', 45000, 0, 0, 1, 0, NULL, 0, 0, 'admin', '2021-07-26 22:48:43');
INSERT INTO `produk` VALUES ('UV Tumbler', 'UV Tumbler', 'UV', 'PCS', 35000, 0, 0, 0, 0, NULL, 0, 0, 'admin', '2021-07-26 22:50:02');
INSERT INTO `produk` VALUES ('DSP X baner', 'DSP X baner', 'DISPLAY', 'PCS', 20000, 0, 1, 1, 1, NULL, 0, 0, 'admin', '2021-07-26 22:58:47');
INSERT INTO `produk` VALUES ('DSP Roll up 60x160', 'DSP Roll Up 60x160', 'DISPLAY', 'PCS', 100000, 0, 0, 1, 0, NULL, 0, 0, 'sabil', '2022-05-11 16:44:31');
INSERT INTO `produk` VALUES ('IND Albatroz', 'Albatroz Indoor', 'INDOOR', 'PCS', 15000, 0, 0, 0, 0, NULL, 0, 0, 'admin', '2021-07-26 22:40:18');
INSERT INTO `produk` VALUES ('IND STK Ritrama', 'Stiker Ritrama Indoor', 'INDOOR', 'PCS', 30000, 1, 0, 1, 0, NULL, 0, 0, 'admin', '2021-07-26 22:42:24');
INSERT INTO `produk` VALUES ('STK Vinyl A3+', 'Stiker Vinyl A3+', 'LASER A3+', 'LBR', 5000, 0, 0, 1, 0, NULL, 1, 1000, 'admin', '2021-07-26 22:37:50');
INSERT INTO `produk` VALUES ('STK Bontak', 'STK Bontak Chromo A3+', 'LASER A3+', 'LBR', 2500, 0, 0, 1, 0, NULL, 1, 1000, 'admin', '2021-07-26 22:56:06');
INSERT INTO `produk` VALUES ('AP150DS', 'Art Paper 150 Dua Sisi', 'LASER A3+', 'LBR', 2000, 0, 0, 1, 0, NULL, 2, 1000, 'admin', '2021-07-26 22:34:56');
INSERT INTO `produk` VALUES ('AP150SS', 'Art Paper 150 Satu Sisi', 'LASER A3+', 'LBR', 1500, 0, 0, 1, 0, NULL, 1, 1000, 'admin', '2021-07-26 22:31:58');
INSERT INTO `produk` VALUES ('BNR 280', 'Banner Frontlite 280', 'OUTDOOR', 'PCS', 10000, 1, 0, 1, 0, NULL, 0, 0, 'admin', '2021-07-26 13:01:32');
INSERT INTO `produk` VALUES ('Kaos', 'Kaos Polos', 'BAHAN', 'PCS', 50000, 0, 0, 1, 0, NULL, 0, 0, 'admin', '2021-07-26 22:29:55');
INSERT INTO `produk` VALUES ('BNR Korcin 440', 'BNR Korcin 440', 'OUTDOOR', 'PCS', 20000, 1, 0, 1, 0, NULL, 0, 0, 'admin', '2021-07-26 22:29:08');

-- ----------------------------
-- Table structure for produk_harga
-- ----------------------------
DROP TABLE IF EXISTS `produk_harga`;
CREATE TABLE `produk_harga`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Kode_Produk` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jenis_harga` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `min_pembelian` int(11) NOT NULL,
  `harga` decimal(16, 0) NOT NULL,
  `ModifiedBY` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tgl_Modified` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1791 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk_harga
-- ----------------------------
INSERT INTO `produk_harga` VALUES (1737, 'DSP X baner', 'MEMBER', 50, 30000, 'admin', '2021-07-26 22:58:46');
INSERT INTO `produk_harga` VALUES (1733, 'SUB Lanyard', 'MEMBER', 50, 8500, 'admin', '2021-07-26 22:57:09');
INSERT INTO `produk_harga` VALUES (1732, 'SUB Lanyard', 'MEMBER', 1, 10000, 'admin', '2021-07-26 22:57:03');
INSERT INTO `produk_harga` VALUES (1731, 'SUB Lanyard', 'UMUM', 50, 10000, 'admin', '2021-07-26 22:56:58');
INSERT INTO `produk_harga` VALUES (1730, 'SUB Lanyard', 'UMUM', 1, 15000, 'admin', '2021-07-26 22:56:50');
INSERT INTO `produk_harga` VALUES (1729, 'OFF Brosur A5 2 sisi 1000 Lbr', 'MEMBER', 1, 450000, 'admin', '2021-07-26 22:55:43');
INSERT INTO `produk_harga` VALUES (1728, 'OFF Brosur A5 2 sisi 1000 Lbr', 'UMUM', 1, 500000, 'admin', '2021-07-26 22:55:38');
INSERT INTO `produk_harga` VALUES (1727, 'OFF Brosur A5 1 Sisi 1000 Lbr', 'MEMBER', 1, 350000, 'admin', '2021-07-26 22:54:35');
INSERT INTO `produk_harga` VALUES (1726, 'OFF Brosur A5 1 Sisi 1000 Lbr', 'UMUM', 1, 375000, 'admin', '2021-07-26 22:54:29');
INSERT INTO `produk_harga` VALUES (1725, 'LAM D A3', 'MEMBER', 50, 2000, 'admin', '2021-07-26 22:53:29');
INSERT INTO `produk_harga` VALUES (1724, 'LAM D A3', 'MEMBER', 1, 2500, 'admin', '2021-07-26 22:53:22');
INSERT INTO `produk_harga` VALUES (1723, 'LAM D A3', 'UMUM', 50, 2500, 'admin', '2021-07-26 22:53:17');
INSERT INTO `produk_harga` VALUES (1722, 'LAM D A3', 'UMUM', 1, 3000, 'admin', '2021-07-26 22:53:12');
INSERT INTO `produk_harga` VALUES (1721, 'LAM G A3', 'MEMBER', 50, 2000, 'admin', '2021-07-26 22:52:24');
INSERT INTO `produk_harga` VALUES (1720, 'LAM G A3', 'MEMBER', 1, 2500, 'admin', '2021-07-26 22:52:19');
INSERT INTO `produk_harga` VALUES (1719, 'LAM G A3', 'UMUM', 10, 2500, 'admin', '2021-07-26 22:52:16');
INSERT INTO `produk_harga` VALUES (1718, 'LAM G A3', 'UMUM', 1, 3000, 'admin', '2021-07-26 22:52:11');
INSERT INTO `produk_harga` VALUES (1717, 'SUB Jersey Printing', 'MEMBER', 1, 80000, 'admin', '2021-07-26 22:50:51');
INSERT INTO `produk_harga` VALUES (1716, 'SUB Jersey Printing', 'UMUM', 1, 100000, 'admin', '2021-07-26 22:50:46');
INSERT INTO `produk_harga` VALUES (1715, 'UV Tumbler', 'MEMBER', 1, 75000, 'admin', '2021-07-26 22:50:01');
INSERT INTO `produk_harga` VALUES (1714, 'UV Tumbler', 'UMUM', 1, 100000, 'admin', '2021-07-26 22:49:53');
INSERT INTO `produk_harga` VALUES (1713, 'DTF PET Meteran ', 'MEMBER', 10, 90000, 'admin', '2021-07-26 22:48:40');
INSERT INTO `produk_harga` VALUES (1712, 'DTF PET Meteran ', 'MEMBER', 1, 100000, 'admin', '2021-07-26 22:48:35');
INSERT INTO `produk_harga` VALUES (1711, 'DTF PET Meteran ', 'UMUM', 10, 125000, 'admin', '2021-07-26 22:48:25');
INSERT INTO `produk_harga` VALUES (1710, 'DTF PET Meteran ', 'UMUM', 1, 135000, 'admin', '2021-07-26 22:48:15');
INSERT INTO `produk_harga` VALUES (1735, 'DSP X baner', 'UMUM', 50, 40000, 'admin', '2021-07-26 22:58:36');
INSERT INTO `produk_harga` VALUES (1736, 'DSP X baner', 'MEMBER', 1, 35000, 'admin', '2021-07-26 22:58:40');
INSERT INTO `produk_harga` VALUES (1734, 'DSP X baner', 'UMUM', 1, 50000, 'admin', '2021-07-26 22:58:27');
INSERT INTO `produk_harga` VALUES (1785, 'DSP Roll up 60x160', 'MEMBER', 1, 150000, 'sabil', '2022-05-11 16:44:31');
INSERT INTO `produk_harga` VALUES (1786, 'DSP Roll up 60x160', 'MEMBER', 50, 145000, 'sabil', '2022-05-11 16:44:31');
INSERT INTO `produk_harga` VALUES (1784, 'DSP Roll up 60x160', 'UMUM', 50, 150000, 'sabil', '2022-05-11 16:44:31');
INSERT INTO `produk_harga` VALUES (1783, 'DSP Roll up 60x160', 'UMUM', 1, 160000, 'sabil', '2022-05-11 16:44:31');
INSERT INTO `produk_harga` VALUES (1702, 'IND STK Ritrama', 'MEMBER', 50, 40000, 'admin', '2021-07-26 22:42:18');
INSERT INTO `produk_harga` VALUES (1701, 'IND STK Ritrama', 'MEMBER', 1, 55000, 'admin', '2021-07-26 22:42:09');
INSERT INTO `produk_harga` VALUES (1700, 'IND STK Ritrama', 'UMUM', 50, 60000, 'admin', '2021-07-26 22:41:51');
INSERT INTO `produk_harga` VALUES (1699, 'IND STK Ritrama', 'UMUM', 1, 65000, 'admin', '2021-07-26 22:41:43');
INSERT INTO `produk_harga` VALUES (1698, 'IND Albatroz', 'MEMBER', 1, 65000, 'admin', '2021-07-26 22:40:17');
INSERT INTO `produk_harga` VALUES (1697, 'IND Albatroz', 'UMUM', 1, 75000, 'admin', '2021-07-26 22:40:11');
INSERT INTO `produk_harga` VALUES (1696, 'STK Vinyl A3+', 'MEMBER', 50, 7500, 'admin', '2021-07-26 22:37:46');
INSERT INTO `produk_harga` VALUES (1695, 'STK Vinyl A3+', 'MEMBER', 1, 8000, 'admin', '2021-07-26 22:37:39');
INSERT INTO `produk_harga` VALUES (1694, 'STK Vinyl A3+', 'UMUM', 50, 9500, 'admin', '2021-07-26 22:37:29');
INSERT INTO `produk_harga` VALUES (1693, 'STK Vinyl A3+', 'UMUM', 1, 10000, 'admin', '2021-07-26 22:37:25');
INSERT INTO `produk_harga` VALUES (1692, 'STK Bontak', 'MEMBER', 50, 4000, 'admin', '2021-07-26 22:36:21');
INSERT INTO `produk_harga` VALUES (1691, 'STK Bontak', 'MEMBER', 1, 4500, 'admin', '2021-07-26 22:36:16');
INSERT INTO `produk_harga` VALUES (1690, 'STK Bontak', 'UMUM', 50, 4500, 'admin', '2021-07-26 22:36:06');
INSERT INTO `produk_harga` VALUES (1689, 'STK Bontak', 'UMUM', 1, 5000, 'admin', '2021-07-26 22:36:01');
INSERT INTO `produk_harga` VALUES (1685, 'AP150DS', 'UMUM', 50, 5500, 'admin', '2021-07-26 22:34:25');
INSERT INTO `produk_harga` VALUES (1684, 'AP150DS', 'UMUM', 1, 6000, 'admin', '2021-07-26 22:34:20');
INSERT INTO `produk_harga` VALUES (1687, 'AP150DS', 'MEMBER', 1, 5000, 'admin', '2021-07-26 22:34:47');
INSERT INTO `produk_harga` VALUES (1688, 'AP150DS', 'MEMBER', 50, 4000, 'admin', '2021-07-26 22:34:55');
INSERT INTO `produk_harga` VALUES (1681, 'AP150SS', 'MEMBER', 50, 2000, 'admin', '2021-07-26 22:31:52');
INSERT INTO `produk_harga` VALUES (1680, 'AP150SS', 'MEMBER', 1, 2500, 'admin', '2021-07-26 22:31:45');
INSERT INTO `produk_harga` VALUES (1679, 'AP150SS', 'UMUM', 50, 3500, 'admin', '2021-07-26 22:31:32');
INSERT INTO `produk_harga` VALUES (1678, 'AP150SS', 'UMUM', 1, 4000, 'admin', '2021-07-26 22:31:26');
INSERT INTO `produk_harga` VALUES (1677, 'Kaos', 'MEMBER', 1, 75000, 'admin', '2021-07-26 22:29:54');
INSERT INTO `produk_harga` VALUES (1676, 'BNR Korcin 440', 'MEMBER', 5, 25000, 'admin', '2021-07-26 22:29:03');
INSERT INTO `produk_harga` VALUES (1675, 'BNR Korcin 440', 'MEMBER', 1, 30000, 'admin', '2021-07-26 22:28:56');
INSERT INTO `produk_harga` VALUES (1674, 'BNR Korcin 440', 'UMUM', 5, 30000, 'admin', '2021-07-26 22:28:48');
INSERT INTO `produk_harga` VALUES (1673, 'BNR Korcin 440', 'UMUM', 1, 35000, 'admin', '2021-07-26 22:28:43');
INSERT INTO `produk_harga` VALUES (1671, 'Kaos', 'UMUM', 1, 80000, 'admin', '2021-07-26 14:05:12');
INSERT INTO `produk_harga` VALUES (1670, 'BNR 280', 'MEMBER', 50, 12500, 'admin', '2021-07-26 13:01:31');
INSERT INTO `produk_harga` VALUES (1669, 'BNR 280', 'MEMBER', 1, 13000, 'admin', '2021-07-26 13:01:25');
INSERT INTO `produk_harga` VALUES (1668, 'BNR 280', 'UMUM', 3, 15000, 'admin', '2021-07-26 13:01:18');
INSERT INTO `produk_harga` VALUES (1667, 'BNR 280', 'UMUM', 1, 20000, 'admin', '2021-07-26 13:01:13');

-- ----------------------------
-- Table structure for produk_harga_khusus
-- ----------------------------
DROP TABLE IF EXISTS `produk_harga_khusus`;
CREATE TABLE `produk_harga_khusus`  (
  `kode_pelanggan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_pelanggan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `membership` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_produk` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `modifiedby` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk_harga_khusus
-- ----------------------------
INSERT INTO `produk_harga_khusus` VALUES ('C00003', 'udin', 'UMUM', 'AP150SS', '1000', 'admin');
INSERT INTO `produk_harga_khusus` VALUES ('C00002', 'samiran', 'MEMBER', 'Kaos', '35000', 'admin');

-- ----------------------------
-- Table structure for prosesproduksi
-- ----------------------------
DROP TABLE IF EXISTS `prosesproduksi`;
CREATE TABLE `prosesproduksi`  (
  `no_proses` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_itempesanan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_proses` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status_pesanan` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_proses` datetime NULL DEFAULT NULL,
  `Kode_Produk` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Nama_Produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p` decimal(16, 2) NULL DEFAULT NULL,
  `l` decimal(16, 2) NULL DEFAULT NULL,
  `qty_pesan` int(11) NULL DEFAULT NULL,
  `qty_produksi` int(11) NULL DEFAULT NULL,
  `qty_sisa` int(11) NULL DEFAULT NULL,
  `satuan` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `finishing` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `namafile` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pemroses` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `TglModified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`no_proses`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of prosesproduksi
-- ----------------------------

-- ----------------------------
-- Table structure for register
-- ----------------------------
DROP TABLE IF EXISTS `register`;
CREATE TABLE `register`  (
  `id_harddisk` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `license_key` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of register
-- ----------------------------

-- ----------------------------
-- Table structure for returbeli
-- ----------------------------
DROP TABLE IF EXISTS `returbeli`;
CREATE TABLE `returbeli`  (
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Status_Bayar` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Status_Transaksi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_qty` decimal(16, 0) NULL DEFAULT NULL,
  `total_item` decimal(16, 0) NULL DEFAULT NULL,
  `total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `pajak` decimal(16, 0) NULL DEFAULT NULL,
  `biaya_lain` decimal(16, 0) NULL DEFAULT NULL,
  `potongan` decimal(16, 0) NULL DEFAULT NULL,
  `net_total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `total_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `total_kembali` decimal(16, 0) NULL DEFAULT NULL,
  `sisa_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `no_supplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_supplier` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_supplier` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_supplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kurir` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kurir` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_cs` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kasir` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_sales` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waktu_bayar` datetime NULL DEFAULT NULL,
  `kassa` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Tgl_Modified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_Transaksi`) USING BTREE,
  INDEX `returbeli_index`(`No_Transaksi`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of returbeli
-- ----------------------------

-- ----------------------------
-- Table structure for satuanjual
-- ----------------------------
DROP TABLE IF EXISTS `satuanjual`;
CREATE TABLE `satuanjual`  (
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`nama`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of satuanjual
-- ----------------------------
INSERT INTO `satuanjual` VALUES ('BIJI');
INSERT INTO `satuanjual` VALUES ('KG');
INSERT INTO `satuanjual` VALUES ('LBR');
INSERT INTO `satuanjual` VALUES ('LITER');
INSERT INTO `satuanjual` VALUES ('METER');
INSERT INTO `satuanjual` VALUES ('PAKET');
INSERT INTO `satuanjual` VALUES ('PCS');
INSERT INTO `satuanjual` VALUES ('RIM');
INSERT INTO `satuanjual` VALUES ('ROLL');
INSERT INTO `satuanjual` VALUES ('YARD');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `kode` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `nama` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `telepon` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`kode`, `urut`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('S00001', 'PT ABC Suplier', 'Surabaya', '612812345678', 1);

-- ----------------------------
-- Table structure for tb_log
-- ----------------------------
DROP TABLE IF EXISTS `tb_log`;
CREATE TABLE `tb_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_log` datetime NULL DEFAULT NULL,
  `aktivitas` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `dokumen` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 30 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_log
-- ----------------------------

-- ----------------------------
-- Table structure for tbuser
-- ----------------------------
DROP TABLE IF EXISTS `tbuser`;
CREATE TABLE `tbuser`  (
  `Id_User` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nama_User` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Password` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NIK` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `m_perusahaan` int(11) NOT NULL DEFAULT 1,
  `m_jabatan` int(11) NOT NULL DEFAULT 1,
  `m_karyawan` int(11) NOT NULL DEFAULT 1,
  `m_golongan_obat` int(11) NOT NULL DEFAULT 1,
  `m_setup_database` int(11) NOT NULL DEFAULT 1,
  `m_pembelian` int(11) NOT NULL DEFAULT 1,
  `m_retur` int(11) NOT NULL DEFAULT 1,
  `m_penjualan_toko` int(11) NOT NULL DEFAULT 1,
  `m_penjualan_resep` int(11) NOT NULL DEFAULT 1,
  `m_refund` int(11) NOT NULL DEFAULT 1,
  `m_kas_keluar` int(11) NOT NULL DEFAULT 1,
  `m_bayar_hutang` int(11) NOT NULL DEFAULT 1,
  `m_bayar_piutang` int(11) NOT NULL DEFAULT 1,
  `m_mutasi_kas` int(11) NOT NULL DEFAULT 1,
  `m_penyesuaian_stok` int(11) NOT NULL DEFAULT 1,
  `m_absensi` int(11) NOT NULL DEFAULT 1,
  `m_master_obat` int(11) NOT NULL DEFAULT 1,
  `m_master_pelanggan` int(11) NOT NULL DEFAULT 1,
  `m_master_distributor` int(11) NOT NULL DEFAULT 1,
  `m_master_produsen` int(11) NOT NULL DEFAULT 1,
  `m_master_dokter` int(11) NOT NULL DEFAULT 1,
  `m_master_biaya` int(11) NOT NULL DEFAULT 1,
  `m_master_kas` int(11) NOT NULL DEFAULT 1,
  `m_import_master_obat` int(11) NOT NULL DEFAULT 1,
  `m_lap_kas` int(11) NOT NULL DEFAULT 1,
  `m_lap_kas_keluar` int(11) NOT NULL DEFAULT 1,
  `m_lap_saldo_stok` int(11) NOT NULL DEFAULT 1,
  `m_lap_over_stok` int(11) NOT NULL DEFAULT 1,
  `m_lap_out_stok` int(11) NOT NULL DEFAULT 1,
  `m_lap_penjualan_periode` int(11) NOT NULL DEFAULT 1,
  `m_lap_penjualan_barang` int(11) NOT NULL DEFAULT 1,
  `m_lap_refund` int(11) NOT NULL DEFAULT 1,
  `m_lap_pembelian_periode` int(11) NOT NULL DEFAULT 1,
  `m_lap_pembelian_barang` int(11) NOT NULL DEFAULT 1,
  `m_lap_retur_pembelian` int(11) NOT NULL DEFAULT 1,
  `m_lap_analisa_penjualan` int(11) NOT NULL DEFAULT 1,
  `m_lap_laba_rugi` int(11) NOT NULL DEFAULT 1,
  `m_lap_tampilkan_agen` int(11) NOT NULL DEFAULT 1,
  `m_ceklog_karyawan` int(11) NOT NULL DEFAULT 1,
  `m_lap_daftar_absensi` int(11) NOT NULL DEFAULT 1,
  `m_setup_user` int(11) NOT NULL DEFAULT 1,
  `m_grafik_penjualan` int(11) NOT NULL DEFAULT 0,
  `m_grafik_pembelian` int(11) NOT NULL DEFAULT 0,
  `m_grafik_laba_rugi` int(11) NOT NULL DEFAULT 0,
  `m_grafik_analisa` int(11) NOT NULL DEFAULT 0,
  `m_kas_masuk` int(11) NOT NULL DEFAULT 1,
  `m_akun` int(11) NOT NULL DEFAULT 1,
  `m_lap_kas_masuk` int(11) NOT NULL DEFAULT 1,
  `m_transfer_masuk` int(11) NOT NULL DEFAULT 1,
  `m_transfer_keluar` int(11) NOT NULL DEFAULT 1,
  `m_lap_pesan` int(11) NOT NULL DEFAULT 1,
  `m_lap_produksi` int(11) NOT NULL DEFAULT 1,
  `m_setoran_kas` int(11) NOT NULL DEFAULT 1,
  `m_permintaan_produksi` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id_User`) USING BTREE,
  UNIQUE INDEX `NIK`(`NIK`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbuser
-- ----------------------------

-- ----------------------------
-- Table structure for tbversion
-- ----------------------------
DROP TABLE IF EXISTS `tbversion`;
CREATE TABLE `tbversion`  (
  `id` int(11) NOT NULL,
  `version` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `info` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbversion
-- ----------------------------
INSERT INTO `tbversion` VALUES (1, '2.1.1', 'Aktivitas Log');

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tanggal_Transaksi` timestamp NULL DEFAULT NULL,
  `Status_Bayar` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Status_Transaksi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_qty` decimal(16, 0) NULL DEFAULT NULL,
  `total_item` decimal(16, 0) NULL DEFAULT NULL,
  `total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `pajak` decimal(16, 0) NULL DEFAULT NULL,
  `biaya_lain` decimal(16, 0) NULL DEFAULT NULL,
  `potongan` decimal(16, 0) NULL DEFAULT NULL,
  `net_total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `total_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `total_kembali` decimal(16, 0) NULL DEFAULT NULL,
  `sisa_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `hpp` decimal(16, 0) NOT NULL,
  `no_pemesan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_pemesan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_pemesan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_pemesan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `membership` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kirim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kirim` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kirim` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kirim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kurir` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kurir` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_cs` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kasir` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_sales` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `worker` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waktu_bayar` datetime NULL DEFAULT NULL,
  `kassa` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_jatuhtempo` date NULL DEFAULT NULL,
  `tgl_deadline` date NULL DEFAULT NULL,
  `no_estimasi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tgl_Modified` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_Transaksi`) USING BTREE,
  INDEX `transaksi_index`(`Tanggal_Transaksi`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES ('JL00001', '2022-12-27 11:38:30', 'Lunas', 'Belum Diproses', 1, 1, 40000, 0, 0, 0, 40000, 50000, 10000, 0, 0, 'UMUM', 'test bayr', '', '62', 'UMUM', 'UMUM', 'test bayr', '', '62', '', '', '', '', '', 'admin', 'admin', '', 'admin', NULL, NULL, '2022-12-27', '2022-12-27', '', '2022-12-27 11:38:30', 'admin');

-- ----------------------------
-- Table structure for transaksi_spesial
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_spesial`;
CREATE TABLE `transaksi_spesial`  (
  `No_Transaksi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tanggal_Transaksi` datetime NULL DEFAULT NULL,
  `Status_Bayar` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Status_Transaksi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_qty` decimal(16, 0) NULL DEFAULT NULL,
  `total_item` decimal(16, 0) NULL DEFAULT NULL,
  `total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `pajak` decimal(16, 0) NULL DEFAULT NULL,
  `biaya_lain` decimal(16, 0) NULL DEFAULT NULL,
  `potongan` decimal(16, 0) NULL DEFAULT NULL,
  `net_total_sales` decimal(16, 0) NULL DEFAULT NULL,
  `total_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `total_kembali` decimal(16, 0) NULL DEFAULT NULL,
  `sisa_bayar` decimal(16, 0) NULL DEFAULT NULL,
  `no_pemesan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_pemesan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_pemesan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_pemesan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `membership` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kirim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kirim` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kirim` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kirim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kurir` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_kurir` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon_kurir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_cs` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_kasir` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_sales` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `worker` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waktu_bayar` datetime NULL DEFAULT NULL,
  `kassa` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_jatuhtempo` datetime NULL DEFAULT NULL,
  `tgl_deadline` datetime NULL DEFAULT NULL,
  `no_estimasi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Tgl_Modified` datetime NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`No_Transaksi`) USING BTREE,
  INDEX `transaksi_spesial`(`No_Transaksi`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi_spesial
-- ----------------------------

-- ----------------------------
-- View structure for beban_usaha_view
-- ----------------------------
DROP VIEW IF EXISTS `beban_usaha_view`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `beban_usaha_view` AS select month(`j`.`Tanggal`) AS `bulan`,year(`j`.`Tanggal`) AS `tahun`,`m`.`nama` AS `beban`,`j`.`debet` AS `nominal` from (`jurnal_d` `j` join `m_akun` `m` on((`j`.`kode` = `m`.`kode`))) where (`m`.`no_grup` = 6) ;

-- ----------------------------
-- View structure for itemtransaksi_gabung
-- ----------------------------
DROP VIEW IF EXISTS `itemtransaksi_gabung`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `itemtransaksi_gabung` AS select `itemtransaksi`.`No_ItemTransaksi` AS `No_ItemTransaksi`,`itemtransaksi`.`No_Transaksi` AS `No_Transaksi`,`itemtransaksi`.`Tanggal_Transaksi` AS `Tanggal_Transaksi`,`itemtransaksi`.`Kode_Produk` AS `Kode_Produk`,`itemtransaksi`.`Nama_Produk` AS `Nama_Produk`,`itemtransaksi`.`p` AS `p`,`itemtransaksi`.`l` AS `l`,`itemtransaksi`.`Qty` AS `Qty`,`itemtransaksi`.`satuan` AS `satuan`,`itemtransaksi`.`cost` AS `cost`,`itemtransaksi`.`sales` AS `sales`,`itemtransaksi`.`subtotal_sales` AS `subtotal_sales`,`itemtransaksi`.`finishing` AS `finishing`,`itemtransaksi`.`namafile` AS `namafile`,`itemtransaksi`.`keterangan` AS `keterangan`,`itemtransaksi`.`isdimensi` AS `isdimensi`,`itemtransaksi`.`distock` AS `distock`,`itemtransaksi`.`isopen` AS `isopen`,`itemtransaksi`.`TglModified` AS `TglModified`,`itemtransaksi`.`ModifiedBy` AS `ModifiedBy` from `itemtransaksi` union select `itemtransaksi_spesial`.`No_ItemTransaksi` AS `No_ItemTransaksi`,`itemtransaksi_spesial`.`No_Transaksi` AS `No_Transaksi`,`itemtransaksi_spesial`.`Tanggal_Transaksi` AS `Tanggal_Transaksi`,`itemtransaksi_spesial`.`Kode_Produk` AS `Kode_Produk`,`itemtransaksi_spesial`.`Nama_Produk` AS `Nama_Produk`,`itemtransaksi_spesial`.`p` AS `p`,`itemtransaksi_spesial`.`l` AS `l`,`itemtransaksi_spesial`.`Qty` AS `Qty`,`itemtransaksi_spesial`.`satuan` AS `satuan`,`itemtransaksi_spesial`.`cost` AS `cost`,`itemtransaksi_spesial`.`sales` AS `sales`,`itemtransaksi_spesial`.`subtotal_sales` AS `subtotal_sales`,`itemtransaksi_spesial`.`finishing` AS `finishing`,`itemtransaksi_spesial`.`namafile` AS `namafile`,`itemtransaksi_spesial`.`keterangan` AS `keterangan`,`itemtransaksi_spesial`.`isdimensi` AS `isdimensi`,`itemtransaksi_spesial`.`distock` AS `distock`,`itemtransaksi_spesial`.`isopen` AS `isopen`,`itemtransaksi_spesial`.`TglModified` AS `TglModified`,`itemtransaksi_spesial`.`ModifiedBy` AS `ModifiedBy` from `itemtransaksi_spesial` ;

-- ----------------------------
-- View structure for lappesanbarang
-- ----------------------------
DROP VIEW IF EXISTS `lappesanbarang`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `lappesanbarang` AS select `b`.`No_Transaksi` AS `no_transaksi`,`b`.`Tanggal_Transaksi` AS `tanggal_transaksi`,`b`.`Kode_Produk` AS `kode_produk`,`b`.`Nama_Produk` AS `nama_produk`,`a`.`Kategori` AS `kategori`,if((`b`.`p` = 0),0,`b`.`p`) AS `p`,if((`b`.`l` = 0),0,`b`.`l`) AS `l`,`b`.`Qty` AS `qty`,((if((`b`.`p` = 0),1,`b`.`p`) * if((`b`.`l` = 0),1,`b`.`l`)) * `b`.`Qty`) AS `vol`,(`b`.`cost` * `b`.`Qty`) AS `Totalcost`,`b`.`subtotal_sales` AS `TotalSales`,(`a`.`click` * `b`.`Qty`) AS `JumlahKlik`,((`a`.`click` * `a`.`hargaclick`) * `b`.`Qty`) AS `HargaKlik`,`a`.`isdimensi` AS `isdimensi`,`b`.`ModifiedBy` AS `cs` from ((`itemtransaksi` `b` left join `produk` `a` on((`a`.`Kode_Produk` = `b`.`Kode_Produk`))) left join `transaksi` `c` on((`b`.`No_Transaksi` = `c`.`No_Transaksi`))) order by `b`.`No_Transaksi`,`b`.`Nama_Produk` ;

-- ----------------------------
-- View structure for stock
-- ----------------------------
DROP VIEW IF EXISTS `stock`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `stock` AS select `p`.`Kode_Produk` AS `kode`,`p`.`Nama_Produk` AS `nama`,`p`.`Kategori` AS `kategori`,`p`.`harga_beli` AS `harga_beli`,ifnull(`l`.`Laststock`,0) AS `sisa`,`p`.`Satuan` AS `satuan`,ifnull((`p`.`harga_beli` * `l`.`Laststock`),0) AS `ttl` from (`produk` `p` left join `laststock` `l` on((`p`.`Kode_Produk` = `l`.`Kode_produk`))) group by `p`.`Kode_Produk` ;

-- ----------------------------
-- View structure for total_item
-- ----------------------------
DROP VIEW IF EXISTS `total_item`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `total_item` AS select `p`.`Kategori` AS `kategori`,sum(`i`.`Qty`) AS `qty` from (`itemtransaksi` `i` join `produk` `p` on((`i`.`Kode_Produk` = `p`.`Kode_Produk`))) group by `p`.`Kategori` ;

-- ----------------------------
-- View structure for transaksi_gabung
-- ----------------------------
DROP VIEW IF EXISTS `transaksi_gabung`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `transaksi_gabung` AS select `transaksi`.`No_Transaksi` AS `No_Transaksi`,`transaksi`.`Tanggal_Transaksi` AS `Tanggal_Transaksi`,`transaksi`.`Status_Bayar` AS `Status_Bayar`,`transaksi`.`Status_Transaksi` AS `Status_Transaksi`,`transaksi`.`total_qty` AS `total_qty`,`transaksi`.`total_item` AS `total_item`,`transaksi`.`total_sales` AS `total_sales`,`transaksi`.`pajak` AS `pajak`,`transaksi`.`biaya_lain` AS `biaya_lain`,`transaksi`.`potongan` AS `potongan`,`transaksi`.`net_total_sales` AS `net_total_sales`,`transaksi`.`total_bayar` AS `total_bayar`,`transaksi`.`total_kembali` AS `total_kembali`,`transaksi`.`sisa_bayar` AS `sisa_bayar`,`transaksi`.`no_pemesan` AS `no_pemesan`,`transaksi`.`nama_pemesan` AS `nama_pemesan`,`transaksi`.`alamat_pemesan` AS `alamat_pemesan`,`transaksi`.`telepon_pemesan` AS `telepon_pemesan`,`transaksi`.`membership` AS `membership`,`transaksi`.`no_kirim` AS `no_kirim`,`transaksi`.`nama_kirim` AS `nama_kirim`,`transaksi`.`alamat_kirim` AS `alamat_kirim`,`transaksi`.`telepon_kirim` AS `telepon_kirim`,`transaksi`.`no_kurir` AS `no_kurir`,`transaksi`.`nama_kurir` AS `nama_kurir`,`transaksi`.`alamat_kurir` AS `alamat_kurir`,`transaksi`.`telepon_kurir` AS `telepon_kurir`,`transaksi`.`keterangan` AS `keterangan`,`transaksi`.`nama_cs` AS `nama_cs`,`transaksi`.`nama_kasir` AS `nama_kasir`,`transaksi`.`nama_sales` AS `nama_sales`,`transaksi`.`worker` AS `worker`,`transaksi`.`waktu_bayar` AS `waktu_bayar`,`transaksi`.`kassa` AS `kassa`,`transaksi`.`tgl_jatuhtempo` AS `tgl_jatuhtempo`,`transaksi`.`tgl_deadline` AS `tgl_deadline`,`transaksi`.`no_estimasi` AS `no_estimasi`,`transaksi`.`Tgl_Modified` AS `Tgl_Modified`,`transaksi`.`ModifiedBy` AS `ModifiedBy` from `transaksi` union select `transaksi_spesial`.`No_Transaksi` AS `No_Transaksi`,`transaksi_spesial`.`Tanggal_Transaksi` AS `Tanggal_Transaksi`,`transaksi_spesial`.`Status_Bayar` AS `Status_Bayar`,`transaksi_spesial`.`Status_Transaksi` AS `Status_Transaksi`,`transaksi_spesial`.`total_qty` AS `total_qty`,`transaksi_spesial`.`total_item` AS `total_item`,`transaksi_spesial`.`total_sales` AS `total_sales`,`transaksi_spesial`.`pajak` AS `pajak`,`transaksi_spesial`.`biaya_lain` AS `biaya_lain`,`transaksi_spesial`.`potongan` AS `potongan`,`transaksi_spesial`.`net_total_sales` AS `net_total_sales`,`transaksi_spesial`.`total_bayar` AS `total_bayar`,`transaksi_spesial`.`total_kembali` AS `total_kembali`,`transaksi_spesial`.`sisa_bayar` AS `sisa_bayar`,`transaksi_spesial`.`no_pemesan` AS `no_pemesan`,`transaksi_spesial`.`nama_pemesan` AS `nama_pemesan`,`transaksi_spesial`.`alamat_pemesan` AS `alamat_pemesan`,`transaksi_spesial`.`telepon_pemesan` AS `telepon_pemesan`,`transaksi_spesial`.`membership` AS `membership`,`transaksi_spesial`.`no_kirim` AS `no_kirim`,`transaksi_spesial`.`nama_kirim` AS `nama_kirim`,`transaksi_spesial`.`alamat_kirim` AS `alamat_kirim`,`transaksi_spesial`.`telepon_kirim` AS `telepon_kirim`,`transaksi_spesial`.`no_kurir` AS `no_kurir`,`transaksi_spesial`.`nama_kurir` AS `nama_kurir`,`transaksi_spesial`.`alamat_kurir` AS `alamat_kurir`,`transaksi_spesial`.`telepon_kurir` AS `telepon_kurir`,`transaksi_spesial`.`keterangan` AS `keterangan`,`transaksi_spesial`.`nama_cs` AS `nama_cs`,`transaksi_spesial`.`nama_kasir` AS `nama_kasir`,`transaksi_spesial`.`nama_sales` AS `nama_sales`,`transaksi_spesial`.`worker` AS `worker`,`transaksi_spesial`.`waktu_bayar` AS `waktu_bayar`,`transaksi_spesial`.`kassa` AS `kassa`,`transaksi_spesial`.`tgl_jatuhtempo` AS `tgl_jatuhtempo`,`transaksi_spesial`.`tgl_deadline` AS `tgl_deadline`,`transaksi_spesial`.`no_estimasi` AS `no_estimasi`,`transaksi_spesial`.`Tgl_Modified` AS `Tgl_Modified`,`transaksi_spesial`.`ModifiedBy` AS `ModifiedBy` from `transaksi_spesial` ;

SET FOREIGN_KEY_CHECKS = 1;
