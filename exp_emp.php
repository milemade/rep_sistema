<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<? header ( "Content-type: application/x-msexcel" );
	header ( "Content-Disposition: attachment; filename=Empleados.xls" );
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
						  <td  class="ctablasup">CODIGO </td>
						  <td  class="ctablasup">NOMBRE </td>
						  <td  class="ctablasup">APELLIDO </td>
						  <td  class="ctablasup">IDENTIFICACION </td>
						  <td  class="ctablasup">CARGO </td>
						  <td  class="ctablasup">TELEFONO </td>
						  <td  class="ctablasup">DIRECCION </td>
						  <td  class="ctablasup">FECHA INGRESO </td>
						  <td  class="ctablasup">FECHA RETIRO </td>
						  <td  class="ctablasup">E.P.S. </td>
						  <td  class="ctablasup">A.R.P. </td>
                          
                        </tr>
						<? 				
						$sql="SELECT cod_ter,cc_ter, nom_ter, ape_ter, tel_ter, dir_ter,cod_car_ter, fec_ing_ter,fec_ret_ter, eps_ter, arp_ter ,des_car  FROM tercero INNER JOIN cargo ON tercero.cod_car_ter=cargo.cod_car $where $paginar";
						//echo $sql;
						$db->query($sql); 
						while($db->next_row()) {
							echo "<tr >  ";
                          	echo "<td >".completar($db->cod_car_ter,2).completar($db->cod_ter,3)."</td>";
							echo "<td >$db->nom_ter </td>";
							echo "<td >$db->ape_ter </td>";
							echo "<td >$db->cc_ter </td>";
							echo "<td >$db->des_car </td>";
							echo "<td >$db->tel_ter </td>";
							echo "<td >$db->dir_ter </td>";
							echo "<td >$db->fec_ing_ter </td>";
							echo "<td >$db->fec_ret_ter </td>";
							echo "<td >$db->eps_ter </td>";
							echo "<td >$db->arp_ter </td>";
							echo "</tr>";
						} ?>
                    
                        
</table >
</body>
</html>
