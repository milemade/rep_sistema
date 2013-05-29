<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?
if ($codigo!="") {
$sql ="SELECT  cod_asi, cod_rut_asi, cod_ven_asi  FROM asignacion WHERE cod_asi=$codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	$compos="(cod_rut_asi,cod_ven_asi)";
	$valores="('".$ruta."','".$vendedor."')" ;
	$error=insertar("asignacion",$compos,$valores); 
	if ($error==1) {
		header("Location: con_asignacion.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS
	$compos="cod_rut_asi='".$ruta."',"."cod_ven_asi='".$vendedor."'";
	$error=editar("asignacion",$compos,'cod_asi',$codigo); 
	if ($error==1) {
		header("Location: con_asignacion.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {font-size: 12px}
</style> 

<? inicio() ?>

<script language="javascript">
function datos_completos(){  
	verifica_rutas();
	return true;
	//return false;
	//return verifica_rutas();
}


function verifica_rutas(){
	var cajita_vendedor=document.getElementById('vendedor').value;
	var cajita_ruta=document.getElementById('ruta').value;
	var vec_codigo = new Array;
	<?
	$dbdatos111= new  Database();
	$sql ="SELECT cod_rut_asi,cod_ven_asi from asignacion";
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_codigo[$i]= new Array ('$dbdatos111->cod_rut_asi','$dbdatos111->cod_ven_asi');\n";	
		$i++;
	}
	?>
	var encontre=0;

	for (j=0; j<<?=$i?>;j++){
		if(cajita_ruta==vec_codigo[j][0] &&  cajita_vendedor==vec_codigo[j][1])
			encontre=1;
	}


	if(encontre==1){	
			alert('Existe Otra Asiganacion Igual')
			return false;
		}
		
	else 
		return true;
}
</script>

</head>
<body <?=$sis?>>
<form  name="forma" id="forma" action="man_asignacion.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td bgcolor="#E9E9E9"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
         <td width="5" height="19">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_asignacion.php?confirmacion=0&amp;editar=<?=$editar?>&amp;insertar=<?=$insertar?>&amp;eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_asignacion.php?confirmacion=0&amp;editar=<?=$editar?>&amp;insertar=<?=$insertar?>&amp;eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>
        <td width="70" class="ctablaform">Consultar</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle"><label>
          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
        </label></td>
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla1 Estilo1">ASIGNACION DE RUTAS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="87" class="textotabla1">Ruta:</td>
        <td width="120"><? combo_evento("ruta","ruta","cod_rut","nom_rut",$dbdatos->cod_rut_asi,"","nom_rut"); ?></td>
        <td width="12">&nbsp;</td>
        <td width="67"><span class="textotabla1">Vendedor:</span></td>
        <td width="124"><label>
        <? combo_evento("vendedor","vendedor","cod_ven","nom_ven",$dbdatos->cod_rut_ven,"","nom_ven"); ?>
        </label></td>
        <td width="13" class="textorojo">&nbsp;</td>
        <td width="206" class="textorojo">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td><div align="center"><img src="imagenes/spacer.gif" alt="." width="624" height="4" /></div></td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
	</td>
  </tr>
</table>
</form> 
</body>
</html>
