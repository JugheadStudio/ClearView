-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 19, 2023 at 02:08 PM
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
-- Database: `ClearView`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `doctorID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `date` varchar(25) NOT NULL,
  `time` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `patientID`, `doctorID`, `roomID`, `date`, `time`) VALUES
(10, 3, 1, 2, '2023-06-13', '04:00 AM'),
(11, 2, 10, 2, '2023-07-06', '00:30 AM'),
(12, 1, 5, 3, '2023-07-01', '04:30 AM'),
(13, 1, 1, 5, '2023-06-22', '07:00 AM'),
(14, 3, 1, 9, '2023-06-22', '05:00 AM'),
(15, 19, 10, 5, '2023-06-24', '05:00 AM'),
(17, 2, 1, 6, '2023-06-30', '17:30 PM'),
(18, 3, 4, 7, '2023-06-23', '15:00 PM'),
(20, 1, 11, 6, '2023-06-29', '15:30 PM');

-- --------------------------------------------------------

--
-- Table structure for table `appointmentHistory`
--

CREATE TABLE `appointmentHistory` (
  `appointmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `doctorID` int(11) NOT NULL,
  `appointmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `changeCreate`
--

CREATE TABLE `changeCreate` (
  `id` int(11) NOT NULL,
  `receptionistID` int(11) NOT NULL,
  `doctorID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `date` varchar(25) NOT NULL,
  `time` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `changeLog`
--

CREATE TABLE `changeLog` (
  `changeID` int(11) NOT NULL,
  `receptionistID` int(11) NOT NULL,
  `date` varchar(25) NOT NULL,
  `time` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `profilePicture` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `dateOfBirth` varchar(25) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `phoneNumber` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `roomID` varchar(25) NOT NULL,
  `discipline` varchar(25) NOT NULL,
  `rate` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `profilePicture`, `username`, `name`, `surname`, `dateOfBirth`, `gender`, `phoneNumber`, `email`, `password`, `roomID`, `discipline`, `rate`) VALUES
(1, 'uploads/649395924b19e.png', 'Doc1', 'Amelia', 'Stone', '1986-06-20', 'Female', '1234567890', 'test@test.com', '$2y$10$hBJbTxD.YP4RELlujy9m/u/H/gLzo0m/gkbzFRqJlv3kKzf.o6SwC', '1', 'Allergist', '500'),
(4, 'uploads/64937cc75330e.png', 'Doc1', 'Benjamin', 'Knight', '1982-05-04', 'Male', '1234567890', 'Ruan@test.com', '$2y$10$11BTQnjpm7TCuViN5b.J5.p4joyujn0fER0PeA/Y1sRl5Wub8JLLi', '1', 'Neurologist', '500'),
(5, 'uploads/6494edf5d4ff1.png', 'Doc2', 'Olivia', 'Reed', '1991-10-16', 'Female', '4234', 'sdfaasd@fds.fasd', '$2y$10$aBgcbasFjdacJIxJ/iD8GurhrFY4H51ByAf3XRoRLFlgTmsFqPC1W', '1', 'ENT Specialist', '232'),
(9, 'uploads/64937cd83e421.png', 'Doc5', 'Ethan', 'Harrison', '1991-05-09', 'Male', '4234', 'fads@fasd.fda', '$2y$10$E7p22ugOFnQ/aTgWNvTwRO3svr5Hp2wjgR6wCqkTIcScFdiYANAf2', '1', 'Chiropractor', '4234'),
(10, 'uploads/64937cdeed559.png', 'admin5', 'Sophia', 'Foster', '1994-03-08', 'Female', '432423', 'fsdaf@fad.sdfa', '$2y$10$WaVgqnv/aNYFZobRFPYfGOcRsWz3jOMKskyqCSNz4InOpIEx9DjoW', '1', 'Physical Therapist', '423'),
(11, 'uploads/64937ce8b1099.png', 'Evans123', 'Samuel', 'Evans', '1988-12-15', 'Male', '1234567890', 'faddf@fasdfs.fa', '$2y$10$qdHGpy5Mx4weMqWVDBE39u/4qvucfaPEet4EXg4gm/FuZeV7DGgpG', '1', 'Psychiatrist', '3424'),
(12, 'uploads/64937cf12b43b.png', 'Ava123', 'Ava', 'Mitchell', '1979-06-13', 'Female', '1234567890', 'asdfdsa@fda.das', '$2y$10$YbVvnd9KtSb.WkhBfcgLiO1Mg.Tysee280h5NPHvZ5SztD7V37QIC', '4', 'ENT Specialist', '423'),
(13, 'uploads/64937cfa2e236.webp', 'William123', 'William', 'Campbell', '1979-09-12', 'Male', '1234567890', 'fasd@fasdf.dfas', '$2y$10$v8NLn00KevwOB5bRAd7xLOU6QJ8kCaArehI0c15KQIJWQz7yZeq3K', '8', 'General Practitioner', '423'),
(14, 'uploads/64937d0650378.png', 'Harper123', 'Harper', 'Nelson', '1997-10-15', 'Female', '1234567890', 'fdasf@fasd.dfas', '$2y$10$WCSQGooMKv1J/XSC4UwOh.gABxInyQ.toPRZnd3OlHmaNwygTG8cK', '7', 'Gastroenterologist', '312'),
(15, 'uploads/64937d0f6ec52.png', 'Jameson1234', 'Jameson', 'Turner', '1995-05-10', 'Male', '1234567890', 'dsaf@fasd.fasd', '$2y$10$YGHLmBIOmj7jA4K2IKiyROQoaxQr.cC9ifJnmdSvxOeUeU2d3tfJS', '3', 'Ophthalmologist', '432');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passwordResetTokens`
--

CREATE TABLE `passwordResetTokens` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `resetToken` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passwordResetTokens`
--

