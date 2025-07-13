-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Host: localhost:3306
-- Generation Time: Jul 05, 2025 at 09:10 AM
-- Server version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS cutfill_db;
USE cutfill_db;

CREATE TABLE `bbm_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `vehicle_id` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bbm_liter` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `vehicle_id` (`vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bbm_logs` (`id`, `user_id`, `vehicle_id`, `date`, `bbm_liter`) VALUES
(1, 4, 2, '2025-07-02', 45),
(2, 4, 1, '2025-07-02', 30);

CREATE TABLE `ritase_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `vehicle_id` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `rit_count` int DEFAULT NULL,
  `weather_condition` varchar(50) DEFAULT NULL,
  `bucket_volume` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `vehicle_id` (`vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ritase_logs` VALUES
(1, 3, 1, '2025-07-02', 5, 'Cerah', 1.2),
(2, 3, 2, '2025-07-02', 7, 'Berawan', 2.5),
(3, 3, 2, '2025-07-01', 2, 'Cerah', 4.6);

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('direktur','admin','user1','user2') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` VALUES
(1, 'Direktur Utama', 'direktur@example.com', '12345', 'direktur'),
(2, 'Admin Proyek', 'admin@example.com', '12345', 'admin'),
(3, 'Pelaksana Lapangan', 'user1@example.com', '12345', 'user1'),
(4, 'Logistik BBM', 'user2@example.com', '12345', 'user2');

CREATE TABLE `vehicles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `operator_name` varchar(100) NOT NULL,
  `vehicle_type` varchar(100) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `bucket_capacity` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `vehicles` VALUES
(1, 'Budi Santoso', 'Excavator', 'B 1234 XY', 1.2, '2025-07-01 19:05:00'),
(2, 'Agus Salim', 'Dump Truck', 'D 4567 ZT', 2.5, '2025-07-01 19:05:00'),
(3, 'aafei', 'excavator', 'AB123CD', 4.5, '2025-07-01 19:45:24');

-- Constraints
ALTER TABLE `bbm_logs`
  ADD CONSTRAINT `bbm_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bbm_logs_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

ALTER TABLE `ritase_logs`
  ADD CONSTRAINT `ritase_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ritase_logs_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

COMMIT;
