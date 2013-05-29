<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?

if ($codigo!="") {

	$sql ="SELECT cod_ven, cc_ven, nom_ven, dir_ven, tel_ven, cod_emp_ven, cod_bod_ven, fec_ing_ven, fec_ret_ven, inv_ven, cod_car_ven,  

tipo_com_ven , cod_tab_com_ven , por_com_ven, garan_ven, sueldo

    FROM vendedor  WHERE cod_ven = $codigo";

    $dbdatos= new  Database();

    $dbdatos->query($sql);

    $dbdatos->next_row();
    $dbdatos->close();

}



if($guardar==1 and $codigo==0) { 
	$compos="(nom_ven,cc_ven,tel_ven, dir_ven,  cod_emp_ven, cod_bod_ven, fec_ing_ven, fec_ret_ven, cod_car_ven,tipo_com_ven , cod_tab_com_ven , por_com_ven, garan_ven,sueldo)";

	

	$valores="('".$nombres."','".$cc."','".$tel."','".$dir."','".$rsocial."','".$bodega."','".$fecha_ing."','".$fecha_ret."','".$cargo."','".$tipo_com."','".$m_comisiones."','".$comision."','".$garantia."','".$val_sueldo."')" ;

	

	$error=insertar("vendedor",$compos,$valores); 

	if ($error==1) {
		header("Location: con_tercero.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 

	}

	else

		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 

}



if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 

	$compos="cc_ven='".$cc."', nom_ven='".$nombres."', tel_ven='".$tel."',dir_ven='".$dir."', cod_emp_ven='".$rsocial."', cod_bod_ven='".$bodega."',  fec_ing_ven='".$fecha_ing."', fec_ret_ven='".$fecha_ret."', cod_car_ven='".$cargo."', tipo_com_ven='".$tipo_com."', cod_tab_com_ven='".$m_comisiones."', por_com_ven='".$comision."', garan_ven='".$garantia."', sueldo='".$val_sueldo."' ";

	//exit;

	$error=editar("vendedor",$compos,'cod_ven',$codigo); 

	if ($error==1) {
		header("Location: con_tercero.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 

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

if (document.getElementById('nombres').value == "" ||  document.getElementById('cc').value == ""  )

	return false;

else

	return true;

}



function fun_tablas(obj){



if (obj.value=="tabla"){

	document.getElementById("tabla").style.display="inline";

	document.getElementById("fija").style.display="none";

	document.getElementById("sueldo").style.display="none";

	document.getElementById("comision").value=-1;

	document.getElementById("val_sueldo").value=0;

}



if (obj.value=="comision"){

	document.getElementById("tabla").style.display="none";

	document.getElementById("fija").style.display="inline";

	document.getElementById("sueldo").style.display="none";

	document.getElementById("comision").value=0;

	document.getElementById("val_sueldo").value=0;

}



if (obj.value=="sueldo"){

	document.getElementById("tabla").style.display="none";

	document.getElementById("fija").style.display="none";

	document.getElementById("sueldo").style.display="inline";

	document.getElementById("comision").value=0;

	document.getElementById("comision").value=-1;

}





}



</script>



</head>

<body <?=$sis?>>

<form  name="forma" id="forma" action="man_tercero.php"  method="post">

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

        <td width="21" class="ctablaform"><a href="con_tercero.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>

        <td width="65" class="ctablaform">Cancelar </td>

        <td width="22" class="ctablaform"><a href="con_tercero.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>

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

    <td class="textotabla1 Estilo1">EMPLEADOS:</td>

  </tr>

  <tr>

    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>

  </tr>

  <tr>

    <td bgcolor="#E9E9E9" valign="top">

	<table width="629" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td class="textotabla1">Nombres:</td>

        <td width="153"><input name="nombres" id="nombres" type="text" class="textfield2"  value="<?=$dbdatos->nom_ven?>" />

          <span class="textorojo">*</span></td>

        <td width="18" align="left" class="textorojo">&nbsp;</td>

        <td width="105" class="textotabla1">Identificacion:</td>

        <td><input name="cc" id="cc" type="text" class="textfield2"  value="<?=$dbdatos->cc_ven?>" onkeypress="  return validaInt()" />

          <span class="textorojo">*</span></td>

        <td class="textorojo">&nbsp;</td>

        <td class="textorojo">&nbsp;</td>

      </tr>

      <tr>

        <td class="textotabla1">Direccion:</td>

        <td><input name="dir" id="dir" type="text" class="textfield2"  value="<?=$dbdatos->dir_ven?>" /></td>

        <td class="textorojo">&nbsp;</td>

        <td class="textotabla1">Telefono:</td>

        <td><input name="tel" id="tel" type="text" class="textfield2"  value="<?=$dbdatos->tel_ven?>" /></td>

        <td class="textorojo">&nbsp;</td>

        <td class="textorojo">&nbsp;</td>

      </tr>

      <tr>

        <td class="textotabla1">Cargo:</td>

        <td><? combo("cargo","cargo","cod_car","des_car",$dbdatos->cod_car_ven); ?></td>

        <td>&nbsp;</td>

        <td class="textotabla1">Bodega:</td>

        <td><? combo("bodega","bodega","cod_bod","nom_bod",$dbdatos->cod_bod_ven); ?></td>

        <td class="textorojo">&nbsp;</td>

        <td class="textorojo">&nbsp;</td>

      </tr>

      <tr>

        <td class="textotabla1">Empresa:</td>

        <td ><a href="#">

          <? combo("rsocial","rsocial","cod_rso","nom_rso",$dbdatos->cod_emp_ven); ?>

        </a></td>

        <td>&nbsp;</td>

        <td class="textotabla1">&nbsp;</td>

        <td ><a href="#"></a></td>

        <td class="textorojo">&nbsp;</td>

        <td class="textorojo">&nbsp;</td>

      </tr>

      <tr>

        <td class="textotabla1">Fecha ing.</td>

        <td><input name="fecha_ing" type="text" class="fecha" id="fecha_ing" readonly="1" value="<?=$dbdatos->fec_ing_ven?>"/>

          <a href="#"><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario"/></a></td>

        <td><a href="#"></a></td>

        <td class="textotabla1">Fecha ret. </td>

        <td><input name="fecha_ret" type="text" class="fecha" id="fecha_ret" readonly="1" value="<?=$dbdatos->fec_ret_ven?>"/>

          <a href="#"><img src="imagenes/date.png" alt="Calendario" name="calendario1" width="16" height="16" border="0" id="calendario"/></a></td>

        <td class="textorojo">&nbsp;</td>

        <td class="textorojo">&nbsp;</td>

      </tr>

      <tr>

        <td width="66" class="textotabla1">Garantia:</td>

        <td colspan="3" class="textotabla1"><input name="garantia" type="text" class="textfield2" id="garantia"  value="<?=$dbdatos->garan_ven?>" size="70"  /></td>

        <td width="162">&nbsp;</td>

        <td width="96" class="textorojo">&nbsp;</td>

        <td width="29" class="textorojo">&nbsp;</td>

      </tr>

	   <tr>

        <td width="66" class="textotabla1">&nbsp;</td>

        <td colspan="4" class="textotabla1">Tabla de Comision <?=$dbdatos->tipo_com_ven; ?>

		

		<?

		

		if($dbdatos->tipo_com_ven=="tabla"){ 

			$activo="checked='checked'";

			$display="inline";

			$display1="none";

			$display2="none";

		}

		if($dbdatos->tipo_com_ven=="comision") {

			$activo1="checked='checked'";

			$display="none";

			$display1="inline";

			$display2="none";

		}

		

		if($dbdatos->tipo_com_ven=="sueldo") {

			$activo2="checked='checked'";

			$display="none";

			$display1="none";

			$display2="inline";

		}

		

		

		 ?>

		 <input name="tipo_com" id="tipo_comision_tabla" type="radio" value="tabla"  onClick="fun_tablas(this)" <?=$activo?>/>

         &nbsp;&nbsp; Comision  

		 <input name="tipo_com" id="tipo_comision_comision" type="radio" value="comision"  onClick="fun_tablas(this)" <?=$activo1?>/>

		  &nbsp;&nbsp; Sueldo Fijo

		 <input name="tipo_com" id="sueldo_fijo" type="radio" value="sueldo"  onClick="fun_tablas(this)" <?=$activo2?>/>

 		    </td>

		  

        <td width="96" class="textorojo">&nbsp;</td>

        <td width="29" class="textorojo">&nbsp;</td>

      </tr>

	  <tr>

        <td width="66" class="textotabla1">&nbsp;</td>

        <td colspan="3" class="textotabla1">

		

		<div id="tabla" style="display:<?=$display?>">

			<table width="100%">

				<tr>

					<td class="textotabla1">Tabla de Comisiones </td>

					<td><span class="textorojo">

					  <? combo("m_comisiones","m_comisiones","cod_tabla","nom_tabla",$dbdatos->cod_tab_com_ven); ?>

					</span></td>

				</tr>

			</table>

		</div>

		

		<div id="sueldo" style="display:<?=$display2?>">

		<table width="100%" >

          <tr>

            <td class="textotabla1">Valor </td>

            <td><span class="textorojo">

              <input name="val_sueldo" id="val_sueldo" type="text" class="textfield2"  value="<?=$dbdatos->sueldo?>" onkeypress="  return validaInt()" />

            </span></td>

          </tr>

        </table>

		</div>		

		

		<div id="fija" style="display:<?=$display1?>">

		<table width="100%" >

          <tr>

            <td class="textotabla1">Comision Fija % </td>

            <td><span class="textorojo">

              <input name="comision" id="comision" type="text" class="textfield2"  value="<?=number_format($dbdatos->por_com_ven,"2",".","")?>" onChange="validaValue(this);" onKeyPress=" return validaFloat(this)"   />

            </span></td>

          </tr>

        </table>

		</div>		

		

		</td>

        <td width="162">&nbsp;</td>

        <td width="96" class="textorojo">		  </td>

        <td width="29" class="textorojo">&nbsp;</td>

      </tr>

	    <tr>

        <td width="66" class="textotabla1">&nbsp;</td>

        <td colspan="3" class="textotabla1">		</td>

        <td width="162">&nbsp;</td>

        <td width="96" class="textorojo">&nbsp;</td>

        <td width="29" class="textorojo">&nbsp;</td>

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

<script type="text/javascript">

			Calendar.setup(

				{

				inputField  : "fecha_ing",      

				ifFormat    : "%Y-%m-%d",    

				button      : "calendario" ,  

				align       :"T3",

				singleClick :true

				}

			);

</script>

<script type="text/javascript">

			Calendar.setup(

				{

				inputField  : "fecha_ret",      

				ifFormat    : "%Y-%m-%d",    

				button      : "calendario1" ,  

				align       :"T3",

				singleClick :true

				}

			);

</script>



</body>

</html>

