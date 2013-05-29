<?php
include "lib/sesion.php";
include("lib/database.php");
?>
<?php
ob_start("ob_gzhandler");
 
// Contenido de la página, puede contener
// tanto HTML cómo PHP
 
//ob_end_flush();
?> 
<style type="text/css">
<!--
.botones1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bolder;
}
.textotabla001 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
}
.textotabla001 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
  <script>
			function vacio(q)
			{
				for ( i = 0; i < q.length; i++ ) { //la funcion q.length devuelve el tamaño de la palabra contenia por el textbox
				  if ( q.charAt(i) != " " ) {//la funcion q.charAt nos deuelve el caracter contenido en la posicion i de la variable q
					return true
				  }
				}
			 return false;
			}

			function valbuscar()
			{
			   if(document.frmbus.buscar.value=="")
			   {
			       alert("Debe ingresar algun texto!");
				   document.frmbus.buscar.focus();
				   return false;
			   }
			   if(vacio(document.frmbus.buscar.value)==false ) {
				   alert("Debe ingresar algun texto!.");
				   document.frmbus.buscar.focus();
				   return false;
			   } 
			   if(document.frmbus.opcionbuscar.value==0)
			   {
			       alert("Debe seleccionar algun parametro de busqueda!");
				   document.frmbus.opcionbuscar.focus();
				   return false;
			   }
			   else
			   {
			       document.frmbus.submit();
				   return true;
			   }
			}
			</script>
			<script language="javascript">
function imprimirinf(){ 
	document.getElementById('search').style.display="none";
	window.print();
}
</script>
<?php
				$db = new Database();
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
				//echo $sql;
				$db->query($sql);
				?>
				<form name="frmbus" method="post" action="reporteinventarios.php">
				<table width="715" border="0" align="center" id="search">
                <tr>
                  <td width="93" class="botones1">Buscar</td>
                  <td width="151"><input type="text" name="buscar" id="buscar" value="<?=$_POST['buscar']?>"/></td>
                  <td width="51" class="botones1">en</td>
                  <td width="195"><select name="opcionbuscar" id="opcionbuscar" class="textotabla001">
		              <option value="0">Seleccione</option>
					  <?php if($_POST['opcionbuscar']==1)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
                      <option value="1" <?php echo $selected?>>Categoria</option>
					  <?php if($_POST['opcionbuscar']==2)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
                      <option value="2" <?php echo $selected?>>Codigo Producto</option>
					  <?php if($_POST['opcionbuscar']==3)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
                      <option value="3" <?php echo $selected?>>Producto</option>
					  <?php if($_POST['opcionbuscar']==4)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
					  <option value="4" <?php $selected?>Tipo Producto</option>
					  <?php if($_POST['opcionbuscar']==5)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
					  <option value="5" <?php echo $selected?>>Bodega</option>
					  <?php if($_POST['opcionbuscar']==6)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
					  <option value="6" <?php echo $selected?>>Pieza/Serial</option>
					  <option value=7>Listado Completo</option>
                    </select>                  </td>
                  <td width="195"><input class="botones1" type="button" name="button2" value="Enviar" onclick="valbuscar()"/></td>
				  <td width="195"><input class="botones1" type="button" name="button2" value="RESUMEN" onclick="window.open('resumeninventario.php?buscar=<?=$buscar?>&opcionbuscar=<?php echo $opcionbuscar?>&usuario=<?php echo$global[3]?>','window','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1366,height=768,left = 0,top = 0')"/></td>
				  <td><input type="button" class="botones1" name="imprimir" id="imprimir" value="Imprimir" onclick="imprimirinf()"/></td>
                </tr>
              </table>
			  </form>
				<div  name="html" align="center">