INSERT INTO `passwordResetTokens` (`id`, `userID`, `resetToken`) VALUES
(13, 1, 'db35beed623f594ac98779bf255b9aad2ff5fb64da1593c23d2c914a0f3580eb'),
(15, 1, 'dcf1540393c08faf00aba23aa055d751f2dc6bc6184050c6a439c7a789bff7cc'),
(16, 17, 'c6e0a5adb9165d950b9a31cd4a2f1210ca48f224a96bc199ae5cfb9d5dd14f62'),
(17, 17, '1648a8db5b06686014e82b2d60d01dcd3eb8a5cecb2d2d537a2e0e10d34cb5c2'),
(18, 1, 'b45398c9f5d86989c9374d2129d121c1106a37fca8011f57ed7fbc0d0f55923d'),
(19, 1, 'd118d4103f53c14d24c2bc58fd1e44491cd77784d08ab31a8f25777226b9c457'),
(20, 1, '6e4debc3758071538369dde741e62c824b581bd87ec8a187959f0db857ed9e20'),
(21, 1, 'f112ea4002bcbc16a24815b7f78bf3b5ecd842980f8a0c8051eaed294274b731'),
(22, 1, '292620652475f817f5357b30c3f66717d3a9cdac73bb3ca353f29ca8d18c4dd0'),
(23, 1, '43d066e49ee4e7436f2ba7ea7e12a659b12bdde0f4f3d4d04eda507fdd010410'),
(24, 1, 'e762869274260c9d05236ec63c60e1cdb689719a55608aa120bae38d0bbe4000'),
(25, 1, '3be7e82d39b50af1ed05fa47bc01394d178eb13ad3e1b7aff04fa1631d1cbfd2'),
(26, 1, '49fbddedeab147bbf2f64906e258f65df16fba1fe044914771908b207be286b6'),
(27, 1, 'c3bdb870abc548c02830f1d9d366b994fcf60b8d3f49039a5ce7792ed96befdd'),
(28, 1, '0fa142643ce4689ab7941bacc1667077d7b79170a4c6ae557ef63a1ab1d3a987'),
(29, 1, '30fdbe7c95aa9ba6bb684709f72d2b52e982dc429085dbe00475d1bd914c1444'),
(30, 1, '405a3e58ad2e43fdb4ffc1ba037f9db10ceb0725f3edbf0cfe657d55a9df4f9c'),
(31, 2, 'aa76c07d2b03cd5184c2f54f00afa969854ff0c4720f39469e7fccc89103d42f'),
(32, 1, 'cb79a65aee4d7129efbfba16ae18c2b132961e1e469d0b4625c648af34b36633'),
(33, 1, 'd1993b92955c7896f3fc67a2a85bc469390d63953e58c2f54d200a9f0ac5c3bf'),
(34, 1, '65f652e2f36470dac4d5dbec33f44df080086b188aed42502c3a4b70cdefde32'),
(35, 1, 'd95b0864ddfa088d22de18ac31cc9e965dfab36595c61e982f3a30877c887143'),
(36, 1, '635f1d194bdb9a34ef28e5a4f256408c95512de1641cd9e6beee5f9b7707d294'),
(37, 20, '5742e7f67a78a5f63ff17d3c8b8038250d738e24143a29c729b95cd5479ec041');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `profilePicture` varchar(250) NOT NULL,
  `name` varchar(25) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `dateOfBirth` varchar(25) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `phoneNumber` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(80) NOT NULL,
  `medicalAid` varchar(25) NOT NULL,
  `medicalAidNumber` varchar(25) NOT NULL,
  `bloodType` varchar(25) NOT NULL,
  `allergy` varchar(80) NOT NULL,
  `emergencyContactName` varchar(25) NOT NULL,
  `emergencyContactNumber` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `profilePicture`, `name`, `surname`, `dateOfBirth`, `gender`, `phoneNumber`, `email`, `address`, `medicalAid`, `medicalAidNumber`, `bloodType`, `allergy`, `emergencyContactName`, `emergencyContactNumber`) VALUES
