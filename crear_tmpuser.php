<?php
    //SE CREAN TABLAS MAESTRO Y DETALLES ENTRADA INVENTARIO USUARIOS
	$sqlcreate = "CREATE TABLE IF NOT EXISTS ".$global[5]." (
		  `cod_ment` int(11) NOT NULL auto_increment,
		  `cod_usu` int(11) NOT NULL,
		  `fechahora` timestamp NOT NULL default CURRENT_TIMESTAMP,
		  `fec_ment` date default NULL COMMENT 'fecha de la entrada',
		  `fac_ment` bigint(50) default NULL COMMENT 'factura de la entrada',
		  `obs_ment` varchar(250) default NULL COMMENT 'observacion',
		  `cod_bod` int(11) default NULL COMMENT 'codigo bodega',
		  `total_ment` varchar(11) default NULL,
		  `cod_prove_ment` int(11) default NULL COMMENT 'codigo del proveedor',
		  `usu_ment` int(11) NOT NULL,
		  `est_ment` varchar(20) NOT NULL COMMENT 'estado en la cartera',
		  `sal_ant_ment` int(11) NOT NULL COMMENT 'saldo anterior',
		  `remision` int(1) NOT NULL default '1',
		  PRIMARY KEY  (`cod_ment`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=44 AUTO_INCREMENT=1 ;";
	$ssqldetail = "CREATE TABLE IF NOT EXISTS ".$global[6]." (
		  `cod_dent` int(11) NOT NULL auto_increment,
		  `cod_ment_dent` int(11) default NULL,
		  `cod_tpro_dent` int(11) default NULL COMMENT 'tipo de producto',
		  `cod_mar_dent` int(11) default NULL COMMENT 'marca',
		  `cod_pes_dent` int(11) default NULL COMMENT 'peso empaque',
		  `cod_ref_dent` int(11) default NULL,
		  `cant_dent` varchar(11) default NULL COMMENT 'cantidad',
		  `cos_dent` varchar(11) default NULL COMMENT 'costo',
		  `cod_serial` int(11) NOT NULL,
		  `bandera` int(1) NOT NULL,
		  `fechahora` timestamp NOT NULL default CURRENT_TIMESTAMP,
		  `num_remision` bigint(11) NOT NULL,
		  PRIMARY KEY  (`cod_dent`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
         	$dbb = new Database();
		$dbb->query($sqlcreate);
		$dbb->query($ssqldetail);
	    $dbb->close();
?>