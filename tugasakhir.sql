-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2021 at 07:29 AM
-- Server version: 10.5.8-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tugasakhir`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(1) NOT NULL,
  `teacher_id` int(1) DEFAULT NULL,
  `sks` int(11) NOT NULL,
  `course` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `teacher_id`, `sks`, `course`) VALUES
(1, 3, 6, 'Fisika I'),
(2, 2, 6, 'Matematika I'),
(3, 4, 6, 'Kimia B'),
(4, 1, 6, 'Sosial I'),
(5, 1, 6, 'Sosial II');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `student_id` int(1) DEFAULT NULL,
  `course_id` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`student_id`, `course_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 4),
(3, 1),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(2) NOT NULL,
  `test_id` int(1) DEFAULT NULL,
  `question` varchar(53) NOT NULL,
  `choice1` varchar(32) DEFAULT NULL,
  `choice2` varchar(11) DEFAULT NULL,
  `choice3` varchar(15) DEFAULT NULL,
  `choice4` varchar(11) DEFAULT NULL,
  `choice5` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `test_id`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `choice5`) VALUES
(1, 3, 'Berapakah 1 + 1', '2', '3', '4', '5', '7'),
(2, 3, 'Berapakah 2 + 2', '4', '5', '21', '6', '8'),
(3, 1, 'Ibukota Indonesia adalah', 'Jakarta', 'London', 'Bandung', 'Manchester', 'Surabaya'),
(4, 1, 'Presiden pertama Republik Indonesia adalah', 'Sukarno', 'Suharto', 'Joko Widodo', 'Megawati', 'Susilo Bambang Yudhoyono'),
(5, 3, 'Berapakah 3 + 3', '6', '7', '2', '4', '10'),
(6, 3, 'Berapakah 2 + 6', '8', '5', '3', '72', '6'),
(7, 2, 'Berikut ini yang merupakan penghantar listrik adalah', 'besi', 'karet', 'plastik', 'PVC', 'kertas'),
(8, 2, 'Berikut ini yang merupakan karnovira adalah', 'buaya', 'ayam', 'sapi', 'kerbau', 'kambing'),
(9, 1, 'Ibukota Jawa Barat adalah', 'Bandung', 'Cimahi', 'Lembang', 'Tasikmalaya', 'Garut'),
(10, 1, 'Berapakah jumlah provinsi di Indonesia?', '34', '31', '32', '44', '32'),
(11, 2, 'Satuan gaya adalah', 'Newton', 'Hertz', 'Kilogram', 'Meter', 'Mol'),
(12, 2, 'Satuan panjang adalah', 'Meter', 'Ohm', 'Lux', 'Gigabyte', 'Kilogram'),
(13, 4, 'Berikut ini yang merupakan perbuatan baik adalah', 'Membantu nenek menyeberang jalan', 'mencuri', 'berbohong', 'berdusta', 'Durhaka kepada orang tua'),
(14, 4, 'Cabang pemerintahan yang membuat undang-undang adalah', 'legislatif', 'eksekutif', 'yudikatif', 'preventif', 'oligarki'),
(15, 4, 'Wabah yang sedang ada sekarang adalah', 'COVID-19', 'H5N1', 'flu burung', 'campak', 'polio'),
(16, 4, 'Ibukota Jawa Barat adalah', 'Bandung', 'Tasikmalaya', 'Leuwipanjang', 'Bogor', 'Antapani'),
(17, 4, 'Kendaraan yang melaju di atas rel disebut', 'kereta api', 'mobil', 'pesawat terbang', 'kapal', 'bus'),
(21, 5, 'Buatlah esai tentang gaya tarik', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(1) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0,
  `username` varchar(7) DEFAULT NULL,
  `password` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `role`, `username`, `password`) VALUES
(1, 0, 'Bagus', 'jka'),
(2, 0, 'Ahmad', 'msn'),
(3, 0, 'Gilang', 'klop'),
(4, 0, 'Raihan', 'best'),
(5, 0, 'Dimas', 'ngbs'),
(6, 0, 'Permadi', 'cdf'),
(7, 0, 'Rini', 'lok');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(1) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 1,
  `username` varchar(6) DEFAULT NULL,
  `password` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `role`, `username`, `password`) VALUES
(1, 1, 'Budi', 'jhg'),
(2, 1, 'Siti', 'msyn'),
(3, 1, 'Firman', 'rtym'),
(4, 1, 'Dewan', 'njgh'),
(8, 1, 'Burhan', 'dasd'),
(9, 1, 'Rama', 'sjw');

-- --------------------------------------------------------

--
-- Table structure for table `teachingFile`
--

CREATE TABLE `teachingFile` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(1) NOT NULL,
  `course_id` int(1) DEFAULT NULL,
  `type` tinyint(1) NOT NULL,
  `test` varchar(19) DEFAULT NULL,
  `duedate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `course_id`, `type`, `test`, `duedate`) VALUES
(1, 4, 0, 'Kuis 1 Sosial I', '2021-06-01'),
(2, 1, 0, 'Kuis 1 Fisika I', '2021-06-01'),
(3, 2, 0, 'Kuis 1 Matematika I', '2021-06-01'),
(4, 4, 0, 'Kuis 2 Sosial I', '2021-06-01'),
(5, 1, 1, 'Kuis Esai Fisika', '2021-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `testSession`
--

CREATE TABLE `testSession` (
  `student_id` int(1) DEFAULT NULL,
  `test_id` int(1) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `testSession`
--

INSERT INTO `testSession` (`student_id`, `test_id`, `score`, `file`) VALUES
(1, 3, 75, NULL),
(2, 1, 100, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachingFile`
--
ALTER TABLE `teachingFile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teachingFile`
--
ALTER TABLE `teachingFile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