(1, 'uploads/64937d18ea20f.png', 'Emma', 'Johnson', '2023-06-07', 'Female', '423423', 'rsd@fdas.fsd', 'test', 'dfsd', '423423', 'A', 'fsdafs', 'Linda Jordaan', '4234234234234'),
(2, 'uploads/64937d2271d2d.png', 'John', 'Smith', '2023-06-14', 'Male', '23423', 'fdsd@fds.sdf', 'fdasfa', 'fsda', '4234', 'AB', 'dsfasd', 'fdasdf', '4234'),
(3, 'uploads/649395b0b8238.PNG', 'Olivia', 'Davis', '2023-06-21', 'Female', '1234', 'test@fdd.com', 'asdfsdfsdf', 'test', '1234', 'O', 'test', 'test', '1234'),
(19, 'uploads/64937d3d9b3a8.png', 'Noah', 'Wilson', '2023-06-08', 'Male', '4234234', 'fsadf@fasf.fasd', 'fasdf', 'sdfdsf', '42423', 'B', 'fsdfds', 'dsafasd', '423423'),
(22, 'uploads/6495c8188df81.png', 'Ava', 'Thompson', '2023-06-30', 'Male', '431', 'fa@dfa.fad', 'fsda', 'sdfasd', '424', 'A', 'Bees', 'fdsda', '24234'),
(23, 'uploads/6494ee1b848b3.png', 'Ethan', 'Brown', '2023-06-24', 'Male', '4321423', 'jugz@jughead.studio', 'dfasdsf', 'sdffasd', '423423', 'B', 'Bees', 'dfsasd', '24234'),
(25, 'uploads/64937d57dbf75.png', 'Isabella', 'Anderson', '2004-06-21', 'Female', '1234567890', 'afsdds@fasd.fasd', 'fsds', 'fdaf', '423423', 'B', 'fsdf', 'fsadfs', '4234'),
(26, 'uploads/64937d6fd3af2.png', 'Lucas', 'Martinez', '1982-10-08', 'Male', '1234567890', 'dfas@fasdd.fdas', 'asdfsda', 'sdfas', '24234', 'B', 'fasdf', 'sdfsad', '42342'),
(27, 'uploads/64937d78cb390.png', 'Sophia', 'Taylor', '1997-06-18', 'Female', '1234567890', 'fsdasd@fasd.das', 'afsdaf', 'Bestmed', '23423', 'B', 'fsdasdf', 'dfasasd', '423423'),
(32, 'uploads/649395fba169d.png', 'Emma', 'Watson', '2023-06-09', 'Female', '44423', 'fdsf@fasd.asd', 'fsas', 'dasf', '2423', 'B', 'fasdf', 'dasfsd', '2423423'),
(38, 'uploads/649597ccc2c3f.png', 'Ruan', 'Jordaan', '2023-06-15', 'Male', '423423', 'fasd@fdas.fasd', 'fasdfsa', 'afsdf', '432423', 'B', 'fasdfsda', 'fasdfdas', '4234323');

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `id` int(11) NOT NULL,
  `profilePicture` varchar(200) NOT NULL,
  `username` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `dateOfBirth` varchar(25) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `phoneNumber` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `rank` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receptionist`
--

INSERT INTO `receptionist` (`id`, `profilePicture`, `username`, `name`, `surname`, `dateOfBirth`, `gender`, `phoneNumber`, `email`, `password`, `rank`) VALUES
(1, 'uploads/64937d95f322e.png', 'admin', 'Ruan', 'Jordaan', '1996-06-13', 'Male', '1234567890', 'ruanj.personal@gmail.com', '$2y$10$qY06/OC3vigxrCzi3eaLyuQu35ZrR7IwEmWrrt6zPZ1zZJ3aN4/6O', '1'),
(2, 'uploads/64937da81d6d1.png', 'admin2', 'Han', 'Solo', '2023-06-10', 'Male', '1234567890', 'jugz@jughead.studio', '$2y$10$4K/J.x6I7Iu.RcHXAiigK.7mMRLdRHlfRCrFtc1Z3/sqnpQh91B/6', '2'),
(9, 'uploads/64937db9c76a5.PNG', 'admin123', 'Luke', 'Skywalker', '2023-06-08', 'Male', '3123', 'test@test.com', '$2y$10$Sb47sVUull4Vw4SVA6H4iuhvdrfrYz4tZG0PNhqDkfRdt88.HTDUu', '1'),
(17, 'uploads/6495978bb7047.png', 'beer1', 'Linda', 'Jordaan', '1967-06-17', 'Female', '1234567890', 'dsfs@gfsd.sdfg', '$2y$10$bHQHzVQtoxcpmxu.zku/OOomorf4himFbirTGaadkzyFF47bFDJAS', '2'),
(19, 'uploads/6495977f3118f.png', 'recept1', 'asdfs', 'asdfsd', '2023-06-08', 'Male', '423423', 'fsaddfs@dfas.afsd', '$2y$10$iMbT7l3nV8gT32Abe9.UDOLLnVASPrHOQOVsiwPa00LrKCum1FL2a', '2'),
(20, 'uploads/6495c59d4612b.png', 'Justin1', 'Justin', 'Koster', '2023-06-09', 'Male', '1234567890', '150139@virtualwindow.co.za', '$2y$10$UE2Tk4caVKEeTmuEzYeED.u27nTf.E3IdY7ThlCWmtCB1BShWo3S6', '2');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `building` varchar(25) NOT NULL,
  `floor` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `name`, `building`, `floor`) VALUES
(1, 'Room 1A', 'Main Building', 'Fist Floor'),
(2, 'Room 1B', 'Main Building', 'First Floor'),
(3, 'Room 1C', 'Main Building', 'First Floor'),
(4, 'Room 1D', 'Main Building', 'First Floor'),
(5, 'Room 1E', 'Main Building', 'First Floor'),
(6, 'Room 2A', 'Main Building', 'Second Floor'),
(7, 'Room 2B', 'Main Building', 'Second Floor'),
(8, 'Room 2C', 'Main Building', 'Second Floor'),
(9, 'Room 2D', 'Main Building', 'Second Floor'),
(10, 'Room 2E', 'Main Building', 'Second Floor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patientID` (`patientID`),
  ADD KEY `doctorID` (`doctorID`),
  ADD KEY `roomID` (`roomID`);

