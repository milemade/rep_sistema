<? session_start();?>
<? include("lib/database.php")?>
<? include("js/funciones.php");
//print_r($_SESSION);
$ahora = date("Y-n-j H:i:s");
$_SESSION["ultimoAcceso"] = $ahora;
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

function datos_completos_sigue()
{  
	
	var confirmar = buscar_facturas();
	if (confirmar==1)
	{
		alert("Este Numero de Factura Ya Existe, Por Favor Verifique")
		return false;
	}
	
	if (document.getElementById('empresa').value > 0 && document.getElementById('fecha_venta').value != "" && document.getElementById('numero_factura_tela_d').value > ""
	
	 ) {
		document.forma.submit();
	}
	else {
		alert('Complete el Formulario, Gracias')
	}

}


function buscar_facturas(){
var vec_datos_total = new Array;
<?
$dbdatos= new  Database();
$sql="select num_fac from m_factura order by num_fac";
$dbdatos->query($sql);
$i=0;
while($dbdatos->next_row()) {
echo "vec_datos_total[$i]=  new Array('$dbdatos->num_fac');\n";
$i++;
}
?>
var confirmar=0;
for(i=0;i<=vec_datos_total.length;i++)
{
	if(document.getElementById('numero_factura_tela_d').value==vec_datos_total[i])
	{
		confirmar=1;
	}
}

return confirmar;
}
</script>

<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_venta.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/siguiente.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="datos_completos_sigue()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Continuar</td>
        <td width="21" class="ctablaform"><a href="con_venta.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"></a></td>
        <td width="70" class="ctablaform">&nbsp;</td>
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
    <td class="textotabla01">FACTURA DE VENTA  :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="84" class="textotabla1">Empresa:</td>
        <td width="182" class="textotabla1">
          <?
		
		$sql="select distinct punto_venta.cod_rso as valor , nom_rso as nombre from punto_venta  inner join  rsocial  on punto_venta.cod_rso=rsocial.cod_rso where cod_ven=$global[2]";
		
		
		 combo_sql("empresa","rsocial","valor","nombre",$dbdatos_edi->nom_rso,$sql); 
		 
		 
		 ?>        </td>
        <td width="17" class="textorojo">*</td>
        <td width="55" class="textotabla1" valign="top">Cliente:</td>
        <td width="211"><? 
		
		
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
		
		$where_cli .= " cod_bod < 0 "; 
		
		$sql="select * from bodega1  order  by nom_bod ";
		
		 combo_sql("cliente","bodega1","cod_bod","nom_bod",$dbdatos_edi->cod_bod,$sql); 
		
		?></td>
        <td width="201"><span class="textorojo">*</span></td>
       </tr>
      
       <tr>
         <td class="textotabla1">Bodega:</td>
         <td>
		 <?
		  $sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$global[2]";
		 combo_sql("bodega","rsocial","valor","nombre",$dbdatos_edi->cod_bod,$sql); 
		 ?></td>
         <td><span class="textorojo">*</span></td>
         <td width="55" class="textotabla1" valign="top">Fecha</td>
         <td><!--<input name="fecha_venta" type="text" class="fecha" id="fecha_venta" readonly="1" value="<? echo date("Y-m-d");  ?>"/>-->
           <input name="fecha_venta" type="text" class="fecha" id="fecha_venta" readonly="readonly" value="<?=$dbdatos->fec_ment ?>" />
           <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
         <td><span class="textorojo">*</span></td>
       </tr>
       
       
       <tr>
         <td class="textotabla1">No Factura:</td>
         <td><input name="numero_factura_tela_d" type="text" class="fecha" id="numero_factura_tela_d" onkeypress=" return validaInt()"/></td>
         <td><span class="textorojo">*</span></td>
         <td width="55" class="textotabla1" valign="top">&nbsp;</td>
         <td><!--<input name="fecha_venta" type="text" class="fecha" id="fecha_venta" readonly="1" value="<? echo date("Y-m-d");  ?>"/>--></td>
         <td><span class="textorojo">*</span></td>
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
	</td>
  </tr>
  
</table>
</form> 
</div>
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
</body>

</html>
