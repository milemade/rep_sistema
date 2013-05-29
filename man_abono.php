<? include("js/funciones.php")?>
<? include("lib/database.php")?>
<?
   include "conf/tiemposesion.php";
if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAR REGISTROS NUEVOS

	$compos="(cod_tpro_aju, cod_mar_aju, cod_pes_aju, cod_ref_aju, cod_bod_aju, cod_fry_aju ,fec_aju, cant_aju,obs_aju)";
	$valores="('".$tipo_producto."','".$marca."','".$peso."','".$combo_referncia."','".$bodega."','".$codigo_fry."','".$fecha."','".$cantidad."','".$observaciones."')" ;
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
	if (document.getElementById('val_abono').value == "" || document.getElementById('fecha_abo').value == "" || document.getElementById('cliente').value < 1 )    
		return false;
	else
		return true;		
}
</script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script type="text/javascript">
      $(function(){
        $("#forma").submit(function(){
          $.ajax({
            type:"POST",
            url:"man_abono.php",
            dataType:"php",
            data:$(this).serialize(),
            beforeSend:function(){
              $("#loading").show();
            },
            success:function(response){
                $("#response").html(response);
                $("#loading").hide();
            }

          })
          return false;
        })

      })
      </script>
</head>
<body <?=$sis?>>
<div id="total">
<script>
function validar()
{
  if(document.getElementById('cliente').value==0) 
  {
     alert('Debe seleccionar un cliente');
	 return false;
  }
  else 
    document.frm1.submit();
}
</script>
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/siguiente.png" alt="Nuevo Registro" width="16" height="16" border="0" onClick="validar();" style="cursor:pointer"/></td>
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
    <td class="textotabla01">ABONO A CARTERA:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<form  name="forma" id="forma" action="man_abono.php"  method="post">
	<table width="622" border="0" cellspacing="0" cellpadding="0" style="padding-top:10px;">
       <tr>
        <td width="51" class="textotabla1">Fecha:</td>
        <td width="144"><input name="fecha_abo" type="text" class="fecha" id="fecha_abo" readonly="1" value="<? echo date("Y-m-d");  ?>" /></td>
        <td width="17" class="textorojo">*</td>
        <td width="92" class="textotabla1">Cliente:</td>
        <td width="377"><select name="cliente" id="cliente" class='SELECT' onchange="document.forma.submit();">
		                <option value="0">[Seleccione]</option>
						<?php //Busca los clientes que tienen facturas a credito y estan en cartera factura
						  $dbcli = new Database();
						  $sqlcli = "SELECT DISTINCT (b.cod_bod), b.nom_bod
									 FROM `m_factura` a
									 JOIN bodega1 b ON a.cod_cli = b.cod_bod 
									 JOIN cartera_factura c ON a.cod_fac = c.cod_fac
									 WHERE a.tipo_pago='Credito' 
									 AND c.estado_car <> 'CANCELADA' AND c.estado_car <> 'anulado' ORDER BY b.nom_bod;";
                          $dbcli->query($sqlcli);									
						  while($dbcli->next_row())
						  {  $codcli = $dbcli->cod_bod;
						     if($cliente==$codcli)
							    $selected = "selected";
						     else
							    unset($selected);
						?>
						<option value="<?=$codcli?>" <?=$selected?>><?=$dbcli->nom_bod?></option>
						<? } $dbcli->close(); ?>			
		                </select><span class="textorojo">*</span></td>
       </tr>
	    
	   </form>
	   
	   <?  if($cliente>0) $none = "block"; else $none = "none";?>
	   <form name="frm1" id="frm1" action="man_liqui_abono.php" method="post">
	   <tr>
    <td colspan="4" class="textotabla1">Observaciones</td>
    <td><textarea name="observaciones" cols="40" rows="4" class="textfield02" ></textarea></td>
  </tr>
       <tr>
         <td colspan="5" class="textotabla1">
	 <table name="facs" id="facs" width="622" border="1" style="display:<?=$none?>">
      <tr>
        <td width="127" class="textotabla1"><div align="center">N° Factura</div></td>
		<td width="127" class="textotabla1"><div align="center">Saldo Factura</div></td>
        <td width="144" class="textotabla1"><div align="center">Valor Efectivo</div></td>
        <td width="144" class="textotabla1"><div align="center">Valor Cheque</div></td>
      </tr>
	  <?
	     $dbfc = new Database();
		 $sqlfc = "SELECT a.cod_fac,a.num_fac,a.tot_fac,b.valor_abono FROM `m_factura` a JOIN cartera_factura b ON a.cod_fac=b.cod_fac WHERE a.cod_cli=".$cliente." AND b.estado_car <> 'CANCELADA' AND b.estado_car <> 'anulado';";
		 $dbfc->query($sqlfc);
		 while($dbfc->next_row()){ $codfac = $dbfc->cod_fac; $totalfac = $dbfc->tot_fac - $dbfc->valor_abono; $numfac = $dbfc->num_fac;
	  ?>
      <tr>
        <td style="padding-left:32px;"><b><?=$numfac?></b></td>
		<td style="padding-left:32px;"><?=number_format($totalfac,0,".",".")?></td>
        <td><input type="text" name="val_abono_<?=$codfac?>" id="val_abono_<?=$codfac?>"  class="caja_resalte1" onkeypress="return validaInt_evento(this,'mas')" onblur="if(this.value==0) this.value='';"/></td>
        <td><input type="text" name="val_cheque_<?=$codfac?>" id="val_cheque_<?=$codfac?>"  class="caja_resalte1" onkeypress="return validaInt_evento(this,'mas')" onblur="if(this.value==0) this.value='';"/></td>
		<input type="hidden" name="totalfac_<?=$codfac?>" value="<?=$$totalfac?>">
      </tr>
	  <? } ?>
    </table></td>
         </tr>
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
<input type="hidden" name="cliente" id="cliente" value="<?=$cliente?>">
<input type="hidden" name="fecha" id="fecha" value="<?=$fecha_abo?>">

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

