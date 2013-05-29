<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?

if ($codigo!="") { // BUSCAR DATOS
	$sql ="SELECT cod_ven_inv, cod_rut_inv, fec_inv, total_saldo_inv, net_comp_inv,iva_comp_inv, total_comp_inv,obs_inv , ini_cont_inv, (SELECT nom_rut FROM ruta WHERE cod_rut=cod_rut_inv) AS ruta_nombre FROM m_inventario WHERE cod_inv = $codigo";		
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	
	$compos="(cod_ven_inv, cod_rut_inv, fec_inv, total_saldo_inv, net_comp_inv, iva_comp_inv, total_comp_inv,obs_inv, ini_cont_inv)";
	$valores="('".$vendedor."','".$ruta."','".$fecha."','".$total_nuevo_saldo."','".$neto."','".$todoiva."','".$todocompra."','".$observaciones."','".$tipo_inventario."')" ;
	
	$ins_id=insertar_maestro("m_inventario",$compos,$valores); 	

	if ($ins_id > 0) 
	{
		$compos="(cod_minv, cod_prod_dinv, cant_dinv, pventa_dinv, pcomp_dinv, iva_dinv, total_dinv )";
		for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 
		{
			if($_POST["codigo_db_".$ii]!=NULL) 
			{
				$valores="('".$ins_id."','".$_POST["codigo_db_".$ii]."','".$_POST["cantidad_".$ii]."','".$_POST["valor_venta_".$ii]."','".$_POST["valor_compra_".$ii]."','".$_POST["iva_".$ii]."','".$_POST["total_compra_".$ii]."')" ;
				$error=insertar("d_invetario",$compos,$valores); 
				
			}	
		}
		header("Location: con_inventario.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}

else
	echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 	
	
}




if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 
	
	$compos="cod_ven_inv='".$vendedor."', cod_rut_inv='".$ruta."', fec_inv='".$fecha."', total_saldo_inv='".$total_nuevo_saldo."', net_comp_inv='".$neto."' ,iva_comp_inv='".$todoiva."', total_comp_inv='".$todocompra."', obs_inv='".$observaciones."',ini_cont_inv='".$tipo_inventario."'";
	
	$error=editar("m_inventario",$compos,'cod_inv',$codigo); 

	$sql="DELETE from  d_invetario  where cod_minv=$codigo ";
	$dbser= new  Database();	
	$dbser->query($sql);

	$compos="(cod_minv, cod_prod_dinv, cant_dinv, pventa_dinv, pcomp_dinv, iva_dinv, total_dinv )";

	for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 
	{
		if($_POST["codigo_db_".$ii]!=NULL) 
		{
			$valores="('".$codigo."','".$_POST["codigo_db_".$ii]."','".$_POST["cantidad_".$ii]."','".$_POST["valor_venta_".$ii]."','".$_POST["valor_compra_".$ii]."','".$_POST["iva_".$ii]."','".$_POST["total_compra_".$ii]."')" ;
			$error=insertar("d_invetario",$compos,$valores); 
		}	
	}

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

function datos_completos(){  

if (document.getElementById('fecha').value == "" || document.getElementById('total_nuevo_saldo').value == 0 || document.getElementById('vendedor').value < 1)
	return false;
else
	return true;		
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

function llenar_codigo()
{
	document.getElementById("codigo_fry").value=document.getElementById("producto_combo").value
}

function buscar_referencia_combo()
{
	opciones=new Array();
	var encontro=0;
	opciones=document.getElementById("producto_combo").options;
	var cantidad = opciones.length;
	for(a=0;a < cantidad; a++)
	{
		 if (opciones[a].value == document.getElementById("codigo_fry").value){
		 	var iten= opciones[a].index;
			opciones[iten].selected = true;
			encontro=1;
			return false;
		}
	}
	
	if(encontro==0 &&  document.getElementById("codigo_fry").value.length > 0){
		document.getElementById("codigo_fry").value='';
		document.getElementById("codigo_fry").focus();
		opciones[0].selected = true;
		alert('Referncia No Encontrado' )
		return false;
	}
}

function  adicion() 
{
	var producto_valores ;
	var unidad_empaque=0;
	var cantidad= document.getElementById('cantidad').value;
	producto_valores = buscar_valores_referencia();
	
	if(document.getElementById("cantidad").value>0  && document.getElementById("codigo_fry").value > 0) 
	{
		if(document.getElementById("ini_empa").value=='Completo')
		{
			alert(producto_valores[3])
			Agregar_html_inventario(producto_valores[0],producto_valores[1],producto_valores[2],producto_valores[3],producto_valores[4],producto_valores[5],cantidad,document.getElementById("ini_empa").value);
		}
		
		
		if(document.getElementById("ini_empa").value=='Parcial')
		{
			if(producto_valores[6]=='') 
				{ unidad_empaque = 1; }
			else 
				{ unidad_empaque = producto_valores[6]; }
				
				var precio_parcial=Math.round(producto_valores[3] / unidad_empaque);				
				//alert(precio_parcial)
				//alert(producto_valores[3])
				//return false;
			Agregar_html_inventario(producto_valores[0],producto_valores[1],producto_valores[2],precio_parcial,producto_valores[4],producto_valores[5],cantidad,document.getElementById("ini_empa").value);
		}
	}
	else {
		alert("Ingrese una Referencia y una Cantidad")
		document.getElementById("cantidad").focus();
	}
}




function buscar_valores_referencia()
{
var producto_valores;
<?
	$sql ='select * from producto';
	$db->query($sql);
	while($db->next_row()){ 
		echo "\n if(document.getElementById('producto_combo').value=='$db->cod_fry_pro') ";
		echo "producto_valores= new Array ('$db->cod_pro','$db->cod_fry_pro','$db->nom_pro','$db->pre_ven_pro','$db->pre_com_pro','$db->iva_pro','$db->unidad');\n";	
	}
	echo "return producto_valores";
?>	
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
	<table width="662" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50" class="textotabla1">Fecha:</td>
        <td width="164">
          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_inv?>" />
          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td width="8" class="textorojo">*</td>
        <td width="93" class="textotabla1"> Ruta:</td>
        <td width="145">
          <select size="1" id="ruta" name="ruta"  class='SELECT' > 
		  <? if($codigo!="") { ?>
		  	<option value="<?=$dbdatos->cod_rut_carg ?>"><?=$dbdatos->ruta_nombre?></option>
		  <? } ?>
		  </select>		  </td>
		 
        <td width="6" class="textorojo">&nbsp;</td>
        <td width="163" class="textorojo">&nbsp;</td>
       </tr>
      
       <tr>
         <td class="textotabla1"> Vendedor:</td>
         <td>
		 <? combo_evento("vendedor","vendedor","cod_ven"," nom_ven ",$dbdatos->cod_ven_inv,"onchange='buscar_rutas()'", "nom_ven"); ?>          </td>
         <td>&nbsp;</td>
         <td class="textotabla1">Observaicones:</td>
         <td colspan="3"><textarea name="observaciones" cols="45" rows="4" class="textfield02"  onchange='buscar_rutas()' ><?=$dbdatos->obs_inv?></textarea></td>
       </tr>
	    <tr>
         <td colspan="4" class="textotabla1"> Tipo de Inventaio: &nbsp;&nbsp;&nbsp;&nbsp;
           Control
           <input name="tipo_inventario" type="radio" value="Control"  checked="checked"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   Inicial
		   <input name="tipo_inventario" type="radio" value="Inicial" />
           
		   </td>
         <td colspan="3">&nbsp;</td>
	    </tr>
       
	   
	   <tr>
        <td colspan="7" class="textotabla1" >
		<table  width="100%" border="1">
         
          <tr >
            <td  class="ctablasup" colspan="2" width="40%">Referencia:</td>
            <td colspan="2"  class="ctablasup">Existencias</td>
			<td colspan="2"  class="ctablasup">Cantidad:</td>
            <td  class="ctablasup">Costo: </td>
			<td width="8%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr >
            <td > 
<input name="codigo_fry" type="text" class="textfield01_1" id="codigo_fry"  onblur="buscar_referencia_combo()" onKeyPress=" return validaInt_evento(this,'cantidad')" size="6"  /> <input type="hidden" id="codigo_producto" value="0" /> </td>
			<td> <? combo_evento("producto_combo","producto","cod_fry_pro","nom_pro",""," onchange='llenar_codigo()'", "nom_pro");?></td>
            <td colspan="2" align="center"> 
			<select name='uni_empa' id='ini_empa' class='SELECT' >
			<option value='Completo' >Completo</option>
			<option value='Parcial' selected='selected'>Parcial</option>
			</select>
			</td>
		    <td colspan="2" align="center">
			<input name="cantidad" type="text" class="textfield01" id="cantidad" onchange="validaValue(this);" onkeypress=" return validaFloat(this)" /></td>
           
            <td align="center"> <input name="total" id="total" type="text" class="textfield01_1" readonly="1" onChange="validaValue(this);" onKeyPress=" return validaFloat(this)"/></td>
			<td align="center"> <input type='button'  class='botones' value='  +  '  onclick="adicion()">	</td>
          </tr>
		      
		  <tr >
		  <td  colspan="8">
			  <table width="100%">
				<tr id="fila_0">
				<td  class="ctablasup" width="45%">Referencia</td>
				<td  class="ctablasup" width="10%">Cantidad</td>
				<td  class="ctablasup" width="10%">P.Venta</td>
				<!--<td  class="ctablasup" width="10%">P. Compra </td>-->
				<td  class="ctablasup" width="10%">IVA % </td>
				<td  class="ctablasup" width="20%">Total Compra </td>
				<td  class="ctablasup" width="5%">Borrar</td>
				</tr>
				<?
				if ($codigo!="") { // BUSCAR DATOS
					$sql ="SELECT *,(SELECT nom_pro FROM producto WHERE cod_pro=cod_prod_dinv) nom_producto,(SELECT cod_fry_pro FROM producto WHERE cod_pro=cod_prod_dinv) cod_fry FROM d_invetario WHERE cod_minv=$codigo";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					//echo "<table width='100%'>";
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_$jj'>";
						//nombre y codigo de la referencia
						echo "<td><INPUT type='hidden'  name='codigo_db_$jj' value='$dbdatos_1->cod_prod_dinv'><span  class='textfield01'> $dbdatos_1->cod_fry-$dbdatos_1->nom_producto </span> </td>";
						
						//cantidad
						echo "<td  align='right' ><INPUT type='hidden'  name='cantidad_$jj' value='$dbdatos_1->cant_dinv'><span class='textfield01'> $dbdatos_1->cant_dinv </span> </td>";	
						
						//precio venta
						echo "<td  align='right' ><INPUT type='hidden'  name='valor_venta_$jj' value='$dbdatos_1->pventa_dinv'><span  class='textfield01'> $dbdatos_1->pventa_dinv </span> </td>";
						
						//precio compra
						echo "<td align='right'><INPUT type='hidden'  name='valor_compra_$jj' value='$dbdatos_1->pcomp_dinv'><span  class='textfield01'> $dbdatos_1->pcomp_dinv </span> </td>";
						
						//precio iva
						echo "<td align='right'><INPUT type='hidden'  name='iva_$jj' value='$dbdatos_1->iva_dinv'><span  class='textfield01'> $dbdatos_1->iva_dinv </span> </td>";	
						
						//precio total de compra
						echo "<td align='right'><INPUT type='hidden'  name='total_compra_$jj' value='$dbdatos_1->total_dinv'><span  class='textfield01'> $dbdatos_1->total_dinv </span> </td>";						
							
						//boton q quita la fila
	$para_total_compra=($dbdatos_1->pventa_dinv*$dbdatos_1->cant_dinv)+ (($dbdatos_1->pventa_dinv*$dbdatos_1->cant_dinv)*$dbdatos_1->iva_dinv)/100;
	$para_neto=($dbdatos_1->pcomp_dinv * $dbdatos_1->cant_dinv);
	$para_iva=(($dbdatos_1->pcomp_dinv * $dbdatos_1->cant_dinv)*($dbdatos_1->iva_dinv)) /100 ;
	//$para_iva = number_format($para_iva,0)
	
						echo "<td><div align='center'>	
						<INPUT type='button' class='botones' value='  -  ' onclick='
removerFila_cargue
(\"fila_$jj\",\"val_inicial\",\"fila_\",\"$jj\",\"$para_total_compra\",\"$para_neto\",\"$para_iva\");'>
						</div></td>";
						echo "</tr>";
						$jj++;
					}
					
				}
				?>
				</table>			</td>
			</tr>
			
		 <tr >
		  <td  colspan="8">
			  <table width="100%">
				<tr >
				<td colspan="2"  class="ctablasup">Resumen del Inventario </td>
				</tr>
					<tr >
				<td ><div align="right"></div></td>
				<td ><div align="right" >Total Inventario:
                    <input name="total_nuevo_saldo" id="total_nuevo_saldo" type="text" class="textfield01" readonly="1" value="<? if ($codigo !=0) echo $dbdatos->total_saldo_inv; else echo "0" ?>" />
				</div>				  </td>
				</tr>
				<tr >
				<td ><div align="right" ></div>				  </td>
				<td ><div align="right" ></div>				  </td>
				</tr>
				<tr >
				<td ><div align="right" ></div>				  </td>
				<td ><div align="right" ></div>				  </td>
				</tr>
				</table>			</td>
			</tr>
		</table>	
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
