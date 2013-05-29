<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?
if ($codigo!="") { // BUSCAR DATOS

	$sql ="SELECT  *  FROM m_dev_entrada  WHERE cod_mdent=$codigo";		
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS


	$compos="(fec_mdent,fac_mdent,obs_mdent,total_mdent,cod_prove_mdent)";
	$valores="('".$fecha."','".$num_fac."','".$observaciones."','".$todocompra."','".$proveedor."')" ; 
	$ins_id=insertar_maestro("m_dev_entrada",$compos,$valores); 	
		
	$tipo_pago = 'Credito'; // para q sea por defecto todo a credito
	if($tipo_pago != 'Contado' ) {
	
		$compos="(cod_doc_ccom,cod_tdoc_ccom,fec_ccom,val_ccom,cod_pro_ccom)";
		$valores="('".$ins_id."','2','$fecha','$todocompra','$proveedor')" ; 
		insertar("cartera_compras",$compos,$valores);
	}	
	
	
		
	if ($ins_id > 0) 
	{
		$compos="(cod_ment_ddent,cod_tpro_ddent,cod_mar_ddent,cod_pes_ddent,cod_ref_ddent,cant_ddent,cos_ddent)";
		
		for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 
		{
			if($_POST["codigo_tipo_prodcuto_".$ii]!=NULL) 
			{
				$valores="('".$ins_id."','".$_POST["codigo_tipo_prodcuto_".$ii]."','".$_POST["codigo_marca_".$ii]."','".$_POST["codigo_peso_".$ii]."','".$_POST["codigo_referencia_".$ii]."','".$_POST["cantidad_ref_".$ii]."','".$_POST["costo_ref_".$ii]."')" ;
				$error=insertar("d_dev_entrada",$compos,$valores); 
				//kardex("suma",$_POST["codigo_referencia_".$ii],$bodega,$_POST["cantidad_ref_".$ii],$_POST["costo_ref_".$ii],$_POST["codigo_peso_".$ii]);
			}	
		}
		header("Location: con_cargue_dev.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}

else
	echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 	
	
}


if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 
	
	$compos="fec_mdent='".$fecha."', fac_mdent='".$num_fac."', obs_mdent='".$observaciones."', total_mdent='".$todocompra."',cod_prove_mdent='".$proveedor."'  ";
	$error=editar("m_dev_entrada",$compos,'cod_mdent',$codigo); 
	
	//actualiza la cartera
	$compos="fec_ccom='$fecha',val_ccom='$todocompra', cod_pro_ccom='$proveedor'";
	$error=editar("cartera_compras",$compos,'cod_doc_ccom',$codigo); 
	//actualiza la cartera
	
	
	$sql="select * from  d_dev_entrada  where cod_ment_ddent=$codigo ";
	$dbser= new  Database();	
	$dbser->query($sql);
	while($dbser->next_row()){
	
	//	kardex("resta",$dbser->cod_ref_dent,$bodega,$dbser->cant_dent,0,$dbser->cod_pes_dent);
	}
	
	$sql="DELETE from  d_dev_entrada  where cod_ment_ddent=$codigo ";
	$dbser->query($sql);

	$compos="(cod_ment_ddent,cod_tpro_ddent,cod_mar_ddent,cod_pes_ddent,cod_ref_ddent,cant_ddent,cos_ddent)";
		
	for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 
	{
		if($_POST["codigo_tipo_prodcuto_".$ii]!=NULL) 
		{
			$valores="('".$codigo."','".$_POST["codigo_tipo_prodcuto_".$ii]."','".$_POST["codigo_marca_".$ii]."','".$_POST["codigo_peso_".$ii]."','".$_POST["codigo_referencia_".$ii]."','".$_POST["cantidad_ref_".$ii]."','".$_POST["costo_ref_".$ii]."')" ;
			$error=insertar("d_dev_entrada",$compos,$valores); 
			
			//kardex("suma",$_POST["codigo_referencia_".$ii],$bodega,$_POST["cantidad_ref_".$ii],$_POST["costo_ref_".$ii],$_POST["codigo_peso_".$ii]);
		}	
	}


	if ($error==1) {
		header("Location: con_cargue_dev.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
	if (document.getElementById('fecha').value == ""  || document.getElementById('todocompra').value == "" )
		return false;
	else
		return true;		

}

function  adicion() 
{
	/*var producto_valores ;
	var cantidad= document.getElementById('cantidad').value;
	///cambio por descuentos
	var descuento_prod= parseFloat(document.getElementById('descuento').value);
	///cambio por descuentos
	var venta_unidad= document.getElementById('venta_unidad').value;
	//producto_valores = buscar_valores_referencia();*/
	if(document.getElementById("cantidad").value>0 && document.getElementById("codigo_fry").value > "" && document.getElementById("costo").value >0 && document.getElementById('combo_referncia').value > 0  && document.getElementById('peso').value > 0  ) 
	{
	
		Agregar_html_entrada();		

		document.getElementById('marca').value=0;
		//document.getElementById('peso').options.length=0;
		document.getElementById('tipo_producto').options.length=0;
		//document.getElementById("tipo_producto").value=0;
		document.getElementById('combo_referncia').options.length=0;
		document.getElementById("codigo_fry").value='';
		document.getElementById("cantidad").value='';
		document.getElementById("costo").value='';
		document.getElementById("codigo_fry").focus();
		return false;
	}
	else 
	{
		alert("Ingrese una Referencia Valida junto con los demas Valores")
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
	$sql ="SELECT cod_pro,nom_pro,cod_fry_pro,cod_tpro_pro,cod_mar_pro,nom_mar,cod_pes_pro ,nom_tpro  FROM producto inner JOIN marca ON marca.cod_mar=producto.cod_mar_pro  inner JOIN tipo_producto ON   producto.cod_tpro_pro =tipo_producto.cod_tpro "; 
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
			//alert(vec_productos[j][5])
			//alert()
			//document.getElementById('marca').options[0] = new Option(vec_productos[j][5],vec_productos[j][4]); 
			document.getElementById('marca').value=vec_productos[j][4];
			document.getElementById('tipo_producto').options[0] = new Option(vec_productos[j][8],vec_productos[j][3]);
			document.getElementById('combo_referncia').options[0] = new Option(vec_productos[j][1],vec_productos[j][0]); 
			bandera=1;
		}
	}
	if(bandera==0)
	{
		//document.getElementById('marca').options.length=0;
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

function buscar_producto(){
var ruta="con_consulta_inf.php";
var tamano="recibo";
var ancho=0;
var alto=0;
	
if(tamano=="mediano") {
	ancho=900;
	alto=600;
}

if(tamano=="grande") {
	ancho=900;
	alto=700;
}

if(tamano=="recibo") {
	ancho=700;
	alto=500;
}



var marginleft = (screen.width - ancho) / 2;
var margintop = (screen.height - alto) / 2;
propiedades = 'menubar=0,resizable=1,height='+alto+',width='+ancho+',top='+margintop+',left='+marginleft+',toolbar=0,scrollbars=yes';
window.open(""+ruta+"?codigo=0","Busqueda",propiedades)

}


document.onkeydown = function(e) 
{ 
	
	
	if(e) 
	document.onkeypress = function(){return true;} 


	var evt = e?e:event; 
	if(evt.keyCode==120 || evt.keyCode==121) 
	{ 
		if(evt.keyCode==120)
		buscar_producto();
		if(evt.keyCode==121){
		calcula_cambio();
		cambio_guardar();		
		}
	
		if(e) 
		document.onkeypress = function(){return false;} 
		else 
		{ 
		evt.keyCode = 0; 
		evt.returnValue = false; 
		} 
	} 
} 


</script>

<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_dev_cargue.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_cargue_dev.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="#"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" onclick="buscar_producto()" /></a><a href="con_cargue_dev.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"></a></td>
        <td width="70" class="ctablaform">Consultar (F9) </td>
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
    <td class="textotabla01">DEVOLUCION  COMPRA :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50" class="textotabla1">Fecha:</td>
        <td width="164">
          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_mdent ?>" />
          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td width="8" class="textorojo">*</td>
        <td width="93" rowspan="2" class="textotabla1" valign="top">Observaicones:</td>
        <td rowspan="2">
		  <textarea name="observaciones" cols="45" rows="4" class="textfield02"  ><?=$dbdatos->obs_mdent?></textarea></td>
        </tr>
      
       <tr>
         <td class="textotabla1">Proveedor</td>
         <td><? combo_evento("proveedor","proveedor","cod_pro","nom_pro",$dbdatos->cod_prove_mdent," ", "nom_pro"); ?></td>
         <td>&nbsp;</td>
         </tr>
       
	         <tr>
         <td class="textotabla1">Factura No:</td>
         <td class="textotabla1"><input name="num_fac" id="num_fac" type="text" class="textfield2" value="<?=$dbdatos->fac_mdent?>" onkeypress=" return validaInt()"/></td>
         <td>&nbsp;</td>
         <td width="93" class="textotabla1" valign="top">&nbsp;</td>
         <td>&nbsp;</td>
            </tr>
	   <tr>
        <td colspan="5" class="textotabla1" >
		<table  width="99%" border="1">         
          <tr >
            <td  class="ctablasup">Categoria</td>
			<td  class="ctablasup">Tipo Producto </td>
            <td colspan="2"  class="ctablasup">Referencia</td>
			<td  class="ctablasup">&nbsp;Codigo</td>
            <td  class="ctablasup">Color</td>
            <td   class="ctablasup">Cantidad</td>
			<td    class="ctablasup">Costo</td>
			<td width="4%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr >
            <td ><? combo_evento("marca","marca","cod_mar","nom_mar",""," onchange=\"busca_proveedores()\" ", "nom_mar"); ?></td>
			<td >
			<select size="1" id="tipo_producto" name="tipo_producto"  class='SELECT' onchange="busca_referencia()" >
            </select>			</td>
            <td colspan="2" align="center"><select size="1" id="combo_referncia" name="combo_referncia"  class='SELECT' onchange="busca_codigo()">
            </select>
              <input name="hidden" type="hidden" id="codigo_producto" value="0" /></td>
            <td align="center"><input name="codigo_fry" id="codigo_fry" type="text" class="caja_resalte1" onkeypress=" return valida_evento(this,'cantidad')"  onchange="cargar_combos()"  ></td>
			 <td align="center">
		<? combo_evento("peso","peso","cod_pes","nom_pes"," "," onfocus='cargar_combos()'  ", "nom_pes"); ?>		</td>
			 <td align="center">
			 <input name="cantidad" type="text" class="caja_resalte" id="cantidad" onkeypress="return validaInt_evento(this,'costo')"/>			 </td>
			 <td align="center">
			 <input name="costo" type="text" class="caja_resalte1" id="costo" onkeypress="return validaInt_evento(this,'mas')"/></td>
			 <td align="center"> 
			 <input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">			 </td>
          </tr>
		      
		  <tr >
		  <td  colspan="9">
			  <table width="100%">
				<tr id="fila_0">
				<td  class="ctablasup">Categoria</td>
				<td  class="ctablasup">Tipo Producto </td>
				<td   class="ctablasup">Referencia:</td>
				<td  class="ctablasup">Codigo</td>
				<td  class="ctablasup">Color</td>
				<td   class="ctablasup">Cantidad:              </td>
				<td    class="ctablasup">Costo</td>
				<td width="4%" class="ctablasup" align="center">Borrar:</td>
				</tr>
				<?
				if ($codigo!="") { // BUSCAR DATOS
				$sql =" SELECT * FROM d_dev_entrada INNER JOIN tipo_producto ON tipo_producto.cod_tpro=d_dev_entrada.cod_tpro_ddent INNER JOIN marca ON marca.cod_mar=d_dev_entrada.cod_mar_ddent INNER JOIN peso ON peso.cod_pes=d_dev_entrada.cod_pes_ddent INNER JOIN producto ON producto.cod_pro=d_dev_entrada.cod_ref_ddent WHERE cod_ment_ddent=$codigo order by cod_ddent ";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					//echo "<table width='100%'>";
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_$jj'>";
						
						//cmarca
						echo "<td  ><INPUT type='hidden'  name='codigo_marca_$jj' value='$dbdatos_1->cod_mar_ddent'><span class='textfield01'> $dbdatos_1->nom_mar </span> </td>";	
						
						//tipo de producto
						echo "<td><INPUT type='hidden'  name='codigo_tipo_prodcuto_$jj' value='$dbdatos_1->cod_tpro_ddent'><span  class='textfield01'> $dbdatos_1->nom_tpro </span> </td>";
						
						//referencia
						echo "<td  ><INPUT type='hidden'  name='codigo_referencia_$jj' value='$dbdatos_1->cod_ref_ddent'><span  class='textfield01'> $dbdatos_1->nom_pro </span> </td>";
						
						//% codigo barra
						echo "<td ><INPUT type='hidden'  name='codigo_fry_$jj' value='$dbdatos_1->cod_fry_pro'><span  class='textfield01'> $dbdatos_1->cod_fry_pro </span> </td>";
						
						//talla
						echo "<td   ><INPUT type='hidden'  name='codigo_peso_$jj' value='$dbdatos_1->cod_pes_ddent'><span  class='textfield01'> $dbdatos_1->nom_pes </span> </td>";
						
						//cantidad
						echo "<td align='right'><INPUT type='hidden'  name='cantidad_ref_$jj' value='$dbdatos_1->cant_ddent'><span  class='textfield01'>".number_format($dbdatos_1->cant_ddent ,0,",",".")."  </span> </td>";	
						
						//costo
						echo "<td align='right'><INPUT type='hidden'  name='costo_ref_$jj' value='$dbdatos_1->cos_ddent'><span  class='textfield01'>".number_format($dbdatos_1->cos_ddent ,0,",",".")."  </span> </td>";	
						
						//boton q quita la fila
						echo "<td><div align='center'>	
<INPUT type='button' class='botones' value='  -  ' onclick='removerFila_entrada(\"fila_$jj\",\"val_inicial\",\"fila_\",\"$dbdatos_1->cos_ddent\");'>
						</div></td>";
						echo "</tr>";
						$jj++;
					}
				}
				?>
				</table>			</td>
			</tr>			
		 <tr >
		  <td  colspan="9">
			  <table width="100%">
				<tr >
				<td  class="ctablasup"><div align="right">Resumen Entrada </div></td>
				</tr>
				<tr >
				<td ><div align="right" >Total  Compra:
				    <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->total_mdent; else echo "0"; ?>"/>
				</div>				  </td>
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
	</td>
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
