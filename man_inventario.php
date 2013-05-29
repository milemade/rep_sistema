<? include("js/funciones.php")?>
<? include("lib/database.php")?>
<?

if ($codigo!="") { // BUSCAR DATOS
	$sql =" SELECT * FROM ajuste	INNER JOIN producto ON  ajuste.cod_ref_aju  =producto.cod_pro LEFT JOIN 	tipo_producto ON producto.cod_tpro_pro = tipo_producto.cod_tpro LEFT JOIN  marca ON producto.cod_mar_pro = marca.cod_mar LEFT  JOIN peso ON producto.cod_pes_pro = peso.cod_pes WHERE  cod_aju=$codigo ";		
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS

	$compos="(cod_tpro_aju, cod_mar_aju, cod_pes_aju, cod_ref_aju, cod_bod_aju, cod_fry_aju ,fec_aju, cant_aju,obs_aju)";
	$valores="('".$tipo_producto."','".$marca."','".$peso."','".$combo_referncia."','".$bodega."','".$codigo_fry."','".$fecha."','".$cantidad."','".$observaciones."')" ;

	kardex("resta",$combo_referncia,$bodega,$cantidad,0,$peso);
	
	
	$error=insertar("ajuste",$compos,$valores);
	if($error==1)
	{
		header("Location:con_inventario.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else 
	{
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
	}
}


if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 
	
	$sql="select * from  ajuste  where cod_aju=$codigo ";
	$dbser= new  Database();	
	$dbser->query($sql);
	if($dbser->next_row())
	{
		kardex("suma",$dbser->cod_ref_aju,$dbser->cod_bod_aju,$dbser->cant_aju,0,$dbser->cod_pes_aju);	
	}
	
	$compos="cod_tpro_aju='".$tipo_producto."', cod_mar_aju='".$marca."', cod_pes_aju='".$peso."', cod_ref_aju='".			$combo_referncia."', cod_bod_aju='".$bodega."' ,cod_fry_aju='".$codigo_fry."', fec_aju='".$fecha."', cant_aju='".$cantidad."',obs_aju='".$observaciones."'";
	
	$error=editar("ajuste",$compos,'cod_aju',$codigo); 
	kardex("resta",$combo_referncia,$bodega,$cantidad,0,$peso);
	if ($error==1) {
		header("Location: con_inventario.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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

function datos_completos()
{  
if (document.getElementById('fecha').value == "" || document.getElementById('combo_referncia').value < 1 || document.getElementById('bodega').value < 1 || document.getElementById('bodega').value < 1 || document.getElementById('codigo_fry').value == ""  || document.getElementById('cantidad').value == "" )    
	return false;
else
	return true;		
}


function busca_proveedores() {
	var codigo_buscar_referencia =document.getElementById('tipo_producto').value;	
	var combo_llenar=document.getElementById('marca');	
	combo_llenar.options.length=0;
	var vec_productos = new Array;
	<?
	$dbdatos111= new  Database();
	$sql ="SELECT    DISTINCT cod_mar_pro, nom_mar ,cod_tpro_pro FROM producto  left JOIN tipo_producto ON tipo_producto.cod_tpro=producto.cod_tpro_pro  left JOIN marca ON marca.cod_mar=producto.cod_mar_pro order by nom_mar "; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_mar_pro','$dbdatos111->nom_mar','$dbdatos111->cod_tpro_pro');\n";	
		$i++;
	}
	?>
	var cant=1;
	combo_llenar.options[0] = new Option('Seleccione','0'); 
	for (j=0; j<<?=$i?>;j++)
	{
		if(codigo_buscar_referencia==vec_productos[j][2]) 
		{
			combo_llenar.options[cant] = new Option(vec_productos[j][1],vec_productos[j][0]);  
			cant++; 	
		}
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



function busca_proveedores() {
	var codigo_buscar_referencia =document.getElementById('marca').value;	
	var combo_llenar=document.getElementById('tipo_producto');	
	combo_llenar.options.length=0;
	var vec_productos = new Array;
	<?
	$dbdatos111= new  Database();
	$sql =" SELECT    DISTINCT cod_tpro, nom_tpro ,cod_mar_pro FROM producto  left JOIN tipo_producto ON tipo_producto.cod_tpro=producto.cod_tpro_pro   order by nom_tpro"; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_tpro','$dbdatos111->nom_tpro','$dbdatos111->cod_mar_pro');\n";	
		$i++;
	}
	?>
	var cant=1;
	combo_llenar.options[0] = new Option('Seleccione','0'); 
	for (j=0; j<<?=$i?>;j++)
	{
		if(codigo_buscar_referencia==vec_productos[j][2]) 
		{
			combo_llenar.options[cant] = new Option(vec_productos[j][1],vec_productos[j][0]);  
			cant++; 	
		}
	}
}

function busca_empaque() {
	var codigo_buscar_referencia =document.getElementById('marca').value;	
	var combo_llenar=document.getElementById('peso');	
	combo_llenar.options.length=0;
	var vec_productos = new Array;
	<?
	$dbdatos111= new  Database();
	$sql ="SELECT DISTINCT  cod_pes, nom_pes, cod_mar_pro, cod_tpro_pro FROM producto left JOIN peso ON peso.cod_pes=producto.cod_pes_pro  order by nom_pes "; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_pes','$dbdatos111->nom_pes','$dbdatos111->cod_mar_pro','$dbdatos111->cod_tpro_pro');\n";	
		$i++;
	}
	?>
	var cant=1;
	combo_llenar.options[0] = new Option('Seleccione','0'); 
	for (j=0; j<<?=$i?>;j++)
	{
		if(codigo_buscar_referencia==vec_productos[j][2] & document.getElementById('tipo_producto').value==vec_productos[j][3]) 
		{
			combo_llenar.options[cant] = new Option(vec_productos[j][1],vec_productos[j][0]);  
			cant++; 	
		}
	}
}

function busca_referencia() {
	var codigo_buscar_referencia =document.getElementById('peso').value;	
	var combo_llenar=document.getElementById('combo_referncia');	
	combo_llenar.options.length=0;
	var vec_productos = new Array;
	<?
	//marca === talla 
	$dbdatos111= new  Database();
	$sql ="SELECT DISTINCT   cod_pro, nom_pro ,cod_pes_pro,cod_mar_pro,cod_tpro_pro FROM producto  ORDER BY nom_pro  "; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_pro','$dbdatos111->nom_pro','$dbdatos111->cod_pes_pro' ,'$dbdatos111->cod_mar_pro','$dbdatos111->cod_tpro_pro');\n";	
		$i++;
	}
	?>
	var cant=1;
	combo_llenar.options[0] = new Option('Seleccione','0'); 
	for (j=0; j<<?=$i?>;j++)
	{
		if(document.getElementById('marca').value==vec_productos[j][3] & document.getElementById('tipo_producto').value==vec_productos[j][4]) 
		{
			combo_llenar.options[cant] = new Option(vec_productos[j][1],vec_productos[j][0]);  
			cant++; 	
		}
	}
}

function busca_codigo() {
	var codigo_buscar_referencia =document.getElementById('combo_referncia').value;	
	var combo_llenar=document.getElementById('codigo_fry');	
	combo_llenar.value='';
	var vec_productos = new Array;
	document.getElementById('cantidad').focus();
	<?
	$dbdatos111= new  Database();
	$sql ="SELECT cod_pro, cod_fry_pro FROM producto  "; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_pro','$dbdatos111->cod_fry_pro');\n";	
		$i++;
	}
	?>
	for (j=0; j<<?=$i?>;j++)
	{
		if(codigo_buscar_referencia==vec_productos[j][0]) 
		{
			combo_llenar.value=vec_productos[j][1];
		}
	}
}

function cargar_combos()
{
	var codigo_buscar_referencia =document.getElementById('codigo_fry').value;	
	document.getElementById('peso').focus();
	var vec_productos = new Array;
	<?
	$dbdatos111= new  Database();
	$sql ="SELECT cod_pro,nom_pro,cod_fry_pro,cod_tpro_pro,cod_mar_pro,nom_mar,cod_pes_pro,nom_pes ,nom_tpro  FROM producto inner JOIN marca ON marca.cod_mar=producto.cod_mar_pro inner JOIN peso ON peso.cod_pes=producto.cod_pes_pro  inner JOIN tipo_producto ON   producto.cod_tpro_pro =tipo_producto.cod_tpro "; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_pro','$dbdatos111->nom_pro','$dbdatos111->cod_fry_pro','$dbdatos111->cod_tpro_pro','$dbdatos111->cod_mar_pro','$dbdatos111->nom_mar','$dbdatos111->cod_pes_pro','$dbdatos111->nom_pes','$dbdatos111->nom_tpro');\n";	
		$i++;
	}
	?>
	var bandera=0;
	for (j=0; j<<?=$i?>;j++)
	{
		if(codigo_buscar_referencia==vec_productos[j][2]) 
		{
			//document.getElementById('marca').options[0] = new Option(vec_productos[j][5],vec_productos[j][4]); 
			document.getElementById('marca').value=vec_productos[j][4];
			document.getElementById('tipo_producto').options[0] = new Option(vec_productos[j][8],vec_productos[j][3]);
			document.getElementById('combo_referncia').options[0] = new Option(vec_productos[j][1],vec_productos[j][0]); 
			bandera=1;
		}
	}
	if(bandera==0)
	{
		document.getElementById('marca').options.length=0;
		//document.getElementById('peso').options.length=0;
		document.getElementById('combo_referncia').options.length=0;
		document.getElementById("tipo_producto").value=0;
		//document.getElementById("codigo_fry").value='';
		document.getElementById("cantidad").value='';
		document.getElementById("costo").value='';
		document.getElementById("codigo_fry").focus();
		alert('Esta Referencia No esta Registrada o Verifique la parametrizacion del Producto')
	}

}
</script>

