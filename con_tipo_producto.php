<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<? 
if($eliminacion==1) {//confirmacion de insercion  
	$error=eliminar("tipo_producto",$eli_codigo,"cod_tpro");
	if ($error >=1)
	         echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;
	if($error=="no")
	         echo "<script language='javascript'> alert('Este producto tiene existencias, NO permite BORRARSE...') </script>" ;
}
if($confirmacion==1) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Inserto el registro Correctamente..') </script>" ;

if($confirmacion==2) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Edito el registro Correctamente..') </script>" ;
	
if(!empty($busquedas)) { #codigo para buscar 

	$busquedas=reemplazar_1($busquedas);

	$where=" where $busquedas ";

}


$sql="SELECT cod_tpro,nom_tpro,desc_tpro FROM tipo_producto  $where ORDER BY nom_tpro ASC";



$cantidad_paginas=paginar($sql);
$cant_pag=ceil($cantidad_paginas/$cant_reg_pag);
if(!empty($act_pag)) 
	$inicio=($act_pag -1)*$cant_reg_pag  ;
else { 
	$inicio =0;
	$act_pag=1;
	}

//$paginar=" limit  $inicio, $cant_reg_pag";

$sql.=$paginar;

$busquedas=reemplazar($busquedas);

?>

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

 <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script language="javascript">

$(document).ready(function() {

	$(".botonExcel").click(function(event) {

		$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());

		$("#FormularioExportacion").submit();

});

});

</script>

<style type="text/css">

.botonExcel{cursor:pointer;}

</style>

</head>

<body  <?=$sis?> onLoad="cambio_1(<?=$cant_pag?>,<?=$act_pag?>);">



<table align="center">

<tr><td><form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">

<p align="right"><font face="Arial, Helvetica, sans-serif">Exportar a Excel</font>  <img src="export_to_excel.gif" class="botonExcel" /></p>

<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />

</form></td></tr>

<tr>

<td valign="top" >

<form id="forma_total" name="forma_total" method="post" action="man_tipo_producto.php">

                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >

                    <tr>

                      <td bgcolor="#E9E9E9"><table width="624" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td width="16" height="33"> </td>

                          <td width="19"> 

						  <? if ($insertar==1) {?>

					  	  <img src="imagenes/page.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_tipo_producto.php?codigo=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>'"/>

					  	  <? } ?></td>

                          <td width="127"><span class="ctablaform">

                            <? if ($insertar==1) {?>

								Agregar

							<? } ?>

                          </span></td>

                          <td width="25" class="ctablaform">&nbsp;</td>

                          <td width="47" class="ctablaform">Buscar: </td>

                          <td width="104"><label>

                            <input name="text" type="text" class="textfield" size="12" id="texto" />

                          </label></td>

                          <td width="16" class="ctablaform"> en</td>

                          <td width="160" valign="middle"><select name="campos" class="textfieldlista" id="campos" >

                            <option value="0">Seleccion</option>

                            <option value="nom_tpro">Nombre</option>

                          	<option value="-1">Lista Completa</option>

                          </select></td>

                          <td width="110" valign="middle"><img src="imagenes/ver.png" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>

                        </tr>

                      </table></td>

                    </tr>

                    <tr>

                      <td><table width="624" border="0"  cellpadding="0" cellspacing="0" bordercolor="#666666" id="Exportar_a_Excel" style="border-collapse:collapse;">

                        <tr>

						  <td  class="ctablasup">NOMBRE </td>

						  <td  class="ctablasup">DESCRIPCION </td>

                          <td  class="ctablasup"  width="112">OPCIONES</td>

                        </tr>

						<? 

						

						echo "<tr style='display:none'><td ><form name='forma_0' action='man_tipo_producto.php'>";

						echo "  </form> </td></tr>  ";						  

						$estilo="ctablablanc";

						$estilo="ctablagris";

						

						//echo $sql;

						$db->query($sql);  #consulta paginada

						while($db->next_row()) {

							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}

							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_tpro' action='man_tipo_producto.php'>  ";

                          	echo "<td >$db->nom_tpro </td>";

				echo "<td >$db->desc_tpro </td>";

                            echo "<td aling='center' >"; 

							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";

                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_tpro'>";

							if ($editar==1)

							 	echo "<img src='imagenes/icoeditar.gif' alt='Editar Registro' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_tpro.submit()'/></td>";

							else 

								echo "<img src='imagenes/e_icoeditar.gif' width='16' height='16'  /></td>";

                            echo 	"<td align='center'>";

							if ($eliminar==1)

								echo"<img src='imagenes/icoeliminar.gif' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_tpro) /></td> ";

							else

								echo"<img src='imagenes/e_icoeliminar.gif' width='16' height='16'  /></td> ";

                            echo "  </tr> </table>  </td>  ";

							echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";

							echo "  </form></tr>  ";

						

						} ?>
                                                <?php $db->close(); ?>
                    
                      </table ></td>

                    </tr>

                    

                    <tr>

                      <td><img src="imagenes/lineasup2.gif" width="624" height="4" /></td>

                    </tr>

                    <tr>

                      <td height="30" align="center" valign="bottom"><table>

                        <tr>

                          <td> <!--<span class="ctablaform" > <?  if ($cant_pag>0) echo "Pagina ".$act_pag." de ".$cant_pag ; else echo "No hay Resultados"  ?> </span>

                            <img src="imagenes/primero.png" alt="Inicio" width="16" height="16" id="primero" style="cursor:pointer; display:inline"  onClick="cambio(1)"/> <img src="imagenes/regresar.png" alt="Anterior" width="16" height="16" id="regresar" style="cursor:pointer; display:inline" onClick="cambio(2)"/> <img src="imagenes/siguiente.png" alt="Siguiente" width="16" height="16"  id="siguiente" style="cursor:pointer; display:inline" onClick="cambio(3)"/> <img src="imagenes/ultimo.png" alt="Ultimo" width="16" height="16" id="ultimo" style="cursor:pointer; display:inline" onClick="cambio(4)"/>--> </td>

                        </tr>

                      </table></td>

                    </tr>

                  </table>

      </form>

</td>

</tr>

</table>						

<form name="forma" method="post" action="con_tipo_producto.php">

  <input type="hidden" name="editar" id="editar" value="<?=$editar?>">

  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">

  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">

  <input type="hidden" name="cant_pag"  id="cant_pag" value="<?=$cant_pag?>">

  <input type="hidden" name="act_pag"  id="act_pag" value="<? if(!empty($act_pag)) echo $act_pag; else echo $pagina;?>">

  <input type="hidden" name="busquedas" id="busquedas" value="<?=$busquedas?>">

   <input type="hidden" name="eliminacion" id="eliminacion" >

    <input type="hidden" name="eli_codigo" id="eli_codigo" >

</form>

</body>

</html>

