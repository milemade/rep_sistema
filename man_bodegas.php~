<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?
if($codigo==0) 
$codigo=-10; 
if ($codigo!="") {

	    $sql ="SELECT * FROM bodega1 WHERE cod_bod= $codigo";

		$dbdatos= new  Database();

		$dbdatos->query($sql);

		$dbdatos->next_row();
}
if($guardar==1 and $codigo==-10) { 

	$campos="(nom_bod, max_cos_bod, iden_bod , dir_bod,tel_bod, ciu_bod,mail_bod, tipo_bod ,propia, cod_lista ,dias_traslado ,dias_credito,cod_covinoc, fec_covinoc, cupo_au_covinoc, cupo_traslados,cod_bod_cli )";

	

	 $valores="('".$nombresito."','".$max_traslado."', '".$identificacion."',  '".$direccion."',  '".$telefono."','".$ciudad."', '".$correo."', '1','".$propia."','".$lista."', '".$ven_traslado."','".$ven_factura."','".$cod_covinoc."','".$fec_covinoc."','".$max_credito."','".$max_traslado."','".$bodega."')" ;  

	

	$error=insertar("bodega1",$campos,$valores); 

	

		

	

	if ($error==1) {

		header("Location: con_bodegas.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 

	}

	else

		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 

}



if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 

	$campos="nom_bod='".$nombresito."', max_cos_bod='".$max_traslado."', iden_bod='".$identificacion."',  dir_bod='".$direccion."',  tel_bod='".$telefono."', ciu_bod='".$ciudad."', mail_bod='".$correo."', propia='".$propia."',  cod_lista='".$lista."', dias_traslado='".$ven_traslado."', dias_credito= '".$ven_factura."', cod_covinoc= '".$cod_covinoc."', fec_covinoc= '".$fec_covinoc."', cupo_au_covinoc= '".$max_credito."', cupo_traslados= '".$max_traslado."' , cod_bod_cli= '".$bodega."'";

	

	

//	enviar_alerta("Alerta de Cambio de Datos ","Se han Modificado los datos del cliente: $nombresito ", "Se han Modificado los datos del cliente: $nombresito  <a href='http://www.globater.com/sistema/man_bodegas.php?codigo=$codigo&editar=1&insertar=1&eliminar=1'>Consultar Formulario</a> ");

	//exit;

	$error=editar("bodega1",$campos,'cod_bod',$codigo); 

	

	if ($error==1) {

		header("Location: con_bodegas.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 

	}

	else

		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 

}



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<link href="css/styles.css" rel="stylesheet" type="text/css" />

<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />

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

if (document.getElementById('nombresito').value == "" ||  document.getElementById('identificacion').value == ""  )

	return false;

else

	return true;

}

</script>



</head>

<body <?=$sis?>>

<form  name="forma" id="forma" action="man_bodegas.php"  method="post">

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

        <td width="21" class="ctablaform"><a href="con_bodegas.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>

        <td width="65" class="ctablaform">Cancelar </td>

        <td width="22" class="ctablaform"><a href="con_bodegas.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>

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

    <td class="textotabla1 Estilo1">CLIENTE:</td>

  </tr>

  <tr>

    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>

  </tr>

  <tr>

    <td bgcolor="#E9E9E9" valign="top">

	<table width="629" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="85" class="textotabla1">Nombre:</td>

        <td width="154"><input name="nombresito" id="nombresito" type="text" class="textfield2"  value="<?=$dbdatos->nom_bod?>" />

          <span class="textorojo">*</span></td>

        <td width="14" align="left" class="textorojo">&nbsp;</td>

        <td width="85" class="textotabla1">Codigo:</td>

        <td width="269"><input name="identificacion" id="identificacion" type="text" class="textfield2"  value="<?=$dbdatos->iden_bod?>"  />

          <span class="textorojo">*</span></td>

        <td width="22" class="textorojo">&nbsp;</td>

        </tr>

      <tr>

        <td class="textotabla1">Direccion:</td>

        <td><input name="direccion" id="direccion" type="text" class="textfield2"  value="<?=$dbdatos->dir_bod?>" /></td>

        <td class="textorojo">&nbsp;</td>

        <td class="textotabla1">Telefonos:</td>

        <td><input name="telefono" id="telefono" type="text" class="textfield2"  value="<?=$dbdatos->tel_bod?>" /></td>

        <td class="textorojo">&nbsp;</td>

        </tr>

      <tr>

        <td class="textotabla1">Ciudad:</td>

        <td><input name="ciudad" id="ciudad" type="text" class="textfield2"  value="<?=$dbdatos->ciu_bod?>" /></td>

        <td class="textorojo">&nbsp;</td>

        <td class="textotabla1">E-mail:</td>

        <td><input name="correo" id="correo" type="text" class="textfield2"  value="<?=$dbdatos->mail_bod?>" /></td>

        <td class="textorojo">&nbsp;</td>

        </tr>

	  <tr>

	    <td class="textotabla1">Fecha consulta: </td>

	    <td><input name="fec_covinoc" id="fec_covinoc" type="text" class="textfield2" readonly="-1"  value="<?=$dbdatos->fec_covinoc?>" />

	      <img src="imagenes/date.png" alt="Calendario" name="calendario" width="18" height="18" id="calendario" style="cursor:pointer"/></td>

	    <td class="textorojo">&nbsp;</td>

	    <td class="textotabla1">Dias factura: </td>

	    <td><input name="ven_factura" id="ven_factura" onkeypress="return validaInt('%d', this,event)"  type="text" class="textfield2"  value="<?=$dbdatos->dias_credito?>" /></td>

	    <td class="textorojo">&nbsp;</td>

	    </tr>

	  <tr>

	    <td class="textotabla1">L.Precio:</td>

	    <td><? combo("lista","listaprecio","cos_list","nom_list",$dbdatos->cod_lista); ?></td>

	    <td class="textorojo">&nbsp;</td>

	    <td class="textotabla1">Valor credito: </td>

	    <td><input name="max_credito" id="max_credito" type="text" class="textfield2" onkeypress="return validaInt('%d', this,event)"  value="<?=$dbdatos->cupo_au_covinoc?>" /></td>

	    <td class="textorojo">&nbsp;</td>

	    </tr>

		 <tr>

	    <td class="textotabla1">Bodega:</td>

	    <td><? combo("bodega","bodega","cod_bod","nom_bod",$dbdatos->cod_bod_cli); ?></td>
        

	    <td class="textorojo">&nbsp;</td>

	    <td class="textotabla1">&nbsp;</td>

	    <td>&nbsp;</td>

	    <td class="textorojo">&nbsp;</td>

	    </tr>

		

	  	  <tr>

        <td colspan="6" valign="bottom"></td>

        </tr>

    </table></td>

  </tr>

  

  <tr>

    <td>&nbsp;</td>

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

<script type="text/javascript">

			

			Calendar.setup(

				{

					inputField  : "fec_covinoc",      

					ifFormat    : "%Y-%m-%d",    

					button      : "calendario" ,  

					align       :"T3",

					singleClick :true

				}

			);

			

</script>

</html>





