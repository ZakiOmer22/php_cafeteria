-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table cafeteria_db.customers: ~5 rows (approximately)
REPLACE INTO `customers` (`id`, `name`, `phone`, `email`) VALUES
	(1, 'Alice Johnson', '555-123-4567', 'alice.johnson@example.com'),
	(2, 'Bob Smith', '555-987-6543', 'bob.smith@example.com'),
	(3, 'Charlie Davis', '555-234-5678', 'charlie.davis@example.com'),
	(4, 'Diana Evans', '555-876-5432', 'diana.evans@example.com'),
	(5, 'Ethan Brown', '555-345-6789', 'ethan.brown@example.com');

-- Dumping data for table cafeteria_db.menu: ~9 rows (approximately)
REPLACE INTO `menu` (`id`, `name`, `price`, `available`) VALUES
	(1, 'Classic Cheeseburger', 5.99, 1),
	(2, 'Veggie Wrap', 4.50, 1),
	(3, 'Grilled Chicken Salad', 6.75, 1),
	(4, 'French Fries', 2.25, 1),
	(5, 'Fresh Lemonade', 1.50, 1),
	(6, 'Chocolate Milkshake', 3.00, 0),
	(7, 'Caesar Salad', 5.25, 1),
	(8, 'Turkey Sandwich', 5.50, 0),
	(9, 'Tomato Soup', 3.75, 1);

-- Dumping data for table cafeteria_db.orders: ~4 rows (approximately)
REPLACE INTO `orders` (`id`, `customer`, `total`, `order_time`) VALUES
	(4, 'Alice Johnson', 25.50, '2025-06-23 20:13:52'),
	(5, 'Bob Smith', 13.75, '2025-06-23 20:13:52'),
	(6, 'Charlie Davis', 40.00, '2025-06-23 20:13:52'),
	(8, 'Arafat Osman Aden', 8.99, '2025-06-23 22:16:48');

-- Dumping data for table cafeteria_db.order_items: ~3 rows (approximately)
REPLACE INTO `order_items` (`id`, `order_id`, `menu_id`, `qty`, `price`) VALUES
	(13, 6, 5, 1, 12.00),
	(14, 4, 6, 1, 12.00),
	(15, 8, 4, 1, 2.99);

-- Dumping data for table cafeteria_db.users: ~1 rows (approximately)
REPLACE INTO `users` (`id`, `username`, `password`, `role`, `profile_pic`) VALUES
	(4, 'ZakiOmer22', '$2y$10$znCRaVm9WhCsF89fGd7HWuWiowlqWnBeVBdlSuzdTu3aQ5.z5dH56', 'Admin', 'cafeteria-system/uploads/profile_pics/profile_4_1750716854.jpg');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
