<? include("../lib/database.php");?>
<?
$db1 = new Database();
$sql = " select * from bodega where cod_bod=".$codigo;
$db1->query($sql);
while($db1->next_row()){

$nombre=$db1->nom_bod;
}
?>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<title>EXISTENCIAS EN BODEGA</title><TABLE width="96%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1">
<TR>
	  <TD colspan="7" class="ctablasup">NOMBRE BODEGA : <?=$nombre?></TD>
  </TR>
	<TR>
		<TD  class="subtitulosproductos">CODIGO</TD>
		<TD class="subtitulosproductos">REFERENCIA</TD>
		<TD class="subtitulosproductos">SERIAL</TD>
        <TD  class="subtitulosproductos">CANTIDAD </TD>
		<TD  class="subtitulosproductos">TALLA </TD>
        <TD  class="subtitulosproductos">VALOR UNIDAD</TD>
		<TD class="subtitulosproductos">VALOR TOTAL</TD>
	</TR>
	
	<?
		$db = new Database();	
		if($codigo!=0){			
		$sql = " SELECT   kardex.cod_ref_kar,   
		                  producto.cod_fry_pro,    
						  producto.nom_pro,  
						  kardex.valor_precio,  
						  producto.cod_tpro_pro,   
						  producto.cod_mar_pro,   
						  kardex.cod_bod_kar, 
                          kardex.serial,						  
						  bodega.nom_bod,   
						  kardex.cant_ref_kar,
                          kardex.cod_talla,
                          peso.nom_pes,
                         (kardex.cant_ref_kar * kardex.valor_precio) AS total_producto
                 FROM
				  kardex
				  INNER JOIN producto ON (kardex.cod_ref_kar = producto.cod_pro)
				  INNER JOIN bodega ON (kardex.cod_bod_kar = bodega.cod_bod)
				  INNER JOIN peso ON (kardex.cod_talla = peso.cod_pes) WHERE cod_bod_kar=".$codigo." ORDER BY producto.cod_fry_pro;";
			$db->query($sql);
			while($db->next_row()){
			
				echo "<FORM action='agr_bod.php' method='POST'>
						<INPUT type='hidden' name='mapa' value='$mapa'>";
				echo "<TR><TD class='textoproductos1' >$db->cod_fry_pro</TD>";
				echo "<TD class='textoproductos1' >$db->nom_pro</TD>";
				echo "<TD class='textoproductos1' >$db->serial</TD>";
				echo "<TD class='textoproductos1' >".number_format($db->cant_ref_kar,2,".",".")."</TD>";
				echo "<TD class='textoproductos1' >$db->nom_pes</TD>";
				echo "<TD class='textoproductos1' >".number_format($db->valor_precio,2,".",".")."</TD>";
				echo "<TD class='textoproductos1' >".number_format($db->total_producto,2,".",".")."</TD>";
				
				//echo "<TD class='textoproductos1' align='center' width='25%' colspan='2'>".number_format($db->cant_ref_kar*$db->valor,0,".",".")." </TD>";
				echo "</TR></FORM>";
				
				$total_valor += $db->total_producto;
			}
		}
		else{
				echo "<FORM action='agr_bod.php' method='POST'>
						<INPUT type='hidden' name='mapa' value='$mapa'>";
				echo "<TR><TD class='textoproductos1' >$db->cod_fry_pro</TD>";
				echo "<TD class='textoproductos1' >$db->nom_pro</TD>";
				echo "<TD class='textoproductos1' >$db->cant_ref_kar</TD>";
				echo "<TD class='textoproductos1' >$db->nom_pes</TD>";
				echo "<TD class='textoproductos1' >".number_format($db->pre_ven_pro,0,".",".")."</TD>";
				echo "<TD class='textoproductos1' >".number_format($db->total_producto,0,".",".")."</TD>";
				
				//echo "<TD class='textoproductos1' align='center' width='25%' colspan='2'>".number_format($db->cant_ref_kar*$db->valor,0,".",".")." </TD>";
				echo "</TR></FORM>";
				
				$total_valor += $db->total_producto;
			
		}
	?>



	<FORM method="POST" action="interna.php">
	<TR>
	  <TD colspan="7" align="center" class="tituloproductos">Total de la Bodega:     <?=number_format($total_valor,0,".",".")  ?></TD>
	  </TR>
	<TR>
	  <TD align="center" colspan="7"><INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<input name="button" type="button" class="botones"  onclick="window.print()" value="Imprimir" />
			<input type="button" value="Cerrar" class="botones"  onclick="window.close()" /></TD></TR></FORM>
</TABLE>
<script language="javascript">
function abrir(id){
	window.open("ver_abono.php?codigo="+id,"ventana","menubar=0,resizable=1,width=700,height=400,toolbar=0,scrollbars=yes")
}
</script>