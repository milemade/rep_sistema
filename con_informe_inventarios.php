<?php
include "lib/sesion.php";
include("lib/database.php");
$global[3] = strtoupper($global[3]);
?>
<? include("js/funciones.php")?>
<?php
$dbdel = new Database();
$sqldel = "DELETE FROM kardex WHERE cant_ref_kar='0';";
//echo $sqldel;
$dbdel->query($sqldel);
$dbdel->close();
?>
<?php 
				$total=0;
				$cant_reg_pag =30;
				$sql = "SELECT HIGH_PRIORITY nom_bod,
				               nom_mar,
							   nom_tpro,
							   nom_pro,
							   cod_fry_pro,
							   serial,
							   nom_pes,
							   totalcan,
							   valor_precio,
							   totalpre
						FROM infinventario ";
				if(isset($buscar) && $opcionbuscar==1)
				{  //Busqueda nombre marca
					$sql .="WHERE nom_mar LIKE '%".$buscar."%'";
				}
				if(isset($buscar) && $opcionbuscar==2)
				{ //Busqueda Codigo producto
					$sql .= "WHERE cod_fry_pro='".$buscar."' ";
				}
				if(isset($buscar) && $opcionbuscar==3)
				{ //Busqueda nombre producto
					$sql .= "WHERE nom_pro LIKE '%".$buscar."%' ";
				}
				if(isset($buscar) && $opcionbuscar==4)
				{ // POr nombre de tipo producto
			       $sql .="WHERE nom_tpro LIKE '%".$buscar."%' ";
				}
                if(isset($buscar) && $opcionbuscar==5)
				{//Nombre de Bodega
					$sql .= "WHERE nom_bod LIKE'%".$buscar."%' ";
				}
				if(isset($buscar) && $opcionbuscar==6)
				{ //Busqueda Pieza/Serial
					$sql .= "WHERE serial='".$buscar."' ";
				}
				 
				$cantidad_paginas = paginar($sql);
$cant_pag=ceil($cantidad_paginas/$cant_reg_pag);
if(!empty($act_pag)) 
	$inicio=($act_pag -1)*$cant_reg_pag  ;
else { 
	$inicio =0;
	$act_pag=1;
	}
$paginar = " limit  $inicio, $cant_reg_pag";
$sql.=$paginar; 
				 //$sql.= " LIMIT 0 , 30";
				$sql; //exit;
					$db->query($sql);
					$filasconsulta = $db->num_rows();
					$estilo="formsleo";
					$sumacantidad = 0;
					$sumadinero = 0;
					
					
				?>