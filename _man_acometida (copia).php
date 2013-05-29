<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?

if ($codigo!="") {
$sql ="SELECT cod_ava, ced_ava, fec_ava, nom_edi_ava, esta_visi_eva, dir_ava, com_ava, barrio_ava, estra_ava, num_b_t_ava, 
		tipo_lug_ava, hora_ava, min_ava, construc_ava, cia_admin_ava, nom_admin_ava, tel_por_ava, tel_admon_ava, planta_ava, 
		obs_ava, cod_emp_ava
		FROM avanzada  WHERE cod_ava=$codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	$compos="(ced_ava, fec_ava, nom_edi_ava, esta_visi_eva,	dir_ava, com_ava, 
	barrio_ava, estra_ava, num_b_t_ava,tipo_lug_ava, hora_ava, min_ava, construc_ava, 
	cia_admin_ava, 	nom_admin_ava, tel_por_ava, tel_admon_ava, planta_ava, obs_ava, cod_emp_ava)";		
	$valores="('".$cuentaed."','".$fecha."','".$nom_edificio."','".$estado."','".$direccion."','".$com."','".$barrio."','".$estrato."','".$num_torres."',
	'".$tipo_lugar."','".$hora."','".$minuto."','".$contructora."','".$cia_admin."','".$administrador."','".
	$tel_proteria."','".$tel_admin."','".$planta_elec."','".$observaciones."','".$tercero."')" ;
	$error=insertar("avanzada",$compos,$valores); 
	if ($error==1) {
		header("Location: con_avanzada.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}
if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS
	$compos="ced_ava='".$cuentaed."',fec_ava='".$fecha."', nom_edi_ava='".$nom_edificio."', esta_visi_eva='".$estado."', 
		dir_ava='".$direccion."', com_ava='".$com."',barrio_ava='".$barrio."',estra_ava='".$estrato."',num_b_t_ava='".$num_torres."',tipo_lug_ava='".$tipo_lugar."',hora_ava='".
		$hora."', min_ava='".$minuto."', construc_ava='".$contructora."',cia_admin_ava='".$cia_admin."', nom_admin_ava='".$administrador."',
		 tel_por_ava='".$tel_proteria."', tel_admon_ava='".$tel_admin."', planta_ava='".$planta_elec."', obs_ava='".$observaciones."', cod_emp_ava='".$tercero."'" ;
	$error=editar("avanzada",$compos,'cod_ava',$codigo); 
	if ($error==1){
		header("Location: con_avanzada.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
if (document.getElementById('cuentaed').value == "" || document.getElementById('fecha').value == "" )
	return false;
else
	return true;
}
</script>

</head>
<body <?=$sis?>>
<form  name="forma" id="forma" action="man_avanzada.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td colspan="2" bgcolor="#E9E9E9"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
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
        <td width="21" class="ctablaform"><a href="con_avanzada.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_avanzada.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>
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
    <td height="4" colspan="2" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td width="167" class="textotabla1 Estilo1">ACOMETIDA: </td>
    <td width="462" class="textotabla1 Estilo1"> <a href="#" class="pestana" >Informacion Edificio</a> - <a href="#" class="pestana" >Informacion Acometida </a></td>
  </tr>
  <tr>
    <td colspan="2"><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" bgcolor="#E9E9E9">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="121" class="textotabla1">Cuenta ED.:</td>
        <td width="162"><input name="cuentaed" id="cuentaed" type="text" class="textfield2"  value="<?=$dbdatos->ced_ava?>" />
          <span class="textorojo">*</span></td>
        <td width="10" class="textorojo">&nbsp;</td>
        <td width="119" class="textotabla1">Fecha:</td>
        <td width="185"><input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_ava?>" />
            <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/><span class="textorojo">*</span></td>
        <td width="13" class="textorojo">&nbsp;</td>
        <td width="19" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Nombre Edificio :</td>
        <td><input name="nom_edificio" id="nom_edificio" type="text" class="textfield2"  value="<?=$dbdatos->nom_edi_ava?>" /></td>
         <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Estado Visita :</td>
        <td><select name="estado"  class='SELECT'>
		 <? if($dbdatos->esta_visi_eva=="Nueva") { ?> <option value="Nueva" selected="selected">Nueva</option> 
		 <? } else {?> <option value="Nueva">Nueva</option>  <? }?>
		<? if($dbdatos->esta_visi_eva=="Replanteada") { ?><option value="Replanteada" selected="selected">Replanteada</option>
		 <? } else  { ?> <option value="Replanteada">Replanteada</option> <? }?>
        </select>        </td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" class="textotabla1">Direccion :</td>
        <td><input name="direccion" id="direccion" type="text" class="textfield2"  value="<?=$dbdatos-> dir_ava?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">COM:</td>
        <td><input name="com" id="com" type="text" class="textfield2"  value="<?=$dbdatos->com_ava?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Barrio:</td>
        <td><input name="barrio" id="barrio" type="text" class="textfield2"  value="<?=$dbdatos->barrio_ava?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Estrato:</td>
        <td><select name="estrato"  class='SELECT'>
		<? if($dbdatos->estra_ava>1 && $dbdatos->estra_ava<7) { ?>
			<option value="<?=$dbdatos->estra_ava?>" selected="selected"><?=$dbdatos->estra_ava?></option>
		<? } ?>
          <option value="6">6</option>
          <option value="5">5</option>
          <option value="4">4</option>
          <option value="3">3</option>
          <option value="2">2</option>
          <option value="1">1</option>
          </select></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">N&deg; Bloq/Torres: </td>
        <td><input name="num_torres" id="num_torres" type="text" class="textfield2"  value="<?=$dbdatos->num_b_t_ava?>" /></td>
        <td>&nbsp;</td>
        <td colspan="2" class="textotabla1">
		   Aptos <? if ($dbdatos->tipo_lug_ava=="Aptos") {?> <input name="tipo_lugar" type="radio" value="Aptos"  checked="checked"/> <? } else {?><input name="tipo_lugar" type="radio" value="Aptos"/> <? }?>
		   Casas <? if ($dbdatos->tipo_lug_ava=="Casas") {?> <input name="tipo_lugar" type="radio" value="Casas"  checked="checked"/> <? } else {?><input name="tipo_lugar" type="radio" value="Casas"/> <? }?>          
		   Oficina <? if ($dbdatos->tipo_lug_ava=="Oficina") {?> <input name="tipo_lugar" type="radio" value="Oficina"  checked="checked"/> <? } else {?><input name="tipo_lugar" type="radio" value="Oficina"/> <? }?>          
		   Local <? if ($dbdatos->tipo_lug_ava=="Local") {?> <input name="tipo_lugar" type="radio" value="Local"  checked="checked"/> <? } else {?><input name="tipo_lugar" type="radio" value="Local"/> <? }?>                    
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="textotabla1">Horario de Trabajo &nbsp; &nbsp;Hora:
          <input name="hora" type="text" class="textfield0010" id="hora" size="3" maxlength="2" onkeypress="  return validaInt()"  value="<?=$dbdatos->hora_ava?>"/>
          Minuto: 
          <input name="minuto" type="text" class="textfield0010" id="minuto" size="3" maxlength="2" onkeypress="  return validaInt()" value="<?=$dbdatos->min_ava?>"/>       </td>
        <td>&nbsp;</td>
        <td class="textotabla1">Constructora:</td>
        <td><input name="contructora" id="contructora" type="text" class="textfield2"  value="<?=$dbdatos->construc_ava?>" /></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Cia Administradora: </td>
        <td><input name="cia_admin" id="cia_admin" type="text" class="textfield2"  value="<?=$dbdatos->cia_admin_ava?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Administrador:</td>
        <td><input name="administrador" id="administrador" type="text" class="textfield2"  value="<?=$dbdatos->nom_admin_ava?>" /></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Tel Porteria: </td>
        <td><input name="tel_proteria" id="tel_proteria" type="text" class="textfield2"  value="<?=$dbdatos->tel_por_ava?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Tel Administracion: </td>
        <td><input name="tel_admin" id="tel_admin" type="text" class="textfield2"  value="<?=$dbdatos->tel_admon_ava?>" /></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Planta Elec. </td>
        <td><input name="planta_elec" id="planta_elec" type="text" class="textfield2"  value="<?=$dbdatos->planta_ava?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Observaciones:</td>
        <td rowspan="3"><textarea name="observaciones" cols="28" rows="3" class="textfield02"><?=$dbdatos->obs_ava?>
        </textarea></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="textotabla1">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Responsable:</td>
        <td><? combo("tercero","tercero","cod_ter","nom_ter",$dbdatos->cod_emp_ava); ?></td>
        <td>&nbsp;</td>
        <td class="textotabla1">&nbsp;</td>
        <td >&nbsp;</td>
        <td ><input type="hidden" name="guardar" id="guardar" /></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="2"><div align="center"><img src="imagenes/spacer.gif" alt="." width="624" height="4" /></div></td>
  </tr>
  <tr>
    <td colspan="2"><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
</table>
</form> 

</body>
<script type="text/javascript">
			Calendar.setup(
				{
				inputField  : "fecha",      
				ifFormat    : "%Y-%m-%d",    
				button      : "calendario" ,  
				align       :"T3",
				singleClick :true
				}
			);
</script>
</html>