<table width="850" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="Exportar_a_Excel" style="border-collapse:collapse;">
                
				 <tr >
			<td width="80"  class="botones1" align="center">Bodega </td>
            <td width="54"  class="botones1">Categ. </td>
            <td width="60"  class="botones1" align="center">T. Producto</td>
			<td width="297"  class="botones1" align="center">Referencia/Nombre Producto</td>
            <td width="70"  class="botones1" align="center">Codigo</td>
	        <td width="70"  class="botones1" align="center">Serie</td>
			<td width="54"   class="botones1" align="center">Color</td>
            <td width="70"   class="botones1" align="center">Cantidad</td>
			<td width="70"   class="botones1" align="center">Valor Unitario</td>
			<td width="90"   class="botones1" align="center">Total</td>
			</tr>
				<? 
				 $totalcantidadbuscar = 0;
				 $totalprebuscar = 0;
				while($db->next_row()){ 	
				  if($db->nom_bod!="" && $db->nom_mar!="" && $db->nom_tpro!="" && $db->nom_pro!="" && $db->cod_fry_pro!="" 
				       && $db->serial!="" && $db->totalcan!="" && $db->valor_precio!="" && $db->totalpre!="") {?>
				<tr id="fila_0">
				<td  class="textotabla001"><?=$db->nom_bod?></td>
                  <td class="textotabla001"><div align="center"><?=strtoupper($db->nom_mar)?></div></td>
				  <td  class="textotabla001"><div align="center"><?=strtoupper($db->nom_tpro)?></div></td>
                  <td  class="textotabla001"><?=strtoupper($db->nom_pro)?></td>
                  <td  class="textotabla001"><?=$db->cod_fry_pro?></td>
                  <td  class="textotabla001"><div align="center"><?=$db->serial?></div></td>
				  <td colspan="1" class="textotabla001"><div align="center"><?=$db->nom_pes?></div></td>
				   <td class="textotabla001"><div align="right"><?=number_format($db->totalcan,2,".",".")?></div></td>
				    <td class="textotabla001"><div align="right"><?=number_format($db->valor_precio,0,".",".")?></div></td>
					<td class="textotabla001"><div align="right"><? echo number_format($db->totalpre,0,".",".");?></td>
					<?
					  $totalcantidadbuscar = $totalcantidadbuscar + $db->totalcan;
					  $totalprebuscar = $totalprebuscar + $db->totalpre;
					
					?></div></td>
			    </tr>
				<? }//if campos no null 
				?>
				<?  if($db->cod_fry_pro=='' && $db->serial=='' && $db->nom_bod!='' &&
					   $db->nom_mar!='' && $db->nom_tpro!='' && $db->nom_pro!='' &&
					   $db->nom_pes!='' && $db->totalcan!='' && $db->valor_precio!='' && $db->totalpre!='')	{	?>
                <tr id="fila_0"  >
				<!--Muetra Total Productos-->
                  <td  class="botones1" colspan="7" align="right">CANTIDAD TOTAL</td>
				   <td class="textotabla001"><div align="right"><?=number_format($db->totalcan,2,".",".")?></div></td>
				    <td class="botones1"><div align="right">TOTAL</div></td>
					<td class="textotabla001"><div align="right"><?=number_format($db->totalpre,2,".",".")?></div></td>
			    </tr>
				  
				<? } ?>
				<?  if($db->nom_pro=="" && $db->cod_fry_pro=="NULL" && $db->serial=="NULL")	{	?>
                <tr id="fila_0"  >
				
                  <td  class="titulotabla001" colspan="7" align="right">CANTIDAD TOTAL</td>
				   <td class="textotabla001"><div align="right"><?=number_format($db->totalcan,2,".",".")?></div></td>
				    <td class="botones1"><div align="right">TOTAL</div></td>
					<td class="textotabla001"><div align="right"><?=number_format($db->totalpre,0,".",".")?></div></td>
			    </tr>
				  
				<? } ?>
				
				<?  } //$db->close(); ?>
				<? if(isset($opcionbuscar) && $opcionbuscar>0) 
					{ ?>
					<tr id="fila_0"  >
				
                  <td  class="botones1" colspan="7" align="right"> TOTAL</td>
				   <td class="textotabla001"><div align="right"><?=number_format($totalcantidadbuscar,2,".",".")?></div></td>
				    <td class="botones1"><div align="right"> TOTAL</div></td>
					<td class="textotabla001"><div align="right"><?=number_format($totalprebuscar,0,".",".")?></div></td>
			    </tr>
				  <? }?>
				  <tr id="fila_0"  >
				
                  <td  class="botones1" colspan="7" align="right">GRAN TOTAL</td>
				   <td class="textotabla001"><div align="right"><?=number_format($totalcantidadbuscar,2,".",".")?></div></td>
				    <td class="botones1"><div align="right">TOTAL</div></td>
					<td class="textotabla001"><div align="right"><?=number_format($totalprebuscar,0,".",".")?></div></td>
			    </tr>
				  </table></div>
				  
			<?php	  ob_end_flush();
?> 
