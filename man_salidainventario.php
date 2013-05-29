<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?php
  include "conf/tiemposesion.php";
  //print_r($_POST); //exit;
 if(!isset($codigo))
   $codigo = 0;
 $n = $_POST['n'];?>
<?php //Limpia la tabla kardex los que no tienen cantidad y los que no tiene serial
  $dbclean = new Database();
  $sqlclean = "DELETE FROM kardex WHERE cant_ref_kar<=0 OR serial=0;";
  $dbclean->query($sqlclean);
  $dbclean->close();
?>
<?php
    if ($codigo>0) {
	$sql ="select * , bodega1.nom_bod as nom_cliente 
	         from ".$global[7]." 
	   left join usuario on usuario.cod_usu=".$global[7].".cod_usu 
	   left join bodega1 on bodega1.cod_bod=".$global[7].".cod_cli 
	   left join rsocial on rsocial.cod_rso =".$global[7].".cod_razon_fac 
	   where cod_fac=".$codigo.";";
	$dbdatos_edi= new  Database();
	$dbdatos_edi->query($sql);
	$dbdatos_edi->next_row();
    //echo $sql;
}
?>
<?php //Funciones
function sumartotal($id,$tabla,$tabla1)
{
  $d = new Database();
  $sql = "SELECT total_pro FROM ".$tabla." WHERE cod_mfac=".$id.";";
  $d->query($sql);
  $total = 0;
  while($d->next_row())
  {
       $total = $total + $d->total_pro;
  }
  $sqlup = "UPDATE ".$tabla1." SET tot_fac=".$total." WHERE cod_fac=".$id.";";
  $d->query($sqlup);
  $d->close();
  return $total;
} ?>
<?php 
function validarserie($serie,$id,$tabla,$bodega)
{ //No permite repetir el serial en la misma orden, solo un registro por serial
  $b = new Database();
  $sql = "SELECT serial FROM ".$tabla." WHERE cod_mfac=".$id." AND serial='".$serie."';";
  $b->query($sql);
  $numfilas = $b->num_rows();
  $b->close();
  return $numfilas; 
} ?>
<?php
   if($n==1)
   { $ahora = date("Y-n-j H:i:s");
     $_SESSION["ultimoAcceso"] = $ahora;
         $dbu = new Database();
	 $sqlu = "UPDATE ".$global[7]." SET cod_cli=".$_POST['cliente'].",fecha='".$_POST['fecha']."',obs='".$_POST['observaciones']."',cod_razon_fac=".$_POST['empresa']." 
	          WHERE cod_fac=".$codigo.";";
	 $dbu->query($sqlu);
	 $dbu->close();?>
<form name="frmm" method="post" action="con_salida_inventarios.php">
<input type="hidden" name="confirmacion" value="1">
<input type="hidden" name="editar" value="<?=$editar?>">
<input type="hidden" name="insertar" value="<?=$insertar?>">
<input type="hidden" name="eliminar" value="<?=$eliminar?>">	
</form>
<script>document.frmm.submit();</script>	 
<?php
 exit;  }
