
CREATE TABLE IF NOT EXISTS `#__imagegenerator_images` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `profilename` varchar(50) NOT NULL,
  `width` smallint(6) NOT NULL,
  `height` smallint(6) NOT NULL,
  `background` varchar(6) NOT NULL,
  `fileformat` smallint(6) NOT NULL,
  `fileformatparam` varchar(10) NOT NULL,
  `outputfilename` varchar(255) NOT NULL,


  `options` text,

  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
   
                              
