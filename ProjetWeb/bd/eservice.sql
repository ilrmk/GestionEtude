-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jun 16, 2023 at 07:03 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eservice`
--

-- --------------------------------------------------------

--
-- Table structure for table `departement`
--

CREATE TABLE `departement` (
  `id_dep` int(11) NOT NULL,
  `nom_dep` varchar(100) NOT NULL,
  `descriptif` text NOT NULL,
  `chef_dep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departement`
--

INSERT INTO `departement` (`id_dep`, `nom_dep`, `descriptif`, `chef_dep`) VALUES
(1, 'mathematique-informatique', 'Le département de mathématiques et d\'informatique peut offrir des cours interdisciplinaires tels que la bio-informatique, la modélisation financière, la géomatique, la cryptographie et les systèmes complexes. Les étudiants qui étudient dans ce département peuvent également avoir la possibilité de travailler sur des projets de recherche en collaboration avec des professeurs et des chercheurs, ou de participer à des activités de recherche indépendantes. Les diplômés du département de mathématiques et d\'informatique sont souvent en mesure de trouver du travail dans des industries telles que la finance, la technologie, la recherche et le développement, la cybersécurité, l\'enseignement et les sciences de la vie', 6),
(2, 'physique-chimie', 'Le département de physique et de chimie peut offrir des cours interdisciplinaires tels que la physique-chimie, la chimie physique et biologique, la chimie des nanomatériaux et la chimie verte. Les étudiants qui étudient dans ce département peuvent également avoir la possibilité de travailler sur des projets de recherche en collaboration avec des professeurs et des chercheurs, ou de participer à des activités de recherche indépendantes. Les diplômés du département de physique et de chimie sont souvent en mesure de trouver du travail dans des industries telles que la recherche et le développement, l\'industrie pharmaceutique, l\'industrie pétrochimique, l\'enseignement et les sciences de la vie.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `etudiant`
--

CREATE TABLE `etudiant` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `email` text,
  `idfiliere` int(11) DEFAULT NULL,
  `semestre` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `etudiant`
--

INSERT INTO `etudiant` (`id`, `nom`, `prenom`, `email`, `idfiliere`, `semestre`) VALUES
(111, 'nom1', 'prenom1', 'nom1@gmail.com', 1, 's2');

-- --------------------------------------------------------

--
-- Table structure for table `filiere`
--

CREATE TABLE `filiere` (
  `id_fil` int(11) NOT NULL,
  `nom_fil` varchar(20) NOT NULL,
  `descriptif_fil` text NOT NULL,
  `coordinateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `filiere`
--

INSERT INTO `filiere` (`id_fil`, `nom_fil`, `descriptif_fil`, `coordinateur`) VALUES
(1, 'Genie informatique', 'La filière génie informatique est une formation universitaire qui vise à former des professionnels dans le domaine de l\'informatique. Elle offre une formation pratique et théorique en génie logiciel, programmation, algorithmique, développement d\'applications, intelligence artificielle, cybersécurité, réseaux informatiques, bases de données, conception de systèmes d\'information et gestion de projets informatiques', 1),
(2, 'Genie civile', 'La filière de génie civil est une formation universitaire qui vise à former des professionnels dans le domaine de la construction et de l\'ingénierie. Elle offre une formation théorique et pratique en conception, construction, entretien et réhabilitation d\'infrastructures telles que les routes, les ponts, les tunnels, les barrages, les édifices, les canaux, les voies ferrées et les aéroports', 5),
(3, 'Genie mecanique', 'une nouvelle filiere....', 5),
(4, 'geer', 'oooo', 5),
(46, 'ID', 'kkkkkkkkkkk', 20),
(48, 'gee', 'eeeeeeeeeeee', 5);

-- --------------------------------------------------------

--
-- Table structure for table `jour`
--

CREATE TABLE `jour` (
  `id` int(11) NOT NULL,
  `nom_jour` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jour`
--

INSERT INTO `jour` (`id`, `nom_jour`) VALUES
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi'),
(6, 'Samedi');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id_mod` int(11) NOT NULL,
  `nom_mod` varchar(50) NOT NULL,
  `volume_horaire` int(11) NOT NULL,
  `responsable` int(11) NOT NULL,
  `semestre` varchar(10) NOT NULL,
  `id_fil` int(11) NOT NULL,
  `id_dep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `module`
--

-- --------------------------------------------------------

--
-- Table structure for table `professeur`
--

CREATE TABLE `professeur` (
  `id_prof` int(11) NOT NULL,
  `nom_prof` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_pass` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `specialite` varchar(100) NOT NULL,
  `id_dep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `professeur`
--


-- --------------------------------------------------------

--
-- Table structure for table `seance`
--

CREATE TABLE `seance` (
  `id` int(11) NOT NULL,
  `nom_filiere` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `nom_module` int(11) NOT NULL,
  `nom_prof` int(11) DEFAULT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `jour` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vacataire`
--

CREATE TABLE `vacataire` (
  `id` int(11) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `mail` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vacataire`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id_dep`),
  ADD KEY `chef_dep` (`chef_dep`);

--
-- Indexes for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`id_fil`),
  ADD KEY `coordinateur` (`coordinateur`);

--
-- Indexes for table `jour`
--
ALTER TABLE `jour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id_mod`),
  ADD KEY `responsable` (`responsable`),
  ADD KEY `id_fil` (`id_fil`),
  ADD KEY `id_dep` (`id_dep`);

--
-- Indexes for table `professeur`
--
ALTER TABLE `professeur`
  ADD PRIMARY KEY (`id_prof`),
  ADD KEY `id_dep` (`id_dep`);

--
-- Indexes for table `seance`
--
ALTER TABLE `seance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c7` (`nom_prof`),
  ADD KEY `c8` (`nom_module`),
  ADD KEY `c6` (`nom_filiere`);

--
-- Indexes for table `vacataire`
--
ALTER TABLE `vacataire`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departement`
--
ALTER TABLE `departement`
  MODIFY `id_dep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `id_fil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `jour`
--
ALTER TABLE `jour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id_mod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

--
-- AUTO_INCREMENT for table `professeur`
--
ALTER TABLE `professeur`
  MODIFY `id_prof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `seance`
--
ALTER TABLE `seance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `vacataire`
--
ALTER TABLE `vacataire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departement`
--
ALTER TABLE `departement`
  ADD CONSTRAINT `departement_ibfk_1` FOREIGN KEY (`chef_dep`) REFERENCES `professeur` (`id_prof`);

--
-- Constraints for table `filiere`
--
ALTER TABLE `filiere`
  ADD CONSTRAINT `fk_idprof` FOREIGN KEY (`coordinateur`) REFERENCES `professeur` (`id_prof`);

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_2` FOREIGN KEY (`responsable`) REFERENCES `professeur` (`id_prof`),
  ADD CONSTRAINT `module_ibfk_3` FOREIGN KEY (`id_fil`) REFERENCES `filiere` (`id_fil`),
  ADD CONSTRAINT `module_ibfk_4` FOREIGN KEY (`id_dep`) REFERENCES `departement` (`id_dep`);

--
-- Constraints for table `professeur`
--
ALTER TABLE `professeur`
  ADD CONSTRAINT `fk_iddep` FOREIGN KEY (`id_dep`) REFERENCES `departement` (`id_dep`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
