<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?

if ($codigo!="") { // BUSCAR DATOS
	$sql ="SELECT  cod_sal,fec_sal, aut_sal ,mot_sal,cod_alm_sal, obs_sal, op_reint_sal , reint_sal, cod_proy_sal , cod_usu_sal  FROM salida WHERE cod_sal=$codigo and cod_proy_sal=$global[0]  ";		
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	if($reintegrado=="checkbox")
		$reintegrado=1;
	else 	
		$reintegrado=0;

	$compos="( fec_sal, aut_sal ,mot_sal,cod_alm_sal, obs_sal, op_reint_sal , reint_sal, cod_proy_sal , cod_usu_sal )";
	$valores="('".$fecha."','".$autoriza."','".$motivo."','".$almacen."','".$observaciones."','".$reintegra."','".$reintegrado."','".$global[0]."','".$global[2]."')" ;
	$ins_id=insertar_maestro("salida",$compos,$valores); 	
	
	if ($ins_id > 0) {
		$compos="( cod_tip_mae, cod_mov_mae , cod_ref_mae , cant_mae ,  cos_mae , tot_mae , cod_alm_mae  )";
		for ($ii=1 ;  $ii <= $cant_items + 1 ; $ii++) {
			if($_POST["codigo_".$ii]!=NULL) {
				$canti=intval($_POST["cantidad".$ii])* -1;
				$valores="(7,'".$ins_id."','".$_POST["codigo_".$ii]."','".$canti."','".$_POST["costo_".$ii]."','".$_POST["total".$ii]."',".$almacen.")" ;
				$error=insertar("maestro_movimiento",$compos,$valores); 
				actual_insertar_debitar($_POST["codigo_".$ii],$_POST["cantidad".$ii]);
				
				if ($_POST["text_serial_".$ii]!="") 
				{ 
					$separar = explode('|',$_POST["text_serial_".$ii]);
					$aa= count($separar);
					//echo $sql="DELETE from  maestro_serial  where tip_mov_ser=2 AND cod_mov_ser=$codigo ";
					$dbser= new  Database();	
					$dbser->query($sql);
					for ($j=0; $j<=$aa; $j++)
					{	
						if ($separar[$j]!="")
						{
							$sql= "INSERT INTO  maestro_serial  ( tip_mov_ser ,  cod_mov_ser ,  ser_ser,cod_ref_ser ,estado,cod_alm_ser ) VALUES( 7, $ins_id, '$separar[$j]',".$_POST["codigo_".$ii].",1,".$almacen.")";			
							$dbser->query($sql);
						}
					}
				}
			
			}
			
		}	
		header("Location: con_salida.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 	
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  EDITAR REGISTROS 
	
	if($reintegrado=="checkbox")
		$reintegrado=1;
	else 	
		$reintegrado=0;
	
	$compos="fec_sal='".$fecha."', aut_sal='".$autoriza."', mot_sal='".$motivo."',  cod_alm_sal='".$almacen."', obs_sal='".$observaciones."' ,op_reint_sal='".$reintegra."', reint_sal='".$reintegrado."' , cod_proy_sal='".$global[0]."' , cod_usu_sal='".$global[2]."'";
	$error=editar("salida",$compos,'cod_sal',$codigo); 
	reverzar_referencias_salidas ($codigo);
	
	$compos="( cod_tip_mae ,  cod_mov_mae ,  cod_ref_mae ,  cant_mae , cos_mae ,  tot_mae , cod_alm_mae )";
		for ($ii=0 ;  $ii <= $cant_items + 1 ; $ii++) 
		{
			if($_POST["codigo_".$ii]!=NULL) 
			{
				$canti=intval($_POST["cantidad".$ii])* -1;
				$valores="( 7 ,'".$codigo."','".$_POST["codigo_".$ii]."','".$canti."','".$_POST["costo_".$ii]."','".$_POST["total".$ii]."',".$almacen.")" ;
				$error=insertar("maestro_movimiento",$compos,$valores); 
				restar_referencias ($_POST["codigo_".$ii],$_POST["cantidad".$ii]);
			}
			//se guardan los seriales
			if ($_POST["text_serial_".$ii]!="") 
			{ 
				$separar = explode('|',$_POST["text_serial_".$ii]);
				$aa= count($separar);
				$sql="DELETE from  maestro_serial  where tip_mov_ser=7 AND cod_mov_ser=$codigo ";
				$dbser= new  Database();	
				$dbser->query($sql);
				for ($j=0; $j<=$aa; $j++)
				{	
					if ($separar[$j]!="")
					{
						$sql= "INSERT INTO  maestro_serial  ( tip_mov_ser ,  cod_mov_ser ,  ser_ser ,cod_ref_ser ) VALUES( 7, $codigo, '$separar[$j]',".$_POST["codigo_".$ii].")";			
						$dbser->query($sql);
					}
				}
			}
		}

	if ($error==1) {
		header("Location: con_salida.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

function buscar_detalles($codigo) {
	$sql ="SELECT cod_mae , cod_tip_mae ,  cod_mov_mae ,  cod_ref_mae ,  cant_mae , cos_mae ,  tot_mae ,referencia.des_ref  AS referenica 
			FROM maestro_movimiento INNER JOIN referencia ON maestro_movimiento.cod_ref_mae=referencia.cod_ref  WHERE cod_mov_mae=$codigo   AND cod_tip_mae=7 ";
	$dbdet= new  Database();
	$dbdet->query($sql);
	$aa=1;
	while($dbdet->next_row())
	{
		
		$relacion=buscar_serial($dbdet->cod_ref_mae,$codigo);
		echo " <tr id='filaDoc_$aa' > ";
		echo " <td  > <input type='hidden' name='codigo_$aa'  value='$dbdet->cod_ref_mae'> ";
		echo "<textarea name='text_serial_$aa' id ='text_serial_$aa'  style='display:none'>$relacion</textarea> ";  //AREA DONDE SE CARGAN LOS SERIALES
		echo " <input type='hidden' name='nombre_unico' id='nombre_unico' value='text_serial_$aa'>"; //CAJA Q GUARDA EL NOMBRE DEL TEXT AREA

		echo " $dbdet->referenica </td>";
		echo " <td > <input type='hidden' name='cantidad$aa'  value='$dbdet->cant_mae'>".number_format($dbdet->cant_mae * -1 ,2)." </td>";
		echo " <td > <input type='hidden' name='costo_$aa'  value='$dbdet->cos_mae'>".number_format($dbdet->cos_mae,2)."</td>";
		echo " <td > <input type='hidden' name='total$aa'  value='$dbdet->tot_mae'> ".number_format( $dbdet->tot_mae,2)."</td> ";
		echo " <td align='center' width='14%'><input type='button'  class='botones' value=' - '  onclick=\"removeDocCmp('filaDoc_$aa')\">";
		if ($relacion!="")
			echo "<input type='button'  class='botones' value=' ! '  onclick=\"ver_seriales($dbdet->cod_ref_mae,'$dbdet->referenica','text_serial_$aa')\"> ";
	
		echo "  </td>  </tr>";
		$aa++;
	}
return $aa -1  ;
}

function buscar_serial($referncia,$codigo) 
{
	//$relacion="";
	$dbserial= new Database();
	$sql="select * from maestro_serial  where tip_mov_ser=7 and cod_mov_ser=$codigo and cod_ref_ser=$referncia ";
	$dbserial->query($sql);
	$aux=0;
	while($dbserial->next_row())
	{
		$relacion=$relacion.$dbserial->ser_ser."|";
	}

$relacion=substr($relacion,0,strlen($relacion) -1) ;
return $relacion;
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
if (document.getElementById('fecha').value == "" || document.getElementById('cant_items').value == 0   )
	return false;
else
	return true;
}
</script>

<script language="javascript">
function  adicion() {
	var ref = document.getElementById('referencia').value;
	existencias_almacen (ref,'almacen');
	//existencias(ref); // vuelve a verificar las aexistencias de la referencia en el almacen
	//VERIFICA LA SELECCION DE LA REFERENCIA
	if (ref=='0') {
		alert('Seleccione la Referncia, Gracais')
		return false;
	}
	// COMPRA LO POSIBLES  MAXIMOS Y MINIMOS
	else {
		var cantidad_permitida=parseInt(document.getElementById('cant_act').value) - parseInt(document.getElementById('cantidad').value);
		var maximo=parseInt(document.getElementById('max').value) ;
		var ayuda=parseInt(document.getElementById('cant_act').value) - maximo;
		
		if(cantidad_permitida < 1 || document.getElementById('cant_almacen').value<1) {
			alert('El Almacen No cuenta con existencias' )
			return false;
		}
	}
	
	for(i=1 ;i <= parseInt(document.getElementById('cant_items').value); i++)
	{
		var newItem =  document.getElementById('codigo_' + i);
		if (newItem != null && newItem.value == ref){
			alert('Esta Referencia ya esta Relacionada, Seleccione Otra');
			return false;
		}
	}

	if (document.getElementById('referencia').value=="" || parseFloat(document.getElementById('cantidad').value)==0 || document.getElementById('cantidad').value=="") {
		alert("Complete los datos, Gracias")
		return false;
	}
	else {
		if (document.getElementById('serial').value!=0) {
			document.getElementById('relacion').style.display = 'inline';
			document.getElementById('total').style.display = 'none';
			relacion_serial(document.getElementById('cantidad').value,document.getElementById('referencia').value,document.getElementById('referencia').options[parseInt(document.getElementById('referencia').selectedIndex)].text);			
		}	
		if (document.getElementById('costo_prom').value == 0 ) {
			document.getElementById('total').value=0;
			document.getElementById('costo').value=0;		
		}	
		else {
			 document.getElementById('total').value = parseFloat(document.getElementById('cantidad').value) * parseFloat(document.getElementById('costo_prom').value);	
		}
		
		addDocCmp(document.getElementById('referencia').value, document.getElementById('referencia').options[parseInt(document.getElementById('referencia').selectedIndex)].text,document.getElementById('cantidad').value ,document.getElementById('total').value,document.getElementById('costo_prom').value,document.getElementById('serial').value)
		document.getElementById('cantidad').value="";
		document.getElementById('total').value="";
		document.getElementById('costo').value="";
	}
}

function  existencias_almacen (valor,objeto){
var cantidad=<?=$contador- 1?>;
var alamcen=document.getElementById(objeto).value
var referencia=valor;
var aux=0;

<?
$sql =" SELECT SUM(cant_mae) AS suma, cod_ref_mae, cod_alm_mae FROM maestro_movimiento WHERE cod_alm_mae<>\"\"  GROUP by cod_alm_mae ,cod_ref_mae order by cod_alm_mae";		
$dbdatos1= new  Database();
$dbdatos1->query($sql);
$contador=0;
?>
<? while($dbdatos1->next_row()) { ?>
var lll_<?=$contador?> = new Array();
lll_<?=$contador?>[0] =<?=$dbdatos1->suma?>;
lll_<?=$contador?>[1] =<?=$dbdatos1->cod_ref_mae?> ;
lll_<?=$contador?>[2] ='<?=$dbdatos1->cod_alm_mae?>' ;
if (lll_<?=$contador?>[2]==alamcen && lll_<?=$contador?>[1]==referencia) {
	document.getElementById('cant_almacen').value=lll_<?=$contador?>[0];
	aux=1;
}
<? $contador++; } ?>

if (aux==0)
	document.getElementById('cant_almacen').value=0;


}
</script>

<script language="javascript">
function cargar(op,objeto,buscar){
var aux=0;
var combo=document.getElementById(objeto);

if (buscar==1 ) 
	combo.length = 0
else 
	op=document.getElementById('tipo').value;
x = 0;
<?
$sql =" select cod_ref,cod_int_ref,des_ref, ser_ref , act_ref, max_ref, min_ref ,
	round((SELECT MAX(cos_mae )
	FROM maestro_movimiento  
	WHERE cod_tip_mae=2  AND cod_ref_mae=cod_ref ))AS costo  from referencia ";		
$dbdatos1= new  Database();
$dbdatos1->query($sql);
$contador=0;
?>
<? while($dbdatos1->next_row()) { ?>
subcat<?=$contador?> = new Array();
subcat<?=$contador?>[x,0] =<?=$dbdatos1->cod_ref?>;
subcat<?=$contador?>[x,1] ='<?=$dbdatos1->cod_int_ref?>' ;
subcat<?=$contador?>[x,2] ='<?=$dbdatos1->des_ref?>' ;
subcat<?=$contador?>[x,3] ='<?=$dbdatos1->ser_ref?>' ;
subcat<?=$contador?>[x,4] ='<?=$dbdatos1->act_ref?>' ;
subcat<?=$contador?>[x,5] ='<?=$dbdatos1->max_ref?>' ;
subcat<?=$contador?>[x,6] ='<?=$dbdatos1->min_ref?>' ;
subcat<?=$contador?>[x,7] ='<? if ($dbdatos1->costo=="" || $dbdatos1->costo==0) echo 0; else echo $dbdatos1->costo ;?> ' ;

if(combo.value==subcat<?=$contador?>[x,0]) // PARA ENCONTRAR LOS MAXIMOS, MINIMOS Y CANTIDAD ACTUAL
{
	document.getElementById('cant_act').value=subcat<?=$contador?>[x,4];
	document.getElementById('max').value=subcat<?=$contador?>[x,5];
	document.getElementById('min').value=subcat<?=$contador?>[x,6];
	document.getElementById('costo_prom').value=subcat<?=$contador?>[x,7];
}

if (buscar==0  ) {
	if(subcat<?=$contador?>[x,3]=='1' && document.getElementById(objeto).value==subcat<?=$contador?>[x,0] ) {
		document.getElementById('serial').value=document.getElementById(objeto).value;
		document.getElementById('cant_act').value=subcat<?=$contador?>[x,4];
		document.getElementById('max').value=subcat<?=$contador?>[x,5];
		document.getElementById('min').value=subcat<?=$contador?>[x,6];
		document.getElementById('costo_prom').value=subcat<?=$contador?>[x,7];
		aux=1;
	}
}
else {
		document.getElementById('serial').value=0;
		var option<?=$contador?> = new Option(subcat<?=$contador?>[x,parseInt(op)],subcat<?=$contador?>[x,0]);
		combo.options[<?=$contador?>]=option<?=$contador?>;
}
<? $contador++; } ?>
document.getElementById('tipo').value=op

if(aux==0){
	document.getElementById('serial').value=0;
}
} 

function antes_guardar_serial()
{
guardar_serial();

}
</script>

<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_salida.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_salida.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_salida.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>
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
    <td class="textotabla01">COMPRAS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="81" class="textotabla1">Fecha:</td>
        <td colspan="2">
          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_sal?>" />
          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td width="13" class="textorojo">*</td>
        <td width="99" class="textotabla1">Motivo:</td>
        <td width="240">
          <input type="text" name="motivo" class="textfield02" value="<?=$dbdatos->mot_sal?>" />       </td>
        </tr>
      
       <tr>
         <td class="textotabla1">Autoriza:</td>
         <td colspan="2"><input type="text" name="autoriza"  class="textfield02" value="<?=$dbdatos->aut_sal?>"/> </td>
         <td></td>
         <td class="textotabla1">Almacen::</td>
         <td><?  combo_almacen("almacen","cod_alm","nom_alm",$dbdatos->cod_alm_sal,$global[0]); ?>
           <span class="textorojo">
           <input name="cant_almacen" id="cant_almacen" type="hidden" />
           </span></td>
       </tr>
       <tr>
        <td class="textotabla1">Reintegra:</td>
   		<td class="textotabla1">

		
		<? if( $codigo!=0) { 
			if ($dbdatos->op_reint_sal=="si" ){ ?>
			Si <input name="reintegra" type="radio" value="si" checked="checked"/> 
			No <input name="reintegra" type="radio" value="no"   />		
			<? } 
			if ($dbdatos->op_reint_sal=="no" ){ ?>
			Si <input name="reintegra" type="radio" value="si" /> 
			No <input name="reintegra" type="radio" value="no" checked="checked"  />		
			<? } ?>
		<?  } 
		else { 	?>
			Si <input name="reintegra" type="radio" value="si" /> 
			No <input name="reintegra" type="radio" value="no" checked="checked"  />		
		<? } ?>
		</td>
        <td class="textotabla1">
		<? if( $codigo > 0 && $dbdatos->op_reint_sal=="si") {
			if( $codigo!="" && $dbdatos->reint_sal==1 ) { ?>
			<input name="reintegrado" type="checkbox" value="checkbox" checked="checked" /> reintegrado
		<? } else {?>
			<input name="reintegrado" type="checkbox" value="checkbox" />   reintegrado
		  <? } }?>
		  </td>
        <td>&nbsp;</td>
        <td class="textotabla1">Observaicones:</td>
       		<td>
          <textarea name="observaciones" cols="35" rows="2" class="textfield02"><?=$dbdatos->obs_sal?></textarea>			</td>
        </tr>
	   
	   <tr>
        <td colspan="6" class="textotabla1" >
		<table  width="85%" border="1">
          <tr>
            <td colspan="5"  class="textotabla1"><div align="center" >Codigo
              <input name="radiobutton" id="op1" type="radio" value="1"  onclick="cargar('1','referencia','1')"/>
              Nombre
              <input name="radiobutton"  id="op2" type="radio" value="2" checked="checked"   onclick="cargar('2','referencia','1')"/>
              <input type="hidden" name="textfield" id="serial" />
              <input type="hidden" name="textfield2" id="tipo" />
            </div></td>
            </tr>
          <tr>
            <td width="30%"  class="ctablasup">Referencia:</td>
            <td width="28%"  class="ctablasup">Cantidad:  </td>
			<td width="28%"  class="ctablasup">Costo:  </td>
            <td width="28%"  class="ctablasup">Total:     </td>
			<td width="14%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr>
            <td> <? combo_ref("referencia","referencia","cod_ref","des_ref",""); ?></td>
            <td align="center"><input name="cantidad" id="cantidad" type="text" class="textfield01" onChange="validaValue(this);" onKeyPress=" return validaFloat(this)"/>
			<input name="cant_act" id="cant_act" type="hidden"/>
			<input name="max" id="max" type="hidden"  />
			<input name="min" id="min" type="hidden" />	
			<input name="costo_prom" id="costo_prom" type="hidden" />
			</td>
            <td align="center"> <input name="costo" id="costo" type="text" class="textfield01" readonly="1"  onchange="validaValue(this);" onKeyPress=" return validaFloat(this)"/></td>
			 <td align="center"> <input name="total" id="total" type="text" class="textfield01" readonly="1" onChange="validaValue(this);" onKeyPress=" return validaFloat(this)"/></td>
			<td align="center"> <input type='button'  class='botones' value='  +  '  onclick="adicion()">			</td>
          </tr>
		  </table>
		  <table border="1" width="87%" >
			  <tr id="filaDoc_0" >
			   <td width='39%'> </td>
			  <td width='17%'> </td>
			  <td width='17%'> </td>
			  <td width='17%'> </td>
			  <td width='18%'> </td>
			  </tr>
	  		  <?  if ($codigo!="") $aa=buscar_detalles($codigo); ?>
			  </table>		  </td>
		 </tr>
	  <tr> 
		  <td colspan="6" >		  </td>
		  </tr>
    </table>
<tr>
  <tr>
    <td><div align="center"><img src="imagenes/spacer.gif"  width="624" height="4" /></div></td>
  </tr>
  <tr>
    <td>
	<img src="imagenes/lineasup2.gif"  width="100%" height="4" />
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
       <input type="button" name="Submit" value="Guardar"  onclick="antes_guardar_serial()"/>  
	    <input type="button" name="Submit" value="Cancelar"  onclick="limpiar()" id="cancelar" />  
       <input type="hidden" name="textfield32"  id="catidad_seriales" value="0"/>
     </div></td>
   </tr>
</table>
</div>
</body>
</html>