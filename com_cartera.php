<? include("js/funciones.php")?>
<? include("lib/database.php");
$ahora = date("Y-n-j H:i:s");
$_SESSION["ultimoAcceso"] = $ahora;?>
<link href="informes/styles.css" rel="stylesheet" type="text/css" />
<link href="informes/styles1.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<TABLE width="710" border="1" cellpadding="0" cellspacing="0"   class="textoproductos1" align="center">
<?
$db = new Database();
$db1 = new Database();
$sql="select distinct(cod_prove_ment ), nom_pro , ident_pro from m_entrada 
inner join proveedor on m_entrada.`cod_prove_ment`=proveedor.`cod_pro` 
AND m_entrada.remision=0 where m_entrada.`est_ment`<>'CANCELADA' AND m_entrada.remision=0
order by proveedor.nom_pro asc";
$db->query($sql);	
$total_saldo_general=0;
while($db->next_row())
{
$cod_proveedor=$db->cod_prove_ment;
?>
	
	<TR>
		<TD height="16" colspan="2" class="subfongris">PROVEEDOR: </TD>
		<TD height="16" colspan="3" class="subfongris" ><?=$db->nom_pro?>&nbsp;</TD>
		<TD height="16" class="subfongris">NIT: </TD>
		<TD height="16" colspan="5" class="subfongris"><?=$db->ident_pro?>&nbsp;</TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	
	<TR valign="top">
		<TD width="152" height="16" class="textfield" valign="top">FECHA FACTURA </TD>
		<TD width="109" height="16" class="textfield" valign="top">FECHA VENCIMIENTO</TD>
		<TD width="20"  class="textfield" valign="top">No</TD>
		<TD width="53" class="textfield" valign="top">VALOR</TD>
        <TD width="52" class="textfield" valign="top">SALDO</TD>
        <TD width="33" class="textfield" valign="top">No. Dias </TD>
		<TD width="44" class="textfield" valign="top">Sin Vencer</TD>
		<TD width="26" class="textfield" valign="top">30 -59 D. </TD>
        <TD width="33" class="textfield" valign="top">60 - 89 D.</TD>
		<TD width="36" class="textfield" valign="top" >90 - 119 D.</TD>
		<TD width="45" class="textfield" valign="top">MAS DE 120 D.</TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<?
	$sql1="select * ,DATE_ADD(m_entrada.`fec_ment` ,  INTERVAL proveedor.`credito_pro` DAY) as fecha_pago,  abs(DATEDIFF(now(),
DATE_ADD(m_entrada.`fec_ment` , INTERVAL proveedor.`credito_pro` DAY))) as dias_faltantes , DATEDIFF(now(),m_entrada.`fec_ment` ) as dias_cartera  from m_entrada  inner join proveedor on m_entrada.`cod_prove_ment`=proveedor.`cod_pro` AND m_entrada.remision=0 where cod_pro=$cod_proveedor and m_entrada.`est_ment`<>'CANCELADA' and m_entrada.`est_ment`<>'anulado' order by proveedor.cod_pro , fec_ment,fac_ment";

	$db1->query($sql1);
	
	$total_corriente=0;	
	$total_saldo=0;
	$total_30=0;
	$total_60=0;
	$total_90=0;
	$total_120=0;
	
	
	
	while($db1->next_row())
	{
	
		$total_saldo=$total_saldo+($db1->total_ment-$db1->sal_ant_ment);
	?>
	
	<TR>
		<TD width="152" height="16" class="textfield"><?=$db1->fec_ment?>&nbsp;</TD>
		<TD width="109" height="16" class="textfield"><?=$db1->fecha_pago?>&nbsp;</TD>
		<TD  class="textfield"><?=$db1->fac_ment?>&nbsp;</TD>
	  <TD width="53" class="textfield"><div align='right'><?=number_format($db1->total_ment,0,".",".")?>&nbsp;</div></TD>
		<TD width="52" class="textfield">
	  <div align='right'><?=number_format($db1->total_ment-$db1->sal_ant_ment,0,".",".")?>&nbsp;</div>		</TD>
        <TD width="33" class="textfield">&nbsp;<?=$db1->dias_cartera?>&nbsp;</TD> 
		<? 
		if( $db1->dias_cartera <=30) {
			$total_corriente=$total_corriente+($db1->total_ment-$db1->sal_ant_ment);
			$total_cor=$db1->total_ment-$db1->sal_ant_ment;
			 $arreglosinven[$db1->cod_pro] += $db1->total_ment-$db1->sal_ant_ment;
			 $sinven+=$db1->total_ment-$db1->sal_ant_ment;
			 
		?>
		<? } ?>
			<TD width="44" class="textfield">
	  <div align='right'>&nbsp;<?=number_format($total_cor,0,".",".")?>&nbsp;</div>			</TD>
		
		<? $total_cor=0 ?>
		
		
		
		<? if($db1->dias_cartera>=30 &&  $db1->dias_cartera<60 ) {
			$total_30=$total_30+($db1->total_ment-$db1->sal_ant_ment);
			$total_30_c=$db1->total_ment-$db1->sal_ant_ment;
			 $arreglo30[$db1->cod_pro] += $db1->total_ment-$db1->sal_ant_ment;
			 $arreglo3059+=$db1->total_ment-$db1->sal_ant_ment;
		?>
		<? } ?>
			<TD width="26" class="textfield">
	  <div align='right'>&nbsp;<?=number_format($total_30_c,0,".",".")?>&nbsp;</div>			</TD>		
		
		<? $total_30_c=0 ?>
		
		<? if($db1->dias_cartera>=60 &&  $db1->dias_cartera<90) { 
			$total_60=$total_60+($db1->total_ment-$db1->sal_ant_ment);
			$total_60_c=$db1->total_ment-$db1->sal_ant_ment;
			 $arreglo60[$db1->cod_pro] += $db1->total_ment-$db1->sal_ant_ment;
			$arreglo6089+= $db1->total_ment-$db1->sal_ant_ment;
		?>
		<? } ?>
			<TD width="33" class="textfield">
	  <div align='right'>&nbsp;<?=number_format($total_60_c,0,".",".")?>&nbsp;</div>			</TD>		
		
		<? $total_60_c=0 ?>
		
		<? if($db1->dias_cartera>=90 &&  $db1->dias_cartera<120 ) {
			$total_90=$total_90+($db1->total_ment-$db1->sal_ant_ment);			
			$total_90_c=$db1->total_ment-$db1->sal_ant_ment;
			 $arreglo90[$db1->cod_pro] += $db1->total_ment-$db1->sal_ant_ment;
			 $arreglo90119+= $db1->total_ment-$db1->sal_ant_ment;
			
		?>
		
		<? } ?>
			<TD width="36" class="textfield">
	  <div align='right'>&nbsp;<?=number_format($total_90_c,0,".",".")?>&nbsp;</div>			</TD>		
		
		<? $total_90_c=0 ?>
		
		
		<? if($db1->dias_cartera>=120) {
			$total_120=$total_120+($db1->total_ment-$db1->sal_ant_ment);
			$total_120_c=$db1->total_ment-$db1->sal_ant_ment;
			$arreglo120[$db1->cod_pro] += $db1->total_ment-$db1->sal_ant_ment;
			$arreglo1201+= $db1->total_ment-$db1->sal_ant_ment;
		?>
		<? } ?> 
			<TD width="45" class="textfield">
	  <div align='right'>&nbsp;<?=number_format($total_120_c,0,".",".")?>&nbsp;</div>			</TD>		
		
		<? $total_120_c=0 ?>
	</TR>
	<?
	
	$total_corriente_general= $total_corriente_general +  $total_corriente;	
	$total_saldo_general=$total_saldo_general + $total_saldo ;
	$total_30_general= $total_30_general + $total_30;
	$total_60_general = $total_60_general + $total_60;
	$total_90_general=$total_90_general + $total_90;
	$total_120_general=$total_120_general + $total_120 ;
	$total_120_general= $total_120 ;
	
	 $arregloLiq[$db1->cod_pro] += $db1->total_ment-$db1->sal_ant_ment;
	 $cantidadPrimer += $db1->total_ment-$db1->sal_ant_ment;



}

	
	
	?>

	<TR>
		<TD height="16" colspan="3" class="textfield100"><strong>SUBTOTALES&nbsp;</strong></TD>
		<TD height="16" class="textfield100">&nbsp;</TD>
		<TD height="16" class="textfield100"><strong><?=number_format($total_saldo,0,".",".")?>&nbsp; </strong></TD>
		<TD height="16" class="textfield100">&nbsp;</TD>
		<TD class="textfield100"><strong><?=number_format($total_corriente,0,".",".")?>&nbsp; </strong></TD>
		<TD class="textfield100"><strong><?=number_format($total_30,0,".",".")?>&nbsp; </strong></TD>
		<TD class="textfield100"><strong><?=number_format($total_60,0,".",".")?>&nbsp; </strong></TD>
		<TD class="textfield100"><strong><?=number_format($total_90,0,".",".")?>&nbsp; </strong></TD>
		<TD class="textfield100"><strong><?=number_format($total_120,0,".",".")?>&nbsp; </strong></TD>
	</TR>
	
	<TR>
		<TD height="16" colspan="11" class="textoproductos1"><HR width="580" /></TD>
	</TR>	
