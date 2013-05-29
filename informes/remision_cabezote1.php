<style type="text/css">
<!--
.Estilo43 {font-size: 10px; font-family: Arial, Helvetica, sans-serif; }
.Estilo46 {font-size: 12px}
-->
</style>

<link href="styles1.css" rel="stylesheet" type="text/css" />

<table width="339" border="0" >
  <tr>
    <td colspan="3">
      <span class="subtitulosproductos">
      <? if ($rem_fac=="remision") { echo " Remision:"; } ?>
      <? if ($rem_fac=="factura") { echo " Factura de venta:"; } ?>
	<? if($es_abono!="si"){?>
	</span><span class="tituloproductos">Remision No: <? echo $fac_numero; ?>	
	<?  }  ?>
	</span></td>
  </tr>
  <tr>
    <td colspan="2"><span class="subtitulosproductos">Fecha:  <? echo $fac_fecha; ?></span></td>
    <td width="57%">
	  <span class="subtitulosproductos">
	<? if($es_abono!="si"){?>
	<!--Tipo Pago :--><? //echo $tipo_pago; ?>	
	<?  }  ?>    
    </span></td>
  </tr>
  
  <tr>
    <td width="21%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  
   <tr>
    <td width="21%"><span class="textoproductos1">Nombre: </span></td>
    <td colspan="2">      <span class="textoproductos1">
      <?=$razon?>    
     </span></td>
  </tr>
  <tr>
    <td><span class="textoproductos1">Nit:</span></td>
    <td colspan="2">      <span class="textoproductos1">
      <?=$nit?>    
    </span></td>
  </tr>
  <tr>
    <td><span class="textoproductos1">Direccion:</span></td>
    <td colspan="2">      <span class="textoproductos1">
      <?=$direccion?>    
    </span></td>
  </tr>
  <tr>
    <td><span class="textoproductos1">Telefono</span></td>
    <td colspan="2">      <span class="textoproductos1">
      <?=$telefono?>    
    </span></td>
  </tr>
  <tr>
    <td colspan="3">	<table width="333" border="0" >
	  <tr>
	    <td><span ><span class="textoproductos1">
	      <? //$leyenda?>
	    </span></span></td>
	    </tr>
    </table>    </td>
  </tr>
</table>