<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_inventario.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_inventario.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_inventario.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>
        <td width="70" class="ctablaform">Consultar</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">
          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" /> </td>
        
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">INVENTARIO FISICO :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="681" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="128" class="textotabla1">Fecha:</td>
        <td width="163">
          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_aju?>" />
          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td width="8" class="textorojo">*</td>
        <td width="96" class="textotabla1">Bodega:</td>
        <td width="261">
		<? 
		
		$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$global[2]";
				 combo_sql("bodega","bodega","valor","nombre",$dbdatos->cod_bod,$sql); 
		
		//combo_evento("bodega","bodega","cod_bod","nom_bod",$dbdatos->cod_bod_aju,"  ", "nom_bod"); 
		
		?>
          <span class="textorojo">*</span></td>
		 
        <td width="6" class="textorojo">&nbsp;</td>
        </tr>
      
       <tr>
         <td height="31" class="textotabla1">Categoria:</td>
         <td><? combo_evento("marca","marca","cod_mar","nom_mar",$dbdatos->cod_mar," onchange=\"busca_proveedores()\" ", "nom_mar"); ?></td>
         <td rowspan="2"><span class="textorojo">*</span></td>
         <td class="textotabla1">Codigo</td>
         <td colspan="2">
		 <input name="codigo_fry" id="codigo_fry" type="text" class="caja_resalte1" onkeypress=" return validaInt_evento(this,'cantidad')"  onchange="cargar_combos()" value="<?=$dbdatos->cod_fry_pro ?>">
           <span class="textorojo">*</span></td>
       </tr>
       <tr>
         <td class="textotabla1">Tipo de Producto:</td>
         <td><select size="1" id="tipo_producto" name="tipo_producto"  class='SELECT' onchange="busca_referencia()" >
         </select></td>
         <td class="textotabla1">Cantidad</td>
         <td colspan="2">
		 <input name="cantidad" type="text" class="caja_resalte" id="cantidad" onkeypress="return validaInt(this)" value="<?=$dbdatos->cant_aju ?>"/>
           <span class="textorojo">*</span></td>
       </tr>
          <tr>
        <td width="128" class="textotabla1">Talla</td>
        <td width="163"><? combo_evento("peso","peso","cod_pes","nom_pes", $dbdatos->cod_pes_aju ,"  ", "nom_pes"); ?></td>
        <td width="8" class="textorojo">*</td>
        <td width="96" class="textotabla1">Observaicones</td>
        <td width="261" rowspan="2"><span class="textorojo">
          <textarea name="observaciones" cols="40" rows="4" class="textfield02"  onchange='buscar_rutas()' ><?=$dbdatos->obs_aju?></textarea>
        </span></td>
		 
        <td width="6" class="textorojo">&nbsp;</td>
        </tr>
	      <tr>
        <td width="128" class="textotabla1">Referencia</td>
        <td width="163">
		<? if ($codigo > 0) {?>
		<select size="1" id="combo_referncia" name="combo_referncia"  class='SELECT' onchange="busca_codigo()">
		  <option value="<?=$dbdatos->cod_ref_aju?>" selected="selected"><?=$dbdatos->nom_pro?></option>
        </select>
		<? } else {  ?>
			<select size="1" id="combo_referncia" name="combo_referncia"  class='SELECT' onchange="busca_codigo()">
        </select>
		<? } ?>
        </td>
        <td width="8" class="textorojo">*</td>
        <td width="96" class="textotabla1">&nbsp;</td>
        <td width="6" class="textorojo">&nbsp;</td>
        </tr>
	      <tr>
        <td width="128" class="textotabla1">&nbsp;</td>
        <td width="163">&nbsp;</td>
        <td width="8" class="textorojo">&nbsp;</td>
        <td width="96" class="textotabla1">&nbsp;</td>
        <td width="261">&nbsp;</td>
		 
        <td width="6" class="textorojo">&nbsp;</td>
        </tr>
	   
	   <tr>
         <td colspan="6" class="textotabla1" >
          </table>
		  
	    </td>
		 </tr>
	  <tr> 
		  <td colspan="8" >		  </td>
		  </tr>
    </table>
