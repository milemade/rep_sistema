<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<? 

if($eliminacion==1) {//confirmacion de insercion  
	$error=eliminar("salida",$eli_codigo,"cod_sal");
	reverzar_referencias_salidas ($eli_codigo);
	if ($error >=1)
	echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;	
}

if($confirmacion==1) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Inserto el registro Correctamente..') </script>" ;

if($confirmacion==2) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Edito el registro Correctamente..') </script>" ;

$where=" where $busquedas   and cod_proy_sal=$global[0] ";
	
if(!empty($busquedas)) { #codigo para buscar 
	$busquedas=reemplazar_1($busquedas);
	$where=" where $busquedas    and cod_proy_sal=$global[0] ";
}#codigo para buscar 
else 
	$where=" where  cod_proy_sal=$global[0] ";


 $cantidad_paginas=paginar(' SELECT  cod_sal,fec_sal, aut_sal ,mot_sal,cod_alm_sal, obs_sal, op_reint_sal , reint_sal, cod_proy_sal , 
 					cod_usu_sal ,cod_usu_sal  FROM  salida   '.$where.'' );
$cant_pag=ceil($cantidad_paginas/$cant_reg_pag);
if(!empty($act_pag)) 
	$inicio=($act_pag -1)*$cant_reg_pag  ;
else { 
	$inicio =0;
	$act_pag=1;
	}
$paginar=" limit  $inicio, $cant_reg_pag";
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
</head>
<body  <?=$sis?> onLoad="cambio_1(<?=$cant_pag?>,<?=$act_pag?>);">

<table align="center">
<tr>
<td valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_ingreso.php">
                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td bgcolor="#E9E9E9"><table width="624" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="16" height="33"> </td>
                          <td width="19"> 
						  <? if ($insertar==1) {?>
					  	  <img src="imagenes/page.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_salida.php?codigo=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>'"/>
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
                            <option value="cod_sal">Numero</option>
							<option value="fec_sal">Fecha</option>
							<option value="nom_alm">Almacen</option>
							<option value="reint_sal">Estado</option>
                          </select></td>
                          <td width="74" valign="middle"><img src="imagenes/ver.png" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="624" border="0"  cellpadding="0">
                        <tr>
                          
						  <td  class="ctablasup">NUMERO </td>
						  <td  class="ctablasup">FECHA </td>
						  <td  class="ctablasup">ALMACEN </td>
						  <td  class="ctablasup">REINTEGRABLE </td>
						  <td  class="ctablasup">ESTADO </td>
                          <td  class="ctablasup">OPCIONES</td>
                        </tr>
						<? 
						
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_salida.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						$sql='SELECT  cod_sal,fec_sal, aut_sal ,mot_sal,cod_alm_sal, obs_sal, 
							op_reint_sal , reint_sal, cod_proy_sal , cod_usu_sal ,cod_usu_sal ,nom_alm 
							,CASE reint_sal WHEN 1 THEN "SI" WHEN 0 THEN "NO" END AS estado
							,CASE op_reint_sal WHEN "si" THEN "Reintegrable" WHEN "no" THEN "" END AS opcion_reint
							FROM  salida INNER JOIN almacen ON almacen.cod_alm=salida.cod_alm_sal  '.$where.'  order by cod_sal desc   '.$paginar ; 
						//echo $sql;
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_sal' action='man_salida.php'>  ";
                          	echo "<td >".completar($db->cod_sal,6)."</td>";
							echo "<td >$db->fec_sal </td>";
							echo "<td >$db->nom_alm </td>";
							echo "<td >$db->opcion_reint </td>";
							echo "<td >$db->estado </td>";
                            echo "<td aling='center' >"; 
							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_sal '>";
							if ($editar==1)
							 	echo "<img src='imagenes/icoeditar.gif' alt='Editar Registro' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_sal.submit()'/></td>";
							else 
								echo "<img src='imagenes/e_icoeditar.gif' width='16' height='16'  /></td>";
                            echo 	"<td align='center'>";
							if ($eliminar==1)
								echo"<img src='imagenes/icoeliminar.gif' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_sal) /></td> ";
							else
								echo"<img src='imagenes/e_icoeliminar.gif' width='16' height='16'  /></td> ";
                            echo "  </tr> </table>  </td>  ";
                            echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";
							echo "  </form></tr>  ";						
						} ?>
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
<form name="forma" method="post" action="con_salida.php"><input type="hidden" name="editar" id="editar" value="<?=$editar?>">
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