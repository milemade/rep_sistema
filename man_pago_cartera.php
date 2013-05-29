<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?

if ($codigo!="") { // BUSCAR DATOS

	$sql ="SELECT  che_pag, obs_pag, fec_pag, val_pag  FROM m_pago_cartera WHERE cod_pag=$codigo";		
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	

	$compos="(che_pag, obs_pag, fec_pag, val_pag)";
	$valores="('".$cheque."','".$observaciones."','".$fecha."','".$todocompra2."')" ;
	$ins_id=insertar_maestro("m_pago_cartera",$compos,$valores); 	

	if ($ins_id > 0) 
	{
		for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 
		{
			if ( $_POST["chek_pago_".$ii]!="") 	
			{
				$sql ="UPDATE m_cargue SET pagado= '1',cod_car_pag= $ins_id  WHERE  cod_carg='".$_POST["codigo_cargue_".$ii]."'";		
				$dbdatos->query($sql);
			}	
		}
		header("Location: con_pago_cartera.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}

else
	echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 	

}


if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 
	
	$compos="che_pag='".$cheque."', obs_pag='".$observaciones."', fec_pag='".$fecha."', val_pag='".$todocompra2."'";
	$error=editar("m_pago_cartera",$compos,'cod_pag',$codigo); 
	
	for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 
	{
		if ( $_POST["chek_pago_".$ii]=="" and $_POST["codigo_cargue_".$ii]!="") 	
			{
				$sql ="UPDATE m_cargue SET pagado= '0',cod_car_pag= '0'  WHERE  cod_carg='".$_POST["codigo_cargue_".$ii]."' and  cod_car_pag='".$codigo."'";		
				$dbdatos->query($sql);
			}
	}

		
	if ($error==1) {
		header("Location: con_pago_cartera.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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

if (document.getElementById('fecha').value == "" || document.getElementById('todocompra2').value == 0 || document.getElementById('cheque').value == "" )
	return false;
else
	return true;		
}


function evualuar(cajita){
//alert(document.getElementById('chek_pago_'+cajita).value)
if(document.getElementById('chek_pago_'+cajita).checked==true) 
{
	document.getElementById('todocompra2').value= parseInt(document.getElementById('todocompra2').value) + parseInt(document.getElementById('chek_pago_'+cajita).value);
}	
else 
{
	document.getElementById('todocompra2').value=parseInt(document.getElementById('todocompra2').value) - parseInt(document.getElementById('chek_pago_'+cajita).value);
}

//alert(document.getElementById('valor_cargue_'+cajita).value)
}

</script>

<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_pago_cartera.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_pago_cartera.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_pago_cartera.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>
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
    <td class="textotabla01">CARGUE DIARIO :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="90" class="textotabla1">Fecha:</td>
        <td width="286">
          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_pag ?>" />
          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td width="8" class="textorojo">*</td>
        <td width="95" class="textotabla1">Num Cheque: </td>
        <td width="148"><input name="cheque" id="cheque" type="text" class="textfield2"  value="<?=$dbdatos->che_pag?>" /></td>
		 
        <td width="17" class="textorojo">&nbsp;</td>
        <td width="80" class="textorojo">&nbsp;</td>
       </tr>
      
       <tr>
         <td class="textotabla1">Observaicones</td>
         <td rowspan="2">
<textarea name="observaciones" cols="45" rows="4" class="textfield02"  onchange='buscar_rutas()' ><?=$dbdatos->obs_pag?></textarea>
</td>
         <td>&nbsp;</td>
         <td rowspan="2" class="textotabla1">Total Pago </td>
         <td colspan="3" rowspan="2"><input name="todocompra2" id="todocompra2" type="text" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->val_pag; else echo "0"; ?>"/></td>
       </tr>
       
	         <tr>
         <td class="textotabla1">&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
       
	   
	   <tr>
        <td colspan="7" class="textotabla1" >
		<table  width="100%" border="1">
		      
		  <tr >
		  <td width="61%">
		  
		  
		  
			  <table width="100%">
				<tr id="fila_0">
				<td  class="ctablasup" >Fecha</td>
				<td  class="ctablasup" >Vendedor</td>
				<td  class="ctablasup" >Valor</td>
				<td  class="ctablasup" >Numero</td>
				<td  class="ctablasup" >Pagar</td>
				</tr>
				<?

				if ($codigo!=0) 
					$sql ="SELECT cod_carg,cod_ven_carg,fec_carg,total_comp_carg,num_fac ,nom_ven FROM m_cargue INNER JOIN vendedor ON vendedor.cod_ven=cod_ven_carg WHERE pagado='1' and  cod_car_pag='$codigo' order by cod_carg";//=
				
				if ($codigo ==0) 
					$sql ="SELECT cod_carg,cod_ven_carg,fec_carg,total_comp_carg,num_fac ,nom_ven FROM m_cargue INNER JOIN vendedor ON vendedor.cod_ven=cod_ven_carg WHERE pagado='0' order by cod_carg";//=
				
				
				if (!empty($sql) ) { // BUSCAR DATOS
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					//echo "<table width='100%'>";
					while($dbdatos_1->next_row()){ 
						$ultimo_id=$dbdatos_1->cod_carg;
						echo "<tr id='fila_$jj'>";
						//fecha de la factura
						echo "<td align='left'>
						<INPUT type='hidden'  name='codigo_cargue_$jj' value='$dbdatos_1->cod_carg'>
						<INPUT type='hidden'  name='valor_cargue_$jj' value='$dbdatos_1->total_comp_carg'>
						<span  class='textfield01'>$dbdatos_1->fec_carg</span> </td>";
						
						//vendedor
						echo "<td  align='left' ><span class='textfield01'> $dbdatos_1->nom_ven</span> </td>";	
						
						//valor factura
						echo "<td  align='right' ><span  class='textfield01'>$ ".number_format($dbdatos_1->total_comp_carg,0,",",".")."</span> </td>";
						
						//numero factura
						echo "<td  align='right' ><span  class='textfield01'> $dbdatos_1->num_fac </span> </td>";
						
						//boton de pagar o de eliminar
						if ($codigo !=0) 
							echo "<td><div align='center'>	
							<input type='checkbox' name='chek_pago_$jj' id='chek_pago_$jj' value='$dbdatos_1->total_comp_carg' onclick='evualuar($jj)'  checked='checked' /></div></td>";
						
						if ($codigo ==0) 
							echo "<td><div align='center'>	
							<input type='checkbox' name='chek_pago_$jj' id='chek_pago_$jj' value='$dbdatos_1->total_comp_carg' onclick='evualuar($jj)' /></div></td>";
						
						echo "</tr>";
						
						$jj++;
						
					}
					
				}
				?>
				</table>			</td>
			</tr>
			
		 <tr >
		  <td>&nbsp;</td>
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
	  <p>
	    <input type="hidden" name="val_inicial" id="val_inicial" value="<?=$ultimo_id?>" />
	    <input type="hidden" name="guardar" id="guardar" />
	    <?  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
	      <input type="hidden" id="valDoc_inicial" value="<?=$valueInicial?>"> 
	      <input type="hidden" name="cant_items" id="cant_items" value=" <?  if ($codigo!="") echo $aa; else echo "0"; ?>">
	  </p>
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