<tr>
  <tr>
    <td>
	<input type="hidden" name="val_inicial" id="val_inicial" value="<? if($codigo!=0) echo $jj-1; else echo "0"; ?>" />
	<input type="hidden" name="guardar" id="guardar" />
		 <?  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
	   <input type="hidden" id="valDoc_inicial" value="<?=$valueInicial?>"> 
	   <input type="hidden" name="cant_items" id="cant_items" value=" <?  if ($codigo!="") echo $aa; else echo "0"; ?>">
	   <input name="neto" id="neto" type="hidden" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->net_comp_inv; else echo "0" ?>"/>
      <input name="todoiva" id="todoiva" type="hidden" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->iva_comp_inv; else echo "0"; ?>"/>
      <input name="todocompra" id="todocompra" type="hidden" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->total_comp_inv; else echo "0"; ?>"/></td>
  </tr>  
</table>
</form> 
</div>

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
<div  id="relacion" align="center" style="display:none" >
<!-- <div  id="relacion" align="center" >-->
<table width="413" border="0" cellspacing="0" cellpadding="0" bgcolor="#E9E9E9" align="center">
   <tr id="pongale_0" >
    <td width="81" class="textotabla1"><strong>Referncia:</strong></td>
    <td width="332" class="textotabla1"><strong id="serial_nombre_"> </strong>
      <input type="hidden" name="textfield3"  id="ref_serial_"/>
	  <input type="hidden" name="textfield3"  id="campo_guardar"/>
	  </td>
   </tr>
   
   <tr>
     <td class="textotabla1" colspan="2"><div align="center">
       <input type="button" name="Submit" value="Guardar"  onclick="guardar_serial()"/>  
	    <input type="button" name="Submit" value="Cancelar"  onclick="limpiar()" id="cancelar" />  
       <input type="hidden" name="textfield32"  id="catidad_seriales" value="0"/>
     </div></td>
   </tr>
</table>
</div>

</body>

</html>
