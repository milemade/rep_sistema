<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?

if ($codigo!=0) {
	$sql ="select  * FROM m_venta INNER JOIN vendedor ON vendedor.cod_ven=m_venta.cod_ven_mven left JOIN ruta ON ruta.cod_rut=m_venta.cod_rut_mven  WHERE cod_mven=$codigo";
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	
	$compos="(cod_ven_mven, fec_mven, cod_rut_mven, obs_mven, dec_cre_mven, obs_cre_mven, dec_cob_mven, obs_cob_mven, dec_che_mven, obs_che_mven, dec_gas_mven, obs_gas_mven, dec_efe_mven, obs_efe_mven )";
	$valores="('".$vendedor."','".$fecha_venta."','".$ruta."','".$observaciones."','".$total_credito_dec."','".$obs_cre."','".$total_cobro_dec."','".$obs_cob."','".$total_cheque_dec."','".$obs_che."','".$total_gasto_dec."','".$obs_gas."','".$total_efectivo_dec."','".$obs_efe."')" ;
	$ins_id=insertar_maestro("m_venta",$compos,$valores); 	

	if ($ins_id > 0) 
	{
		//insercion del credito
		$compos="( cod_mven_dvcr, cod_cli_dvcr, val_cred_dvcr, fac_cred_dvcr) ";
		for ($ii=1 ;  $ii <= $val_inicial_cre + 1 ; $ii++) 
		{
			if($_POST["num_factura_cre_".$ii]!=NULL) 
			{
				$valores="('".$ins_id."','".$_POST["cod_cli_cre_".$ii]."','".$_POST["val_factura_cre_".$ii]."','".$_POST["num_factura_cre_".$ii]."')";
				$error=insertar("d_credito_venta",$compos,$valores); 
			}	
		}
		//insercion del credito
		
		//insercion del cobro
		$compos="( cod_mven_dvco, cod_cli_dvco , val_cob_dvco, fac_cob_dvco) ";
		for ($ii=1 ;  $ii <= $val_inicial_cre + 1 ; $ii++) 
		{
			if($_POST["num_factura_cob_".$ii]!=NULL) 
			{
				$valores="('".$ins_id."','".$_POST["cod_cli_cob_".$ii]."','".$_POST["val_factura_cob_".$ii]."','".$_POST["num_factura_cob_".$ii]."')";
				$error=insertar("d_cobro_venta",$compos,$valores); 
			}	
		}
		//insercion del cobro
		
		//insercion de cehque
		$compos="(cod_mven_dvch,num_cheq_dvch,ban_cheq_dvch,val_cheq_dvch)";
		for ($ii=1 ;  $ii <= $val_inicial_che + 1 ; $ii++) 
		{
			if($_POST["num_che_".$ii]!=NULL) 
			{
				$valores="('".$ins_id."','".$_POST["num_che_".$ii]."','".$_POST["nombre_banco_".$ii]."','".$_POST["valor_che_".$ii]."')";
				$error=insertar("d_cheque_venta",$compos,$valores); 
			}	
		}
		//insercion del ceche
	
		//insercion de gasto
		$compos="(cod_mven_dvga,cod_doc_dvga,val_gas_dvga)";
		for ($ii=1 ;  $ii <= $val_inicial_gas + 1 ; $ii++) 
		{
			if($_POST["codigo_gasto_".$ii]!=NULL) 
			{
				$valores="('".$ins_id."','".$_POST["codigo_gasto_".$ii]."','".$_POST["valor_gasto_".$ii]."')";
				$error=insertar("d_gastos_venta",$compos,$valores); 
			}	
		}
		//insercion de gasto
		
		//insercion de efectivo
		$vec_codigos= explode("|", $val_final_efectivo);
		$compos="(cod_mven_dvef,cod_den_dvef,nom_den_dvef,cant_dvef,val_dvef)";
		for ($ii=0 ;  $ii <= count($vec_codigos) - 1 ; $ii++) 
		{
			if($_POST["cantidad_efectivo_".$vec_codigos[$ii]]!=NULL) 
			{
				$valores="('".$ins_id."','".$_POST["cod_denominacion_".$vec_codigos[$ii]]."','".$_POST["denominacion_".$vec_codigos[$ii]]."','".$_POST["cantidad_efectivo_".$vec_codigos[$ii]]."','".$_POST["valor_efectivo_".$vec_codigos[$ii]]."')";
				//echo "<br>";
				$error=insertar("d_efectivo_venta",$compos,$valores); 
			}	
		}
		//insercion de efectivo
	
		header("Location: con_venta.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
else
	echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 	
}



if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 
	
	$compos="cod_ven_mven='".$vendedor."', fec_mven='".$fecha_venta."', cod_rut_mven='".$ruta."', obs_mven='".$observaciones."'   , dec_cre_mven='".$total_credito_dec."', obs_cre_mven='".$obs_cre."', dec_cob_mven='".$total_cobro_dec."', obs_cob_mven='".$obs_cob."', dec_che_mven='".$total_cheque_dec."', obs_che_mven='".$obs_che."', dec_gas_mven='".$total_gasto_dec."'    , obs_gas_mven='".$obs_gas."', dec_efe_mven='".$total_efectivo_dec."', obs_efe_mven='".$obs_efe."'";
	$error=editar("m_venta",$compos,'cod_mven',$codigo); 
	
	//insercion del credito
		$sql="DELETE from  d_credito_venta  where cod_mven_dvcr=$codigo ";
		$dbser= new  Database();	
		$dbser->query($sql);
		
		$compos="( cod_mven_dvcr, cod_cli_dvcr, val_cred_dvcr, fac_cred_dvcr) ";
		for ($ii=1 ;  $ii <= $val_inicial_cre + 1 ; $ii++) 
		{
			if($_POST["num_factura_cre_".$ii]!=NULL) 
			{
				$valores="('".$codigo."','".$_POST["cod_cli_cre_".$ii]."','".$_POST["val_factura_cre_".$ii]."','".$_POST["num_factura_cre_".$ii]."')";
				$error=insertar("d_credito_venta",$compos,$valores); 
			}	
		}
		//insercion del credito

		//insercion del cobro
		$sql="DELETE from  d_cobro_venta  where cod_mven_dvco=$codigo ";
		$dbser= new  Database();	
		$dbser->query($sql);
		
		$compos="( cod_mven_dvco,cod_cli_dvco, val_cob_dvco, fac_cob_dvco) ";
		for ($ii=1 ;  $ii <= $val_inicial_cob + 1 ; $ii++) 
		{
			if($_POST["num_factura_cob_".$ii]!=NULL) 
			{
				$valores="('".$codigo."','".$_POST["cod_cli_cob_".$ii]."','".$_POST["val_factura_cob_".$ii]."','".$_POST["num_factura_cob_".$ii]."')";
				$error=insertar("d_cobro_venta",$compos,$valores); 
			}	
		}
		//insercion del cobro
		
		//insercion de cehque
		$sql="DELETE from  d_cheque_venta  where cod_mven_dvch=$codigo ";
		$dbser= new  Database();	
		$dbser->query($sql);
		
		$compos="( cod_mven_dvch, num_cheq_dvch , ban_cheq_dvch ,val_cheq_dvch) ";
		for ($ii=1 ;  $ii <= $val_inicial_che + 1 ; $ii++) 
		{
			if($_POST["num_che_".$ii]!=NULL) 
			{
				$valores="('".$codigo."','".$_POST["num_che_".$ii]."','".$_POST["nombre_banco_".$ii]."','".$_POST["valor_che_".$ii]."')";
				$error=insertar("d_cheque_venta",$compos,$valores); 
			}	
		}
		//insercion de cehque
		
		//insercion de gastos
		$sql="DELETE from  d_gastos_venta  where cod_mven_dvga=$codigo ";
		$dbser= new  Database();	
		$dbser->query($sql);
		
		$compos="(cod_mven_dvga,cod_doc_dvga,val_gas_dvga)";
		for ($ii=1 ;  $ii <= $val_inicial_gas + 1 ; $ii++) 
		{
			if($_POST["codigo_gasto_".$ii]!=NULL) 
			{
				$valores="('".$codigo."','".$_POST["codigo_gasto_".$ii]."','".$_POST["valor_gasto_".$ii]."')";
				$error=insertar("d_gastos_venta",$compos,$valores); 
			}	
		}
		//insercion de gastos
		
		//insercion de efectivo
		$sql="DELETE from  d_efectivo_venta  where cod_mven_dvef=$codigo ";
		$dbser= new  Database();	
		$dbser->query($sql);
		
		$vec_codigos= explode("|", $val_final_efectivo);
		$compos="(cod_mven_dvef,cod_den_dvef,nom_den_dvef,cant_dvef,val_dvef)";
		for ($ii=0 ;  $ii <= count($vec_codigos) - 1 ; $ii++) 
		{
			if($_POST["cantidad_efectivo_".$vec_codigos[$ii]]!=NULL) 
			{
				$valores="('".$codigo."','".$_POST["cod_denominacion_".$vec_codigos[$ii]]."','".$_POST["denominacion_".$vec_codigos[$ii]]."','".$_POST["cantidad_efectivo_".$vec_codigos[$ii]]."','".$_POST["valor_efectivo_".$vec_codigos[$ii]]."')";
				$error=insertar("d_efectivo_venta",$compos,$valores); 
			}	
		}
		//insercion de efectivo
		

	if ($error==1) {
		header("Location:con_venta.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>"; 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript" src="js/js.js"></script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacfute;tulo</title>
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

if (document.getElementById('fecha_venta').value == ""  || document.getElementById('vendedor').value == 0  )
	return false;
else 
	return true;
}


function solapa(objeto,pes) {
	document.getElementById('solapa1').style.display = "none";
	document.getElementById('solapa2').style.display = "none";
	document.getElementById('solapa3').style.display = "none";
	document.getElementById('solapa4').style.display = "none";
	document.getElementById('solapa5').style.display = "none";
	document.getElementById('solapa6').style.display = "none";
	
	document.getElementById('l_solapa1').className="pestana";
	document.getElementById('l_solapa2').className="pestana";
	document.getElementById('l_solapa3').className="pestana";
	document.getElementById('l_solapa4').className="pestana";
	document.getElementById('l_solapa5').className="pestana";
	document.getElementById('l_solapa6').className="pestana";
	
	document.getElementById(objeto).style.display = "inline";
	document.getElementById(pes).className="ctablaform";

}

function buscar_rutas() {
var combo=document.getElementById("ruta");
combo.options.length=0;
var cant=0;
<?
	$i=0;
	$db = new Database();	
	$sql ='SELECT cod_ven_asi,cod_rut_asi,nom_rut  FROM asignacion  INNER JOIN ruta ON asignacion.cod_rut_asi=ruta.cod_rut';
	$db->query($sql);
	while($db->next_row()){ 
		echo "if(document.getElementById('vendedor').value==$db->cod_ven_asi) {";
		echo "combo.options[cant] = new Option('$db->nom_rut','$db->cod_rut_asi');  ";
		echo  "cant++; } ";
	}
?>

}

function  adicion_credito() 
{

	var valor_factura_cre= document.getElementById("valor_factura_cre").value;
	var cliente_codigo_cre = document.getElementById("cliente_credito_cre").value;
	var cliente_nombre_cre= document.getElementById("cliente_credito_cre").options[document.getElementById("cliente_credito_cre").selectedIndex].text;
	var num_factura_cre= document.getElementById("num_factura_cre").value;
	
	if(valor_factura_cre > 0  && cliente_codigo_cre > 0 && num_factura_cre > 0) 
	{
		Agregar_html_credito(num_factura_cre , cliente_codigo_cre , cliente_nombre_cre , valor_factura_cre);
		document.getElementById("valor_factura_cre").value="";
		document.getElementById("cliente_credito_cre").value=0;
		document.getElementById("num_factura_cre").value="";
	}
	else 
	{
		alert("Ingrese los Datos del Credito")
		document.getElementById("num_factura_cre").focus();
	}
}



function adicion_cobro() 
{
	var valor_factura_cre= document.getElementById("valor_factura_cob").value;
	var cliente_codigo_cre = document.getElementById("cliente_credito_cob").value;
	var cliente_nombre_cre= document.getElementById("cliente_credito_cob").options[document.getElementById("cliente_credito_cob").selectedIndex].text;
	var num_factura_cre= document.getElementById("num_factura_cob").value;
	
	if(valor_factura_cre > 0  && cliente_codigo_cre > 0 && num_factura_cre > 0) 
	{
		Agregar_html_cobro(num_factura_cre , cliente_codigo_cre , cliente_nombre_cre , valor_factura_cre);
		document.getElementById("valor_factura_cob").value="";
		document.getElementById("cliente_credito_cob").value=0;
		document.getElementById("num_factura_cob").value="";
	}
	else 
	{
		alert("Ingrese los Datos del Cobro")
		document.getElementById("num_factura_cob").focus();
	}
}


function adicion_cheque() 
{
	var num_factura_che= document.getElementById("num_factura_che").value;
	var nombre_banco = document.getElementById("nombre_banco").value;
	var valor_che= document.getElementById("valor_che").value;
	
	if(num_factura_che != ""  && valor_che > 0 ) 
	{
		Agregar_html_cheque(num_factura_che , nombre_banco , valor_che );
		document.getElementById("num_factura_che").value="";
		document.getElementById("nombre_banco").value="";
		document.getElementById("valor_che").value="";

	}
	else 
	{
		alert("Ingrese los Datos del Cheque")
		document.getElementById("num_factura_che").focus();
	}
}


function adicion_gasto() 
{
	var codigo_gasto= document.getElementById("codigo_gasto").value;
	var valor_gas = document.getElementById("valor_gas").value;
	var nombre_gas= document.getElementById("codigo_gasto").options[document.getElementById("codigo_gasto").selectedIndex].text;
	
	
	if(valor_gas > 0 && codigo_gasto > 0 ) 
	{
		Agregar_html_gasto(codigo_gasto , nombre_gas , valor_gas );
		document.getElementById("codigo_gasto").value=0;
		document.getElementById("valor_gas").value="";
	}
	else 
	{
		alert("Ingrese los Datos del Gasto")
		document.getElementById("codigo_gasto").focus();
	}
}

function calcula_efectivo(obj, cod, den){
var multi = 0;
var total_efec=0;
document.getElementById("valor_efectivo_"+ cod).value=obj.value * den;
codigos = document.getElementById("val_final_efectivo").value;
document.getElementById("total_efectivo").value=0;
vec_cod=codigos.split('|');

for(i= 0; i <= vec_cod.length; i++ ){
	if(document.getElementById("valor_efectivo_"+vec_cod[i])) {
		if(document.getElementById("cantidad_efectivo_"+vec_cod[i]).value>0) {
		multi = document.getElementById("denominacion_"+vec_cod[i]).value * document.getElementById("cantidad_efectivo_"+vec_cod[i]).value;
		total_efec=total_efec+multi;
		}
	}	
}

document.getElementById("total_efectivo").value=total_efec;
}

function crear_nota(boton,nota){
if(document.getElementById(nota).style.display=="none") {
	document.getElementById(boton).value='Ocultar Nota';
	document.getElementById(nota).style.display = "inline";
}
else {
	document.getElementById(boton).value='Crear Nota';
	document.getElementById(nota).style.display = "none";
}
}

</script>

<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:hover {
	color: #333333;
}
-->
</style></head>

<body <?=$sis?>>
<form  name="forma" id="forma" action="man_venta.php"  method="post">
  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td bgcolor="#E9E9E9"><table width="100%" height="27" border="0" cellpadding="0" cellspacing="0">  
      <tr>
        <td width="5" height="27">&nbsp;</td>
        <td width="20" >
		<img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onclick="cambio_guardar()" style="cursor:pointer"/>
		</td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_venta.php?confirmacion=0&amp;editar=<?=$editar?>&amp;insertar=<?=$insertar?>&amp;eliminar=<?=$eliminar?>">
			<img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform">
			<a href="con_venta.php?confirmacion=0&amp;editar=<?=$editar?>&amp;insertar=<?=$insertar?>&amp;eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>
        <td width="70" class="ctablaform">Consultar</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">
		<label>
          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
          <input type="hidden" name="guardar" id="guardar" />
        </label>
		</td>
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">VENTA DIARIA:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9E9E9">
	<table width="662" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50" class="textotabla1">Fecha:</td>
        <td width="164">
          <input name="fecha_venta" type="text" class="fecha" id="fecha_venta" readonly="1" value="<?=$dbdatos->fec_mven?>"/>
          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" id="calendario" style="cursor:pointer"/>
		</td>
        <td width="8" class="textorojo">*</td>
        <td width="93" class="textotabla1"> Ruta:</td>
        <td width="145">
          <select size="1" id="ruta" name="ruta"  class='SELECT' > 
		  <? if($codigo!="") { ?>
		  	<option value="<?=$dbdatos->cod_rut_mven ?>"><?=$dbdatos->nom_rut?></option>
		  <? } ?>
		  </select>		  
		</td>		 
        <td width="6" class="textorojo">&nbsp;</td>
        <td width="163" class="textorojo">&nbsp;</td>
       </tr>
       <tr>
         <td class="textotabla1"> Vendedor:</td>
         <td>
		 <? combo_evento("vendedor","vendedor","cod_ven"," nom_ven ",$dbdatos->cod_ven_mven,"onchange='buscar_rutas()'", "nom_ven"); ?>          </td>
         <td>&nbsp;</td>
         <td class="textotabla1">Observaicones:</td>
         <td colspan="3">
			<textarea name="observaciones" cols="45" rows="4" class="textfield02" ><?=$dbdatos->obs_mven?></textarea>
		 </td>
       </tr>
	   <tr>
         <td colspan="7" class="textotabla1" >
    </table>
	</td>
  </tr>
   <tr>
    <td valign="bottom">
		<img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
	<td colspan="2">   
		<table width="100%">
		<tr>
	    <td align="center" > <a href="#" class="pestana" onclick="solapa('solapa1','l_solapa1')" id="l_solapa1">CREDITOS </a></td>
	    <td > <a href="#" class="pestana" onclick="solapa('solapa2','l_solapa2')" id="l_solapa2">COBROS </a> </td>
	    <td > <a href="#" class="pestana" onclick="solapa('solapa3','l_solapa3')"id="l_solapa3">CHEQUES </a></td>
	    <td > <a href="#" class="pestana" onclick="solapa('solapa4','l_solapa4')" id="l_solapa4">GASTOS </a></td>
        <td > <a href="#" class="pestana" onclick="solapa('solapa5','l_solapa5')" id="l_solapa5">EFECTIVO </a></td>	
		<td > <a href="#" class="pestana" onclick="solapa('solapa6','l_solapa6')" id="l_solapa6">CONSIGNACION </a></td>	
		<!--<td > <a href="#" class="pestana" onclick="solapa('solapa6','l_solapa6')" id="l_solapa6">DEVOLUCION </a></td>	-->
		</tr>
		</table>
	  </td>
    </tr>
  <tr>
    <td valign="top" bgcolor="#E9E9E9">
		<div id="solapa1" style="display:none">
			<table  width="68%" border="1" align="center">
			
          <tr >
            <td  class="ctablasup" width="30%">Factura</td>
            <td   width="40%" class="ctablasup">Cliente</td>
			<td  class="ctablasup"  width="20%" >Valor</td>
			<td width="8%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr >
            <td  align="center"><input name="num_factura_cre" type="text" class="textfield01" id="num_factura_cre" onchange="validaValue(this);" onkeypress=" return validaFloat(this)" /></td>
			<td align="left"><? combo_evento("cliente_credito_cre","cliente_credito","cod_clic","nom_clic","","", "nom_clic");?></td>
		    <td align="center"><input name="valor_factura_cre" type="text" class="textfield01" id="valor_factura_cre" onchange="validaValue(this);" onkeypress=" return validaFloat(this)" /></td>
			<td align="center"> <input type='button'  class='botones' value='  +  '  onclick="adicion_credito()">	</td>
          </tr>
		      
		  <tr >
		  <td  colspan="5">
			  <table width="100%">
				<tr id="fila_cre_0">
				<td  class="ctablasup" width="29%">Factura</td>
				<td  class="ctablasup" width="39%">Cliente</td>
				<td  class="ctablasup" width="20%">Valor</td>
				<td  class="ctablasup" width="7%">Borrar</td>
				</tr>
				<?
				$total_credito=0;
				if ($codigo!="") { // BUSCAR DATOS
					$sql ="SELECT cod_mven_dvcr, cod_cli_dvcr, val_cred_dvcr, fac_cred_dvcr , nom_clic  FROM  d_credito_venta  INNER JOIN cliente_credito ON cod_cli_dvcr=cliente_credito.cod_clic  WHERE cod_mven_dvcr=$codigo";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_cre_$jj'>";
						//numero de factura
						echo "<td><INPUT type='hidden'  name='num_factura_cre_$jj' value='$dbdatos_1->fac_cred_dvcr'><span  class='textfield01'>$dbdatos_1->fac_cred_dvcr </span> </td>";
						
						//codigo del cliente
						echo "<td><INPUT type='hidden'  name='cod_cli_cre_$jj' value='$dbdatos_1->cod_cli_dvcr'><span  class='textfield01'>$dbdatos_1->nom_clic </span> </td>";
						
						//valor de factura
						echo "<td align='right'><INPUT type='hidden'  name='val_factura_cre_$jj' value='$dbdatos_1->val_cred_dvcr'><span  class='textfield01'>$dbdatos_1->val_cred_dvcr </span> </td>";
						
						
						//total del credito
						$total_credito= intval($total_credito + $dbdatos_1->val_cred_dvcr);
						echo "<td><div align='center'><INPUT type='button' class='botones' value='  -  ' onclick='removerFila_credito(\"fila_cre_$jj\",\"val_inicial_cre\",\"fila_cre_\",\"$jj\",\"$dbdatos_1->val_cred_dvcr\");'>
						</div></td>";
						echo "</tr>";
						$jj++;
						
					}
					$jj_credito=$jj;
				}
				?>
				</table>				</td>
			</tr>
			
		 <tr >
		  <td  colspan="5" >
			  
			  <input type="hidden" name="val_inicial_cre" id="val_inicial_cre" value="<? if($codigo!=0) echo $jj_credito-1; else echo "0"; ?>" />
			  <table width="100%">
			<tr >
				<td >
				<div align="left">
				<span class="ctablasup">Valor Declarado:
                    <input name="total_credito_dec" id="total_credito_dec" type="text" class="textfield01"  value="<? if ($codigo !=0 && $dbdatos->dec_cre_mven!="" ) echo $dbdatos->dec_cre_mven; else echo "0" ?>" />
                </span>
				</div>				
				</td>
				<td  align="right"><span class="ctablasup">Total Credito:
                    <input name="total_credito" id="total_credito" type="text" class="textfield01" readonly="1" value="<? if ($codigo !=0) echo $total_credito; else echo "0" ?>" />
				</span></td>
			</tr>
			<tr>
			<td colspan="2"><div align="center">
			  <input name="boton_nota1" type="button" class="boton" value="Crear Nota"  onclick="crear_nota('boton_nota1','nota1')"/>
			  </div></td>
			</tr>
			  </table>
			  <div id="nota1" style="display:none"> 
			  <table width="100%">			
				<tr >
				
				<td valign="top" >
				<span class="ctablasup">Observacion de Creditos:							
				<textarea name="obs_cre" cols="66" rows="2" class="textfield02"><?=$dbdatos->obs_cre_mven?></textarea>
				</span>				</td> 
				</tr>
				
			  </table>			  
			  </div>
			  </td>
			</tr>
		</table>
		</div>	
		
		<div id="solapa2" style="display:none">
			<table  width="68%" border="1" align="center">
			
          <tr >
            <td  class="ctablasup" width="30%">Factura</td>
            <td   width="40%" class="ctablasup">Cliente</td>
			<td  class="ctablasup"  width="20%" >Valor</td>
			<td width="8%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr >
            <td  align="center">
			<input name="num_factura_cob" type="text" class="textfield01" id="num_factura_cob" onchange="validaValue(this);" onkeypress=" return validaFloat(this)" /></td>
			<td align="left">
				<? combo_evento("cliente_credito_cob","cliente_credito","cod_clic","nom_clic","","", "nom_clic");?>
				</td>
		    <td align="center">
			<input name="valor_factura_cob" type="text" class="textfield01" id="valor_factura_cob" onchange="validaValue(this);" onkeypress=" return validaFloat(this)" /></td>
			<td align="center"> <input type='button'  class='botones' value='  +  '  onclick="adicion_cobro()">	</td>
          </tr>
		      
		  <tr >
		  <td  colspan="5">
			  <table width="100%">
				<tr id="fila_cob_0">
				<td  class="ctablasup" width="29%">Factura</td>
				<td  class="ctablasup" width="39%">Cliente</td>
				<td  class="ctablasup" width="20%">Valor</td>
				<td  class="ctablasup" width="7%">Borrar</td>
				</tr>
				<?
				$total_cobro=0;
				if ($codigo!="") { // BUSCAR DATOS
					$sql ="SELECT cod_mven_dvco, cod_cli_dvco, val_cob_dvco,fac_cob_dvco , nom_clic  FROM  d_cobro_venta  INNER JOIN cliente_credito ON cod_cli_dvco=cliente_credito.cod_clic  WHERE cod_mven_dvco=$codigo";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_cob_$jj'>";
						//numero de factura
						echo "<td><INPUT type='hidden'  name='num_factura_cob_$jj' value='$dbdatos_1->fac_cob_dvco'><span  class='textfield01'>$dbdatos_1->fac_cob_dvco </span> </td>";
						
						//codigo del cliente
						echo "<td><INPUT type='hidden'  name='cod_cli_cob_$jj' value='$dbdatos_1->cod_cli_dvco'><span  class='textfield01'>$dbdatos_1->nom_clic </span> </td>";
						
						//valor de factura
						echo "<td align='right'><INPUT type='hidden'  name='val_factura_cob_$jj' value='$dbdatos_1->val_cob_dvco'><span  class='textfield01'>$dbdatos_1->val_cob_dvco </span> </td>";
						
						
						//total del credito
						$total_cobro= intval($total_cobro + $dbdatos_1->val_cob_dvco);
						echo "<td><div align='center'><INPUT type='button' class='botones' value='  -  ' onclick='removerFila_cobro(\"fila_cob_$jj\",\"val_inicial_cre\",\"fila_cre_\",\"$jj\",\"$dbdatos_1->val_cob_dvco\");'>
						</div></td>";
						echo "</tr>";
						$jj++;
						
					}
					$jj_cobro=$jj;
				}
				?>
				</table>				
				</td>
			</tr>
			
		 <tr >
		  <td  colspan="5" >
		  <input type="hidden" name="val_inicial_cob" id="val_inicial_cob" value="<? if($codigo!=0) echo $jj_cobro-1; else echo "0";?>"/>
			  <table width="100%">
			<tr >
				<td >
				<div align="left">
				<span class="ctablasup">Valor Declarado:
                    <input name="total_cobro_dec" id="total_cobro_dec" type="text" class="textfield01" value="<? if ($codigo !=0 && $dbdatos->dec_cob_mven!="") echo $dbdatos->dec_cob_mven; else echo "0" ?>" />
                </span>
				</div>				
				</td>
				<td >
				<div align="right">
					<span class="ctablasup">Total Cobro:
				  <input name="total_cobro" id="total_cobro" type="text" class="textfield01" readonly="1" value="<? if ($codigo !=0) echo $total_cobro; else echo "0" ?>" />
				  </span> 
				</div>
				</td>
				</tr>
				<tr>
			<td colspan="2"><div align="center">
			  <input name="boton_nota2" type="button" class="boton" value="Crear Nota"  onclick="crear_nota('boton_nota2','nota2')"/>
			  </div></td>
			</tr>
			  </table>
			  <div id="nota2" style="display:none"> 
			  <table width="100%">			
				<tr >
				
				<td valign="top" >
				<span class="ctablasup">Observacion de Cobros:							
				<textarea name="obs_cob" cols="66" rows="2" class="textfield02" onchange='buscar_rutas()'><?=$dbdatos->obs_cob_mven?></textarea>
				</span>				</td> 
				</tr>
				
			  </table>			  
			  </div>
			  			</td>
			</tr>
		</table>
		</div>	
		
		<div id="solapa3" style="display:none">
			<table  width="68%" border="1" align="center">
			
          <tr >
            <td  class="ctablasup" width="30%">Numero de Cheque </td>
            <td   width="40%" class="ctablasup">Banco</td>
			<td  class="ctablasup"  width="20%" >Valor</td>
			<td width="8%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr >
            <td  align="center">
			<input name="num_factura_che" id="num_factura_che" type="text" class="textfield2"   /></td>
			<td align="left"><input name="nombre_banco" id="nombre_banco" type="text" class="textfield2" /></td>
		    <td align="center">
			<input name="valor_che" type="text" class="textfield01" id="valor_che" onchange="validaValue(this);" onkeypress=" return validaFloat(this)" /></td>
			<td align="center"> <input type='button'  class='botones' value='  +  '  onclick="adicion_cheque()">	</td>
          </tr>
		      
		  <tr >
		  <td  colspan="5">
			  <table width="100%">
				<tr id="fila_che_0">
				<td  class="ctablasup" width="29%">Numero de Cheque</td>
				<td  class="ctablasup" width="39%">Banco</td>
				<td  class="ctablasup" width="22%">Valor</td>
				<td  class="ctablasup" width="10%">Borrar</td>
				</tr>
				<?
				$total_chero=0;
				
				if ($codigo!="") { // BUSCAR DATOS
					$sql ="SELECT  num_cheq_dvch , ban_cheq_dvch ,val_cheq_dvch from d_cheque_venta WHERE cod_mven_dvch=$codigo";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_che_$jj'>";
						//numero de cheque
						echo "<td><INPUT type='hidden'  name='num_che_$jj' value='$dbdatos_1->num_cheq_dvch'><span  class='textfield01'>$dbdatos_1->num_cheq_dvch </span> </td>";
						
						//nombre de banco
						echo "<td><INPUT type='hidden'  name='nombre_banco_$jj' value='$dbdatos_1->ban_cheq_dvch'><span  class='textfield01'>$dbdatos_1->ban_cheq_dvch </span> </td>";
						
						//valor de cheque
						echo "<td align='right'><INPUT type='hidden'  name='valor_che_$jj' value='$dbdatos_1->val_cheq_dvch'><span  class='textfield01'>$dbdatos_1->val_cheq_dvch </span> </td>";
						
						
						//total del credito
						$total_chero= intval($total_chero + $dbdatos_1->val_cheq_dvch);
						echo "<td><div align='center'><INPUT type='button' class='botones' value='  -  ' onclick='removerFila_cheque(\"fila_che_$jj\",\"val_inicial_che\",\"fila_cre_\",\"$jj\",\"$dbdatos_1->val_cheq_dvch\");'>
						</div></td>";
						echo "</tr>";
						$jj++;
						
					}
					$jj_chero=$jj;
				}
				?>
				</table>				
				</td>
			</tr>
			
		 <tr >
		  <td  colspan="5" >
		  <input type="hidden" name="val_inicial_che" id="val_inicial_che" value="<? if($codigo!=0) echo $jj_chero-1; else echo "0";?>"/>
			  <table width="100%">
			<tr >
				
				<td >
				<div align="left">
				<span class="ctablasup">Valor Declarado:
                    <input name="total_cheque_dec" id="total_cheque_dec" type="text" class="textfield01"  value="<? if ($codigo !=0  && $dbdatos->dec_che_mven!="") echo $dbdatos->dec_che_mven; else echo "0" ?>" />
                </span>
				</div>				
				</td>
				<td >
				
				<div align="right">
					<span class="ctablasup">Total cheques:
				    <input name="total_chero" id="total_chero" type="text" class="textfield01" readonly="1" value="<? if ($codigo !=0) echo $total_chero; else echo "0" ?>" />
				  </span> 
				</div>
				</td>
				</tr>
				<tr>
					<td colspan="2">
						<div align="center">
						  <input name="boton_nota3" type="button" class="boton" value="Crear Nota"  onclick="crear_nota('boton_nota3','nota3')"/>
			  			</div>
					</td>
				</tr>
			  </table>
			  
			  <div id="nota3" style="display:none"> 
			  <table width="100%">			
				<tr >
				
				<td valign="top" >
				<span class="ctablasup">Observacion de Cheques:							
				<textarea name="obs_che" cols="66" rows="2" class="textfield02" ><?=$dbdatos->obs_che_mven?></textarea>
				</span>				</td> 
				</tr>
				
			  </table>			  
			  </div>
			  
			  
			  </td>
			</tr>
		</table>
		</div>	
		
		<div id="solapa4" style="display:none">
			<table  width="56%" border="1" align="center">
			
          <tr>
            <td  class="ctablasup" width="30%">Tipo de Gasto </td>
			<td  class="ctablasup"  width="20%" >Valor</td>
			<td width="8%" class="ctablasup" align="center">Agregar</td>
          </tr>
		  
          <tr >
            <td  align="center">
			<? combo_evento("codigo_gasto","documento","cod_doc","nom_doc","","", "nom_doc");?>
			</td>
			
		    <td align="center">
			<input name="valor_gas" type="text" class="textfield01" id="valor_gas" onchange="validaValue(this);" onkeypress=" return validaFloat(this)" /></td>
			<td align="center"> <input type='button'  class='botones' value='  +  '  onclick="adicion_gasto()">	</td>
          </tr>
		      
		  <tr >
		  <td  colspan="5">
			  <table width="100%">
				<tr id="fila_gas_0">
				<td  class="ctablasup" width="52%">Tipo de Gasto</td>
				<td  class="ctablasup" width="33%">Valor</td>
				<td  class="ctablasup" width="15%">Borrar</td>
				</tr>
				<?
				$total_gasto=0;
				if ($codigo!="") { // BUSCAR DATOS
					$sql ="SELECT cod_doc_dvga,val_gas_dvga ,nom_doc FROM d_gastos_venta INNER JOIN documento ON cod_doc_dvga=cod_doc WHERE cod_mven_dvga = $codigo";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_gas_$jj'>";
						//tipo documento
						echo "<td><INPUT type='hidden'  name='codigo_gasto_$jj' value='$dbdatos_1->cod_doc_dvga'><span  class='textfield01'>$dbdatos_1->nom_doc </span> </td>";
						
						//valor de gasto
						echo "<td align='right'><INPUT type='hidden'  name='valor_gasto_$jj' value='$dbdatos_1->val_gas_dvga'><span  class='textfield01'>$dbdatos_1->val_gas_dvga</span></td>";
						
						
						//total del credito
						$total_gasto= intval($total_gasto + $dbdatos_1->val_gas_dvga);
						echo "<td><div align='center'><INPUT type='button' class='botones' value='  -  ' onclick='removerFila_gasto(\"fila_gas_$jj\",\"val_inicial_gas\",\"fila_gas_\",\"$jj\",\"$dbdatos_1->val_gas_dvga\");'>
						</div></td>";
						echo "</tr>";
						$jj++;
						
					}
					$jj_gasro=$jj;
				}
				?>
				</table>				
			  </td>
			</tr>
			
		 <tr >
		  <td  colspan="5" >
		  <input type="hidden" name="val_inicial_gas" id="val_inicial_gas" value="<? if($codigo!=0) echo $jj_gasro-1; else echo "0";?>"/>
			  <table width="100%">
			<tr >
				
				<td >
				<div align="left">
				<span class="ctablasup">Valor Declarado:
                    <input name="total_gasto_dec" id="total_gasto_dec" type="text" class="textfield01"  value="<? if ($codigo !=0 && $dbdatos->dec_gas_mven!="") echo $dbdatos->dec_gas_mven; else echo "0" ?>" />
                </span>
				</div>				
				</td>
				<td >
				<div align="right">
					<span class="ctablasup">Total Gastos:
				    <input name="total_gasto" id="total_gasro" type="text" class="textfield01" readonly="1" value="<? if ($codigo !=0) echo $total_gasto; else echo "0" ?>" />
				  </span> 
				</div>
				</td>
				</tr>
				<tr>
			<td colspan="2"><div align="center">
			  <input name="boton_nota4" type="button" class="boton" value="Crear Nota"  onclick="crear_nota('boton_nota4','nota4')"/>
			  </div></td>
			</tr>
			  </table>	
			  		
			    <div id="nota4" style="display:none">
				<table width="100%">			
				<tr >
				
				<td valign="top" >
				<span class="ctablasup">Observacion de Gastos:							
				<textarea name="obs_gas" cols="43" rows="2" class="textfield02" ><?=$dbdatos->obs_gas_mven?></textarea>
				</span>				</td> 
				</tr>
				
			  </table>
			  </div>
			  
			  </td>
			</tr>
		</table>
		</div>	
		
		<div id="solapa5" style="display:none">
			<table  width="55%" border="1" align="center">
			
          <tr >
            <td  class="ctablasup" width="28%">Denominacion</td>
            <td   width="30%" class="ctablasup">Cantidad</td>
			<td  class="ctablasup"  width="42%" >Valor</td>
			</tr>
		<?
		//busca las denominaciones\		
		$sql ="select cod_den,nom_den from denominacion order by nom_den,tipo_mon_den asc";//=		
		$dbdatos_1= new  Database();
		$dbdatos_sub= new  Database();
		$dbdatos_1->query($sql);
		$total_efe=0;
		$jj=1;
		while($dbdatos_1->next_row()){ 
		$codigos_den.=$dbdatos_1->cod_den."|";
		?> 
          	<tr >
				<td  class="ctablasup">
				<?
				$sql ="SELECT * FROM d_efectivo_venta WHERE cod_mven_dvef=$codigo AND cod_den_dvef=$dbdatos_1->cod_den";
				$dbdatos_sub->query($sql);
				if($dbdatos_sub->next_row()){ 
					$canti_efe=$dbdatos_sub->cant_dvef;
					$valor_efe=$dbdatos_sub->val_dvef;
					$total_efe=$total_efe + $valor_efe;
				}
				?>
				<input type="hidden" name="cod_denominacion_<?=$dbdatos_1->cod_den?>"  value="<?=$dbdatos_1->cod_den?>" />
				<input type="hidden" name="denominacion_<?=$dbdatos_1->cod_den?>"  value="<?=$dbdatos_1->nom_den?>" />
				<div align="right"> <?=number_format($dbdatos_1->nom_den,0,",",".")?></div></td>
				<td align="left">
					<div align="right">
				  	<input name="cantidad_efectivo_<?=$dbdatos_1->cod_den?>" type="text" class="textfield01" id="cantidad_efectivo_<?=$dbdatos_1->cod_den?>" onchange="calcula_efectivo(this,<?=$dbdatos_1->cod_den?>,<?=$dbdatos_1->nom_den?>);" onkeypress="return validaInt(this)" value="<? if($canti_efe>0) echo $canti_efe; else echo "0" ?>"/>
				  	</div>
				</td>
				<td align="center">
					<div align="right">
				  	<input name="valor_efectivo_<?=$dbdatos_1->cod_den?>" type="text" class="textfield01" id="valor_efectivo_<?=$dbdatos_1->cod_den?>" onkeypress=" return validaInt(this)" readonly="-1"  value="<? if($valor_efe>0) echo $valor_efe; else echo "0" ?>"/>
				  </div>
			  </td>
			</tr>
		<?
		}
		?>	
		 <tr >
		  <td  colspan="4" ><table width="100%">
			<tr >
				<td width="44%" >
				<div align="left">
				<span class="ctablasup"> Declarado:
                    <input name="total_efectivo_dec" id="total_efectivo_dec" type="text" class="textfield01"  value="<? if ($codigo !=0 && $dbdatos->dec_efe_mven!="") echo $dbdatos->dec_efe_mven; else echo "0" ?>" />
                </span>				</div>				</td>
				<td width="56%" >
				<div align="right"><span class="ctablasup">Total efectivo:
				    <input name="total_efectivo" id="total_efectivo" type="text" class="textfield01" readonly="1" value="<?=$total_efe?>" />
				  </span>				</div>				</td>
				</tr>
					<tr>
			<td colspan="2"><div align="center">
			  <input name="boton_nota5" type="button" class="boton" value="Crear Nota"  onclick="crear_nota('boton_nota5','nota5')"/>
			  <input type="hidden" name="val_final_efectivo" id="val_final_efectivo" value="<?=$codigos_den?>"/>
			</div></td>
			</tr>
			  </table>
			   <div id="nota5" style="display:none">
			   <table width="100%">			
				<tr >
				
				<td valign="top" >
				<span class="ctablasup">Observacion Efectivo:							
				<textarea name="obs_efe" cols="46" rows="2" class="textfield02"><?=$dbdatos->obs_efe_mven?></textarea>
				</span>				</td> 
				</tr>
				
			  </table></div>
			  </td>
			  
			</tr>
		</table>
		
		</div>
		
		
		<div id="solapa6" style="display:inline">
			<table  width="61%" border="1" align="center">
			
          <tr>
            <td  class="ctablasup" width="30%">Num Consignacion </td>
			<td  class="ctablasup"  width="20%" >Valor</td>
			<td width="8%" class="ctablasup" align="center">Agregar</td>
          </tr>
		  
          <tr >
            <td  align="center"><input name="valor_gas2" type="text" class="textfield01" id="valor_gas2" onchange="validaValue(this);" onkeypress=" return validaFloat(this)" /></td>
			
		    <td align="center">
			<input name="valor_gas" type="text" class="textfield01" id="valor_gas" onchange="validaValue(this);" onkeypress=" return validaFloat(this)" /></td>
			<td align="center"> <input type='button'  class='botones' value='  +  '  onclick="adicion_gasto()">	</td>
          </tr>
		      
		  <tr >
		  <td  colspan="5">
			  <table width="100%">
				<tr id="fila_gas_0">
				<td  class="ctablasup" width="52%">Num Consignacion </td>
				<td  class="ctablasup" width="33%">Valor</td>
				<td  class="ctablasup" width="15%">Borrar</td>
				</tr>
				<?
				$total_gasto=0;
				if ($codigo!="") { // BUSCAR DATOS
					$sql ="SELECT cod_doc_dvga,val_gas_dvga ,nom_doc FROM d_gastos_venta INNER JOIN documento ON cod_doc_dvga=cod_doc WHERE cod_mven_dvga = $codigo";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_gas_$jj'>";
						//tipo documento
						echo "<td><INPUT type='hidden'  name='codigo_gasto_$jj' value='$dbdatos_1->cod_doc_dvga'><span  class='textfield01'>$dbdatos_1->nom_doc </span> </td>";
						
						//valor de gasto
						echo "<td align='right'><INPUT type='hidden'  name='valor_gasto_$jj' value='$dbdatos_1->val_gas_dvga'><span  class='textfield01'>$dbdatos_1->val_gas_dvga</span></td>";
						
						
						//total del credito
						$total_gasto= intval($total_gasto + $dbdatos_1->val_gas_dvga);
						echo "<td><div align='center'><INPUT type='button' class='botones' value='  -  ' onclick='removerFila_gasto(\"fila_gas_$jj\",\"val_inicial_gas\",\"fila_gas_\",\"$jj\",\"$dbdatos_1->val_gas_dvga\");'>
						</div></td>";
						echo "</tr>";
						$jj++;
						
					}
					$jj_gasro=$jj;
				}
				?>
				</table>				
			  </td>
			</tr>
			
		 <tr >
		  <td  colspan="5" >
		  <input type="hidden" name="val_inicial_gas" id="val_inicial_gas" value="<? if($codigo!=0) echo $jj_gasro-1; else echo "0";?>"/>
			  <table width="100%">
			<tr >
				
				<td >
				<div align="left">
				<span class="ctablasup">Valor Declarado:
                    <input name="total_gasto_dec" id="total_gasto_dec" type="text" class="textfield01"  value="<? if ($codigo !=0 && $dbdatos->dec_gas_mven!="") echo $dbdatos->dec_gas_mven; else echo "0" ?>" />
                </span>
				</div>				
				</td>
				<td >
				<div align="right">
					<span class="ctablasup">Total Consignacion:
				    <input name="total_gasto" id="total_gasro" type="text" class="textfield01" readonly="1" value="<? if ($codigo !=0) echo $total_gasto; else echo "0" ?>" />
				  </span> 
				</div>
				</td>
				</tr>
				<tr>
			<td colspan="2"><div align="center">
			  <input name="boton_nota4" type="button" class="boton" value="Crear Nota"  onclick="crear_nota('boton_nota6','nota6')"/>
			  </div></td>
			</tr>
			  </table>	
			  		
			    <div id="nota6" style="display:none">
				<table width="100%">			
				<tr >
				
				<td valign="top" >
				<span class="ctablasup">Observacion de Gastos:							
				<textarea name="obs_consig" cols="43" rows="2" class="textfield02" ><?=$dbdatos->obs_gas_mven?></textarea>
				</span>				</td> 
				</tr>
				
			  </table>
			  </div>
			  
			  </td>
			</tr>
		</table>
		</div>	
	</td>
  </tr>


  <tr>
    <td>
		<img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
</table>
</form> 
</body>

<script type="text/javascript">
			
			Calendar.setup(
				{
					inputField  : "fecha_venta",      
					ifFormat    : "%Y-%m-%d",    
					button      : "calendario" ,  
					align       :"T3",
					singleClick :true
				}
			);
			
</script>
</html>