?>
<?
   if($n==4)
   { $ahora = date("Y-n-j H:i:s");
     $_SESSION["ultimoAcceso"] = $ahora;
     if($codigo == 0)
	{  /*Si no hay codigo, crea un registro en maestro*/
		$compos="(cod_usu, cod_cli,fecha,num_fac,cod_razon_fac,obs)";
		$valores="('".$global[2]."','".$cliente."','".$fecha."','".$numeroremision."','".$empresa."','".$observaciones."')" ;
		$codig = insertar_maestro($global[7],$compos,$valores); //exit;
		if($codig>0)
		{ /*Ingresa en la tabla detalle ya hay codigo*/
			$compos="(cod_mfac,cod_tpro,cod_cat,cod_peso, cod_pro, cant_pro, val_uni, total_pro,serial,disponible,cod_bod) ";
			$arrcolor = explode("|",$_POST["codigo_fry"]);
			$arrpeso = explode("|",$_POST["peso"]);
			$color = $arrcolor[0];
			$bodega = $arrpeso[1];
			$serial = $arrpeso[2];
			$disponible = $_POST['serial'] - $_POST['cantidad'];
			if($_POST["costo"]>0)
				 $totalcosto = $_POST["cantidad"] * $_POST["costo"];
			$valores="('".$codig."','".$_POST["tipo_producto"]."','".$_POST["marca"]."','".$color."','".$_POST["combo_referncia"]."','".$_POST["cantidad"]."','".$_POST["costo"]."','".$totalcosto."','".$serial."','".$disponible."',".$bodega.")";
			$repiteserie = validarserie($serial,$codig,$global[8],$bodega); 
			if($repiteserie>0)
			  echo "<script>alert('NUMERO DE SERIE O PIEZA UTILIZADO!')</script>";
			if($repiteserie==0 && $_POST["cantidad"]!="" && $_POST["tipo_producto"]>0 && $color>0 && $_POST["costo"]!="")
			{
				 $error = insertar($global[8],$compos,$valores); //exit;
				 if($global[1]==1) /*Si es Superadministrador AFECTA INVENTARIOS*/
				 {       
				   kardex("resta",$_POST["combo_referncia"],$bodega,$_POST["cantidad"],$_POST["costo"],$color,$serial);
				 }
			}
		}
	} //Fin no existe codigo
	if($codigo>0)
	{    /*Modifica la tabla maestro si hay algun cambio*/
		 $compos ="cod_usu='".$global[2]."',cod_cli='".$cliente."',fecha='".$fecha."',";
		 $compos .= " num_fac='".$numeroremision."',cod_razon_fac='".$empresa."',obs='".$observaciones."'";
		 $where_campo = "cod_fac";
		 $where_valor = $codigo;
		 editar($global[7],$compos,$where_campo, $where_valor);
		 $compos="(cod_mfac,cod_tpro,cod_cat,cod_peso, cod_pro, cant_pro, val_uni, total_pro,serial,disponible,cod_bod) ";
		 $arrcolor = explode("|",$_POST["codigo_fry"]);
		 $arrpeso = explode("|",$_POST["peso"]);
		 $color = $arrcolor[0];
		 $bodega = $arrpeso[1];
		 $serial = $arrpeso[2];
		 $disponible = $_POST['serial'] - $_POST['cantidad'];
		 if($_POST["costo"]>0)
			 $totalcosto = $_POST["cantidad"] * $_POST["costo"];
		 $valores="('".$codigo."','".$_POST["tipo_producto"]."','".$_POST["marca"]."','".$color."','".$_POST["combo_referncia"]."','".abs($_POST["cantidad"])."','".$_POST["costo"]."','".$totalcosto."','".$serial."','".$disponible."',".$bodega.")";
		 $repiteserie = validarserie($serial,$codigo,$global[8],$bodega); 
		 if($repiteserie>0)
			echo "<script>alert('NUMERO DE SERIE O PIEZA UTILIZADO!')</script>";
		 if($repiteserie==0 && $_POST["cantidad"]>0 && $codigo>0 && $_POST["tipo_producto"]>0 && $color>0 && $_POST["costo"]!="")
		 {
			$error=insertar($global[8],$compos,$valores); //exit;
			if($global[1]==1) /*Si es Superadministrador AFECTA INVENTARIOS*/
			{ 
			   kardex("resta",$_POST["combo_referncia"],$bodega,$_POST["cantidad"],$_POST["costo"],$color,$serial);			
			}
		 }
	} ?>
<form name="frm" method="post">
<?php
          if(isset($codig) && $codig>0)
	      $codigo = $codig;
?>
<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>">
</form>
<script>document.frm.submit()</script>
<?php   exit;}//Fin n==4

