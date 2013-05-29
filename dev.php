 
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
 
<script type="text/javascript" src="calendario/javascript/calendar.js"></script>
	<script type="text/javascript" src="calendario/javascript/calendar-es.js"></script>
	<script type="text/javascript" src="calendario/javascript/calendar-setup.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="calendario/styles/calendar-win2k-cold-1.css" title="win2k-cold-1" />
	<link href="css/styles.css" rel="stylesheet" type="text/css" /> 
	<script type="text/javascript" src="js/funciones.js"></script> 
<script language="javascript"> 
 
 
function datos_completos(){ 
 
 
	if( document.getElementById('todocompra').value < -1) {
		alert('No Valor en la Devolucion')
		return false;
	}
		
	if (document.getElementById('todocompra').value == ""){	
		return false;
	}
	else 
		return true;
 
}
 
 

function crear_descuento(div_caja,caja,val_uni,span_desc,boton_crear, div_guardar){
	document.getElementById(boton_crear).style.display='none';
	document.getElementById(div_guardar).style.display='inline';
	document.getElementById(span_desc).style.display='none';
	document.getElementById(div_caja).style.display='inline';
//crear_descuento(\"div_caja_desc_$jj\",\"caja_cant_desc_$jj\",\"$dbdatos_1->val_uni\",\"span_crear_desc_$jj\",\"boton_desc_$jj\")
}
 
function guardar_descuento(div_caja,caja,val_uni,span_desc,boton_crear, div_guardar,cant_ori,letrero_span){
 alert(cant_ori)
 alert(parseInt(document.getElementById(cant_ori).value))
	/*
	
 if ( parseInt(document.getElementById(cant_ori).value) < parseInt(document.getElementById(caja).value) ){
		alert('Cantidad No permitida, Verifique')
		return false;
	}
	 
	document.getElementById("todocompra").value = parseInt(document.getElementById("todocompra").value) - parseInt((val_uni * document.getElementById(letrero_span).value) );
	document.getElementById(boton_crear).style.display='inline';
	document.getElementById(div_guardar).style.display='none';
	document.getElementById(span_desc).style.display='inline';
	document.getElementById(div_caja).style.display='none';
	document.getElementById(letrero_span).value=document.getElementById(caja).value;
	 
	document.getElementById("todocompra").value = parseInt(document.getElementById("todocompra").value) + parseInt((val_uni * document.getElementById(letrero_span).value));*/

}
 
 
</script>
 
