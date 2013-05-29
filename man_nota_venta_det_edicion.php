<? include("js/funciones.php")?>
<? include("lib/database.php")?>
<? include "conf/tiemposesion.php"; ?>
<? $dbdatos= new  Database();
   if ($codigo!="") 
   {
      $sql ="select * 
	          from notas_ventas 
			 inner join `m_factura` on  notas_ventas.`cod_ven_notc`=m_factura.`cod_fac` 
			 INNER JOIN cartera_factura ON (m_factura.cod_fac = cartera_factura.cod_fac) 
			 inner join bodega1 on bodega1.`cod_bod`=`m_factura`.`cod_cli` where cod_notc= '$codigo' ";		
	  $dbdatos->query($sql);	
	  $dbdatos->next_row();
   }//echo $codigo_factura."----".$valor_nota;
   if($codigo_factura>0 and $valor_nota>0) 	
   { /* RUTINA PARA  INSERTAR REGISTROS NUEVOS	*/
       $ahora = date("Y-n-j H:i:s");
       $_SESSION["ultimoAcceso"] = $ahora;   
       $compos="fec_notc='".$fecha."',val_notc='".$valor_nota."' ,obs_notc='".$observaciones."' ";	$error=editar("notas_compra",$compos,'cod_notc',$codigo);				
	   $actual_valor= $saldo_actual- $saldo_anterior;	
	   $sql ="update cartera_factura set valor_abono='$actual_valor' where cod_fac='$codigo_factura'";	
	   $dbdatos->query($sql); 			
	   $actual_valor=$actual_valor + $valor_nota;	
	   $sql =" update cartera_factura set valor_abono='$actual_valor' where cod_fac='$codigo_factura'";	
	   $dbdatos->query($sql); 			
	   if($error==1)	
	   {		
	      header("Location:con_nota_venta.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 	
	   }	
	   else 	
	   {		
	      echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 	
	   }
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
body 
{	
   margin-left: 0px;	
   margin-top: 0px;	margin-right: 0px;	
   margin-bottom: 0px;
}
.Estilo1 
{
  font-size: 12px
}
</style> 
<? inicio() ?>
<script language="javascript">
function datos_completos()
{  	
   if (document.getElementById('codigo_factura').value == "" ||  document.getElementById('valor_nota').value == "" ||  
       document.getElementById('fecha').value == "" )    		
	 return false;	
   else		
     return true;		
}
</script>
<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_nota_venta_det_edicion.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >  
<tr>   
<td bgcolor="#E9E9E9" >   
    <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" >       
	<tr>        
	<td width="5" height="30">&nbsp;</td>        
	<td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onclick="cambio_guardar()" style="cursor:pointer"/></td>        
	<td width="61" class="ctablaform">Guardar</td>        
	<td width="21" class="ctablaform"><a href="con_abono.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>        
	<td width="65" class="ctablaform">Cancelar </td>        
	<td width="22" class="ctablaform"><a href="con_abono.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>        
	<td width="70" class="ctablaform">Consultar</td>        
	<td width="21" class="ctablaform"></td>        
	<td width="60" class="ctablaform">&nbsp;</td>        
	<td width="24" valign="middle" class="ctablaform">&nbsp;</td>        
	<td width="193" valign="middle"><input type="hidden" name="editar" id="editar" value="<?=$editar?>">		  
	                                <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">		  
									<input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">          
									<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" /> </td>                
	<td width="67" valign="middle">&nbsp;</td>      
	</tr>    
	</table>	
</td>  
</tr>  
<tr>    
<td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td></tr>  
<tr><td class="textotabla01">NOTA CREDITO VENTA:</td></tr>  
<tr><td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td></tr>  
<tr><td bgcolor="#E9E9E9" valign="top">	
   <table width="622" border="0" cellspacing="0" cellpadding="0">       
   <tr>        
   <td width="96" class="textotabla1">Factura No:</td><td width="144"><input name="dir" id="dir" type="text" class="textfield2" value="<?=$dbdatos->num_fac?>" readonly="-1" /></td>        
   <td width="13" class="textorojo">&nbsp;</td>        <td width="94" class="textotabla1">Proveedor</td>        
   <td width="275"><input name="dir2" id="dir2" type="text" class="textfield2"  value="<?=$dbdatos->nom_bod?>" readonly="-1"/></td></tr>	      
   <tr><td width="96" class="textotabla1">Valor Factura:</td>        
   <td width="144"><input name="dir3" id="dir3" type="text" class="textfield2"  value="<?=$dbdatos->tot_fac?>" readonly="-1"  /></td>        
   <td width="13" class="textorojo">&nbsp;</td>        <td width="94" class="textotabla1">Saldo Factura:</td>        
   <td width="275"><input name="saldo_factura" id="saldo_factura" type="text" class="textfield2" value="<?=$dbdatos->tot_fac - $dbdatos->valor_abono?>" readonly="-1"  />          
   <input name="saldo_actual" id="saldo_actual" type="hidden"  value="<?=$dbdatos->valor_abono?>"></td></tr>	      
   <tr>        
   <td width="96" class="textotabla1">&nbsp;</td>        
   <td width="144">&nbsp;</td>        
   <td width="13" class="textorojo">&nbsp;</td>        
   <td width="94" class="textotabla1">&nbsp;</td>        
   <td width="275"><input name="codigo_factura" id="codigo_factura" type="hidden"  value="<?=$dbdatos->cod_fac?>" />		
   <input name="saldo_anterior" id="saldo_anterior" type="hidden"  value="<?=$dbdatos->val_notc?>"  /></td></tr>	      
   <tr>        
   <td width="96" class="textotabla1">Valor Nota :</td>        
   <td width="144"><input name="valor_nota" id="valor_nota" type="text" class="textfield2"  onkeypress="return validaInt(this)"  value="<?=$dbdatos->val_notc?>" /></td>        
   <td width="13" class="textorojo">*</td>        
   <td width="94" class="textotabla1">&nbsp;</td>        
   <td width="275"><input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_notc?>" /><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td></tr>	   	   
   <tr><td height="31" class="textotabla1">Observaciones</td>         
   <td colspan="4"><textarea name="observaciones" cols="35" rows="3" class="textfield02"  ><?=$dbdatos->obs_notc?></textarea></td></tr>       	   
   <tr><td colspan="5" class="textotabla1" >          
   </table>		  	    
   </td>		 
</tr>	  
<tr> 		  
<td colspan="8" ></td></tr></table>
<tr><td>	
<input type="hidden" name="val_inicial" id="val_inicial" value="<? if($codigo!=0) echo $jj-1; else echo "0"; ?>" />	
<input type="hidden" name="guardar" id="guardar" />		 <?  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>	   
<input type="hidden" id="valDoc_inicial" value="<?=$valueInicial?>"> 	   
<input type="hidden" name="cant_items" id="cant_items" value=" <?  if ($codigo!="") echo $aa; else echo "0"; ?>">	   
<input name="neto" id="neto" type="hidden" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->net_comp_inv; else echo "0" ?>"/>      
<input name="todoiva" id="todoiva" type="hidden" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->iva_comp_inv; else echo "0"; ?>"/>      
<input name="todocompra" id="todocompra" type="hidden" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->total_comp_inv; else echo "0"; ?>"/></td>  </tr>  
</table>
<input type="hidden" name="editar" id="editar" value="<?=$editar?>">
<input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
<input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
</form> </div>
<div id="relacion" align="center" style="display:none" >
<!-- <div  id="relacion" align="center" >-->
<table width="413" border="0" cellspacing="0" cellpadding="0" bgcolor="#E9E9E9" align="center">   
<tr id="pongale_0" >    
<td width="81" class="textotabla1"><strong>Referencia:</strong></td>    
<td width="332" class="textotabla1"><strong id="serial_nombre_"> </strong>      
<input type="hidden" name="textfield3"  id="ref_serial_"/>	  <input type="hidden" name="textfield3"  id="campo_guardar"/></td></tr>      
<tr><td class="textotabla1" colspan="2"><div align="center">       
<input type="button" name="Submit" value="Guardar"  onclick="guardar_serial()"/>  	    
<input type="button" name="Submit" value="Cancelar"  onclick="limpiar()" id="cancelar" />         
<input type="hidden" name="textfield32"  id="catidad_seriales" value="0"/></div></td></tr>
</table>
</div>
<script type="text/javascript">		
Calendar.setup(	{			
   inputField  : "fecha",      			
   ifFormat    : "%Y-%m-%d",    			
   button      : "calendario" ,  			
   align       :"T3",			
   singleClick :true			
});
</script>
</body>
</html>
<?php $dbdatos->close(); ?>