<?

} 
if(count($arregloLiq)>0)
{
   arsort($arregloLiq);
foreach($arregloLiq as $codPro=>$cant)
{
 $cant."<br>";
}
}
   if(count($arreglosinven)>0)
   {	
		arsort($arreglosinven);
		foreach($arreglosinven as $codPro=>$cants)
		{
		$cants."<br>";	
		}	
	}
if(count($arreglo30)>0)
{
	arsort($arreglo30);
	foreach($arreglo30 as $codPro=>$cantse)
	{
	 $cantse."<br>";	
	}	
}
if(count($arreglo60)>0)
{
	arsort($arreglo60);
	foreach($arreglo60 as $codPro=>$cants60)
	{
	  $cants60."<br>";	
	}	
}
if(count($arreglo90)>0)
{
	arsort($arreglo90);
	foreach($arreglo90 as $codPro=>$cants90)
	{
	 $cants90."<br>";	
	}	
}

if(count($arreglo120)>0)
{
	arsort($arreglo120);
	foreach($arreglo120 as $codPro=>$cants120)
	{
	 $cants120."<br>";	
	}
}	
?>
	
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL SALDOS:
	    <?=number_format($cantidadPrimer,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL SIN VENCER:
	    <?=number_format($sinven,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 30-59 DIAS:
	    <?=number_format($arreglo3059,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 60-89 DIAS:
	    <?=number_format($arreglo6089,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 90-119 DIAS:
	    <?=number_format($arreglo90119,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL MAS DE 120 DIAS:
	    <?=number_format($arreglo1201,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	  <TD height="16" colspan="11" class="tituloproductos" align="center">
		
	  <INPUT type="button" value="Imprimir" class="botones"  onclick="abrir()">	</TR>
</TABLE>

<script>
function abrir(){
	window.print();
}
</script>
<?php if($db->num_rows()>0) $db->close(); ?>
<?php if($db1->num_rows()>0) $db1->close(); ?>
