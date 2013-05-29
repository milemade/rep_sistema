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

<div align="center"><span class="subtitulosproductos">Fecha de corte de cartera por cobrar <?=date("Y/m/d")?></span></div>

<TABLE width="100%" border="1" cellpadding="2" cellspacing="0"   class="textoproductos1">
<?
$db = new Database();
$db1 = new Database();



  $sql="SELECT 'CLIENTE' AS tipo_credito, cod_car_fac,fec_car_fac, cartera_factura.cod_fac, num_fac,cod_cli,

  (SELECT SUM(total_pro) FROM d_factura WHERE cod_mfac=cartera_factura.cod_fac) - ifnull(tot_dev_mfac,0) AS total_neto, 

  (SELECT SUM(total_pro) FROM d_factura WHERE cod_mfac=cartera_factura.cod_fac) - ifnull(valor_abono,0) - ifnull(tot_dev_mfac,0) AS total, 

  datediff( curdate(),fecha) AS dias, (SELECT nom_bod FROM bodega1 WHERE cod_bod=cod_cli) AS nombre , DATE_ADD(cartera_factura.fec_car_fac,INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) DAY) AS vecimiento, datediff( curdate(), DATE_ADD(cartera_factura.fec_car_fac,INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) DAY)) AS pasado FROM cartera_factura INNER JOIN m_factura ON m_factura.cod_fac=cartera_factura.cod_fac WHERE cod_cli> -1 AND (estado_car <>'CANCELADA' and estado_car <>'anulada' ) group by cod_cli ORDER BY nombre ";

$db->query($sql);	

while($db->next_row())