?>
<?php if($n==5){
     $ahora = date("Y-n-j H:i:s");
     $_SESSION["ultimoAcceso"] = $ahora;
/*Borrar productos de la salida de remision*/
  $dbelim = new Database();
   if($codigo>0)
   {
      $sqlelim = "DELETE FROM ".$global[8]." WHERE cod_dfac=".$_POST['ideli'].";";
      $dbelim->query($sqlelim);
      if($global[1]==1) //Si es Superadministrador AFECTA INVENTARIOS
      {//Repone lo que elimina en Inventario
	  kardex("suma",$_POST['prod'],$_POST['bodega'],$_POST["cantidad"],$_POST["costo"],$_POST['color'],$_POST["serial"]);
      }
   }
   $dbelim->close();
?>
     <form name="frm" method="post">
	 <input type="hidden" name="codigo" value="<?=$codigo?>">
	 </form>
	 <script>document.frm.submit()</script> 
<?php exit;} ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Salida Remision</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {font-size: 12px}
.total {
	font-family: Arial, Helvetica, sans-serif;
	color: #4F4F4F;
	text-align:right;
	font-size:10px;
	font-weight: bold;
	
}
</style> 

<? inicio() ?>
<script language="javascript">

function datos_completos()
{  
	if (document.getElementById('fecha').value == "" || 
	    document.getElementById('empresa').value == "" ||
		document.getElementById('cliente').value == "")
	{
	    alert("Diligencie  los campos de Fecha, Empresa y Cliente, gacias!");
		return false;
	}
	else
		return true;		

}

function  adicion() 
{ 
     //alert(document.getElementById("serial").value);
	 if(document.getElementById('fecha').value == "")
	 {
	     alert("Debe ingresar la fecha!");
		 document.getElementById('fecha').focus();
		 return false;
	 }
	 if(document.getElementById('empresa').value =="")
	 {
	     alert("Debe seleccionar una Empresa!");
		 document.getElementById('empresa').focus();
		 return false;
		 
	 }
	 if(document.getElementById('cliente').value =="")
	 {
	     alert("Debe seleccionar una Cliente!");
		 document.getElementById('cliente').focus();
		 return false;
		 
	 }
    if(document.getElementById("cantidad").value!='' && 
       document.getElementById("codigo_fry").value !="" && 
       document.getElementById("costo").value !="" && 
       document.getElementById('combo_referncia').value !="" &&
       document.getElementById('serial').value!='') 
	{      
	    //alert(document.getElementById('n').value);
	    document.fo3.submit();		   
	}
	else 
	{
		alert("Complete los Valores!")
		document.getElementById("codigo_fry").focus();
	}
}



function enfocar(obj_ini,obj_fin){
if(window.event.keyCode==13)
{
  window.event.keyCode=0;
  document.getElementById(obj_fin).focus();
  return false;
}
}
function guardarsi()
{
      if(document.getElementById('fecha').value == "")
      {
          alert("Debe ingresar la Fecha!");
		  document.getElementById('fecha').focus();
	      return false;
      }
	  if(document.getElementById('empresa').value == "")
      {
          alert("Debe seleccionar la empresa!");
		  document.getElementById('empresa').focus();
	      return false;
      }
	  if(document.getElementById('cliente').value == "")
      {
          alert("Debe seleccionar el Cliente!");
		  document.getElementById('cliente').focus();
	      return false;
      }
      else
      {
	   //alert(document.getElementById('cliente').value);
	   document.getElementById('n').value = 1;
       document.fo3.submit();
	   return true;
      }
}
</script>
<script language="javascript">
$(document).ready(function() {
    $().ajaxStart(function() {
        $('#loading').show();
        $('#result').hide();
    }).ajaxStop(function() {
        $('#loading').hide();
        $('#result').fadeIn('slow');
    });
    $('#form, #fat, #fo3').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#result').html(data);

            }
        })
        
        return false;
    }); 
})  
</script>
<script language="JavaScript1.2">
var digitos=10 //cantidad de digitos buscados
var puntero=0
var buffer=new Array(digitos) //declaraci�n del array Buffer
var cadena=""

