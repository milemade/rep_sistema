<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?

//echo $codigo."===";

if ($codigo!=0) {
	$sql ="select * , bodega1.nom_bod as nom_cliente from m_factura inner join usuario on usuario.cod_usu=m_factura.cod_usu inner join bodega1 on bodega1.cod_bod=m_factura.cod_cli inner join bodega on bodega.cod_bod =m_factura.cod_bod inner join rsocial on rsocial.cod_rso =m_factura.cod_razon_fac where cod_fac=$codigo";
	$dbdatos_edi= new  Database();
	$dbdatos_edi->query($sql);
	$dbdatos_edi->next_row();
}



if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	/*$db6 = new Database();
	$sql = "select num_fac_rso + 1  as  num_factura from rsocial WHERE cod_rso=$empresa ";
	$db6->query($sql);	
	if($db6->next_row())
		$num_factura = $db6->num_factura;
	
	//ACTUALIZA LA ULTIMA FACTURA
	$db2 = new Database();
	$sql = "UPDATE rsocial SET num_fac_rso = $num_factura  WHERE  cod_rso=$empresa";
	$db2->query($sql);	
		
	if($Credito=="") $tipo_pago="Contado"; else  $tipo_pago="Credito";
	
	$compos="(cod_usu, cod_cli,fecha,num_fac,cod_razon_fac,tipo_pago,obs,tot_fac,cod_bod)";
	
	$valores="('".$global[2]."','".$cliente_fac."','".$fecha_fac."','".$num_factura."','".$empresa."','".$tipo_pago."','".$observaciones."','".$todocompra."','".$bodega_fac."')" ;
	
	$ins_id=insertar_maestro("m_factura",$compos,$valores); 	

	if($tipo_pago != 'Contado' ) {
		$sql = "INSERT INTO cartera_factura ( fec_car_fac, cod_fac) VALUES( '$fecha_fac', '$ins_id');";
		$db2->query($sql);	
	}
	
	if ($ins_id > 0) 
	{
		//insercion del credito
		$compos="(cod_mfac,cod_tpro,cod_cat,cod_peso, cod_pro, cant_pro, val_uni, total_pro) ";
		for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 
		{
			if($_POST["codigo_referencia_".$ii]!=NULL) 
			{
				$val_uni=$_POST["costo_ref_".$ii] / $_POST["cantidad_ref_".$ii];				
				$valores="('".$ins_id."','".$_POST["codigo_tipo_prodcuto_".$ii]."','".$_POST["codigo_marca_".$ii]."','".$_POST["codigo_peso_".$ii]."','".$_POST["codigo_referencia_".$ii]."','".$_POST["cantidad_ref_".$ii]."','".$_POST["costo_ref_uni_".$ii]."','".$_POST["costo_ref_total_".$ii]."')";
				$error=insertar("d_factura",$compos,$valores); 
				
				kardex("resta",$_POST["codigo_referencia_".$ii],$bodega_fac,$_POST["cantidad_ref_".$ii],$_POST["costo_ref_".$ii],$_POST["codigo_peso_".$ii]);
			}	
		}
		header("Location: con_venta.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>"; 	
*/
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {font-size: 12px}
</style> 

<? inicio() ?>

<?

	$dbdatos_cliente= new  Database();
	
?>


<script language="javascript">
</script>