{

$cod_proveedor=$db->cod_cli;

?>

	

	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD height="16" colspan="2" class="subfongris">NOMBRE DEL CLIENTE: </TD>

		<TD height="16" colspan="3" class="subfongris" ><?=$db->nombre?>&nbsp;</TD>

		<TD height="16" class="subfongris">NIT: </TD>

		<TD height="16" colspan="5" class="subfongris"><?=$db->ident?>&nbsp;</TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	

	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD width="97" height="16" class="boton">FECHA FACTURA </TD>

		<TD width="97" height="16" class="boton">FECHA VENCIMIENTO</TD>

		<TD width="94"  class="boton">No</TD>

		<TD width="96" class="boton">VALOR</TD>

        <TD width="96" class="boton">SALDO</TD>

		

        <TD width="96" class="boton">DIAS C</TD>

		<TD width="96" class="boton">SIN VENCER </TD>

		<TD width="96" class="boton" >30-59 D. </TD>

        <TD width="98" class="boton">60-89 D.</TD>

		<TD width="96" class="boton">90-119 D.</TD>

		<TD width="96" class="boton">MAS DE 120 D.</TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<?

	 $sql1="select * ,

	 DATE_ADD(m_entrada.`fec_ment` ,  

	 INTERVAL proveedor.`credito_pro` DAY) as fecha_pago,  (DATEDIFF(now(),

DATE_ADD(m_entrada.`fec_ment` , INTERVAL proveedor.`credito_pro` DAY))) as dias_faltantes , 

DATEDIFF(now(),m_entrada.`fec_ment` ) as dias_cartera , 

(SELECT iden_bod FROM bodega1 WHERE cod_bod=cod_cli) as ident from 

m_entrada  inner join proveedor on m_entrada.`cod_prove_ment`=proveedor.`cod_pro` AND m_entrada.remision=0 where cod_pro=$cod_proveedor and m_entrada.`est_ment`<>'CANCELADA' order by proveedor.cod_pro";







 $sql1="select * ,DATE_ADD(m_factura.fecha , INTERVAL bodega1.`dias_credito` DAY) as fecha_pago,  (DATEDIFF(now(), DATE_ADD(m_factura.`fecha` , INTERVAL bodega1.`dias_credito` DAY)))   as dias_faltantes ,  DATEDIFF(now(),m_factura.`fecha` ) as dias_cartera ,  m_factura.tot_fac- (select valor_abono from cartera_factura where cod_fac=m_factura.cod_fac) as saldo_factura  from m_factura  inner join bodega1 on m_factura.`cod_cli`=bodega1.`cod_bod` inner join `cartera_factura` on cartera_factura.cod_fac=m_factura.cod_fac  where cod_cli=$cod_proveedor  and estado_car <>'CANCELADA' AND estado_car <>'anulado' and tipo_pago='Credito' order by bodega1.cod_bod ,fecha ,  num_fac asc   "; 





//$sql1=" SELECT 'CLIENTE' AS tipo_credito, cod_car_fac,fec_car_fac, cartera_factura.cod_fac,  	num_fac, cod_cli,  	(SELECT SUM(total_pro) FROM d_factura WHERE cod_mfac=cartera_factura.cod_fac) -  ifnull(tot_dev_mfac,0) AS total_neto,  	(SELECT SUM(total_pro) FROM d_factura WHERE cod_mfac=cartera_factura.cod_fac)  - ifnull(valor_abono,0) -  ifnull(tot_dev_mfac,0) AS total,  	datediff( curdate(),fecha) AS dias, (SELECT nom_bod FROM bodega1 WHERE cod_bod=cod_cli) AS nombre ,  	DATE_ADD(cartera_factura.fec_car_fac,INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) DAY) AS vecimiento,  	datediff( curdate(), DATE_ADD(cartera_factura.fec_car_fac,INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) DAY)) AS pasado  	FROM cartera_factura  	INNER JOIN m_factura ON m_factura.cod_fac=cartera_factura.cod_fac  	WHERE cod_cli> -1 AND estado_car <>'CANCELADA' and  cod_cli=$codigo   	ORDER BY  num_fac, fec_car_fac  asc   "; 













	$db1->query($sql1);

	

	$total_corriente=0;	

	$total_saldo=0;

	$total_30=0;

	$total_60=0;

	$total_90=0;

	$total_120=0;

	

	

	

	while($db1->next_row())

	{

	

	$total_saldo=$total_saldo+($db1->saldo_factura);

	

	?>

	

	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD width="97" height="16" class="textfield"><?=$db1->fecha?>&nbsp;</TD>

		<TD width="97" height="16" class="textfield"><?=$db1->fecha_pago?>&nbsp;</TD>

		<TD  class="textfield"><?=$db1->num_fac?>&nbsp;</TD>

		<TD width="96" class="textfield"><div align='right'><?=number_format($db1->tot_fac,0,".",".")?>&nbsp;</div></TD>

		<TD width="96" class="textfield">

		<div align='right'><?=number_format($db1->saldo_factura,0,".",".")?>&nbsp;</div>		</TD>

		

        <TD width="96" class="textfield">&nbsp;<?=$db1->dias_faltantes?>&nbsp;</TD> 

		

		<? if($db1->dias_cartera<=30) {

			$total_corriente=$total_corriente+($db1->saldo_factura);

			$tot_corr=($db1->saldo_factura);



		?>

		<? } ?>

		

			<TD width="96" class="textfield">

				<div align='right'>&nbsp;<?=number_format($tot_corr,0,".",".")?>&nbsp;</div>			</TD>

		

		<? $tot_corr=0; 	?>

		

		<? if($db1->dias_cartera>=30 &&  $db1->dias_cartera<60 ) {

			$total_30=$total_30+($db1->saldo_factura);

			$tot_30_c=($db1->saldo_factura);

		?>

		<? } ?>

			<TD width="96" class="textfield">

				<div align='right'>&nbsp;<?=number_format($tot_30_c,0,".",".")?>&nbsp;</div>			</TD>		

		

		<? $tot_30_c=0; 	?>

		

		

		<? if($db1->dias_cartera>=60 &&  $db1->dias_cartera<90) { 

			$total_60=$total_60+($db1->saldo_factura);

			$tot_60_c=($db1->saldo_factura);

			

		?>

		<? } ?>

			<TD width="98" class="textfield">

				<div align='right'><?=number_format($tot_60_c,0,".",".")?></div>			</TD>		

		

		<? $tot_60_c=0; 	?>

		

		<? if($db1->dias_cartera>=90 &&  $db1->dias_cartera<=120 ) {

			$total_90=$total_90+($db1->saldo_factura);

			$tot_90_c=($db1->saldo_factura);

		?>

		<? } ?>

			<TD width="96" class="textfield">

				<div align='right'>&nbsp;<?=number_format($tot_90_c,0,".",".")?>&nbsp;</div>			</TD>		

		

		<?  $tot_90_c=0; ?>

		

		

		<? if($db1->dias_cartera>=120) {

			$total_120=$total_120+($db1->saldo_factura);

			$tot_120_c=($db1->saldo_factura);

		?>
                    
		<? } ?> 

			<TD width="96" class="textfield">

				<div align='right'>&nbsp;<?=number_format($tot_120_c,0,".",".")?>&nbsp;</div>			</TD>		

		

		<? $tot_120_c=0; 	?>

	</TR>

	<?



	

	

	

	}

	

	?>



	<TR>

		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->

		<TD height="16" colspan="2" class="textfield100"><strong>SUBTOTALES&nbsp;</strong></TD>

		<TD height="16" class="textfield100">&nbsp;</TD>

		<TD height="16" class="textfield100"><strong><?=number_format($total_saldo,0,".",".")?>&nbsp; </strong></TD>

		<TD height="16" class="textfield100">&nbsp;</TD>

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

		<TD height="16" colspan="11" class="textoproductos1"><HR /> <BR /></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>	

	

	

	

<?



$total_corriente_general= $total_corriente_general +  $total_corriente;	

	$total_saldo_general=$total_saldo_general + $total_saldo ;

	$total_30_general= $total_30_general + $total_30;

	$total_60_general = $total_60_general + $total_60;

	$total_90_general=$total_90_general + $total_90;

	$total_120_general=$total_120_general + $total_120 ;



$total_saldo=0;

	 $total_30=0;

	  $total_60=0;

	   $total_90=0;

	    $total_120=0;



}





?>

	

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL SALDOS:

	    <?=number_format($total_saldo_general,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL CORRIENTE :

	    <?=number_format($total_corriente_general,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 30 DIAS:

	    <?=number_format($total_30_general,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 60 DIAS:

	    <?=number_format($total_60_general,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 90 DIAS:

	    <?=number_format($total_90_general,0,".",".")?></TD>

		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->

	</TR>

	<TR>

		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL MAS DE 120 DIAS:

	    <?=number_format($total_120_general,0,".",".")?></TD>

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
<?php if($db1->num_rows()>0) $db1->close(); ?>  
<?php if($db->num_rows()>0) $db->close(); ?> 