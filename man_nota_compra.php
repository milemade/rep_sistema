<?PHP include("js/funciones.php")?>
<?PHP include("lib/database.php")?>
<?PHP
if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS

	$compos="(cod_tpro_aju, cod_mar_aju, cod_pes_aju, cod_ref_aju, cod_bod_aju, cod_fry_aju ,fec_aju, cant_aju,obs_aju)";

	$valores="('".$tipo_producto."','".$marca."','".$peso."','".$combo_referncia."','".$bodega."','".$codigo_fry."','".$fecha."','".$cantidad."','".$observaciones."')" ;


	//kardex("resta",$combo_referncia,$bodega,$cantidad,0,$peso);

	

	$error=insertar("ajuste",$compos,$valores);

	if($error==1)

	{

		header("Location:con_abono.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 

	}

	else 

	{

		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 

	}

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

	if (document.getElementById('cod_factura').value == ""  )    

		return false;

	else

		return true;		

}

</script>



<script type="text/javascript" src="js/js.js"></script>

</head>

<body <?=$sis?>>

<div id="total">

<form  name="forma" id="forma" action="man_nota_compra_det.php"  method="post">

<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >

  <tr>

   <td bgcolor="#E9E9E9" >

   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 

      <tr>

        <td width="5" height="30">&nbsp;</td>

        <td width="20" ><img src="imagenes/siguiente.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>

        <td width="61" class="ctablaform">Siguiente</td>

        <td width="21" class="ctablaform"><a href="con_abono.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>

        <td width="65" class="ctablaform">Cancelar </td>

        <td width="22" class="ctablaform"><a href="con_abono.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>

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

    <td class="textotabla01">NOTA A COMPRA:</td>

  </tr>

  <tr>

    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>

  </tr>

  <tr>

    <td bgcolor="#E9E9E9" valign="top">

	<table width="622" border="0" cellspacing="0" cellpadding="0">

       <tr>

        <td width="51" class="textotabla1">Factura:</td>

        <td width="144"><?PHP

		$sql="SELECT 
		m_entrada.cod_ment,
		m_entrada.total_ment,
		m_entrada.cod_prove_ment,
		proveedor.nom_pro,
		m_entrada.fac_ment,

  CONCAT(fac_ment,'--', nom_pro) as factura 
  FROM   m_entrada
  INNER JOIN proveedor ON (m_entrada.cod_prove_ment = proveedor.cod_pro) 
  where est_ment<>'anulado' and  est_ment<>'CANCELADA' AND  remision='0' order by nom_pro ,  fac_ment desc"; 

		combo_sql  ("cod_factura","m_entrada","cod_ment","factura","",$sql);


		?>
		</td>

        <td width="17" class="textorojo">*</td>

        <td width="92" class="textotabla1">&nbsp;</td>

        <td width="377">&nbsp;</td>

       </tr>

	   <tr>

         <td height="31" class="textotabla1">&nbsp;</td>

         <td>&nbsp;</td>

         <td>&nbsp;</td>

         <td class="textotabla1">&nbsp;</td>

         <td  valign="top">&nbsp;</td>

       </tr>

       



	   <tr>

         <td colspan="5" class="textotabla1" >

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

<input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">

<input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">

<input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">

<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />

</form> 

</div>





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

