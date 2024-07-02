-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 09:37 PM
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
-- Database: `new_event`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `session_title` varchar(255) NOT NULL,
  `participants_id` int(11) NOT NULL,
  `dateIn` varchar(255) NOT NULL,
  `timeIn` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `event_id`, `session_title`, `participants_id`, `dateIn`, `timeIn`, `email`) VALUES
(12, 1, '0', 1, '2024-07-01', '21:27:48', NULL),
(13, 1, 'Styled for Success: The Multicloud Makeover Your Customers Deserve', 1, '2024-07-01', '21:30:41', NULL),
(14, 1, 'Fortifying the Frontlines: Advanced Security Solutions with Cisco Firepower', 1, '2024-07-01', '21:32:41', NULL),
(15, 1, 'Convergent Evolution: Optimizing Data Center Operations with Cisco IoT Technologies', 1, '2024-07-01', '21:32:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `suggestion` text NOT NULL,
  `similar_event` text NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment`, `suggestion`, `similar_event`, `event_id`, `email`) VALUES
(2, 'comment', 'suggestion', 'message', 1, 'corbine.santos0206@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_status` int(11) NOT NULL COMMENT '0 = deleted\r\n1 = active\r\n2 = already answer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_title`, `user_id`, `event_status`) VALUES
(1, 'event edited', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_sessions`
--

CREATE TABLE `event_sessions` (
  `session_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `session_title` varchar(255) NOT NULL,
  `technology` varchar(255) NOT NULL,
  `technology_line` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `speaker` varchar(255) NOT NULL,
  `speaker_special` varchar(255) NOT NULL,
  `date` varchar(10) NOT NULL,
  `timeam` varchar(10) NOT NULL,
  `timepm` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_sessions`
--

INSERT INTO `event_sessions` (`session_id`, `event_id`, `session_title`, `technology`, `technology_line`, `product_name`, `speaker`, `speaker_special`, `date`, `timeam`, `timepm`) VALUES
(32, 1, 'Fortifying the Frontlines: Advanced Security Solutions with Cisco Firepower', 'Security', 'Infrastrucutre Security ', 'Cisco Firepower Next-Generation Firewall', 'AJ Capelan', 'Security Evangelist', '11/1/2023', '9:00', '17:00'),
(33, 1, 'Fortifying the Frontlines: Advanced Security Solutions with Cisco Firepower', 'Security', 'Endpoint Security ', 'Cisco AMP (Advanced Malware Protection)', 'Bryan Ortiz', 'Security Solutions Architect', '11/1/2023', '9:00', '17:00'),
(34, 1, 'Fortifying the Frontlines: Advanced Security Solutions with Cisco Firepower', 'Security', 'Endpoint Security ', 'Cisco Threat Response', 'Bryan Ortiz', 'Security Solutions Architect', '11/1/2023', '9:00', '17:00'),
(35, 1, 'Bridging Worlds: Cisco’s Pioneering Approach to IoT and Industrial Connectivity', 'Enterprise Networking', 'Networking Hardware', 'Cisco Industrial Ethernet Switches', 'JC Campo', 'Systems Engineer - Enterprise', '11/4/2023', '12:00', '20:00'),
(36, 1, 'Bridging Worlds: Cisco’s Pioneering Approach to IoT and Industrial Connectivity', 'Mass Scale and Automation ', 'IoT (Internet of Things)', 'Cisco IoT Gateways', 'Robin Carlos', 'Emerging Technology Architect', '11/4/2023', '12:00', '20:00'),
(37, 1, 'Bridging Worlds: Cisco’s Pioneering Approach to IoT and Industrial Connectivity', 'Enterprise Networking', 'Networking Hardware', 'Cisco Industrial Routers', 'JC Campo', 'Systems Engineer - Enterprise', '11/4/2023', '12:00', '20:00'),
(38, 1, 'Bridging Worlds: Cisco’s Pioneering Approach to IoT and Industrial Connectivity', 'Mass Scale and Automation ', 'IoT (Internet of Things)', 'Cisco Kinetic', 'Robin Carlos', 'Emerging Technology Architect', '11/4/2023', '12:00', '20:00'),
(39, 1, 'Unified Shield: Integrating Cisco’s Security Solutions for Holistic Protection', 'Security', 'Endpoint Security ', 'Cisco SecureX', 'AJ Capelan', 'Security Evangelist', '11/8/2023', '12:00', '20:00'),
(40, 1, 'Unified Shield: Integrating Cisco’s Security Solutions for Holistic Protection', 'Security', 'Endpoint Security ', 'Cisco SecureX', 'AJ Capelan', 'Security Evangelist', '11/8/2023', '12:00', '20:00'),
(41, 1, 'Unified Shield: Integrating Cisco’s Security Solutions for Holistic Protection', 'Security', 'Endpoint Security ', 'Cisco ISE (Identity Services Engine)', 'AJ Capelan', 'Security Evangelist', '11/8/2023', '12:00', '20:00'),
(42, 1, 'Unified Shield: Integrating Cisco’s Security Solutions for Holistic Protection', 'Security', 'Network Security ', 'Cisco Umbrella', 'AJ Capelan', 'Security Evangelist', '11/8/2023', '12:00', '20:00'),
(43, 1, 'Convergent Evolution: Optimizing Data Center Operations with Cisco IoT Technologies', 'Recurring Softwares', 'Software Management', 'Cisco Data Center Network Manager', 'Princess Cruz', 'Cloud Infrastructure Manager', '11/12/2023', '6:00', '19:00'),
(44, 1, 'Convergent Evolution: Optimizing Data Center Operations with Cisco IoT Technologies', 'Cloud Infrastructure', 'Software Management', 'Cisco Edge Intelligence', 'Princess Cruz', 'Cloud Infrastructure Manager', '11/12/2023', '6:00', '19:00'),
(45, 1, 'Convergent Evolution: Optimizing Data Center Operations with Cisco IoT Technologies', 'Recurring Softwares', 'Data Center and Cloud', 'Cisco Intersight', 'Rod James', 'Cloud Infrastructure SE', '11/12/2023', '6:00', '19:00'),
(46, 1, 'Convergent Evolution: Optimizing Data Center Operations with Cisco IoT Technologies', 'Cloud Infrastructure', 'Data Center and Cloud', 'Cisco UCS Servers', 'Maine Hernandez', 'Cloud Compute Expert', '11/12/2023', '6:00', '19:00'),
(47, 1, 'Securing the Edge: Strategies and Solutions for IoT Security with Cisco', 'Security', 'Network Security ', 'Cisco Cyber Vision', 'AJ Capelan', 'Security Evangelist', '11/16/2023', '10:00', '14:00'),
(48, 1, 'Securing the Edge: Strategies and Solutions for IoT Security with Cisco', 'Mass Scale and Automation ', 'IoT (Internet of Things)', 'Cisco IoT Security', 'Robin Carlos', 'Emerging Technology Architect', '11/16/2023', '10:00', '14:00'),
(49, 1, 'Securing the Edge: Strategies and Solutions for IoT Security with Cisco', 'Security', 'Network Security ', 'Cisco Umbrella', 'AJ Capelan', 'Security Evangelist', '11/16/2023', '10:00', '14:00'),
(50, 1, 'Architecting the Future: Cisco’s Vision for Next-Generation Enterprise Networking', 'Enterprise Networking', 'Networking Hardware', 'Cisco Catalyst Switches', 'JC Campo', 'Systems Engineer - Enterprise', '11/19/2023', '6:00', '17:00'),
(51, 1, 'Architecting the Future: Cisco’s Vision for Next-Generation Enterprise Networking', 'Enterprise Networking', 'Recurring Softwares', 'Network Management', 'Princess Cruz', 'Cloud Infrastructure Manager', '11/19/2023', '6:00', '17:00'),
(52, 1, 'Architecting the Future: Cisco’s Vision for Next-Generation Enterprise Networking', 'Enterprise Networking', 'Networking Hardware', 'Cisco Aironet Access Points', 'JC Campo', 'Systems Engineer - Enterprise', '11/19/2023', '6:00', '17:00'),
(53, 1, 'Architecting the Future: Cisco’s Vision for Next-Generation Enterprise Networking', 'Enterprise Networking', 'Networking Hardware', 'Cisco Meraki', 'JC Campo', 'Systems Engineer - Enterprise', '11/19/2023', '6:00', '17:00'),
(54, 1, 'Redefining Connectivity: Leveraging Cisco SD-WAN for Enhanced Business Operations', 'Enterprise Networking', 'Networking Hardware', 'Cisco Viptela', 'Mario Bermuda', 'Cloud Networking Architect', '11/23/2023', '10:00', '21:00'),
(55, 1, 'Redefining Connectivity: Leveraging Cisco SD-WAN for Enhanced Business Operations', 'Enterprise Networking', 'Networking Hardware', 'Cisco Meraki SD-WAN', 'Mario Bermuda', 'Cloud Networking Architect', '11/23/2023', '10:00', '21:00'),
(56, 1, 'Redefining Connectivity: Leveraging Cisco SD-WAN for Enhanced Business Operations', 'Enterprise Networking', 'Networking Hardware', 'Cisco ISR Routers', 'JC Campo', 'Systems Engineer - Enterprise', '11/23/2023', '10:00', '21:00'),
(57, 1, 'Transformative Networks: How Cisco is Leading the Way in Enterprise Network Evolution', 'Recurring Softwares', 'Software Management', 'Cisco DNA Assurance', 'Princess Cruz', 'Cloud Infrastructure Manager', '11/26/2023', '6:00', '15:00'),
(58, 1, 'Transformative Networks: How Cisco is Leading the Way in Enterprise Network Evolution', 'Cloud Infrastructure', 'Data Center and Cloud', 'Cisco Nexus Switches', 'Sarun Yu', 'Data Center Networking Expert', '11/26/2023', '6:00', '15:00'),
(59, 1, 'Transformative Networks: How Cisco is Leading the Way in Enterprise Network Evolution', 'Cloud Infrastructure', 'Software Management', 'Cisco Application Policy Infrastructure Controller (APIC)', 'Princess Cruz', 'Cloud Infrastructure Manager', '11/26/2023', '6:00', '15:00'),
(60, 1, 'Unified Front: Integrating Communications and Networking with Cisco’s Enterprise Solutions', 'Hybrid Work', 'Collaboration and Communication', 'Cisco Unified Communications Manager', 'Bong Calyan', 'Collaboration Expert', '11/29/2023', '9:00', '18:00'),
(61, 1, 'Unified Front: Integrating Communications and Networking with Cisco’s Enterprise Solutions', 'Hybrid Work', 'Collaboration and Communication', 'Cisco WebEx', 'Jane Mendoza', 'Web Conferencing Specialist', '11/29/2023', '9:00', '18:00'),
(62, 1, 'Unified Front: Integrating Communications and Networking with Cisco’s Enterprise Solutions', 'Hybrid Work', 'Collaboration and Communication', 'Cisco Jabber', 'Bong Calyan', 'Collaboration Expert', '11/29/2023', '9:00', '18:00'),
(63, 1, 'Unified Front: Integrating Communications and Networking with Cisco’s Enterprise Solutions', 'Hybrid Work', 'Collaboration and Communication', 'Cisco TelePresence', 'Bong Calyan', 'Collaboration Expert', '11/29/2023', '9:00', '18:00'),
(64, 1, 'Strategic Connectivity: Advanced SD-WAN Strategies with Cisco Viptela', 'Enterprise Networking', 'Networking Hardware', 'Cisco Viptela vEdge Routers', 'JC Campo', 'Systems Engineer - Enterprise', '12/3/2023', '6:00', '13:00'),
(65, 1, 'Strategic Connectivity: Advanced SD-WAN Strategies with Cisco Viptela', 'Recurring Softwares', 'Software Management', 'Cisco vManage', 'Princess Cruz', 'Cloud Infrastructure Manager', '12/3/2023', '6:00', '13:00'),
(66, 1, 'Strategic Connectivity: Advanced SD-WAN Strategies with Cisco Viptela', 'Recurring Softwares', 'Software Management', 'Cisco vSmart Controller', 'Princess Cruz', 'Cloud Infrastructure Manager', '12/3/2023', '6:00', '13:00'),
(67, 1, 'Securing the Enterprise: Cisco’s Comprehensive Approach to Network Security', 'Security', 'Infrastrucutre Security ', 'Cisco Secure Firewall', 'AJ Capelan', 'Security Evangelist', '12/3/2023', '6:00', '13:00'),
(68, 1, 'Securing the Enterprise: Cisco’s Comprehensive Approach to Network Security', 'Security', 'Endpoint Security ', 'Cisco Secure Endpoint', 'AJ Capelan', 'Security Evangelist', '12/3/2023', '6:00', '13:00'),
(69, 1, 'Securing the Enterprise: Cisco’s Comprehensive Approach to Network Security', 'Security', 'Endpoint Security ', 'Cisco Stealthwatch', 'AJ Capelan', 'Security Evangelist', '12/3/2023', '6:00', '13:00'),
(70, 1, 'Securing the Enterprise: Cisco’s Comprehensive Approach to Network Security', 'Security', 'Network Security ', 'Cisco Secure Network Analytics', 'Bryan Ortiz', 'Security Solutions Architect', '12/3/2023', '6:00', '13:00'),
(71, 1, 'Empowering the Edge: Cisco’s Innovative Solutions for IoT Integration', 'Mass Scale and Automation ', 'IoT (Internet of Things)', 'Cisco IoT Gateways', 'Robin Carlos', 'Emerging Technology Architect', '12/10/2023', '6:00', '20:00'),
(72, 1, 'Empowering the Edge: Cisco’s Innovative Solutions for IoT Integration', 'Cloud Infrastructure', 'Data Center and Cloud', 'Cisco Edge Intelligence', 'Sarun Yu', 'Data Center Networking Expert', '12/10/2023', '6:00', '20:00'),
(73, 1, 'Empowering the Edge: Cisco’s Innovative Solutions for IoT Integration', 'Enterprise Networking', 'Networking Hardware', 'Cisco Industrial Routers', 'JC Campo', 'Systems Engineer - Enterprise', '12/10/2023', '6:00', '20:00'),
(74, 1, 'Empowering the Edge: Cisco’s Innovative Solutions for IoT Integration', 'Enterprise Networking', 'Networking Hardware', 'Cisco Embedded Networks Series', 'JC Campo', 'Systems Engineer - Enterprise', '12/10/2023', '6:00', '20:00'),
(75, 1, 'Automate to Innovate: Transforming Networks with Cisco’s Automation Technologies', 'Recurring Softwares', 'Software Management', 'Cisco DNA Center', 'Princess Cruz', 'Cloud Infrastructure Manager', '12/14/2023', '10:00', '14:00'),
(76, 1, 'Automate to Innovate: Transforming Networks with Cisco’s Automation Technologies', 'Mass Scale and Automation ', 'Automation', 'Cisco Network Services Orchestrator (NSO)', 'Toni Marcos', 'Infrastructure Automation', '12/14/2023', '10:00', '14:00'),
(77, 1, 'Automate to Innovate: Transforming Networks with Cisco’s Automation Technologies', 'Cloud Infrastructure', 'Software Management', 'Cisco ACI (Application Centric Infrastructure)', 'Princess Cruz', 'Cloud Infrastructure Manager', '12/14/2023', '10:00', '14:00'),
(78, 1, 'Pioneering the Future: The Evolution of Cisco’s Data Center Technologies', 'Cloud Infrastructure', 'Data Center and Cloud', 'Cisco UCS Servers', 'Maine Hernandez', 'Cloud Compute Expert', '12/17/2023', '6:00', '18:00'),
(79, 1, 'Pioneering the Future: The Evolution of Cisco’s Data Center Technologies', 'Cloud Infrastructure', 'Data Center and Cloud', 'Cisco HyperFlex', 'Maine Hernandez', 'Cloud Compute Expert', '12/17/2023', '6:00', '18:00'),
(80, 1, 'Pioneering the Future: The Evolution of Cisco’s Data Center Technologies', 'Cloud Infrastructure', 'Data Center and Cloud', 'Cisco Nexus Switches', 'Sarun Yu', 'Data Center Networking Expert', '12/17/2023', '6:00', '18:00'),
(81, 1, 'Guarding the Gateway: Advanced IoT Security Strategies with Cisco', 'Security', 'Endpoint Security ', 'Cisco Identity Services Engine (ISE)', 'AJ Capelan', 'Security Evangelist', '12/20/2023', '9:00', '21:00'),
(82, 1, 'Guarding the Gateway: Advanced IoT Security Strategies with Cisco', 'Security', 'Network Security ', 'Cisco Cyber Vision', 'AJ Capelan', 'Security Evangelist', '12/20/2023', '9:00', '21:00'),
(83, 1, 'Guarding the Gateway: Advanced IoT Security Strategies with Cisco', 'Security', 'Network Security ', 'Cisco Umbrella', 'AJ Capelan', 'Security Evangelist', '12/20/2023', '9:00', '21:00'),
(84, 1, 'Revolutionizing Data Centers: Cisco’s Journey to Automation and Intelligence', 'Recurring Softwares', 'Data Center and Cloud', 'Cisco Intersight', 'Rod James', 'Cloud Infrastructure SE', '12/23/2023', '12:00', '15:00'),
(85, 1, 'Revolutionizing Data Centers: Cisco’s Journey to Automation and Intelligence', 'Recurring Softwares', 'Data Center and Cloud', 'Cisco Workload Optimization Manager', 'Rod James', 'Cloud Infrastructure SE', '12/23/2023', '12:00', '15:00'),
(86, 1, 'Revolutionizing Data Centers: Cisco’s Journey to Automation and Intelligence', 'Recurring Softwares', 'Data Center and Cloud', 'Cisco Tetration', 'Rod James', 'Cloud Infrastructure SE', '12/23/2023', '12:00', '15:00'),
(87, 1, 'Converging Worlds: Harnessing the Power of Automation in IoT with Cisco', 'Mass Scale and Automation ', 'IoT (Internet of Things)', 'Cisco IoT Gateways', 'Robin Carlos', 'Emerging Technology Architect', '12/26/2023', '8:00', '15:00'),
(88, 1, 'Converging Worlds: Harnessing the Power of Automation in IoT with Cisco', 'Recurring Softwares', 'Software Management', 'Cisco Industrial Network Director', 'Princess Cruz', 'Cloud Infrastructure Manager', '12/26/2023', '8:00', '15:00'),
(89, 1, 'Converging Worlds: Harnessing the Power of Automation in IoT with Cisco', 'Recurring Softwares', 'Software Management', 'Cisco DNA Center', 'Princess Cruz', 'Cloud Infrastructure Manager', '12/26/2023', '8:00', '15:00'),
(90, 1, 'Converging Worlds: Harnessing the Power of Automation in IoT with Cisco', 'Enterprise Networking', 'Networking Hardware', 'Cisco Embedded Networks Series', 'JC Campo', 'Systems Engineer - Enterprise', '12/26/2023', '8:00', '15:00'),
(91, 1, 'Converging Worlds: Harnessing the Power of Automation in IoT with Cisco', 'Mass Scale and Automation ', 'IoT (Internet of Things)', 'Cisco Kinetic', 'Robin Carlos', 'Emerging Technology Architect', '12/26/2023', '8:00', '15:00'),
(92, 1, 'Synergizing Operations: The Role of IoT in Optimizing Data Center Performance with Cisco', 'Cloud Infrastructure', 'Data Center and Cloud', 'Cisco HyperFlex', 'Maine Hernandez', 'Cloud Compute Expert', '12/31/2023', '6:00', '14:00'),
(93, 1, 'Synergizing Operations: The Role of IoT in Optimizing Data Center Performance with Cisco', 'Cloud Infrastructure', 'Data Center and Cloud', 'Cisco UCS Servers', 'Maine Hernandez', 'Cloud Compute Expert', '12/31/2023', '6:00', '14:00'),
(94, 1, 'Synergizing Operations: The Role of IoT in Optimizing Data Center Performance with Cisco', 'Recurring Softwares', 'Data Center and Cloud', 'Cisco Intersight', 'Rod James', 'Cloud Infrastructure SE', '12/31/2023', '6:00', '14:00'),
(95, 1, 'Synergizing Operations: The Role of IoT in Optimizing Data Center Performance with Cisco', 'Cloud Infrastructure', 'Data Center and Cloud', 'Cisco Nexus Switches', 'Sarun Yu', 'Data Center Networking Expert', '12/31/2023', '6:00', '14:00'),
(96, 1, 'Synergizing Operations: The Role of IoT in Optimizing Data Center Performance with Cisco', 'Cloud Infrastructure', 'Software Management', 'Cisco ACI (Application Centric Infrastructure)', 'Princess Cruz', 'Cloud Infrastructure Manager', '12/31/2023', '6:00', '14:00'),
(97, 1, 'Secure Connect: Elevating Collaboration through Cisco’s Unified Security', 'Hybrid Work', 'Collaboration and Communication', 'Cisco WebEx', 'Jane Mendoza', 'Web Conferencing Specialist', '1/5/2024', '11:00', '19:00'),
(98, 1, 'Secure Connect: Elevating Collaboration through Cisco’s Unified Security', 'Security', 'Endpoint Security ', 'Cisco Duo Security', 'AJ Capelan', 'Security Evangelist', '1/5/2024', '11:00', '19:00'),
(99, 1, 'Secure Connect: Elevating Collaboration through Cisco’s Unified Security', 'Security', 'Endpoint Security ', 'Cisco AnyConnect Secure Mobility Client', 'AJ Capelan', 'Security Evangelist', '1/5/2024', '11:00', '19:00'),
(100, 1, 'Unified Visions: Exploring Advanced Collaboration Technologies with Cisco WebEx', 'Hybrid Work', 'Collaboration and Communication', 'Cisco WebEx Meetings', 'Jane Mendoza', 'Web Conferencing Specialist', '1/8/2024', '11:00', '19:00'),
(101, 1, 'Unified Visions: Exploring Advanced Collaboration Technologies with Cisco WebEx', 'Hybrid Work', 'Collaboration and Communication', 'Cisco WebEx Teams', 'Jane Mendoza', 'Web Conferencing Specialist', '1/8/2024', '11:00', '19:00'),
(102, 1, 'Unified Visions: Exploring Advanced Collaboration Technologies with Cisco WebEx', 'Hybrid Work', 'Collaboration and Communication', 'Cisco WebEx Devices like WebEx Board and Room Kit', 'Jane Mendoza', 'Web Conferencing Specialist', '1/8/2024', '11:00', '19:00'),
(103, 1, 'Guardians of the Network: Cisco’s Intelligent Approach to Cybersecurity', 'Security', 'Infrastrucutre Security ', 'Cisco Firepower Next-Generation Firewall', 'AJ Capelan', 'Security Evangelist', '1/11/2024', '10:00', '16:00'),
(104, 1, 'Guardians of the Network: Cisco’s Intelligent Approach to Cybersecurity', 'Security', 'Endpoint Security ', 'Cisco Advanced Malware Protection (AMP)', 'Bryan Ortiz', 'Security Solutions Architect', '1/11/2024', '10:00', '16:00'),
(105, 1, 'Guardians of the Network: Cisco’s Intelligent Approach to Cybersecurity', 'Security', 'Infrastrucutre Security ', 'Cisco Stealthwatch', 'AJ Capelan', 'Security Evangelist', '1/11/2024', '10:00', '16:00'),
(106, 1, 'Collaborate with Confidence: Secure Communication Solutions from Cisco', 'Security', 'Endpoint Security ', 'Cisco SecureX', 'AJ Capelan', 'Security Evangelist', '1/14/2024', '6:00', '19:00'),
(107, 1, 'Collaborate with Confidence: Secure Communication Solutions from Cisco', 'Security', 'Endpoint Security ', 'Cisco Email Security', 'AJ Capelan', 'Security Evangelist', '1/14/2024', '6:00', '19:00'),
(108, 1, 'Collaborate with Confidence: Secure Communication Solutions from Cisco', 'Security', 'Endpoint Security ', 'Cisco Secure Endpoint', 'AJ Capelan', 'Security Evangelist', '1/14/2024', '6:00', '19:00'),
(109, 1, 'Enterprise Synergy: Transformative Collaborative Solutions with Cisco', 'Hybrid Work', 'Collaboration and Communication', 'Cisco Unified Communications Manager (UCM)', 'Bong Calyan', 'Collaboration Expert', '1/17/2024', '9:00', '13:00'),
(110, 1, 'Enterprise Synergy: Transformative Collaborative Solutions with Cisco', 'Hybrid Work', 'Collaboration and Communication', 'Cisco Collaboration Flex Plan', 'Bong Calyan', 'Collaboration Expert', '1/17/2024', '9:00', '13:00'),
(111, 1, 'Enterprise Synergy: Transformative Collaborative Solutions with Cisco', 'Hybrid Work', 'Collaboration and Communication', 'Cisco Jabber', 'Bong Calyan', 'Collaboration Expert', '1/17/2024', '9:00', '13:00'),
(112, 1, 'Innovate Securely: Cisco’s Cutting-Edge Solutions for Cyber Resilience', 'Security', 'Infrastrucutre Security ', 'Cisco Threat Response', 'AJ Capelan', 'Security Evangelist', '1/20/2024', '12:00', '16:00'),
(113, 1, 'Innovate Securely: Cisco’s Cutting-Edge Solutions for Cyber Resilience', 'Security', 'Infrastrucutre Security ', 'Cisco Secure Firewall', 'AJ Capelan', 'Security Evangelist', '1/20/2024', '12:00', '16:00'),
(114, 1, 'Innovate Securely: Cisco’s Cutting-Edge Solutions for Cyber Resilience', 'Security', 'Network Security ', 'Cisco Secure Network Analytics', 'Bryan Ortiz', 'Security Solutions Architect', '1/20/2024', '12:00', '16:00'),
(115, 1, 'Beyond Boundaries: Creating Enhanced Collaborative Experiences with Cisco', 'Hybrid Work', 'Collaboration and Communication', 'Cisco WebEx Room Series', 'Jane Mendoza', 'Web Conferencing Specialist', '1/23/2024', '8:00', '19:00'),
(116, 1, 'Beyond Boundaries: Creating Enhanced Collaborative Experiences with Cisco', 'Hybrid Work', 'Collaboration and Communication', 'Cisco TelePresence SX Series', 'Bong Calyan', 'Collaboration Expert', '1/23/2024', '8:00', '19:00'),
(117, 1, 'Beyond Boundaries: Creating Enhanced Collaborative Experiences with Cisco', 'Hybrid Work', 'Collaboration and Communication', 'Cisco Spark Board', 'Bong Calyan', 'Collaboration Expert', '1/23/2024', '8:00', '19:00');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `participants_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0 = pending\r\n1 = answered\r\n2 = deleted event'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`participants_id`, `event_id`, `email`, `full_name`, `company`, `designation`, `status`) VALUES
(1, 1, 'corbine.santos0206@gmail.com', 'Aljon Layson', 'Company', 'IT DEPT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_recommend`
--

CREATE TABLE `product_recommend` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_recommend`
--

INSERT INTO `product_recommend` (`id`, `event_id`, `email`, `product_name`) VALUES
(1, 1, 'corbine.santos0206@gmail.com', 'Cisco UCS Servers'),
(2, 1, 'corbine.santos0206@gmail.com', 'Viptella');

-- --------------------------------------------------------

--
-- Table structure for table `recommendation`
--

CREATE TABLE `recommendation` (
  `recommend_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `reponse_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `response` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sesion_recommend`
--

CREATE TABLE `sesion_recommend` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `session_title` varchar(255) NOT NULL,
  `participants_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sesion_recommend`
--

INSERT INTO `sesion_recommend` (`id`, `event_id`, `session_title`, `participants_id`) VALUES
(1, 1, 'Power of the Platform: The Key to Retiring More RSW', 1),
(2, 1, 'Cut to the Chase and Bank Your RSW Quota with IoT Control Center', 1),
(3, 1, 'Software Unleashed: Crush Quota with AI-powered Customer Engagement', 1);

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `survey_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `technology_line` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`survey_id`, `comment_id`, `technology_line`) VALUES
(22, 2, 'Data Center and Cloud'),
(23, 2, 'Networking Hardware');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = inactive\r\n1 = active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `status`) VALUES
(1, 'email@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1),
(2, 'testeraccount1@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1),
(3, 'testeraccount2@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_sessions`
--
ALTER TABLE `event_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`participants_id`);

--
-- Indexes for table `product_recommend`
--
ALTER TABLE `product_recommend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD PRIMARY KEY (`recommend_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`reponse_id`);

--
-- Indexes for table `sesion_recommend`
--
ALTER TABLE `sesion_recommend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`survey_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_sessions`
--
ALTER TABLE `event_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participants_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_recommend`
--
ALTER TABLE `product_recommend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recommendation`
--
ALTER TABLE `recommendation`
  MODIFY `recommend_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `reponse_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sesion_recommend`
--
ALTER TABLE `sesion_recommend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `survey_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
