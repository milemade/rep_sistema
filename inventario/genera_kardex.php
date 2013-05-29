<? include("../lib/database.php")?>
<? include("../js/funciones.php")?>
<? header ( "Content-type: application/x-msexcel" );
	header ( "Content-Disposition: attachment; filename=invebodega.xls" );
	header ( "Content-Description: Generador XLS" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>

</head>
<body>
<table width="837" border="0"  cellpadding="0">
                        <tr>                          
						  <td  class="ctablasup">CODIGO_REFERENCIA </td>
						  <td  class="ctablasup">CODIGO_TALLA </td>
						  <td  class="ctablasup">NOMBRE_REFERNCIA </td>
						  <td  class="ctablasup">REFERNCIA </td>
						  <td  class="ctablasup">TALLA </td>
						  <td  class="ctablasup">CANTIDAD </td>
                        </tr>
						<? 				
						$sql="SELECT * from `peso` ,producto order by  cod_pro ,cod_pes ";
						//echo $sql;
						$db->query($sql); 
						while($db->next_row()) {
							echo "<tr >  ";
                          	echo "<td >$db->cod_pro</td>";
							echo "<td >$db->cod_pes </td>";
							echo "<td >$db->nom_pro </td>";
							echo "<td >$db->cod_fry_pro </td>";
							echo "<td >$db->nom_pes </td>";
							echo "<td >0 </td>";
							echo "</tr>";
						} ?>
</table >
</body>
</html>