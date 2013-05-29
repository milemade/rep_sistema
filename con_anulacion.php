<?php include("lib/database.php")?>
<?PHP	 include("js/funciones.php")?>
<?PHP 
$ahora = date("Y-n-j H:i:s");
$_SESSION["ultimoAcceso"] = $ahora;
if($eliminacion==1) 
{//confirmacion de Eliminación  
	$error=eliminar("m_factura",$eli_codigo,"cod_fac");
if ($error >=1)
	echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;
}
if($confirmacion==1) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Inserto el registro Correctamente..') </script>" ;
if($confirmacion==2) //confirmacion de Edicion 
	echo "<script language='javascript'> alert('Se Edito el registro Correctamente..') </script>" ;

$where_cli="";
 $sql="select distinct a.cod_bod as valor , 
                       b.nom_bod as nombre 
			     from punto_venta a 
				 join  bodega  b on a.cod_bod=b.cod_bod ";
$dbdatos= new  Database();
$dbdatos->query($sql);	
$where_cli="";
while($dbdatos->next_row())
{
	$where_cli .= "bodega1.cod_bod_cli= ".$dbdatos->valor  ;
	$where_cli .= " or ";
}		
$where_cli .= " bodega1.cod_bod < 0 "; 
    $dbdatos->close();
if($det==0)
	$where="  ";
if(!empty($busquedas)) 
{ #codigo para buscar 
	$busquedas=reemplazar_1($busquedas);
	$where.=" and $busquedas   ";
}#codigo para buscar 
  $sql="SELECT c.nom_bod, 
			   b.cod_usu, 
			   b.nom_usu, 
			   c.cod_bod, 
			   c.nom_bod AS nom_cliente, 
			   d.cod_bod, 
			   d.nom_bod, 
			   e.cod_fac, 
			   e.valor_abono, 
			   a.cod_fac, 
			   a.cod_bod, 
			   a.cod_usu, 
			   a.fecha, 
			   a.num_fac, 
			   a.tipo_pago, 
			   a.estado
		FROM m_factura a
		LEFT JOIN usuario b ON b.cod_usu = a.cod_usu
		LEFT JOIN bodega1 c ON c.cod_bod = a.cod_cli
		LEFT JOIN bodega d ON d.cod_bod = a.cod_bod
		LEFT JOIN cartera_factura e ON e.cod_fac = a.cod_fac
		WHERE e.valor_abono =0 $where
		ORDER BY a.fecha, a.num_fac DESC";
//exit;
$cantidad_paginas=paginar($sql);
$cant_pag=ceil($cantidad_paginas/$cant_reg_pag);
if(!empty($act_pag)) 
	$inicio=($act_pag -1)*$cant_reg_pag  ;
else 
{ 
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
<table width="792" align="center">
<tr>
<td width="784" valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_anulacion.php">
 <table width="804" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr><td width="804" bgcolor="#E9E9E9">
      <table width="624" border="0" cellspacing="0" cellpadding="0">
      <tr><td width="8" height="33"> </td>
          <td width="17"> 
          </td>
         <td width="50" class="ctablaform">Buscar: </td>
         <td width="103" class="ctablaform"><input name="text" type="text" class="textfield" size="12" id="texto" /></td>
         <td width="20"><label> <span class="ctablaform">en</span></label></td>
         <td width="160" class="ctablaform"><select name="campos" class="textfieldlista" id="campos" >
                                            <option value="0">Seleccion</option>
                                            <option value="a.estado">Estado</option>
                                            <option value="a.fecha">Fecha</option>
                                            <option value="a.num_fac">No Factura</option>
                                            <option value="b.nom_usu">Vendedor</option>
                                            <option value="a.tipo_pago">Tipo de pago</option>
                                            <option value="c.nom_bod">Cliente</option>
											<option value="-1">Lista Completa</option>
                                             </select></td>
                          <td width="41" valign="middle"><img src="imagenes/ver.png" alt="Buscar" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>
                          <td width="54" valign="middle" class="ctablaform">&nbsp;</td>
                          <td width="38" valign="middle">&nbsp;</td>
                        </tr>

                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="809" border="0"  cellpadding="0">
                        <tr>
  						  <td width="69"  class="ctablasup">ESTADO</td>
						  <td width="65"  class="ctablasup">FECHA </td>
						  <td width="84"  class="ctablasup">No. factura </td>
						  <td width="180"  class="ctablasup">VENDEDOR</td>
						  <td width="97"  class="ctablasup">TIPO PAGO</td>
						  <td width="204"  class="ctablasup">CLIENTE</td>
                          <td  class="ctablasup"  width="89">OPCIONES</td>
                        </tr>
						<? 
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_anulacion.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						//echo $sql;
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_fac' action='man_anulacion.php'>  ";
							echo "<td >".strtoupper($db->estado)."</td>";
							echo "<td >$db->fecha </td>";
							echo "<td align='center'>$db->num_fac </td>";
							echo "<td align='center'>".strtoupper($db->nom_usu)."</td>";
							echo "<td align='center'>".strtoupper($db->tipo_pago)."</td>";
							echo "<td >$db->nom_cliente </td>";
							echo "<td aling='center' >"; 
							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_fac'>";
							if ($editar==1 and $db->estado!='anulado' ){
								//echo  $db->estado;
							 	echo "<img src='imagenes/icoeditar.gif' alt='Anular Factura' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_fac.submit()'/></td>";
							}
							else 
								echo "<img src='imagenes/e_icoeditar.gif' width='16' height='16'  /></td>";
                            echo 	"<td align='center'>";
							/*if ($eliminar==10)
								echo"<img src='imagenes/icoeliminar.gif' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_fac) /></td> ";
							else
								echo "<img src='imagenes/e_icoeliminar.gif' width='16' height='16'  /></td> ";*/
						   //impresion	
							echo "<td align='center'><img src='imagenes/mirar.png' alt='Ver Factura' width='16' height='16'  style=\"cursor:pointer\" onClick=\"imprimir_inf('ver_factura_v.php',$db->cod_fac,'grande')\" /></td>";	
						    echo "  </tr> </table>  </td>  ";
							echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";
							echo "  </form></tr>  ";
							} ?>
                      </table ></td>
                    </tr>
                    <tr>
                      <td><img src="imagenes/lineasup2.gif" width="805" height="4" /></td>
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
<form name="forma" method="post" action="con_anulacion.php">
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
<?php $db->close(); ?>
