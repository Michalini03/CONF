

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `acess_rights` (
  `id` int NOT NULL,
  `acess_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `acess_rights`
--

INSERT INTO `acess_rights` (`id`, `acess_title`) VALUES
(3, 'Admin'),
(1, 'Author'),
(2, 'Reviewer'),
(4, 'Superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `file_name` varchar(255) NOT NULL,
  `author_id` int NOT NULL,
  `last_edited` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `state` int DEFAULT '1',
  `reviewer_id` int DEFAULT NULL,
  `review` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `description`, `file_name`, `author_id`, `last_edited`, `state`, `reviewer_id`, `review`) VALUES
(8, 'fdsa', 'fdasfasdf', '692eecc6bfb0d_ZOSopak2025.pdf', 1, '2025-12-02 13:42:30', 4, 4, 'SUper'),
(10, 'Ahojda', 'Zkusebka', '692f36d61b742_PozadavkyUPS-1.pdf', 1, '2025-12-02 18:58:30', 4, 1, 'Supr cupr'),
(11, 'Testing full stopage', 'Lorem ipsum skrupum budum tsuki puki Lorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki puki Lorem ipsum skrupum budum tsuki puki Lorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki puki Lorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki puki Lorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki pukiLorem ipsum skrupum budum tsuki puki', '692f3e76736d0_zos-kompletni-vypisky.pdf', 5, '2025-12-02 19:31:02', 4, 6, 'Supr ZOS poznamky'),
(12, 'Test1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer consequat lacus sed felis fringilla semper. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Aliquam ut maximus urna, a finibus ante. Etiam tempor condimentum hendrerit. Donec libero turpis, pharetra volutpat cursus eget, auctor vitae lorem. Nulla a imperdiet ligula, id sodales nibh. Nunc egestas posuere consectetur. Maecenas quis varius enim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer lectus eros, dapibus nec aliquet vel, laoreet id massa. Phasellus risus libero, consequat ut ante vel, euismod mattis nisi.\r\n\r\nAliquam erat volutpat. Praesent eget egestas nulla. Nam id sem elementum, lobortis odio et, blandit sapien. Quisque vestibulum, nunc quis tristique malesuada, ante elit ornare sapien, eget cursus leo odio ac ligula. Nulla facilisi. Suspendisse scelerisque gravida volutpat. Phasellus fermentum mattis hendrerit. Donec convallis sapien tortor, ut euismod ipsum commodo sed. In hac habitasse platea dictumst. Nam convallis orci pulvinar mollis auctor. Phasellus ipsum sem, dapibus eget justo a, placerat posuere mauris. Aliquam dictum dui sed orci aliquam, id congue orci finibus. In facilisis fringilla facilisis.', '692f40e3bcfb6_PRO_2.pdf', 5, '2025-12-02 19:41:23', 4, 1, 'OK'),
(13, 'TEST2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer consequat lacus sed felis fringilla semper. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Aliquam ut maximus urna, a finibus ante. Etiam tempor condimentum hendrerit. Donec libero turpis, pharetra volutpat cursus eget, auctor vitae lorem. Nulla a imperdiet ligula, id sodales nibh. Nunc egestas posuere consectetur. Maecenas quis varius enim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer lectus eros, dapibus nec aliquet vel, laoreet id massa. Phasellus risus libero, consequat ut ante vel, euismod mattis nisi.\r\n\r\nAliquam erat volutpat. Praesent eget egestas nulla. Nam id sem elementum, lobortis odio et, blandit sapien. Quisque vestibulum, nunc quis tristique malesuada, ante elit ornare sapien, eget cursus leo odio ac ligula. Nulla facilisi. Suspendisse scelerisque gravida volutpat. Phasellus fermentum mattis hendrerit. Donec convallis sapien tortor, ut euismod ipsum commodo sed. In hac habitasse platea dictumst. Nam convallis orci pulvinar mollis auctor. Phasellus ipsum sem, dapibus eget justo a, placerat posuere mauris. Aliquam dictum dui sed orci aliquam, id congue orci finibus. In facilisis fringilla facilisis.', '692f40f340eef_malikm_PRO_1.pdf', 5, '2025-12-02 19:41:39', 4, 1, 'OK2'),
(14, 'TEST3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer consequat lacus sed felis fringilla semper. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Aliquam ut maximus urna, a finibus ante. Etiam tempor condimentum hendrerit. Donec libero turpis, pharetra volutpat cursus eget, auctor vitae lorem. Nulla a imperdiet ligula, id sodales nibh. Nunc egestas posuere consectetur. Maecenas quis varius enim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer lectus eros, dapibus nec aliquet vel, laoreet id massa. Phasellus risus libero, consequat ut ante vel, euismod mattis nisi.\r\n\r\nAliquam erat volutpat. Praesent eget egestas nulla. Nam id sem elementum, lobortis odio et, blandit sapien. Quisque vestibulum, nunc quis tristique malesuada, ante elit ornare sapien, eget cursus leo odio ac ligula. Nulla facilisi. Suspendisse scelerisque gravida volutpat. Phasellus fermentum mattis hendrerit. Donec convallis sapien tortor, ut euismod ipsum commodo sed. In hac habitasse platea dictumst. Nam convallis orci pulvinar mollis auctor. Phasellus ipsum sem, dapibus eget justo a, placerat posuere mauris. Aliquam dictum dui sed orci aliquam, id congue orci finibus. In facilisis fringilla facilisis.', '692f40fe54e99_MastersThesis.pdf', 5, '2025-12-02 19:41:50', 4, 1, 'OK2'),
(15, 'TEST4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer consequat lacus sed felis fringilla semper. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Aliquam ut maximus urna, a finibus ante. Etiam tempor condimentum hendrerit. Donec libero turpis, pharetra volutpat cursus eget, auctor vitae lorem. Nulla a imperdiet ligula, id sodales nibh. Nunc egestas posuere consectetur. Maecenas quis varius enim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer lectus eros, dapibus nec aliquet vel, laoreet id massa. Phasellus risus libero, consequat ut ante vel, euismod mattis nisi.\r\n\r\nAliquam erat volutpat. Praesent eget egestas nulla. Nam id sem elementum, lobortis odio et, blandit sapien. Quisque vestibulum, nunc quis tristique malesuada, ante elit ornare sapien, eget cursus leo odio ac ligula. Nulla facilisi. Suspendisse scelerisque gravida volutpat. Phasellus fermentum mattis hendrerit. Donec convallis sapien tortor, ut euismod ipsum commodo sed. In hac habitasse platea dictumst. Nam convallis orci pulvinar mollis auctor. Phasellus ipsum sem, dapibus eget justo a, placerat posuere mauris. Aliquam dictum dui sed orci aliquam, id congue orci finibus. In facilisis fringilla facilisis.', '692f410d687cd_PSA_20250926.pdf', 5, '2025-12-02 19:42:05', 4, 1, 'OK3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_rights` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `access_rights`) VALUES
(1, 'malikm', '$2y$10$RU63FBCPTh6kQ1Xi2qUYQ.DO3e5CtqpHoru1a8aEL16oR8guYaSrm', 4),
(4, 'test_user1', '$2y$10$ol5g21z6fnO8IRvXlIqpkOaySHQ7zsKBvzXyRnfE9l8gbA2BZejxG', 3),
(5, 'test_user2', '$2y$10$itiao8EnP9LiqoeBRFdUZOAu12/8iFGlaTx5LPvAgIZeSPpW9nu2q', 1),
(6, 'test_user3', '$2y$10$eKb8bCgJZq4eaMio8aZOIuvi0Xn6faDkwWvDFni4uj/loy8AlCCs2', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acess_rights`
--
ALTER TABLE `acess_rights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `acess_title` (`acess_title`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acess_rights`
--
ALTER TABLE `acess_rights`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;