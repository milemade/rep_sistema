<?
include("lib/database.php");
?>

<link href="../styles.css" rel="stylesheet" type="text/css" />
<link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
<title>Consulta Facturacion</title>
<link href="css/styles2.css" rel="stylesheet" type="text/css">
<TABLE width="891" border="1" cellpadding="2" cellspacing="1"  class="textoproductos1">
<TR>
		<TD width="11%"  class="botones1">Nombre</TD>
		<TD width="19%" class="botones1">Nit</TD>
        <TD width="20%" class="botones1">Telefono</TD>
		<TD width="20%" class="botones1">Direccion</TD>
    <TD width="12%" class="botones1">Mail  </TD>
     
	 <!--  <TD width="18%" class="subfongris">DEVOLUCION</TD>-->
	  
  </TR>
	
	<?		
	$sql = " SELECT   * from bodega1 ORDER BY nom_bod  desc   ";

		$db->query($sql);
		while($db->next_row()){

			echo "<TR > <TD class='txtablas' width='40%' >&nbsp;$db->nom_bod</TD>";	
			
			echo "<TD class='txtablas' >&nbsp;$db->iden_bod</TD>";
			
			echo "<TD class='txtablas' >&nbsp;$db->tel_bod</TD>";
			
			echo "<TD class='txtablas' '>&nbsp;$db->dir_bod</TD>";
			
			echo "<TD class='txtablas' >&nbsp;$db->mail_bod</TD>";
			
		
			echo "</TR>";
		}
	?>





	<FORM method="POST" action="../agr_prin_factura.php">
	<TR><TD align="center" colspan="8">	
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<input name="button" type="button" class="botones" onClick="window.print()" value="Imprimir" /></TD>
	</TR></FORM>
</TABLE>