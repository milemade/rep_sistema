<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?
if ($codigo!="") {

    $sql ="SELECT * FROM listaprecio  WHERE cos_list = $codigo";
    $dbdatos= new  Database();
    $dbdatos->query($sql);
    $dbdatos->next_row();

}





if($guardar==1 and $codigo==0) { 

	$campos="(nom_list)";

	

	$valores="('".$nombres."')" ;

	$error=insertar("listaprecio",$campos,$valores); 

	if ($error==1) {

		header("Location: con_lista.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 

	}

	else

		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 

}



if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 

	

	

	$campos="nom_list='".$nombres."' ";

	//exit;

	$error=editar("listaprecio",$campos,'cos_list',$codigo); 

	if ($error==1) {

		header("Location: con_lista.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 

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

if (document.getElementById('nombres').value == ""   )

	return false;

else

	return true;

}



function verdatalle() {

var dato =document.getElementById('codigo').value;

		window.open("formatos/ver_lista.php?codigo="+dato,"ventana","menubar=0,resizable=1,width=900,height=600,toolbar=0,scrollbars=yes")

}



</script>



</head>

<body <?=$sis?>>

<form  name="forma" id="forma" action="man_lista.php"  method="post">

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

        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nuevo Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>

        <td width="61" class="ctablaform">Guardar</td>

        <td width="21" class="ctablaform"><a href="con_lista.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>

        <td width="65" class="ctablaform">Cancelar </td>

        <td width="22" class="ctablaform"><a href="con_lista.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>

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

    <td class="textotabla1 Estilo1">LISTAS:</td>

  </tr>

  <tr>

    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>

  </tr>

  <tr>

    <td bgcolor="#E9E9E9" valign="top">

	<table width="629" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="66" class="textotabla1">Nombre:</td>

        <td width="167"><input name="nombres" id="nombres" type="text" class="textfield2"  value="<?=$dbdatos->nom_list?>" />

          <span class="textorojo">*</span></td>

        <td width="10" align="left" class="textorojo">&nbsp;</td>

        <td width="61" class="textotabla1">&nbsp;</td>

        <td width="206"><?

            	if($codigo != 0)

					echo '<INPUT type="button" value="Det. Lista" class="botones" onClick="verdatalle()">';

			?></td>

        <td width="96" class="textorojo" >&nbsp;</td>

        <td width="29" class="textorojo">&nbsp;</td>

      </tr>

	  	  <tr>

        <td class="textotabla1">&nbsp;</td>

        <td>&nbsp;</td>

        <td class="textorojo">&nbsp;</td>

        <td class="textotabla1">&nbsp;</td>

        <td>&nbsp;</td>

        <td class="textorojo">&nbsp;</td>

        <td class="textorojo">&nbsp;</td>

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

<?php $dbdatos->close(); ?>

</body>

</html>



