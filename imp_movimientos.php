<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>
<script type="text/javascript">
var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<script type="text/javascript" src="js/funciones.js"></script>
 <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body  <?=$sis?> onLoad="cambio_1(<?=$cant_pag?>,<?=$act_pag?>);">

<table align="center">
<tr>
<td valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_moneda.php">
                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td bgcolor="#E9E9E9" class="ctablaform">Consulta Movimientos: </td>
                    </tr>
                    <tr>
                      <td><table width="624" border="0"  cellpadding="0">
                        <tr>
                          <td  class="ctablasup">MOVIMINETO </td>
						  <td  class="ctablasup">DOCUMENTO  </td>
						  <td  class="ctablasup">REFERENCIA  </td>
						  <td  class="ctablasup">ALMACEN  </td>
						  <td  class="ctablasup">MOVIL  </td>
						  <td  class="ctablasup">CANTIDAD  </td>				
                        </tr>
						<? 
						
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_unidad.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						$sql="SELECT *, cod_mae, 
								CASE cod_tip_mae 
								WHEN 2 THEN 'Compras'
								WHEN 5 THEN 'Traslado'
								WHEN 7 THEN 'Salida'
								WHEN 4 THEN 'Reintegro'
								END AS tipo ,
								(SELECT des_ref FROM referencia WHERE cod_ref=cod_ref_mae ) AS refrencia , 
								(SELECT nom_alm FROM almacen WHERE cod_alm=cod_alm_mae) AS almacen,
								(SELECT nom_mov FROM moviles WHERE cod_mov=cod_alm_mae) AS moviles  
								FROM maestro_movimiento
								WHERE cod_ref_mae=$codigo";
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda>  ";
                          	echo "<td >$db->tipo </td>";
							echo "<td >".completar($db->$db->des_uni,6)."</td>";		
							echo "<td >$db->refrencia </td>";
							echo "<td >$db->almacen </td>";
							echo "<td >$db->moviles </td>";
							echo "<td >$db->cant_mae </td>";
							echo " </tr>  ";
						
						} ?>
					</table ></td>
                    </tr>
                    
                    <tr>
                      <td><img src="imagenes/lineasup2.gif" width="624" height="4" /></td>
                    </tr>
                    <tr>
                      <td height="30" align="center" valign="bottom">&nbsp;</td>
                    </tr>
                  </table>
      </form>
</td>
</tr>
</table>						
</body>
</html>

<? 


?>


