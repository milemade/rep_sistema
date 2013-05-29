<?PHP include("js/funciones.php")?>
<?PHP include("lib/database.php")?>
<?PHP include "conf/tiemposesion.php";
//print_r($_POST);
$fecha = $fecha_abo;
$valor = 0;
$saldo = 0;
$total_cheques = 0;
$total_efectivo = 0;
$bodega = $cliente;
?>
<?	$db = new Database();
    $sql="SELECT  cod_car_fac as codigo_cartera , 'CLIENTE' AS tipo_credito, 
     			  cod_car_fac,fec_car_fac, cartera_factura.cod_fac, num_fac, cod_cli, cod_razon_fac,
			      m_factura.tot_fac AS total, 
			     (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) AS dias , 
			     (SELECT nom_bod FROM bodega1 WHERE cod_bod=cod_cli) AS nombre , 
			     DATE_ADD(cartera_factura.fec_car_fac, INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) DAY) AS vecimiento,
			     datediff(curdate(),DATE_ADD(cartera_factura.fec_car_fac, INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) DAY)) AS pasado ,
			    m_factura.tot_fac - IFNULL(valor_Abono,0)  AS saldo ,num_abono, valor_abono
			    FROM cartera_factura  
			    INNER JOIN m_factura ON m_factura.cod_fac=cartera_factura.cod_fac 
			    WHERE cod_cli > -1 and  cod_cli=$cliente AND estado_car <>'CANCELADA'  and estado_car <>'anulado'
			    ORDER BY num_fac ";
	//echo $sql;	
$tabla='';
?>

<script language="javascript">
function validar_abonos()
{
	document.forma.submit();
}

function validar_cacelar()
{
	document.myForm.submit();
}



</script>
<link href="../styles.css" rel="stylesheet" type="text/css" />
<link href="../admon_cartera/styles1.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--

.style1 {font-size: 12%}

-->
/* :::::: Estilo CSS del area de texto :::::: */
#textarea { 
background: #E0ECF8; /* Color de fondo */
color: #848484; /* Color del texto */
text-shadow:1px 1px 2px #ffffff; /* Sombra del texto */
Font-size:12px; /* Tamaño del texto */
border:1px solid #ABC4DD; /* Caracteres del borde */
}
</style>
<link href="css/styles.css"  rel="stylesheet" type="text/css">
<link href="css/styles1.css" rel="stylesheet" type="text/css">
<body>
<table width="600" border="0">
  <tr>
    <td class='subtitulosproductos'>Observaciones</td>
    <td><textarea id="textarea"  rows="5" cols="100" style="overflow: auto;"><?=$observaciones?></textarea></td>
  </tr>
</table>

