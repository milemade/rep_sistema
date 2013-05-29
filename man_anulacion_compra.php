<?php include("lib/database.php")?>
<?PHP include("js/funciones.php"); print_r($_POST);?>
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
<?PHP inicio() ?>
<script language="javascript">
function datos_completos_sigue()
{  
	if(confirm("¿Esta seguro de Anular esta Factura?.")) 
	{
		document.forma.submit();		
	} 
}
</script>
<?PHP
if($anular==1 && $codigo>0) 	{ // RUTINA PARA  ANULAR     
    //echo "ENTRA";
	$db6 = new Database();
	$sql = "  update m_entrada set est_ment='anulado' WHERE cod_ment=$codigo ";
	$db6->query($sql);	
	echo "<br>";
	$sql = "delete from cartera_compras WHERE cod_doc_ccom=$codigo ";
	$db6->query($sql);	
	//exit;
	echo " <script language='javascript'>window.location = 'con_anulacion.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar'; </script> "; 
    header("Location: con_anulacion.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
}
if ($codigo!=0) {
	$dbdatos_edi= new  Database();
	 $sql ="select * from  m_entrada a INNER JOIN proveedor b ON a.cod_prove_ment = b.cod_pro where a.cod_ment=$codigo";
	 $dbdatos_edi->query($sql);
	$dbdatos_edi->next_row();
}
?>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="informes/inf.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_anulacion_compra.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Anular Factura" width="16" height="16" border="0" onClick="datos_completos_sigue()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Anular</td>
        <td width="21" class="ctablaform"><a href="con_anulacion_compra.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
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
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" /> 
		  <input type="hidden" name="anular" id="anular" value="1">
		  </td>
          <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">ANULACION DE FACTURA  :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="147" class="textotabla1">No Factura:
          <?=$dbdatos_edi->fac_ment ?></td>
        <td width="119" class="textotabla1"><a href="#">
		<img src="imagenes/mirar.png" alt="Cancelar" width="16" height="16" border="0"   onclick="imprimir_inf('inf_cargue.php',<?=$codigo?>,'grande')"/>
		</a>
         &nbsp;</td>
        <td width="17" class="textorojo">*</td>
        <td width="55" class="textotabla1" valign="top">Proveedor</td>
        <td width="211"><span class="textotabla1">
          <?=$dbdatos_edi->nom_pro?>
        </span></td>
        <td width="201">&nbsp;</td>
       </tr>
       <tr>
         <td class="textotabla1">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td width="55" class="textotabla1" valign="top">Valor</td>
         <td><span class="textotabla1">
           <?=$dbdatos_edi->total_ment?>
         </span></td>
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