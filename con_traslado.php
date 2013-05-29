<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<? 
$insertar = 1;
$editar =1;
$eliminar = 1;
$dbborrar = new Database();
$sqlborrar = "DELETE FROM kardex WHERE cant_ref_kar=0;";
$dbborrar->query($sqlborrar);
$dbborrar->close();
if($eliminacion==1) {



	$sql="SELECT * ,(SELECT cod_bod_sal_tras FROM m_traslado WHERE cod_tras=cod_mtras_dtra) AS bodega_salida, 

	     (SELECT cod_bod_ent_tras FROM m_traslado WHERE cod_tras=cod_mtras_dtra) AS bodega_entrada  

		  FROM  d_traslado  where cod_mtras_dtra=$eli_codigo ";

	$dbser= new  Database();	

	$dbser->query($sql);

	while($dbser->next_row())

	{

		kardex("resta",$dbser->cod_ref_dtra,$dbser->bodega_entrada,$dbser->cant_dtra,0,$dbser->cod_pes_dtra,$dbser->serial);

		kardex("suma",$dbser->cod_ref_dtra,$dbser->bodega_salida,$dbser->cant_dtra,0,$dbser->cod_pes_dtra,$dbser->serial);	

	}
        $dbser->close();
	

	$error=eliminar("m_traslado",$eli_codigo,"cod_tras");



	$sql ="DELETE FROM d_traslado WHERE cod_mtras_dtra=$eli_codigo";//=		

	$dbdatos_1= new  Database();

	$dbdatos_1->query($sql);
        $dbdatos_1->close();
	

	// actualiza movimientos

	resumen_movimiento($eli_codigo,"Traslado",$fecha,$vendedor,$total_nuevo_saldo,"suma","eliminando");

	// actualiza movimientos				

					

	if ($error >=1)

	echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;

	

}





if($confirmacion==1) //confirmacion de insercion 

	echo "<script language='javascript'> alert('Se actualizaron los datos Correctamente..') </script>" ;



if($confirmacion==2) //confirmacion de insercion 

	echo "<script language='javascript'> alert('Se Edito el registro Correctamente..') </script>" ;





if(!empty($busquedas)) { #codigo para buscar 

	$busquedas=reemplazar_1($busquedas);

	$where=" where $busquedas ";

}#codigo para buscar 



	/*$sql="SELECT * , (SELECT nom_bod FROM bodega WHERE cod_bod=cod_bod_sal_tras) AS bodega_salida, 
	            (SELECT nom_bod FROM bodega WHERE cod_bod=cod_bod_ent_tras) AS bodega_entrada 
				FROM m_traslado $where  ORDER BY cod_tras DESC ";*/

    $sql = "SELECT a.cod_tras, a.fec_tras, b.nom_bod bodega_salida, c.nom_bod bodega_entrada
              FROM m_traslado a
              JOIN bodega b ON a.cod_bod_sal_tras = b.cod_bod
              JOIN bodega c ON a.cod_bod_ent_tras = c.cod_bod ORDER BY a.cod_tras DESC ";

$cantidad_paginas=paginar($sql);

$cant_pag=ceil($cantidad_paginas/$cant_reg_pag);



if(!empty($act_pag)) 

	$inicio=($act_pag -1)*$cant_reg_pag  ;

else { 

	$inicio =0;

	$act_pag=1;

	}

$paginar=" limit  $inicio, $cant_reg_pag";

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

<script type="text/javascript" src="informes/inf.js"></script>

 <link href="css/styles.css" rel="stylesheet" type="text/css">

</head>

<body  <?=$sis?> onLoad="cambio_1(<?=$cant_pag?>,<?=$act_pag?>);">



<table align="center">

<tr>

<td valign="top" >

