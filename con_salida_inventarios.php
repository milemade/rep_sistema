<? include("lib/database.php");   include("js/funciones.php");
   if($mensaje!="")  {     echo "<font face='arial' size='2' color='#8A0808'>".$mensaje."</font>";     echo "<script>alert('".$mensaje."');</script>";  }
?><? 
$ahora = date("Y-n-j H:i:s");
$_SESSION["ultimoAcceso"] = $ahora;

        if($global[1]==2)
	{ //Si es Usuario Inventarios crea tablas temporales salida
	     require_once("crear_tmpremision.php");
	} 

if($eliminacion==1) {//confirmacion de eliminacion  

	//$sql="select *,(select cod_bod from m_remision where cod_fac=$eli_codigo) as bodega from  d_remision where cod_mfac=$eli_codigo";
	//Busca el detalle de la entrada para borralo en el kardex
	$sql="select  cod_pro,cod_bod,cant_pro,cod_peso,serial from ".$global[8]." where cod_mfac=$eli_codigo";
	//echo $sql; exit;
	$dbser= new  Database();	
	$dbser->query($sql);
	while($dbser->next_row()){
	   //aqui repone los articulos en kardex
	        if($global[1]==1)
	        { 
		   kardex("suma",$dbser->cod_pro,$dbser->cod_bod,$dbser->cant_pro,0,$dbser->cod_peso,$dbser->serial);
		}
	}
        $dbser->close();
	//aqui elimina el registro de maestra entrada
	$error=eliminar($global[7],$eli_codigo,"cod_fac");

	
	//Aqui elimina el detalle
	$sql ="DELETE FROM ".$global[8]." WHERE cod_mfac=$eli_codigo";//=		
	$dbdatos_1= new  Database();
	$dbdatos_1->query($sql);
	$dbdatos_1->close();
	
	
	if ($error >=1)
	echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;
}


if($confirmacion==1) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Actualizo el registro Correctamente..') </script>" ;

if($confirmacion==2) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Edito el registro Correctamente..') </script>" ;


$where_cli="";
$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre      
        from punto_venta  
		inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod 
	    where cod_ven=$global[2]";
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

//echo $det."=";

if($det==0)
	$where.=" where a.cod_fac>0    ";

if(!empty($busquedas)) { #codigo para buscar 
	$busquedas=reemplazar_1($busquedas);
	$where.=" and $busquedas   ";
}#codigo para buscar 



$sql="select a.cod_fac,a.fecha,a.num_fac , d.nom_bod nom_cliente,c.nom_usu
        from ".$global[7]." a
		join ".$global[8]." b ON a.cod_fac = b.cod_mfac
		join usuario  c on c.cod_usu=a.cod_usu
        join bodega1  d on d.cod_bod=a.cod_cli 
		LEFT join bodega e on e.cod_bod =a.cod_bod 
		$where AND a.num_fac>0 GROUP BY a.cod_fac ORDER BY a.cod_fac DESC ";

//exit;

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
$sql .= ";";
$busquedas=reemplazar($busquedas);
//echo $sql;
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
<?if($global[1]==1) 
	{?><div align="center"><a href="actualizarsalidainventarios.php"><FONT size="3">ACTUALIZAR CARGA USUARIOS</font></a></div><? } ?>
<table align="center">
<tr>
<td valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_salidainventario.php">
                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td bgcolor="#E9E9E9"><table width="624" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="8" height="33"> </td>
                          <td width="17"> 
						  <? if ($insertar==1) {?>
					  	  <img src="imagenes/page.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_salidainventario.php?codigo=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>'"/>
					  	  <? } ?></td>
                          <td width="133"><span class="ctablaform">
                            <? if ($insertar==1) {?>
								Agregar
							<? } ?>
                          </span></td>
                          <td width="50" class="ctablaform">Buscar: </td>
                          <td width="103" class="ctablaform"><input name="text" type="text" class="textfield" size="12" id="texto" /></td>
                          <td width="20"><label> <span class="ctablaform">en</span></label></td>
                          <td width="160" class="ctablaform"><select name="campos" class="textfieldlista" id="campos" >
                            <option value="0">Seleccion</option>
                            <option value="fecha">Fecha</option>
                            <option value="num_fac">No Remision</option>
                            <option value="bodega1.nom_bod">Cliente</option>
                            <option value="-1">Lista Completa</option>
                          </select></td>
                          <td width="41" valign="middle"><img src="imagenes/ver.png" alt="Buscar" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>
                          <td width="54" valign="middle" class="ctablaform">&nbsp;</td>
                          <td width="38" valign="middle">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="624" border="0"  cellpadding="0">
                        <tr>
  						  <td  class="ctablasup">FECHA </td>
						  <td  class="ctablasup">Remision No</td>
						  <td  class="ctablasup">VENDEDOR</td>
						  <!--<td  class="ctablasup">TIPO PAGO</td>-->
						  <td  class="ctablasup">CLIENTE</td>
                          <td  class="ctablasup"  width="112">OPCIONES</td>
                        </tr>
						<? 
						
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_salidainventario.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						
						//echo $sql;
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_fac' action='man_salidainventario.php'>  ";
							echo "<td >$db->fecha </td>";
							echo "<td ><div align='center'>$db->num_fac </div></td>";
							echo "<td >".strtoupper($db->nom_usu)." </td>";
							//echo "<td >$db->tipo_pago </td>";
							echo "<td >$db->nom_cliente </td>";
							echo "<td aling='center' >"; 
							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_fac'>";
							if ($editar!=10)
							 	echo "<img src='imagenes/icoeditar.gif' alt='Editar Registro' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_fac.submit()'/></td>";
							else 
								echo "<img src='imagenes/e_icoeditar.gif' width='16' height='16'  /></td>";
                            echo 	"<td align='center'>";
							if ($eliminar!=10)
								echo"<img src='imagenes/icoeliminar.gif' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_fac) /></td> ";
							else
								echo"<img src='imagenes/e_icoeliminar.gif' width='16' height='16'  /></td> ";
                           
						   //impresion	
							echo "<td align='center'><img src='imagenes/mirar.png' width='16' height='16'  style=\"cursor:pointer\" onClick=\"imprimir_inf('ver_remisionsalida_v.php',$db->cod_fac,'grande')\" /></td>";	
							
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
<form name="forma" method="post" action="con_salida_inventarios.php">
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
