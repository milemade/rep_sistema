<? include("../js/funciones.php")?>
<? include("../lib/database.php")?>

<link href="informes/styles.css" rel="stylesheet" type="text/css" />

<link href="informes/styles1.css" rel="stylesheet" type="text/css" />

<link href="styles.css" rel="stylesheet" type="text/css" />

<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />

<link href="css/styles2.css" rel="stylesheet" type="text/css" />

<link href="css/styles.css" rel="stylesheet" type="text/css" />

<title>CARTERA</title><TABLE width="100%" border="1" cellpadding="2" cellspacing="0"   class="textoproductos1">

<?
$db = new Database();
$db1 = new Database();
$sql="SELECT * from proveedor where cod_pro=$proveedor";
$db->query($sql);	
$num1 = $db->num_rows();
while($db->next_row())
{
$cod_proveedor=$db->cod_prove_ment;
?>
	<TR>
	  <TD height="16" class="botones1"><span class="botones"> PROVEEDOR: </span></TD>
	  <TD colspan="2"  class="botones1"><span class="botones"><?=$db->nom_pro?></span></TD>
	  <TD width="6%"  class="botones1"><span class="botones">NIT: </span></TD>
	  <TD colspan="5" class="botones1"><span class="botones"><?=$db->ident_pro?></span></TD>
  </TR>
	<TR>
      <!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->
	  <TD width="14%" height="16" class="boton"><div align="center">DOCUMENTO </div></TD><!--nom_tdoc-->
	  <TD width="13%"  class="boton">No</TD><!--cod_doc_ccom-->
	  <TD width="13%"  class="boton">Num Factura</TD><!--cod_doc_ccom-->
	  <TD colspan="2"  class="boton"><div align="center">DECRIPCI&Oacute;N DEL ABONO </div></TD><!--anotacion-->
	  <TD width="10%" class="boton"><div align="center">FECHA</div></TD><!--fec_ccom-->
      <TD colspan="2" class="boton"><div align="center">DEBITO</div></TD>
	  <TD width="8%" class="boton"><div align="center">CREDITO</div></TD>
      <!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<?
	    $sql1="SELECT a.cod_doc_ccom, 
			   a.cod_tdoc_ccom, 
			   a.fec_ccom, 
			   a.val_ccom, 
			   a.cod_pro_ccom, 
			   b.nom_pro, 
			   c.nom_tdoc, 
			   c.tipo_mov, 
			   d.cod_ment, 
			   d.fac_ment, 
			   d.fec_ment, 
			   d.total_ment, 
			   d.cod_prove_ment, 
			   b.nom_pro, 
			   d.est_ment, 
			   d.sal_ant_ment, 
			   e.cod_abo, 
			   e.anotacion 
		      FROM cartera_compras a
		      JOIN proveedor b ON a.cod_pro_ccom = b.cod_pro 
		      JOIN tipo_documento c ON (a.cod_tdoc_ccom = c.cod_tdoc) 
		      LEFT JOIN m_entrada d ON (d.cod_ment = a.cod_doc_ccom) 
		      LEFT JOIN abono_pago e ON (e.cod_abo = a.cod_doc_ccom) 
		      WHERE a.cod_pro_ccom = $proveedor 
              and a.fec_ccom >= '$fec_ini' AND a.fec_ccom <= '$fec_fin' 
			  ORDER BY a.fec_ccom asc;";
	$db1->query($sql1);
	$num2 = $db1->num_rows();
	$total_devito=0;	
	$total_credito=0;	
	$total_saldo=0;
	while($db1->next_row())
	{
	?>
	<TR>
		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->
		<TD width="14%" height="16" class="textfield"><?=$db1->nom_tdoc?>&nbsp;</TD>
		<TD  class="textfield"><?=$db1->cod_doc_ccom?>&nbsp;</TD>
		<TD  class="textfield"><?=$db1->fac_ment?>&nbsp;</TD>
		<TD colspan="2"  class="textfield"><?=$db1->anotacion?>&nbsp;</TD>
		<TD class="textfield"><?=$db1->fec_ccom?>&nbsp;</TD>
		<? if($db1->tipo_mov=="RESTA") {
			$total_devito=$total_devito+$db1->val_ccom;
			$valor_debito=$db1->val_ccom;
			//if($db1->cod_tdoc_ccom==4) //Si es nota compra
			   //$total_credito = $total_credito-$db1->val_ccom;
		 } 
		 else 
		 	$valor_debito=0;
		 ?>
		<TD colspan="2" class="textfield"><div align='right'>&nbsp;<?=number_format($valor_debito,0,".",".")?>&nbsp;</div></TD>
		<? if($db1->tipo_mov=="SUMA") {
			$total_credito=$total_credito+$db1->val_ccom;
			$valor_credito=$db1->val_ccom;
		 } 
		 else 
		 	$valor_credito=0;
		 ?>
			<TD  class="textfield">
				<div align='right'>&nbsp;<?=number_format($valor_credito,0,".",".")?>&nbsp;</div>			</TD>
	</TR>
	<?	
	}
	?>
   <TR>
		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->
		<TD height="16" colspan="5" class="textfield100"><span class="textfield"><strong>SUBTOTALES&nbsp;</strong></span></TD>
		<TD width="10%" height="16" class="textfield100">&nbsp;</TD>
		<TD colspan="2" class="textfield100"><strong><div align='right'>&nbsp;<?=number_format($total_devito,0,".",".")?>&nbsp;</div></strong></TD>
		<TD width="8%" class="textfield100"><strong><div align='right'>&nbsp;<?=number_format($total_credito,0,".",".")?></div></strong></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
<?
}
?>
	<TR>
		<TD height="16" class="subtitulosproductos">TOTAL SALDO:</TD>
		<TD height="16" colspan="4" class="subtitulosproductos"><strong><div align='right'><strong><?=number_format($total_credito- $total_devito,0,".",".")?></strong>&nbsp;&nbsp;</div></strong></TD>
		<TD height="16" colspan="5" class="subtitulosproductos">&nbsp;</TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	  <TD height="16" colspan="9" class="tituloproductos" align="center"><INPUT type="button" value="Imprimir" class="botones"  onclick="abrir()">	</TR>
</TABLE>
<script>
function abrir(){
	window.print();
}
</script>
<?php if($num1>0)$db->close(); ?>
<?php if($num2>0) $db1->close(); ?>
