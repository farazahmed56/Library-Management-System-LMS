--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publication_year` int(4) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for some initial books
--

INSERT INTO `books` (`id`,`title`, `author`, `publication_year`, `isbn`, `quantity`) VALUES
(1, 'Pride and Prejudice', 'Jane Austen', 1813, 'JAN-0923-56', 2),
(2, 'A History of Western Philosophy', 'Bertrand Russell', 1946, 'ABC-54321-0', 4),
(3, 'Java: The Complete Reference', 'Herbert Schildt', 2018, 'XYZ-987-123', 5),
(4, 'Introduction to Computer', 'Peter Norton', 1993, 'DCBA-789-0', 12),
(5, 'Pakistan: A Personal History', 'Imran Khan', 2015, 'IMRAN-124-5', 7),
(6, 'The Castle', 'Franz Kafka', 1930, 'KAF-4321-', 6),
(7, 'Digital Logic and Computer Design', 'Morris Mono', 1989, 'MNO-7894-0', 3),
(8, 'Assembly Language and Organization of IBM PC', 'Yutha Yu & Charles Maru', 1928, 'YU-5643-009', 14),
(9, 'Software Engineering ', 'Ian Sommervile', 2014, 'IAN-0987', 12);

-- --------------------------------------------------------

--
-- Table structure for table `issued_books`
--

CREATE TABLE `issued_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`book_id`) REFERENCES `books`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