<form id="forma_total" name="forma_total" method="post" action="man_traslado.php">

                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >

                    <tr>

                      <td bgcolor="#E9E9E9"><table width="624" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td width="16" height="33"> </td>

                          <td width="19"> 

						  <? if ($insertar==1) {?>

					  	  <img src="imagenes/page.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_d_traslado.php?codigo=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>'"/>

					  	  <? } ?></td>

                          <td width="160"><span class="ctablaform">

                            <? if ($insertar==1) {?>

								Agregar

							<? } ?>

                          </span></td>

                          <td width="20" class="ctablaform">&nbsp;</td>

                          <td width="53" class="ctablaform">Buscar: </td>

                          <td width="103"><label>

                            <input name="text" type="text" class="textfield" size="12" id="texto" />

                          </label></td>

                          <td width="19" class="ctablaform"> en</td>

                          <td width="160" valign="middle"><select name="campos" class="textfieldlista" id="campos" >

                            <option value="0">Seleccion</option>

                            <option value="bodega_salida">Bodega Entrega</option>

							<option value="bodega_entrada">Bodega Recibe</option>

                           	<option value="-1">Lista Completa</option>

                          </select></td>

                          <td width="74" valign="middle"><img src="imagenes/ver.png" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>

                        </tr>

                      </table></td>

                    </tr>

                    <tr>

                      <td><table width="624" border="0"  cellpadding="0">

                        <tr>

						  <td  class="ctablasup" >No </td>

						  <td  class="ctablasup" >FECHA </td>

						  <td  class="ctablasup">BODEGA SALDA</td>

						  <td  class="ctablasup">BODEGA ENTRADA</td>

                          <td  class="ctablasup"  width="112">OPCIONES</td>

                        </tr>

						<? 

						

						echo "<tr style='display:none'><td ><form name='forma_0' action='man_traslado.php'>";

						echo "  </form> </td></tr>  ";						  

						$estilo="ctablablanc";

						$estilo="ctablagris";

						

						//echo $sql;

						$db->query($sql);  #consulta paginada

						while($db->next_row()) {

							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}

							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_tras' action='man_traslado.php'>  ";

							echo "<td >$db->cod_tras</td>";

                          	echo "<td >$db->fec_tras</td>";

							echo "<td >$db->bodega_salida </td>";

							echo "<td >$db->bodega_entrada </td>";

							//echo "<td align='right'>".number_format($db->total_saldo_tras,0,",",".")."</td>";

                            echo "<td aling='center' >"; 

							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";

                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_tras'>";

							if ($editar==1)

							 	echo "<img src='imagenes/icoeditar.gif' alt='Editar Registro' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_tras.submit()'/></td>";

							else 

								echo "<img src='imagenes/e_icoeditar.gif' width='16' height='16'  /></td>";

                            echo 	"<td align='center'>";

							if ($eliminar==1)

								echo"<img src='imagenes/icoeliminar.gif' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_tras) /></td> ";

							else

								echo"<img src='imagenes/e_icoeliminar.gif' width='16' height='16'  /></td> ";

								

								

							//impresion	

							echo "<td align='center'><img src='imagenes/mirar.png' width='16' height='16'  style=\"cursor:pointer\" onClick=\"imprimir_inf('inf_traslado.php',$db->cod_tras,'mediano')\" /></td>";	

							

							//echo "<td align='center'><img src='imagenes/Note.gif' width='16' height='16'    alt='Despacho' style=\"cursor:pointer\" onClick=\"imprimir_inf('inf_despacho.php',$db->cod_tras,'mediano')\" /></td>";	

							

							

							

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

                          <td> <span class="ctablaform" > <?  if ($cant_pag>0) echo "Pagina ".$act_pag." de ".$cant_pag ; else echo "No hay Resultados"  ?> </span>

                            <img src="imagenes/primero.png" alt="Inicio" width="16" height="16" id="primero" style="cursor:pointer; display:inline"  onClick="cambio(1)"/> <img src="imagenes/regresar.png" alt="Anterior" width="16" height="16" id="regresar" style="cursor:pointer; display:inline" onClick="cambio(2)"/> <img src="imagenes/siguiente.png" alt="Siguiente" width="16" height="16"  id="siguiente" style="cursor:pointer; display:inline" onClick="cambio(3)"/> <img src="imagenes/ultimo.png" alt="Ultimo" width="16" height="16" id="ultimo" style="cursor:pointer; display:inline" onClick="cambio(4)"/> </td>

                        </tr>

                      </table></td>

                    </tr>

                  </table>

      </form>

</td>

</tr>

</table>						

<form name="forma" method="post" action="con_traslado.php">

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

