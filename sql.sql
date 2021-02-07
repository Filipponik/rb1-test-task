SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `clicks` (
  `id` int NOT NULL,
  `x` int NOT NULL,
  `y` int NOT NULL,
  `timestamp` bigint UNSIGNED NOT NULL,
  `sitepage_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `clicks` (`id`, `x`, `y`, `timestamp`, `sitepage_id`) VALUES
(6, 597, 130, 1612700954, 8),
(7, 530, 135, 1612701006, 8);


CREATE TABLE `sitepage` (
  `id` int NOT NULL,
  `url` text NOT NULL,
  `site_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `sitepage` (`id`, `url`, `site_id`) VALUES
(7, '/index2.html', 3),
(8, '/client_page.html', 3);


CREATE TABLE `sites` (
  `id` int NOT NULL,
  `url` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `sites` (`id`, `url`) VALUES
(3, 'filipponik.tk');

ALTER TABLE `clicks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sitepage_id` (`sitepage_id`);

ALTER TABLE `sitepage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `site_id` (`site_id`);

ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `clicks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `sitepage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `sites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `clicks`
  ADD CONSTRAINT `clicks_ibfk_1` FOREIGN KEY (`sitepage_id`) REFERENCES `sitepage` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `sitepage`
  ADD CONSTRAINT `sitepage_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;