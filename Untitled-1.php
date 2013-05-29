<? include("js/funciones.php")?>
<? include("lib/database.php")?>
<link href="informes/styles.css" rel="stylesheet" type="text/css" />
<link href="informes/styles1.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<TABLE width="100%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1">
	<TR>
		<!--<TD width="10%" height="12" class="subfongris">TIPO </TD>-->
		<TD width="22%" height="16" class="subfongris">NOMBRE </TD>
		<TD width="10%" class="subfongris">FECHA</TD>
        <TD width="6%" class="subfongris">N. FAC.</TD>
        <TD width="8%" class="subfongris">T. FAC.</TD>
		<TD width="8%" class="subfongris">S. FAC.</TD>
		<TD width="11%" class="subfongris" >F. VEN. </TD>
        <TD width="10%" class="subfongris"> CARTERA CORRIENTE </TD>
		<TD width="10%" class="subfongris">30</TD>
		<TD width="10%" class="subfongris">60</TD>
		<TD width="10%" class="subfongris">90</TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	
	<?
$db = new Database();
$db1 = new Database();

	/*echo $sql = "SELECT  cod_car_fac,fec_car_fac, cartera_factura.cod_fac, num_fac, bod_cli_fac, (SELECT SUM(total_pro)  FROM d_factura WHERE cod_mfac=cartera_factura.cod_fac) AS total, (SELECT dias_credito FROM bodega1 WHERE cod_bod=bod_cli_fac) AS dias , (SELECT nom_bod FROM bodega1 WHERE cod_bod=bod_cli_fac) AS nombre , DATE_ADD(cartera_factura.fec_car_fac, INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=bod_cli_fac) DAY) AS vecimiento, datediff(curdate(),DATE_ADD(cartera_factura.fec_car_fac, INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=bod_cli_fac)  DAY)) AS pasado
FROM cartera_factura
INNER JOIN m_factura ON m_factura.cod_fac=cartera_factura.cod_fac
WHERE  datediff(curdate(),DATE_ADD(cartera_factura.fec_car_fac, INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=bod_cli_fac)  DAY))>0
order by pasado desc ";*/

$where_cli="";
$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$global[2]";
		
		
		$dbdatos= new  Database();
		$dbdatos->query($sql);	
		$where_cli="";
		while($dbdatos->next_row())
		{
			$where_cli .= "m_factura.cod_bod = ".$dbdatos->valor  ;
			$where_cli .= " or ";
		}		
		$where_cli .= " m_factura.cod_bod < 0 "; 

		if($det==0)
			$where.="  m_factura.cod_fac>0   and  ( $where_cli )   "; //

   
   
   
	 $sql=" 	SELECT 'CLIENTE' AS tipo_credito, cod_car_fac,fec_car_fac, cartera_factura.cod_fac, 
	num_fac, cod_cli, 
	(SELECT SUM(total_pro) FROM d_factura WHERE cod_mfac=cartera_factura.cod_fac) -  ifnull(tot_dev_mfac,0) AS total_neto, 
	(SELECT SUM(total_pro) FROM d_factura WHERE cod_mfac=cartera_factura.cod_fac)  - ifnull(valor_abono,0) -  ifnull(tot_dev_mfac,0) AS total, 
	datediff( curdate(),fecha) AS dias, (SELECT nom_bod FROM bodega1 WHERE cod_bod=cod_cli) AS nombre , 
	DATE_ADD(cartera_factura.fec_car_fac,INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) DAY) AS vecimiento, 
	datediff( curdate(), DATE_ADD(cartera_factura.fec_car_fac,INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) DAY)) AS pasado 
	FROM cartera_factura 
	INNER JOIN m_factura ON m_factura.cod_fac=cartera_factura.cod_fac 
	WHERE cod_cli> -1 AND (estado_car <>'CANCELADA'  and   estado_car <>'anulada' ) and  $where 
	group by  num_fac ORDER BY  num_fac, fec_car_fac  asc ";
		 
		$db->query($sql);
		$totalfacturacion=0;
		$totalcorriente=0;
		$total30=0;
		$total60=0;
		$total90=0;
		$validador=0;
		while($db->next_row()){
			$validador=0;
			$totalfacturacion=$totalfacturacion+$db->total;
			echo "<FORM action='liq_cartera.php' method='POST'> <INPUT type='hidden' name='mapa' value='$mapa'> <TR>";
			//echo "<TD class='ctablablanc' >$db->tipo_credito</TD>";
			echo "<TD class='ctablablanc' >$db->nombre</TD>";
			echo "<TD class='ctablablanc' >$db->fec_car_fac</TD>";
			echo "<TD class='ctablablanc' >$db->num_fac</TD>";
			echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->total_neto,0,".",".")."</div></TD>";
			echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format(abs($db->total),0,".",".")."</div></TD>";
			
			if(!empty($db->vecimiento))
				echo "<TD class='ctablablanc' align='right'>$db->vecimiento</TD>";
			else 
				echo "<TD class='ctablablanc' align='right'>&nbsp;</TD>";
			
			if ($db->pasado < 1 )
				echo "<TD class='ctablablanc'  align='right'><div align='right'>".number_format(abs($db->total),0,".",".")."</div></TD>";
			else 
				echo "<TD class='ctablablanc'  align='right'>&nbsp;</TD>";
			
			
			if($db->pasado > 0 && $db->pasado < 31) {
				echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format(abs($db->total),0,".",".")."</div></TD>";
				$total30=$total30+$db->total;
			}
			else {	
				echo "<TD class='ctablablanc' align='right'>&nbsp;</TD>";
				$validador=1;
			}
			if($db->pasado > 30 && $db->pasado < 61){
				echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->total,0,".",".")."</div></TD>";
				$total60=$total60+$db->total;
			}
			else {	
				echo "<TD class='ctablablanc' >&nbsp;</TD>";
				$validador=1;
			}
				
			if($db->pasado > 60 ){
				echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->total,0,".",".")."</div></TD>";
				$total90=$total90+$db->total;
			}
			else 	{
				echo "<TD class='ctablablanc' >&nbsp;</TD>";
				$validador=1;
			}
			
			if($validador==1)
				$totalcorriente = $totalcorriente + $db->total;
			//echo "<TD class='ctablablanc' align='center' width='15%'> 		<INPUT type='hidden' name='id' value='$db->cod_car'> 				<INPUT type='submit' value='Abono Factura' class='botones'></TD>";
			echo "</TR>	</FORM>";
		}
	?>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL FACTURAS:<?=number_format($totalfacturacion,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL CORRIENTE:
	    <?=number_format($totalcorriente-$total30-$total60-$total90,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 30 DIAS:
	    <?=number_format($total30,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 60 DIAS:
	    <?=number_format($total60,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	<TR>
		<TD height="16" colspan="11" class="subtitulosproductos">TOTAL 90 DIAS:
	    <?=number_format($total90,0,".",".")?></TD>
		<!--<TD width="11%" class="botones1" >OPCIONES</TD>-->
	</TR>
	  <TD height="16" colspan="11" class="tituloproductos" align="center">
		
	  <INPUT type="button" value="Imprimir" class="botones"  onclick="abrir()">	
	</TR>
</TABLE>

<script>
function abrir(){
	window.print();
}
</script>