function buscar_op(obj,objfoco){
   var letra = String.fromCharCode(event.keyCode)
   if(puntero >= digitos){
       cadena="";
       puntero=0;
    }
   //si se presiona la tecla ENTER, borro el array de teclas presionadas y salto a otro objeto...
   if (event.keyCode == 13){
       borrar_buffer();
       if(objfoco!=0) objfoco.focus(); //evita foco a otro objeto si objfoco=0
    }
   //sino busco la cadena tipeada dentro del combo...
   else{
       buffer[puntero]=letra;
       //guardo en la posicion puntero la letra tipeada
       cadena=cadena+buffer[puntero]; //armo una cadena con los datos que van ingresando al array
       puntero++;

       //barro todas las opciones que contiene el combo y las comparo la cadena...
       for (var opcombo=0;opcombo < obj.length;opcombo++){
          if(obj[opcombo].text.substr(0,puntero).toLowerCase()==cadena.toLowerCase()){
          obj.selectedIndex=opcombo;
          }
       }
    }
   event.returnValue = false; //invalida la acci�n de pulsado de tecla para evitar busqueda del primer caracter
}

function borrar_buffer(){
   //inicializa la cadena buscada
    cadena="";
    puntero=0;
}
</script>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jscargueinventario.js"></script>
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<link href="informes/styles.css" rel="stylesheet" type="text/css" />
<script>
function ponerfoco()
{
    document.getElementById("marca").focus();
}
</script>
</head>
<body <?=$sis?> onLoad="ponerfoco()">
<div id="total">
<table width="80%" border="0" bgcolor="#E9E9E9" align="center">
<tr>
    <td><table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#E9E9E9"> 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" >
		<img src="imagenes/icoguardar.png" alt="Nuevo Registro" width="16" height="16" border="0" onClick="guardarsi();" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform" valign="bottom">Guardar
		
		</td>
        
        <td width="21" class="ctablaform"><a href="con_salida_inventarios.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>&bandera=1"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="#"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" onClick="buscar_producto()" /></a><a href="con_cargue_inventario.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"></a></td>
        <td width="70" class="ctablaform">Consultar (F9) </td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">
          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" /> </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="bottom"><table width="100%">
	<tr><td><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td></tr>
	<tr><td bgcolor="#ffffff"><span class="textotabla01">SALIDA INVENTARIO</span></td></tr>
	<tr><td><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td></tr></table></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9"><!--ZONA D-->
	
	<form method="post" action="" id="fo3" name="fo3" >
	
	<table width="100%" border="0">
  <tr>
    <td><span class="textorojo">*</span><span class="textotabla1">Fecha</span></td>
    <td><input name="fecha" type="text" id="fecha" readonly="readonly" value="<? echo $dbdatos_edi->fecha; ?>"/>
           <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
    <td><span class="textorojo">*</span><span class="textotabla1">Empresa</span></td>
    <td><?	
		$sql="select distinct punto_venta.cod_rso as valor , nom_rso as nombre from punto_venta  inner join  rsocial  on punto_venta.cod_rso=rsocial.cod_rso where cod_ven=1;";
		combo_sql("empresa","rsocial","valor","nombre",$dbdatos_edi->cod_razon_fac,$sql); ?></td>
  </tr>
  <tr>
    <td style="padding-left:14px"><span class="textotabla1">Remision No</span> </td>
    <td><input name="numeroremision" readonly type="text"  id="numeroremision" value="
	<? if($dbdatos_edi->num_fac>0)
	       echo $dbdatos_edi->num_fac;
	   else
	   {
		   $dbmax = new Database();
		   $sql = "SELECT MAX(num_fac) + 1 as max FROM ".$global[7].";";
		   $dbmax->query($sql);
		   $dbmax->next_row();
		   $max = $dbmax->max;
		   if($max=="")
			  $max = 1;
		   echo $max;   
		   $dbmax->close();
		   }
	   ?>" /></td>
    <td ><span class="textorojo">*</span><span class="textotabla1">Cliente</span></td>
    <td><? 
		
		
		//combo_evento("cliente","bodega1","cod_bod"," nom_bod ",$dbdatos_edi->cod_cli,"", "nom_bod");
		
		$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$global[2]";
		$dbdatos= new  Database();
		$dbdatos->query($sql);
		
		$where_cli="";
		while($dbdatos->next_row())
		{
			$where_cli .= "cod_bod_cli= ".$dbdatos->valor  ;
			$where_cli .= " or ";
		}
		$dbdatos->close();
		$where_cli .= " cod_bod < 0 "; 
		
		$sql="select * from bodega1  order  by nom_bod ";
		
		 combo_sql("cliente","bodega1","cod_bod","nom_bod",$dbdatos_edi->cod_bod,$sql); 
		
		?></td><td height="16"><span class="textotabla1">
  <tr>
    <td style="padding-left:14px"><span class="textotabla1" >Observaciones</span></td>
    <td><textarea cols="45" rows="4" class="textfield02" name="observaciones" id="observaciones"><?=$dbdatos_edi->obs?></textarea></td>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
         
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
<!--FIN ZONA d--></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9"><!--Comienza Carga Productos-->
	<table border="1" width="100%">         
          <tr >
            <td class="ctablasup"><div align="center">Categoria</div></td>
	        <td class="ctablasup"><div align="center">Tipo Producto </div></td>
            <td class="ctablasup"><div align="center">Codigo - Producto</div></td>
	        <td class="ctablasup"><div align="center">Color</div></td>
	        <td class="ctablasup"><div align="center">Serial-Cantidad-Precio-Bodega</div></td>
	        <td class="ctablasup"><div align="center">Disponible</div></td>
            <td width="6%" class="ctablasup"><div align="center">Cantidad</div></td>
			<td width="4%" class="ctablasup"><div align="center">Costo</div></td>
			<td width="7%" align="center" class="ctablasup"><div align="center">Agregar:</div></td>
