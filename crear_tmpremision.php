<?php

     $sqlmaster = "CREATE TABLE IF NOT EXISTS ".$global[7]." (
		  `cod_fac` int(11) NOT NULL auto_increment,
		  `cod_usu` int(11) default NULL,
		  `cod_cli` int(11) default NULL,
		  `cod_bod` int(11) default NULL,
		  `fecha` date default NULL,
		  `num_fac` int(11) NOT NULL default '0',
		  `obs` text,
		  `tipo_fac` varchar(50) default NULL,
		  `bod_cli_fac` int(11) default NULL,
		  `rem_fac` varchar(50) default NULL,
		  `cod_razon_fac` int(11) default NULL,
		  `tipo_pago` varchar(50) default NULL,
		  `estado` varchar(50) default NULL,
		  `tot_fac` varchar(10) character set utf8 collate utf8_spanish2_ci default NULL,
		  `tot_dev_mfac` int(11) NOT NULL,
		  PRIMARY KEY  (`cod_fac`,`num_fac`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=56 AUTO_INCREMENT=1 ;";

     $sqldetail = "CREATE TABLE IF NOT EXISTS ".$global[8]." (
		  `cod_dfac` int(11) NOT NULL auto_increment,
		  `cod_mfac` int(11) default NULL,
		  `cod_tpro` int(10) unsigned default NULL COMMENT 'codigo tipo de producto',
		  `cod_cat` int(10) unsigned default NULL COMMENT 'codigo categoria',
		  `cod_peso` int(10) unsigned default NULL COMMENT 'codigo peso o talla',
		  `cod_pro` int(11) default NULL,
		  `cod_bod` int(11) NOT NULL,
		  `disponible` varchar(11) character set latin1 NOT NULL,
		  `cant_pro` varchar(11) character set latin1 default NULL,
		  `val_uni` varchar(11) collate utf8_spanish2_ci default NULL,
		  `total_pro` varchar(11) character set latin1 default NULL,
		  `serial` int(11) NOT NULL,
		  PRIMARY KEY  (`cod_dfac`),
		  KEY `serial` (`serial`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;";
        $dbb = new Database();
	$dbb->query($sqlmaster);
	$dbb->query($sqldetail);
	$dbb->close();
	

?>