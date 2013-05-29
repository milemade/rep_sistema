<?
include "../lib/sesion.php";
include("../lib/database.php");
			
//echo $codigo;
//echo $nombre_aplicacion;
//exit;
$db = new Database();
$db_ver = new Database();
$sql = "SELECT  *  FROM bodega  WHERE cod_bod=$codigo_bodega";
$db_ver->query($sql);	
if($db_ver->next_row()){ 
	$bodega=$db_ver->nom_bod;

}

?>
<?
				$total=0;
				$sql = " SELECT * FROM kardex	
					INNER JOIN producto ON kardex.cod_ref_kar=producto.cod_pro
					LEFT JOIN 	tipo_producto ON producto.cod_tpro_pro = tipo_producto.cod_tpro 
					LEFT JOIN  marca ON producto.cod_mar_pro = marca.cod_mar
					LEFT JOIN peso ON kardex.cod_talla = peso.cod_pes 
					WHERE kardex.cod_bod_kar=$codigo_bodega and kardex.cant_ref_kar>0 and kardex.cod_bod_kar=$codigo_bodega ";
					if(isset($buscar) && $opcionbuscar==1)
					{
					   $sql.="and marca.nom_mar='".$buscar."'" ;
					}
					if(isset($buscar) && $opcionbuscar==2)
					{
					   $sql.="and producto.cod_fry_pro='".$buscar."'" ;
					}
					if(isset($buscar) && $opcionbuscar==3)
					{
					   $sql.="and producto.nom_pro='".$buscar."'" ;
					}
					if(isset($buscar) && $opcionbuscar==4)
					{
					   $sql.="and tipo_producto.nom_tpro='".$buscar."'" ;
					}
				$sql.="order by nom_pro, cod_talla  ";
				//echo $sql;
					$db->query($sql);
					$estilo="formsleo";
					$sumacantidad = 0;
					$sumadinero = 0;
					
					
				?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}


</script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 
 <style type="text/css">
<!--
.Estilo1 {font-size: 9px}
.Estilo2 {font-size: 9 }
-->
 </style>
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?=$nombre_aplicacion?> -- SALDOS DE BODEGA --</title>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
	  <TD align="center"><table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
        <input type="hidden" name="mapa" value="<?=$mapa?>" />
        <input type="hidden" name="id" value="<?=$id?>" />
        <tr>
          <td width="100%" class='txtablas'><table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
              <tr>
                <td width="14%">&nbsp;</td>
                <td class="ctablaform"><div align="center"><span class="textoproductos1">&nbsp;&nbsp;Bodega:<span class="textotabla01">
                    <?=$bodega?>
                </span></span><span class="textoproductos1">&nbsp;&nbsp;</span></div></td>
              </tr>
          </table></td>
        </tr>
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
        <tr>
          <td width="100%" class='txtablas'><form name="frmbus" id="frmbus" method="POST">
              <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
          </td>
        </tr>
	    <tr>
          <td width="14%">&nbsp;</td>
	      <td class="ctablaform"><div align="center">
	          <table width="715" border="0">
                <tr>
                  <td width="93" class="tituloproductos">Buscar</td>
                  <td width="151"><input type="text" name="buscar" id="buscar" value="<?=$_POST['buscar']?>"/></td>
                  <td width="51" class="tituloproductos">en</td>
                  <td width="195"><select name="opcionbuscar" id="opcionbuscar" class="SELECT">
                      <option value="0">Seleccione</option>
					  <? if($_POST['opcionbuscar']==1)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
                      <option value="1" <?=$selected?>>Nombre Categoria</option>
					  <? if($_POST['opcionbuscar']==2)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
                      <option value="2" <?=$selected?>>Codigo Producto</option>
					  <? if($_POST['opcionbuscar']==3)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
                      <option value="3" <?=$selected?>>Nombre Producto</option>
					  <? if($_POST['opcionbuscar']==4)
					       $selected = "selected";
						 else
						   unset($selected);      ?>
					  <option value="4" <?=$selected?>>Nombre Tipo Producto</option>
                    </select>                  </td>
                  <td width="195"><input class="boton" type="button" name="button2" value="Enviar" onclick="valbuscar()"/></td>
                </tr>
              </table>
	        <input type="hidden" name="codigo_bodega" value="<?=$codigo_bodega?>" /></td>
        </tr>
      </table></form></TD>
  </TR>
		<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>
<style type="text/css">
.botonExcel{cursor:pointer;}
</style>	
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="Exportar_a_Excel" style="border-collapse:collapse;">
               
				 <tr >
            <td  class="botones1">Categoria </td>
            <td  class="botones1">Tipo Producto</td>
			<td  class="botones1">Referencia/Producto</td>
            <td  class="botones1">Codigo</td>
	    <td  class="botones1">Pieza/Serie</td>
			<td   class="botones1">Color</td>
            <td   class="botones1">Cantidad</td>
			<td   class="botones1">Valor Unitario</td>
			<td   class="botones1">Total</td>
			</tr>
				 <? while($db->next_row()){ 	  
					$sumacantidad = $sumacantidad + $db->cant_ref_kar;?>
                <tr id="fila_0"  >
				
                  <td  class="textotabla01"><?=$db->nom_mar?></td>
				  <td  class="textotabla01"><?=$db->nom_tpro?></td>
                  <td  class="textotabla01"><?=$db->nom_pro?></td>
                  <td  class="textotabla01"><?=$db->cod_fry_pro?></td>
                  <td  class="textotabla01"><?=$db->serial?></td>
				  <td colspan="1" class="textotabla01"><?=$db->nom_pes?></td>
				   <td class="textotabla01"><div align="right"><?=number_format($db->cant_ref_kar,2,".",".")?></div></td>
				    <td class="textotabla01"><div align="right"><?=number_format($db->valor_precio,2,".",".")?></div></td>
					<td class="textotabla01"><div align="right"><? echo $total = $db->valor_precio * $db->cant_ref_kar;?></div></td>
			    </tr>
				  
				<?
	               $sumadinero = $sumadinero + $total;
				  } 
				 
				 ?>
				 
				  <tr >
			  
                  <td colspan="9" ><table width="389" border="0" align="right">
                    <tr>
                      <td width="136" class="textotabla01">&nbsp;</td>
                      <td width="62" class="textotabla01">TOTAL</td>
                      <td><div align="right" class="textotabla01" ><?=number_format($sumacantidad,2,".",".")?></div></td>
                      <td width="115" class="textotabla01"><div align="right">TOTAL</div></td>
                      <td width="48" class="textotabla01"><?=number_format($sumadinero,2,".",".")?></td>
                    </tr>
                  </table></td>
				  </tr>
				  <tr >
				    <td colspan="9" >&nbsp;</td>
			    </tr>
              </table></TD>
		  </TR>
			<TR>
			  <TD align="center">             </TD>
		  </TR>
			<TR>
			  <TD align="center"><p></TD>
		  </TR>
</TABLE>

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
	
	<TR><TD colspan="3" align="center"><input name="button" type="button"  class="botones1" id="imp" onClick="imprimir()" value="Imprimir">
        <input name="button" type="button"  class="botones1"  id="cer" onClick="window.close()" value="Cerrar">
		<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<p align="right">Exportar a Excel  <img src="../export_to_excel.gif" class="botonExcel" /></p>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form></TD>
	</TR>

	<TR>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
		<TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
	</TR>
	<TR>
	  <TD align="center">
	