--
-- Indexes for table `appointmentHistory`
--
ALTER TABLE `appointmentHistory`
  ADD KEY `appointmentID` (`appointmentID`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctorID` (`doctorID`),
  ADD KEY `appointmentID` (`appointmentID`);

--
-- Indexes for table `changeCreate`
--
ALTER TABLE `changeCreate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receptionistID` (`receptionistID`),
  ADD KEY `doctorID` (`doctorID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `changeLog`
--
ALTER TABLE `changeLog`
  ADD KEY `receptionistID` (`receptionistID`),
  ADD KEY `changeID` (`changeID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roomID` (`roomID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `password` (`password`);

--
-- Indexes for table `passwordResetTokens`
--
ALTER TABLE `passwordResetTokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `changeCreate`
--
ALTER TABLE `changeCreate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passwordResetTokens`
--
ALTER TABLE `passwordResetTokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `receptionist`
--
ALTER TABLE `receptionist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`roomID`) REFERENCES `room` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`doctorID`) REFERENCES `doctor` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`patientID`) REFERENCES `patients` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `appointmentHistory`
--
ALTER TABLE `appointmentHistory`
  ADD CONSTRAINT `appointmenthistory_ibfk_1` FOREIGN KEY (`appointmentID`) REFERENCES `calendar` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`appointmentID`) REFERENCES `appointment` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `calendar_ibfk_2` FOREIGN KEY (`doctorID`) REFERENCES `doctor` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `changeCreate`
--
ALTER TABLE `changeCreate`
  ADD CONSTRAINT `changecreate_ibfk_1` FOREIGN KEY (`doctorID`) REFERENCES `doctor` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `changecreate_ibfk_2` FOREIGN KEY (`patientID`) REFERENCES `patients` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `changecreate_ibfk_3` FOREIGN KEY (`receptionistID`) REFERENCES `receptionist` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `changeLog`
--
ALTER TABLE `changeLog`
  ADD CONSTRAINT `changelog_ibfk_1` FOREIGN KEY (`changeID`) REFERENCES `changeCreate` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `changelog_ibfk_2` FOREIGN KEY (`receptionistID`) REFERENCES `receptionist` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `passwordResetTokens`
--
ALTER TABLE `passwordResetTokens`
  ADD CONSTRAINT `passwordresettokens_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `receptionist` (`id`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
