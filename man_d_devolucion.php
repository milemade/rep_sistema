<? include("lib/database.php")?>
<? include("js/funciones.php")?>

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
	if (document.getElementById('num_factura').value > 0 ) {
		document.forma.submit();
	}
	else {
		alert('Complete el Formulario, Gracias')
	}

}


</script>

<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_devolucion.php"  method="post">
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
    <td class="textotabla01">DEVOLUCION DE FACTURA  :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="84" class="textotabla1">No Factura:</td>
        <td width="182" class="textotabla1">
		
		
		<? 
		
		$where_cli="";
		$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$global[2]";
		$dbdatos= new  Database();
		$dbdatos->query($sql);	
		$where_cli="";
		while($dbdatos->next_row())
		{
			$where_cli .= "bodega1.cod_bod_cli= ".$dbdatos->valor  ;
			$where_cli .= " or ";
		}		
		$where_cli .= " bodega1.cod_bod < 0 "; 

		if($det==0)
			$where.=" where cod_fac>0   and  ( $where_cli )  ";

	 	$sql="select * , bodega1.nom_bod AS nom_cliente , cod_fac AS valor, concat(num_fac,' - ',bodega1.nom_bod ,' - (',bodega.nom_bod,')') AS nombre 
from m_factura  left join usuario on usuario.cod_usu=m_factura.cod_usu   left join bodega1 on bodega1.cod_bod=m_factura.cod_cli  left join bodega on bodega.cod_bod =m_factura.cod_bod    where cod_fac>0 and ( bodega1.cod_bod_cli= 225 or bodega1.cod_bod < 0 )   and (select valor_abono from cartera_factura where cartera_factura.cod_fac=m_factura.cod_fac) <1  ORDER BY cod_fac DESC  ";

		//exit;
		//$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$global[2]";
	//	$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$global[2]";
		
		
	    combo_sql("num_factura","bodega","valor","nombre",$dbdatos->cod_bod,$sql); 
		//combo_evento("num_factura","m_factura","cod_fac"," num_fac ","","", "num_fac desc"); 
		
		?>
		</td>
        <td width="17" class="textorojo">*</td>
        <td width="55" class="textotabla1" valign="top">&nbsp;</td>
        <td width="211">&nbsp;</td>
        <td width="201">&nbsp;</td>
       </tr>
       <tr>
         <td class="textotabla1">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td width="55" class="textotabla1" valign="top">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
	   <tr>
         <td colspan="6" class="textotabla1" >     	   
	</table>		  
	    </td>
	  </tr>
	  <tr> 
		<td colspan="8" >		  
		</td>
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
</body>
</html>