<script type="text/javascript" src="js/js.js"></script>
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<link href="informes/styles.css" rel="stylesheet" type="text/css" />
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_venta.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_venta.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="#"></a></td>
        <td width="70" class="ctablaform">&nbsp;</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">

          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" /> </td>
        
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">FACTURACION :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td width="62" class="textotabla1">Fecha:</td>
        <td width="275" class="subtitulosproductos"><?=$dbdatos_edi->fecha?>
          <input name="fecha_fac" id="fecha_fac" type="hidden" value="<?=$dbdatos_edi->fecha?>"  /></td>
        <td width="20" class="textorojo">*</td>
        <td width="77" class="textotabla1">Vendedor:</td>
        <td width="145"  class="subtitulosproductos">
		<?
		if ($codigo!=0) echo $dbdatos_edi->nom_usu;
		else  echo $global[3];
		
		?>
		<input name="vendedor" id="vendedor" type="hidden" value="<?=$global[2]?>"></td>		 
        <td width="171" class="textorojo">&nbsp;</td>
       </tr>
	   <tr>
        <td width="62" height="24" class="textotabla1">Empresa:</td>
        <td width="275" class="subtitulosproductos">
		<?
	
		echo $db->nom_rso;
	
		?>
		<input name="empresa" id="empresa" type="hidden" value="<?=$empresa?>"></td>
        <td width="20" class="textorojo">*</td>
        <td width="77" class="textotabla1"> Bodega:</td>
        <td class="subtitulosproductos"><span class="textoproductos1">
          <?
		?>
          <input name="bodega_fac" id="bodega_fac" type="hidden" value="<?=$bodega?>">
        </span></td>		 
        <td width="171" >
			<input name="precio_lista" id="precio_lista" type="hidden" class="subtitulosproductos" />
		</td>
       </tr>
	   <tr>
        <td width="62" class="textotabla1">Cliente:</td>
        <td width="275" class="subtitulosproductos">
		<?
		echo $db->nom_bod;	
		?>
		<input name="cliente_fac" id="cliente_fac" type="hidden" value="<?=$cliente?>"></td>
        <td width="20" class="textorojo">*</td>
        <td width="77" class="textotabla1">&nbsp;</td>
        <td colspan="2"><div id="cupo" style="display:none">
          <span class="textotabla1">Cupo:<span class="textorojo">
          <input name="cupo_credito" id="cupo_credito" type="hidden" class="caja_resalte1"  readonly="-1"/>
          </span></span>		  </div>		  
		<span  id="div_credito" style="display:none" class="textoproductos1"> 
		$  <?=number_format($cupo_covinoc ,0,",",".")?>
		<input name="cupo_covinoc" type="hidden" id="cupo_covinoc"  value="<?=$cupo_covinoc?>" readonly="-1" align="right"/>
		</span>
		<textarea name="tipo_referencias"  id="tipo_referencias"   cols="45" rows="4"  style="display:none"></textarea></td>		 
        </tr>
	   <tr>
        <td colspan="7" class="textotabla1" >
		<table  width="100%" border="1">
		      
		  <tr >
		  <td width="4%">
			  <table width="100%">
				<tr id="fila_0">
				
				<td width="14%"  class="ctablasup">Categoria</td>
				<td width="21%"  class="ctablasup">Tipo Producto </td>
				<td width="20%"   class="ctablasup">Referencia</td>
				<td width="9%"  class="ctablasup">Codigo</td>
				<td width="8%"  class="ctablasup">Talla</td>
				<td width="8%"   class="ctablasup">Cantidad</td>
				<td width="13%"    class="ctablasup">Valor</td>
				<td width="7%" class="ctablasup" align="center">Cambiar</td>
				</tr>
				<?
				if ($codigo!="") { // BUSCAR DATOS
					$sql =" select * from d_factura inner join tipo_producto on d_factura.cod_tpro=tipo_producto.cod_tpro
inner join marca on d_factura.cod_cat=marca.cod_mar inner join peso on d_factura.cod_peso= peso.cod_pes inner join producto  on d_factura.cod_pro= producto.cod_pro where cod_mfac =$codigo order by cod_dfac ";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;

					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_$jj'>";

						echo "<td  ><INPUT type='hidden'  name='codigo_marca_$jj' value='$dbdatos_1->cod_cat'><span class='textfield01'> $dbdatos_1->nom_mar </span> </td>";	
						
						//tipo de producto
						echo "<td><INPUT type='hidden'  name='codigo_tipo_prodcuto_$jj' value='$dbdatos_1->cod_tpro'><span  class='textfield01'> $dbdatos_1->nom_tpro </span> </td>";						
						//referencia
						echo "<td  ><INPUT type='hidden'  name='codigo_referencia_$jj' value='$dbdatos_1->cod_pro_1'><span  class='textfield01'> $dbdatos_1->nom_pro </span> </td>";
						//% codigo barra
						echo "<td ><INPUT type='hidden'  name='codigo_fry_$jj' value='$dbdatos_1->cod_fry_pro'><span  class='textfield01'> $dbdatos_1->cod_fry_pro </span> </td>";
						//talla
						echo "<td   ><INPUT type='hidden'  name='codigo_peso_$jj' value='$dbdatos_1->cod_peso'><span  class='textfield01'> $dbdatos_1->nom_pes </span> </td>";
						//cantidad
						echo "<td align='right'><INPUT type='hidden'  name='cantidad_ref_$jj' value='$dbdatos_1->cant_pro'><span  class='textfield01'>".number_format($dbdatos_1->cant_pro ,0,",",".")."  </span> </td>";	
						//costo
						echo "<td align='right'><INPUT type='hidden'  name='costo_ref_$jj' value='$dbdatos_1->total_pro'><span  class='textfield01'>".number_format($dbdatos_1->total_pro ,0,",",".")."  </span> </td>";	
						//boton q quita la fila
						echo "<td><div align='center'>	
<INPUT type='button' class='botones' value='Cambiar' onclick='removerFila_entrada(\"fila_$jj\",\"val_inicial\",\"fila_\",\"$dbdatos_1->total_pro\");'>
						</div></td>";
						echo "</tr>";
						$jj++;
					}
				}
				?>
				</table>			</td>
			</tr>			
		 <tr >
		  <td>
			  <table width="100%">
				<tr >
				<td  class="ctablasup"><div align="left">Observaciones:</div></td>
				<td  class="ctablasup"><div align="right">Resumen Venta </div></td>
				</tr>
				<tr >
				<td width="47%" ><div align="left" >
				  <textarea name="observaciones" cols="45" rows="3" class="textfield02"  onchange='buscar_rutas()' ><?=$dbdatos->obs_tras?></textarea>
				</div>				  </td>
				<td width="53%" ><div align="right"><span class="ctablasup">Total  Venta:</span>
				    <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos_edi->tot_fac; else echo "0"; ?>"/>
				  </div></td>
				</tr>
				</table>			  </td>
			</tr>
		</table>
		  </table>
	    </td>
	  </tr>
	  <tr> 
		  <td colspan="8" >		  </td>
	  </tr>
    </table>
<tr>

  <tr>
    <td>
	<input type="hidden" name="val_inicial" id="val_inicial" value="<? if($codigo!=0) echo $jj-1; else echo "0"; ?>" />
	<input type="hidden" name="guardar" id="guardar" />
		 <?  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
	   <input type="hidden" id="valDoc_inicial" value="<?=$valueInicial?>"> 
	   <input type="hidden" name="cant_items" id="cant_items" value=" <?  if ($codigo!="") echo $aa; else echo "0"; ?>">
	</td>
  </tr>
  
</table>
</form> 
</div>
</body>
</html>
