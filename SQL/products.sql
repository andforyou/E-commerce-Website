-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2024 at 01:35 PM
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
-- Database: `Mystore`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(100) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keywords`, `category_id`, `sub_category_id`, `product_image`, `product_price`, `status`, `stock`) VALUES
(1, 'Banana Milk', '350ml', 'banana milk,milk,healthy', 1, 11, 'beverageBananaMilk.png', '6', 'true', 2),
(2, 'Coca', '500ml', 'coca,fun', 1, 12, 'beverageCoca.png', '3', 'true', 2),
(3, 'Coconut Water', '350ml', 'coconut water,water,coconut,healthy', 1, 11, 'beverageCocowater.png', '7', 'true', 2),
(4, 'Juice', '350ml', 'juice,orange juice,healthy', 1, 11, 'beverageJuice.png', '5', 'true', 2),
(5, 'Milk', '1L', 'milk,healthy', 1, 11, 'beverageMilk.png', '3', 'true', 2),
(6, 'Peach Tea', '500ml', 'peach tea;tea', 1, 12, 'beveragePeachtea.png', '4', 'true', 0),
(7, 'Water', '500ml', 'water', 1, 11, 'beverageWater.png', '2', 'true', 2),
(8, 'Apple', '1kg', 'apple,fruit', 2, 21, 'freshApple.png', '5', 'true', 2),
(9, 'Banana', '1kg', 'banana,fruit', 2, 21, 'freshBanana.png', '4', 'true', 2),
(10, 'Orange', '1kg', 'orange,fruit', 2, 21, 'freshOrange.png', '3', 'true', 2),
(11, 'Lemmon', '1kg', 'lemmon,fruit', 2, 21, 'freshLemmon.png', '3', 'true', 2),
(12, 'Onion', '1kg', 'oninon,vege,vegetable', 2, 22, 'freshOnion.png', '4', 'true', 2),
(13, 'Potato', '1kg', 'potato,vege,vegetable', 2, 22, 'freshPotato.png', '3', 'true', 2),
(14, 'Cabbage', '1kg', 'cabbage,vege,vegetable', 2, 22, 'freshCabbage.png', '6', 'true', 2),
(15, 'Chips', '750g', 'chips,chip,frozen', 3, 32, 'frozenChip.png', '12', 'true', 2),
(16, 'Dumplings', '800g', 'dumplings,dumpling', 3, 31, 'frozenDumpling.png', '15', 'true', 2),
(17, 'Ice Cream Large', '500g', 'ice cream,frozen', 3, 32, 'frozenIcecream1.png', '12', 'true', 2),
(18, 'Ice Cream Small', '300g', 'ice cream,frozen', 3, 32, 'frozenIcecream2.png', '7', 'true', 2),
(19, 'Pizza', '1kg', 'pizza,frozen,fun', 3, 32, 'frozenPizza.png', '16', 'true', 2),
(20, 'Vegetable', '1kg', 'vegetable,vege,frozen,healthy', 3, 31, 'frozenVegatable.png', '6', 'true', 2),
(21, 'Wings', '700g', 'wings,chicken,frozen,fun', 3, 32, 'frozenWing.png', '10', 'true', 0),
(22, 'Candle', 'per 1ea', 'candle,bedroom,home', 4, 42, 'livingCandle.png', '15', 'true', 2),
(23, 'Mirror', 'per 1ea', 'mirror,bedroom,home', 4, 42, 'livingMirror.png', '18', 'true', 2),
(24, 'Pillow', 'per 1ea', 'pillow,bedroom,home', 4, 42, 'livingPillow.png', '10', 'true', 2),
(25, 'Plant Small', 'per 1ea', 'plant,living,home', 4, 41, 'livingPlant1.png', '12', 'true', 0),
(26, 'Plant Large', 'per 1ea', 'plant,living,home', 4, 41, 'livingPlant2.png', '15', 'true', 2),
(27, 'Vase White', 'per 1ea', 'vase,living,home', 4, 41, 'livingVase1.png', '14', 'true', 2),
(28, 'Vase Blue', 'per 1ea', 'vase,living,home', 4, 41, 'livingVase2.png', '16', 'true', 2),
(30, 'Dog Treats', '400g', 'dog,treat,pet,dog food', 5, 51, 'petFoodDogTreat.png', '5', 'true', 2),
(31, 'Dog Food', '1kg', 'dog,pet,dog food', 5, 51, 'petFoodDogFood.png', '8', 'true', 2),
(32, 'Dog Food Can', '300g', 'dog,can,pet,dog food', 5, 51, 'petFoodDogCan.png', '7', 'true', 2),
(33, 'Cat Food Can', '300g', 'cat,can,pet,cat food', 5, 52, 'petFoodCatCan.png', '7', 'true', 2),
(34, 'Cat Food', '1kg', 'cat,pet,cat food', 5, 52, 'petFoodCatFood.png', '8', 'true', 2),
(35, 'Fish Food', '500g', 'fish,pet,fish food', 5, 52, 'petFoodFishFood.png', '6', 'true', 2),
(36, 'Bird Food', '400g', 'bird,pet,bird food', 5, 52, 'petFoodBirdFood.png', '6', 'true', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