<br><br>
<TABLE width="80%" border="0"  cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" align="center">
		<FORM action="sav_abonos_ventas.php" method="post" name="forma" >
		<input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		<input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		<input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
		<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
		<INPUT type="hidden" value="<?=$cliente?>" name="cliente">
		<INPUT type="hidden" value="<?=$bodega?>" name="bodega">
		<INPUT type="hidden" value="<?=$fecha?>" name="fecha">
		
		<TR>
        <TD class='ctablasup' align="center" colspan="9">LIQUIDACION DE ABONOS </TD>
		<TR>
        <TD class='subtitulosproductos'>Num Doc.</TD>
        <TD  class='subtitulosproductos'>Fecha	Doc.</TD>
        <TD  class='subtitulosproductos'>Valor Doc.</TD>
        <TD  class='subtitulosproductos'>Saldo Anterior</TD>
		<TD  class='subtitulosproductos'>Valor Cheque</TD>
        <TD  class='subtitulosproductos'>Valor Efectivo</TD>
	    <TD  class='subtitulosproductos' width="11%">Valor Abono</TD>
		<TD  class='subtitulosproductos' width="11%">Saldo Doc.</TD>
	    <TD  class='subtitulosproductos'><div align="center">Estado</div></TD>
		</TR>
			<?php			
						
				$db->query($sql);
				$i=1;
				$aa=0;
				
				$bb=0;
				//while($db->next_row() and $descuento >0 )
				while($db->next_row()) 
				{ 
					//echo $db->num_abono;
					$var1 = "val_abono_".$db->cod_fac;
					$var2 = "val_cheque_".$db->cod_fac;  
					$valorvar1 = $$var1;
					$valorvar2 = $$var2;
					$total_efectivo += (int)$valorvar1;
					$total_cheques += $valorvar2;
					$valor_abono_factura = $$var1 + $$var2; //Suma Efectivo y Cheques
					$valor +=$valor_abono_factura;
					$descuento=$valor_abono_factura;	
					$rsocial_fac=$db->cod_razon_fac;	
    			    $nombre_abono=$db->nombre;
				    $total_factura=  $db->saldo - $db->valor_Abono;
				    $identifiacion=0;
					if($valorvar2!="" || $valorvar1 !="")
				    $tabla.='<TR>
						  <TD  class=\'textoproductos1\'><INPUT type="hidden" value="'.$db->num_abono.'" name="num_abonos_'.$i.'" >
					  	  <INPUT type="hidden" value="'.$db->codigo_cartera.'" name="codigo_cartera_'.$i.'" > 
						  <INPUT type="hidden" value="'.$db->num_fac.'" name="factura_'.$i.'" >'.$db->num_fac.'</TD>
						  <TD  class=\'textoproductos1\'>'.$db->fec_car_fac.'</TD>
						  <TD  class=\'textoproductos1\'>'.number_format((int)$db->total,0,".",".").'</TD>
						  <TD  class=\'textoproductos1\'>'.number_format((int)$db->saldo,0,".",".").'</TD>
						  <TD  class=\'textoproductos1\'>'.number_format((int)$$var2,0,".",".").'</TD>
						  <TD  class=\'textoproductos1\'>'.number_format((int)$$var1,0,".",".").'</TD>';
					if( $descuento >= $total_factura )
					{	  
						$tabla.='<TD class=\'textoproductos1\'>'.number_format($total_factura,0,".",".").'</TD>
								 <TD  class=\'textoproductos1\'>0</TD>
								 <TD width="10%" class=\'textoproductos1\'><div align="center">CANCELADA</div>
								 <INPUT type="hidden" value="CANCELADA" name="accion_'.$i.'" >
								 <INPUT type="hidden" value="'.($db->saldo).'" name="valor_abono_'.$i.'" >';
                       $identifiacion=1;
					}
					if( $descuento < $total_factura &&  $descuento > 0 )
					 {	 
					    $saldoactualmostrar = $db->saldo - $descuento;
						$tabla.='<TD  class=\'textoproductos1\'><div align="right">'.number_format($descuento,0,".",".").'</div></TD>
								 <TD  class=\'textoproductos1\'><div align="right">'.number_format($db->saldo - $descuento,0,".",".").'</div></TD>
								 <TD width="10%" class=\'textoproductos1\'><div align="center">ABONADO</div>
								 <INPUT type="hidden" value="ABONADO" name="accion_'.$i.'" >
								 <INPUT type="hidden"  name="val_traza_'.$i.'"  value="'.$descuento.'" >
								 <INPUT type="hidden" value="'.($db->valor_abono +  $descuento ).'" name="valor_abono_'.$i.'" >';
							$identifiacion=1;
					}
					$descuento=$descuento - $total_factura;
					$saldo+=$descuento;
					$i++; ?>
			<!--<INPUT type="hidden" value="<?=$$var1?>" name="efec_abo_<?=$i?>">
            <INPUT type="hidden" value="<?=$$var2?>" name="cheq_abo_<?=$i?>">-->
			
			<?php	} //end while
			if($i== 1)
			{

				echo  "<span class=\'textoproductos1\'>No Existen Facturas Pendientes, No se puede Procesar el Abono</span>";

			}	
			echo $tabla;
			if($descuento > 0)
			{

				$bb=1;

				$mensaje="<span class=\'textoproductos1\' align='center'>El saldo supera la Cartera, por Favor Verifique... </span>";

			}
			if($i > 1)
			{
				$tabla ='<TABLE width="92%" border="0" cellpadding="2" cellspacing="1" >
				        <TR>
				        <TD class=\'subtitulosproductos \'>Num Doc.</TD>
			            <TD class=\'subtitulosproductos\'>Fecha Doc.</TD>
			            <TD class=\'subtitulosproductos\'>Valor Doc.</TD>
			            <TD class=\'subtitulosproductos\'>Saldo Anterior</TD>
						<TD class=\'subtitulosproductos\'>Valor Cheque</TD>
			            <TD class=\'subtitulosproductos\'>Efectivo</TD>
			            <TD class=\'subtitulosproductos\'>Valor Abono</TD>
				        <TD class=\'subtitulosproductos\'>Saldo Actual</TD>
			            <TD class=\'subtitulosproductos\'>Accion</TD>
					    </TR>'.$tabla.'</TABLE><table>';
				$i=$i-1;
				$aa=1;
				if($descuento > 0) $descuento=0;
			}
			?>
			 </TR>
				<TR>
		        <TD class='subtitulosproductos' align="left" colspan="9"><hr></TD>
			    </TR>
				<TR>
				  <TD colspan="5"  class='subtitulosproductos'>CLIENTE: <?=$nombre_abono?> </TD>
				  <TD  class='subtitulosproductos'> TOTAL ABONOS</TD>
				  <TD  class='textoproductos1'><div align="right"><?=number_format($valor,0,".",".")?></div></TD>
				  <TD  class='textoproductos1'><div align="right"><b>SALDO TOTAL</b></div></TD>
				  <TD colspan="2" class='textoproductos1'><?=number_format($saldo*-1,0,".",".")?></TD>
  </TR>
	            <TR><TD colspan="7" align="center">
				<INPUT type="hidden" value="<?=$valor?>" name="valor">
				<INPUT type="hidden" value="<?=$i?>" name="cantidad">
				<INPUT type="hidden"  name="saldo" value = "<?=$saldo?>"  >
				<INPUT type="hidden" value="<?=$anotacion?>" name="anotacion">
				<INPUT type="hidden"  name="rsocial_fac" value = "<?=$rsocial_fac?>"  >
				<?PHP
				if($aa == 1 && $bb == 0  )
				{ 
				?>
				<INPUT type="button" value="Aceptar" class="botones" onClick="validar_abonos()">
				<?PHP } ?>
				<input name="button" type="button" class="botones" onClick="validar_cacelar()" value="Cancelar" />
				<INPUT type="hidden"  name="leotabla" value = "<? echo str_replace("\"","'",$tabla);   ?>">
				<!--<textarea style="display:inline" name="observacion"><?=$tabla?></textarea>-->
				</TD>
	</TR>
	
	<input type="hidden" name="observaciones" value="<?=$observaciones?>">
	<input type="hidden" name="cheq_abo" value="<?=$total_cheques?>">
	<input type="hidden" name="efec_abo" value="<?=$total_efectivo?>">
	</FORM>
</TABLE>
<?PHP
if($aa==1)
{
	echo $mensaje;
}

?>
<FORM method="POST" action="con_abono.php" name="myForm">
<input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
<input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
<input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
</FORM>
</body>