</tr>
<!--ZONA DEL FRAMEWORK JQUERY PARA CARGA DE COMBOS DINAMICOS-->
<script>
$(document).ready(function(){
 $("#marca").change(function(){ $.post("carga_select2.php",{ id:$(this).val() },function(data){$("#tipo_producto").html(data);})});
});
$(document).ready(function(){
 $("#tipo_producto").change(function(){ $.post("carga_select3.php",{ id:$(this).val() },function(data){$("#combo_referncia").html(data);})});
});
$(document).ready(function(){
 $("#combo_referncia").change(function(){ $.post("carga_select4.php",{ id:$(this).val() },function(data){$("#codigo_fry").html(data);})});
});
$(document).ready(function(){
 $("#codigo_fry").change(function(){ $.post("carga_select5.php",{ id:$(this).val() },function(data){$("#peso").html(data);})});
});
$(document).ready(function(){
 $("#peso").change(function(){ $.post("carga_select6.php",{ id:$(this).val() },function(data){$("#serial").html(data);})});
});
$(document).ready(function(){
 $("#peso").change(function(){ $.post("carga_select7.php",{ id:$(this).val() },function(data){$("#costo").html(data);})});
});

$(document).ready(function(){
 $("#serial").change(function(){ $.post("carga_select7.php",{ id:$(this).val() },function(data){$("#totalexistencias").html(data);})});
})
</script>
<script language="JavaScript1.2">
var digitos=10 //cantidad de digitos buscados
var puntero=0
var buffer=new Array(digitos) //declaraci�n del array Buffer
var cadena=""

function buscar_op(obj,objfoco){
   var letra = String.fromCharCode(event.keyCode)
   if(puntero >= digitos){
       cadena="";
       puntero=0;
    }
   //si se presiona la tecla ENTER, borro el array de teclas presionadas y salto a otro objeto...
   if (event.keyCode == 13){
       borrar_buffer();
       if(objfoco!=0) objfoco.focus(); //evita foco a otro objeto si objfoco=0
    }
   //sino busco la cadena tipeada dentro del combo...
   else{
       buffer[puntero]=letra;
       //guardo en la posicion puntero la letra tipeada
       cadena=cadena+buffer[puntero]; //armo una cadena con los datos que van ingresando al array
       puntero++;

       //barro todas las opciones que contiene el combo y las comparo la cadena...
       for (var opcombo=0;opcombo < obj.length;opcombo++){
          if(obj[opcombo].text.substr(0,puntero).toLowerCase()==cadena.toLowerCase()){
          obj.selectedIndex=opcombo;
          }
       }
    }
   event.returnValue = false; //invalida la acci�n de pulsado de tecla para evitar busqueda del primer caracter
}

