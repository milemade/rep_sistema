<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<? 
$ahora = date("Y-n-j H:i:s");
$_SESSION["ultimoAcceso"] = $ahora;
if($eliminacion==1) {//confirmacion de insercion  
	$error=eliminar("m_factura",$eli_codigo,"cod_ment");
if ($error >=1)
	echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;
}
if($confirmacion==1) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Inserto el registro Correctamente..') </script>" ;
if($confirmacion==2) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Edito el registro Correctamente..') </script>" ;
$where_cli="";
$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod ";
		$dbdatos= new  Database();
		$dbdatos->query($sql);	
		$where_cli="";
		while($dbdatos->next_row())
		{
			$where_cli .= "bodega1.cod_bod_cli= ".$dbdatos->valor  ;
			$where_cli .= " or ";
		}		
		
if($det==0)
	$where="  ";
if(!empty($busquedas)) { #codigo para buscar 
	$busquedas=reemplazar_1($busquedas);
	$where.=" and $busquedas   ";
}
  #codigo para buscar las facturas de compra sin abonos ni notas compra
  $sql="SELECT a.cod_ment, 
			   a.fec_ment, 
			   a.fac_ment, 
			   a.total_ment, 
			   a.est_ment, 
			   a.cod_prove_ment, 
			   b.nom_pro
		FROM m_entrada a   
		INNER JOIN proveedor b ON a.cod_prove_ment = b.cod_pro AND a.remision =0
		WHERE a.est_ment='PENDIENTE'
		ORDER BY a.fac_ment DESC  ";
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
<table width="659" align="center">
<tr>
<td valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_anulacion_compra.php">
                  <table width="644" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td bgcolor="#E9E9E9"><table width="624" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="8" height="33"> </td>
                          <td width="17"> </td>
                          <td width="50" class="ctablaform">Buscar: </td>
                          <td width="103" class="ctablaform"><input name="text" type="text" class="textfield" size="12" id="texto" /></td>
                          <td width="20"><label> <span class="ctablaform">en</span></label></td>
                          <td width="160" class="ctablaform"><select name="campos" class="textfieldlista" id="campos" >
                            <option value="0">Seleccion</option>
                            <option value="fec_mfac">Fecha</option>
                            <option value="fac_ment">No Factura</option>
                            <option value="nom_pro">Proveedor</option>
                            <option value="-1">Lista Completa</option>
                          </select></td>
                          <td width="41" valign="middle"><img src="imagenes/ver.png" alt="Buscar" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>
                          <td width="54" valign="middle" class="ctablaform">&nbsp;</td>
                          <td width="38" valign="middle">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="638" border="0"  cellpadding="0">
                        <tr>
  						  <td width="115"  class="ctablasup">ESTADO</td>
						  <td width="83"  class="ctablasup">FECHA </td>
						  <td width="85"  class="ctablasup">No FACTURA </td>
						  <td width="212"  class="ctablasup">PROVEEDOR</td>
                         <td  class="ctablasup"  width="131">OPCIONES</td>
                        </tr>
						<? 
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_anulacion_compra.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						//echo $sql;
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_ment' action='man_anulacion_compra.php'>  ";
                           if ($db->est_ment=='anulado' )
						   {
							   $anula='ANULADO';
							   echo "<td >$anula </td>";
						   }
						     else
							 {
							      echo "<td >$db->est_ment </td>";
  				 }	  
							echo "<td >$db->fec_ment </td>";
							echo "<td align='center'>$db->fac_ment </td>";
							//echo "<td >$db->nom_usu </td>";
							//echo "<td >$db->tipo_pago </td>";
							echo "<td >$db->nom_pro </td>";
							echo "<td aling='center' >"; 
							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_ment'>";
							if ($editar==1 and $db->est_ment!='anulado' ){
								//echo  $db->estado;
							 	echo "<img src='imagenes/icoeditar.gif' alt='Anular Factura' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_ment.submit()'/></td>";
							}
							else 
								echo "<img src='imagenes/e_icoeditar.gif' width='16' height='16'  /></td>";
                            echo 	"<td align='center'>";
							/*if ($eliminar==10)
								echo"<img src='imagenes/icoeliminar.gif' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_ment) /></td> ";
							else
								echo"<img src='imagenes/e_icoeliminar.gif' width='16' height='16'  /></td> ";*/
						   //impresion
						   echo "</td>";
							echo "<td align='center'><img alt='Ver Factura' src='imagenes/mirar.png' width='16' height='16'  style=\"cursor:pointer\" onClick=\"imprimir_inf('inf_cargue.php',$db->cod_ment,'grande')\" /></td>";	
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
<form name="forma" method="post" action="con_anulacion_compra.php">
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
<?php $dbdatos->close(); ?>
<?php $db->close(); ?>