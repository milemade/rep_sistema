<?
include "../lib/sesion.php";
include("../lib/database.php");
//echo $codigo;
//echo $nombre_aplicacion;
//exit;
//print_r($_SESSION);
$datetime=Date('Y-m-d H:i:s');
$db = new Database();
$db_ver = new Database();
$sql ="select b.num_fac,d.nom_bod proveedor,b.tot_fac,c.valor_abono,a.val_notc,a.fec_notc,e.nom_usu,b.fecha
	   from notas_ventas a
	   inner join `m_factura` b on  a.`cod_ven_notc`=b.`cod_fac` 
	   INNER JOIN cartera_factura  c ON b.cod_fac = c.cod_fac
	   inner join bodega1 d on d.`cod_bod`=b.`cod_cli` 
	   JOIN usuario e ON e.cod_usu=a.cod_usu_notc where a.cod_notc= '$codigo' ";	
$db_ver->query($sql);	
if($db_ver->next_row()){ 

	$fechanota = $db_ver->fec_notc;
	$fecha = $db_ver->fecha;
	$proveedor = $db_ver->proveedor;
	$numero_factura = $db_ver->num_fac;
	$total_factura = $db_ver->tot_fac;
	$valor_abono = $db_ver->valor_abono;
	$valor_nota = $db_ver->val_notc;
	$saldo_factura = $total_factura - $valor_abono;
	$obs = $db_ver->obs_notc;
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
 <title><?=$nombre_aplicacion?> -- NOTA VENTA --</title>
 <style type="text/css">
<!--
.Estilo4 {font-size: 18px}
-->
 </style>
 <style>
.botones1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
	text-decoration: none;
	background-color: #999999;
}
.textotabla01 {

	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	font-weight: normal;
	color: #000000;
	text-align: left;
	padding-right: 2px;
	padding-left: 5px;
}
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
			  		<td width="47%" rowspan="2"><span class="Estilo4">NOTA VENTA<span> </td>
				    <td width="22%" height="22" class="ctablaform"> <span class="textoproductos1"> &nbsp;&nbsp;Fecha Factura:<span class="textotabla01">
                    <?=$fecha?>
				    </span></span></td>

			  	   

			  	    <td width="51%" class="ctablaform"><span class="textoproductos1">&nbsp;&nbsp;Numero Factura: &nbsp;<?=$numero_factura?></span></td>

			  	</tr>

			  	<tr>

			  	  <td  colspan="2" class="ctablaform"><span class="textoproductos1">&nbsp;&nbsp;Proveedor :<span class="textotabla01">

			  	    <?=strtoupper($proveedor)?>

			  	  </span></span></td>

			      

                  </span></span></td>

			  	</tr>

				</table>					</TD>

		  </TR>

			

			

			<TR>

			  <TD colspan="2" align="center">

			  <table width="800" border="1">
  <tr>
    <td width="98" class="botones1"> Valor Factura</td>
    <td width="285" class="textotabla01"><?=number_format($total_factura,0,",",".")?></td>
    <td width="104" class="botones1">Saldo Factura</td>
    <td width="285" class="textotabla01"><?=number_format($saldo_factura,0,",",".")?></td>
  </tr>
  <tr>
    <td class="botones1">Fecha Nota</td>
    <td class="textotabla01"><?=$fechanota?></td>
    <td class="botones1" class="textotabla01">Valor Nota</td>
    <td class="textotabla01"><?=number_format($valor_nota,0,",",".")?></td>
  </tr>
</table>

                
</TD>

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

		        <?=$obs?> 

		      </span></TD>

			</TR>

</TABLE>



 

<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">

	

	<TR><TD colspan="3" align="center"><input name="button" type="button"  class="botones1" id="imp" onClick="imprimir()" value="Imprimir">

        <input name="button" type="button"  class="botones1"  id="cer" onClick="window.close()" value="Cerrar"></TD>

	</TR>



	<TR>

		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>

		<TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>

		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>

	</TR>

	<TR>

	  <TD align="center">
<?php $db_ver->close(); ?>
<table width="400" border="0">
  <tr>
    <td class="subtitulosproductos" width="79">Usuario</td>
    <td width="305" class="textotabla01"><? echo $global[3]?></td>
  </tr>
  <tr>
    <td class="subtitulosproductos">Fechahora</td>
    <td class="textotabla01"><?=$datetime?></td>
  </tr>
</table>
	