function borrar_buffer(){
   //inicializa la cadena buscada
    cadena="";
    puntero=0;
}
</script>
<!--FIN ZONA DEL FRAMEWORK JQUERY PARA CARGA DE COMBOS DINAMICOS-->
<tr >
            <td><select name="marca" id="marca" class='SELECT'>
		 <option selected value="0">Seleccione</option>
		 <?php
		   $dbmarcam = new Database();
		   $sqlmarca = "SELECT a.cod_mar, a.nom_mar
						FROM marca a
						INNER JOIN producto b ON a.`cod_mar` = b.`cod_mar_pro`
						INNER JOIN kardex c ON c.cod_ref_kar = b.cod_pro
						GROUP BY a.nom_mar;";
		   $dbmarcam->query($sqlmarca);
		   while($dbmarcam->next_row())
		   { ?>
			  <option value="<?=$dbmarcam->cod_mar?>"><?=$dbmarcam->nom_mar?></option>       
	    <? }
		   $dbmarcam->close(); ?></select></td>
            <td><!--TIPO PRODUCTO-->
			<select name="tipo_producto" id="tipo_producto" class='SELECT'>
			<option selected value="0">Seleccione</option>
			</select></td>
            <td><!--PRODUCTO-CODIGO-->
	 	    <select name="combo_referncia" id="combo_referncia" class='SELECT' onKeypress=buscar_op(this,text2) onblur=borrar_buffer() onclick=borrar_buffer()> 
            <option selected value="0">Seleccione</option>
            </select></td>
            <td><!--COLOR-->
			<select name="codigo_fry" id="codigo_fry" class='SELECT'>
        <option selected value="0">Seleccione</option>
        </select></td>
            <td><!--SERIAL-CANTIDAD-PRECIO-BODEGA-->
			<select name="peso" id="peso" class='SELECT' onKeypress=buscar_op(this,text2) onblur=borrar_buffer() onclick=borrar_buffer()>
            <option selected value="0">Seleccione</option>
            </select></td>
            <td><!--CANTIDAD DISPONIBLE-->
			<select name="serial" id="serial" class='SELECT'>
	              <option selected value="0">Seleccione</option>
	              </select></td>
			  <script>
			function valexist(a,b)
			{
			   //alert(a+" - "+b);
			   a = parseFloat(a);
			   b = parseFloat(b);
			   if(a>b)
			   {
			     alert("La cantidad debe ser inferior o igual al Disponible!");
				 document.fo3.cantidad.value = "";
				 return true;
			   }
			   
			}
			</script>
        <td align="center"><input name="cantidad" id="cantidad" type="text" size="6" onKeyUp="valexist(this.value,serial.value);" /></td>
	    <td align="center"><input name="costo" id="costo" type="text" size="6" onKeyPress="return validaInt_evento(this,'mas')"/>
	    <!--<select name="costo" id="costo" class='SELECT'>
	              <option selected value="0">Seleccione</option>
	              </select>--></td>
	    <td align="center"><input id="mas" type='button' class='botones' value='  +  '  onclick="adicion()"></td>
          </tr>
