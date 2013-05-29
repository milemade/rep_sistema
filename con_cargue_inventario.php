<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<? //Script para ver los registros de cada usuario
//print_r($_GET);
$ahora = date("Y-n-j H:i:s");
$_SESSION["ultimoAcceso"] = $ahora;
    if(empty($global[5]) && empty($global[6]))
	{
	   print "<script>alert('Debe ingresar de nuevo al sistema.')</script>";
	   print "<script> top.location.replace('http://108.163.168.106/~construc/inventarios/inicio.php'); </script>";
	}
    if($global[1]==2)
	{
	     require_once("crear_tmpuser.php");
	} 
        if($eliminacion==1) {//confirmacion de insercion  
		if($global[1]==1){//Si es el Superadministrador Afecta Inventarios
		$sql="select *,(select cod_bod from ".$global[5]." where cod_ment=$eli_codigo) as bodega from ".$global[6]." where cod_ment_dent=$eli_codigo";
		$dbser= new  Database();	
		$dbser->query($sql);
		while($dbser->next_row()){
			kardex("resta",$dbser->cod_ref_dent,$dbser->bodega,$dbser->cant_dent,$dbser->cos_dent,$dbser->cod_pes_dent,$dbser->cod_serial);
		}
                $dbser->close();
		}
	$error=eliminar($global[5],$eli_codigo,"cod_ment");

	      
	$sql ="DELETE FROM ".$global[6]." WHERE cod_ment_dent=$eli_codigo";//=		
	$dbdatos_1= new  Database();
	$dbdatos_1->query($sql);
	$dbdatos_1->close();
					
	if ($error >=1)
	echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;
	
}


if($confirmacion==1) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Inserto el registro Correctamente..') </script>" ;

if($confirmacion==2) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Actualizo el registro Correctamente..') </script>" ;


$where_cli="";

$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$global[2]";
		$dbdatos= new  Database();
		$dbdatos->query($sql);
		
		$where_cli="";
		while($dbdatos->next_row())
		{
			$where_cli .= "bodega.cod_bod= ".$dbdatos->valor  ;
			$where_cli .= " or ";
		}
		
		$where_cli .= " bodega.cod_bod < 0 "; 
                $dbdatos->close();


//if($det==0)
//	$where.=" where cod_ment>0   and  ( $where_cli )  ";


$where .= " WHERE a.remision=1 ";
if(!empty($busquedas)) { #codigo para buscar 
	$busquedas=reemplazar_1($busquedas);
	$where.=" and $busquedas  ";
}#codigo para buscar 



$sql="SELECT a.cod_ment,a.fec_ment,a.fac_ment,c.nom_bod,d.nom_usu FROM ".$global[5]." a 
        JOIN ".$global[6]." b ON a.cod_ment=b.cod_ment_dent
        JOIN bodega c ON a.cod_bod=c.cod_bod 
        JOIN usuario d ON a.usu_ment  =d.cod_usu  
       $where GROUP BY a.cod_ment ORDER BY a.cod_ment DESC";
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
//echo $sql; //exit;
$busquedas=reemplazar($busquedas);
//echo "<br><br>Busqueda  ".$busquedas;
?>
<?php
if($_POST['codigo']>0 && $_POST['guardar']==1)
{  //Si ES EDICION
 $compos="fec_ment='".$fecha."', fac_ment='".$num_fac."', obs_ment='".$observaciones."', cod_bod='".$bodega."', total_ment='".$todocompra."',cod_prove_ment='".$proveedor."',usu_ment='".$global[2]."'  ";
 $error=editar($global[5],$compos,'cod_ment',$codigo);  
}
?>
<?php
 function sumartotal($id,$maestra,$detalle)
{
  $d = new Database();
  $sql = "SELECT cant_dent,cos_dent FROM ".$detalle." WHERE cod_ment_dent=".$id.";";
  $d->query($sql);
  $total = 0;
  while($d->next_row())
  {
       $total = $total + ($d->cant_dent * $d->cos_dent);
  }
  $du = new Database();
  $sqlu = "UPDATE ".$maestra." SET total_ment=".$total." WHERE cod_ment=".$id.";";
  $du->query($sqlu);
  $d->close(); //exit;
  $du->close();
  return $total;
}
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
<script type="text/javascript" src="informes/inf.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
 <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body  <?=$sis?> onLoad="cambio_1(<?=$cant_pag?>,<?=$act_pag?>);">

<table align="center">
<tr>
<td valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_almacen.php">
                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td bgcolor="#E9E9E9"><table width="624" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="16" height="33"> </td>
                          <td width="19"> 
						  <? if ($insertar==1) {?>
					  	  <img src="imagenes/page.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_cargue_inventario.php?codigo=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>'"/>
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
							<option value="a.fac_ment">Remision</option>
                            <option value="c.nom_bod">Bodega</option>
							<option value="b.cod_serial">Serial</option>
                           	<option value="-1">Lista Completa</option>
                          </select></td>
                          <td width="74" valign="middle"><img src="imagenes/ver.png" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><div>
		<?if($global[1]==1)
	{?><a href="actualizarcargainventarios.php?insertar=<?=insertar?>&editar=<?=$editar?>&eliminar=<?=$eliminar?>"><FONT size="3">ACTUALIZAR CARGA USUARIOS</font></a></div><? } ?><table width="624" border="0"  cellpadding="0">
                        <tr> 
                          
						  <td  class="ctablasup" >No</td>
						  <td  class="ctablasup" >FECHA </td>
						  <td  class="ctablasup" >REMISION</td>
						  <td  class="ctablasup">BODEGA</td>
						  <td  class="ctablasup">USUARIO</td>
						  <td  class="ctablasup">TOTAL</td>
                          <td  class="ctablasup"  width="112">OPCIONES</td>
                        </tr>
						<? 
						
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_alamce.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						
						//echo $sql;
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> 
							<form name='forma_$db->cod_ment' method='POST' action='man_cargue_inventario.php'>  ";
							
							
							echo "<td >$db->cod_ment</td>";
                          	echo "<td >$db->fec_ment</td>";
							echo "<td >$db->fac_ment</td>";
							echo "<td >".strtoupper($db->nom_bod)."</td>";
							echo "<td >".strtoupper($db->nom_usu)." </td>";
							echo "<td align='right'  >".number_format(sumartotal($db->cod_ment,$global[5],$global[6]),0,",",".")."</td>";
							
                            echo "<td aling='center' >"; 
							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                            echo 	" <tr>  <td align='center'>
							<input type='hidden' name='codigo' value='$db->cod_ment'>";
							if ($editar==1)
							 	echo "<img src='imagenes/icoeditar.gif' alt='Editar Registro' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_ment.submit()'/></td>";
							else 
								echo "<img src='imagenes/icoeditar.gif' alt='Editar Registro' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_ment.submit()'/></td>";
                            echo 	"<td align='center'>";
							if ($eliminar==1)
								echo"<img src='imagenes/icoeliminar.gif' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_ment) /></td> ";
							else
								echo"<img src='imagenes/e_icoeliminar.gif' width='16' height='16'  /></td> ";
							
							//impresion	
							echo "<td align='center'><img src='imagenes/mirar.png' width='16' height='16'  style=\"cursor:pointer\" onClick=\"imprimir_inf('inf_cargue_inventario.php',$db->cod_ment,'mediano')\" /></td>";	
							
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
<form name="forma" method="post" action="con_cargue_inventario.php">
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
