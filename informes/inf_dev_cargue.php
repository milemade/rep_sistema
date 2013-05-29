<?
include "../lib/sesion.php";
include("../lib/database.php");
			
//echo $codigo;
//echo $nombre_aplicacion;
//exit;
$db = new Database();
$db_ver = new Database();
$sql = "SELECT  *  FROM m_dev_entrada inner join proveedor ON m_dev_entrada.cod_prove_mdent=proveedor.cod_pro WHERE cod_mdent=$codigo";
$db_ver->query($sql);	
if($db_ver->next_row()){ 
	$fecha=$db_ver->fec_mdent;
	$obser=$db_ver->obs_mdent;
	$proveedor=$db_ver->nom_pro;

	$factura=$db_ver->fac_mdent;	
	$total_nuevo_saldo=$db_ver->total_mdent;
	$numero_doc=$db_ver->cod_mdent;
}

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
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?=$nombre_aplicacion?> -- DEVOLUCION DE INVENTARIO --</title>
 <style type="text/css">
<!--
.Estilo4 {font-size: 18px}
-->
 </style>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">

			<TR>
			  <TD colspan="2" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" rowspan="2"><span class="Estilo4">DEVOLUCION DE INVENTARIOS</span> </td>
				    <td width="22%" height="22" class="ctablaform"> <span class="textoproductos1"> &nbsp;&nbsp;&nbsp;&nbsp;Fecha:<span class="textotabla01">
                    <?=$fecha?>
				    </span></span></td>
			  	   
			  	    <td width="31%" class="ctablaform"><span class="textoproductos1">Numero Doc: &nbsp;<?=$numero_doc?></span></td>
			  	</tr>
			  	<tr>
			  	  <td  class="ctablaform"><span class="textoproductos1">&nbsp;&nbsp;Factura No :<span class="textotabla01">
			  	    <?=$factura?>
			  	  </span></span><span class="textoproductos1">&nbsp;&nbsp;</span></td>
			      <td  class="ctablaform"><span class="textoproductos1">Proveedor:<span class="textotabla01">
                  <?=$proveedor?>
                  </span></span></td>
			  	</tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD colspan="2" align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
                
				  <tr >
            <td  class="botones1">Tipo Producto </td>
            <td  class="botones1">Proveedor</td>
			<td  class="botones1">Referencia</td>
            <td  class="botones1">Codigo</td>
			 <td   class="botones1">Talla/Color</td>
            <td   class="botones1">Cantidad</td>
			<td    class="botones1">Costo</td>
          </tr>
				<?

				$total=0;
				$sql = "  SELECT * FROM d_dev_entrada INNER JOIN tipo_producto ON tipo_producto.cod_tpro=d_dev_entrada.cod_tpro_ddent INNER JOIN marca ON marca.cod_mar=d_dev_entrada.cod_mar_ddent INNER JOIN peso ON peso.cod_pes=d_dev_entrada.cod_pes_ddent INNER JOIN producto ON producto.cod_pro=d_dev_entrada.cod_ref_ddent WHERE cod_ment_ddent=$codigo order by cod_ddent   ";
					$db->query($sql);
					$estilo="formsleo";
					while($db->next_row()){ 	
						
				?>
                <tr id="fila_0"  >
                  <td  class="textotabla01"><?=$db->nom_tpro?></td>
				  <td  class="textotabla01"><?=$db->nom_mar?></td>
                  <td colspan="1" class="textotabla01"><?=$db->cod_fry_pro?></td>
                  <td  class="textotabla01"><div align="right"><?=$db->nom_pro?></div></td>
                  <td  class="textotabla01"><div align="right">
                    <?=$db->nom_pes?></div></td>
				   <td class="textotabla01"><div align="right"><?=number_format($db->cant_ddent,0,".",".")?></div></td>
				 <td  class="textotabla01"><div align="right"><?=number_format($db->cos_ddent,0,".",".")?></div></td>
                </tr>
				  
				<?
	
				  } 
				 
				 ?>
				 
				  <tr >
			  
                  <td colspan="7" >
				  <table  width="100%"  > 
				  <tr>
				  <td class="subfongris"><div align="right">Total Devolucion </div></td>
				    <td><div align="right"><span class="tituloproductos">
				      <?=number_format($total_nuevo_saldo,0,".",".")?> 
			        </span></div></td>	
				  </tr>
				  </table>				  </td>
				  </tr>
              </table></TD>
		  </TR>
			<TR>
			  <TD colspan="2" align="center">             </TD>
		  </TR>
			<TR>
			  <TD colspan="2" align="center"><p></TD>
		  </TR>
			<TR>
			
			
			
			  <TD width="13%" height="40" align="center" valign="top"><div align="center" class="textoproductos1">
			    <div align="left" class="subtitulosproductos">Observaciones:			    </div>
			  </div></TD>
		      <TD width="87%" valign="top" ><span class="textotabla01">
		        <?=$obser?> 
		      </span></TD>
			</TR>
</TABLE>

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
	
	<TR><TD colspan="3" align="center"><input name="button" type="button"  class="botones1" id="imp" onClick="imprimir()" value="Imprimr">
        <input name="button" type="button"  class="botones1"  id="cer" onClick="window.close()" value="Cerrar"></TD>
	</TR>

	<TR>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
		<TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
	</TR>
	<TR>
	  <TD align="center">
	