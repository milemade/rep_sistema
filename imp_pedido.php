<? include("lib/database.php")?>
<? include("js/funciones.php")?>

<?
$dbcos= new  Database();
$sql = " SELECT * FROM proyecto WHERE cod_pro=".$global[0];
$dbcos->query($sql);
$dbcos->next_row();

 ?>

<style type="text/css">
<!--
.Estilo1 {font-family: "Times New Roman", Times, serif}
.Estilo6 {font-size: 12px}
.Estilo9 {font-weight: bold; font-family: "Times New Roman", Times, serif;}
-->
</style>
<table width="616" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<? 
	echo $sql = " SELECT * FROM pedido INNER JOIN almacen ON almacen.cod_alm=pedido.cod_alm_ped  INNER JOIN proveedor ON
			    proveedor.cod_pro=pedido.cod_pro_ped INNER JOIN  usuario  ON  usuario.cod_usu =pedido.cod_usu_ped 	WHERE cod_ped=".$codigo;
	$dbcos->query($sql);
	$dbcos->next_row();
  ?>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="28%" rowspan="2"><span class="Estilo6"><img src="imp_pedido_clip_image002.gif" alt="." width="122" height="65" class="Estilo1" /></span></td>
        <td height="39" colspan="3"><span class="Estilo9">
          <?=$dbcos->nom_pro?>
        </span></td>
        <td width="22%" rowspan="2"><div align="right"><span class="Estilo6"><img src="imp_pedido_clip_image002.gif" alt="." width="122" height="65" class="Estilo1" /></span></div></td>
      </tr>
      <tr>
        <td colspan="3"><span class="Estilo9">Contrato No.
              <?=$dbcos->cont_pro?>
        </span></td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="Estilo6"><span class="Estilo1">No.
          <?=completar($db->cod_ped,6)?>
        </span></td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6">&nbsp;</td>
      </tr>
      <tr>
        <td class="Estilo6"><span class="Estilo1">Proveedor:</span></td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6"><span class="Estilo1">No. Dev.</span></td>
      </tr>
      <tr>
        <td class="Estilo6"><span class="Estilo1">Nombre:</span></td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6"><span class="Estilo1">Fecha</span></td>
      </tr>
      <tr>
        <td class="Estilo6"><span class="Estilo1">Fac o Ref:</span></td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6"><span class="Estilo1">Tipo</span></td>
      </tr>
      <tr>
        <td class="Estilo6"><span class="Estilo1">Almacen</span></td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6">&nbsp;</td>
        <td class="Estilo6">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="106"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="6"><div align="center"><strong>DETALLE DEL PEDIDO</strong></div></td>
        </tr>
      <tr>
        <td width="11%" class="Estilo6"><span class="Estilo9">Item</span></td>
        <td width="16%" class="Estilo6"><span class="Estilo9">Codigo</span></td>
        <td width="31%" class="Estilo6"><span class="Estilo9">Descripci&oacute;n</span></td>
        <td width="17%" class="Estilo6"><span class="Estilo9">Cantidad&nbsp;</span></td>
        <td width="13%" class="Estilo6"><span class="Estilo9">Costo</span></td>
        <td width="12%" class="Estilo6"><span class="Estilo9">Total</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20%" class="Estilo9">&nbsp;</td>
          <td width="43%">&nbsp;</td>
          <td width="12%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="Estilo9">Total:</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="Estilo9">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="49"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" height="71"><span class="Estilo9">Observaciones:</span></td>
        <td width="80%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="Estilo9">&nbsp;</td>
        <td width="43%">&nbsp;</td>
        <td width="18%">&nbsp;</td>
        <td width="19%">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" class="Estilo9">Elaborado por: </td>
        <td colspan="3">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

  <? //include("lib/sesion.php")?>
  <? include("lib/database.php")?>
  <?
$sql='SELECT  cod_ped, fec_ped , cod_alm_ped , pri_ped, fec_ent_ped ,  cod_pro_ped ,cod_proy_ped , obs_ped, cod_usu_ped ,nom_alm ,proveedor.nom_pro ,
	proyecto.nom_pro  ,concat(usuario.nom_usu,concat("  ",usuario.ape_usu)) AS usuario FROM pedido  INNER JOIN  almacen  ON almacen.cod_alm=pedido.cod_alm_ped 
	INNER JOIN proveedor ON proveedor.cod_pro=pedido.cod_pro_ped INNER JOIN proyecto ON proyecto.cod_pro=pedido.cod_proy_ped INNER JOIN usuario ON usuario.cod_usu=cod_usu_ped where cod_ped='.$codigo.' order by cod_ped desc '.$paginar ; 
	
//echo $sql;
/*
$db->query($sql);  #consulta paginada
while($db->next_row()) {
	if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
	echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_ped' action='man_pedido.php'>  ";
	echo "<td >".completar($db->cod_ped,6)."</td>";
	echo "<td >$db->fec_ped </td>";
	echo "<td >$db->nom_alm </td>";
	echo "<td aling='center' >"; 
	echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_ped '>";
	if ($editar==1)
		echo "<img src='imagenes/icoeditar.gif' alt='Editar Registro' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_ped.submit()'/></td>";
	else 
		echo "<img src='imagenes/e_icoeditar.gif' width='16' height='16'  /></td>";
	echo 	"<td align='center'>";
	if ($eliminar==1)
		echo"<img src='imagenes/icoeliminar.gif' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_ped) /></td> ";
	else
		echo"<img src='imagenes/e_icoeliminar.gif' width='16' height='16'  /></td> ";
	
	echo" <td> <img src='imagenes/imprimir.png' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=imprimir($global[2],$db->cod_ped) /></td> ";
	echo "  </tr> </table>  </td>  ";
	echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";
	echo "  </form></tr>  ";						
} 
*/
?>
</p>
