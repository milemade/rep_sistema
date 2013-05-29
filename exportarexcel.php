<?php
include "lib/sesion.php";
include("lib/database.php");
?>
<? header("Content-Type: application/vnd.ms-excel");header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("content-disposition: attachment;filename=ReporteInventarios.xls");?>
<?php
$dbdel = new Database();
$sqldel = "DELETE FROM kardex WHERE cant_ref_kar='0';";
//echo $sqldel;
$dbdel->query($sqldel);
$dbdel->close();
?>
<?php
				$total=0;
				$cant_reg_pag =50;
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
				///echo $sql; //exit;
				$db->query($sql);
				$sumacantidad = 0;
				$sumadinero = 0;
			?>
		  	<table>
			<tr>
			<td colspan="10"><b>INFORME INVENTARIOS:: FECHA:  <?=Date('Y-m-d')?>:: Usuario: <?=$usuario?></b></td>
            </tr>
			<tr >
			<td><b>Bodega</b></td>
            <td><b>Categoria</b> </td>
            <td><b>Tipo Producto</b></td>
			<td><b>Referencia/Nombre Producto</b></td>
            <td><b>Codigo</b></td>
	        <td><b>Pieza/Serie</b></td>
			<td><b>Color</b></td>
            <td><b>Cantidad</b></td>
			<td><b>Valor Unitario</b></td>
			<td><b>Total</b></td>
			</tr>
				<? 
				 $totalcantidadbuscar = 0;
				 $totalprebuscar = 0;
				while($db->next_row()){ 	
				$bodega = $db->nom_bod;
				$marca = $db->nom_mar;
				$tiporoducto = $db->nom_tpro;
				$producto = $db->nom_pro;
				$codigo = $db->cod_fry_pro;
				$serial = $db->serial;
				$totalcan = $db->totalcan;
				$valor_precio = $db->valor_precio;
				$totalpre = $db->totalpre;
				?>
                
				<? if($db->nom_bod!="" && $db->nom_mar!="" && $db->nom_tpro!="" && $db->nom_pro!="" && $db->cod_fry_pro!="" 
				       && $db->serial!="" && $db->totalcan!="" && $db->valor_precio!="" && $db->totalpre!="") {?>
				<tr id="fila_0">
				<td><?=$db->nom_bod?></td>
                  <td><div align="center"><?=strtoupper($db->nom_mar)?></div></td>
				  <td><div align="center"><?=strtoupper($db->nom_tpro)?></div></td>
                  <td><?=strtoupper($db->nom_pro)?></td>
                  <td><?=$db->cod_fry_pro?></td>
                  <td><div align="center"><?=$db->serial?></div></td>
				  <td colspan="1" class="textotabla001"><div align="center"><?=$db->nom_pes?></div></td>
				   <td><div align="right"><?=number_format($db->totalcan,2,".",".")?></div></td>
				    <td><div align="right"><?=number_format($db->valor_precio,2,".",".")?></div></td>
					<td><div align="right"><? echo number_format($db->totalpre,0,".",".");
					if(isset($opcionbuscar) && $opcionbuscar>0)
					{
					  $totalcantidadbuscar = $totalcantidadbuscar + $db->totalcan;
					  $totalprebuscar = $totalprebuscar + $db->totalpre;
					}
					?></div></td>
			    </tr>
				<? }//if campos no null 
				?>
				<?  if($db->cod_fry_pro=='' && $db->serial=='' && $db->nom_bod!='' &&
					   $db->nom_mar!='' && $db->nom_tpro!='' && $db->nom_pro!='' &&
					   $db->nom_pes!='' && $db->totalcan!='' && $db->valor_precio!='' && $db->totalpre!='')	{	?>
                <tr id="fila_0"  >
				<!--Muetra Total Productos-->
                  <td   colspan="7" align="right">CANTIDAD TOTAL</td>
				   <td><div align="right"><?=number_format($db->totalcan,2,".",".")?></div></td>
				    <td><div align="right">TOTAL</div></td>
					<td><div align="right"><?=number_format($db->totalpre,0,".",".")?></div></td>
			    </tr>
				  
				<? } ?>
				<?  if($db->nom_pro=="" && $db->cod_fry_pro=="" && $db->serial=="")	{	?>
                <tr id="fila_0"  >
				
                  <td colspan="7" align="right">CANTIDAD TOTALnn</td>
				   <td><div align="right"><?=number_format($db->totalcan,2,".",".")?></div></td>
				    <td><div align="right">TOTAL</div></td>
					<td><div align="right"><?=number_format($db->totalpre,2,".",".")?></div></td>
			    </tr>
				  
				<? } ?>
				<?  if($db->nom_bod=="" && $db->nom_mar=="" && $db->nom_tpro=="" && $db->nom_pro=="" && $db->cod_fry_pro=="" && 
				$db->serial=="" && $db->nom_pes!="" && $db->totalcan!="" && $db->valor_precio==0 && $db->totalpre!="")	{	?>
                <tr id="fila_0"  >
				
                  <td   colspan="7" align="right">GRAN TOTAL</td>
				   <td><div align="right"><?=number_format($db->totalcan,2,".",".")?></div></td>
				    <td><div align="right">GRAN TOTAL</div></td>
					<td><div align="right"><?=number_format($db->totalpre,,".",".")?></div></td>
			    </tr>
				  
				<? } ?>
				<?  } $db->close(); ?>
				<? if(isset($opcionbuscar) && $opcionbuscar>0) 
					{ ?>
					<tr id="fila_0"  >
				
                  <td   colspan="7" align="right"> TOTAL</td>
				   <td><div align="right"><?=number_format($totalcantidadbuscar,2,".",".")?></div></td>
				    <td><div align="right"> TOTAL</div></td>
					<td><div align="right"><?=number_format($totalprebuscar,2,".",".")?></div></td>
			    </tr>
				  <? }?>	
				  
				  <tr >
				    <td colspan="9" >&nbsp;</td>
			    </tr>
              </table>
	