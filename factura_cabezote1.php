<style type="text/css">
<!--
.Estilo43 {font-size: 10px; font-family: Arial, Helvetica, sans-serif; }
.Estilo46 {font-size: 12px}
-->
</style>

<table width="600" border="0" >
  <tr>
    <td colspan="3"><span class="Estilo43">
      <? if ($rem_fac=="remision") { echo " Remision:"; } ?>
      <? if ($rem_fac=="factura") { echo " Factura de venta:"; } ?>
	<? if($es_abono!="si"){?>
	<span class="Estilo46">Factura       No:<? echo $fac_numero; ?></span></span>
	<?  }  ?>  
      </td>
  </tr>
  <tr>
    <td colspan="2"><span class="Estilo43">Fecha:<? echo $fac_fecha; ?></span></td>
    <td width="57%"><span class="Estilo43">
	<? if($es_abono!="si"){?>
	Tipo PAgo :<? echo $tipo_pago; ?>
	<?  }  ?>
	</span></td>
  </tr>
  
  <tr>
    <td width="21%"><span class="Estilo43">Nombre: </span></td>
    <td colspan="2"><span class="Estilo43">
      <?=$razon?>
    </span></td>
  </tr>
  <tr>
    <td><span class="Estilo43">Nit:</span></td>
    <td colspan="2"><span class="Estilo43">
      <?=$nit?>
    </span></td>
  </tr>
  <tr>
    <td><span class="Estilo43">Direccion:</span></td>
    <td colspan="2"><span class="Estilo43">
      <?=$direccion?>
    </span></td>
  </tr>
  <tr>
    <td><span class="Estilo43">Telefono</span></td>
    <td colspan="2"><span class="Estilo43">
      <?=$telefono?>
    </span></td>
  </tr>
  <tr>
    <td colspan="3"><span class="Estilo43" >
	<table width="238" border="0" >
	<tr>
	<td>
	<span class="Estilo43">
      <?=$leyenda?>
	 </span>	</td>
	</tr>
	 </table>
    </span></td>
  </tr>
</table>
