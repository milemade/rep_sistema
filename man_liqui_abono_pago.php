<?php include("js/funciones.php")?>
<?PHP include("lib/database.php")?>
<?php include "conf/tiemposesion.php";?>
<?PHP
$fecha= $fecha_abo;
$valor = $val_abono;
$proveedor = $cliente;
$db = new Database();
$sql="SELECT  m_entrada.cod_ment,   
              m_entrada.fec_ment,   
			  m_entrada.fac_ment,   
			  m_entrada.total_ment,   
			  m_entrada.cod_prove_ment,   
			  proveedor.nom_pro,   
			  m_entrada.est_ment,   
			  m_entrada.sal_ant_ment 
		 FROM m_entrada 
		 INNER JOIN proveedor ON (m_entrada.cod_prove_ment = proveedor.cod_pro)   
		 where m_entrada.est_ment!='CANCELADA' and  m_entrada.cod_prove_ment=$proveedor order by fec_ment ,fac_ment ";			
$tabla='';
?>
<script language="javascript">
function validar_abonos(){
	document.forma.submit();
}
function validar_cacelar(){
	document.myForm.submit();
}
</script>
<link href="../styles.css" rel="stylesheet" type="text/css" />
<link href="../admon_cartera/styles1.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 12%}
-->
</style>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/styles1.css" rel="stylesheet" type="text/css">
<TABLE width="79%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<FORM action="sav_abonos.php" method="post" name="forma" >
			<input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
			<input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
			<input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
			<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
			<INPUT type="hidden" value="<?=$cliente?>" name="cliente">
			<INPUT type="hidden" value="<?=$bodega?>" name="bodega">
			<INPUT type="hidden" value="<?=$valor?>" name="valor">
			<INPUT type="hidden" value="<?=$fecha?>" name="fecha">
			<INPUT type="hidden" value="<?=$observaciones?>" name="observacion_abo">
			<!--<textarea name="observacion" cols="30" rows="5" style="display:none"><?=$observaciones?></textarea>-->
			<TR>
			  <TD class='ctablasup' align="center" colspan="7">LIQUIDACION DE ABONO </TD>
			<TR>
			  <TD class='subtitulosproductos'>Factura</TD>
			  <TD  class='subtitulosproductos'>Fecha		      </TD>
			  <TD  class='subtitulosproductos'>Valor Factura</TD>
			   <TD  class='subtitulosproductos'>Saldo Anterior</TD>
			    <TD  class='subtitulosproductos'>Valor Abono</TD>
				<TD  class='subtitulosproductos'>Saldo Actual</TD>
			  <TD  class='subtitulosproductos'>Estado</TD>
			</TR>
			<?			
				//$valor=1475000;
				$descuento=$valor;			
				$db->query($sql);
				$i=1;
				$aa=0;
				$bb=0;
				while($db->next_row() and $descuento >0)
				{ 
					//echo $db->num_abono;
					 $rsocial_fac=$db->cod_razon_fac;	
					 $nombre_abono=$db->nom_pro;
					 $total_factura=  $db->saldo - $db->valor_Abono;
					 $identifiacion=0;
					 $nuevo_valor_factura_total=($db->total_ment-$db->sal_ant_ment);
     				 $tabla.='<TR>
						  <TD  class=\'textoproductos1\'>'.$db->fac_ment.'	  
						  <INPUT type="hidden" value="'.$db->num_abono.'" name="num_abonos_'.$i.'" >
						  <INPUT type="hidden" value="'.$db->cod_ment.'" name="codigo_cartera_'.$i.'" > 
						  <INPUT type="hidden" value="'.$db->num_fac.'" name="factura_'.$i.'" >'.$db->num_fac.'</TD>
						  <TD  class=\'textoproductos1\'>'.$db->fec_ment.'</TD>
						  <TD  class=\'textoproductos2\' aling=\'center\'>'.number_format($db->total_ment,0,".",".").'</TD>
						  <TD  class=\'textoproductos2\'>'.number_format($db->sal_ant_ment,0,".",".").'</TD>  ';
				if( $descuento >= $nuevo_valor_factura_total ){	  
						$tabla.='<TD class=\'textoproductos2\'>'.number_format($nuevo_valor_factura_total,0,".",".").'</TD>
								<TD  class=\'textoproductos2\'>0</TD>
								<TD width="10%" class=\'textoproductos1\'>CANCELADA
								<INPUT type="hidden" value="CANCELADA" name="accion_'.$i.'" >
								<INPUT type="hidden" value="'.($db->sal_ant_ment + $nuevo_valor_factura_total).'" name="saldo_anterior_'.$i.'" >
								</TD></TR>';
						$identifiacion=1;

						$descuento=$descuento - $nuevo_valor_factura_total;

					}
   				else if( $descuento < $nuevo_valor_factura_total &&  $descuento > 0 ) {	  
						$valor_abono= $descuento;
						$saldo_fatura= $nuevo_valor_factura_total- $descuento;
						$tabla.='<TD  class=\'textoproductos2\'>'.number_format($valor_abono,0,".",".").'</TD>
								<TD  class=\'textoproductos2\'>'.number_format($saldo_fatura,0,".",".").'</TD>
								<TD width="10%" class=\'textoproductos\'>ABONADO
								<INPUT type="hidden" value="ABONADO" name="accion_'.$i.'" >
								<INPUT type="hidden" value="'.($db->valor_abono +  $descuento ).'" name="valor_abono_'.$i.'" >
								<INPUT type="hidden" value="'.($db->sal_ant_ment  + $valor_abono).'" name="saldo_anterior_'.$i.'" >
								</TD></TR>';
						$identifiacion=1;
						//echo "<br>";
						 $descuento= $descuento - $nuevo_valor_factura_total ;						
					}
					$i++;
				}
			if($i== 1){
				echo  "<span class=\'textoproductos1\'>No Existen Facturas Pendientes, No se puede Procesar el Abono</span>";
			}	
			echo $tabla;
			if($descuento > 0){
				$bb=1;
				$mensaje="<span class=\'textoproductos1\' align='center'>El saldo supera la Cartera, por Favor Verifique... </span>";
			}
			if($i > 1){
				$tabla='<TABLE width="92%" border="0" cellpadding="2" cellspacing="1" >
				<TR>
				 <TD class=\'subtitulosproductos \'>Factura</TD>
			  <TD  class=\'subtitulosproductos\'>Fecha		      </TD>
			  <TD  class=\'subtitulosproductos\'>Valor Factura</TD>
			   <TD  class=\'subtitulosproductos\'>Saldo Anterior</TD>
			    <TD  class=\'subtitulosproductos\'>Valor Abono</TD>
				<TD  class=\'subtitulosproductos\'>Saldo Actual</TD>
			  <TD  class=\'subtitulosproductos\'>Accion</TD>
				</TR>
				'.$tabla.'</TABLE>';
				$i=$i-1;
				$aa=1;
				if($descuento > 0) $descuento=0;
			}
			?>
			 </TR>
				<TR>
			  <TD class='subtitulosproductos' align="left" colspan="7"><br> 
			  PROVEEDOR: <?=$nombre_abono?>  </TD>
			</TR>
	<TR><TD colspan="7" align="center">
				<INPUT type="hidden"  name="saldo" value = "<?=$descuento?>"  >
				<INPUT type="hidden" value="<?=$i?>" name="cantidad">
				<INPUT type="hidden" value="<?=$anotacion?>" name="anotacion">
				<INPUT type="hidden"  name="rsocial_fac" value = "<?=$rsocial_fac?>"  >
				<?
				if($aa == 1 && $bb == 0  ){ 
				?>
				<INPUT type="button" value="Aceptar" class="botones" onClick="validar_abonos()">
				<? } ?>
				<input name="button" type="button" class="botones" onClick="validar_cacelar()" value="Cancelar" />
				<INPUT type="hidden"  name="leotabla" value = "<? echo str_replace("\"","'",$tabla);   ?>">
				<!--<textarea style="display:inline" name="observacion"><?=$tabla?></textarea>-->
				</TD>
	</TR>
	</FORM>
</TABLE>
<?
if($aa==1){
	echo $mensaje;
}
/*if($descuento>0){
	echo "Nota: Saldo a Favor de: ".$descuento.'<INPUT type="text"  id="saldo" value = "'.$descuento.'" >';
}
*/?>
<FORM method="POST" action="con_abono_pago.php" name="myForm">
<input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
<input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
<input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
</FORM>