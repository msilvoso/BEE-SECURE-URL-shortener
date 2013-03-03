SET NAMES utf8;

--
-- Table structure for table `flags`
--

DROP TABLE IF EXISTS `flags`;
CREATE TABLE `flags` (
  `flag` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`flag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `urls`
--

DROP TABLE IF EXISTS `urls`;
CREATE TABLE `urls` (
  `short_url` varchar(255) NOT NULL DEFAULT '',
  `long_url` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `referrals` int(11) DEFAULT '0',
  PRIMARY KEY (`short_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
