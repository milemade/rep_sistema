-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 24-03-2012 a las 08:31:54
-- Versión del servidor: 5.0.45
-- Versión de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `facturacion`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `abono`
-- 

DROP TABLE IF EXISTS `abono`;
CREATE TABLE `abono` (
  `cod_abo` int(11) NOT NULL auto_increment,
  `cod_bod_Abo` int(11) default NULL,
  `val_abo` int(11) default NULL,
  `cod_usu_abo` int(11) default NULL,
  `fec_abo` date default NULL,
  `saldo` int(11) default NULL,
  `observacion` longtext,
  `anotacion` longtext,
  `cod_rso_abo` int(11) default NULL,
  `efec_abo` int(11) NOT NULL COMMENT 'valor efectivo',
  `cheq_abo` int(11) NOT NULL COMMENT 'valor cheque',
  PRIMARY KEY  (`cod_abo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=2508 AUTO_INCREMENT=370 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `abono_pago`
-- 

DROP TABLE IF EXISTS `abono_pago`;
CREATE TABLE `abono_pago` (
  `cod_abo` int(11) NOT NULL auto_increment,
  `cod_bod_Abo` int(11) default NULL COMMENT 'codigo proveedor',
  `val_abo` int(11) default NULL,
  `cod_usu_abo` int(11) default NULL,
  `fec_abo` date default NULL,
  `saldo` int(11) default NULL,
  `observacion` longtext,
  `anotacion` longtext,
  `cod_rso_abo` int(11) default NULL,
  PRIMARY KEY  (`cod_abo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=2732 AUTO_INCREMENT=130 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `ajuste`
-- 

DROP TABLE IF EXISTS `ajuste`;
CREATE TABLE `ajuste` (
  `cod_aju` int(11) NOT NULL auto_increment,
  `cod_tpro_aju` int(11) default NULL,
  `cod_mar_aju` int(11) default NULL,
  `cod_pes_aju` int(11) default NULL,
  `cod_ref_aju` int(11) default NULL,
  `cod_bod_aju` int(11) default NULL,
  `cod_fry_aju` varchar(50) default NULL,
  `fec_aju` date default NULL,
  `cant_aju` int(11) default NULL,
  `obs_aju` text,
  `cod_rso_abo` int(11) NOT NULL,
  PRIMARY KEY  (`cod_aju`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `asignacion`
-- 

DROP TABLE IF EXISTS `asignacion`;
CREATE TABLE `asignacion` (
  `cod_asi` int(11) NOT NULL auto_increment,
  `cod_ven_asi` int(11) default NULL,
  `cod_rut_asi` varchar(50) default NULL,
  PRIMARY KEY  (`cod_asi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `auditoria`
-- 

DROP TABLE IF EXISTS `auditoria`;
CREATE TABLE `auditoria` (
  `cod_aud` int(11) NOT NULL auto_increment,
  `cod_usu_aud` int(11) default NULL,
  `nom_tab_aud` char(100) default NULL,
  `fec_aud` datetime default NULL,
  `transaccion` int(11) default NULL,
  `cod_pro` int(11) default NULL,
  PRIMARY KEY  (`cod_aud`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20241 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `bodega`
-- 

DROP TABLE IF EXISTS `bodega`;
CREATE TABLE `bodega` (
  `cod_bod` int(11) NOT NULL auto_increment,
  `nom_bod` varchar(50) default NULL,
  `cod_res` int(11) default NULL COMMENT 'codigo del responable de la bodega pero esta en la tabla personal',
  `cod_rso_bod` int(10) unsigned default NULL,
  `cod_bod_cli` int(11) NOT NULL,
  PRIMARY KEY  (`cod_bod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=331 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `bodega1`
-- 

DROP TABLE IF EXISTS `bodega1`;
CREATE TABLE `bodega1` (
  `cod_bod` int(11) NOT NULL auto_increment,
  `nom_bod` varchar(200) default NULL,
  `max_cos_bod` int(11) default NULL,
  `tipo_bod` int(11) default NULL,
  `iden_bod` varchar(50) default NULL,
  `dir_bod` varchar(50) default NULL,
  `tel_bod` varchar(50) default NULL,
  `ciu_bod` varchar(50) default NULL,
  `mail_bod` varchar(50) default NULL,
  `propia` int(11) default NULL,
  `cod_lista` int(11) default NULL,
  `dias_traslado` int(11) NOT NULL,
  `dias_credito` int(11) NOT NULL,
  `cod_covinoc` varchar(50) default NULL,
  `fec_covinoc` date default NULL,
  `cupo_au_covinoc` int(11) default NULL,
  `cupo_traslados` varchar(50) default NULL,
  `cod_bod_cli` int(11) NOT NULL,
  PRIMARY KEY  (`cod_bod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cargo`
-- 

DROP TABLE IF EXISTS `cargo`;
CREATE TABLE `cargo` (
  `cod_car` int(11) NOT NULL auto_increment,
  `des_car` varchar(100) default NULL,
  `desc_car` varchar(230) default NULL,
  `cod_proy` int(11) default NULL,
  PRIMARY KEY  (`cod_car`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cartera_compras`
-- 

DROP TABLE IF EXISTS `cartera_compras`;
CREATE TABLE `cartera_compras` (
  `cod_ccom` int(11) NOT NULL auto_increment COMMENT 'codigo de la cartera',
  `cod_doc_ccom` int(11) NOT NULL COMMENT 'codigo del documento',
  `cod_tdoc_ccom` int(11) NOT NULL COMMENT 'codigo tipo documento',
  `fec_ccom` date NOT NULL COMMENT 'fecha del documento',
  `val_ccom` varchar(11) NOT NULL COMMENT 'valor del documento',
  `cod_pro_ccom` int(11) NOT NULL COMMENT 'codigo del proveedor',
  PRIMARY KEY  (`cod_ccom`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1418 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cartera_factura`
-- 

DROP TABLE IF EXISTS `cartera_factura`;
CREATE TABLE `cartera_factura` (
  `cod_car_fac` int(11) NOT NULL auto_increment,
  `fec_car_fac` date default NULL,
  `cod_fac` int(11) default NULL,
  `tipo_car` int(11) default NULL,
  `estado_car` varchar(50) default '0',
  `valor_abono` int(11) default '0',
  `num_abono` text,
  `obs_abono` text,
  PRIMARY KEY  (`cod_car_fac`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=54 AUTO_INCREMENT=620 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `clientes`
-- 

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL auto_increment,
  `nombre` varchar(30) default NULL,
  PRIMARY KEY  (`id_cliente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cliente_credito`
-- 

DROP TABLE IF EXISTS `cliente_credito`;
CREATE TABLE `cliente_credito` (
  `cod_clic` int(11) NOT NULL auto_increment COMMENT 'codigo de cliente con credito',
  `nom_clic` varchar(200) default NULL,
  `dir_lic` varchar(200) default NULL,
  `tel_clic` varchar(200) default NULL,
  PRIMARY KEY  (`cod_clic`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `denominacion`
-- 

DROP TABLE IF EXISTS `denominacion`;
CREATE TABLE `denominacion` (
  `cod_den` int(11) NOT NULL auto_increment,
  `nom_den` int(11) default NULL,
  `tipo_mon_den` varchar(50) default NULL COMMENT 'si es moneda o billete',
  PRIMARY KEY  (`cod_den`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `dentradatemp`
-- 

DROP TABLE IF EXISTS `dentradatemp`;
CREATE TABLE `dentradatemp` (
  `cod_dent` int(11) NOT NULL auto_increment,
  `cod_ment_dent` int(11) default NULL,
  `cod_tpro_dent` int(11) default NULL COMMENT 'tipo de producto',
  `cod_mar_dent` int(11) default NULL COMMENT 'marca',
  `cod_pes_dent` int(11) default NULL COMMENT 'peso empaque',
  `cod_ref_dent` int(11) default NULL,
  `cod_serial` int(11) NOT NULL COMMENT 'Serial suministrado por el cliente',
  `cant_dent` varchar(30) default NULL COMMENT 'cantidad',
  `cos_dent` int(11) default NULL COMMENT 'costo',
  PRIMARY KEY  (`cod_dent`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `det_lista`
-- 

DROP TABLE IF EXISTS `det_lista`;
CREATE TABLE `det_lista` (
  `cod_lista` int(11) default NULL,
  `cod_pro` int(11) default NULL,
  `pre_reg` int(11) default NULL,
  `pre_list` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `documento`
-- 

DROP TABLE IF EXISTS `documento`;
CREATE TABLE `documento` (
  `cod_doc` int(11) NOT NULL auto_increment,
  `nom_doc` varchar(50) default NULL,
  PRIMARY KEY  (`cod_doc`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `dremitem`
-- 

DROP TABLE IF EXISTS `dremitem`;
CREATE TABLE `dremitem` (
  `cod_dfac` int(11) NOT NULL auto_increment,
  `cod_mfac` int(11) default NULL,
  `cod_tpro` int(10) unsigned default NULL COMMENT 'codigo tipo de producto',
  `cod_cat` int(10) unsigned default NULL COMMENT 'codigo categoria',
  `cod_peso` int(10) unsigned default NULL COMMENT 'codigo peso o talla',
  `cod_pro` int(11) default NULL,
  `cod_bod` int(11) NOT NULL,
  `disponible` varchar(11) NOT NULL,
  `cant_pro` varchar(11) default NULL,
  `val_uni` varchar(11) character set utf8 collate utf8_spanish2_ci default NULL,
  `total_pro` varchar(11) default NULL,
  `serial` int(11) NOT NULL,
  PRIMARY KEY  (`cod_dfac`),
  KEY `serial` (`serial`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_cargue`
-- 

DROP TABLE IF EXISTS `d_cargue`;
CREATE TABLE `d_cargue` (
  `cod_dcarg` int(11) NOT NULL auto_increment,
  `cod_mcarg` int(11) default NULL,
  `cod_prod_dcarg` int(11) default NULL,
  `cant_dcarg` int(11) default NULL,
  `pventa_dcarg` int(11) default NULL,
  `total_desc_dcarg` int(11) default NULL,
  `pcomp_dcarg` int(11) default NULL,
  `iva_dcarg` int(11) default NULL,
  `subtotal_dcarg` int(11) default NULL,
  PRIMARY KEY  (`cod_dcarg`),
  KEY `d_carges_ibfk_2` (`cod_mcarg`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_cartera_compras`
-- 

DROP TABLE IF EXISTS `d_cartera_compras`;
CREATE TABLE `d_cartera_compras` (
  `cod_dcc` int(11) NOT NULL auto_increment,
  `cod_car_ccom_dcc` int(11) NOT NULL COMMENT 'codigo maestra cartera compras',
  `cod_abo_dcc` int(11) NOT NULL COMMENT 'codigo del abono',
  PRIMARY KEY  (`cod_dcc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_cheque_venta`
-- 

DROP TABLE IF EXISTS `d_cheque_venta`;
CREATE TABLE `d_cheque_venta` (
  `cod_cheq_dvch` int(11) NOT NULL auto_increment COMMENT 'codigo cheque del detalle de la venta',
  `cod_mven_dvch` int(11) default NULL,
  `num_cheq_dvch` varchar(30) default NULL COMMENT 'numero',
  `val_cheq_dvch` int(11) default NULL COMMENT 'valor del cheque',
  `ban_cheq_dvch` varchar(50) default NULL COMMENT 'banco',
  PRIMARY KEY  (`cod_cheq_dvch`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_cobro_venta`
-- 

DROP TABLE IF EXISTS `d_cobro_venta`;
CREATE TABLE `d_cobro_venta` (
  `cod_cob_dvco` int(11) NOT NULL auto_increment COMMENT 'codigo del cobro',
  `cod_mven_dvco` int(11) default NULL COMMENT 'codigo de la maestra de venta',
  `cod_cli_dvco` int(11) default NULL COMMENT 'cliente al q se le cobra',
  `val_cob_dvco` int(11) default NULL,
  `fac_cob_dvco` varchar(50) default NULL COMMENT 'factura',
  `val_desc_dvco` int(11) default NULL,
  PRIMARY KEY  (`cod_cob_dvco`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_comision`
-- 

DROP TABLE IF EXISTS `d_comision`;
CREATE TABLE `d_comision` (
  `cod_com` int(11) NOT NULL auto_increment,
  `val_min_com` int(11) default NULL COMMENT 'valor inicio de comision',
  `val_max_com` int(11) default NULL,
  `val_com` int(11) default NULL,
  `cod_m_com` varchar(50) default NULL COMMENT 'codigo de la maestra',
  PRIMARY KEY  (`cod_com`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_consignacion_venta`
-- 

DROP TABLE IF EXISTS `d_consignacion_venta`;
CREATE TABLE `d_consignacion_venta` (
  `cod_cons_dvcon` int(11) NOT NULL auto_increment COMMENT 'codigo de consignacion',
  `cod_mven_dvcon` int(11) default NULL COMMENT 'codigo maestro',
  `banco_dvcon` varchar(50) default NULL COMMENT 'nombre del banco',
  `cod_doc_dvcon` int(11) default NULL COMMENT 'numero de consignacion',
  `val_consig_dvcon` int(11) default NULL COMMENT 'valor consignacion',
  PRIMARY KEY  (`cod_cons_dvcon`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_credito_venta`
-- 

DROP TABLE IF EXISTS `d_credito_venta`;
CREATE TABLE `d_credito_venta` (
  `cod_cred_dvcr` int(11) NOT NULL auto_increment COMMENT 'codigo  credito detalle de venta',
  `cod_mven_dvcr` int(11) default NULL COMMENT 'codigo de la maestra de venta',
  `cod_cli_dvcr` int(11) default NULL COMMENT 'codigo cliente',
  `val_cred_dvcr` int(11) default NULL COMMENT 'valor del credito',
  `fac_cred_dvcr` varchar(50) default NULL COMMENT 'numero de factura ',
  PRIMARY KEY  (`cod_cred_dvcr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_devolucion`
-- 

DROP TABLE IF EXISTS `d_devolucion`;
CREATE TABLE `d_devolucion` (
  `cod_ddev` int(11) NOT NULL auto_increment COMMENT 'codigo del detalle',
  `cod_mdev` int(11) default NULL COMMENT 'codigo de la maestra de la devolucion',
  `cod_mfac_dev` int(11) default NULL COMMENT 'codigo de la maestra de la factura',
  `cod_dfac_dev` int(11) default NULL COMMENT 'codigo del detalle de la factura',
  `cod_prod_ddev` int(11) default NULL COMMENT 'codigo del producto',
  `cod_pes_ddev` int(11) default NULL COMMENT 'codigo de la talla',
  `cant_fac_dev` int(11) default NULL COMMENT 'cantidad facturada original',
  `val_fac` int(11) default NULL COMMENT 'valor del producto facturado',
  `cant_ddev` int(11) default NULL COMMENT 'cantidad de la devolucion',
  `pventa_ddev` int(11) default NULL COMMENT 'valor de venta',
  `total_ddev` int(11) default NULL COMMENT 'total de produco',
  `iva_ddev` int(11) default NULL COMMENT 'valor del iva',
  PRIMARY KEY  (`cod_ddev`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_dev_entrada`
-- 

DROP TABLE IF EXISTS `d_dev_entrada`;
CREATE TABLE `d_dev_entrada` (
  `cod_ddent` int(11) NOT NULL auto_increment,
  `cod_ment_ddent` int(11) default NULL,
  `cod_tpro_ddent` int(11) default NULL COMMENT 'tipo de producto',
  `cod_mar_ddent` int(11) default NULL COMMENT 'marca',
  `cod_pes_ddent` int(11) default NULL COMMENT 'peso empaque',
  `cod_ref_ddent` int(11) default NULL,
  `cant_ddent` int(11) default NULL COMMENT 'cantidad',
  `cos_ddent` int(11) default NULL COMMENT 'costo',
  PRIMARY KEY  (`cod_ddent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_efectivo_venta`
-- 

DROP TABLE IF EXISTS `d_efectivo_venta`;
CREATE TABLE `d_efectivo_venta` (
  `cod_efe_dvef` int(11) NOT NULL auto_increment COMMENT 'codigo del efectivo',
  `cod_mven_dvef` int(11) default NULL COMMENT 'detalle de la maestra de venta',
  `cod_den_dvef` int(11) default NULL COMMENT 'codigo denominacion de moneda',
  `nom_den_dvef` int(11) default NULL COMMENT 'nombre denominacion',
  `cant_dvef` int(11) default NULL COMMENT 'cantidad por moneda',
  `val_dvef` int(11) default NULL COMMENT 'valor del efectivo ',
  PRIMARY KEY  (`cod_efe_dvef`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_entrada`
-- 

DROP TABLE IF EXISTS `d_entrada`;
CREATE TABLE `d_entrada` (
  `cod_dent` int(11) NOT NULL auto_increment,
  `cod_ment_dent` int(11) default NULL,
  `cod_tpro_dent` int(11) default NULL COMMENT 'tipo de producto',
  `cod_mar_dent` int(11) default NULL COMMENT 'marca',
  `cod_pes_dent` int(11) default NULL COMMENT 'peso empaque',
  `cod_ref_dent` int(11) default NULL,
  `cant_dent` varchar(11) default NULL COMMENT 'cantidad',
  `cos_dent` varchar(11) default NULL COMMENT 'costo',
  `cod_serial` int(11) NOT NULL,
  PRIMARY KEY  (`cod_dent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7597 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_factura`
-- 

DROP TABLE IF EXISTS `d_factura`;
CREATE TABLE `d_factura` (
  `cod_dfac` int(11) NOT NULL auto_increment,
  `cod_mfac` int(11) default NULL,
  `cod_tpro` int(10) unsigned default NULL COMMENT 'codigo tipo de producto',
  `cod_cat` int(10) unsigned default NULL COMMENT 'codigo categoria',
  `cod_peso` int(10) unsigned default NULL COMMENT 'codigo peso o talla',
  `cod_pro` int(11) default NULL,
  `cant_pro` varchar(11) default NULL,
  `val_uni` int(11) default NULL,
  `total_pro` varchar(11) default NULL,
  PRIMARY KEY  (`cod_dfac`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=626 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_gastos_venta`
-- 

DROP TABLE IF EXISTS `d_gastos_venta`;
CREATE TABLE `d_gastos_venta` (
  `cod_gas_dvga` int(11) NOT NULL auto_increment COMMENT 'codigo del gasto',
  `cod_mven_dvga` int(11) default NULL COMMENT 'codigo maestro',
  `cod_doc_dvga` int(11) default NULL COMMENT 'codigo del gasto',
  `val_gas_dvga` int(11) default NULL COMMENT 'valor del gasto',
  PRIMARY KEY  (`cod_gas_dvga`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_invetario`
-- 

DROP TABLE IF EXISTS `d_invetario`;
CREATE TABLE `d_invetario` (
  `cod_dinv` int(11) NOT NULL auto_increment,
  `cod_minv` int(11) default NULL,
  `cod_prod_dinv` int(11) default NULL,
  `cant_dinv` int(11) default NULL,
  `pventa_dinv` int(11) default NULL,
  `pcomp_dinv` int(11) default NULL,
  `iva_dinv` int(11) default NULL,
  `total_dinv` int(11) default NULL,
  PRIMARY KEY  (`cod_dinv`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_remision`
-- 

DROP TABLE IF EXISTS `d_remision`;
CREATE TABLE `d_remision` (
  `cod_dfac` int(11) NOT NULL auto_increment,
  `cod_mfac` int(11) default NULL,
  `cod_tpro` int(10) unsigned default NULL COMMENT 'codigo tipo de producto',
  `cod_cat` int(10) unsigned default NULL COMMENT 'codigo categoria',
  `cod_peso` int(10) unsigned default NULL COMMENT 'codigo peso o talla',
  `cod_pro` int(11) default NULL,
  `cod_bod` int(11) NOT NULL,
  `disponible` varchar(11) NOT NULL,
  `cant_pro` varchar(11) default NULL,
  `val_uni` varchar(11) character set utf8 collate utf8_spanish2_ci default NULL,
  `total_pro` varchar(11) default NULL,
  `serial` int(11) NOT NULL,
  PRIMARY KEY  (`cod_dfac`),
  KEY `serial` (`serial`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=685 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `d_traslado`
-- 

DROP TABLE IF EXISTS `d_traslado`;
CREATE TABLE `d_traslado` (
  `cod_dtra` int(11) NOT NULL auto_increment,
  `cod_mtras_dtra` int(11) default NULL COMMENT 'campo del maestro traslado',
  `cod_tpro_dtra` int(11) default NULL COMMENT 'tipo de producto',
  `cod_mar_dtra` int(11) default NULL COMMENT 'marca',
  `cod_pes_dtra` int(11) default NULL COMMENT 'peso empaque',
  `cod_ref_dtra` int(11) default NULL COMMENT 'codigo referencia',
  `cant_dtra` int(11) default NULL COMMENT 'cantidad',
  `serial` int(11) NOT NULL,
  PRIMARY KEY  (`cod_dtra`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `empresa`
-- 

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `cod_emp` int(11) NOT NULL auto_increment,
  `nom_emp` varchar(50) default NULL,
  PRIMARY KEY  (`cod_emp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `festivo`
-- 

DROP TABLE IF EXISTS `festivo`;
CREATE TABLE `festivo` (
  `cod_fes` int(11) NOT NULL auto_increment,
  `fec_fes` date default NULL,
  PRIMARY KEY  (`cod_fes`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `gastos`
-- 

DROP TABLE IF EXISTS `gastos`;
CREATE TABLE `gastos` (
  `cod_gas` int(11) NOT NULL auto_increment COMMENT 'codigo de gasto',
  `fec_gas` date default NULL,
  `nom_gas` varchar(50) default NULL COMMENT 'nombre del gasto',
  `val_gas` int(11) default NULL COMMENT 'valor de gasto',
  `obs_gas` text COMMENT 'obsevacio del gasto',
  PRIMARY KEY  (`cod_gas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

-- 
-- Estructura Stand-in para la vista `infinventario`
-- 
CREATE TABLE `infinventario` (
`nom_bod` varchar(50)
,`nom_mar` varchar(250)
,`nom_tpro` varchar(50)
,`nom_pro` varchar(50)
,`cod_fry_pro` varchar(50)
,`serial` bigint(11)
,`nom_pes` varchar(250)
,`totalcan` double
,`valor_precio` int(11)
,`totalpre` double
);
-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `interfaz`
-- 

DROP TABLE IF EXISTS `interfaz`;
CREATE TABLE `interfaz` (
  `cod_int` int(11) NOT NULL auto_increment,
  `nom_int` char(100) default NULL,
  `rut_int` char(200) default NULL,
  `cod_mod_int` int(11) default NULL,
  `cod_per` int(11) default NULL,
  PRIMARY KEY  (`cod_int`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `items`
-- 

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `cod_items` int(11) NOT NULL auto_increment,
  `nombre_items` varchar(200) NOT NULL,
  `codigo_items` varchar(30) NOT NULL,
  PRIMARY KEY  (`cod_items`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `kardex`
-- 

DROP TABLE IF EXISTS `kardex`;
CREATE TABLE `kardex` (
  `cod_kar` int(11) NOT NULL auto_increment,
  `cod_ref_kar` int(11) default NULL,
  `cod_bod_kar` int(11) default NULL,
  `cant_ref_kar` varchar(11) default NULL,
  `valor_precio` int(11) default NULL,
  `cod_talla` int(11) unsigned default NULL,
  `serial` int(11) NOT NULL,
  PRIMARY KEY  (`cod_kar`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6246 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `listaprecio`
-- 

DROP TABLE IF EXISTS `listaprecio`;
CREATE TABLE `listaprecio` (
  `cos_list` int(11) NOT NULL auto_increment,
  `nom_list` varchar(50) default NULL,
  PRIMARY KEY  (`cos_list`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `marca`
-- 

DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca` (
  `cod_mar` int(11) NOT NULL auto_increment,
  `nom_mar` varchar(250) default NULL COMMENT 'nombre marca',
  `desc_mar` varchar(250) default NULL,
  PRIMARY KEY  (`cod_mar`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `mentradatemp`
-- 

DROP TABLE IF EXISTS `mentradatemp`;
CREATE TABLE `mentradatemp` (
  `cod_ment` int(11) NOT NULL auto_increment,
  `fec_ment` date default NULL COMMENT 'fecha de la entrada',
  `remision` int(1) NOT NULL COMMENT 'Bandera Remision',
  `fac_ment` varchar(50) default NULL COMMENT 'factura de la entrada',
  `obs_ment` varchar(250) default NULL COMMENT 'observacion',
  `cod_bod` int(11) default NULL COMMENT 'codigo bodega',
  `total_ment` int(11) default NULL,
  `cod_prove_ment` int(11) default NULL COMMENT 'codigo del proveedor',
  `usu_ment` int(11) NOT NULL,
  `est_ment` varchar(20) NOT NULL COMMENT 'estado en la cartera',
  `sal_ant_ment` int(11) NOT NULL COMMENT 'saldo anterior',
  PRIMARY KEY  (`cod_ment`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=44 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `meses`
-- 

DROP TABLE IF EXISTS `meses`;
CREATE TABLE `meses` (
  `cod_mes` int(11) NOT NULL,
  `nom_mes` varchar(20) NOT NULL,
  PRIMARY KEY  (`cod_mes`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `modulos`
-- 

DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos` (
  `cod_mod` int(11) NOT NULL auto_increment,
  `nom_mod` char(20) default NULL,
  PRIMARY KEY  (`cod_mod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `mremitemp`
-- 

DROP TABLE IF EXISTS `mremitemp`;
CREATE TABLE `mremitemp` (
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
  PRIMARY KEY  (`cod_fac`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=56 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_cargue`
-- 

DROP TABLE IF EXISTS `m_cargue`;
CREATE TABLE `m_cargue` (
  `cod_carg` int(11) NOT NULL auto_increment,
  `cod_ven_carg` int(11) default NULL COMMENT 'codigo vendedor',
  `cod_rut_carg` int(11) default NULL COMMENT 'ruta del vendedor',
  `fec_carg` date default NULL,
  `total_saldo_carg` int(11) default NULL COMMENT 'total de la compra sin iva',
  `net_comp_carg` int(11) default NULL COMMENT 'neto costo',
  `iva_comp_carg` int(11) default NULL COMMENT 'iva del producto',
  `total_comp_carg` int(11) default NULL COMMENT 'total del costo con iva',
  `obs_carg` longtext,
  `num_fac` varchar(50) default NULL,
  `jornada` varchar(50) default NULL,
  `total_factura` varchar(50) default NULL,
  `iva_16` int(11) NOT NULL,
  `iva_10` int(11) NOT NULL,
  `pagado` varchar(50) default '0' COMMENT 'estado del pago en cartera',
  `cod_car_pag` int(11) default '0' COMMENT 'codigo de documento de pago en cartera',
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY  (`cod_carg`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_comisiones`
-- 

DROP TABLE IF EXISTS `m_comisiones`;
CREATE TABLE `m_comisiones` (
  `cod_tabla` int(11) NOT NULL auto_increment,
  `nom_tabla` varchar(50) default NULL,
  PRIMARY KEY  (`cod_tabla`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_devolucion`
-- 

DROP TABLE IF EXISTS `m_devolucion`;
CREATE TABLE `m_devolucion` (
  `cod_dev` int(11) NOT NULL auto_increment,
  `fec_dev` date default NULL COMMENT 'fecha de la devolucion',
  `cod_bod_dev` int(11) default NULL COMMENT 'codigo de la bodega',
  `num_fac_dev` int(11) default NULL COMMENT 'numero de factura',
  `val_del` int(11) default NULL COMMENT 'valor total de la devolucion',
  `cod_ven_dev` int(11) default NULL COMMENT 'codigo vendedor',
  `obs_dev` longtext COMMENT 'obsrvacion',
  PRIMARY KEY  (`cod_dev`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=32 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_dev_entrada`
-- 

DROP TABLE IF EXISTS `m_dev_entrada`;
CREATE TABLE `m_dev_entrada` (
  `cod_mdent` int(11) NOT NULL auto_increment,
  `fec_mdent` date NOT NULL,
  `fac_mdent` char(20) NOT NULL,
  `obs_mdent` text NOT NULL,
  `cod_bod` int(11) NOT NULL,
  `total_mdent` int(11) NOT NULL,
  `cod_prove_mdent` int(11) NOT NULL,
  PRIMARY KEY  (`cod_mdent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_entrada`
-- 

DROP TABLE IF EXISTS `m_entrada`;
CREATE TABLE `m_entrada` (
  `cod_ment` int(11) NOT NULL auto_increment,
  `fec_ment` date default NULL COMMENT 'fecha de la entrada',
  `fac_ment` varchar(50) default NULL COMMENT 'factura de la entrada',
  `obs_ment` varchar(250) default NULL COMMENT 'observacion',
  `cod_bod` int(11) default NULL COMMENT 'codigo bodega',
  `total_ment` varchar(11) default NULL,
  `cod_prove_ment` int(11) default NULL COMMENT 'codigo del proveedor',
  `usu_ment` int(11) NOT NULL,
  `est_ment` varchar(20) NOT NULL COMMENT 'estado en la cartera',
  `sal_ant_ment` int(11) NOT NULL COMMENT 'saldo anterior',
  `remision` int(1) NOT NULL,
  PRIMARY KEY  (`cod_ment`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=44 AUTO_INCREMENT=2380 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_factura`
-- 

DROP TABLE IF EXISTS `m_factura`;
CREATE TABLE `m_factura` (
  `cod_fac` int(11) NOT NULL auto_increment,
  `cod_usu` int(11) default NULL,
  `cod_cli` int(11) default NULL,
  `cod_bod` int(11) default NULL,
  `fecha` date default NULL,
  `num_fac` char(25) default NULL,
  `obs` text,
  `tipo_fac` varchar(50) default NULL,
  `bod_cli_fac` int(11) default NULL,
  `rem_fac` varchar(50) default NULL,
  `cod_razon_fac` int(11) default NULL,
  `tipo_pago` varchar(50) default NULL,
  `estado` varchar(50) default NULL,
  `tot_fac` varchar(10) default NULL,
  `tot_dev_mfac` int(11) NOT NULL,
  PRIMARY KEY  (`cod_fac`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=56 AUTO_INCREMENT=628 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_inventario`
-- 

DROP TABLE IF EXISTS `m_inventario`;
CREATE TABLE `m_inventario` (
  `cod_inv` int(11) NOT NULL auto_increment,
  `cod_ven_inv` int(11) default NULL COMMENT 'codigo vendedor',
  `cod_rut_inv` int(11) default NULL COMMENT 'ruta del vendedor',
  `fec_inv` date default NULL,
  `total_saldo_inv` int(11) default NULL COMMENT 'total de la compra sin iva',
  `net_comp_inv` int(11) default NULL COMMENT 'neto costo',
  `iva_comp_inv` int(11) default NULL COMMENT 'iva del producto',
  `total_comp_inv` int(11) default NULL COMMENT 'total del costo con iva',
  `obs_inv` longtext,
  `ini_cont_inv` varchar(50) default NULL COMMENT 'tipo de invetario 1 para inicial 0 para controlar',
  `jorn_inv` varchar(50) default NULL COMMENT 'jornada',
  PRIMARY KEY  (`cod_inv`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_pago_cartera`
-- 

DROP TABLE IF EXISTS `m_pago_cartera`;
CREATE TABLE `m_pago_cartera` (
  `cod_pag` int(11) NOT NULL auto_increment,
  `che_pag` varchar(200) default NULL COMMENT 'cheque para el pago',
  `obs_pag` text,
  `fec_pag` date default NULL,
  `val_pag` int(11) default NULL,
  PRIMARY KEY  (`cod_pag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_remision`
-- 

DROP TABLE IF EXISTS `m_remision`;
CREATE TABLE `m_remision` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=56 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_traslado`
-- 

DROP TABLE IF EXISTS `m_traslado`;
CREATE TABLE `m_traslado` (
  `cod_tras` int(11) NOT NULL auto_increment,
  `cod_bod_sal_tras` int(11) default NULL COMMENT 'codigo vendedor q entrega',
  `cod_bod_ent_tras` int(11) default NULL COMMENT 'codigo vendedor q recibe',
  `fec_tras` date default NULL,
  `total_saldo_tras` int(11) default NULL COMMENT 'total de la compra sin iva',
  `net_comp_tras` int(11) default NULL COMMENT 'neto costo',
  `iva_comp_tras` int(11) default NULL COMMENT 'iva del producto',
  `total_comp_tras` int(11) default NULL COMMENT 'total del costo con iva',
  `obs_tras` longtext,
  `cod_usu_tras` int(11) NOT NULL,
  PRIMARY KEY  (`cod_tras`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `m_venta`
-- 

DROP TABLE IF EXISTS `m_venta`;
CREATE TABLE `m_venta` (
  `cod_mven` int(11) NOT NULL auto_increment,
  `cod_ven_mven` int(11) default NULL COMMENT 'codigo vendedor',
  `fec_mven` date default NULL COMMENT 'fecha de venta',
  `cod_rut_mven` int(11) default NULL COMMENT 'codigo ruta',
  `obs_mven` longtext,
  `dec_cre_mven` int(11) default NULL COMMENT 'valor declarado del credito',
  `obs_cre_mven` text,
  `dec_cob_mven` int(11) default NULL,
  `obs_cob_mven` text,
  `dec_che_mven` int(11) default NULL,
  `obs_che_mven` text,
  `dec_gas_mven` int(11) default NULL,
  `obs_gas_mven` text,
  `dec_efe_mven` int(11) default NULL,
  `obs_efe_mven` text,
  `dec_cons_mven` int(11) default NULL COMMENT 'consignacion declarada',
  `obs_cons_mven` text COMMENT 'observacion de consignacion',
  PRIMARY KEY  (`cod_mven`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `nota`
-- 

DROP TABLE IF EXISTS `nota`;
CREATE TABLE `nota` (
  `cod_not` int(11) NOT NULL auto_increment,
  `fec_not` date NOT NULL,
  `val_not` int(11) NOT NULL,
  `obs_not` longtext NOT NULL,
  `cod_fac_not` int(11) NOT NULL,
  PRIMARY KEY  (`cod_not`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `notas_compra`
-- 

DROP TABLE IF EXISTS `notas_compra`;
CREATE TABLE `notas_compra` (
  `cod_notc` int(11) NOT NULL auto_increment,
  `fec_notc` date NOT NULL COMMENT 'fecha nota',
  `val_notc` int(11) NOT NULL COMMENT 'valor nota',
  `cod_ven_notc` int(11) NOT NULL COMMENT 'codigo factura de venta',
  `cod_usu_notc` int(11) NOT NULL COMMENT 'usuario',
  `obs_notc` text NOT NULL,
  PRIMARY KEY  (`cod_notc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `notas_ventas`
-- 

DROP TABLE IF EXISTS `notas_ventas`;
CREATE TABLE `notas_ventas` (
  `cod_notc` int(11) NOT NULL auto_increment,
  `fec_notc` date NOT NULL COMMENT 'fecha nota',
  `val_notc` int(11) NOT NULL COMMENT 'valor nota',
  `cod_ven_notc` int(11) NOT NULL COMMENT 'codigo factura de venta',
  `cod_usu_notc` int(11) NOT NULL COMMENT 'usuario',
  `obs_notc` text NOT NULL,
  PRIMARY KEY  (`cod_notc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=27 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `parametros`
-- 

DROP TABLE IF EXISTS `parametros`;
CREATE TABLE `parametros` (
  `cod_parametro` int(11) NOT NULL,
  `valor_festivo` int(11) default NULL COMMENT 'valor del festivo',
  PRIMARY KEY  (`cod_parametro`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `permisos`
-- 

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos` (
  `cod_usu_per` int(11) NOT NULL default '0',
  `cod_int_per` int(11) NOT NULL default '0',
  `con_per` int(11) NOT NULL default '0',
  `edi_per` int(11) default NULL,
  `ins_per` int(11) default NULL,
  `eli_per` int(11) default NULL,
  PRIMARY KEY  (`cod_usu_per`,`cod_int_per`,`con_per`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `peso`
-- 

DROP TABLE IF EXISTS `peso`;
CREATE TABLE `peso` (
  `cod_pes` int(11) NOT NULL auto_increment,
  `nom_pes` varchar(250) default NULL COMMENT 'nombre del peso empaque',
  `desc_pes` varchar(250) default NULL,
  PRIMARY KEY  (`cod_pes`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `privilegios`
-- 

DROP TABLE IF EXISTS `privilegios`;
CREATE TABLE `privilegios` (
  `id_privilegio` int(11) NOT NULL auto_increment,
  `id_cliente` int(11) NOT NULL default '0',
  `privilegio` int(2) default NULL,
  PRIMARY KEY  (`id_privilegio`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `producto`
-- 

DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `cod_pro` int(11) NOT NULL auto_increment,
  `cod_fry_pro` varchar(50) default NULL,
  `nom_pro` varchar(50) default NULL,
  `pre_ven_pro` int(11) default NULL COMMENT 'precio de venta',
  `pre_com_pro` int(11) default NULL COMMENT 'precio de compra',
  `iva_pro` int(11) default NULL,
  `unidad` int(11) default NULL COMMENT 'cantidad de unidades por empaque',
  `cod_tpro_pro` int(11) default NULL COMMENT 'codigo tipo de prodcucto',
  `cod_mar_pro` int(11) default NULL,
  `cod_pes_pro` int(11) default NULL COMMENT 'codigo peso empaque',
  `min_pro` int(11) NOT NULL,
  PRIMARY KEY  (`cod_pro`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=360 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `producto_descuento`
-- 

DROP TABLE IF EXISTS `producto_descuento`;
CREATE TABLE `producto_descuento` (
  `cod_des` int(11) NOT NULL auto_increment,
  `cod_pro_des` int(11) default NULL,
  `cod_emp_des` int(11) default NULL,
  `por_des` float(13,5) default NULL,
  PRIMARY KEY  (`cod_des`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `proveedor`
-- 

DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor` (
  `cod_pro` int(11) NOT NULL auto_increment,
  `nom_pro` varchar(100) default NULL,
  `tel_pro` varchar(15) character set utf8 collate utf8_spanish_ci NOT NULL,
  `direccion_pro` varchar(50) NOT NULL,
  `ident_pro` varchar(20) character set utf8 collate utf8_spanish2_ci NOT NULL,
  `email_pro` varchar(10) character set utf8 collate utf8_spanish2_ci NOT NULL,
  `fax_pro` varchar(100) NOT NULL,
  `credito_pro` int(11) NOT NULL,
  PRIMARY KEY  (`cod_pro`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `punto_venta`
-- 

DROP TABLE IF EXISTS `punto_venta`;
CREATE TABLE `punto_venta` (
  `cod_pun` int(11) NOT NULL auto_increment COMMENT 'cod usuario',
  `nom_pun` varchar(50) default NULL COMMENT 'nombre punto de venta',
  `cod_bod` int(11) default NULL COMMENT 'cod bodega',
  `cod_ven` int(11) default NULL,
  `cod_rso` int(10) unsigned default NULL,
  PRIMARY KEY  (`cod_pun`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `regimenes`
-- 

DROP TABLE IF EXISTS `regimenes`;
CREATE TABLE `regimenes` (
  `nom_reg` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `resumen_movimineto`
-- 

DROP TABLE IF EXISTS `resumen_movimineto`;
CREATE TABLE `resumen_movimineto` (
  `cod_rmov` int(11) NOT NULL auto_increment,
  `tipo_mov_rmov` varchar(50) default NULL COMMENT 'tipo de movimiento',
  `cod_doc_rmov` int(11) default NULL COMMENT 'codigo del documento',
  `fec_rmov` date default NULL COMMENT 'fecha del movimiento',
  `ven_rmov` int(11) default NULL COMMENT 'vendedor',
  `valor_suma` int(11) default '0' COMMENT 'valor del movimiento',
  `valor_resta` int(11) default '0',
  `acc_rmov` varchar(50) default NULL COMMENT 'si suma o resta',
  `fec_sal_ant` date default NULL COMMENT 'fecha del saldo anterior',
  `saldo_anterior` int(11) default NULL COMMENT 'saldo anterior',
  `procesado` int(11) default '0',
  PRIMARY KEY  (`cod_rmov`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rsocial`
-- 

DROP TABLE IF EXISTS `rsocial`;
CREATE TABLE `rsocial` (
  `cod_rso` int(11) NOT NULL auto_increment,
  `nom_rso` varchar(50) default NULL,
  `nit_rso` varchar(20) default NULL,
  `logo_rso` varchar(50) default NULL,
  `desc1_rso` longtext character set utf8 collate utf8_spanish2_ci NOT NULL COMMENT 'descripcion leyenda 1',
  `desc2_rso` longtext character set utf8 collate utf8_spanish2_ci NOT NULL COMMENT 'descripcion leyenda 2',
  `reg_rso` varchar(100) character set utf8 collate utf8_spanish2_ci NOT NULL COMMENT 'regimen',
  `tel_rso` varchar(50) NOT NULL,
  `dir_rso` varchar(50) NOT NULL,
  `num_fac_rso` int(11) NOT NULL,
  `num_rem_rso` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY  (`cod_rso`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `ruta`
-- 

DROP TABLE IF EXISTS `ruta`;
CREATE TABLE `ruta` (
  `cod_rut` int(11) NOT NULL auto_increment,
  `nom_rut` varchar(50) default NULL,
  `desc_rut` longtext COMMENT 'descripcion de la  ruta',
  PRIMARY KEY  (`cod_rut`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `saldos`
-- 

DROP TABLE IF EXISTS `saldos`;
CREATE TABLE `saldos` (
  `cod_sal` int(11) NOT NULL auto_increment,
  `cod_ven_sal` int(11) default NULL COMMENT 'vendedor del saldo',
  `fec_sal` date default NULL COMMENT 'fecha de calculo',
  `val_sal` int(11) default NULL COMMENT 'valor calculado',
  PRIMARY KEY  (`cod_sal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo_documento`
-- 

DROP TABLE IF EXISTS `tipo_documento`;
CREATE TABLE `tipo_documento` (
  `cod_tdoc` int(11) NOT NULL auto_increment,
  `nom_tdoc` varchar(50) NOT NULL,
  `tipo_mov` varchar(20) NOT NULL,
  PRIMARY KEY  (`cod_tdoc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo_moneda`
-- 

DROP TABLE IF EXISTS `tipo_moneda`;
CREATE TABLE `tipo_moneda` (
  `cod_tipo` int(11) default NULL,
  `nom_tipo` varchar(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo_producto`
-- 

DROP TABLE IF EXISTS `tipo_producto`;
CREATE TABLE `tipo_producto` (
  `cod_tpro` int(11) NOT NULL auto_increment,
  `nom_tpro` varchar(50) default NULL,
  `desc_tpro` varchar(250) default NULL,
  PRIMARY KEY  (`cod_tpro`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `traza_ventas_pagos`
-- 

DROP TABLE IF EXISTS `traza_ventas_pagos`;
CREATE TABLE `traza_ventas_pagos` (
  `cod_tpag` int(11) NOT NULL auto_increment,
  `cod_car_tpag` int(11) NOT NULL COMMENT 'codigo de la cartera',
  `fec_tpag` date NOT NULL COMMENT 'fecha de la traza',
  `val_tpag` int(11) NOT NULL COMMENT 'valor traza',
  `tipo_doc_tpag` varchar(50) NOT NULL COMMENT 'documento q hizo el movimiento',
  `num_doc_tpag` int(11) NOT NULL COMMENT 'codigo del documento',
  PRIMARY KEY  (`cod_tpag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=468 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuario`
-- 

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `cod_usu` int(11) NOT NULL auto_increment,
  `nom_usu` varchar(200) default NULL,
  `car_usu` varchar(100) default NULL COMMENT 'cargo',
  `cc_usu` int(11) default NULL,
  `tel_usu` varchar(50) default NULL,
  `dir_usu` varchar(50) default NULL,
  `log_usu` varchar(20) default NULL,
  `pas_usu` varchar(20) default NULL,
  PRIMARY KEY  (`cod_usu`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `vendedor`
-- 

DROP TABLE IF EXISTS `vendedor`;
CREATE TABLE `vendedor` (
  `cod_ven` int(11) NOT NULL auto_increment,
  `cc_ven` varchar(20) default NULL,
  `nom_ven` varchar(200) default NULL,
  `dir_ven` varchar(50) default NULL,
  `tel_ven` varchar(50) default NULL,
  `cod_emp_ven` int(11) default NULL COMMENT 'codigo de la emprea',
  `cod_bod_ven` int(11) default NULL COMMENT 'codigo de la bodega a la q esta asignado',
  `cod_rut_ven` int(11) default NULL COMMENT 'codigo de la ruta',
  `fec_ing_ven` date default NULL,
  `fec_ret_ven` date default NULL,
  `inv_ven` int(11) default NULL,
  `cod_car_ven` int(11) default NULL COMMENT 'codigo del cargo',
  `tipo_com_ven` varchar(50) default NULL COMMENT 'tipo de comision ',
  `cod_tab_com_ven` int(11) default NULL COMMENT 'codigo de la tabla de comosiones',
  `por_com_ven` float(13,5) default NULL COMMENT 'porcentaje de comosion',
  `garan_ven` varchar(250) default NULL COMMENT 'garantia',
  `sueldo` int(11) default NULL,
  PRIMARY KEY  (`cod_ven`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

-- 
-- Estructura para la vista `infinventario`
-- 
DROP TABLE IF EXISTS `infinventario`;

DROP VIEW IF EXISTS `infinventario`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `facturacion`.`infinventario` AS select `f`.`nom_bod` AS `nom_bod`,`d`.`nom_mar` AS `nom_mar`,`c`.`nom_tpro` AS `nom_tpro`,`b`.`nom_pro` AS `nom_pro`,`b`.`cod_fry_pro` AS `cod_fry_pro`,`a`.`serial` AS `serial`,`e`.`nom_pes` AS `nom_pes`,sum(`a`.`cant_ref_kar`) AS `totalcan`,`a`.`valor_precio` AS `valor_precio`,sum((`a`.`valor_precio` * `a`.`cant_ref_kar`)) AS `totalpre` from (((((`facturacion`.`kardex` `a` join `facturacion`.`producto` `b` on((`a`.`cod_ref_kar` = `b`.`cod_pro`))) join `facturacion`.`tipo_producto` `c` on((`b`.`cod_tpro_pro` = `c`.`cod_tpro`))) join `facturacion`.`marca` `d` on((`b`.`cod_mar_pro` = `d`.`cod_mar`))) join `facturacion`.`peso` `e` on((`a`.`cod_talla` = `e`.`cod_pes`))) join `facturacion`.`bodega` `f` on((`a`.`cod_bod_kar` = `f`.`cod_bod`))) group by `f`.`nom_bod`,`d`.`nom_mar`,`c`.`nom_tpro`,`b`.`nom_pro`,`b`.`cod_fry_pro`,`a`.`serial` with rollup;