<script type="text/javascript" src="js/js.js"></script>
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<link href="informes/styles.css" rel="stylesheet" type="text/css" />
</head>
<body >
<div id="total">
<form  name="forma" id="forma" action="man_devolucion.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=1&insertar=1&eliminar=1"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=1&insertar=1&eliminar=1"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>
        <td width="70" class="ctablaform">Consultar</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">
 
          <input type="hidden" name="editar"   id="editar"   value="1">
		  <input type="hidden" name="insertar" id="insertar" value="1">
		  <input type="hidden" name="eliminar" id="eliminar" value="1">
          <input type="hidden" name="codigo" id="codigo" value="5261" /> </td>
        
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">FACTURACION :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td width="62" class="textotabla1">Fecha:</td>
        <td width="275" class="subtitulosproductos">2011-02-19          <input name="fecha_fac" id="fecha_fac" type="hidden" value="2011-02-19"  /></td>
        <td width="20" class="textorojo">*</td>
        <td width="77" class="textotabla1">Vendedor:</td>
        <td width="145"  class="subtitulosproductos">
		RUBEN DARIO		<input name="vendedor" id="vendedor" type="hidden" value="5"></td>		 
        <td width="171" class="textorojo">&nbsp;</td>
       </tr>
	   <tr>
        <td width="62" class="textotabla1">Empresa:</td>
        <td width="275" class="subtitulosproductos">
		THE SPORT SHOP / RUBEN SARMIENTO		<input name="empresa" id="empresa" type="hidden" value="15"></td>
        <td width="20" class="textorojo">*</td>
        <td width="77" class="textotabla1"> Bodega:</td>
        <td class="subtitulosproductos"><span class="textoproductos1">
          ALMACEN 7 AGOSTO          <input name="bodega_fac" id="bodega_fac" type="hidden" value="225">
        </span></td>		 
        <td width="171" >
			<input name="numero_factura" id="numero_factura" type="hidden" value="5261" />
		</td>
       </tr>
	   <tr>
        <td width="62" class="textotabla1">Cliente:</td>
        <td width="275" class="subtitulosproductos">
		ANDRES LOPEZ  /  DELTA SPORT		<input name="cliente_fac" id="cliente_fac" type="hidden" value="251"></td>
        <td width="20" class="textorojo">*</td>
        <td width="77" class="textotabla1">&nbsp;</td>
        <td colspan="2"><div id="cupo" style="display:none">
          <span class="textotabla1">Cupo:<span class="textorojo">
          <input name="cupo_credito" id="cupo_credito" type="text" class="caja_resalte1"  readonly="-1"/>
          </span></span>		  </div>		  
		<span  id="div_credito" style="display:none" class="textoproductos1"> 
		$  0		<input name="cupo_covinoc" type="hidden" id="cupo_covinoc"  value="0" readonly="-1" align="right"/>
		</span></td>		 
        </tr>
	   <tr>
        <td colspan="7" class="textotabla1" >
		<table  width="100%" border="1">
		      
		  <tr >
		  <td width="4%">
			  <table width="100%">
				<tr id="fila_0">
				
				<td width="20%"  class="ctablasup">Referencia</td>
				<td width="13%"  class="ctablasup">Codigo</td>
				<td width="9%"   class="ctablasup">Talla</td>
				<td width="10%"  class="ctablasup">Cantidad</td>
				<td width="7%"  class="ctablasup">Valor</td>
				<td width="13%"   class="ctablasup">Opcion</td>
				<td width="21%"    class="ctablasup">Cantidad Dev. </td>
				
				</tr>
				<tr id='fila_1'><td >
				 <INPUT type='hidden'  name='codigo_mfac_1' value='5261'> 
				 <INPUT type='hidden'  name='codigo_det_fac_1' value='12280'> 
				 <INPUT type='hidden'  name='codigo_referencia_1' value='348'>
				 <span  class='textfield01'> MEDIA FUTBOL PROF </span> </td><td ><span  class='textfield01'> MFC0002 </span> </td>
				 <td >
				 <INPUT type='hidden'  name='codigo_peso_1' value='21'>
				 <span  class='textfield01'> NEGRA </span> </td><td align='right'>
				 <INPUT type='text'  name='cantidad_ref_1'  name='cantidad_ref_1' value='1'>
				 <span  class='textfield01'>1  </span> </td><td align='right'>
				 <INPUT type='hidden'  name='costo_ref_1' value='3500'>
				 <span  class='textfield01'>3.500  </span> </td><td>
						<div align='center'>	
<INPUT type='button' class='botones' value='Descontar' id='boton_desc_1' onclick='crear_descuento("div_caja_desc_1","caja_cant_desc_1","3500","span_crear_desc_1","boton_desc_1","div_actua_1" );'>
						</div>
						
						
						<div align='center' style='display:none' id='div_actua_1'>	
<INPUT type='button' class='botones' value='Actualizar' id='boton_actua_1' onclick='guardar_descuento("div_caja_desc_1","caja_cant_desc_1","3500","span_crear_desc_1","boton_desc_1","div_actua_1" ,"cantidad_ref_1" ,"valor_span_1" );'> 
						</div>
						</td><td>
								<table width='100%'>
									<tr>
										<td >
										 	<div style='display:none' id='div_caja_desc_1'>
										 		<input name='caja_cant_desc_1' id='caja_cant_desc_1' type='text' class='textfield01'  value='0'   onkeypress='return validaInt(this)' />
										 	</div>
										 </td>
										 <td  style='display:inline'>
										 	<div id='span_crear_desc_1' >
											<input name='valor_span_1' id='valor_span_1' type='text' class='botones'  value='0' readonly='-1'/>
											</div>
										 </td>
									</tr>
								</table>
						 </td></tr>				</table>			</td>
			</tr>			
		 <tr >
		  <td>
			  <table width="100%">
				<tr >
				<td  class="ctablasup"><div align="left">Observaciones:</div></td>
				<td  class="ctablasup"><div align="right">Resumen Venta </div></td>
				</tr>
				<tr >
				<td width="47%" ><div align="left" >
				  <textarea name="observaciones" cols="45" rows="3" class="textfield02"></textarea>
				</div>				  </td>
				<td width="53%" ><div align="right"><span class="ctablasup">Total  Descuento:</span>
 <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="1"  value="0 "/>
				  </div></td>
				</tr>
				</table>			  </td>
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
	<input type="hidden" name="val_inicial" id="val_inicial" value="1" />
	<input type="hidden" name="guardar" id="guardar" />
		 	   <input type="hidden" id="valDoc_inicial" value=""> 
	   <input type="hidden" name="cant_items" id="cant_items" value=" ">
	</td>
  </tr>
  
</table>
</form> 
</div>
</body>
</html>

