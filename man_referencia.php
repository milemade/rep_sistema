<?PHP include("lib/database.php")?>
<?PHP include("js/funciones.php")?>
<?PHP



if ($codigo!="")
{

    $sql ="SELECT 
	cod_pro,
	cod_fry_pro,
	nom_pro,
	pre_ven_pro,
	pre_com_pro,
	iva_pro,
	cod_tpro_pro,
	cod_mar_pro,
	cod_pes_pro,
	unidad,
	min_pro
	from producto WHERE cod_pro=$codigo";
	
    $dbdatos= new  Database();
    $dbdatos->query($sql);
    $dbdatos->next_row();
    $dbdatos->close();

}



if($guardar==1 and $codigo==0) 
{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS

	$compos="(cod_fry_pro,nom_pro,pre_com_pro,pre_ven_pro,iva_pro,unidad,cod_tpro_pro,cod_mar_pro,cod_pes_pro,min_pro)";

	$valores="('".$codigos."','".$nombres."','".$costo."','".$venta."','".$iva."','".$unidad."','".$tipo_producto."','".$marca."','".$peso."','".$minimo."')" ;

	$error=insertar("producto",$compos,$valores); 

	if ($error==1)
	{
		header("Location: con_referencia.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}

	else

		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 

}



if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS

	$compos="cod_fry_pro='".$codigos."', nom_pro='".$nombres."', pre_com_pro='".$costo."', pre_ven_pro='".$venta."',iva_pro='".$iva."',unidad='".$unidad."',cod_tpro_pro='".$tipo_producto."',cod_mar_pro='".$marca."',cod_pes_pro='".$peso."' ,min_pro='".$minimo."'  ";

	$error=editar("producto",$compos,'cod_pro',$codigo); 

	if ($error==1) {

		header("Location: con_referencia.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 

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

if (document.getElementById('nombres').value == "" || document.getElementById('codigos').value == ""  || document.getElementById('tipo_producto').value == 0 || document.getElementById('marca').value == 0  || document.getElementById('unidad').value == "" || document.getElementById('costo').value == "" || document.getElementById('venta').value == ""|| document.getElementById('iva').value == "" )

	return false;

else

	return true;

}



function buscar_codigo(){



var cajita_codigo=document.getElementById('codigos').value;

var vec_codigo = new Array;

<?

$dbdatos111= new  Database();

$sql ="select cod_fry_pro from producto";

$dbdatos111->query($sql);

$i = 0;

while($dbdatos111->next_row()){

	echo "vec_codigo[$i]= '$dbdatos111->cod_fry_pro';\n";	

	$i++;

 

}
$dbdatos111->close();


?>

var encontre=0;

for (j=0; j<<?=$i?>;j++){

	if(cajita_codigo==vec_codigo[j])

		encontre=1;

}



if(encontre==1){	

	if (document.getElementById('codigos').value!="") {

		alert('La referencia ya esta registrada')

		//document.getElementById('codigos').setfocus();

		document.getElementById('codigos').value="";

		return false;

	}

}



}





</script>



</head>

<body <?=$sis?>>

<form  name="forma" id="forma" action="man_referencia.php"  method="post">

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

        <td width="21" class="ctablaform"><a href="con_referencia.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>

        <td width="65" class="ctablaform">Cancelar </td>

        <td width="22" class="ctablaform"><a href="con_referencia.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>

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

    <td class="textotabla1 Estilo1">PRODCUTO:</td>

  </tr>

  <tr>

    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>

  </tr>

  <tr>

    <td bgcolor="#E9E9E9" valign="top">

	<table width="629" border="0" cellspacing="0" cellpadding="0">

		<tr>

        <td width="106" class="textotabla1">Categoria</td>

        <td width="148"><? combo_evento("marca","marca","cod_mar"," nom_mar ",$dbdatos->cod_mar_pro,"", "nom_mar"); ?></td>

        <td width="17" class="textorojo">*</td>

        <td width="113" class="textotabla1">Uni. X Empaque:</td>

        <td width="159"><input name="unidad" id="unidad" type="text" class="textfield2"  value="<?=$dbdatos->unidad?>" onkeypress="  return validaInt()" /></td>

       <td width="11" class="textorojo">*</td>

        <td width="75" class="textorojo">&nbsp;</td>

      </tr>

	  

	  

	  

	  

      <tr>

        <td width="106" class="textotabla1">Tipo Prodcuto </td>

        <td width="148">

		<? combo_evento("tipo_producto","tipo_producto","cod_tpro"," nom_tpro ",$dbdatos->cod_tpro_pro,"", "nom_tpro"); ?>

		</td>

        <td width="17" class="textorojo">*</td>

        <td width="113" class="textotabla1">Precio Costo:</td>

        <td width="159">

		<input name="costo" id="costo" type="text" class="textfield2"  value="<?=$dbdatos->pre_com_pro?>"  onkeypress="  return validaInt()" />

		</td>

       <td width="11" class="textorojo">*</td>

        <td width="75" class="textorojo">&nbsp;</td>

      </tr>

      <tr>

        <td class="textotabla1">Codigo:</td>

        <td><input name="codigos" id="codigos" type="text" class="textfield2"  value="<?=$dbdatos->cod_fry_pro?>"  onchange="buscar_codigo()"  onblur="buscar_codigo()" /></td>

        <td><span class="textorojo">*</span></td>

        <td class="textotabla1">Precio Venta :</td>

        <td><input name="venta" id="venta" type="text" class="textfield2"  value="<?=$dbdatos->pre_ven_pro?>" onkeypress="  return validaInt()" /></td>

        <td ><span class="textorojo">*</span></td>

        <td >&nbsp;</td>

      </tr>

      <tr>

        <td class="textotabla1">Nombre:</td>

        <td><input name="nombres" id="nombres" type="text" class="textfield2"  value="<?=$dbdatos->nom_pro?>" /></td>

        <td><span class="textorojo">*</span></td>

        <td class="textotabla1">IVA %:</td>

        <td><input name="iva" id="iva" type="text" class="textfield2"  value="<?=$dbdatos->iva_pro?>" onkeypress="  return validaInt()"  /></td>

        <td ><span class="textorojo">*</span></td>

        <td >&nbsp;</td>

      </tr>

	  

	  <tr>

        <td class="textotabla1">Cant. Minima </td>

        <td><input name="minimo" id="minimo" type="text" class="textfield2"  value="<?=$dbdatos->min_pro?>" /></td>

        <td>&nbsp;</td>

        <td class="textotabla1">&nbsp;</td>

        <td>&nbsp;</td>

        <td >&nbsp;</td>

        <td >&nbsp;</td>

      </tr>

    </table></td>

  </tr>

  

  <tr>

    <td><div align="center"><img src="imagenes/spacer.gif" alt="." width="624" height="4" /></div></td>

  </tr>

  <tr>

    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>

  </tr>

  <tr>

    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />

	</td>

  </tr>

</table>

</form> 



</body>

</html>

