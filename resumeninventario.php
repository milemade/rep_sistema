<style type="text/css">
<!--
.tit {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bolder;
	color: #000000;
	
}
.tex {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
-->
</style>
<script language="javascript">
function imprimir(){
	document.getElementById('opciones').style.display="none";
	window.print();
}
</script>
<table width="600" border="0" id="opciones" align="center">
  <tr>
    <td width="311"><form name="nik" method="POST"><table width="300" border="0">
      <tr>
        <td class="tit">Opciones</td>
        <td><select name="opc" id="opc" onchange="this.form.submit();">
          <option value="0">[Seleccione]</option>
          <option value="1">Resumen por Bodega</option>
          <option value="2">Resumen por Codigo y Bodega</option>
        </select></td>
      </tr>
    </table></form></td>
    <td width="279"><div align="right">
      <input type="button" name="button3" id="button3" value="Imprimir" onclick="imprimir()"/>
    </div></td>
  </tr>
</table>

<?
  require_once("lib/database.php");
  if(isset($buscar) && $buscar!='' && $opcionbuscar>0)
  {
       $sql = "SELECT nom_bod, cod_fry_pro,SUM( totalcan ) cantotal, SUM( totalpre ) pretotal
				  FROM infinventario
				  WHERE nom_bod <> ''
				  AND nom_mar <> ''
				  AND nom_tpro <> ''
				  AND nom_pro <> ''
				  AND cod_fry_pro >0
				  AND serial >0
				  AND nom_pes <> '' ";
		
		
    if(isset($buscar) && $opcionbuscar==1)
	{  //Busqueda nombre marca
		$sql .= "AND  nom_mar LIKE '%".$buscar."%'";
	}
	if(isset($buscar) && $opcionbuscar==2)
	{ //Busqueda Codigo producto
		$sql .= "AND  cod_fry_pro= '".$buscar."'";
	}
	if(isset($buscar) && $opcionbuscar==3)
	{ //Busqueda nombre producto
		$sql .= "AND nom_pro LIKE '%".$buscar."%'";
	}
	if(isset($buscar) && $opcionbuscar==4)
	{ // Por nombre de tipo producto
	   $sql .= "AND nom_tpro LIKE '%".$buscar."%'";
	}
	if(isset($buscar) && $opcionbuscar==5)
	{//Nombre de Bodega
		$sql .= "AND nom_bod LIKE '%".$buscar."%'";
	}
	if(isset($buscar) && $opcionbuscar==6)
	{ //Busqueda Pieza/Serial
		$sql .= "AND serial='".$buscar."'";
	}
	$sql .=" GROUP BY nom_bod,cod_fry_pro
				  WITH ROLLUP";
	//echo $sql;
	$db = new Database();
	$db->query($sql);
	?>
<table width="364" border="0" align="center">
<tr>
        <td colspan="4"><table width="300" border="0">
          <tr>
            <td colspan="2" class="tit">RESUMEN INVENTARIO</td>
            </tr>
          <tr>
            <td width="64" class="tit">Usuario</td>
            <td width="226" class="tex"><?=strtoupper($usuario)?></td>
          </tr>
          <tr>
            <td class="tit">Fecha</td>
            <td class="tex"><?=Date('Y-m-d')?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="69" class="tit" align="center">BODEGA</td>
        <td width="67" class="tit" align="center">CODIGO</td>
        <td width="87" class="tit" align="center">CANTIDAD</td>
        <td width="93" class="tit" align="center">VALOR</td>
      </tr>
	  <? while($db->next_row()){
	    $bodega = $db->nom_bod;
		$codigo = $db->cod_fry_pro;
		$cantidad = $db->cantotal;
		$pretotal = $db->pretotal;
		if($bodega!='' && $codigo>0 && $cantidad>0 && $pretotal>0)
		{
	  ?>
      <tr>
        <td class="tex"><?=$bodega?></td>
        <td class="tex"><?=$codigo?></td>
        <td class="tex"><div align="right"><?=number_format($cantidad,2,".",".")?></div></td>
        <td class="tex"><div align="right"><?=number_format($pretotal,0,".",".")?></div></td>
      </tr>
	  <? } ?>
	  <?if($bodega!='' && $codigo=='' && $cantidad>0 && $pretotal>0){?>
	    <tr>
        <td class="tit" colspan=2>TOTAL BODEGA</td>
        <td class="tex"><div align="right"><?=number_format($cantidad,2,".",".")?></div></td>
        <td class="tex"><div align="right"><?=number_format($pretotal,0,".",".")?></div></td>
      </tr>
	  <? } ?>
	  <?if($bodega=='' && $codigo=='' && $cantidad>0 && $pretotal>0){?>
	    <tr>
        <td class="tit" colspan=2>TOTAL</td>
        <td class="tex"><div align="right"><?=number_format($cantidad,2,".",".")?></div></td>
        <td class="tex"><div align="right"><?=number_format($pretotal,0,".",".")?></div></td>
      </tr>
	  <? } ?>
    <? }$db->close(); ?> 
    </table>	
<?  } ?>
<?if($opc==1){?>
<?
  $sql = "SELECT nom_bod, SUM( totalcan ) cantotal, SUM( totalpre ) pretotal
		  FROM infinventario
		  WHERE nom_bod <> ''
		  AND nom_mar <> ''
		  AND nom_tpro <> ''
		  AND nom_pro <> ''
		  AND cod_fry_pro >0
		  AND serial >0
		  AND nom_pes <> ''
		  GROUP BY nom_bod
		  WITH ROLLUP";
$db = new Database();
$db->query($sql);

?>

<table width="600" border="0" align="center">
  <tr>
    <td><table width="334" border="0">
      <tr>
        <td width="69" class="tit" align="center">BODEGA</td>
        <td width="87" class="tit" align="right">CANTIDAD</td>
        <td width="93" class="tit" align="right">VALOR</td>
      </tr>
	  <?
	     while($db->next_row()){
		 $bodega = $db->nom_bod;
		 if($bodega=="")
		    $bodega = "<b>TOTAL</b>";
		 $cantidad = $db->cantotal;
		 $valor = $db->pretotal;
	  ?>  
      <tr>
        <td class="tex"><?=$bodega?></td>
        <td class="tex"><div align="right"><?=number_format($cantidad,2,".",".")?></div></td>
        <td class="tex"><div align="right"><?=number_format($valor,0,".",".")?></div></td>
      </tr>
	 <? } $db->close();?> 
    </table></td>
  </tr>
  
</table>
<? } ?>
<? if($opc==2){?>
<table width="334" border="0" align="center">
      <tr>
        <td colspan="4"><table width="500" border="0" align="center">
          <tr>
            <td colspan="2" class="tit" align="crnter">RESUMEN INVENTARIO BODEGA CODIGO</td>
            </tr>
          <tr>
            <td width="64" class="tit">Usuario</td>
            <td width="226" class="tex"><?=strtoupper($usuario)?></td>
          </tr>
          <tr>
            <td class="tit">Fecha</td>
            <td class="tex"><?=Date('Y-m-d')?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="69" class="tit" align="center">BODEGA</td>
        <td width="67" class="tit" align="center">CODIGO</td>
        <td width="87" class="tit" align="center">CANTIDAD</td>
        <td width="93" class="tit" align="center">VALOR</td>
      </tr>
	  <?    $dbc = new Database();
	        $sqlc = "SELECT nom_bod, cod_fry_pro, SUM( totalcan ) cantotal, SUM( totalpre ) pretotal
						FROM infinventario
						WHERE nom_bod <> ''
						AND nom_mar <> ''
						AND nom_tpro <> ''
						AND nom_pro <> ''
						AND cod_fry_pro >0
						AND serial >0
						AND nom_pes <> ''
						GROUP BY nom_bod, cod_fry_pro
						WITH ROLLUP;";
			$dbc->query($sqlc);
			while($dbc->next_row()){ 
			 $bodega = $dbc->nom_bod;
			 $codigo = $dbc->cod_fry_pro;
			 $cantidad = $dbc->cantotal;
			 $totalpre = $dbc->pretotal;
			 if($bodega!='' && $codigo>0 && $cantidad>0 && $totalpre>0){
			?>
      <tr>
        <td class="tex"><?=$bodega?></td>
        <td class="tex"><?=$codigo?></td>
        <td class="tex"><div align="right"><?=number_format($cantidad,2,".",".")?></div></td>
        <td class="tex"><div align="right"><?=number_format($totalpre,0,".",".")?></div></td>
      </tr>
	  <? } ?>
	  <?if($bodega!='' && $codigo=='' && $cantidad>0 && $totalpre>0){ ?>
	  
	  <tr>
        <td class="tit" colspan="2">TOTAL BODEGA</td>
        <td><div align="right" class="tex"><?=number_format($cantidad,2,".",".")?></div></td>
        <td><div align="right" class="tex"><?=number_format($totalpre,0,".",".")?></div></td>
      </tr>
	  <? } ?>
	  <?if($bodega=='' && $codigo=='' && $cantidad>0 && $totalpre>0){ ?>
	  
	  <tr>
        <td class="tit" colspan="2">TOTAL</td>
        <td><div align="right" class="tex"><?=number_format($cantidad,2,".",".")?></div></td>
        <td><div align="right" class="tex"><?=number_format($totalpre,0,".",".")?></div></td>
      </tr>
	  <? } ?>
	  <? } ?>
    </table>
	<? } ?>