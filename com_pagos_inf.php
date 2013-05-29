<? include("../js/funciones.php")?>

<? include("../lib/database.php")?>

<link href="styles.css" rel="stylesheet" type="text/css" />

<link href="styles1.css" rel="stylesheet" type="text/css" />

<link href="../styles.css" rel="stylesheet" type="text/css" />

<link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />

<link href="../css/styles2.css" rel="stylesheet" type="text/css" />

<link href="../css/styles.css" rel="stylesheet" type="text/css" />

<TABLE width="100%" border="1" cellpadding="2" cellspacing="0"   class="textoproductos1">

<?

$db = new Database();

$db1 = new Database();

$db2 = new Database();



$sql="select distinct(cod_prove_ment ), nom_pro , ident_pro from m_entrada  inner join proveedor on m_entrada.`cod_prove_ment`=proveedor.`cod_pro`  where m_entrada.`est_ment`<>'CANCELADA' order by proveedor.nom_pro asc";

$db->query($sql);	

$total_saldo_general=0;





while($db->next_row())

{

$cod_proveedor=$db->cod_prove_ment;



$total_saldo_proveedor=0;

?>

	

	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD height="16" colspan="2" class="subfongris">NOMBRE PROVEEDOR: 

	    <?=$db->nom_pro?></TD>

		<TD height="16" colspan="3" class="subfongris" >NIT:

        <?=$db->ident_pro?></TD>

		<TD height="16" class="subfongris">&nbsp;</TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	

	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD width="8%" height="16" class="boton">FECHA FACTURA </TD>

		<TD width="8%" height="16" class="boton">FECHA VENCIMIENTO </TD>

		<TD width="4%"  class="boton">No</TD>

		<TD width="6%" class="boton">VALOR</TD>

        <TD width="6%" class="boton">SALDO</TD>

        <TD width="6%" class="boton">No. Dias </TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<?

	

	$sql_33=" SELECT 	 MONTH(fec_ment) as mes,    sum(m_entrada.total_ment) as total,   (select nom_mes from meses WHERE cod_mes= MONTH(fec_ment) ) as nombre_mes FROM   m_entrada   where cod_prove_ment='$cod_proveedor' and fec_ment>'$fec_ini' and  fec_ment<'$fec_fin'   group by cod_prove_ment , mes ";

$db2->query($sql_33);	

while($db2->next_row())

{

$nombre_mes=$db2->nombre_mes;

$codigo_mes=$db2->mes;

 $subtotal_mes=$db2->total;

$total_saldo_proveedor=$total_saldo_proveedor+$subtotal_mes;

//echo "<br>";



	

	 $sql1="select * ,DATE_ADD(m_entrada.`fec_ment` ,  INTERVAL proveedor.`credito_pro` DAY) as fecha_pago,  abs(DATEDIFF(now(),

DATE_ADD(m_entrada.`fec_ment` , INTERVAL proveedor.`credito_pro` DAY))) as dias_faltantes , DATEDIFF(now(),m_entrada.`fec_ment` ) as dias_cartera , MONTH(fec_ment) as mes  from m_entrada  inner join proveedor on m_entrada.`cod_prove_ment`=proveedor.`cod_pro`  where cod_pro=$cod_proveedor and m_entrada.`est_ment`<>'CANCELADA' and  MONTH(fec_ment)='$codigo_mes'and fec_ment>'$fec_ini' and  fec_ment<'$fec_fin'  order by proveedor.cod_pro , mes ";





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

		<TD width="8%" height="16" class="textfield"><?=$db1->fec_ment?>&nbsp;</TD>

		<TD width="8%" height="16" class="textfield"><?=$db1->fecha_pago?>&nbsp;</TD>

		<TD  class="textfield"><?=$db1->fac_ment?>&nbsp;</TD>

		<TD width="6%" class="textfield"><div align='right'><?=number_format($db1->total_ment,0,".",".")?>&nbsp;</div></TD>

		<TD width="6%" class="textfield">

		<div align='right'><?=number_format($db1->total_ment-$db1->sal_ant_ment,0,".",".")?>&nbsp;</div>		</TD>

        <TD width="6%" class="textfield">&nbsp;<?=$db1->dias_cartera?>&nbsp;</TD> 

		<? 

		if( $db1->dias_cartera <30) {

			$total_corriente=$total_corriente+($db1->total_ment-$db1->sal_ant_ment);

			//echo $db1->dias_cartera;

			$total_cor=$db1->total_ment-$db1->sal_ant_ment;

		?>

		<? } ?>

	</TR>

	<?

	

	$total_corriente_general= $total_corriente_general +  $total_corriente;	

	$total_saldo_general=$total_saldo_general + $total_saldo ;

	$total_30_general= $total_30_general + $total_30;

	$total_60_general = $total_60_general + $total_60;

	$total_90_general=$total_90_general + $total_90;

	$total_120_general=$total_120_general + $total_120 ;

	$total_120_general= $total_120 ;

	

	} 

	?>

	

	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD height="16" class="subfongris">&nbsp;</TD>

		<TD height="16" class="subfongris">&nbsp;</TD>

		<TD height="16" class="subfongris">&nbsp;</TD>

		<TD height="16" colspan="2" class="ctablasup">Subtotal

        <?=$nombre_mes?>

        : &nbsp;</TD>

		<TD height="16" class="ctablasup"><?=number_format($subtotal_mes,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	

	<TR>

		<TD height="16" colspan="6" class="subtitulosproductos">&nbsp;</TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	

	<? }	

	

	?>



	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD height="16" colspan="3" class="textfield100"><strong>TOTAL PROVEEDOR </strong></TD>

		<TD height="16" class="textfield100"><strong>

		  <?=number_format($total_saldo_proveedor,0,".",".")?>

		</strong></TD>

		<TD height="16" class="textfield100"><strong>&nbsp; </strong></TD>

		<TD height="16" class="textfield100">&nbsp;</TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	

	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD height="16" colspan="6" class="textoproductos1"><HR /> <BR /></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>	

<?

}

?>

	

	<TR>

		<TD height="16" colspan="6" class="subtitulosproductos">TOTAL DEL PERIODO:

	    <?=number_format($total_corriente_general+$total_30_general+$total_60_general+ $total_90_general+$total_120_general,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	  <TD height="16" colspan="6" class="tituloproductos" align="center">

		

	  <INPUT type="button" value="Imprimir" class="botones"  onclick="abrir()">	</TR>

</TABLE>



<script>

function abrir(){

	window.print();

}

</script>