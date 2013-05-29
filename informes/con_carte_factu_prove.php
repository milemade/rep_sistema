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



$sql="select distinct(cod_prove_ment ), nom_pro , ident_pro from m_entrada  inner join proveedor on m_entrada.`cod_prove_ment`=proveedor.`cod_pro`  where m_entrada.`est_ment`<>'CANCELADA' and cod_prove_ment=$codigo  order by proveedor.nom_pro asc";

$db->query($sql);	

while($db->next_row())

{

$cod_proveedor=$db->cod_prove_ment;

?>

	

	<TR>

	

		<TD height="16" colspan="2" class="subfongris">NOMBRE PROVEEDOR: </TD>

		<TD height="16" colspan="3" class="subfongris" ><?=$db->nom_pro?>&nbsp;</TD>

		<TD height="16" class="subfongris">NIT: </TD>

		<TD height="16" colspan="4" class="subfongris"><?=$db->ident_pro?>&nbsp;</TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	

	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD width="8%" height="16" class="boton">FECHA FACTURA</TD>

		<TD width="4%"  class="boton">No</TD>

		<TD width="6%" class="boton">VALOR</TD>

        <TD width="6%" class="boton">SALDO</TD>

        <TD width="6%" class="boton">DIAS C</TD>

		<TD width="6%" class="boton">C. CORRIENTE </TD>

		<TD width="7%" class="boton" >30 D. </TD>

        <TD width="10%" class="boton">60 D.</TD>

		<TD width="6%" class="boton">90 D.</TD>

		<TD width="6%" class="boton">MAS DE 120 D.</TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<?

	$sql1="select * ,DATE_ADD(m_entrada.`fec_ment` ,  INTERVAL proveedor.`credito_pro` DAY) as fecha_pago,  abs(DATEDIFF(now(),

DATE_ADD(m_entrada.`fec_ment` , INTERVAL proveedor.`credito_pro` DAY))) as dias_faltantes , DATEDIFF(now(),m_entrada.`fec_ment` ) as dias_cartera  from m_entrada  inner join proveedor on m_entrada.`cod_prove_ment`=proveedor.`cod_pro`  where cod_pro=$cod_proveedor and m_entrada.`est_ment`<>'CANCELADA' and m_entrada.`est_ment`<>'anulado' order by proveedor.cod_pro";

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

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD width="8%" height="16" class="textfield"><?=$db1->fec_ment?>&nbsp;</TD>

		<TD  class="textfield"><?=$db1->fac_ment?>&nbsp;</TD>

		<TD width="6%" class="textfield"><div align='right'><?=number_format($db1->total_ment,0,".",".")?>&nbsp;</div></TD>

		<TD width="6%" class="textfield">

		<div align='right'><?=number_format($db1->total_ment-$db1->sal_ant_ment,0,".",".")?>&nbsp;</div>		</TD>

        <TD width="6%" class="textfield">&nbsp;<?=$db1->dias_cartera?>&nbsp;</TD> 

		

		<? 

		//echo $db1->dias_cartera."--";

		if($db1->dias_cartera<30) {

			$total_corriente=$total_corriente+($db1->total_ment-$db1->sal_ant_ment);

		?>

			<TD width="6%" class="textfield">

				<div align='right'>&nbsp;<?=number_format($db1->total_ment-$db1->sal_ant_ment,0,".",".")?>&nbsp;</div>			</TD>

		<? } else { ?>

		<TD width="6%" class="textfield">

				<div align='right'>&nbsp;</div>			</TD>

		<? }?>

		

		<? if($db1->dias_cartera>30 &&  $db1->dias_cartera<60 ) {

			$total_30=$total_30+($db1->total_ment-$db1->sal_ant_ment);

		?>

			<TD width="7%" class="textfield">

				<div align='right'>&nbsp;<?=number_format($db1->total_ment-$db1->sal_ant_ment,0,".",".")?>&nbsp;</div>			</TD>		

		<? } else { ?>

		<TD width="6%" class="textfield">

				<div align='right'>&nbsp;</div>			</TD>

		<? }?>

		

		<? if($db1->dias_cartera>60 &&  $db1->dias_cartera<90) { 

			$total_60=$total_60+($db1->total_ment-$db1->sal_ant_ment);

		?>

			<TD width="10%" class="textfield">

				<div align='right'>&nbsp;<?=number_format($db1->total_ment-$db1->sal_ant_ment,0,".",".")?>&nbsp;</div>			</TD>		

		<? } else { ?>

		<TD width="6%" class="textfield">

				<div align='right'>&nbsp;</div>			</TD>

		<? }?>

		

		

		<? if($db1->dias_cartera>90 &&  $db1->dias_cartera<120 ) {

			$total_90=$total_90+($db1->total_ment-$db1->sal_ant_ment);

		?>

			<TD width="6%" class="textfield">

				<div align='right'>&nbsp;<?=number_format($db1->total_ment-$db1->sal_ant_ment,0,".",".")?>&nbsp;</div>			</TD>		

		<? } else { ?>

		<TD width="6%" class="textfield">

				<div align='right'>&nbsp;</div>			</TD>

		<? }?>

		

		<? if($db1->dias_cartera>120) {

			$total_120=$total_120+($db1->total_ment-$db1->sal_ant_ment);

			//echo "entro";

		?>

			<TD width="6%" class="textfield">

				<div align='right'>&nbsp;<?=number_format($db1->total_ment-$db1->sal_ant_ment,0,".",".")?>&nbsp;</div>			</TD>		

		<? } else { ?>

		<TD width="6%" class="textfield">

				<div align='right'>&nbsp;</div>			</TD>

		<? }?>

	</TR>

	<?

	

	$total_corriente_general= $total_corriente_general +  $total_corriente;	

	$total_saldo_general=$total_saldo_general + $total_saldo ;

	$total_30_general= $total_30_general + $total_30;

	$total_60_general = $total_60_general + $total_60;

	$total_90_general=$total_90_general + $total_90;

	$total_120_general=$total_120_general + $total_120 ;

	

	}

	?>



	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD height="16" colspan="2" class="textfield100"><strong>SUBTOTALES&nbsp;</strong></TD>

		<TD height="16" class="textfield100">&nbsp;</TD>

		<TD height="16" class="textfield100"><strong><?=number_format($total_saldo,0,".",".")?>&nbsp; </strong></TD>

		<TD height="16" class="textfield100">&nbsp;</TD>

		<TD class="textfield100"><strong><?=number_format($total_corriente,0,".",".")?>&nbsp; </strong></TD>

		<TD class="textfield100"><strong><?=number_format($total_30,0,".",".")?>&nbsp; </strong></TD>

		<TD class="textfield100"><strong><?=number_format($total_60,0,".",".")?>&nbsp; </strong></TD>

		<TD class="textfield100"><strong><?=number_format($total_90,0,".",".")?>&nbsp; </strong></TD>

		<TD class="textfield100"><strong><?=number_format($total_120,0,".",".")?>&nbsp; </strong></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	

	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD height="16" colspan="10" class="textoproductos1"><HR /> <BR /></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>	

<?

}

?>

	

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL SALDOS:

	    <?=number_format($total_saldo,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL CORRIENTE :

	    <?=number_format($total_corriente,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 30 DIAS:

	    <?=number_format($total_30,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 60 DIAS:

	    <?=number_format($total_60,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 90 DIAS:

	    <?=number_format($total_90,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL MAS DE 120 DIAS:

	    <?=number_format($total_120,0,".",".")?></TD>

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