</table>
<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>">
<input type="hidden" name="n" id="n" value="4">
<input type="hidden" name="editar" value="<?=$editar?>">
<input type="hidden" name="insertar" value="<?=$insertar?>">
<input type="hidden" name="eliminar" value="<?=$eliminar?>">
</form> 
	<!--Finaliza Carga Productos-->	</td>
  </tr>
  
  <tr>
    <td bgcolor="#E9E9E9"><!--Zona muestra productos-->
	<table width="100%">
				<tr>
				<td width="8%" class="ctablasup">Bodega</td>
				<td width="10%" class="ctablasup">Categoria</td>
				<td width="15%" class="ctablasup">Tipo Producto </td>
				<td width="9%" class="ctablasup">Producto</td>
				<td width="8%" class="ctablasup">Codigo</td>
				<td width="6%" class="ctablasup">Color</td>
				<td width="14%" class="ctablasup">Serial</td>
				<td width="6%" class="ctablasup">Disponible</td>
				<td width="6%" class="ctablasup">Cantidad:</td>
				<td width="6%" class="ctablasup">Costo</td>
				<td width="5%" class="ctablasup">Total</td>
				<td width="7%" align="center" class="ctablasup">Borrar</td>
				</tr>
					<?php
				if ($codigo>0 ) 
				{ // BUSCAR DATOS
					if($codigo>0)
					{
					   $t1 = $global[7];
					   $t2 = $global[8];
					   $id = $codigo;
					}
					$sql =" select * from ".$t2." inner join tipo_producto on ".$t2.".cod_tpro=tipo_producto.cod_tpro
						inner join marca on ".$t2.".cod_cat=marca.cod_mar 
						inner join peso on ".$t2.".cod_peso= peso.cod_pes 
						inner join producto  on ".$t2.".cod_pro= producto.cod_pro 
						INNER JOIN bodega ON bodega.cod_bod = ".$t2.".cod_bod
						where cod_mfac=".$id." order by ".$t2.".serial ";//=	
//echo $sql;						
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					while($dbdatos_1->next_row())
					{ ?>
					<tr>
				<td class='textfield01'><?=strtoupper($dbdatos_1->nom_bod)?></td>
				<td class='textfield01'><?=strtoupper($dbdatos_1->nom_mar)?></td>
				<td class='textfield01'><?=strtoupper($dbdatos_1->nom_tpro)?></td>
				<td class='textfield01'><?=strtoupper($dbdatos_1->nom_pro)?></td>
				<td class='textfield01'><div align="center"><?=$dbdatos_1->cod_fry_pro?></div></td>
				<td class='textfield01'><div align="center"><?=strtoupper($dbdatos_1->nom_pes)?></div></td>
				<td class='textfield01' ><div align="center"><?=$dbdatos_1->serial?></div></td>
				<td class='textfield01' ><div align="center"><?=$dbdatos_1->disponible?></div></td>
				<td class='textfield01'><div align="center"><?=$dbdatos_1->cant_pro?></div></td>
				<td class='textfield01'><div align="center"><?=number_format($dbdatos_1->val_uni,2,",",".")?></div></td>
				<td class='textfield01'><?=number_format(round($dbdatos_1->total_pro),2,",",".")?></td>
				<td align="center"><form name="frmdel_"<?=$dbdatos_1->cod_dfac?> method="post"><input type="submit" class="botones" name="deltmp" id="deltmp" value=" - ">
				<input type="hidden" name="ideli" value="<?=$dbdatos_1->cod_dfac?>">
				<input type="hidden" name="n" value="5">
                                <input type="hidden" name="bodega" id="bodega" value="<?=$dbdatos_1->cod_bod?>">
				<input type="hidden" name="cantidad" id="cantidad" value="<?=$dbdatos_1->cant_pro?>">
				<input type="hidden" name="serial" id="serial" value="<?=$dbdatos_1->serial?>">	
				<input type="hidden" name="prod" id="prod" value="<?=$dbdatos_1->cod_pro?>">
				<input type="hidden" name="costo" id="costo" value="<?=$dbdatos_1->val_uni?>">
				<input type="hidden" name="color" id="color" value="<?=$dbdatos_1->cod_peso?>"> 
						<input type="hidden" name="codigo" value="<?=$codigo?>"></form></td>
				</tr>
				<?	}} ?>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td align="center">&nbsp;</td>
                                  
		  </tr>
				<tr>
				  <td colspan="10"><div align="right" class="total">TOTAL REMISION SALIDA </div></td>
				  <td colspan="2"><input name="todover" id="todover" type="text" readonly="1" value="<? if($codigo>0)
														        { 
															   $total = sumartotal($codigo,$global[8],$global[7]); 
															   $total = round($total);															
															   echo number_format($total,2,",",".");
														         }  ?>"/></td>
		  </tr>
		</table>
	<!--Fin Zona muestra productos--></td>
  </tr>
  <!--<tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>-->
</table>

</div>
</html>
