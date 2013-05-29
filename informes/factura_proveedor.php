<link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles1.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles2.css" rel="stylesheet" type="text/css" />
<link href="styles1.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo12 {font-size: 10px; font-family: Arial, Helvetica, sans-serif; }
-->
</style>
<table width="300" border="0">
   <tr>
    <td width="23%"><span class="textoproductos1">Vendido a : </span></td>
    <td width="77%">
      <span class="textoproductos1">
      <?
		  	$db_cliente = new Database();
			$db_fecha = new Database();
			$sql ='select * from proveedor where cod_pro='.$codigo_salida;
			$db_cliente->query($sql);
			if($db_cliente->next_row()){ 
				
				/*$sql_fecha="select date_add('$fac_fecha',INTERVAL $db_cliente->dias_credito DAY ) as fecha_vencimineto_factura";
				$db_fecha->query($sql_fecha);
				if($db_fecha->next_row()){ 
					$fecha_vencimineto_factura=$db_fecha->fecha_vencimineto_factura;
				}	*/
				
			?>      
      <? echo $db_cliente->nom_pro; ?> </span></td>
  </tr>
  <tr>
    <td><span class="textoproductos1">Nit/C.C.:</span></td>
    <td><span class="textoproductos1"><? echo $db_cliente->ident_pro; ?></span></td>
  </tr>
  <tr>
    <td><span class="textoproductos1">Direccion:</span></td>
    <td><span class="textoproductos1"><? echo $db_cliente->direccion_pro;?></span></td>
  </tr>
  <tr>
    <td><span class="textoproductos1">Telefono</span></td>
    <td><span class="textoproductos1"><? echo $db_cliente->tel_pro;?></span></td>
  </tr>
  
    <? } ?>
</table>
